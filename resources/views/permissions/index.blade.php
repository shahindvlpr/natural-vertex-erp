@extends('layouts.master')

@section('title', 'Permissions - Natural Vertex ERP')
@section('page-title', 'Permissions')

@section('content')
<div style="background:#fff; border:1px solid #e8eaed;">
    <div style="padding:16px 20px; border-bottom:1px solid #e8eaed; display:flex; justify-content:space-between; align-items:center;">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-key" style="color:#6c5ce7;"></i> Permissions
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('permissions.create') }}" style="padding:8px 16px; background:#6c5ce7; color:#fff; text-decoration:none; font-size:13px; font-weight:500;">
                <i class="fas fa-plus"></i> Add Permission
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
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Module</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Roles</th>
                        <th style="padding:10px 12px; text-align:center; font-size:12px; font-weight:600; color:#4a4a5a;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr style="border-bottom:1px solid #e8eaed;">
                            <td style="padding:10px 12px; font-size:13px;">#{{ $permission->id }}</td>
                            <td style="padding:10px 12px; font-size:13px; font-weight:500;">{{ $permission->name }}</td>
                            <td style="padding:10px 12px; font-size:13px; color:#6b6b80;">{{ $permission->slug }}</td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <span style="display:inline-block; padding:2px 10px; background:#e8eaed; font-size:11px;">{{ ucfirst($permission->module) }}</span>
                            </td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <span style="display:inline-block; padding:2px 10px; background:#e8eaed; font-size:12px;">
                                    {{ $permission->roles_count ?? 0 }}
                                </span>
                            </td>
                            <td style="padding:10px 12px; text-align:center; font-size:13px;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <a href="{{ route('permissions.edit', $permission->id) }}" style="padding:4px 10px; background:#3b82f6; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $permission->id }}').submit();" style="padding:4px 10px; background:#ef4444; color:#fff; text-decoration:none; font-size:12px;">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $permission->id }}" action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-key" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No permissions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $permissions->links() }}
        </div>
    </div>
</div>
@endsection