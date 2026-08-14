<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use App\Models\SalaryStructure;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * Payroll Dashboard
     */
    public function index()
    {
        $totalEmployees = Employee::where('is_active', true)->count();
        $totalSalaries = Salary::count();
        $totalPaid = Salary::where('status', 'paid')->sum('net_salary');
        $pendingSalaries = Salary::where('status', 'generated')->count();

        $recentSalaries = Salary::with('employee')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('payroll.index', compact(
            'totalEmployees',
            'totalSalaries',
            'totalPaid',
            'pendingSalaries',
            'recentSalaries'
        ));
    }

    /**
     * Salary Structure Management
     */
    public function salaryStructure(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $structures = SalaryStructure::with('employee')
            ->when($employeeId, function($query) use ($employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $employees = Employee::where('is_active', true)->get();

        return view('payroll.salary-structure', compact('structures', 'employees', 'employeeId'));
    }

    /**
     * Create Salary Structure
     */
    public function createStructure(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'basic_salary' => 'required|numeric|min:0',
            'house_rent' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'conveyance' => 'nullable|numeric|min:0',
            'other_allowance' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'loan_deduction' => 'nullable|numeric|min:0',
            'advance_deduction' => 'nullable|numeric|min:0',
            'other_deduction' => 'nullable|numeric|min:0',
            'effective_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $employee = Employee::find($request->employee_id);

        // Deactivate previous structures
        SalaryStructure::where('employee_id', $request->employee_id)
            ->where('is_active', true)
            ->update(['is_active' => false, 'end_date' => Carbon::parse($request->effective_date)->subDay()]);

        $grossSalary = $request->basic_salary + ($request->house_rent ?? 0) + 
                       ($request->medical_allowance ?? 0) + ($request->conveyance ?? 0) + 
                       ($request->other_allowance ?? 0) + ($request->bonus ?? 0);

        $netSalary = $grossSalary - (($request->tax_deduction ?? 0) + ($request->loan_deduction ?? 0) + 
                     ($request->advance_deduction ?? 0) + ($request->other_deduction ?? 0));

        SalaryStructure::create([
            'employee_id' => $request->employee_id,
            'basic_salary' => $request->basic_salary,
            'house_rent' => $request->house_rent ?? 0,
            'medical_allowance' => $request->medical_allowance ?? 0,
            'conveyance' => $request->conveyance ?? 0,
            'other_allowance' => $request->other_allowance ?? 0,
            'bonus' => $request->bonus ?? 0,
            'tax_deduction' => $request->tax_deduction ?? 0,
            'loan_deduction' => $request->loan_deduction ?? 0,
            'advance_deduction' => $request->advance_deduction ?? 0,
            'other_deduction' => $request->other_deduction ?? 0,
            'gross_salary' => $grossSalary,
            'net_salary' => $netSalary,
            'effective_date' => $request->effective_date,
            'is_active' => true,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('payroll.structure')
            ->with('success', 'Salary structure created successfully!');
    }

    /**
     * Generate Salary
     */
    public function generate(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $employees = Employee::where('is_active', true)->get();
        $generatedCount = 0;

        foreach ($employees as $employee) {
            // Check if salary already generated for this month
            $existing = Salary::where('employee_id', $employee->id)
                ->where('salary_month', $month)
                ->where('salary_year', $year)
                ->first();

            if ($existing) {
                continue;
            }

            // Get salary structure
            $structure = SalaryStructure::where('employee_id', $employee->id)
                ->where('is_active', true)
                ->first();

            if (!$structure) {
                continue;
            }

            // Get attendance for the month
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $totalPresent = $attendances->where('status', 'present')->count();
            $totalAbsent = $attendances->where('status', 'absent')->count();
            $totalLate = $attendances->where('status', 'late')->count();
            $totalLeave = $attendances->where('status', 'leave')->count();
            $totalOvertime = $attendances->sum('overtime_hours');

            // Calculate overtime amount (if any)
            $overtimeRate = ($structure->basic_salary / 30) / 8; // Per hour rate
            $overtimeAmount = $totalOvertime * $overtimeRate;

            // Calculate salary
            $basicSalary = $structure->basic_salary;
            $houseRent = $structure->house_rent;
            $medicalAllowance = $structure->medical_allowance;
            $conveyance = $structure->conveyance;
            $otherAllowance = $structure->other_allowance;
            $bonus = $structure->bonus;

            $grossSalary = $basicSalary + $houseRent + $medicalAllowance + 
                          $conveyance + $otherAllowance + $bonus + $overtimeAmount;

            $netSalary = $grossSalary - ($structure->tax_deduction + $structure->loan_deduction + 
                        $structure->advance_deduction + $structure->other_deduction);

            Salary::create([
                'employee_id' => $employee->id,
                'salary_structure_id' => $structure->id,
                'salary_month' => $month,
                'salary_year' => $year,
                'basic_salary' => $basicSalary,
                'house_rent' => $houseRent,
                'medical_allowance' => $medicalAllowance,
                'conveyance' => $conveyance,
                'other_allowance' => $otherAllowance,
                'bonus' => $bonus,
                'overtime_amount' => $overtimeAmount,
                'tax_deduction' => $structure->tax_deduction,
                'loan_deduction' => $structure->loan_deduction,
                'advance_deduction' => $structure->advance_deduction,
                'other_deduction' => $structure->other_deduction,
                'total_present' => $totalPresent,
                'total_absent' => $totalAbsent,
                'total_late' => $totalLate,
                'total_leave' => $totalLeave,
                'total_overtime_hours' => $totalOvertime,
                'gross_salary' => $grossSalary,
                'net_salary' => $netSalary,
                'status' => 'generated',
                'generated_by' => Auth::id(),
            ]);

            $generatedCount++;
        }

        return redirect()->route('payroll.index')
            ->with('success', "{$generatedCount} salaries generated for " . date('F', mktime(0, 0, 0, $month, 1)) . " {$year}!");
    }

    /**
     * Salary Slip
     */
    public function salarySlip($id)
    {
        $salary = Salary::with(['employee', 'salaryStructure'])->findOrFail($id);
        return view('payroll.salary-slip', compact('salary'));
    }

    /**
     * Generate Salary Slip PDF
     */
    public function downloadPdf($id)
    {
        $salary = Salary::with(['employee', 'salaryStructure'])->findOrFail($id);
        
        $pdf = Pdf::loadView('payroll.salary-slip-pdf', compact('salary'));
        return $pdf->download('salary-slip-' . $salary->employee->employee_id . '-' . $salary->salary_month . '.pdf');
    }

    /**
     * Salary History
     */
    public function history(Request $request)
    {
        $employeeId = $request->get('employee_id');
        
        $salaries = Salary::with('employee')
            ->when($employeeId, function($query) use ($employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        $employees = Employee::where('is_active', true)->get();

        return view('payroll.history', compact('salaries', 'employees', 'employeeId'));
    }

    /**
     * Update Salary Status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:generated,approved,paid',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $salary = Salary::findOrFail($id);
        $salary->status = $request->status;
        
        if ($request->status == 'paid') {
            $salary->payment_date = $request->payment_date ?? now();
            $salary->payment_method = $request->payment_method;
            $salary->transaction_id = $request->transaction_id;
        }
        
        $salary->notes = $request->notes;
        $salary->save();

        return redirect()->back()->with('success', 'Salary status updated successfully!');
    }



}