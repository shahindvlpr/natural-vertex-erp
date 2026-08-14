@extends('layouts.master')

@section('title', 'Generate Salary - Natural Vertex ERP')
@section('page-title', 'Generate Salary')

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
.btn-generate { padding: 10px 28px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-generate:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3); }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 16px; color: #166534; margin-bottom: 16px; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; padding: 10px 16px; color: #991b1b; margin-bottom: 16px; }
.alert-success i, .alert-error i { margin-right: 8px; }
.info-box { padding: 16px; background: #f8f9fa; border: 1px solid #e8eaed; margin-bottom: 16px; }
.info-box .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.info-box .item { padding: 8px 12px; }
.info-box .label { font-size: 11px; color: #6b6b80; display: block; }
.info-box .value { font-size: 14px; font-weight: 600; color: #1a1a2e; }
@media (max-width: 768px) { .info-box .row { grid-template-columns: 1fr; } }
</style>

<div class="payroll-card">
    <div class="payroll-card-header">
        <h5 class="payroll-card-title">
            <i class="fas fa-plus-circle"></i> Generate Salary
        </h5>
        <a href="{{ route('payroll.index') }}" class="btn-cancel">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="payroll-card-body">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Info Box -->
        <div class="info-box">
            <div class="row">
                <div class="item">
                    <span class="label">Total Active Employees</span>
                    <span class="value">{{ $totalEmployees ?? 0 }}</span>
                </div>
                <div class="item">
                    <span class="label">Employees with Salary Structure</span>
                    <span class="value">{{ $hasStructure ?? 0 }}</span>
                </div>
                <div class="item">
                    <span class="label">Current Month</span>
                    <span class="value">{{ date('F Y') }}</span>
                </div>
                <div class="item">
                    <span class="label">Last Generated</span>
                    <span class="value">{{ $lastGenerated ?? 'Not yet' }}</span>
                </div>
            </div>
        </div>

        <!-- Generate Form -->
        <form action="{{ route('payroll.generate') }}" method="GET">
            @csrf

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Month <span class="required">*</span></label>
                    <select name="month" class="form-control" required>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == date('m') ? 'selected' : '' }}>
                                {{ date('F', mktime(0,0,0,$m,1)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Year <span class="required">*</span></label>
                    <select name="year" class="form-control" required>
                        @for($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div style="margin-top:16px; display:flex; gap:12px;">
                <button type="submit" class="btn-generate" onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Generating...'; this.disabled=true;">
                    <i class="fas fa-cog"></i> Generate Salary
                </button>
                <a href="{{ route('payroll.history') }}" class="btn-cancel">
                    <i class="fas fa-history"></i> View History
                </a>
            </div>
        </form>

        <!-- Warning -->
        <div style="margin-top:16px; padding:12px 16px; background:#fefce8; border:1px solid #fde68a; color:#92400e; font-size:13px;">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Note:</strong> Generating salary will create salary records for all active employees based on their salary structure and attendance for the selected month.
        </div>
    </div>
</div>
@endsection