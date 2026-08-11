<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'desc')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('is_active', true)->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $user = User::create($validated);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $user->logActivity('create', 'users', null, $user->toArray(), 'User created');

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::where('is_active', true)->get();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $oldData = $user->toArray();
        $user->update($validated);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        $user->logActivity('update', 'users', $oldData, $user->toArray(), 'User updated');

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account!');
        }

        $user->logActivity('delete', 'users', $user->toArray(), null, 'User deleted');
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot change your own status!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        $user->logActivity('toggle_status', 'users', null, ['is_active' => $user->is_active], "User {$status}");

        return redirect()->route('users.index')->with('success', "User {$status} successfully!");
    }
}