<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'desc')->paginate(15);
        return view('hr.holidays.index', compact('holidays'));
    }

    public function create()
    {
        return view('hr.holidays.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date',
            'type' => 'required|in:public,company,religious',
            'description' => 'nullable|string',
            'is_paid' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_paid'] = $request->has('is_paid') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Holiday::create($validated);

        return redirect()->route('hr.holidays.index')->with('success', 'Holiday created successfully!');
    }

    public function edit(Holiday $holiday)
    {
        return view('hr.holidays.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date,' . $holiday->id,
            'type' => 'required|in:public,company,religious',
            'description' => 'nullable|string',
            'is_paid' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_paid'] = $request->has('is_paid') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $holiday->update($validated);

        return redirect()->route('hr.holidays.index')->with('success', 'Holiday updated successfully!');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('hr.holidays.index')->with('success', 'Holiday deleted successfully!');
    }

    public function toggleStatus(Holiday $holiday)
    {
        $holiday->is_active = !$holiday->is_active;
        $holiday->save();

        $status = $holiday->is_active ? 'activated' : 'deactivated';
        return redirect()->route('hr.holidays.index')->with('success', "Holiday {$status} successfully!");
    }
}