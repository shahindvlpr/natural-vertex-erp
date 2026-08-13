@extends('layouts.master')

@section('title', 'Create Employee - Natural Vertex ERP')
@section('page-title', 'Create Employee')

@section('content')
<style>
.form-card { background: #fff; border: 1px solid #e8eaed; max-width: 800px; margin: 0 auto; }
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
.photo-upload { display: flex; align-items: center; gap: 16px; }
.photo-preview { width: 80px; height: 80px; border-radius: 50%; border: 2px solid #e8eaed; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa; }
.photo-preview img { width: 100%; height: 100%; object-fit: cover; }
.photo-upload-btn { padding: 6px 16px; background: #e8eaed; color: #4a4a5a; border: none; font-size: 12px; cursor: pointer; transition: all 0.2s; }
.photo-upload-btn:hover { background: #d1d5db; }
</style>

<div class="form-card">
    <div class="form-card-header">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-user-plus" style="color:#6c5ce7;"></i> Create Employee
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

        <form action="{{ route('hr.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Last Name <span class="required">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Phone <span class="required">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Date of Birth <span class="required">*</span></label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Gender <span class="required">*</span></label>
                        <select name="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Designation</label>
                        <select name="designation_id" class="form-control">
                            <option value="">Select Designation</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Joining Date <span class="required">*</span></label>
                        <input type="date" name="joining_date" value="{{ old('joining_date') }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Confirmation Date</label>
                        <input type="date" name="confirmation_date" value="{{ old('confirmation_date') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Basic Salary</label>
                        <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="resigned" {{ old('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                            <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">State</label>
                        <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Zip Code</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Bank Account</label>
                        <input type="text" name="bank_account" value="{{ old('bank_account') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">NID Number</label>
                        <input type="text" name="nid_number" value="{{ old('nid_number') }}" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Photo</label>
                        <div class="photo-upload">
                            <div class="photo-preview" id="photoPreview">
                                <i class="fas fa-user" style="font-size:30px; color:#d1d5db;"></i>
                            </div>
                            <div>
                                <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                                    <i class="fas fa-upload"></i> Upload Photo
                                </button>
                                <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;">
                                <small style="display:block; font-size:11px; color:#6b6b80; margin-top:4px;">Max 2MB, JPG/PNG</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                            <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span style="font-weight:600; color:#4a4a5a;">Active</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Create
                </button>
                <a href="{{ route('hr.employees.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('photoInput').addEventListener('change', function(e) {
    const preview = document.getElementById('photoPreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Photo">`;
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endsection