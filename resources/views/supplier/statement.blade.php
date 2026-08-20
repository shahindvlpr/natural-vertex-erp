@extends('layouts.master')

@section('title', 'Supplier Statement - Natural Vertex ERP')
@section('page-title', 'Supplier Statement')

@section('content')
<style>
.statement-card { background: #fff; border: 1px solid #e8eaed; }
.statement-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.statement-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.statement-card-title i { color: #6c5ce7; margin-right: 8px; }
.statement-card-body { padding: 20px; }
.btn-back { padding: 8px 16px; background: #e8eaed; color: #4a4a5a; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-back:hover { background: #d1d5db; }
.btn-print { padding: 8px 16px; background: #3b82f6; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-print:hover { background: #2563eb; }
.summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 20px; }
.summary-box { text-align: center; padding: 16px; border: 1px solid #e8eaed; background: #f8f9fa; }
.summary-number { font-size: 22px; font-weight: 700; display: block; }
.summary-label { font-size: 11px; color: #6b6b80; }
.summary-box.total .summary-number { color: #6c5ce7; }
.summary-box.paid .summary-number { color: #10b981; }
.summary-box.due .summary-number { color: #ef4444; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-paid { background: #10b981; }
.status-partial { background: #f59e0b; }
.status-unpaid { background: #ef4444; }
.payment-form { display: grid; grid-template-columns: 1fr 1fr auto; gap: 8px; align-items: end; margin-top: 12px; padding: 16px; background: #f8f9fa; border: 1px solid #e8eaed; }
.payment-form .form-group { margin-bottom: 0; }
.payment-form .form-label { font-size: 11px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 2px; }
.payment-form .form-control { padding: 6px 10px; font-size: 12px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; }
@media (max-width: 768px) { .payment-form { grid-template-columns: 1fr; } }
</style>

<div class="statement-card">
    <div class="statement-card-header">
        <h5 class="statement-card-title">
            <i class="fas fa-file-alt"></i> Supplier Statement - {{ $supplier->name }}
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('supplier.show', $supplier->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('supplier.purchase-history', $supplier->id) }}" class="btn-back">
                <i class="fas fa-history"></i> Purchase History
            </a>
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <div class="statement-card-body">
        <!-- Summary -->
        <div class="summary-grid">
            <div class="summary-box total">
                <span class="summary-number">৳ {{ number_format($totalAmount ?? 0, 2) }}</span>
                <span class="summary-label">Total Invoices</span>
            </div>
            <div class="summary-box paid">
                <span class="summary-number">৳ {{ number_format($totalPaid ?? 0, 2) }}</span>
                <span class="summary-label">Total Paid</span>
            </div>
            <div class="summary-box due">
                <span class="summary-number">৳ {{ number_format($totalDue ?? 0, 2) }}</span>
                <span class="summary-label">Total Due</span>
            </div>
            <div class="summary-box">
                <span class="summary-number">{{ $totalInvoices ?? 0 }}</span>
                <span class="summary-label">Total Invoices</span>
            </div>
        </div>

        <!-- Invoices -->
        <h6 style="font-size:13px; font-weight:600; margin-bottom:12px;">
            <i class="fas fa-file-invoice" style="color:#6c5ce7;"></i> Invoice Details
        </h6>
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>PO #</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                            <td>{{ $invoice->purchaseOrder->order_number ?? 'N/A' }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-file-alt" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No invoices found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Payment Form -->
        @if($totalDue > 0)
            <div style="margin-top:16px; padding:16px; background:#f8f9fa; border:1px solid #e8eaed;">
                <h6 style="font-size:13px; font-weight:600; margin:0 0 12px 0;">
                    <i class="fas fa-money-bill" style="color:#6c5ce7;"></i> Make Payment
                </h6>
                <form action="{{ route('supplier.payment', $supplier->id) }}" method="POST" class="payment-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Invoice <span class="required">*</span></label>
                        <select name="invoice_id" class="form-control" required>
                            <option value="">Select Invoice</option>
                            @foreach($invoices as $invoice)
                                @if($invoice->due_amount > 0)
                                    <option value="{{ $invoice->id }}">
                                        {{ $invoice->invoice_number }} - Due: ৳ {{ number_format($invoice->due_amount, 2) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Amount <span class="required">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1; display:flex; gap:8px; align-items:center;">
                        <button type="submit" class="btn-primary-custom" style="background:#10b981; padding:6px 20px;">
                            <i class="fas fa-check"></i> Make Payment
                        </button>
                        <span style="font-size:11px; color:#6b6b80;">
                            <i class="fas fa-info-circle"></i> Due Amount: ৳ {{ number_format($totalDue, 2) }}
                        </span>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection