@extends('layouts.master')

@section('title', 'Attendance Dashboard - Natural Vertex ERP')
@section('page-title', 'Attendance Dashboard')

@section('content')
<style>
.attendance-card { background: #fff; border: 1px solid #e8eaed; }
.attendance-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; }
.attendance-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.attendance-card-title i { color: #6c5ce7; margin-right: 8px; }
.attendance-card-body { padding: 20px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; }
.stat-box { text-align: center; padding: 16px; border: 1px solid #e8eaed; transition: all 0.2s; }
.stat-box:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); transform: translateY(-2px); }
.stat-number { font-size: 28px; font-weight: 700; color: #1a1a2e; display: block; }
.stat-label { font-size: 12px; color: #6b6b80; }
.stat-box.present .stat-number { color: #10b981; }
.stat-box.absent .stat-number { color: #ef4444; }
.stat-box.late .stat-number { color: #f59e0b; }
.stat-box.leave .stat-number { color: #3b82f6; }
.stat-box.not-marked .stat-number { color: #6b7280; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-present { background: #10b981; }
.status-absent { background: #ef4444; }
.status-late { background: #f59e0b; }
.status-early_exit { background: #f59e0b; }
.status-leave { background: #3b82f6; }
.status-holiday { background: #8b5cf6; }
.status-not_marked { background: #6b7280; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; color: #fff; }
</style>

<div class="attendance-card">
    <div class="attendance-card-header">
        <h5 class="attendance-card-title">
            <i class="fas fa-clipboard-check"></i> Attendance Dashboard
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('attendance.daily') }}" class="btn-primary-custom">
                <i class="fas fa-calendar-day"></i> Daily Attendance
            </a>
            <a href="{{ route('attendance.report') }}" class="btn-primary-custom">
                <i class="fas fa-file-alt"></i> Monthly Report
            </a>
        </div>
    </div>

    <div class="attendance-card-body">
        <!-- Statistics -->
        <div class="stats-grid" style="margin-bottom:24px;">
            <div class="stat-box present">
                <span class="stat-number">{{ $stats['present'] ?? 0 }}</span>
                <span class="stat-label">Present</span>
            </div>
            <div class="stat-box absent">
                <span class="stat-number">{{ $stats['absent'] ?? 0 }}</span>
                <span class="stat-label">Absent</span>
            </div>
            <div class="stat-box late">
                <span class="stat-number">{{ $stats['late'] ?? 0 }}</span>
                <span class="stat-label">Late</span>
            </div>
            <div class="stat-box leave">
                <span class="stat-number">{{ $stats['on_leave'] ?? 0 }}</span>
                <span class="stat-label">On Leave</span>
            </div>
            <div class="stat-box not-marked">
                <span class="stat-number">{{ $stats['not_marked'] ?? 0 }}</span>
                <span class="stat-label">Not Marked</span>
            </div>
            <div class="stat-box" style="border-color:#6c5ce7;">
                <span class="stat-number" style="color:#6c5ce7;">{{ $stats['total_employees'] ?? 0 }}</span>
                <span class="stat-label">Total Employees</span>
            </div>
        </div>

        <!-- Recent Attendances -->
        <h6 style="font-size:13px; font-weight:600; color:#4a4a5a; margin-bottom:12px;">
            <i class="fas fa-history" style="color:#6c5ce7;"></i> Recent Activities
        </h6>
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Hours</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAttendances as $attendance)
                        <tr>
                            <td>{{ $attendance->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ $attendance->date->format('d M Y') }}</td>
                            <td>{{ $attendance->check_in ? date('h:i A', strtotime($attendance->check_in)) : '-' }}</td>
                            <td>{{ $attendance->check_out ? date('h:i A', strtotime($attendance->check_out)) : '-' }}</td>
                            <td>{{ number_format($attendance->total_hours ?? 0, 2) }}h</td>
                            <td>
                                <span class="status-badge status-{{ $attendance->status }}">
                                    {{ $attendance->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-clipboard-check" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No attendance records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection