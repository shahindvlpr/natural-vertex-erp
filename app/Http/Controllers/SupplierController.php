<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount(['purchaseOrders', 'purchaseInvoices'])
            ->orderBy('id', 'desc')
            ->paginate(15);
            
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers',
            'phone' => 'required|string|max:20|unique:suppliers',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Supplier::create($validated);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier created successfully!');
    }

    public function show(Supplier $supplier)
    {
        $purchaseOrders = $supplier->purchaseOrders()
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $totalPurchases = $supplier->total_purchases;
        $totalPaid = $supplier->total_paid;
        $totalDue = $supplier->total_due;

        return view('supplier.show', compact('supplier', 'purchaseOrders', 'totalPurchases', 'totalPaid', 'totalDue'));
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $supplier->update($validated);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchaseOrders()->count() > 0) {
            return redirect()->route('supplier.index')
                ->with('error', 'Cannot delete supplier with purchase orders!');
        }

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier deleted successfully!');
    }

    public function toggleStatus(Supplier $supplier)
    {
        $supplier->is_active = !$supplier->is_active;
        $supplier->save();

        $status = $supplier->is_active ? 'activated' : 'deactivated';

        return redirect()->route('supplier.index')
            ->with('success', "Supplier {$status} successfully!");
    }

    public function purchaseHistory($supplierId = null)
    {
        if (is_null($supplierId)) {
            return redirect()->route('supplier.all-purchase-history');
        }

        $supplier = Supplier::findOrFail($supplierId);

        $purchaseOrders = $supplier->purchaseOrders()
            ->with(['items', 'purchaseRequest'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('supplier.purchase-history', compact('supplier', 'purchaseOrders'));
    }

    public function statement($supplierId = null)
    {
        if (is_null($supplierId)) {
            return redirect()->route('supplier.all-statement');
        }

        $supplier = Supplier::findOrFail($supplierId);

        $invoices = $supplier->purchaseInvoices()
            ->orderBy('invoice_date', 'desc')
            ->get();

        $totalInvoices = $invoices->count();
        $totalAmount = $invoices->sum('total_amount');
        $totalPaid = $invoices->sum('paid_amount');
        $totalDue = $invoices->sum('due_amount');

        return view('supplier.statement', compact(
            'supplier',
            'invoices',
            'totalInvoices',
            'totalAmount',
            'totalPaid',
            'totalDue'
        ));
    }

    public function makePayment(Request $request, Supplier $supplier)
    {
        $request->validate([
            'invoice_id' => 'required|exists:purchase_invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $invoice = PurchaseInvoice::findOrFail($request->invoice_id);

        if ($request->amount > $invoice->due_amount) {
            return redirect()->back()->with('error', 'Payment amount cannot exceed due amount!');
        }

        $invoice->paid_amount += $request->amount;
        $invoice->due_amount = $invoice->total_amount - $invoice->paid_amount;

        if ($invoice->due_amount <= 0) {
            $invoice->payment_status = 'paid';
        } else {
            $invoice->payment_status = 'partial';
        }

        $invoice->save();

        return redirect()->route('supplier.statement', $supplier->id)
            ->with('success', 'Payment made successfully!');
    }

    public function allPurchaseHistory()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'items', 'purchaseRequest'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('supplier.purchase-history-all', compact('purchaseOrders'));
    }

    public function allStatement()
    {
        $suppliers = Supplier::with(['purchaseInvoices'])
            ->where('is_active', true)
            ->get();

        $summary = [];
        $totalAmount = 0;
        $totalPaid = 0;
        $totalDue = 0;

        foreach ($suppliers as $supplier) {
            $supplierTotal = $supplier->purchaseInvoices->sum('total_amount');
            $supplierPaid = $supplier->purchaseInvoices->sum('paid_amount');
            $supplierDue = $supplier->purchaseInvoices->sum('due_amount');

            $summary[] = [
                'supplier' => $supplier,
                'total_amount' => $supplierTotal,
                'total_paid' => $supplierPaid,
                'total_due' => $supplierDue,
            ];

            $totalAmount += $supplierTotal;
            $totalPaid += $supplierPaid;
            $totalDue += $supplierDue;
        }

        return view('supplier.statement-all', compact('summary', 'totalAmount', 'totalPaid', 'totalDue'));
    }
}