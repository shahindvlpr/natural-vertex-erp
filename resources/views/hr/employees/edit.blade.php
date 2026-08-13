@extends('layouts.master')

@section('title', 'Edit Employee - Natural Vertex ERP')
@section('page-title', 'Edit Employee')

@section('content')
<style>
.form-card { background: #fff; border: 1px solid #e8eaed; max-width: 900px; margin: 0 auto; }
.form-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; }
.form-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.form-card-title i { color: #6c5ce7; margin-right: 8px; }
.form-card-body { padding: 20px; }
.form-group { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 4px; }
.form-label .required { color: #ef4444; }
.form-control { width: 100%; padding: 9px 14px; font-size: 13px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; transition: all 0.25s ease; }
.form-control:focus { outline: none; border-color: #6c5ce7; box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06); }
.form-control:disabled { background: #f8f9fc; cursor: not-allowed; }
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b80' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
textarea.form-control { resize: vertical; min-height: 60px; }
.btn-save { padding: 10px 28px; background: linear-gradient(135deg, #6c5ce7, #4a3db8); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3); }
.btn-save:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
.form-actions { display: flex; gap: 12px; padding-top: 16px; border-top: 1px solid #e8eaed; margin-top: 8px; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; padding: 10px 16px; color: #991b1b; margin-bottom: 16px; }
.alert-error i { margin-right: 8px; }
.photo-upload { display: flex; align-items: center; gap: 16px; }
.photo-preview { width: 80px; height: 80px; border-radius: 50%; border: 2px solid #e8eaed; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa; }
.photo-preview img { width: 100%; height: 100%; object-fit: cover; }
.photo-upload-btn { padding: 6px 16px; background: #e8eaed; color: #4a4a5a; border: none; font-size: 12px; cursor: pointer; transition: all 0.2s; }
.photo-upload-btn:hover { background: #d1d5db; }
.photo-remove-btn { padding: 6px 16px; background: #ef4444; color: #fff; border: none; font-size: 12px; cursor: pointer; transition: all 0.2s; }
.photo-remove-btn:hover { background: #dc2626; }
.employee-id-badge { display: inline-block; padding: 4px 12px; background: #e8eaed; color: #4a4a5a; font-size: 12px; font-weight: 600; }
.row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 768px) { .row { grid-template-columns: 1fr; } }
</style>

<div class="form-card">
    <div class="form-card-header">
        <h5 class="form-card-title">
            <i class="fas fa-user-edit"></i> Edit Employee: {{ $employee->full_name }}
        </h5>
        <span class="employee-id-badge">
            <i class="fas fa-id-badge"></i> {{ $employee->employee_id }}
        </span>
    </div>

    <div class="form-card-body">
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('hr.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column -->
                <div>
                    <!-- Personal Information -->
                    <div style="margin-bottom:20px;">
                        <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; border-bottom:1px solid #e8eaed; padding-bottom:8px; margin-bottom:12px;">
                            <i class="fas fa-user" style="color:#6c5ce7;"></i> Personal Information
                        </h6>
                        <div class="form-group">
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone <span class="required">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control" required>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div style="margin-bottom:20px;">
                        <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; border-bottom:1px solid #e8eaed; padding-bottom:8px; margin-bottom:12px;">
                            <i class="fas fa-map-marker-alt" style="color:#6c5ce7;"></i> Address Information
                        </h6>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $employee->address) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" value="{{ old('city', $employee->city) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">State</label>
                            <input type="text" name="state" value="{{ old('state', $employee->state) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" value="{{ old('zip_code', $employee->zip_code) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" value="{{ old('country', $employee->country) }}" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <!-- Employment Information -->
                    <div style="margin-bottom:20px;">
                        <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; border-bottom:1px solid #e8eaed; padding-bottom:8px; margin-bottom:12px;">
                            <i class="fas fa-briefcase" style="color:#6c5ce7;"></i> Employment Information
                        </h6>
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-control">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Designation</label>
                            <select name="designation_id" class="form-control">
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Joining Date <span class="required">*</span></label>
                            <input type="date" name="joining_date" value="{{ old('joining_date', $employee->joining_date->format('Y-m-d')) }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmation Date</label>
                            <input type="date" name="confirmation_date" value="{{ old('confirmation_date', $employee->confirmation_date ? $employee->confirmation_date->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Basic Salary</label>
                            <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="resigned" {{ old('status', $employee->status) == 'resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                                <input type="checkbox" name="is_active" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                                <span style="font-weight:600; color:#4a4a5a;">Active</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bank & ID Information -->
                    <div style="margin-bottom:20px;">
                        <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; border-bottom:1px solid #e8eaed; padding-bottom:8px; margin-bottom:12px;">
                            <i class="fas fa-credit-card" style="color:#6c5ce7;"></i> Bank & ID Information
                        </h6>
                        <div class="form-group">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bank Account</label>
                            <input type="text" name="bank_account" value="{{ old('bank_account', $employee->bank_account) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NID Number</label>
                            <input type="text" name="nid_number" value="{{ old('nid_number', $employee->nid_number) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">TIN Number</label>
                            <input type="text" name="tin_number" value="{{ old('tin_number', $employee->tin_number) }}" class="form-control">
                        </div>
                    </div>

                    <!-- Date of Birth & Gender -->
                    <div style="margin-bottom:20px;">
                        <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; border-bottom:1px solid #e8eaed; padding-bottom:8px; margin-bottom:12px;">
                            <i class="fas fa-calendar-alt" style="color:#6c5ce7;"></i> Personal Details
                        </h6>
                        <div class="form-group">
                            <label class="form-label">Date of Birth <span class="required">*</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth->format('Y-m-d')) }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender <span class="required">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Upload -->
            <div style="margin-bottom:20px; border-top:1px solid #e8eaed; padding-top:16px;">
                <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; margin-bottom:12px;">
                    <i class="fas fa-image" style="color:#6c5ce7;"></i> Photo
                </h6>
                <div class="photo-upload">
                    <div class="photo-preview" id="photoPreview">
                        @if($employee->photo)
                            <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}">
                        @else
                            <i class="fas fa-user" style="font-size:30px; color:#d1d5db;"></i>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                            <i class="fas fa-upload"></i> Change Photo
                        </button>
                        <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;">
                        @if($employee->photo)
                            <button type="button" class="photo-remove-btn" onclick="removePhoto()">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        @endif
                        <small style="display:block; font-size:11px; color:#6b6b80; margin-top:4px;">Max 2MB, JPG/PNG</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save" id="saveBtn">
                    <span id="saveText"><i class="fas fa-save"></i> Update Employee</span>
                    <span id="saveSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
                <a href="{{ route('hr.employees.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Photo Preview
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

// Remove Photo
function removePhoto() {
    if (confirm('Are you sure you want to remove the photo?')) {
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = `<i class="fas fa-user" style="font-size:30px; color:#d1d5db;"></i>`;
        // Remove photo input value
        document.getElementById('photoInput').value = '';
        
        // Add hidden input to indicate photo removal
        const form = document.querySelector('form');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_photo';
        hiddenInput.value = '1';
        form.appendChild(hiddenInput);
    }
}

// Form Submit Loading State
document.querySelector('form').addEventListener('submit', function() {
    const btn = document.getElementById('saveBtn');
    const text = document.getElementById('saveText');
    const spinner = document.getElementById('saveSpinner');
    
    btn.disabled = true;
    text.innerHTML = 'Updating...';
    spinner.classList.remove('d-none');
});
</script>
@endsection