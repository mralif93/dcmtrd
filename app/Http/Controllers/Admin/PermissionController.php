<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Permission::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('short_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('full_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Pagination with sorting
        $perPage = 10; // Default items per page
        $permissions = $query->orderBy('name')->paginate($perPage)->withQueryString();
        
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
            'short_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Permission::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'full_name' => $request->full_name,
            'description' => $request->description,
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        // Get users with this permission
        $users = User::whereRaw("FIND_IN_SET(?, permission)", [$permission->name])
            ->orWhereRaw("permission LIKE ?", ['%' . $permission->name . '%'])
            ->paginate(10);
            
        return view('admin.permissions.show', compact('permission', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id),
            ],
            'short_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store the old permission name for user updates
        $oldName = $permission->name;
        $newName = $request->name;

        $permission->update([
            'name' => $newName,
            'short_name' => $request->short_name,
            'full_name' => $request->full_name,
            'description' => $request->description,
        ]);

        // If the permission name changed, update all users that have this permission
        if ($oldName !== $newName) {
            $users = User::whereRaw("FIND_IN_SET(?, permission)", [$oldName])
                ->orWhereRaw("permission LIKE ?", ['%' . $oldName . '%'])
                ->get();

            foreach ($users as $user) {
                $permissions = $user->getPermissionsArray();
                $key = array_search($oldName, $permissions);
                
                if ($key !== false) {
                    $permissions[$key] = $newName;
                    $user->setPermissions($permissions);
                }
            }
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        // Remove this permission from all users who have it
        $users = User::whereRaw("FIND_IN_SET(?, permission)", [$permission->name])
            ->orWhereRaw("permission LIKE ?", ['%' . $permission->name . '%'])
            ->get();

        foreach ($users as $user) {
            $user->removePermission($permission->name);
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }

    /**
     * Assign permission to multiple users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function assignUsers(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->user_ids as $userId) {
            $user = User::find($userId);
            if ($user) {
                $user->addPermission($permission->name);
            }
        }

        return redirect()->route('permissions.show', $permission)
            ->with('success', 'Permission assigned to users successfully');
    }

    /**
     * Remove permission from a user.
     *
     * @param  \App\Models\Permission  $permission
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function removeUser(Permission $permission, User $user)
    {
        $user->removePermission($permission->name);

        return redirect()->route('permissions.show', $permission)
            ->with('success', 'Permission removed from user successfully');
    }
}