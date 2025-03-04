<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    /**
     * Display a listing of the leases.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $leases = Lease::with('tenant')->paginate(10);
        
        return view('admin.leases.index', compact('leases'));
    }

    /**
     * Show the form for creating a new lease.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tenants = Tenant::where('status', 'active')->get();
        
        return view('admin.leases.create', compact('tenants'));
    }

    /**
     * Store a newly created lease in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'required|string|max:255',
            'permitted_use' => 'required|string|max:255',
            'rental_amount' => 'required|numeric|min:0',
            'rental_frequency' => 'required|string|max:255',
            'option_to_renew' => 'boolean',
            'term_years' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string|in:active,inactive'
        ]);

        Lease::create($request->all());
        
        return redirect()->route('leases.index')
            ->with('success', 'Lease created successfully');
    }

    /**
     * Display the specified lease.
     *
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\View\View
     */
    public function show(Lease $lease)
    {
        $lease->load('tenant.property');
        
        return view('admin.leases.show', compact('lease'));
    }

    /**
     * Show the form for editing the specified lease.
     *
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\View\View
     */
    public function edit(Lease $lease)
    {
        $tenants = Tenant::where('status', 'active')->get();
        
        return view('admin.leases.edit', compact('lease', 'tenants'));
    }

    /**
     * Update the specified lease in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lease $lease)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'required|string|max:255',
            'permitted_use' => 'required|string|max:255',
            'rental_amount' => 'required|numeric|min:0',
            'rental_frequency' => 'required|string|max:255',
            'option_to_renew' => 'boolean',
            'term_years' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string|in:active,inactive'
        ]);

        $lease->update($request->all());
        
        return redirect()->route('leases.index')
            ->with('success', 'Lease updated successfully');
    }

    /**
     * Remove the specified lease from storage.
     *
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lease $lease)
    {
        $lease->delete();
        
        return redirect()->route('leases.index')
            ->with('success', 'Lease deleted successfully');
    }
}