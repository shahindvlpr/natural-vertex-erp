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
.form-group { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 4px; }
.form-label .required { color: #ef4444; }
.form-control { width: 100%; padding: 9px 14px; font-size: 13px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; transition: all 0.25s ease; }
.form-control:focus { outline: none; border-color: #6c5ce7; box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06); }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-save { padding: 10px 28px; background: linear-gradient(135deg, #6c5ce7, #4a3db8); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3); }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.row-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.badge-active { display: inline-block; padding: 2px 12px; background: #10b981; color: #fff; font-size: 11px; }
.badge-inactive { display: inline-block; padding: 2px 12px; background: #6b7280; color: #fff; font-size: 11px; }
@media (max-width: 768px) { .row-grid { grid-template-columns: 1fr; } }
</style>

<div class="supplier-card">
    <div class="supplier-card-header">
        <h5 class="supplier-card-title">
            <i class="fas fa-truck"></i> Suppliers
        </h5>
        <button onclick="document.getElementById('createForm').style.display='block'" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Add Supplier
        </button>
    </div>

    <div class="supplier-card-body">
        @if(session('success'))
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 16px; color:#166534; margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Create Form -->
        <div id="createForm" style="display:none; margin-bottom:24px; padding:20px; border:1px solid #e8eaed; background:#f8f9fa;">
            <h6 style="margin:0 0 16px 0; font-size:15px; font-weight:600;">
                <i class="fas fa-plus-circle" style="color:#6c5ce7;"></i> Add New Supplier
            </h6>
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf

                <div class="row-grid">
                    <div class="form-group">
                        <label class="form-label">Supplier Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone <span class="required">*</span></label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" class="form-control" placeholder="https://example.com">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control">
                    </div>
                </div>

                <div style="display:flex; gap:12px; margin-top:12px;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Supplier
                    </button>
                    <button type="button" onclick="document.getElementById('createForm').style.display='none'" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Contact Person</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers ?? [] as $supplier)
                        <tr>
                            <td>#{{ $supplier->id }}</td>
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->email ?? 'N/A' }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                            <td>
                                @if($supplier->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <button onclick="editSupplier({{ $supplier->id }})" class="btn-primary-custom" style="padding:4px 10px; font-size:11px;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteSupplier({{ $supplier->id }})" class="btn-danger-custom" style="padding:4px 10px; font-size:11px; background:#ef4444; color:#fff; border:none; cursor:pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-truck" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No suppliers found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function editSupplier(id) {
    alert('Edit supplier ID: ' + id);
}

function deleteSupplier(id) {
    if (confirm('Are you sure you want to delete this supplier?')) {
        alert('Supplier deleted!');
    }
}
</script>
@endsection