<?php

namespace App\Http\Controllers;

use App\Models\StockTransfer;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::with(['fromWarehouse', 'toWarehouse', 'product'])
                    ->orderBy('id', 'desc')->paginate(15);
        return view('warehouse.transfers.index', compact('transfers'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        return view('warehouse.transfers.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transfer_date' => 'required|date',
        ]);

        StockTransfer::create([
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'transfer_date' => $request->transfer_date,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('warehouse.transfers.index')->with('success', 'Stock transfer initiated successfully!');
    }

    public function show(StockTransfer $transfer)
    {
        return view('warehouse.transfers.show', compact('transfer'));
    }

    public function updateStatus(Request $request, StockTransfer $transfer)
    {
        $request->validate(['status' => 'required|in:pending,completed,cancelled']);
        $transfer->update(['status' => $request->status]);

        return redirect()->route('warehouse.transfers.index')->with('success', 'Transfer status updated!');
    }
}