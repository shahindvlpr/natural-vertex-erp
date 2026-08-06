{{-- resources/views/company/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Company Settings - Natural Vertex ERP')
@section('page-title', 'Company Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="settings-card">
            <div class="settings-card-header">
                <h5 class="settings-card-title">
                    <i class="fas fa-building text-primary"></i> Company Information
                </h5>
                <p class="settings-card-subtitle">Manage your company details and preferences</p>
            </div>
            <div class="settings-card-body">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert-custom alert-success">
                        <i class="fas fa-check-circle"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <form action="{{ route('company.update', $company->id) }}" method="POST" id="companyForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">Basic Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Company Name <span class="required">*</span></label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-building"></i></span>
                                                <input type="text" class="form-control" name="name" value="{{ old('name', $company->name) }}" required>
                                            </div>
                                            @error('name')
                                                <span class="error-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control" name="email" value="{{ old('email', $company->email) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Phone</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-phone"></i></span>
                                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $company->phone) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Website</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-globe"></i></span>
                                                <input type="url" class="form-control" name="website" value="{{ old('website', $company->website) }}" placeholder="https://example.com">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-map-marker-alt"></i></span>
                                                <textarea class="form-control" name="address" rows="2">{{ old('address', $company->address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax Information -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">Tax Information</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">VAT Number</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-receipt"></i></span>
                                                <input type="text" class="form-control" name="vat_number" value="{{ old('vat_number', $company->vat_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">BIN Number</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-credit-card"></i></span>
                                                <input type="text" class="form-control" name="bin_number" value="{{ old('bin_number', $company->bin_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">TIN Number</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-id-card"></i></span>
                                                <input type="text" class="form-control" name="tin_number" value="{{ old('tin_number', $company->tin_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Tax Zone</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-map-pin"></i></span>
                                                <input type="text" class="form-control" name="tax_zone" value="{{ old('tax_zone', $company->tax_zone) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Settings -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">Financial Settings</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Currency <span class="required">*</span></label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-money-bill-wave"></i></span>
                                                <select class="form-control" name="currency" required>
                                                    @foreach($currencies as $key => $value)
                                                        <option value="{{ $key }}" {{ old('currency', $company->currency) == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Currency Symbol <span class="required">*</span></label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-dollar-sign"></i></span>
                                                <input type="text" class="form-control" name="currency_symbol" value="{{ old('currency_symbol', $company->currency_symbol) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Timezone <span class="required">*</span></label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-clock"></i></span>
                                                <select class="form-control" name="timezone" required>
                                                    @foreach($timezones as $key => $value)
                                                        <option value="{{ $key }}" {{ old('timezone', $company->timezone) == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Settings -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">Invoice Settings</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Invoice Prefix</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-hashtag"></i></span>
                                                <input type="text" class="form-control" name="invoice_prefix" value="{{ old('invoice_prefix', $company->invoice_prefix) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Start Number</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-sort-numeric-up"></i></span>
                                                <input type="number" class="form-control" name="invoice_start_number" value="{{ old('invoice_start_number', $company->invoice_start_number) }}" min="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Fiscal Year</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-calendar-alt"></i></span>
                                                <input type="text" class="form-control" name="fiscal_year" value="{{ old('fiscal_year', $company->fiscal_year) }}" placeholder="2024-2025">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Invoice Footer</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fas fa-pen"></i></span>
                                                <textarea class="form-control" name="invoice_footer" rows="2">{{ old('invoice_footer', $company->invoice_footer) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">Social Links</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fab fa-facebook text-primary"></i> Facebook</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fab fa-facebook"></i></span>
                                                <input type="url" class="form-control" name="facebook" value="{{ old('facebook', $company->facebook) }}" placeholder="https://facebook.com/company">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fab fa-twitter text-info"></i> Twitter</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fab fa-twitter"></i></span>
                                                <input type="url" class="form-control" name="twitter" value="{{ old('twitter', $company->twitter) }}" placeholder="https://twitter.com/company">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fab fa-linkedin text-primary"></i> LinkedIn</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fab fa-linkedin"></i></span>
                                                <input type="url" class="form-control" name="linkedin" value="{{ old('linkedin', $company->linkedin) }}" placeholder="https://linkedin.com/company">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fab fa-youtube text-danger"></i> YouTube</label>
                                            <div class="input-group-custom">
                                                <span class="input-icon"><i class="fab fa-youtube"></i></span>
                                                <input type="url" class="form-control" name="youtube" value="{{ old('youtube', $company->youtube) }}" placeholder="https://youtube.com/company">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Logo & Images -->
                        <div class="col-lg-4">
                            <div class="settings-section">
                                <h6 class="settings-section-title">Logo & Images</h6>
                                
                                <!-- Logo -->
                                <div class="image-upload-section">
                                    <label class="form-label">Company Logo</label>
                                    <div class="image-preview" id="logoPreview">
                                        @if($company->logo)
                                            <img src="{{ asset('storage/uploads/companies/' . $company->logo) }}" alt="Logo">
                                            <button type="button" class="image-remove" onclick="deleteImage('logo')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-image"></i>
                                                <span>No logo uploaded</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="image-upload-actions">
                                        <button type="button" class="btn-upload" onclick="document.getElementById('logoInput').click()">
                                            <i class="fas fa-upload"></i> Upload Logo
                                        </button>
                                        <input type="file" id="logoInput" accept="image/*" style="display:none">
                                    </div>
                                    <small class="image-help">Recommended: 200x200px, PNG or JPG (max 2MB)</small>
                                </div>

                                <!-- Favicon -->
                                <div class="image-upload-section">
                                    <label class="form-label">Favicon</label>
                                    <div class="image-preview" id="faviconPreview">
                                        @if($company->favicon)
                                            <img src="{{ asset('storage/uploads/companies/' . $company->favicon) }}" alt="Favicon">
                                            <button type="button" class="image-remove" onclick="deleteImage('favicon')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-image"></i>
                                                <span>No favicon uploaded</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="image-upload-actions">
                                        <button type="button" class="btn-upload" onclick="document.getElementById('faviconInput').click()">
                                            <i class="fas fa-upload"></i> Upload Favicon
                                        </button>
                                        <input type="file" id="faviconInput" accept="image/*" style="display:none">
                                    </div>
                                    <small class="image-help">Recommended: 32x32px, ICO or PNG (max 512KB)</small>
                                </div>

                                <!-- Signature -->
                                <div class="image-upload-section">
                                    <label class="form-label">Signature</label>
                                    <div class="image-preview" id="signaturePreview">
                                        @if($company->signature)
                                            <img src="{{ asset('storage/uploads/companies/' . $company->signature) }}" alt="Signature">
                                            <button type="button" class="image-remove" onclick="deleteImage('signature')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-pen"></i>
                                                <span>No signature uploaded</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="image-upload-actions">
                                        <button type="button" class="btn-upload" onclick="document.getElementById('signatureInput').click()">
                                            <i class="fas fa-upload"></i> Upload Signature
                                        </button>
                                        <input type="file" id="signatureInput" accept="image/*" style="display:none">
                                    </div>
                                    <small class="image-help">Recommended: 300x100px, PNG (max 2MB)</small>
                                </div>
                            </div>

                            <!-- Maintenance Mode -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">System Status</h6>
                                <div class="form-check-custom">
                                    <label class="switch">
                                        <input type="checkbox" name="maintenance_mode" {{ old('maintenance_mode', $company->maintenance_mode) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <div class="switch-label">
                                        <span class="switch-title">Maintenance Mode</span>
                                        <span class="switch-description">Enable to put the system in maintenance mode</span>
                                    </div>
                                </div>
                                <div class="form-group mt-3" id="maintenanceMessageGroup" style="{{ old('maintenance_mode', $company->maintenance_mode) ? 'display:block' : 'display:none' }}">
                                    <label class="form-label">Maintenance Message</label>
                                    <div class="input-group-custom">
                                        <span class="input-icon"><i class="fas fa-comment"></i></span>
                                        <textarea class="form-control" name="maintenance_message" rows="2">{{ old('maintenance_message', $company->maintenance_message) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="settings-actions">
                        <button type="submit" class="btn-save" id="saveBtn">
                            <span id="saveText"><i class="fas fa-save"></i> Save Changes</span>
                            <span id="saveSpinner" class="spinner-border d-none" role="status"></span>
                        </button>
                        <a href="{{ route('dashboard.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ============================================
   SETTINGS PAGE STYLES
============================================ */
.settings-card {
    background: #fff;
    border: 1px solid #e8eaed;
}

.settings-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #e8eaed;
}

.settings-card-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
}

.settings-card-title i {
    margin-right: 8px;
}

.settings-card-subtitle {
    font-size: 13px;
    color: #6b6b80;
    margin: 4px 0 0;
}

.settings-card-body {
    padding: 24px;
}

/* ============================================
   SETTINGS SECTION
============================================ */
.settings-section {
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #e8eaed;
    background: #fafafc;
}

.settings-section-title {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e8eaed;
}

/* ============================================
   FORM ELEMENTS
============================================ */
.form-group {
    margin-bottom: 16px;
}

.form-label {
    font-size: 12px;
    font-weight: 600;
    color: #4a4a5a;
    display: block;
    margin-bottom: 4px;
}

.form-label .required {
    color: #ef4444;
}

.input-group-custom {
    position: relative;
    border: 1px solid #e8eaed;
    background: #fff;
    transition: all 0.25s ease;
}

.input-group-custom:focus-within {
    border-color: #6c5ce7;
    box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06);
}

.input-group-custom .input-icon {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8c8f9c;
    font-size: 14px;
    border-right: 1px solid #e8eaed;
    background: #f8f9fc;
}

.input-group-custom .form-control {
    width: 100%;
    padding: 10px 14px 10px 46px;
    font-size: 13px;
    border: none;
    background: transparent;
    color: #1a1a2e;
    font-family: 'Inter', sans-serif;
}

.input-group-custom .form-control:focus {
    outline: none;
    box-shadow: none;
}

.input-group-custom select.form-control {
    appearance: none;
}

.input-group-custom textarea.form-control {
    resize: vertical;
    min-height: 60px;
}

.error-text {
    font-size: 11px;
    color: #ef4444;
    margin-top: 4px;
    display: block;
}

/* ============================================
   ALERT
============================================ */
.alert-custom {
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid transparent;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-custom.alert-success {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}

.alert-custom i {
    font-size: 16px;
}

/* ============================================
   IMAGE UPLOAD
============================================ */
.image-upload-section {
    margin-bottom: 20px;
}

.image-preview {
    width: 100%;
    height: 120px;
    border: 2px dashed #e8eaed;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    background: #fafafc;
    margin-bottom: 8px;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.image-placeholder {
    text-align: center;
    color: #b0b3c0;
}

.image-placeholder i {
    font-size: 32px;
    display: block;
    margin-bottom: 4px;
}

.image-placeholder span {
    font-size: 12px;
}

.image-remove {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 28px;
    height: 28px;
    background: rgba(239, 68, 68, 0.9);
    border: none;
    color: #fff;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-remove:hover {
    background: #ef4444;
}

.image-upload-actions {
    display: flex;
    gap: 8px;
}

.btn-upload {
    padding: 6px 16px;
    background: #6c5ce7;
    color: #fff;
    border: none;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}

.btn-upload:hover {
    background: #4a3db8;
}

.image-help {
    font-size: 11px;
    color: #b0b3c0;
    display: block;
    margin-top: 4px;
}

/* ============================================
   SWITCH (Maintenance Mode)
============================================ */
.form-check-custom {
    display: flex;
    align-items: center;
    gap: 12px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #d1d5db;
    transition: .3s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background: white;
    transition: .3s;
}

.switch input:checked + .slider {
    background: #6c5ce7;
}

.switch input:checked + .slider:before {
    transform: translateX(20px);
}

.switch-label {
    flex: 1;
}

.switch-title {
    font-size: 13px;
    font-weight: 600;
    color: #1a1a2e;
    display: block;
}

.switch-description {
    font-size: 11px;
    color: #6b6b80;
}

/* ============================================
   ACTIONS
============================================ */
.settings-actions {
    padding-top: 20px;
    border-top: 1px solid #e8eaed;
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-save {
    padding: 10px 28px;
    background: linear-gradient(135deg, #6c5ce7, #4a3db8);
    color: #fff;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3);
}

.btn-save:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-save .spinner-border {
    width: 16px;
    height: 16px;
    border-width: 2px;
}

.btn-cancel {
    padding: 10px 20px;
    color: #6b6b80;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    border: 1px solid #e8eaed;
    background: #fff;
}

.btn-cancel:hover {
    background: #f8f9fc;
    color: #1a1a2e;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 992px) {
    .settings-card-header {
        padding: 16px 20px;
    }
    
    .settings-card-body {
        padding: 16px 20px;
    }
    
    .settings-section {
        padding: 16px;
    }
}

@media (max-width: 576px) {
    .settings-card-header {
        padding: 12px 16px;
    }
    
    .settings-card-body {
        padding: 12px 16px;
    }
    
    .settings-section {
        padding: 12px;
    }
    
    .settings-actions {
        flex-direction: column;
    }
    
    .btn-save,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // IMAGE UPLOAD
    // ============================================
    function setupImageUpload(inputId, previewId, uploadUrl, fieldName) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const formData = new FormData();
                formData.append(fieldName, this.files[0]);
                
                // Show loading
                preview.innerHTML = '<div class="image-placeholder"><i class="fas fa-spinner fa-spin"></i><span>Uploading...</span></div>';
                
                fetch(uploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated image
                        location.reload();
                    } else {
                        alert('Upload failed: ' + data.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    alert('Upload failed');
                    location.reload();
                });
            }
        });
    }

    // Setup uploads
    setupImageUpload('logoInput', 'logoPreview', '{{ route("company.logo.upload") }}', 'logo');
    setupImageUpload('faviconInput', 'faviconPreview', '{{ route("company.favicon.upload") }}', 'favicon');
    setupImageUpload('signatureInput', 'signaturePreview', '{{ route("company.signature.upload") }}', 'signature');

    // ============================================
    // DELETE IMAGE
    // ============================================
    window.deleteImage = function(type) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        const urls = {
            'logo': '{{ route("company.logo.delete") }}',
            'favicon': '{{ route("company.logo.delete") }}',
            'signature': '{{ route("company.logo.delete") }}'
        };

        fetch(urls[type], {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    };

    // ============================================
    // MAINTENANCE MODE TOGGLE
    // ============================================
    const maintenanceCheckbox = document.querySelector('input[name="maintenance_mode"]');
    const maintenanceMessage = document.getElementById('maintenanceMessageGroup');
    
    maintenanceCheckbox.addEventListener('change', function() {
        if (this.checked) {
            maintenanceMessage.style.display = 'block';
        } else {
            maintenanceMessage.style.display = 'none';
        }
    });

    // ============================================
    // FORM SUBMIT
    // ============================================
    const form = document.getElementById('companyForm');
    const saveBtn = document.getElementById('saveBtn');
    const saveText = document.getElementById('saveText');
    const saveSpinner = document.getElementById('saveSpinner');

    form.addEventListener('submit', function() {
        saveBtn.disabled = true;
        saveText.innerHTML = 'Saving...';
        saveSpinner.classList.remove('d-none');
    });
});
</script>
@endpush