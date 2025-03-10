<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionUserController extends Controller
{
    /**
     * Display a listing of user permissions.
     */
    public function index(): View
    {
        $permissionUsers = PermissionUser::with(['user', 'permission'])->paginate(10);
        
        return view('admin.permission-users.index', compact('permissionUsers'));
    }

    /**
     * Show the form for creating a new permission assignment.
     */
    public function create(): View
    {
        $users = User::all(['id', 'name', 'email']);
        $permissions = Permission::all(['id', 'name', 'full_name']);
        
        return view('admin.permission-users.create', compact('users', 'permissions'));
    }

    /**
     * Store a newly created permission assignment in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        // Check if already exists to avoid duplicate primary key error
        $exists = PermissionUser::where('user_id', $validated['user_id'])
            ->where('permission_id', $validated['permission_id'])
            ->exists();
            
        if (!$exists) {
            PermissionUser::create($validated);
            return redirect()->route('permission-users.index')
                ->with('success', 'Permission assigned successfully');
        }

        return redirect()->route('permission-users.index')
            ->with('error', 'This permission has already been assigned to the user');
    }

    /**
     * Display the specified permission assignment.
     */
    public function show(string $id): View
    {
        $permissionUser = PermissionUser::with(['user', 'permission'])->findOrFail($id);
        
        return view('admin.permission-users.show', compact('permissionUser'));
    }

    /**
     * Show the form for editing the specified permission assignment.
     */
    public function edit(string $id): View
    {
        $permissionUser = PermissionUser::findOrFail($id);
        $users = User::all(['id', 'name', 'email']);
        $permissions = Permission::all(['id', 'name', 'full_name']);
        
        return view('admin.permission-users.edit', compact('permissionUser', 'users', 'permissions'));
    }

    /**
     * Update the specified permission assignment in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $permissionUser = PermissionUser::findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        // Check if the update would create a duplicate
        if ($permissionUser->user_id != $validated['user_id'] || 
            $permissionUser->permission_id != $validated['permission_id']) {
            
            $exists = PermissionUser::where('user_id', $validated['user_id'])
                ->where('permission_id', $validated['permission_id'])
                ->exists();
                
            if ($exists) {
                return redirect()->route('permission-users.edit', $id)
                    ->with('error', 'This permission has already been assigned to the user');
            }
        }

        $permissionUser->update($validated);
        
        return redirect()->route('permission-users.index')
            ->with('success', 'Permission assignment updated successfully');
    }

    /**
     * Remove the specified permission assignment from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $permissionUser = PermissionUser::findOrFail($id);
        $permissionUser->delete();
        
        return redirect()->route('permission-users.index')
            ->with('success', 'Permission assignment deleted successfully');
    }

    /**
     * Show a list of permissions for a specific user.
     */
    public function userPermissions(string $userId): View
    {
        $user = User::findOrFail($userId);
        $permissionUsers = PermissionUser::with('permission')
            ->where('user_id', $userId)
            ->paginate(10);
            
        return view('admin.permission-users.user-permissions', compact('user', 'permissionUsers'));
    }

    /**
     * Show a list of users with a specific permission.
     */
    public function permissionUsers(string $permissionId): View
    {
        $permission = Permission::findOrFail($permissionId);
        $permissionUsers = PermissionUser::with('user')
            ->where('permission_id', $permissionId)
            ->paginate(10);
            
        return view('admin.permission-users.permission-users', compact('permission', 'permissionUsers'));
    }
}