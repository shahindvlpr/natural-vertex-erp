@extends('layouts.master')

@section('title', 'Audit Logs - Natural Vertex ERP')
@section('page-title', 'Audit Logs')

@section('content')
<div style="background:#fff; border:1px solid #e8eaed;">
    <div style="padding:16px 20px; border-bottom:1px solid #e8eaed; display:flex; justify-content:space-between; align-items:center;">
        <h5 style="margin:0; font-size:16px; font-weight:600;">
            <i class="fas fa-history" style="color:#6c5ce7;"></i> Audit Logs
        </h5>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('audit.export') }}" style="padding:8px 16px; background:#10b981; color:#fff; text-decoration:none; font-size:13px; font-weight:500;">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
    </div>

    <div style="padding:20px;">
        <!-- Filter -->
        <div style="margin-bottom:16px; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
            <form action="{{ route('audit.index') }}" method="GET" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <select name="module" style="padding:8px 14px; border:1px solid #e8eaed; font-size:13px; background:#fff;">
                    <option value="">All Modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                            {{ ucfirst($module) }}
                        </option>
                    @endforeach
                </select>

                <select name="action" style="padding:8px 14px; border:1px solid #e8eaed; font-size:13px; background:#fff;">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" 
                       style="padding:8px 14px; border:1px solid #e8eaed; font-size:13px; min-width:200px;">

                <button type="submit" style="padding:8px 16px; background:#6c5ce7; color:#fff; border:none; cursor:pointer; font-size:13px;">
                    <i class="fas fa-filter"></i> Filter
                </button>

                @if(request('module') || request('action') || request('search'))
                    <a href="{{ route('audit.index') }}" style="padding:8px 16px; background:#e8eaed; color:#4a4a5a; text-decoration:none; font-size:13px;">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fa; border-bottom:2px solid #e8eaed;">
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">ID</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">User</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Action</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Module</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Description</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">IP</th>
                        <th style="padding:10px 12px; text-align:left; font-size:12px; font-weight:600; color:#4a4a5a;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr style="border-bottom:1px solid #e8eaed;">
                            <td style="padding:10px 12px; font-size:13px;">#{{ $log->id }}</td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <strong>{{ $log->user->name ?? 'System' }}</strong>
                            </td>
                            <td style="padding:10px 12px; font-size:13px;">
                                <span style="display:inline-block; padding:2px 10px; 
                                    @if($log->action == 'login') background:#10b981; color:#fff;
                                    @elseif($log->action == 'logout') background:#f59e0b; color:#fff;
                                    @elseif($log->action == 'create') background:#3b82f6; color:#fff;
                                    @elseif($log->action == 'update') background:#8b5cf6; color:#fff;
                                    @elseif($log->action == 'delete') background:#ef4444; color:#fff;
                                    @else background:#6b7280; color:#fff; @endif
                                    font-size:11px;">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td style="padding:10px 12px; font-size:13px; color:#6b6b80;">{{ ucfirst($log->module) }}</td>
                            <td style="padding:10px 12px; font-size:13px;">{{ $log->description ?? '-' }}</td>
                            <td style="padding:10px 12px; font-size:13px; color:#6b6b80;">{{ $log->ip_address ?? '-' }}</td>
                            <td style="padding:10px 12px; font-size:13px; color:#6b6b80;">
                                {{ $log->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:30px; text-align:center; color:#6b6b80; font-size:14px;">
                                <i class="fas fa-history" style="font-size:24px; display:block; margin-bottom:8px; color:#e8eaed;"></i>
                                No logs found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection