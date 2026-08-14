@extends('layouts.master')

@section('title', 'Payroll Dashboard - Natural Vertex ERP')
@section('page-title', 'Payroll Dashboard')

@section('content')
<style>
.payroll-card { background: #fff; border: 1px solid #e8eaed; }
.payroll-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.payroll-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.payroll-card-title i { color: #6c5ce7; margin-right: 8px; }
.payroll-card-body { padding: 20px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
.stat-box { text-align: center; padding: 16px; border: 1px solid #e8eaed; transition: all 0.2s; }
.stat-box:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.stat-number { font-size: 28px; font-weight: 700; color: #1a1a2e; display: block; }
.stat-label { font-size: 12px; color: #6b6b80; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-success-custom { padding: 8px 16px; background: #10b981; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-success-custom:hover { background: #059669; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-draft { background: #6b7280; }
.status-generated { background: #3b82f6; }
.status-approved { background: #10b981; }
.status-paid { background: #8b5cf6; }
</style>

<div class="payroll-card">
    <div class="payroll-card-header">
        <h5 class="payroll-card-title">
            <i class="fas fa-wallet"></i> Payroll Dashboard
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('payroll.structure') }}" class="btn-primary-custom">
                <i class="fas fa-cog"></i> Salary Structure
            </a>
            <a href="{{ route('payroll.generate') }}" class="btn-success-custom">
                <i class="fas fa-plus"></i> Generate Salary
            </a>
        </div>
    </div>

    <div class="payroll-card-body">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-number">{{ $totalEmployees }}</span>
                <span class="stat-label">Total Employees</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalSalaries }}</span>
                <span class="stat-label">Total Salaries</span>
            </div>
            <div class="stat-box" style="border-color:#10b981;">
                <span class="stat-number" style="color:#10b981;">৳ {{ number_format($totalPaid, 2) }}</span>
                <span class="stat-label">Total Paid</span>
            </div>
            <div class="stat-box" style="border-color:#f59e0b;">
                <span class="stat-number" style="color:#f59e0b;">{{ $pendingSalaries }}</span>
                <span class="stat-label">Pending Approval</span>
            </div>
        </div>

        <!-- Recent Salaries -->
        <h6 style="font-size:13px; font-weight:600; margin-bottom:12px;">
            <i class="fas fa-history" style="color:#6c5ce7;"></i> Recent Salaries
        </h6>
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Gross Salary</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSalaries as $salary)
                        <tr>
                            <td>{{ $salary->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ $salary->month_year }}</td>
                            <td>৳ {{ number_format($salary->gross_salary, 2) }}</td>
                            <td>৳ {{ number_format($salary->net_salary, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ $salary->status }}">
                                    {{ $salary->status_label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('payroll.slip', $salary->id) }}" class="btn-primary-custom" style="padding:4px 10px; font-size:11px;">
                                    <i class="fas fa-file-invoice"></i> Slip
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-wallet" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No salaries found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection