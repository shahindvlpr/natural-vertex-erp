@extends('layouts.master')

@section('title', 'Supplier Details - Natural Vertex ERP')
@section('page-title', 'Supplier Details')

@section('content')
<style>
.profile-card { background: #fff; border: 1px solid #e8eaed; max-width: 1000px; margin: 0 auto; }
.profile-header { padding: 20px 24px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
.profile-title { margin: 0; font-size: 18px; font-weight: 700; }
.profile-title i { color: #6c5ce7; margin-right: 8px; }
.profile-body { padding: 24px; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.info-item { padding: 12px 16px; background: #f8f9fa; border: 1px solid #e8eaed; }
.info-label { font-size: 11px; color: #6b6b80; display: block; }
.info-value { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-top: 2px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 24px; }
.stat-box { text-align: center; padding: 16px; border: 1px solid #e8eaed; background: #f8f9fa; }
.stat-number { font-size: 24px; font-weight: 700; color: #1a1a2e; display: block; }
.stat-label { font-size: 11px; color: #6b6b80; }
.badge-active { display: inline-block; padding: 2px 12px; background: #10b981; color: #fff; font-size: 11px; }
.badge-inactive { display: inline-block; padding: 2px 12px; background: #6b7280; color: #fff; font-size: 11px; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-back { padding: 8px 16px; background: #e8eaed; color: #4a4a5a; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-back:hover { background: #d1d5db; }
.table-custom { width: 100%; border-collapse: collapse; margin-top: 12px; }
.table-custom th { padding: 8px 12px; text-align: left; font-size: 11px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 8px 12px; font-size: 12px; border-bottom: 1px solid #e8eaed; }
.status-badge { display: inline-block; padding: 2px 8px; font-size: 10px; color: #fff; }
.status-draft { background: #6b7280; }
.status-sent { background: #3b82f6; }
.status-confirmed { background: #10b981; }
.status-received { background: #8b5cf6; }
.status-cancelled { background: #ef4444; }
@media (max-width: 768px) { .info-grid { grid-template-columns: 1fr; } }
</style>

<div class="profile-card">
    <div class="profile-header">
        <div>
            <h5 class="profile-title">
                <i class="fas fa-truck"></i> {{ $supplier->name }}
            </h5>
            <div style="font-size:13px; color:#6b6b80; margin-top:4px;">
                <i class="fas fa-id-card"></i> ID: #{{ $supplier->id }}
                @if($supplier->is_active)
                    <span class="badge-active" style="margin-left:8px;">Active</span>
                @else
                    <span class="badge-inactive" style="margin-left:8px;">Inactive</span>
                @endif
            </div>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('supplier.purchase-history', $supplier->id) }}" class="btn-primary-custom">
                <i class="fas fa-history"></i> Purchase History
            </a>
            <a href="{{ route('supplier.statement', $supplier->id) }}" class="btn-primary-custom">
                <i class="fas fa-file-alt"></i> Statement
            </a>
            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn-primary-custom">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('supplier.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="profile-body">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-number">{{ $totalPurchases ?? 0 }}</span>
                <span class="stat-label">Total Purchases</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">৳ {{ number_format($totalPurchases ?? 0, 2) }}</span>
                <span class="stat-label">Total Amount</span>
            </div>
            <div class="stat-box" style="border-color:#10b981;">
                <span class="stat-number" style="color:#10b981;">৳ {{ number_format($totalPaid ?? 0, 2) }}</span>
                <span class="stat-label">Total Paid</span>
            </div>
            <div class="stat-box" style="border-color:#ef4444;">
                <span class="stat-number" style="color:#ef4444;">৳ {{ number_format($totalDue ?? 0, 2) }}</span>
                <span class="stat-label">Total Due</span>
            </div>
        </div>

        <!-- Information -->
        <h6 style="font-size:13px; font-weight:600; margin-bottom:12px;">
            <i class="fas fa-info-circle" style="color:#6c5ce7;"></i> Supplier Information
        </h6>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Supplier Name</span>
                <span class="info-value">{{ $supplier->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $supplier->email ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone</span>
                <span class="info-value">{{ $supplier->phone }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Website</span>
                <span class="info-value">
                    @if($supplier->website)
                        <a href="{{ $supplier->website }}" target="_blank" style="color:#6c5ce7; text-decoration:none;">
                            {{ $supplier->website }}
                        </a>
                    @else
                        N/A
                    @endif
                </span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">Address</span>
                <span class="info-value">{{ $supplier->address ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contact Person</span>
                <span class="info-value">{{ $supplier->contact_person ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contact Phone</span>
                <span class="info-value">{{ $supplier->contact_phone ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Orders</span>
                <span class="info-value">{{ $supplier->purchaseOrders()->count() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Member Since</span>
                <span class="info-value">{{ $supplier->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Recent Orders -->
        @if($purchaseOrders && $purchaseOrders->count() > 0)
            <h6 style="font-size:13px; font-weight:600; margin:20px 0 12px 0;">
                <i class="fas fa-clock" style="color:#6c5ce7;"></i> Recent Purchase Orders
            </h6>
            <div style="overflow-x:auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->order_date->format('d M Y') }}</td>
                                <td>৳ {{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection