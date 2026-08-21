@extends('layouts.master')

@section('title', 'Edit Rack')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-edit text-warning me-2"></i> Edit Rack / Shelf
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                Update rack information
            </p>
        </div>
        <a href="{{ route('warehouse.racks.index') }}" class="btn btn-light px-4 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <!-- Premium Full Width Card -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <form action="{{ route('warehouse.racks.update', $rack->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Form Header -->
                <div class="px-4 py-3 border-bottom bg-light">
                    <h6 class="mb-0 text-muted fw-bold text-uppercase small">Rack Information</h6>
                </div>

                <!-- Form Body (Full Width) -->
                <div class="px-4 py-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label for="warehouse_id" class="form-label fw-bold text-muted small text-uppercase">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select bg-light border-0 py-2 @error('warehouse_id') is-invalid @enderror" required>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ $rack->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                            @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="name" class="form-label fw-bold text-muted small text-uppercase">Rack/Shelf Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $rack->name) }}" class="form-control bg-light border-0 py-2 @error('name') is-invalid @enderror" placeholder="E.g. Rack A" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="code" class="form-label fw-bold text-muted small text-uppercase">Code</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $rack->code) }}" class="form-control bg-light border-0 py-2 @error('code') is-invalid @enderror" placeholder="E.g. A-1">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="description" class="form-label fw-bold text-muted small text-uppercase">Description</label>
                            <input type="text" name="description" id="description" value="{{ old('description', $rack->description) }}" class="form-control bg-light border-0 py-2 @error('description') is-invalid @enderror" placeholder="Short description">
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <div class="bg-light p-3 d-flex align-items-center">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $rack->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-muted small ms-2" for="is_active">
                                        Active Status
                                    </label>
                                </div>
                                <span class="text-muted small ms-3">If enabled, this rack will be available for storage.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-4 py-3 border-top bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('warehouse.racks.index') }}" class="btn btn-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Update Rack
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