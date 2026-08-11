<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->orderBy('id', 'desc')->paginate(15);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $role = Role::create($validated);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('module')->orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $role->update($validated);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role with assigned users!');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }

    public function toggleStatus(Role $role)
    {
        $role->is_active = !$role->is_active;
        $role->save();

        $status = $role->is_active ? 'activated' : 'deactivated';
        return redirect()->route('roles.index')->with('success', "Role {$status} successfully!");
    }
}