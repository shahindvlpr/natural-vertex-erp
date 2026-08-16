<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->paginate(15);
        return view('procurement.supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully!');
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $id,
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully!');
    }
}