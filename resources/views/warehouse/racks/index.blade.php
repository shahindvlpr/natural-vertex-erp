@extends('layouts.master')

@section('title', 'Racks & Shelves')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-layer-group text-primary me-2"></i> Racks & Shelves
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                Manage warehouse racks and shelves
            </p>
        </div>
        <a href="{{ route('warehouse.racks.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus me-1"></i> Add Rack
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
                            <th class="py-3">Warehouse</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Code</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="pe-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($racks as $rack)
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-muted">#{{ $rack->id }}</td>
                            <td class="py-3 fw-semibold text-dark">{{ $rack->warehouse->name }}</td>
                            <td class="py-3">{{ $rack->name }}</td>
                            <td class="py-3 text-muted">{{ $rack->code ?? '-' }}</td>
                            <td class="py-3 text-center">
                                @if($rack->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-center">
                                <!-- Edit -->
                                <a href="{{ route('warehouse.racks.edit', $rack->id) }}" class="btn btn-primary btn-sm me-1" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <!-- Toggle Status -->
                                <a href="{{ route('warehouse.racks.toggle-status', $rack->id) }}" class="btn btn-warning btn-sm me-1" title="Toggle">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                                <!-- Delete -->
                                <form action="{{ route('warehouse.racks.destroy', $rack->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-layer-group fa-3x text-light mb-3 d-block"></i>
                                <p class="mb-0">No racks found. Click "Add Rack" to create one.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-3 pb-3 px-4">
            {{ $racks->links() }}
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