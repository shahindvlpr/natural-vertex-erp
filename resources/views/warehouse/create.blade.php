@extends('layouts.master')

@section('title', 'Add Warehouse')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-plus-circle text-primary me-2"></i> Add New Warehouse
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                Create a new storage location
            </p>
        </div>
        <a href="{{ route('warehouse.index') }}" class="btn btn-light px-4 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Premium Full Width Card -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <form action="{{ route('warehouse.store') }}" method="POST">
                @csrf
                
                <!-- Form Header -->
                <div class="px-4 py-3 border-bottom bg-light">
                    <h6 class="mb-0 text-muted fw-bold text-uppercase small">Warehouse Information</h6>
                </div>

                <!-- Form Body (Full Width) -->
                <div class="px-4 py-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label for="name" class="form-label fw-bold text-muted small text-uppercase">Warehouse Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control bg-light border-0 py-2 @error('name') is-invalid @enderror" placeholder="Enter warehouse name" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="location" class="form-label fw-bold text-muted small text-uppercase">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control bg-light border-0 py-2 @error('location') is-invalid @enderror" placeholder="Enter location">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="manager_name" class="form-label fw-bold text-muted small text-uppercase">Manager Name</label>
                            <input type="text" name="manager_name" id="manager_name" value="{{ old('manager_name') }}" class="form-control bg-light border-0 py-2 @error('manager_name') is-invalid @enderror" placeholder="Manager name">
                            @error('manager_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="phone" class="form-label fw-bold text-muted small text-uppercase">Contact Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control bg-light border-0 py-2 @error('phone') is-invalid @enderror" placeholder="Contact phone">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <div class="bg-light p-3 d-flex align-items-center">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked style="width: 3em; height: 1.5em;">
                                    <label class="form-check-label fw-bold text-muted small ms-2" for="is_active">
                                        Active Status
                                    </label>
                                </div>
                                <span class="text-muted small ms-3">If enabled, this warehouse will be available for transactions.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-4 py-3 border-top bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('warehouse.index') }}" class="btn btn-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Save Warehouse
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
    
    .form-control {
        transition: all 0.2s ease;
    }
    .form-control:focus {
        background: #fff !important;
        box-shadow: 0 0 0 2px rgba(108, 92, 231, 0.15) !important;
        border: 1px solid var(--primary) !important;
    }
</style>
@endsection