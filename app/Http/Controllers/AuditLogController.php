<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('id', 'desc');

        // Filter by module
        if ($request->has('module') && $request->module != '') {
            $query->where('module', $request->module);
        }

        // Filter by action
        if ($request->has('action') && $request->action != '') {
            $query->where('action', $request->action);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20);
        
        // Get unique modules for filter
        $modules = AuditLog::distinct()->pluck('module');
        $actions = AuditLog::distinct()->pluck('action');

        return view('audit.index', compact('logs', 'modules', 'actions'));
    }

    public function show(AuditLog $log)
    {
        return view('audit.show', compact('log'));
    }

    public function export()
    {
        // Export logs to CSV/Excel
        return redirect()->route('audit.index')->with('info', 'Export feature coming soon!');
    }
}