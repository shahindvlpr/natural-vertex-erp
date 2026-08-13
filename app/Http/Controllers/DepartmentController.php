<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->orderBy('id', 'desc')->paginate(15);
        return view('hr.departments.index', compact('departments'));
    }

    public function create()
    {
        $managers = Employee::where('status', 'active')->get();
        return view('hr.departments.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'code' => 'required|string|max:50|unique:departments',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:employees,id',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        Department::create($validated);

        return redirect()->route('hr.departments.index')->with('success', 'Department created successfully!');
    }

    public function edit(Department $department)
    {
        $managers = Employee::where('status', 'active')->get();
        return view('hr.departments.edit', compact('department', 'managers'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:employees,id',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $department->update($validated);

        return redirect()->route('hr.departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->count() > 0) {
            return redirect()->route('hr.departments.index')->with('error', 'Cannot delete department with employees!');
        }

        $department->delete();
        return redirect()->route('hr.departments.index')->with('success', 'Department deleted successfully!');
    }

    public function toggleStatus(Department $department)
    {
        $department->is_active = !$department->is_active;
        $department->save();

        $status = $department->is_active ? 'activated' : 'deactivated';
        return redirect()->route('hr.departments.index')->with('success', "Department {$status} successfully!");
    }
}