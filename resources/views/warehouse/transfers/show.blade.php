@extends('layouts.master')

@section('title', 'Transfer Details')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-info-circle text-primary me-2"></i> Stock Transfer #{{ $transfer->id }}
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                View transfer details
            </p>
        </div>
        <a href="{{ route('warehouse.transfers.index') }}" class="btn btn-light px-4 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Premium Full Width Card -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <!-- Card Header -->
            <div class="px-4 py-3 border-bottom bg-light">
                <h6 class="mb-0 text-muted fw-bold text-uppercase small">Transfer Information</h6>
            </div>

            <!-- Information Grid -->
            <div class="px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">From Warehouse</label>
                            <span class="fw-semibold text-dark">{{ $transfer->fromWarehouse->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">To Warehouse</label>
                            <span class="fw-semibold text-primary">{{ $transfer->toWarehouse->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">Product</label>
                            <span class="fw-semibold text-dark">{{ $transfer->product->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">Quantity</label>
                            <span class="fw-bold text-dark">{{ $transfer->quantity }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">Transfer Date</label>
                            <span class="text-dark">{{ $transfer->transfer_date }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">Status</label>
                            @if($transfer->status == 'completed')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Completed</span>
                            @elseif($transfer->status == 'cancelled')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Cancelled</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">Pending</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3">
                            <label class="text-muted small fw-bold mb-1 d-block">Notes</label>
                            <span class="text-dark">{{ $transfer->notes ?? 'No notes provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            @if($transfer->status === 'pending')
            <div class="px-4 py-3 border-top bg-light d-flex align-items-center gap-3">
                <span class="fw-bold text-muted small text-uppercase">Update Status:</span>
                <form action="{{ route('warehouse.transfers.update-status', $transfer->id) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <select name="status" class="form-select form-select-sm bg-white border-0" style="max-width: 200px;">
                        <option value="completed">Mark as Completed</option>
                        <option value="cancelled">Mark as Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </form>
            </div>
            @endif
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
    
    .form-select {
        transition: all 0.2s ease;
    }
    .form-select:focus {
        background: #fff !important;
        box-shadow: 0 0 0 2px rgba(108, 92, 231, 0.15) !important;
        border: 1px solid var(--primary) !important;
    }
</style>
@endsection