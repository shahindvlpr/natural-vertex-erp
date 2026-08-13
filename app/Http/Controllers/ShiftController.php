<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::orderBy('id', 'desc')->paginate(15);
        return view('hr.shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('hr.shifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:shifts',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'break_duration' => 'nullable|integer|min:0',
            'shift_type' => 'required|in:morning,evening,night,flexible',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        Shift::create($validated);

        return redirect()->route('hr.shifts.index')->with('success', 'Shift created successfully!');
    }

    public function edit(Shift $shift)
    {
        return view('hr.shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:shifts,name,' . $shift->id,
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'break_duration' => 'nullable|integer|min:0',
            'shift_type' => 'required|in:morning,evening,night,flexible',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $shift->update($validated);

        return redirect()->route('hr.shifts.index')->with('success', 'Shift updated successfully!');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('hr.shifts.index')->with('success', 'Shift deleted successfully!');
    }

    public function toggleStatus(Shift $shift)
    {
        $shift->is_active = !$shift->is_active;
        $shift->save();

        $status = $shift->is_active ? 'activated' : 'deactivated';
        return redirect()->route('hr.shifts.index')->with('success', "Shift {$status} successfully!");
    }
}