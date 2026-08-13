@extends('layouts.master')

@section('title', 'Edit Designation - Natural Vertex ERP')
@section('page-title', 'Edit Designation')

@section('content')
<style>
.form-card { background: #fff; border: 1px solid #e8eaed; max-width: 600px; margin: 0 auto; }
.form-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; }
.form-card-body { padding: 20px; }
.form-group { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 4px; }
.form-label .required { color: #ef4444; }
.form-control { width: 100%; padding: 9px 14px; font-size: 13px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; transition: all 0.25s ease; }
.form-control:focus { outline: none; border-color: #6c5ce7; box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06); }
textarea.form-control { resize: vertical; min-height: 60px; }
.btn-save { padding: 10px 28px; background: linear-gradient(135deg, #6c5ce7, #4a3db8); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3); }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
.form-actions { display: flex; gap: 12px; padding-top: 16px; border-top: 1px solid #e8eaed; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; padding: 10px 16px; color: #991b1b; margin-bottom: 16px; }
</style>

<div class="form-card">
    <div class="form-card-header">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-edit" style="color:#6c5ce7;"></i> Edit Designation: {{ $designation->name }}
        </h5>
    </div>

    <div class="form-card-body">
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('hr.designations.update', $designation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Designation Name <span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name', $designation->name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Code <span class="required">*</span></label>
                <input type="text" name="code" value="{{ old('code', $designation->code) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $designation->description) }}</textarea>
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                    <input type="checkbox" name="is_active" {{ old('is_active', $designation->is_active) ? 'checked' : '' }}>
                    <span style="font-weight:600; color:#4a4a5a;">Active</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('hr.designations.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection