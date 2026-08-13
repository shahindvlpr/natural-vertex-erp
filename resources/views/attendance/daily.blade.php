@extends('layouts.master')

@section('title', 'Daily Attendance - Natural Vertex ERP')
@section('page-title', 'Daily Attendance')

@section('content')
<style>
.attendance-card { background: #fff; border: 1px solid #e8eaed; }
.attendance-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.attendance-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.attendance-card-title i { color: #6c5ce7; margin-right: 8px; }
.attendance-card-body { padding: 20px; }
.attendance-table { width: 100%; border-collapse: collapse; }
.attendance-table th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; position: sticky; top: 0; }
.attendance-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; vertical-align: middle; }
.attendance-table tr:hover td { background: #f8f9fa; }
.attendance-table .employee-info { display: flex; align-items: center; gap: 8px; }
.attendance-table .avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-present { background: #10b981; }
.status-absent { background: #ef4444; }
.status-late { background: #f59e0b; }
.status-not_marked { background: #6b7280; }
.btn-checkin { padding: 4px 12px; background: #10b981; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; }
.btn-checkin:hover { background: #059669; }
.btn-checkout { padding: 4px 12px; background: #3b82f6; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; }
.btn-checkout:hover { background: #2563eb; }
.btn-disabled { padding: 4px 12px; background: #e8eaed; color: #6b6b80; border: none; font-size: 11px; cursor: not-allowed; }
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 16px; color: #166534; margin-bottom: 16px; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; padding: 10px 16px; color: #991b1b; margin-bottom: 16px; }
.alert-success i, .alert-error i { margin-right: 8px; }
</style>

<div class="attendance-card">
    <div class="attendance-card-header">
        <h5 class="attendance-card-title">
            <i class="fas fa-calendar-day"></i> Daily Attendance
        </h5>
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <form method="GET" action="{{ route('attendance.daily') }}" style="display:flex; gap:8px; align-items:center;">
                <input type="date" name="date" value="{{ $date }}" style="padding:6px 12px; border:1px solid #e8eaed; font-size:13px;">
                <button type="submit" class="btn-primary-custom" style="padding:6px 16px;">
                    <i class="fas fa-search"></i> View
                </button>
            </form>
            <span style="font-size:13px; color:#6b6b80;">
                <i class="fas fa-calendar-alt"></i> {{ $dateObj->format('l, d M Y') }}
            </span>
        </div>
    </div>

    <div class="attendance-card-body">
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

        <div style="overflow-x:auto; max-height:600px; overflow-y:auto;">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th style="width:25%;">Employee</th>
                        <th style="width:15%;">Check In</th>
                        <th style="width:15%;">Check Out</th>
                        <th style="width:10%;">Hours</th>
                        <th style="width:15%;">Status</th>
                        <th style="width:20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $item)
                        @php
                            $employee = $item['employee'];
                            $attendance = $item['attendance'];
                            $status = $item['status'];
                        @endphp
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}" class="avatar">
                                    <div>
                                        <div style="font-weight:500; font-size:13px;">{{ $employee->full_name }}</div>
                                        <div style="font-size:11px; color:#6b6b80;">{{ $employee->employee_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $attendance ? date('h:i A', strtotime($attendance->check_in)) : '-' }}</td>
                            <td>{{ $attendance && $attendance->check_out ? date('h:i A', strtotime($attendance->check_out)) : '-' }}</td>
                            <td>{{ $attendance ? number_format($attendance->total_hours ?? 0, 2) : '-' }}h</td>
                            <td>
                                @if($status == 'not_marked')
                                    <span class="status-badge status-not_marked">Not Marked</span>
                                @else
                                    <span class="status-badge status-{{ $attendance->status }}">
                                        {{ $attendance->status_label }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($status == 'not_marked' || !$attendance->check_in)
                                    <button onclick="checkIn({{ $employee->id }})" class="btn-checkin">
                                        <i class="fas fa-sign-in-alt"></i> Check In
                                    </button>
                                @elseif($attendance->check_in && !$attendance->check_out)
                                    <button onclick="checkOut({{ $employee->id }})" class="btn-checkout">
                                        <i class="fas fa-sign-out-alt"></i> Check Out
                                    </button>
                                @else
                                    <span class="btn-disabled">
                                        <i class="fas fa-check"></i> Completed
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-users" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No employees found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function checkIn(employeeId) {
    if (!confirm('Are you sure you want to check in this employee?')) return;
    
    fetch('{{ route("attendance.check-in") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ employee_id: employeeId, method: 'manual' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('An error occurred. Please try again.');
    });
}

function checkOut(employeeId) {
    if (!confirm('Are you sure you want to check out this employee?')) return;
    
    fetch('{{ route("attendance.check-out") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ employee_id: employeeId, method: 'manual' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('An error occurred. Please try again.');
    });
}
</script>
@endsection