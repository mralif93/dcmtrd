<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get search and filter parameters
        $search = $request->input('search');
        $status = $request->input('status');
        $property = $request->input('property_id');
        $expiringSoon = $request->has('expiring_soon');
        
        // Start with a base query
        $query = Tenant::with('property');
        
        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('contact_person', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereHas('property', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Apply status filter if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Apply property filter if provided
        if ($property) {
            $query->where('property_id', $property);
        }
        
        // Apply expiring soon filter if selected
        if ($expiringSoon) {
            $threeMonthsFromNow = now()->addMonths(3);
            $query->where('expiry_date', '<=', $threeMonthsFromNow)
                  ->where('expiry_date', '>=', now())
                  ->where('status', 'active');
        }
        
        // Paginate the results (10 items per page)
        $tenants = $query->orderBy('name')->paginate(10)->withQueryString();
        
        // Get all properties for the filter dropdown
        $properties = Property::where('status', 'active')->get();
        
        return view('user.tenants.index', compact('tenants', 'properties', 'search', 'status', 'property', 'expiringSoon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        return view('user.tenants.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'commencement_date' => 'required|date',
            'expiry_date' => 'required|date|after:commencement_date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tenant = Tenant::create($request->all());

        return redirect()->route('tenants-info.show', $tenant)
            ->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        $tenant->load('property', 'leases');
        return view('user.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        $properties = Property::where('status', 'active')->get();
        return view('user.tenants.edit', compact('tenant', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'commencement_date' => 'required|date',
            'expiry_date' => 'required|date|after:commencement_date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tenant->update($request->all());

        return redirect()->route('tenants-info.show', $tenant)
            ->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        
        // Check if tenant has associated leases before hard deleting
        if ($tenant->leases()->count() > 0) {
            // Use soft delete if there are associated leases
            $tenant->delete();
            return redirect()->route('tenants-info.index')
                ->with('success', 'Tenant has been archived.');
        }

        // Hard delete if no associated records
        $tenant->forceDelete();
        return redirect()->route('tenants-info.index')
            ->with('success', 'Tenant has been permanently deleted.');
    }
}