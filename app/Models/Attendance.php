<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'check_in_method',
        'check_out_method',
        'total_hours',
        'overtime_hours',
        'status',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
    ];

    protected $appends = ['status_label', 'status_color'];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'present' => 'Present',
            'absent' => 'Absent',
            'late' => 'Late',
            'early_exit' => 'Early Exit',
            'leave' => 'On Leave',
            'holiday' => 'Holiday',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'present' => '#10b981',
            'absent' => '#ef4444',
            'late' => '#f59e0b',
            'early_exit' => '#f59e0b',
            'leave' => '#3b82f6',
            'holiday' => '#8b5cf6',
        ];
        return $colors[$this->status] ?? '#6b7280';
    }

    public function getCheckInTimeAttribute()
    {
        return $this->check_in ? date('h:i A', strtotime($this->check_in)) : '-';
    }

    public function getCheckOutTimeAttribute()
    {
        return $this->check_out ? date('h:i A', strtotime($this->check_out)) : '-';
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }

    public function scopeBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    // Helper Methods
    public static function getTodayStatus($employeeId)
    {
        $attendance = self::where('employee_id', $employeeId)
            ->whereDate('date', now()->toDateString())
            ->first();
        
        if (!$attendance) {
            return ['status' => 'absent', 'label' => 'Not Checked In'];
        }
        
        if ($attendance->check_in && !$attendance->check_out) {
            return ['status' => 'checked_in', 'label' => 'Checked In'];
        }
        
        if ($attendance->check_in && $attendance->check_out) {
            return ['status' => 'checked_out', 'label' => 'Checked Out'];
        }
        
        return ['status' => 'absent', 'label' => 'Absent'];
    }

    public static function calculateTotalHours($checkIn, $checkOut)
    {
        if (!$checkIn || !$checkOut) {
            return 0;
        }
        
        $start = \Carbon\Carbon::parse($checkIn);
        $end = \Carbon\Carbon::parse($checkOut);
        return $start->diffInHours($end) + $start->diffInMinutes($end) % 60 / 60;
    }

    public static function getMonthlySummary($employeeId, $month, $year)
    {
        $attendances = self::where('employee_id', $employeeId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        return [
            'total_days' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'early_exit' => $attendances->where('status', 'early_exit')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'holiday' => $attendances->where('status', 'holiday')->count(),
            'total_hours' => $attendances->sum('total_hours'),
            'overtime_hours' => $attendances->sum('overtime_hours'),
        ];
    }
}