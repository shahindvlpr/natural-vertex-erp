@extends('layouts.master')

@section('title', 'Stock Transfers')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-exchange-alt text-primary me-2"></i> Stock Transfers
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                Manage warehouse stock transfers
            </p>
        </div>
        <a href="{{ route('warehouse.transfers.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus me-1"></i> New Transfer
        </a>
    </div>

    <!-- Premium Card -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase text-muted small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th class="py-3">Product</th>
                            <th class="py-3">From</th>
                            <th class="py-3">To</th>
                            <th class="py-3 text-center">Qty</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="pe-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-muted">#{{ $transfer->id }}</td>
                            <td class="py-3 fw-semibold text-dark">{{ $transfer->product->name }}</td>
                            <td class="py-3 text-muted">{{ $transfer->fromWarehouse->name ?? '-' }}</td>
                            <td class="py-3 fw-semibold text-primary">{{ $transfer->toWarehouse->name }}</td>
                            <td class="py-3 text-center fw-bold">{{ $transfer->quantity }}</td>
                            <td class="py-3 text-center">
                                @if($transfer->status == 'completed')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Completed</span>
                                @elseif($transfer->status == 'cancelled')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Cancelled</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">Pending</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-center">
                                <a href="{{ route('warehouse.transfers.show', $transfer->id) }}" class="btn btn-info btn-sm me-1" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-exchange-alt fa-3x text-light mb-3 d-block"></i>
                                <p class="mb-0">No transfers found. Click "New Transfer" to initiate one.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-3 pb-3 px-4">
            {{ $transfers->links() }}
        </div>
    </div>
</div>

<style>
    /* Smooth & Premium No-Radius Animations */
    .btn-action {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .table-hover tbody tr {
        transition: all 0.25s ease;
    }
    .table-hover tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.002);
    }
</style>
@endsection