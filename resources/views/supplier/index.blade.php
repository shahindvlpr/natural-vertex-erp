@extends('layouts.master')

@section('title', 'Suppliers - Natural Vertex ERP')
@section('page-title', 'Suppliers')

@section('content')
<style>
.supplier-card { background: #fff; border: 1px solid #e8eaed; }
.supplier-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.supplier-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.supplier-card-title i { color: #6c5ce7; margin-right: 8px; }
.supplier-card-body { padding: 20px; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-edit { padding: 4px 10px; background: #3b82f6; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-edit:hover { background: #2563eb; }
.btn-delete { padding: 4px 10px; background: #ef4444; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-delete:hover { background: #dc2626; }
.btn-toggle { padding: 4px 10px; background: #f59e0b; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-toggle:hover { background: #d97706; }
.btn-view { padding: 4px 10px; background: #10b981; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-view:hover { background: #059669; }
.badge-active { display: inline-block; padding: 2px 12px; background: #10b981; color: #fff; font-size: 11px; }
.badge-inactive { display: inline-block; padding: 2px 12px; background: #6b7280; color: #fff; font-size: 11px; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
</style>

<div class="supplier-card">
    <div class="supplier-card-header">
        <h5 class="supplier-card-title">
            <i class="fas fa-truck"></i> Suppliers
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('supplier.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Add Supplier
            </a>
        </div>
    </div>

    <div class="supplier-card-body">
        @if(session('success'))
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 16px; color:#166534; margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#fef2f2; border:1px solid #fecaca; padding:10px 16px; color:#991b1b; margin-bottom:16px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Contact Person</th>
                        <th>Orders</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>#{{ $supplier->id }}</td>
                            <td>
                                <strong>{{ $supplier->name }}</strong>
                                @if($supplier->website)
                                    <div style="font-size:11px; color:#6b6b80;">
                                        <a href="{{ $supplier->website }}" target="_blank" style="color:#6c5ce7; text-decoration:none;">
                                            {{ $supplier->website }}
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $supplier->email ?? 'N/A' }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                            <td>
                                <span style="display:inline-block; padding:2px 10px; background:#e8eaed; font-size:12px;">
                                    {{ $supplier->purchase_orders_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                @if($supplier->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center; flex-wrap:wrap;">
                                    <a href="{{ route('supplier.show', $supplier->id) }}" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $supplier->id }}').submit();" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $supplier->id }}" action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('supplier.toggle-status', $supplier->id) }}" class="btn-toggle">
                                        <i class="fas fa-{{ $supplier->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                    <a href="{{ route('supplier.purchase-history', $supplier->id) }}" class="btn-view" style="background:#8b5cf6;">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-truck" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No suppliers found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection