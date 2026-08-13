@extends('layouts.master')

@section('title', 'Create Shift - Natural Vertex ERP')
@section('page-title', 'Create Shift')

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
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b80' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
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
            <i class="fas fa-plus-circle" style="color:#6c5ce7;"></i> Create Shift
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

        <form action="{{ route('hr.shifts.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Shift Name <span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Start Time <span class="required">*</span></label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">End Time <span class="required">*</span></label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Break Duration (minutes)</label>
                <input type="number" name="break_duration" value="{{ old('break_duration', 0) }}" class="form-control" min="0">
            </div>

            <div class="form-group">
                <label class="form-label">Shift Type <span class="required">*</span></label>
                <select name="shift_type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="morning" {{ old('shift_type') == 'morning' ? 'selected' : '' }}>Morning</option>
                    <option value="evening" {{ old('shift_type') == 'evening' ? 'selected' : '' }}>Evening</option>
                    <option value="night" {{ old('shift_type') == 'night' ? 'selected' : '' }}>Night</option>
                    <option value="flexible" {{ old('shift_type') == 'flexible' ? 'selected' : '' }}>Flexible</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                    <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span style="font-weight:600; color:#4a4a5a;">Active</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Create
                </button>
                <a href="{{ route('hr.shifts.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection