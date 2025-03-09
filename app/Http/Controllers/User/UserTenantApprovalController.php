<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserTenantApprovalController extends Controller
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
        $query = Tenant::with(['property', 'leases' => function ($q) {
            $q->latest('start_date');
        }]);
        
        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('contact_person', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
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
        
        // Get all statuses for the filter dropdown
        $statuses = Tenant::distinct()->pluck('status')->toArray();
        
        // Paginate the results (10 items per page)
        $tenants = $query->orderBy('name')->paginate(10)->withQueryString();
        
        // Get all properties for the filter dropdown
        $properties = Property::where('status', 'active')->orderBy('name')->get();
        
        return view('user.tenants.index', compact('tenants', 'properties', 'statuses', 'search', 'status', 'property', 'expiringSoon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->orderBy('name')->get();
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
            'approval_status' => 'nullable|string|max:50',
            'last_approval_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            $tenant = Tenant::create($request->all());
            
            DB::commit();
            
            return redirect()->route('tenants-info.show', $tenant)
                ->with('success', 'Tenant created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create tenant: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        $tenant->load([
            'property', 
            'leases' => function ($query) {
                $query->orderBy('start_date', 'desc');
            }
        ]);
        
        // Get lease expiry information
        $currentLease = $tenant->leases->first();
        $daysToExpiry = null;
        $expiryStatus = null;
        
        if ($currentLease && $currentLease->end_date) {
            $daysToExpiry = now()->diffInDays($currentLease->end_date, false);
            
            if ($daysToExpiry < 0) {
                $expiryStatus = 'expired';
            } elseif ($daysToExpiry <= 30) {
                $expiryStatus = 'critical';
            } elseif ($daysToExpiry <= 90) {
                $expiryStatus = 'warning';
            } else {
                $expiryStatus = 'good';
            }
        }
        
        return view('user.tenants.show', compact('tenant', 'daysToExpiry', 'expiryStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        $properties = Property::where('status', 'active')->orderBy('name')->get();
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
            'approval_status' => 'nullable|string|max:50',
            'last_approval_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            $tenant->update($request->all());
            
            DB::commit();
            
            return redirect()->route('tenants-info.show', $tenant)
                ->with('success', 'Tenant updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update tenant: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenants_info)
    {
        $tenant = $tenants_info;
        
        try {
            DB::beginTransaction();
            
            // Check if tenant has associated leases before hard deleting
            if ($tenant->leases()->count() > 0) {
                // Use soft delete if there are associated leases
                $tenant->delete();
                DB::commit();
                return redirect()->route('tenants-info.index')
                    ->with('success', 'Tenant has been archived.');
            }

            // Hard delete if no associated records
            $tenant->forceDelete();
            
            DB::commit();
            
            return redirect()->route('tenants-info.index')
                ->with('success', 'Tenant has been permanently deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete tenant: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Display a list of tenants with expiring leases.
     */
    public function expiringLeases()
    {
        $threeMonthsFromNow = now()->addMonths(3);
        
        $tenants = Tenant::with(['property', 'leases'])
            ->where('expiry_date', '<=', $threeMonthsFromNow)
            ->where('expiry_date', '>=', now())
            ->where('status', 'active')
            ->orderBy('expiry_date')
            ->paginate(10);
            
        return view('user.tenants.expiring', compact('tenants'));
    }
    
    /**
     * Update tenant approval status.
     */
    public function updateApprovalStatus(Request $request, Tenant $tenant)
    {
        $validator = Validator::make($request->all(), [
            'approval_status' => 'required|string|max:50',
            'last_approval_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            $tenant->update([
                'approval_status' => $request->approval_status,
                'last_approval_date' => $request->last_approval_date ?? now(),
            ]);
            
            DB::commit();
            
            return redirect()->route('tenants-info.show', $tenant)
                ->with('success', 'Tenant approval status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update tenant approval status: ' . $e->getMessage()]);
        }
    }
}