<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'salary_structure_id',
        'salary_month',
        'salary_year',
        'basic_salary',
        'house_rent',
        'medical_allowance',
        'conveyance',
        'other_allowance',
        'bonus',
        'overtime_amount',
        'tax_deduction',
        'loan_deduction',
        'advance_deduction',
        'other_deduction',
        'total_present',
        'total_absent',
        'total_late',
        'total_leave',
        'total_overtime_hours',
        'gross_salary',
        'net_salary',
        'status',
        'payment_date',
        'payment_method',
        'transaction_id',
        'notes',
        'generated_by',
        'approved_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'house_rent' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'conveyance' => 'decimal:2',
        'other_allowance' => 'decimal:2',
        'bonus' => 'decimal:2',
        'overtime_amount' => 'decimal:2',
        'tax_deduction' => 'decimal:2',
        'loan_deduction' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'other_deduction' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'total_overtime_hours' => 'decimal:2',
        'total_present' => 'integer',
        'total_absent' => 'integer',
        'total_late' => 'integer',
        'total_leave' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getFormattedGrossAttribute()
    {
        return number_format($this->gross_salary, 2);
    }

    public function getFormattedNetAttribute()
    {
        return number_format($this->net_salary, 2);
    }

    public function getMonthYearAttribute()
    {
        return date('F Y', mktime(0, 0, 0, $this->salary_month, 1, $this->salary_year));
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'generated' => 'info',
            'approved' => 'success',
            'paid' => 'primary',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'generated' => 'Generated',
            'approved' => 'Approved',
            'paid' => 'Paid',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function calculateGrossSalary()
    {
        return $this->basic_salary + $this->house_rent + $this->medical_allowance + 
               $this->conveyance + $this->other_allowance + $this->bonus + $this->overtime_amount;
    }

    public function calculateNetSalary()
    {
        $gross = $this->calculateGrossSalary();
        $deductions = $this->tax_deduction + $this->loan_deduction + 
                      $this->advance_deduction + $this->other_deduction;
        return $gross - $deductions;
    }
}