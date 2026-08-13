@extends('layouts.master')

@section('title', 'Employee Details - Natural Vertex ERP')
@section('page-title', 'Employee Details')

@section('content')
<style>
.profile-card { background: #fff; border: 1px solid #e8eaed; max-width: 900px; margin: 0 auto; }
.profile-header { padding: 24px; border-bottom: 1px solid #e8eaed; display: flex; align-items: center; gap: 24px; }
.profile-avatar { width: 100px; height: 100px; border-radius: 50%; border: 3px solid #6c5ce7; overflow: hidden; flex-shrink: 0; }
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
.profile-name { font-size: 22px; font-weight: 700; color: #1a1a2e; margin: 0; }
.profile-id { font-size: 13px; color: #6b6b80; }
.profile-status { display: inline-block; padding: 2px 12px; font-size: 12px; font-weight: 500; }
.profile-status.active { background: #10b981; color: #fff; }
.profile-status.inactive { background: #ef4444; color: #fff; }
.profile-status.resigned { background: #f59e0b; color: #fff; }
.profile-status.terminated { background: #6b7280; color: #fff; }
.profile-body { padding: 24px; }
.section-title { font-size: 14px; font-weight: 600; color: #1a1a2e; border-bottom: 1px solid #e8eaed; padding-bottom: 8px; margin-bottom: 16px; }
.section-title i { color: #6c5ce7; margin-right: 8px; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.info-item { margin-bottom: 12px; }
.info-label { font-size: 11px; font-weight: 600; color: #6b6b80; text-transform: uppercase; letter-spacing: 0.3px; display: block; margin-bottom: 2px; }
.info-value { font-size: 14px; color: #1a1a2e; }
.info-value .badge { display: inline-block; padding: 2px 10px; font-size: 11px; }
.badge-department { background: #3b82f6; color: #fff; }
.badge-designation { background: #8b5cf6; color: #fff; }
.badge-gender { background: #e8eaed; color: #4a4a5a; }
.profile-actions { display: flex; gap: 12px; padding-top: 16px; border-top: 1px solid #e8eaed; margin-top: 16px; }
.btn-edit { padding: 10px 24px; background: #3b82f6; color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: none; cursor: pointer; }
.btn-edit:hover { background: #2563eb; }
.btn-back { padding: 10px 24px; background: #e8eaed; color: #4a4a5a; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: none; cursor: pointer; }
.btn-back:hover { background: #d1d5db; }
.btn-delete { padding: 10px 24px; background: #ef4444; color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: none; cursor: pointer; }
.btn-delete:hover { background: #dc2626; }
@media (max-width: 768px) {
    .profile-header { flex-direction: column; text-align: center; }
    .info-grid { grid-template-columns: 1fr; }
    .profile-actions { flex-direction: column; }
    .btn-edit, .btn-back, .btn-delete { width: 100%; text-align: center; }
}
</style>

<div class="profile-card">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}">
        </div>
        <div style="flex:1;">
            <h2 class="profile-name">{{ $employee->full_name }}</h2>
            <div class="profile-id">
                <i class="fas fa-id-badge"></i> {{ $employee->employee_id }}
            </div>
            <div style="margin-top:8px;">
                <span class="profile-status {{ $employee->status }}">
                    {{ ucfirst($employee->status) }}
                </span>
                @if($employee->is_active)
                    <span style="display:inline-block; padding:2px 12px; background:#10b981; color:#fff; font-size:11px; margin-left:8px;">
                        <i class="fas fa-check-circle"></i> Active
                    </span>
                @else
                    <span style="display:inline-block; padding:2px 12px; background:#ef4444; color:#fff; font-size:11px; margin-left:8px;">
                        <i class="fas fa-times-circle"></i> Inactive
                    </span>
                @endif
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:12px; color:#6b6b80;">
                <i class="fas fa-calendar-alt"></i> Joined: {{ $employee->joining_date->format('d M Y') }}
            </div>
            <div style="font-size:12px; color:#6b6b80; margin-top:4px;">
                <i class="fas fa-clock"></i> Age: {{ $employee->age }} years
            </div>
        </div>
    </div>

    <!-- Profile Body -->
    <div class="profile-body">
        <!-- Personal Information -->
        <div style="margin-bottom:24px;">
            <h6 class="section-title">
                <i class="fas fa-user"></i> Personal Information
            </h6>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $employee->full_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $employee->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $employee->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gender</span>
                    <span class="info-value">
                        <span class="badge badge-gender">{{ ucfirst($employee->gender) }}</span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date of Birth</span>
                    <span class="info-value">{{ $employee->date_of_birth->format('d M Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Age</span>
                    <span class="info-value">{{ $employee->age }} years</span>
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div style="margin-bottom:24px;">
            <h6 class="section-title">
                <i class="fas fa-briefcase"></i> Employment Information
            </h6>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Employee ID</span>
                    <span class="info-value">{{ $employee->employee_id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Department</span>
                    <span class="info-value">
                        <span class="badge badge-department">{{ $employee->department->name ?? 'N/A' }}</span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Designation</span>
                    <span class="info-value">
                        <span class="badge badge-designation">{{ $employee->designation->name ?? 'N/A' }}</span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Joining Date</span>
                    <span class="info-value">{{ $employee->joining_date->format('d M Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Confirmation Date</span>
                    <span class="info-value">{{ $employee->confirmation_date ? $employee->confirmation_date->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Basic Salary</span>
                    <span class="info-value">৳ {{ number_format($employee->basic_salary, 2) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="profile-status {{ $employee->status }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Active</span>
                    <span class="info-value">
                        @if($employee->is_active)
                            <span style="color:#10b981;"><i class="fas fa-check-circle"></i> Yes</span>
                        @else
                            <span style="color:#ef4444;"><i class="fas fa-times-circle"></i> No</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div style="margin-bottom:24px;">
            <h6 class="section-title">
                <i class="fas fa-map-marker-alt"></i> Address Information
            </h6>
            <div class="info-grid">
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Address</span>
                    <span class="info-value">{{ $employee->address ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">City</span>
                    <span class="info-value">{{ $employee->city ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">State</span>
                    <span class="info-value">{{ $employee->state ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Zip Code</span>
                    <span class="info-value">{{ $employee->zip_code ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Country</span>
                    <span class="info-value">{{ $employee->country ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Bank & ID Information -->
        <div style="margin-bottom:24px;">
            <h6 class="section-title">
                <i class="fas fa-credit-card"></i> Bank & ID Information
            </h6>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Bank Name</span>
                    <span class="info-value">{{ $employee->bank_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Bank Account</span>
                    <span class="info-value">{{ $employee->bank_account ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">NID Number</span>
                    <span class="info-value">{{ $employee->nid_number ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">TIN Number</span>
                    <span class="info-value">{{ $employee->tin_number ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="profile-actions">
            <a href="{{ route('hr.employees.edit', $employee->id) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Edit Employee
            </a>
            <a href="{{ route('hr.employees.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this employee?')) document.getElementById('delete-form').submit();" class="btn-delete">
                <i class="fas fa-trash"></i> Delete
            </a>
            <form id="delete-form" action="{{ route('hr.employees.destroy', $employee->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection