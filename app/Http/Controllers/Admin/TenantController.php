<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the tenants.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tenants = Tenant::with('property')->paginate(10);
        
        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new tenant.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        
        return view('admin.tenants.create', compact('properties'));
    }

    /**
     * Store a newly created tenant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'commencement_date' => 'required|date',
            'expiry_date' => 'required|date|after:commencement_date',
            'status' => 'required|string|in:active,inactive'
        ]);

        Tenant::create($request->all());
        
        return redirect()->route('tenants.index')
            ->with('success', 'Tenant created successfully');
    }

    /**
     * Display the specified tenant.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\View\View
     */
    public function show(Tenant $tenant)
    {
        $tenant->load('property', 'leases');
        
        return view('admin.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified tenant.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\View\View
     */
    public function edit(Tenant $tenant)
    {
        $properties = Property::where('status', 'active')->get();
        
        return view('admin.tenants.edit', compact('tenant', 'properties'));
    }

    /**
     * Update the specified tenant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'commencement_date' => 'required|date',
            'expiry_date' => 'required|date|after:commencement_date',
            'status' => 'required|string|in:active,inactive'
        ]);

        $tenant->update($request->all());
        
        return redirect()->route('tenants.index')
            ->with('success', 'Tenant updated successfully');
    }

    /**
     * Remove the specified tenant from storage.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tenant $tenant)
    {
        // Check if the tenant has any leases before deleting
        if ($tenant->leases()->count() > 0) {
            return redirect()->route('tenants.index')
                ->with('error', 'Cannot delete tenant because it has associated leases');
        }
        
        $tenant->delete();
        
        return redirect()->route('tenants.index')
            ->with('success', 'Tenant deleted successfully');
    }
}