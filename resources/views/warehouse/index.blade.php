@extends('layouts.master')

@section('title', 'Warehouses')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Dynamic Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                <i class="fas fa-warehouse text-primary me-2"></i> 
                Warehouses
            </h5>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> 
                Manage your storage locations
            </p>
        </div>
        <a href="{{ route('warehouse.create') }}" class="btn btn-primary px-4 shadow-sm hover-lift">
            <i class="fas fa-plus me-2"></i> Add Warehouse
        </a>
    </div>

    <!-- Premium Card -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase text-muted small fw-bold border-bottom-0">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Location</th>
                            <th class="py-3">Manager</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="pe-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warehouses as $warehouse)
                        <tr class="smooth-row">
                            <td class="ps-4 py-3 fw-bold text-muted">#{{ $warehouse->id }}</td>
                            <td class="py-3 fw-semibold text-dark">
                                {{ $warehouse->name }}
                                @if($warehouse->location)
                                    <div class="small text-muted text-truncate" style="max-width: 200px;">
                                        <i class="fas fa-map-marker-alt me-1 text-primary" style="font-size: 10px;"></i> {{ $warehouse->location }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 text-muted">{{ $warehouse->location ?? '-' }}</td>
                            <td class="py-3 text-muted">{{ $warehouse->manager_name ?? 'Not Assigned' }}</td>
                            <td class="py-3 text-center">
                                @if($warehouse->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-center">
                                {{-- Edit --}}
                                <a href="{{ route('warehouse.edit', $warehouse->id) }}" class="btn btn-primary btn-sm btn-action me-1" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                {{-- Toggle Status --}}
                                <a href="{{ route('warehouse.toggle-status', $warehouse->id) }}" class="btn btn-warning btn-sm btn-action me-1" title="{{ $warehouse->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                                {{-- Delete --}}
                                <form action="{{ route('warehouse.destroy', $warehouse->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-action" onclick="return confirm('Are you sure you want to delete this warehouse?');" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="empty-state">
                                    <i class="fas fa-warehouse fa-3x text-light mb-3 d-block"></i>
                                    <p class="mb-0">No warehouses found. Click <strong>"Add Warehouse"</strong> to create one.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-3 pb-3 px-4">
            {{ $warehouses->links() }}
        </div>
    </div>
</div>

<style>
    /* Smooth & Premium Animations (Zero Border-Radius) */
    
    /* Header Transition */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Table Row Smooth Transition */
    .smooth-row {
        transition: all 0.25s ease;
    }
    .smooth-row:hover {
        background: #f8f9fa;
        transform: scale(1.002);
    }

    /* Button Action Smooth */
    .btn-action {
        transition: all 0.25s ease;
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-action:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Empty State Animation */
    .empty-state {
        padding: 20px;
        position: relative;
        transform: translateY(0);
        transition: transform 0.3s ease;
    }
    .empty-state:hover {
        transform: translateY(-5px);
    }

    /* Pagination (Custom) */
    .card-footer .pagination {
        margin: 0;
        transition: all 0.2s ease;
    }
    .card-footer .pagination .page-link {
        border-radius: 0;
        border: none;
        transition: all 0.2s ease;
    }
    .card-footer .pagination .page-item.active .page-link {
        background: var(--primary);
    }
    .card-footer .pagination .page-link:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection