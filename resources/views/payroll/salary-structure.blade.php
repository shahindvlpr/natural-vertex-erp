@extends('layouts.master')

@section('title', 'Salary Structure - Natural Vertex ERP')
@section('page-title', 'Salary Structure')

@section('content')
<style>
.payroll-card { background: #fff; border: 1px solid #e8eaed; }
.payroll-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.payroll-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.payroll-card-title i { color: #6c5ce7; margin-right: 8px; }
.payroll-card-body { padding: 20px; }
.form-group { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 4px; }
.form-label .required { color: #ef4444; }
.form-control { width: 100%; padding: 9px 14px; font-size: 13px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; transition: all 0.25s ease; }
.form-control:focus { outline: none; border-color: #6c5ce7; box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06); }
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b80' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-save { padding: 10px 28px; background: linear-gradient(135deg, #6c5ce7, #4a3db8); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3); }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.badge-active { display: inline-block; padding: 2px 12px; background: #10b981; color: #fff; font-size: 11px; }
.badge-inactive { display: inline-block; padding: 2px 12px; background: #6b7280; color: #fff; font-size: 11px; }
.filters { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 16px; }
.row-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 768px) { .row-grid { grid-template-columns: 1fr; } .filters { flex-direction: column; align-items: stretch; } }
</style>

<div class="payroll-card">
    <div class="payroll-card-header">
        <h5 class="payroll-card-title">
            <i class="fas fa-cog"></i> Salary Structure
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <form method="GET" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <select name="employee_id" class="form-control" style="width:200px; padding:6px 12px;">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $employeeId == $emp->id ? 'selected' : '' }}>
                            {{ $emp->full_name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-search"></i> Filter
                </button>
            </form>
            <button onclick="document.getElementById('createForm').style.display='block'" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Add Structure
            </button>
        </div>
    </div>

    <div class="payroll-card-body">
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

        <!-- Create Form -->
        <div id="createForm" style="display:none; margin-bottom:24px; padding:20px; border:1px solid #e8eaed; background:#f8f9fa;">
            <h6 style="margin:0 0 16px 0; font-size:15px; font-weight:600;">
                <i class="fas fa-plus-circle" style="color:#6c5ce7;"></i> Create New Salary Structure
            </h6>
            <form action="{{ route('payroll.structure.create') }}" method="POST">
                @csrf

                <div class="row-grid">
                    <div class="form-group">
                        <label class="form-label">Employee <span class="required">*</span></label>
                        <select name="employee_id" class="form-control" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Effective Date <span class="required">*</span></label>
                        <input type="date" name="effective_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Basic Salary <span class="required">*</span></label>
                        <input type="number" step="0.01" name="basic_salary" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">House Rent</label>
                        <input type="number" step="0.01" name="house_rent" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Medical Allowance</label>
                        <input type="number" step="0.01" name="medical_allowance" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Conveyance</label>
                        <input type="number" step="0.01" name="conveyance" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Other Allowance</label>
                        <input type="number" step="0.01" name="other_allowance" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bonus</label>
                        <input type="number" step="0.01" name="bonus" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tax Deduction</label>
                        <input type="number" step="0.01" name="tax_deduction" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Loan Deduction</label>
                        <input type="number" step="0.01" name="loan_deduction" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Advance Deduction</label>
                        <input type="number" step="0.01" name="advance_deduction" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Other Deduction</label>
                        <input type="number" step="0.01" name="other_deduction" class="form-control" placeholder="0.00">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="2"></textarea>
                </div>

                <div style="display:flex; gap:12px; margin-top:12px;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Create Structure
                    </button>
                    <button type="button" onclick="document.getElementById('createForm').style.display='none'" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Basic</th>
                        <th>House Rent</th>
                        <th>Medical</th>
                        <th>Gross</th>
                        <th>Net</th>
                        <th>Status</th>
                        <th>Effective</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($structures as $structure)
                        <tr>
                            <td>
                                <strong>{{ $structure->employee->full_name ?? 'N/A' }}</strong>
                                <div style="font-size:11px; color:#6b6b80;">{{ $structure->employee->employee_id ?? '' }}</div>
                            </td>
                            <td>৳ {{ number_format($structure->basic_salary, 2) }}</td>
                            <td>৳ {{ number_format($structure->house_rent, 2) }}</td>
                            <td>৳ {{ number_format($structure->medical_allowance, 2) }}</td>
                            <td><strong>৳ {{ number_format($structure->gross_salary, 2) }}</strong></td>
                            <td><strong style="color:#6c5ce7;">৳ {{ number_format($structure->net_salary, 2) }}</strong></td>
                            <td>
                                @if($structure->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td style="font-size:12px; color:#6b6b80;">{{ $structure->effective_date->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-cog" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No salary structures found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $structures->appends(['employee_id' => $employeeId])->links() }}
        </div>
    </div>
</div>
@endsection