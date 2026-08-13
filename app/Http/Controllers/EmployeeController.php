<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'designation'])->orderBy('id', 'desc')->paginate(15);
        return view('hr.employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        return view('hr.employees.create', compact('departments', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string|unique:employees',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'joining_date' => 'required|date',
            'confirmation_date' => 'nullable|date',
            'basic_salary' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'nid_number' => 'nullable|string|max:50',
            'tin_number' => 'nullable|string|max:50',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'status' => 'required|in:active,inactive,resigned,terminated',
            'is_active' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Generate Employee ID
        $validated['employee_id'] = 'EMP-' . str_pad(Employee::count() + 1, 5, '0', STR_PAD_LEFT);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'emp_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/employees', $filename, 'public');
            $validated['photo'] = $filename;
        }

        Employee::create($validated);

        return redirect()->route('hr.employees.index')->with('success', 'Employee created successfully!');
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        return view('hr.employees.edit', compact('employee', 'departments', 'designations'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|unique:employees,phone,' . $employee->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'joining_date' => 'required|date',
            'confirmation_date' => 'nullable|date',
            'basic_salary' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'nid_number' => 'nullable|string|max:50',
            'tin_number' => 'nullable|string|max:50',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'status' => 'required|in:active,inactive,resigned,terminated',
            'is_active' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($employee->photo) {
                Storage::disk('public')->delete('uploads/employees/' . $employee->photo);
            }
            $file = $request->file('photo');
            $filename = 'emp_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/employees', $filename, 'public');
            $validated['photo'] = $filename;
        }

        $employee->update($validated);

        return redirect()->route('hr.employees.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete('uploads/employees/' . $employee->photo);
        }
        $employee->delete();

        return redirect()->route('hr.employees.index')->with('success', 'Employee deleted successfully!');
    }

    public function toggleStatus(Employee $employee)
    {
        $employee->is_active = !$employee->is_active;
        $employee->save();

        $status = $employee->is_active ? 'activated' : 'deactivated';
        return redirect()->route('hr.employees.index')->with('success', "Employee {$status} successfully!");
    }
}