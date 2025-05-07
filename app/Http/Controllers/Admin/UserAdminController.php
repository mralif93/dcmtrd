<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('permissions');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('role', 'like', '%' . $searchTerm . '%')
                  ->orWhere('job_title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('department', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        // Filter by job_title
        if ($request->has('job_title') && $request->job_title != '') {
            $query->where('job_title', $request->job_title);
        }
        
        // Filter by department
        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }

        // Filter by permission
        if ($request->has('permission') && $request->permission != '') {
            if ($request->permission == 'all') {
                // Find users with multiple permissions
                $query->has('permissions', '>=', 2);
            } else {
                // Find users with the specific permission
                $query->whereHas('permissions', function($q) use ($request) {
                    $q->where('name', strtoupper($request->permission));
                });
            }
        }
        
        // Pagination with sorting
        $perPage = 10; // Default items per page
        $users = $query->orderBy('name')->paginate($perPage)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.users.create', compact('permissions'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user,maker,approval,approver,compliance,legal,sales',
            'job_title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'office_location' => 'nullable|string|max:255',
            'permissions' => 'present|array',
            'permissions.*' => 'nullable|in:dcmtrd,reits,legal,compliance,sales',
            'two_factor_enabled' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'job_title' => $request->job_title,
            'department' => $request->department,
            'office_location' => $request->office_location,
            'two_factor_enabled' => $request->has('two_factor_enabled'),
        ]);

        // Attach permissions
        $permissions = collect($request->permissions)->filter()->values();
        
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', strtoupper($permissionName))->first();
            if ($permission) {
                $user->permissions()->attach($permission->id);
            }
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('permissions');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('permissions');
        $permissions = Permission::all();
        return view('admin.users.edit', compact('user', 'permissions'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'required|string|in:admin,user,maker,approval,approver,legal,compliance,sales',
            'job_title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'office_location' => 'nullable|string|max:255',
            'permissions' => 'present|array',
            'permissions.*' => 'nullable|in:dcmtrd,reits,legal,compliance,sales',
            'password' => 'nullable|string|min:8|confirmed',
            'two_factor_enabled' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'job_title' => $request->job_title,
            'department' => $request->department,
            'office_location' => $request->office_location,
            'two_factor_enabled' => $request->has('two_factor_enabled'),
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update permissions - first detach all existing permissions
        $user->permissions()->detach();
        
        // Then attach the new ones
        $permissions = collect($request->permissions ?? [])->filter()->values();

        // dd($permissions);
                
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('short_name', strtoupper($permissionName))->first();
            if ($permission) {
                $user->permissions()->attach($permission->id);
            }
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
    
    /**
     * Toggle two-factor authentication for a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleTwoFactor(User $user)
    {
        $user->update([
            'two_factor_enabled' => !$user->two_factor_enabled,
        ]);
        
        $status = $user->two_factor_enabled ? 'enabled' : 'disabled';
        
        return redirect()->back()
            ->with('success', "Two-factor authentication {$status} successfully");
    }
}