<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::with('warehouse')->orderBy('id', 'desc')->paginate(15);
        return view('warehouse.racks.index', compact('racks'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        return view('warehouse.racks.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        Rack::create([
            'warehouse_id' => $request->warehouse_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('warehouse.racks.index')->with('success', 'Rack created successfully!');
    }

    public function edit(Rack $rack)
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        return view('warehouse.racks.edit', compact('rack', 'warehouses'));
    }

    public function update(Request $request, Rack $rack)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $rack->update([
            'warehouse_id' => $request->warehouse_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('warehouse.racks.index')->with('success', 'Rack updated successfully!');
    }

    public function destroy(Rack $rack)
    {
        $rack->delete();
        return redirect()->route('warehouse.racks.index')->with('success', 'Rack deleted successfully!');
    }

    public function toggleStatus(Rack $rack)
    {
        $rack->is_active = !$rack->is_active;
        $rack->save();

        $status = $rack->is_active ? 'activated' : 'deactivated';
        return redirect()->route('warehouse.racks.index')->with('success', "Rack {$status} successfully!");
    }
}