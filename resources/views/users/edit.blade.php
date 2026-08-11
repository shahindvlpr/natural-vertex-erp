@extends('layouts.master')

@section('title', 'Edit User - Natural Vertex ERP')
@section('page-title', 'Edit User')

@section('content')
<div style="background:#fff; border:1px solid #e8eaed; max-width:600px; margin:0 auto;">
    <div style="padding:16px 20px; border-bottom:1px solid #e8eaed;">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-user-edit" style="color:#6c5ce7;"></i> Edit User: {{ $user->name }}
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

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Name <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Email <span style="color:#ef4444;">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Password <span style="color:#ef4444; font-size:11px; font-weight:400;">(Leave blank to keep current)</span>
                </label>
                <input type="password" name="password"
                       style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation"
                       style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Phone
                </label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       style="width:100%; padding:9px 14px; font-size:13px; border:1px solid #e8eaed; background:#fff; color:#1a1a2e;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:600; color:#4a4a5a; display:block; margin-bottom:4px;">
                    Roles
                </label>
                <div style="display:flex; flex-wrap:wrap; gap:8px; padding:8px 0;">
                    @foreach($roles as $role)
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; cursor:pointer;">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                   {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                    <input type="checkbox" name="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <span style="font-weight:600; color:#4a4a5a;">Active</span>
                </label>
            </div>

            <div style="display:flex; gap:12px; padding-top:16px; border-top:1px solid #e8eaed;">
                <button type="submit" style="padding:10px 28px; background:linear-gradient(135deg,#6c5ce7,#4a3db8); color:#fff; border:none; font-size:14px; font-weight:600; cursor:pointer;">
                    <i class="fas fa-save"></i> Update User
                </button>
                <a href="{{ route('users.index') }}" style="padding:10px 20px; color:#6b6b80; text-decoration:none; font-size:14px; border:1px solid #e8eaed; background:#fff;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection