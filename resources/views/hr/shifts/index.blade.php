@extends('layouts.master')

@section('title', 'Shifts - Natural Vertex ERP')
@section('page-title', 'Shifts')

@section('content')
<style>
.hr-card { background: #fff; border: 1px solid #e8eaed; }
.hr-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; }
.hr-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.hr-card-title i { color: #6c5ce7; margin-right: 8px; }
.hr-card-body { padding: 20px; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; color: #fff; }
.btn-edit { padding: 4px 10px; background: #3b82f6; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-edit:hover { background: #2563eb; }
.btn-delete { padding: 4px 10px; background: #ef4444; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-delete:hover { background: #dc2626; }
.btn-toggle { padding: 4px 10px; background: #f59e0b; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-toggle:hover { background: #d97706; }
.badge-active { display: inline-block; padding: 2px 12px; background: #10b981; color: #fff; font-size: 11px; }
.badge-inactive { display: inline-block; padding: 2px 12px; background: #ef4444; color: #fff; font-size: 11px; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 16px; color: #166534; margin-bottom: 16px; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; padding: 10px 16px; color: #991b1b; margin-bottom: 16px; }
.badge-shift { display: inline-block; padding: 2px 10px; background: #e8eaed; font-size: 11px; }
</style>

<div class="hr-card">
    <div class="hr-card-header">
        <h5 class="hr-card-title">
            <i class="fas fa-clock"></i> Shifts
        </h5>
        <a href="{{ route('hr.shifts.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Add Shift
        </a>
    </div>

    <div class="hr-card-body">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div style="overflow-x:auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Break</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shifts as $shift)
                        <tr>
                            <td>#{{ $shift->id }}</td>
                            <td><strong>{{ $shift->name }}</strong></td>
                            <td style="color:#6b6b80;">{{ $shift->formatted_time }}</td>
                            <td><span class="badge-shift">{{ ucfirst($shift->shift_type) }}</span></td>
                            <td>{{ $shift->break_duration }} min</td>
                            <td>
                                @if($shift->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <a href="{{ route('hr.shifts.edit', $shift->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $shift->id }}').submit();" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $shift->id }}" action="{{ route('hr.shifts.destroy', $shift->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('hr.shifts.toggle-status', $shift->id) }}" class="btn-toggle">
                                        <i class="fas fa-{{ $shift->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-clock" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No shifts found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $shifts->links() }}
        </div>
    </div>
</div>
@endsection