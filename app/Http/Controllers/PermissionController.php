<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::withCount('roles')->orderBy('module')->orderBy('name')->paginate(20);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $modules = $this->getModules();
        return view('permissions.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'module' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Permission::create($validated);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully!');
    }

    public function edit(Permission $permission)
    {
        $modules = $this->getModules();
        return view('permissions.edit', compact('permission', 'modules'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'module' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $permission->update($validated);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully!');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permissions.index')->with('error', 'Cannot delete permission assigned to roles!');
        }

        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully!');
    }

    private function getModules()
    {
        return [
            'dashboard' => 'Dashboard',
            'users' => 'User Management',
            'roles' => 'Roles',
            'permissions' => 'Permissions',
            'company' => 'Company Settings',
            'hr' => 'HR',
            'attendance' => 'Attendance',
            'payroll' => 'Payroll',
            'inventory' => 'Inventory',
            'warehouse' => 'Warehouse',
            'procurement' => 'Procurement',
            'supplier' => 'Supplier',
            'production' => 'Production',
            'sales' => 'Sales',
            'customer' => 'Customer',
            'delivery' => 'Delivery',
            'accounts' => 'Accounts',
            'expense' => 'Expense',
            'banking' => 'Banking',
            'reports' => 'Reports',
            'settings' => 'Settings',
        ];
    }
}