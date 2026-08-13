@extends('layouts.master')

@section('title', 'Holidays - Natural Vertex ERP')
@section('page-title', 'Holidays')

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
.badge-type { display: inline-block; padding: 2px 10px; font-size: 11px; }
.badge-type-public { background: #3b82f6; color: #fff; }
.badge-type-company { background: #8b5cf6; color: #fff; }
.badge-type-religious { background: #f59e0b; color: #fff; }
.badge-paid { display: inline-block; padding: 2px 10px; background: #10b981; color: #fff; font-size: 11px; }
.badge-unpaid { display: inline-block; padding: 2px 10px; background: #ef4444; color: #fff; font-size: 11px; }
.table-custom { width: 100%; border-collapse: collapse; }
.table-custom th { padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 600; color: #4a4a5a; background: #f8f9fa; border-bottom: 2px solid #e8eaed; }
.table-custom td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #e8eaed; }
.table-custom tr:hover td { background: #f8f9fa; }
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 16px; color: #166534; margin-bottom: 16px; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; padding: 10px 16px; color: #991b1b; margin-bottom: 16px; }
</style>

<div class="hr-card">
    <div class="hr-card-header">
        <h5 class="hr-card-title">
            <i class="fas fa-calendar-day"></i> Holidays
        </h5>
        <a href="{{ route('hr.holidays.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Add Holiday
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
                        <th>Date</th>
                        <th>Day</th>
                        <th>Type</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($holidays as $holiday)
                        <tr>
                            <td>#{{ $holiday->id }}</td>
                            <td><strong>{{ $holiday->name }}</strong></td>
                            <td>{{ $holiday->formatted_date }}</td>
                            <td style="color:#6b6b80;">{{ $holiday->day_name }}</td>
                            <td>
                                <span class="badge-type badge-type-{{ $holiday->type }}">
                                    {{ ucfirst($holiday->type) }}
                                </span>
                            </td>
                            <td>
                                @if($holiday->is_paid)
                                    <span class="badge-paid">Paid</span>
                                @else
                                    <span class="badge-unpaid">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @if($holiday->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <a href="{{ route('hr.holidays.edit', $holiday->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $holiday->id }}').submit();" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $holiday->id }}" action="{{ route('hr.holidays.destroy', $holiday->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('hr.holidays.toggle-status', $holiday->id) }}" class="btn-toggle">
                                        <i class="fas fa-{{ $holiday->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-calendar-day" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No holidays found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $holidays->links() }}
        </div>
    </div>
</div>
@endsection