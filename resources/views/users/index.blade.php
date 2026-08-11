@extends('layouts.master')

@section('title', 'Users - Natural Vertex ERP')
@section('page-title', 'Users')

@section('content')
<div style="background:#fff; border:1px solid #e8eaed;">
    <div style="padding:16px 20px; border-bottom:1px solid #e8eaed; display:flex; justify-content:space-between; align-items:center;">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-users" style="color:#6c5ce7;"></i> Users
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('users.create') }}" style="padding:8px 16px; background:#6c5ce7; color:#fff; text-decoration:none; font-size:13px; font-weight:500;">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
    </div>

    <div style="padding:20px;">
        @if(session('success'))
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 16px; color:#166534; margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#fef2f2; border:1px solid #fecaca; padding:10px 16px; color:#991b1b; margin-bottom:16px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Search & Filter -->
        <div style="margin-bottom:16px; display:flex; gap:10px; flex-wrap:wrap;">
            <form action="{{ route('users.index') }}" method="GET" style="display:flex; gap:8px; flex-wrap:wrap;">
                <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" 
                       style="padding:8px 14px; border:1px solid #e8eaed; font-size:13px; min-width:200px;">
                <button type="submit" style="padding:8px 16px; background:#6c5ce7; color:#fff; border:none; cursor:pointer; font-size:13px;">
                    <i class="fas fa-search"></i> Search
                </button>
                @if(request('search'))
                    <a href="{{ route('users.index') }}" style="padding:8px 16px; background:#e8eaed; color:#4a4a5a; text-decoration:none; font-size:13px;">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fa; border-bottom:2px solid #e8eaed;">
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">ID</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">User</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Email</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Roles</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Status</th>
                        <th style="padding:10px 12px; text-align:center; font-size:12px; font-weight:600; color:#4a4a5a;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom:1px solid #e8eaed;">
                            <td style="padding:10px 12px; font-size:13px;">#{{ $user->id }}</td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div style="width:32px; height:32px; background:linear-gradient(135deg,#6c5ce7,#4a3db8); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="padding:10px 12px; font-size:13px;">{{ $user->email }}</td>
                            <td style="padding:10px 12px; font-size:13px;">
                                @foreach($user->roles as $role)
                                    <span style="display:inline-block; padding:2px 10px; background:#e8eaed; font-size:11px; margin:2px;">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td style="padding:10px 12px; font-size:13px;">
                                @if($user->is_active)
                                    <span style="display:inline-block; padding:2px 12px; background:#10b981; color:#fff; font-size:11px;">Active</span>
                                @else
                                    <span style="display:inline-block; padding:2px 12px; background:#ef4444; color:#fff; font-size:11px;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding:10px 12px; text-align:center; font-size:13px;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <a href="{{ route('users.edit', $user->id) }}" style="padding:4px 10px; background:#3b82f6; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $user->id }}').submit();" style="padding:4px 10px; background:#ef4444; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('users.toggle-status', $user->id) }}" style="padding:4px 10px; background:#f59e0b; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-users" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection