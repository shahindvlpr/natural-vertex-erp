@extends('layouts.master')

@section('title', 'Purchase Invoice - Natural Vertex ERP')
@section('page-title', 'Purchase Invoice')

@section('content')
<style>
.proc-card { background: #fff; border: 1px solid #e8eaed; }
.proc-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.proc-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.proc-card-title i { color: #6c5ce7; margin-right: 8px; }
.proc-card-body { padding: 20px; }
.form-group { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 4px; }
.form-label .required { color: #ef4444; }
.form-control { width: 100%; padding: 9px 14px; font-size: 13px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; transition: all 0.25s ease; }
.form-control:focus { outline: none; border-color: #6c5ce7; box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06); }
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b80' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-success-custom { padding: 8px 16px; background: #10b981; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.btn-success-custom:hover { background: #059669; }
.btn-save { padding: 10px 28px; background: linear-gradient(135deg, #6c5ce7, #4a3db8); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3); }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-paid { background: #10b981; }
.status-partial { background: #f59e0b; }
.status-unpaid { background: #ef4444; }
.filters { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 16px; }
.payment-modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; }
.payment-modal-content { background:#fff; max-width:500px; width:90%; padding:24px; border:1px solid #e8eaed; }
.row-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 768px) { .row-grid { grid-template-columns: 1fr; } }
</style>

<div class="proc-card">
    <div class="proc-card-header">
        <h5 class="proc-card-title">
            <i class="fas fa-file-invoice"></i> Purchase Invoice
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <form method="GET" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <select name="payment_status" class="form-control" style="width:150px; padding:6px 12px;">
                    <option value="">All Status</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-search"></i> Filter
                </button>
            </form>
            <button onclick="document.getElementById('createForm').style.display='block'" class="btn-primary-custom">
                <i class="fas fa-plus"></i> New Invoice
            </button>
        </div>
    </div>

    <div class="proc-card-body">
        @if(session('success'))
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 16px; color:#166534; margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fef2f2; border:1px solid #fecaca; padding:10px 16px; color:#991b1b; margin-bottom:16px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Create Form -->
        <div id="createForm" style="display:none; margin-bottom:24px; padding:20px; border:1px solid #e8eaed; background:#f8f9fa;">
            <h6 style="margin:0 0 16px 0; font-size:15px; font-weight:600;">
                <i class="fas fa-plus-circle" style="color:#6c5ce7;"></i> Create Purchase Invoice
            </h6>
            <form action="{{ route('procurement.invoice.store') }}" method="POST">
                @csrf

                <div class="row-grid">
                    <div class="form-group">
                        <label class="form-label">Purchase Order <span class="required">*</span></label>
                        <select name="purchase_order_id" class="form-control" required>
                            <option value="">Select Order</option>
                            @foreach($purchaseOrders as $po)
                                <option value="{{ $po->id }}">{{ $po->order_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier <span class="required">*</span></label>
                        <select name="supplier_id" class="form-control" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Invoice Date <span class="required">*</span></label>
                        <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sub Total <span class="required">*</span></label>
                        <input type="number" step="0.01" name="sub_total" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Discount</label>
                        <input type="number" step="0.01" name="discount" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tax</label>
                        <input type="number" step="0.01" name="tax" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Shipping Charge</label>
                        <input type="number" step="0.01" name="shipping_charge" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div style="display:flex; gap:12px; margin-top:12px;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Create Invoice
                    </button>
                    <button type="button" onclick="document.getElementById('createForm').style.display='none'" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>PO #</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                            <td>{{ $invoice->purchaseOrder->order_number ?? 'N/A' }}</td>
                            <td>{{ $invoice->supplier->name ?? 'N/A' }}</td>
                            <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                            <td>{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : 'N/A' }}</td>
                            <td>৳ {{ number_format($invoice->total_amount, 2) }}</td>
                            <td>৳ {{ number_format($invoice->paid_amount, 2) }}</td>
                            <td><strong>৳ {{ number_format($invoice->due_amount, 2) }}</strong></td>
                            <td>
                                <span class="status-badge status-{{ $invoice->payment_status }}">
                                    {{ ucfirst($invoice->payment_status) }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <button onclick="viewInvoice({{ $invoice->id }})" class="btn-primary-custom" style="padding:4px 10px; font-size:11px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($invoice->payment_status != 'paid')
                                        <button onclick="openPaymentModal({{ $invoice->id }}, {{ $invoice->due_amount }})" class="btn-success-custom" style="padding:4px 10px; font-size:11px;">
                                            <i class="fas fa-money-bill"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-file-invoice" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No purchase invoices found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $invoices->appends(['payment_status' => request('payment_status')])->links() }}
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="payment-modal">
    <div class="payment-modal-content">
        <h5 style="margin:0 0 16px 0; font-size:16px; font-weight:600;">
            <i class="fas fa-money-bill" style="color:#6c5ce7;"></i> Make Payment
        </h5>
        <form action="" method="POST" id="paymentForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Amount to Pay <span class="required">*</span></label>
                <input type="number" step="0.01" name="paid_amount" id="paymentAmount" class="form-control" required>
                <small style="color:#6b6b80; font-size:11px;">Due Amount: ৳ <span id="dueAmountDisplay">0.00</span></small>
            </div>
            <div class="form-group">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-control">
                    <option value="bank">Bank Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="cheque">Cheque</option>
                    <option value="mobile">Mobile Banking</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Payment Date</label>
                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
            <div style="display:flex; gap:12px; margin-top:12px;">
                <button type="submit" class="btn-save">
                    <i class="fas fa-check"></i> Make Payment
                </button>
                <button type="button" onclick="closePaymentModal()" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPaymentModal(invoiceId, dueAmount) {
    const modal = document.getElementById('paymentModal');
    const form = document.getElementById('paymentForm');
    const amountInput = document.getElementById('paymentAmount');
    const dueDisplay = document.getElementById('dueAmountDisplay');
    
    form.action = '/procurement/invoices/' + invoiceId + '/payment';
    amountInput.max = dueAmount;
    amountInput.placeholder = 'Max: ' + dueAmount.toFixed(2);
    dueDisplay.textContent = dueAmount.toFixed(2);
    modal.style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

function viewInvoice(id) {
    alert('View invoice ID: ' + id);
}

// Close modal on outside click
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) closePaymentModal();
});
</script>
@endsection