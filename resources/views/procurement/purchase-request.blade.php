@extends('layouts.master')

@section('title', 'Purchase Request - Natural Vertex ERP')
@section('page-title', 'Purchase Request')

@section('content')
<style>
.proc-card { background: #fff; border: 1px solid #e8eaed; }
.proc-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.proc-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.proc-card-title i { color: #6c5ce7; margin-right: 8px; }
.proc-card-body { padding: 20px; }
.form-group { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 600; color: #4a4a5a; display: block; margin-bottom: 4px; }
.form-label .required { color: #ef4444; }
.form-control { width: 100%; padding: 9px 14px; font-size: 13px; border: 1px solid #e8eaed; background: #fff; color: #1a1a2e; transition: all 0.25s ease; }
.form-control:focus { outline: none; border-color: #6c5ce7; box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06); }
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b80' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-success-custom { padding: 8px 16px; background: #10b981; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.btn-success-custom:hover { background: #059669; }
.btn-danger-custom { padding: 8px 16px; background: #ef4444; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.btn-danger-custom:hover { background: #dc2626; }
.btn-save { padding: 10px 28px; background: linear-gradient(135deg, #6c5ce7, #4a3db8); color: #fff; border: none; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108, 92, 231, 0.3); }
.btn-cancel { padding: 10px 20px; color: #6b6b80; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid #e8eaed; background: #fff; }
.btn-cancel:hover { background: #f8f9fc; color: #1a1a2e; }
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
.filters { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 16px; }
.row-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.item-row { display: grid; grid-template-columns: 3fr 1fr 1fr 1fr auto; gap: 8px; align-items: center; padding: 8px; background: #f8f9fa; border: 1px solid #e8eaed; margin-bottom: 8px; }
@media (max-width: 768px) { .row-grid { grid-template-columns: 1fr; } .item-row { grid-template-columns: 1fr; } }
</style>

<div class="proc-card">
    <div class="proc-card-header">
        <h5 class="proc-card-title">
            <i class="fas fa-file"></i> Purchase Request
        </h5>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <form method="GET" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <select name="status" class="form-control" style="width:150px; padding:6px 12px;">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                </select>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-search"></i> Filter
                </button>
            </form>
            <button onclick="document.getElementById('createForm').style.display='block'" class="btn-primary-custom">
                <i class="fas fa-plus"></i> New Request
            </button>
        </div>
    </div>

    <div class="proc-card-body">
        @if(session('success'))
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 16px; color:#166534; margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Create Form -->
        <div id="createForm" style="display:none; margin-bottom:24px; padding:20px; border:1px solid #e8eaed; background:#f8f9fa;">
            <h6 style="margin:0 0 16px 0; font-size:15px; font-weight:600;">
                <i class="fas fa-plus-circle" style="color:#6c5ce7;"></i> Create Purchase Request
            </h6>
            <form action="{{ route('procurement.request.store') }}" method="POST" id="requestForm">
                @csrf

                <div class="row-grid">
                    <div class="form-group">
                        <label class="form-label">Department <span class="required">*</span></label>
                        <select name="department_id" class="form-control" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Request Date <span class="required">*</span></label>
                        <input type="date" name="request_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Required Date</label>
                        <input type="date" name="required_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Priority <span class="required">*</span></label>
                        <select name="priority" class="form-control" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <h6 style="font-size:13px; font-weight:600; margin:16px 0 12px 0;">Items</h6>
                <div id="itemsContainer">
                    <div class="item-row">
                        <select name="items[0][product_id]" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="items[0][quantity]" placeholder="Qty" class="form-control" required step="0.01">
                        <input type="number" name="items[0][unit_price]" placeholder="Unit Price" class="form-control" required step="0.01">
                        <input type="text" name="items[0][description]" placeholder="Description" class="form-control">
                        <button type="button" onclick="removeItem(this)" class="btn-danger-custom" style="padding:4px 10px; font-size:12px;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="btn-primary-custom" style="margin-top:8px;">
                    <i class="fas fa-plus"></i> Add Item
                </button>

                <div class="form-group" style="margin-top:16px;">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="2"></textarea>
                </div>

                <div style="display:flex; gap:12px; margin-top:12px;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Submit Request
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
                        <th>Request #</th>
                        <th>Department</th>
                        <th>Requested By</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
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
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <button onclick="viewRequest({{ $request->id }})" class="btn-primary-custom" style="padding:4px 10px; font-size:11px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($request->status == 'pending')
                                        <button onclick="approveRequest({{ $request->id }})" class="btn-success-custom" style="padding:4px 10px; font-size:11px;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button onclick="rejectRequest({{ $request->id }})" class="btn-danger-custom" style="padding:4px 10px; font-size:11px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-file" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No purchase requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $requests->appends(['status' => request('status')])->links() }}
        </div>
    </div>
</div>

<script>
let itemIndex = 1;

function addItem() {
    const container = document.getElementById('itemsContainer');
    const row = document.createElement('div');
    row.className = 'item-row';
    row.innerHTML = `
        <select name="items[${itemIndex}][product_id]" class="form-control" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
        <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" class="form-control" required step="0.01">
        <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" class="form-control" required step="0.01">
        <input type="text" name="items[${itemIndex}][description]" placeholder="Description" class="form-control">
        <button type="button" onclick="removeItem(this)" class="btn-danger-custom" style="padding:4px 10px; font-size:12px;">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(row);
    itemIndex++;
}

function removeItem(btn) {
    const row = btn.closest('.item-row');
    if (document.querySelectorAll('.item-row').length > 1) {
        row.remove();
    } else {
        alert('You need at least one item!');
    }
}

function viewRequest(id) {
    alert('View request ID: ' + id);
}

function approveRequest(id) {
    if (confirm('Are you sure you want to approve this request?')) {
        alert('Request approved!');
    }
}

function rejectRequest(id) {
    if (confirm('Are you sure you want to reject this request?')) {
        alert('Request rejected!');
    }
}
</script>
@endsection