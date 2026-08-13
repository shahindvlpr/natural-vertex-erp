@extends('layouts.master')

@section('title', 'Monthly Attendance Report - Natural Vertex ERP')
@section('page-title', 'Monthly Attendance Report')

@section('content')
<style>
.attendance-card { background: #fff; border: 1px solid #e8eaed; }
.attendance-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.attendance-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.attendance-card-title i { color: #6c5ce7; margin-right: 8px; }
.attendance-card-body { padding: 20px; }
.report-table { width: 100%; border-collapse: collapse; }
.report-table th { padding: 8px 10px; text-align: center; font-size: 11px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border: 1px solid #e8eaed; }
.report-table td { padding: 8px 10px; text-align: center; font-size: 12px; border: 1px solid #e8eaed; }
.report-table tr:hover td { background: #f8f9fa; }
.employee-cell { text-align: left; font-weight: 500; }
.employee-cell .avatar { width: 24px; height: 24px; border-radius: 50%; object-fit: cover; margin-right: 6px; }
.attendance-summary { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; padding: 16px; background: #f8f9fa; border: 1px solid #e8eaed; }
.summary-item { text-align: center; padding: 8px 16px; }
.summary-item .number { font-size: 20px; font-weight: 700; display: block; }
.summary-item .label { font-size: 11px; color: #6b6b80; }
.summary-item.present .number { color: #10b981; }
.summary-item.absent .number { color: #ef4444; }
.summary-item.late .number { color: #f59e0b; }
.summary-item.leave .number { color: #3b82f6; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; }
</style>

<div class="attendance-card">
    <div class="attendance-card-header">
        <h5 class="attendance-card-title">
            <i class="fas fa-file-alt"></i> Monthly Attendance Report
        </h5>
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <form method="GET" action="{{ route('attendance.report') }}" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <select name="month" style="padding:6px 12px; border:1px solid #e8eaed; font-size:13px;">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
                <select name="year" style="padding:6px 12px; border:1px solid #e8eaed; font-size:13px;">
                    @for($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <select name="employee_id" style="padding:6px 12px; border:1px solid #e8eaed; font-size:13px;">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $emp->id == $employeeId ? 'selected' : '' }}>
                            {{ $emp->full_name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary-custom" style="padding:6px 16px;">
                    <i class="fas fa-search"></i> Generate
                </button>
                <a href="{{ route('attendance.report') }}" class="btn-primary-custom" style="padding:6px 16px; background:#e8eaed; color:#4a4a5a;">
                    <i class="fas fa-times"></i> Clear
                </a>
            </form>
        </div>
    </div>

    <div class="attendance-card-body">
        <!-- Summary -->
        @php
            $totalPresent = 0; $totalAbsent = 0; $totalLate = 0; $totalLeave = 0; $totalEmployees = count($reportData);
            foreach($reportData as $data) {
                $totalPresent += $data['summary']['present'];
                $totalAbsent += $data['summary']['absent'];
                $totalLate += $data['summary']['late'];
                $totalLeave += $data['summary']['leave'];
            }
        @endphp

        <div class="attendance-summary">
            <div class="summary-item present">
                <span class="number">{{ $totalPresent }}</span>
                <span class="label">Present</span>
            </div>
            <div class="summary-item absent">
                <span class="number">{{ $totalAbsent }}</span>
                <span class="label">Absent</span>
            </div>
            <div class="summary-item late">
                <span class="number">{{ $totalLate }}</span>
                <span class="label">Late</span>
            </div>
            <div class="summary-item leave">
                <span class="number">{{ $totalLeave }}</span>
                <span class="label">On Leave</span>
            </div>
            <div class="summary-item" style="border-left:1px solid #e8eaed; padding-left:16px;">
                <span class="number" style="color:#6c5ce7;">{{ $totalEmployees }}</span>
                <span class="label">Total Employees</span>
            </div>
        </div>

        <!-- Report Table -->
        <div style="overflow-x:auto; max-height:500px; overflow-y:auto;">
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="min-width:180px; text-align:left;">Employee</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Late</th>
                        <th>Early Exit</th>
                        <th>Leave</th>
                        <th>Holiday</th>
                        <th>Total Hours</th>
                        <th>OT Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $data)
                        @php
                            $summary = $data['summary'];
                            $employee = $data['employee'];
                        @endphp
                        <tr>
                            <td class="employee-cell">
                                <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}" class="avatar">
                                {{ $employee->full_name }}
                            </td>
                            <td>{{ $summary['present'] }}</td>
                            <td>{{ $summary['absent'] }}</td>
                            <td>{{ $summary['late'] }}</td>
                            <td>{{ $summary['early_exit'] }}</td>
                            <td>{{ $summary['leave'] }}</td>
                            <td>{{ $summary['holiday'] }}</td>
                            <td>{{ number_format($summary['total_hours'], 2) }}h</td>
                            <td>{{ number_format($summary['overtime_hours'], 2) }}h</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-file-alt" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No data found for the selected period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection