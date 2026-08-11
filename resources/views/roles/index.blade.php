@extends('layouts.master')

@section('title', 'Roles - Natural Vertex ERP')
@section('page-title', 'Roles')

@section('content')
<div style="background:#fff; border:1px solid #e8eaed;">
    <div style="padding:16px 20px; border-bottom:1px solid #e8eaed; display:flex; justify-content:space-between; align-items:center;">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-user-tag" style="color:#6c5ce7;"></i> Roles
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('roles.create') }}" style="padding:8px 16px; background:#6c5ce7; color:#fff; text-decoration:none; font-size:13px; font-weight:500;">
                <i class="fas fa-plus"></i> Add Role
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

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fa; border-bottom:2px solid #e8eaed;">
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">ID</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Name</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Slug</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Users</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Permissions</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Status</th>
                        <th style="padding:10px 12px; text-align:center; font-size:12px; font-weight:600; color:#4a4a5a;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr style="border-bottom:1px solid #e8eaed;">
                            <td style="padding:10px 12px; font-size:13px;">#{{ $role->id }}</td>
                            <td style="padding:10px 12px; font-size:13px; font-weight:500;">{{ $role->name }}</td>
                            <td style="padding:10px 12px; font-size:13px; color:#6b6b80;">{{ $role->slug }}</td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <span style="display:inline-block; padding:2px 10px; background:#e8eaed; font-size:12px;">
                                    {{ $role->users_count ?? 0 }}
                                </span>
                            </td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <span style="display:inline-block; padding:2px 10px; background:#e8eaed; font-size:12px;">
                                    {{ $role->permissions_count ?? 0 }}
                                </span>
                            </td>
                            <td style="padding:10px 12px; font-size:13px;">
                                @if($role->is_active)
                                    <span style="display:inline-block; padding:2px 12px; background:#10b981; color:#fff; font-size:11px;">Active</span>
                                @else
                                    <span style="display:inline-block; padding:2px 12px; background:#ef4444; color:#fff; font-size:11px;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding:10px 12px; text-align:center; font-size:13px;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <a href="{{ route('roles.edit', $role->id) }}" style="padding:4px 10px; background:#3b82f6; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $role->id }}').submit();" style="padding:4px 10px; background:#ef4444; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('roles.toggle-status', $role->id) }}" style="padding:4px 10px; background:#f59e0b; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-{{ $role->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-user-tag" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No roles found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection