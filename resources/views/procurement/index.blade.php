@extends('layouts.master')

@section('title', 'Procurement Dashboard - Natural Vertex ERP')
@section('page-title', 'Procurement Dashboard')

@section('content')
<style>
.proc-card { background: #fff; border: 1px solid #e8eaed; }
.proc-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; }
.proc-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.proc-card-title i { color: #6c5ce7; margin-right: 8px; }
.proc-card-body { padding: 20px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px; }
.stat-box { text-align: center; padding: 16px; border: 1px solid #e8eaed; transition: all 0.2s; }
.stat-box:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.stat-number { font-size: 28px; font-weight: 700; color: #1a1a2e; display: block; }
.stat-label { font-size: 12px; color: #6b6b80; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-draft { background: #6b7280; }
.status-pending { background: #f59e0b; }
.status-approved { background: #10b981; }
.status-rejected { background: #ef4444; }
.status-ordered { background: #3b82f6; }
</style>

<div class="proc-card">
    <div class="proc-card-header">
        <h5 class="proc-card-title">
            <i class="fas fa-shopping-cart"></i> Procurement Dashboard
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('procurement.request') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i> New Request
            </a>
            <a href="{{ route('procurement.order') }}" class="btn-primary-custom">
                <i class="fas fa-file-signature"></i> New Order
            </a>
        </div>
    </div>

    <div class="proc-card-body">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-number">{{ $totalRequests }}</span>
                <span class="stat-label">Total Requests</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalOrders }}</span>
                <span class="stat-label">Total Orders</span>
            </div>
            <div class="stat-box" style="border-color:#f59e0b;">
                <span class="stat-number" style="color:#f59e0b;">{{ $pendingRequests }}</span>
                <span class="stat-label">Pending Requests</span>
            </div>
            <div class="stat-box" style="border-color:#3b82f6;">
                <span class="stat-number" style="color:#3b82f6;">{{ $pendingOrders }}</span>
                <span class="stat-label">Draft Orders</span>
            </div>
            <div class="stat-box" style="border-color:#6c5ce7;">
                <span class="stat-number" style="color:#6c5ce7;">{{ $totalSuppliers }}</span>
                <span class="stat-label">Suppliers</span>
            </div>
        </div>

        <!-- Recent Requests -->
        <h6 style="font-size:13px; font-weight:600; margin-bottom:12px;">
            <i class="fas fa-clock" style="color:#6c5ce7;"></i> Recent Purchase Requests
        </h6>
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Request #</th>
                        <th>Department</th>
                        <th>Requested By</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Priority</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRequests as $request)
                        <tr>
                            <td><strong>{{ $request->request_number }}</strong></td>
                            <td>{{ $request->department->name ?? 'N/A' }}</td>
                            <td>{{ $request->requestedBy->name ?? 'N/A' }}</td>
                            <td>{{ $request->request_date->format('d M Y') }}</td>
                            <td>৳ {{ number_format($request->total_amount, 2) }}</td>
                            <td>
                                <span style="display:inline-block; padding:2px 8px; 
                                    @if($request->priority == 'urgent') background:#ef4444; color:#fff;
                                    @elseif($request->priority == 'high') background:#f59e0b; color:#fff;
                                    @elseif($request->priority == 'medium') background:#3b82f6; color:#fff;
                                    @else background:#6b7280; color:#fff; @endif
                                    font-size:10px;">
                                    {{ ucfirst($request->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $request->status }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-shopping-cart" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No purchase requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection