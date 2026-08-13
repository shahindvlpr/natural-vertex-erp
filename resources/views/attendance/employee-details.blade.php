@extends('layouts.master')

@section('title', 'Employee Attendance Details - Natural Vertex ERP')
@section('page-title', 'Employee Attendance Details')

@section('content')
<style>
.details-card { background: #fff; border: 1px solid #e8eaed; }
.details-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.details-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.details-card-title i { color: #6c5ce7; margin-right: 8px; }
.details-card-body { padding: 20px; }
.employee-profile { display: flex; align-items: center; gap: 20px; padding: 16px; background: #f8f9fa; border: 1px solid #e8eaed; margin-bottom: 20px; }
.employee-avatar { width: 64px; height: 64px; border-radius: 50%; border: 3px solid #6c5ce7; object-fit: cover; flex-shrink: 0; }
.employee-info h4 { margin: 0; font-size: 18px; font-weight: 700; color: #1a1a2e; }
.employee-info .sub { font-size: 13px; color: #6b6b80; }
.employee-info .sub i { margin-right: 4px; }
.summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 12px; margin-bottom: 20px; }
.summary-box { text-align: center; padding: 12px; border: 1px solid #e8eaed; background: #fff; }
.summary-box .number { font-size: 22px; font-weight: 700; display: block; }
.summary-box .label { font-size: 11px; color: #6b6b80; }
.summary-box.present .number { color: #10b981; }
.summary-box.absent .number { color: #ef4444; }
.summary-box.late .number { color: #f59e0b; }
.summary-box.leave .number { color: #3b82f6; }
.summary-box.hours .number { color: #6c5ce7; }
.details-table { width: 100%; border-collapse: collapse; }
.details-table th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; position: sticky; top: 0; }
.details-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.details-table tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-present { background: #10b981; }
.status-absent { background: #ef4444; }
.status-late { background: #f59e0b; }
.status-early_exit { background: #f59e0b; }
.status-leave { background: #3b82f6; }
.status-holiday { background: #8b5cf6; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-back { padding: 8px 16px; background: #e8eaed; color: #4a4a5a; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-back:hover { background: #d1d5db; }
.filters { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.filters select, .filters input { padding: 6px 12px; border: 1px solid #e8eaed; font-size: 13px; background: #fff; }
@media (max-width: 768px) {
    .employee-profile { flex-direction: column; text-align: center; }
    .summary-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>

<div class="details-card">
    <div class="details-card-header">
        <h5 class="details-card-title">
            <i class="fas fa-user-clock"></i> Attendance Details
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('attendance.report') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Report
            </a>
            <a href="{{ route('attendance.daily') }}" class="btn-primary-custom">
                <i class="fas fa-calendar-day"></i> Daily Attendance
            </a>
        </div>
    </div>

    <div class="details-card-body">
        <!-- Employee Profile -->
        <div class="employee-profile">
            <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}" class="employee-avatar">
            <div class="employee-info">
                <h4>{{ $employee->full_name }}</h4>
                <div class="sub">
                    <i class="fas fa-id-badge"></i> {{ $employee->employee_id }}
                    <span style="margin:0 8px;">|</span>
                    <i class="fas fa-building"></i> {{ $employee->department->name ?? 'N/A' }}
                    <span style="margin:0 8px;">|</span>
                    <i class="fas fa-user-tie"></i> {{ $employee->designation->name ?? 'N/A' }}
                </div>
                <div class="sub" style="margin-top:4px;">
                    <i class="fas fa-envelope"></i> {{ $employee->email }}
                    <span style="margin:0 8px;">|</span>
                    <i class="fas fa-phone"></i> {{ $employee->phone }}
                </div>
            </div>
            <div style="margin-left:auto; text-align:right;">
                <div style="font-size:13px; color:#6b6b80;">
                    <i class="fas fa-calendar-alt"></i> {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}
                </div>
                <div style="font-size:13px; color:#6b6b80; margin-top:4px;">
                    <i class="fas fa-clock"></i> Total Days: {{ $summary['total_days'] ?? 0 }}
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="summary-grid">
            <div class="summary-box present">
                <span class="number">{{ $summary['present'] ?? 0 }}</span>
                <span class="label">Present</span>
            </div>
            <div class="summary-box absent">
                <span class="number">{{ $summary['absent'] ?? 0 }}</span>
                <span class="label">Absent</span>
            </div>
            <div class="summary-box late">
                <span class="number">{{ $summary['late'] ?? 0 }}</span>
                <span class="label">Late</span>
            </div>
            <div class="summary-box leave">
                <span class="number">{{ $summary['leave'] ?? 0 }}</span>
                <span class="label">On Leave</span>
            </div>
            <div class="summary-box hours">
                <span class="number">{{ number_format($summary['total_hours'] ?? 0, 2) }}h</span>
                <span class="label">Total Hours</span>
            </div>
            <div class="summary-box hours" style="border-color:#f59e0b;">
                <span class="number" style="color:#f59e0b;">{{ number_format($summary['overtime_hours'] ?? 0, 2) }}h</span>
                <span class="label">OT Hours</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters" style="margin-bottom:16px;">
            <form method="GET" action="{{ route('attendance.employee.details', $employee->id) }}" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <select name="month" style="padding:6px 12px; border:1px solid #e8eaed; font-size:13px;">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
                <select name="year" style="padding:6px 12px; border:1px solid #e8eaed; font-size:13px;">
                    @for($y = date('Y') - 3; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn-primary-custom" style="padding:6px 16px;">
                    <i class="fas fa-search"></i> View
                </button>
                <a href="{{ route('attendance.employee.details', $employee->id) }}" class="btn-back" style="padding:6px 16px;">
                    <i class="fas fa-times"></i> Reset
                </a>
            </form>
        </div>

        <!-- Details Table -->
        <div style="overflow-x:auto; max-height:500px; overflow-y:auto;">
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Hours</th>
                        <th>OT Hours</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->date->format('d M Y') }}</td>
                            <td style="color:#6b6b80;">{{ $attendance->date->format('l') }}</td>
                            <td>{{ $attendance->check_in ? date('h:i A', strtotime($attendance->check_in)) : '-' }}</td>
                            <td>{{ $attendance->check_out ? date('h:i A', strtotime($attendance->check_out)) : '-' }}</td>
                            <td>{{ number_format($attendance->total_hours ?? 0, 2) }}h</td>
                            <td>{{ number_format($attendance->overtime_hours ?? 0, 2) }}h</td>
                            <td>
                                <span class="status-badge status-{{ $attendance->status }}">
                                    {{ $attendance->status_label }}
                                </span>
                            </td>
                            <td style="font-size:12px; color:#6b6b80;">{{ $attendance->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-clipboard-check" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No attendance records found for this period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($attendances, 'links'))
            <div style="margin-top:16px;">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
</div>
@endsection