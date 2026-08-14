<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseItem;
use App\Models\GoodsReceive;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProcurementController extends Controller
{
    /**
     * Procurement Dashboard
     */
    public function index()
    {
        $totalRequests = PurchaseRequest::count();
        $totalOrders = PurchaseOrder::count();
        $pendingRequests = PurchaseRequest::where('status', 'pending')->count();
        $pendingOrders = PurchaseOrder::where('status', 'draft')->count();
        $totalSuppliers = Supplier::count();

        $recentRequests = PurchaseRequest::with(['department', 'requestedBy'])
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('procurement.index', compact(
            'totalRequests',
            'totalOrders',
            'pendingRequests',
            'pendingOrders',
            'totalSuppliers',
            'recentRequests'
        ));
    }

    /**
     * Purchase Request Management
     */
    public function purchaseRequest(Request $request)
    {
        $status = $request->get('status');
        $requests = PurchaseRequest::with(['department', 'requestedBy'])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $departments = Department::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();

        return view('procurement.purchase-request', compact('requests', 'departments', 'products', 'status'));
    }

    /**
     * Store Purchase Request
     */
    public function storePurchaseRequest(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'request_date' => 'required|date',
            'required_date' => 'nullable|date|after:request_date',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        $purchaseRequest = PurchaseRequest::create([
            'request_number' => 'PR-' . strtoupper(Str::random(8)),
            'department_id' => $request->department_id,
            'requested_by' => Auth::id(),
            'request_date' => $request->request_date,
            'required_date' => $request->required_date,
            'description' => $request->description,
            'total_amount' => $totalAmount,
            'priority' => $request->priority,
            'status' => 'pending',
            'remarks' => $request->remarks,
        ]);

        foreach ($request->items as $item) {
            PurchaseItem::create([
                'purchase_request_id' => $purchaseRequest->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
                'description' => $item['description'] ?? null,
            ]);
        }

        return redirect()->route('procurement.request')
            ->with('success', 'Purchase request created successfully!');
    }

    /**
     * Purchase Order Management
     */
    public function purchaseOrder(Request $request)
    {
        $status = $request->get('status');
        $orders = PurchaseOrder::with(['supplier', 'createdBy'])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $purchaseRequests = PurchaseRequest::where('status', 'approved')->get();

        return view('procurement.purchase-order', compact('orders', 'suppliers', 'products', 'purchaseRequests', 'status'));
    }

    /**
     * Store Purchase Order
     */
    public function storePurchaseOrder(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after:order_date',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subTotal = 0;
        foreach ($request->items as $item) {
            $subTotal += $item['quantity'] * $item['unit_price'];
        }

        $discount = $request->discount ?? 0;
        $tax = $request->tax ?? 0;
        $shippingCharge = $request->shipping_charge ?? 0;
        $totalAmount = $subTotal - $discount + $tax + $shippingCharge;

        $purchaseOrder = PurchaseOrder::create([
            'order_number' => 'PO-' . strtoupper(Str::random(8)),
            'purchase_request_id' => $request->purchase_request_id,
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
            'delivery_date' => $request->delivery_date,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'sub_total' => $subTotal,
            'discount' => $discount,
            'tax' => $tax,
            'shipping_charge' => $shippingCharge,
            'total_amount' => $totalAmount,
            'status' => 'draft',
            'terms_conditions' => $request->terms_conditions,
            'remarks' => $request->remarks,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->items as $item) {
            PurchaseItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        // Update purchase request status if linked
        if ($request->purchase_request_id) {
            PurchaseRequest::where('id', $request->purchase_request_id)
                ->update(['status' => 'ordered']);
        }

        return redirect()->route('procurement.order')
            ->with('success', 'Purchase order created successfully!');
    }

    /**
     * Goods Receive Management
     */
    public function goodsReceive(Request $request)
    {
        $status = $request->get('status');
        $receives = GoodsReceive::with(['purchaseOrder', 'purchaseOrder.supplier'])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $purchaseOrders = PurchaseOrder::where('status', 'confirmed')->get();

        return view('procurement.goods-receive', compact('receives', 'purchaseOrders', 'status'));
    }

    /**
     * Store Goods Receive
     */
    public function storeGoodsReceive(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'receive_date' => 'required|date',
            'received_by' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.purchase_item_id' => 'required|exists:purchase_items,id',
            'items.*.received_quantity' => 'required|numeric|min:0.01',
        ]);

        $goodsReceive = GoodsReceive::create([
            'receive_number' => 'GR-' . strtoupper(Str::random(8)),
            'purchase_order_id' => $request->purchase_order_id,
            'receive_date' => $request->receive_date,
            'received_by' => $request->received_by,
            'notes' => $request->notes,
            'status' => 'complete',
        ]);

        foreach ($request->items as $item) {
            $purchaseItem = PurchaseItem::find($item['purchase_item_id']);
            $purchaseItem->received_quantity += $item['received_quantity'];
            $purchaseItem->save();

            // Update stock
            $product = Product::find($purchaseItem->product_id);
            // Here you can add stock update logic
        }

        // Update purchase order status
        PurchaseOrder::where('id', $request->purchase_order_id)
            ->update(['status' => 'received']);

        return redirect()->route('procurement.goods-receive')
            ->with('success', 'Goods received successfully!');
    }

    /**
     * Purchase Invoice Management
     */
    public function purchaseInvoice(Request $request)
    {
        $paymentStatus = $request->get('payment_status');
        $invoices = PurchaseInvoice::with(['supplier', 'purchaseOrder'])
            ->when($paymentStatus, function($query) use ($paymentStatus) {
                return $query->where('payment_status', $paymentStatus);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $suppliers = Supplier::where('is_active', true)->get();
        $purchaseOrders = PurchaseOrder::where('status', 'received')->get();

        return view('procurement.purchase-invoice', compact('invoices', 'suppliers', 'purchaseOrders', 'paymentStatus'));
    }

    /**
     * Store Purchase Invoice
     */
    public function storePurchaseInvoice(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after:invoice_date',
            'sub_total' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
        ]);

        $subTotal = $request->sub_total;
        $discount = $request->discount ?? 0;
        $tax = $request->tax ?? 0;
        $shippingCharge = $request->shipping_charge ?? 0;
        $totalAmount = $subTotal - $discount + $tax + $shippingCharge;

        PurchaseInvoice::create([
            'invoice_number' => 'PI-' . strtoupper(Str::random(8)),
            'purchase_order_id' => $request->purchase_order_id,
            'supplier_id' => $request->supplier_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'sub_total' => $subTotal,
            'discount' => $discount,
            'tax' => $tax,
            'shipping_charge' => $shippingCharge,
            'total_amount' => $totalAmount,
            'paid_amount' => 0,
            'due_amount' => $totalAmount,
            'payment_status' => 'unpaid',
            'notes' => $request->notes,
        ]);

        return redirect()->route('procurement.invoice')
            ->with('success', 'Purchase invoice created successfully!');
    }

    /**
     * Update Invoice Payment
     */
    public function updateInvoicePayment(Request $request, $id)
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $invoice = PurchaseInvoice::findOrFail($id);
        $newPaidAmount = $invoice->paid_amount + $request->paid_amount;
        
        if ($newPaidAmount > $invoice->total_amount) {
            return redirect()->back()->with('error', 'Payment amount cannot exceed total amount!');
        }

        $invoice->paid_amount = $newPaidAmount;
        $invoice->due_amount = $invoice->total_amount - $newPaidAmount;
        
        if ($invoice->due_amount <= 0) {
            $invoice->payment_status = 'paid';
        } else {
            $invoice->payment_status = 'partial';
        }
        
        $invoice->save();

        return redirect()->route('procurement.invoice')
            ->with('success', 'Payment updated successfully!');
    }
}