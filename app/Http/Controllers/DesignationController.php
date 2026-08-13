<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::withCount('employees')->orderBy('id', 'desc')->paginate(15);
        return view('hr.designations.index', compact('designations'));
    }

    public function create()
    {
        return view('hr.designations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:designations',
            'code' => 'required|string|max:50|unique:designations',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        Designation::create($validated);

        return redirect()->route('hr.designations.index')->with('success', 'Designation created successfully!');
    }

    public function edit(Designation $designation)
    {
        return view('hr.designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:designations,name,' . $designation->id,
            'code' => 'required|string|max:50|unique:designations,code,' . $designation->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $designation->update($validated);

        return redirect()->route('hr.designations.index')->with('success', 'Designation updated successfully!');
    }

    public function destroy(Designation $designation)
    {
        if ($designation->employees()->count() > 0) {
            return redirect()->route('hr.designations.index')->with('error', 'Cannot delete designation with employees!');
        }

        $designation->delete();
        return redirect()->route('hr.designations.index')->with('success', 'Designation deleted successfully!');
    }

    public function toggleStatus(Designation $designation)
    {
        $designation->is_active = !$designation->is_active;
        $designation->save();

        $status = $designation->is_active ? 'activated' : 'deactivated';
        return redirect()->route('hr.designations.index')->with('success', "Designation {$status} successfully!");
    }
}