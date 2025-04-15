<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserLeaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get search query parameters
        $search = $request->input('search');
        $status = $request->input('status');
        
        // Start with a base query
        $query = Lease::with(['tenant', 'tenant.property']);
        
        // Apply search filters if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('lease_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('tenant', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('tenant.property', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Apply status filter if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Paginate the results (10 items per page)
        $leases = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Get all possible statuses for the filter dropdown
        $statuses = ['active', 'inactive', 'terminated', 'expired'];
        
        return view('user.leases.index', compact('leases', 'statuses', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::where('status', 'active')->with('property')->get();
        return view('user.leases.create', compact('tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'required|string|max:255',
            'permitted_use' => 'required|string|max:255',
            'option_to_renew' => 'boolean',
            'term_years' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'base_rate_year_1' => 'required|numeric|min:0',
            'monthly_gsto_year_1' => 'required|numeric|min:0',
            'base_rate_year_2' => 'required|numeric|min:0',
            'monthly_gsto_year_2' => 'required|numeric|min:0',
            'base_rate_year_3' => 'required|numeric|min:0',
            'monthly_gsto_year_3' => 'required|numeric|min:0',
            'space' => 'required|numeric|min:0',
            'tenancy_type' => 'nullable|string|max:255',
            'attachment' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,active,inactive,expired'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lease = Lease::create($request->all());

        return redirect()->route('leases-info.show', $lease)
            ->with('success', 'Lease created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lease $leases_info)
    {
        $lease = $leases_info;
        $lease->load(['tenant', 'tenant.property']);
        return view('user.leases.show', compact('lease'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lease $leases_info)
    {
        $lease = $leases_info;
        $tenants = Tenant::where('status', 'active')->with('property')->get();
        return view('user.leases.edit', compact('lease', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lease $leases_info)
    {
        $lease = $leases_info;
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'required|string|max:255',
            'permitted_use' => 'required|string|max:255',
            'option_to_renew' => 'boolean',
            'term_years' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'base_rate_year_1' => 'required|numeric|min:0',
            'monthly_gsto_year_1' => 'required|numeric|min:0',
            'base_rate_year_2' => 'required|numeric|min:0',
            'monthly_gsto_year_2' => 'required|numeric|min:0',
            'base_rate_year_3' => 'required|numeric|min:0',
            'monthly_gsto_year_3' => 'required|numeric|min:0',
            'space' => 'required|numeric|min:0',
            'tenancy_type' => 'nullable|string|max:255',
            'attachment' => 'nullable|string|max:255',
            'status' => 'required|string|in:pending,active,inactive,expired'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lease->update($request->all());

        return redirect()->route('leases-info.show', $lease)
            ->with('success', 'Lease updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lease $leases_info)
    {
        $lease = $leases_info;
        $lease->delete();

        return redirect()->route('leases-info.index')
            ->with('success', 'Lease deleted successfully.');
    }

    /**
     * Update the lease status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Lease $lease)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive,terminated,expired',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lease->update([
            'status' => $request->status
        ]);

        return redirect()->back()
            ->with('success', 'Lease status updated successfully.');
    }

    /**
     * Display leases expiring within a specific timeframe.
     *
     * @return \Illuminate\Http\Response
     */
    public function expiringLeases(Request $request)
    {
        $search = $request->input('search');
        
        $query = Lease::with(['tenant', 'tenant.property'])
            ->where('status', 'active')
            ->where('end_date', '<=', now()->addMonths(3))
            ->where('end_date', '>=', now());
            
        // Apply search if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('lease_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('tenant', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('tenant.property', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $expiringLeases = $query->orderBy('end_date')->paginate(10)->withQueryString();

        return view('user.leases.expiring', compact('expiringLeases', 'search'));
    }
}