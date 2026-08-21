@extends('layouts.master')

@section('title', 'Issue Stock')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-arrow-up text-danger me-2"></i> Issue Stock
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                Issue stock from warehouse
            </p>
        </div>
        <a href="{{ route('warehouse.index') }}" class="btn btn-light px-4 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Warehouse
        </a>
    </div>

    <!-- Premium Full Width Card -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <form action="{{ route('warehouse.issue.store') }}" method="POST">
                @csrf
                
                <!-- Form Header -->
                <div class="px-4 py-3 border-bottom bg-light">
                    <h6 class="mb-0 text-muted fw-bold text-uppercase small">Issue Information</h6>
                </div>

                <!-- Form Body (Full Width) -->
                <div class="px-4 py-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="warehouse_id" class="form-label fw-bold text-muted small text-uppercase">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select bg-light border-0 py-2 @error('warehouse_id') is-invalid @enderror" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                            @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="product_id" class="form-label fw-bold text-muted small text-uppercase">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-select bg-light border-0 py-2 @error('product_id') is-invalid @enderror" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label fw-bold text-muted small text-uppercase">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" class="form-control bg-light border-0 py-2 @error('quantity') is-invalid @enderror" required>
                            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="reference" class="form-label fw-bold text-muted small text-uppercase">Reference</label>
                            <input type="text" name="reference" id="reference" value="{{ old('reference') }}" class="form-control bg-light border-0 py-2" placeholder="Reference #">
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-4 py-3 border-top bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('warehouse.index') }}" class="btn btn-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-danger px-4 shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Issue Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Smooth & Premium No-Radius Animations */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .form-control, .form-select {
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        background: #fff !important;
        box-shadow: 0 0 0 2px rgba(108, 92, 231, 0.15) !important;
        border: 1px solid var(--primary) !important;
    }
</style>
@endsection