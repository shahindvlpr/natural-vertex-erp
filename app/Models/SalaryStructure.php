<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryStructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'house_rent',
        'medical_allowance',
        'conveyance',
        'other_allowance',
        'bonus',
        'tax_deduction',
        'loan_deduction',
        'advance_deduction',
        'other_deduction',
        'gross_salary',
        'net_salary',
        'effective_date',
        'end_date',
        'is_active',
        'remarks',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'basic_salary' => 'decimal:2',
        'house_rent' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'conveyance' => 'decimal:2',
        'other_allowance' => 'decimal:2',
        'bonus' => 'decimal:2',
        'tax_deduction' => 'decimal:2',
        'loan_deduction' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'other_deduction' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function calculateGrossSalary()
    {
        return $this->basic_salary + $this->house_rent + $this->medical_allowance + 
               $this->conveyance + $this->other_allowance + $this->bonus;
    }

    public function calculateNetSalary()
    {
        $gross = $this->calculateGrossSalary();
        $deductions = $this->tax_deduction + $this->loan_deduction + 
                      $this->advance_deduction + $this->other_deduction;
        return $gross - $deductions;
    }

    public function getFormattedGrossAttribute()
    {
        return number_format($this->gross_salary, 2);
    }

    public function getFormattedNetAttribute()
    {
        return number_format($this->net_salary, 2);
    }
}