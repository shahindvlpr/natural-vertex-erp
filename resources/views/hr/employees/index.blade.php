@extends('layouts.master')

@section('title', 'Employees - Natural Vertex ERP')
@section('page-title', 'Employees')

@section('content')
<style>
.hr-card { background: #fff; border: 1px solid #e8eaed; }
.hr-card-header { padding: 16px 20px; border-bottom: 1px solid #e8eaed; display: flex; justify-content: space-between; align-items: center; }
.hr-card-title { margin: 0; font-size: 16px; font-weight: 600; }
.hr-card-title i { color: #6c5ce7; margin-right: 8px; }
.hr-card-body { padding: 20px; }
.btn-primary-custom { padding: 8px 16px; background: #6c5ce7; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s; }
.btn-primary-custom:hover { background: #4a3db8; color: #fff; }
.btn-view { padding: 4px 10px; background: #10b981; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-view:hover { background: #059669; }
.btn-edit { padding: 4px 10px; background: #3b82f6; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-edit:hover { background: #2563eb; }
.btn-delete { padding: 4px 10px; background: #ef4444; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-delete:hover { background: #dc2626; }
.btn-toggle { padding: 4px 10px; background: #f59e0b; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-toggle:hover { background: #d97706; }
.badge-active { display: inline-block; padding: 2px 12px; background: #10b981; color: #fff; font-size: 11px; }
.badge-inactive { display: inline-block; padding: 2px 12px; background: #ef4444; color: #fff; font-size: 11px; }
.avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
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
            <i class="fas fa-users"></i> Employees
        </h5>
        <a href="{{ route('hr.employees.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Add Employee
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
                        <th>Employee</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>#{{ $employee->id }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}" class="avatar">
                                    <span><strong>{{ $employee->full_name }}</strong></span>
                                </div>
                            </td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->department->name ?? 'N/A' }}</td>
                            <td>{{ $employee->designation->name ?? 'N/A' }}</td>
                            <td>
                                @if($employee->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:4px; justify-content:center;">
                                    <a href="{{ route('hr.employees.show', $employee->id) }}" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('hr.employees.edit', $employee->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $employee->id }}').submit();" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $employee->id }}" action="{{ route('hr.employees.destroy', $employee->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('hr.employees.toggle-status', $employee->id) }}" class="btn-toggle">
                                        <i class="fas fa-{{ $employee->is_active ? 'pause' : 'play' }}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-users" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No employees found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection