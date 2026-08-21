<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function receiveIndex()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        return view('warehouse.receive', compact('warehouses', 'products'));
    }

    public function receiveStore(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $stockBefore = $product->stock;

        $product->stock += $request->quantity;
        $product->save();

        StockMovement::create([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id,
            'type' => 'receive',
            'quantity' => $request->quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $product->stock,
            'movement_date' => now(),
            'reference' => $request->reference,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('warehouse.receive')->with('success', 'Stock Received Successfully!');
    }

    public function issueIndex()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        return view('warehouse.issue', compact('warehouses', 'products'));
    }

    public function issueStore(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        $stockBefore = $product->stock;
        $product->stock -= $request->quantity;
        $product->save();

        StockMovement::create([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id,
            'type' => 'issue',
            'quantity' => $request->quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $product->stock,
            'movement_date' => now(),
            'reference' => $request->reference,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('warehouse.issue')->with('success', 'Stock Issued Successfully!');
    }
}