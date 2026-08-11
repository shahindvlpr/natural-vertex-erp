@extends('layouts.master')

@section('title', 'Edit Role - Natural Vertex ERP')
@section('page-title', 'Edit Role')

@section('content')
<div style="background:#fff; border:1px solid #e8eaed; max-width:800px; margin:0 auto;">
    <div style="padding:16px 20px; border-bottom:1px solid #e8eaed;">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-user-edit" style="color:#6c5ce7;"></i> Edit Role: {{ $role->name }}
        </h5>
    </div>

    <div style="padding:20px;">
        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fecaca; padding:10px 16px; color:#991b1b; margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Role Name <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required
                       style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Description
                </label>
                <textarea name="description" rows="2" style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">{{ old('description', $role->description) }}</textarea>
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Permissions
                </label>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:6px; padding:8px 0; max-height:300px; overflow-y:auto;">
                    @foreach($permissions as $permission)
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; cursor:pointer;">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                            <span style="font-size:11px;">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                    <input type="checkbox" name="is_active" {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                    <span style="font-weight:600; color:#4a4a5a;">Active</span>
                </label>
            </div>

            <div style="display:flex; gap:12px; padding-top:16px; border-top:1px solid #e8eaed;">
                <button type="submit" style="padding:10px 28px; background:linear-gradient(135deg,#6c5ce7,#4a3db8); color:#fff; border:none; font-size:14px; font-weight:600; cursor:pointer;">
                    <i class="fas fa-save"></i> Update Role
                </button>
                <a href="{{ route('roles.index') }}" style="padding:10px 20px; color:#6b6b80; text-decoration:none; font-size:14px; border:1px solid #e8eaed; background:#fff;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection