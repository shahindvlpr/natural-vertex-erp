<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('id', 'desc')->paginate(15);
        return view('warehouse.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Warehouse::create([
            'name' => $request->name,
            'location' => $request->location,
            'manager_name' => $request->manager_name,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Warehouse created successfully!');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $warehouse->update([
            'name' => $request->name,
            'location' => $request->location,
            'manager_name' => $request->manager_name,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Warehouse updated successfully!');
    }

    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->racks()->count() > 0) {
            return redirect()->route('warehouse.index')->with('error', 'Cannot delete warehouse because it has racks assigned!');
        }
        
        $warehouse->delete();
        return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted successfully!');
    }

    public function toggleStatus(Warehouse $warehouse)
    {
        $warehouse->is_active = !$warehouse->is_active;
        $warehouse->save();

        $status = $warehouse->is_active ? 'activated' : 'deactivated';
        return redirect()->route('warehouse.index')->with('success', "Warehouse {$status} successfully!");
    }
}