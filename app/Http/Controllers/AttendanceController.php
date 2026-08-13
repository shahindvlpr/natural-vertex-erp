<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display attendance dashboard.
     */
    public function index()
    {
        $today = Carbon::today();
        $employees = Employee::where('is_active', true)->get();
        
        // Today's attendance summary
        $todayAttendance = Attendance::whereDate('date', $today)->get();
        
        $stats = [
            'total_employees' => $employees->count(),
            'present' => $todayAttendance->where('status', 'present')->count(),
            'absent' => $todayAttendance->where('status', 'absent')->count(),
            'late' => $todayAttendance->where('status', 'late')->count(),
            'on_leave' => $todayAttendance->where('status', 'leave')->count(),
            'not_marked' => $employees->count() - $todayAttendance->count(),
        ];

        // Recent attendances
        $recentAttendances = Attendance::with('employee')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('attendance.index', compact('stats', 'recentAttendances', 'today'));
    }

    /**
     * Daily attendance management.
     */
    public function daily(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $dateObj = Carbon::parse($date);
        
        // Get all employees with their attendance for the selected date
        $employees = Employee::where('is_active', true)->get();
        
        $attendances = [];
        foreach ($employees as $employee) {
            $attendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $date)
                ->first();
            
            $attendances[] = [
                'employee' => $employee,
                'attendance' => $attendance,
                'status' => $attendance ? $attendance->status : 'not_marked',
            ];
        }

        return view('attendance.daily', compact('attendances', 'date', 'dateObj'));
    }

    /**
     * Check-in employee.
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'method' => 'nullable|in:manual,face,fingerprint',
        ]);

        $employeeId = $request->employee_id;
        $today = Carbon::today();

        // Check if already checked in
        $existing = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            if ($existing->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee already checked in today!'
                ], 422);
            }
        }

        $now = Carbon::now();
        $checkInTime = $now->format('H:i:s');
        
        // Determine status based on check-in time
        $status = 'present';
        $company = \App\Models\Company::first();
        $shiftStart = $company ? $company->shift_start_time ?? '09:00:00' : '09:00:00';
        
        if ($now->format('H:i:s') > $shiftStart) {
            $status = 'late';
        }

        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'date' => $today,
            ],
            [
                'check_in' => $checkInTime,
                'check_in_method' => $request->method ?? 'manual',
                'status' => $status,
                'created_by' => Auth::id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful!',
            'data' => $attendance
        ]);
    }

    /**
     * Check-out employee.
     */
    public function checkOut(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'method' => 'nullable|in:manual,face,fingerprint',
        ]);

        $employeeId = $request->employee_id;
        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Employee has not checked in today!'
            ], 422);
        }

        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Employee already checked out today!'
            ], 422);
        }

        $now = Carbon::now();
        $checkOutTime = $now->format('H:i:s');
        
        // Calculate total hours
        $totalHours = Attendance::calculateTotalHours($attendance->check_in, $checkOutTime);
        
        // Calculate overtime (if any)
        $overtimeHours = 0;
        $company = \App\Models\Company::first();
        $shiftEnd = $company ? $company->shift_end_time ?? '18:00:00' : '18:00:00';
        
        if ($now->format('H:i:s') > $shiftEnd) {
            $overtimeHours = Attendance::calculateTotalHours($shiftEnd, $checkOutTime);
        }

        $attendance->update([
            'check_out' => $checkOutTime,
            'check_out_method' => $request->method ?? 'manual',
            'total_hours' => $totalHours,
            'overtime_hours' => $overtimeHours,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out successful!',
            'data' => $attendance
        ]);
    }

    /**
     * Monthly attendance report.
     */
    public function report(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        $employeeId = $request->get('employee_id');

        $employees = Employee::where('is_active', true)->get();
        
        $reportData = [];
        foreach ($employees as $employee) {
            if ($employeeId && $employee->id != $employeeId) {
                continue;
            }
            
            $summary = Attendance::getMonthlySummary($employee->id, $month, $year);
            $reportData[] = [
                'employee' => $employee,
                'summary' => $summary,
            ];
        }

        return view('attendance.report', compact('reportData', 'month', 'year', 'employees', 'employeeId'));
    }

    /**
     * Employee attendance details.
     */
    public function employeeDetails($employeeId, Request $request)
    {
        $employee = Employee::findOrFail($employeeId);
        
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        $attendances = Attendance::where('employee_id', $employeeId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        $summary = Attendance::getMonthlySummary($employeeId, $month, $year);

        return view('attendance.employee-details', compact(
            'employee', 'attendances', 'summary', 'month', 'year'
        ));
    }

    /**
     * Update attendance status manually.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'status' => 'required|in:present,absent,late,early_exit,leave,holiday',
            'remarks' => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($request->attendance_id);
        $attendance->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'Attendance status updated successfully!');
    }
}