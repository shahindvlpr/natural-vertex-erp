@extends('layouts.master')

@section('title', 'Salary History - Natural Vertex ERP')
@section('page-title', 'Salary History')

@section('content')
<style>
.payroll-card { background: #fff; border: 1px solid #e8eaed; }
.payroll-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.payroll-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.payroll-card-title i { color: #6c5ce7; margin-right: 8px; }
.payroll-card-body { padding: 20px; }
.form-control { padding: 6px 12px; border: 1px solid #e8eaed; font-size: 13px; background: #fff; }
.btn-primary-custom { padding: 6px 16px; background: #6c5ce7; color: #fff; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; }
.btn-view { padding: 4px 10px; background: #3b82f6; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-view:hover { background: #2563eb; }
.btn-pdf { padding: 4px 10px; background: #ef4444; color: #fff; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-pdf:hover { background: #dc2626; }
.btn-status { padding: 4px 10px; border: none; font-size: 11px; cursor: pointer; transition: all 0.2s; }
.btn-status-draft { background: #6b7280; color: #fff; }
.btn-status-generated { background: #3b82f6; color: #fff; }
.btn-status-approved { background: #10b981; color: #fff; }
.btn-status-paid { background: #8b5cf6; color: #fff; }
.status-badge { display: inline-block; padding: 2px 10px; font-size: 11px; color: #fff; }
.status-draft { background: #6b7280; }
.status-generated { background: #3b82f6; }
.status-approved { background: #10b981; }
.status-paid { background: #8b5cf6; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.filters { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 16px; }
@media (max-width: 576px) { .filters { flex-direction: column; align-items: stretch; } }
</style>

<div class="payroll-card">
    <div class="payroll-card-header">
        <h5 class="payroll-card-title">
            <i class="fas fa-history"></i> Salary History
        </h5>
        <a href="{{ route('payroll.index') }}" class="btn-primary-custom">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="payroll-card-body">
        @if(session('success'))
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 16px; color:#166534; margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="filters">
            <form method="GET" action="{{ route('payroll.history') }}" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <select name="employee_id" class="form-control" style="width:200px;">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ $employeeId == $emp->id ? 'selected' : '' }}>
                            {{ $emp->full_name }}
                        </option>
                    @endforeach
                </select>
                <select name="status" class="form-control" style="width:150px;">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="generated" {{ request('status') == 'generated' ? 'selected' : '' }}>Generated</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('payroll.history') }}" class="btn-primary-custom" style="background:#e8eaed; color:#4a4a5a;">
                    <i class="fas fa-times"></i> Clear
                </a>
            </form>
        </div>

        <!-- Table -->
        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th>Gross Salary</th>
                        <th>Net Salary</th>
                        <th>Present</th>
                        <th>OT Hours</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salaries as $salary)
                        <tr>
                            <td>
                                <strong>{{ $salary->employee->full_name ?? 'N/A' }}</strong>
                                <div style="font-size:11px; color:#6b6b80;">{{ $salary->employee->employee_id ?? '' }}</div>
                            </td>
                            <td>{{ $salary->month_year }}</td>
                            <td>৳ {{ number_format($salary->gross_salary, 2) }}</td>
                            <td><strong>৳ {{ number_format($salary->net_salary, 2) }}</strong></td>
                            <td>{{ $salary->total_present }}/{{ $salary->total_absent + $salary->total_present + $salary->total_late }}</td>
                            <td>{{ number_format($salary->total_overtime_hours, 1) }}h</td>
                            <td>
                                <span class="status-badge status-{{ $salary->status }}">
                                    {{ $salary->status_label }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center; flex-wrap:wrap;">
                                    <a href="{{ route('payroll.slip', $salary->id) }}" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('payroll.slip.pdf', $salary->id) }}" class="btn-pdf" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <button onclick="openStatusModal({{ $salary->id }}, '{{ $salary->status }}')" class="btn-status btn-status-{{ $salary->status }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80;">
                                <i class="fas fa-history" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No salary records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $salaries->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; max-width:500px; width:90%; padding:24px; border:1px solid #e8eaed;">
        <h5 style="margin:0 0 16px 0; font-size:16px; font-weight:600;">
            <i class="fas fa-edit" style="color:#6c5ce7;"></i> Update Salary Status
        </h5>
        <form id="statusForm" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" id="statusSelect" class="form-control" required>
                    <option value="generated">Generated</option>
                    <option value="approved">Approved</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Payment Date</label>
                <input type="date" name="payment_date" id="paymentDate" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" id="paymentMethod" class="form-control">
                    <option value="">Select Method</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="cheque">Cheque</option>
                    <option value="mobile">Mobile Banking</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Transaction ID</label>
                <input type="text" name="transaction_id" id="transactionId" class="form-control" placeholder="Enter transaction ID">
            </div>
            <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
            </div>
            <div style="display:flex; gap:12px; margin-top:12px;">
                <button type="submit" class="btn-generate" style="background:linear-gradient(135deg,#6c5ce7,#4a3db8);">
                    <i class="fas fa-save"></i> Update
                </button>
                <button type="button" onclick="closeStatusModal()" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openStatusModal(id, status) {
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('statusForm');
    const select = document.getElementById('statusSelect');
    const paymentDate = document.getElementById('paymentDate');
    const paymentMethod = document.getElementById('paymentMethod');
    const transactionId = document.getElementById('transactionId');
    const notes = document.getElementById('notes');
    
    // Set form action
    form.action = '/payroll/update-status/' + id;
    
    // Set current status
    select.value = status;
    
    // If paid, show payment fields
    if (status === 'paid') {
        paymentDate.style.display = 'block';
        paymentMethod.style.display = 'block';
        transactionId.style.display = 'block';
    } else {
        paymentDate.style.display = 'none';
        paymentMethod.style.display = 'none';
        transactionId.style.display = 'none';
    }
    
    // Clear fields
    paymentDate.value = '';
    paymentMethod.value = '';
    transactionId.value = '';
    notes.value = '';
    
    modal.style.display = 'flex';
}

function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
}

// Show/hide payment fields based on status selection
document.getElementById('statusSelect')?.addEventListener('change', function() {
    const show = this.value === 'paid';
    document.getElementById('paymentDate').style.display = show ? 'block' : 'none';
    document.getElementById('paymentMethod').style.display = show ? 'block' : 'none';
    document.getElementById('transactionId').style.display = show ? 'block' : 'none';
});

// Close modal on outside click
document.getElementById('statusModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeStatusModal();
});
</script>
@endsection