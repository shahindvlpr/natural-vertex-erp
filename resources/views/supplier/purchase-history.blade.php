@extends('layouts.master')

@section('title', 'Purchase History - Natural Vertex ERP')
@section('page-title', 'Purchase History')

@section('content')
<style>
.history-card { background: #fff; border: 1px solid #e8eaed; }
.history-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.history-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.history-card-title i { color: #6c5ce7; margin-right: 8px; }
.history-card-body { padding: 20px; }
.btn-back { padding: 8px 16px; background: #e8eaed; color: #4a4a5a; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-back:hover { background: #d1d5db; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-draft { background: #6b7280; }
.status-sent { background: #3b82f6; }
.status-confirmed { background: #10b981; }
.status-received { background: #8b5cf6; }
.status-cancelled { background: #ef4444; }
</style>

<div class="history-card">
    <div class="history-card-header">
        <h5 class="history-card-title">
            <i class="fas fa-history"></i> Purchase History - {{ $supplier->name }}
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('supplier.show', $supplier->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Supplier
            </a>
            <a href="{{ route('supplier.statement', $supplier->id) }}" class="btn-back" style="background:#6c5ce7; color:#fff;">
                <i class="fas fa-file-alt"></i> Statement
            </a>
        </div>
    </div>

    <div class="history-card-body">
        <div style="margin-bottom:12px; padding:12px 16px; background:#f8f9fa; border:1px solid #e8eaed;">
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap:8px;">
                <div>
                    <span style="font-size:11px; color:#6b6b80;">Total Orders</span>
                    <div style="font-size:16px; font-weight:700;">{{ $purchaseOrders->total() }}</div>
                </div>
                <div>
                    <span style="font-size:11px; color:#6b6b80;">Total Amount</span>
                    <div style="font-size:16px; font-weight:700;">৳ {{ number_format($purchaseOrders->sum('total_amount'), 2) }}</div>
                </div>
                <div>
                    <span style="font-size:11px; color:#6b6b80;">Phone</span>
                    <div style="font-size:14px; font-weight:600;">{{ $supplier->phone }}</div>
                </div>
                <div>
                    <span style="font-size:11px; color:#6b6b80;">Email</span>
                    <div style="font-size:14px; font-weight:600;">{{ $supplier->email ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Request #</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->order_date->format('d M Y') }}</td>
                            <td>{{ $order->purchaseRequest->request_number ?? 'N/A' }}</td>
                            <td>৳ {{ number_format($order->sub_total, 2) }}</td>
                            <td>৳ {{ number_format($order->discount, 2) }}</td>
                            <td>৳ {{ number_format($order->tax, 2) }}</td>
                            <td><strong>৳ {{ number_format($order->total_amount, 2) }}</strong></td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-history" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No purchase history found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $purchaseOrders->links() }}
        </div>
    </div>
</div>
@endsection