<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaseRequest;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
{
    /**
     * Display a listing of the leases.
     */
    public function index(Request $request)
    {
        $query = Lease::query();
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('tenant', function($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('unit', function($subQuery) use ($search) {
                    $subQuery->where('unit_number', 'like', "%{$search}%");
                })
                ->orWhereHas('unit.property', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Apply property filter
        if ($request->filled('property_id')) {
            $query->whereHas('unit', function($q) use ($request) {
                $q->where('property_id', $request->property_id);
            });
        }
        
        // Apply date range filter
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }
        
        // Get leases with relations
        $leases = $query->with(['tenant', 'unit.property'])
                        ->latest('start_date')
                        ->paginate(10)
                        ->withQueryString();
        
        // Get properties for filter dropdown
        $properties = Property::orderBy('name')->pluck('name', 'id');
        
        // Get summary statistics
        $activeLeases = Lease::where('status', 'active')->count();
        $expiringLeases = Lease::where('status', 'active')
                            ->whereDate('end_date', '<=', now()->addDays(30))
                            ->count();
        $totalMonthlyRevenue = Lease::where('status', 'active')
                                ->sum('monthly_rent');
        // Calculate average lease length in days - SQLite compatible
        $leases = Lease::whereNotNull('start_date')
                    ->whereNotNull('end_date')
                    ->get();
                    
        $totalDays = 0;
        $leaseCount = count($leases);
        
        foreach ($leases as $lease) {
            $totalDays += $lease->start_date->diffInDays($lease->end_date);
        }
        
        $avgLeaseDays = $leaseCount > 0 ? round($totalDays / $leaseCount) : 0;
        
        return view('admin.leases.index', compact(
            'leases', 
            'properties', 
            'activeLeases', 
            'expiringLeases', 
            'totalMonthlyRevenue',
            'avgLeaseDays'
        ));
    }

    /**
     * Show the form for creating a new lease.
     */
    public function create(Request $request)
    {
        // Get pre-selected tenant or unit if provided
        $selectedTenant = null;
        $selectedUnit = null;
        
        if ($request->filled('tenant_id')) {
            $selectedTenant = Tenant::findOrFail($request->tenant_id);
        }
        
        if ($request->filled('unit_id')) {
            $selectedUnit = Unit::with('property')->findOrFail($request->unit_id);
        }
        
        // Get all available tenants (active without current lease)
        $tenants = Tenant::where('active_status', true)
                        ->orderBy('last_name')
                        ->orderBy('first_name')
                        ->get()
                        ->pluck(DB::raw("first_name || ' ' || last_name"), 'id');
        
        // Get all available units (without active lease)
        $availableUnits = Unit::where('status', 'Available')
                            ->with('property')
                            ->get()
                            ->mapWithKeys(function ($unit) {
                                return [$unit->id => $unit->property->name . ' - Unit ' . $unit->unit_number];
                            });
                            
        return view('admin.leases.create', compact(
            'tenants', 
            'availableUnits', 
            'selectedTenant', 
            'selectedUnit'
        ));
    }

    /**
     * Store a newly created lease in storage.
     */
    public function store(LeaseRequest $request)
    {
        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        
        try {
            // Create the lease
            $lease = Lease::create($request->validated());
            
            // Update unit status to Occupied
            $unit = Unit::findOrFail($request->unit_id);
            $unit->status = 'Occupied';
            $unit->save();
            
            DB::commit();
            
            return redirect()
                ->route('leases.show', $lease)
                ->with('success', 'Lease created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create lease: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified lease.
     */
    public function show(Lease $lease)
    {
        // Load related models
        $lease->load(['tenant', 'unit.property']);
        
        // Calculate lease metrics
        $leaseMetrics = [
            'total_value' => $lease->monthly_rent * $lease->start_date->diffInMonths($lease->end_date),
            'remaining_value' => $lease->status === 'active' 
                ? $lease->monthly_rent * now()->diffInMonths($lease->end_date, false) 
                : 0,
            'elapsed_percentage' => $lease->status === 'active'
                ? (now()->diffInDays($lease->start_date) / $lease->start_date->diffInDays($lease->end_date)) * 100
                : ($lease->status === 'expired' ? 100 : 0),
            'days_elapsed' => $lease->start_date->diffInDays(
                $lease->status === 'active' ? now() : ($lease->status === 'expired' ? $lease->end_date : $lease->start_date)
            ),
            'days_total' => $lease->start_date->diffInDays($lease->end_date),
            'days_remaining' => $lease->status === 'active' ? now()->diffInDays($lease->end_date) : 0
        ];
        
        // Round percentages
        $leaseMetrics['elapsed_percentage'] = min(100, round($leaseMetrics['elapsed_percentage']));
        
        // Get related maintenance records for this unit during this lease
        $maintenanceRecords = $lease->unit->maintenanceRecords()
            ->where(function($query) use ($lease) {
                $query->whereBetween('request_date', [$lease->start_date, $lease->end_date])
                      ->orWhere(function($q) use ($lease) {
                          $q->where('request_date', '>=', $lease->start_date)
                            ->where('status', '!=', 'Completed');
                      });
            })
            ->latest('request_date')
            ->get();
            
        return view('admin.leases.show', compact(
            'lease', 
            'leaseMetrics', 
            'maintenanceRecords'
        ));
    }

    /**
     * Show the form for editing the specified lease.
     */
    public function edit(Lease $lease)
    {
        $lease->load(['tenant', 'unit.property']);
        
        // Get all tenants
        $tenants = Tenant::where('active_status', true)
                        ->orderBy('last_name')
                        ->orderBy('first_name')
                        ->get()
                        ->pluck(DB::raw("first_name || ' ' || last_name"), 'id');
        
        // Get all units, including the current one
        $units = Unit::with('property')
                    ->where(function($query) use ($lease) {
                        $query->where('status', 'Available')
                              ->orWhere('id', $lease->unit_id);
                    })
                    ->get()
                    ->mapWithKeys(function ($unit) {
                        return [$unit->id => $unit->property->name . ' - Unit ' . $unit->unit_number];
                    });
                    
        return view('admin.leases.edit', compact('lease', 'tenants', 'units'));
    }

    /**
     * Update the specified lease in storage.
     */
    public function update(LeaseRequest $request, Lease $lease)
    {
        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        
        try {
            $oldUnitId = $lease->unit_id;
            $newUnitId = $request->unit_id;
            
            // Update the lease
            $lease->update($request->validated());
            
            // Update unit statuses if unit changed
            if ($oldUnitId != $newUnitId) {
                // Set old unit to Available
                $oldUnit = Unit::findOrFail($oldUnitId);
                $oldUnit->status = 'Available';
                $oldUnit->save();
                
                // Set new unit to Occupied
                $newUnit = Unit::findOrFail($newUnitId);
                $newUnit->status = 'Occupied';
                $newUnit->save();
            }
            
            DB::commit();
            
            return redirect()
                ->route('leases.show', $lease)
                ->with('success', 'Lease updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to update lease: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified lease from storage.
     */
    public function destroy(Lease $lease)
    {
        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        
        try {
            // Only allow deletion if lease is not active
            if ($lease->status === 'active') {
                return back()->with('error', 'Cannot delete an active lease. Please terminate the lease first.');
            }
            
            // Store unit ID for reference
            $unitId = $lease->unit_id;
            
            // Delete the lease
            $lease->delete();
            
            // No need to update unit status since lease was not active
            
            DB::commit();
            
            return redirect()
                ->route('leases.index')
                ->with('success', 'Lease deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Failed to delete lease: ' . $e->getMessage());
        }
    }
    
    /**
     * Terminate a lease early.
     */
    public function terminate(Request $request, Lease $lease)
    {
        // Validate request
        $request->validate([
            'termination_date' => 'required|date|after_or_equal:' . $lease->start_date,
            'termination_reason' => 'required|string|max:255',
            'final_inspection_date' => 'nullable|date|after_or_equal:termination_date',
            'security_deposit_returned' => 'nullable|numeric|min:0|max:' . $lease->security_deposit,
            'notes' => 'nullable|string'
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Can only terminate active leases
            if ($lease->status !== 'active') {
                return back()->with('error', 'Can only terminate active leases.');
            }
            
            // Update lease
            $lease->status = 'terminated';
            $lease->end_date = $request->termination_date;
            $lease->termination_reason = $request->termination_reason;
            $lease->move_out_inspection = $request->final_inspection_date;
            $lease->security_deposit_returned = $request->security_deposit_returned;
            $lease->notes = $request->notes;
            $lease->save();
            
            // Update unit status
            $unit = Unit::findOrFail($lease->unit_id);
            $unit->status = 'Available';
            $unit->save();
            
            DB::commit();
            
            return redirect()
                ->route('leases.show', $lease)
                ->with('success', 'Lease terminated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to terminate lease: ' . $e->getMessage());
        }
    }
    
    /**
     * Renew a lease.
     */
    public function renew(Request $request, Lease $lease)
    {
        // Validate request
        $request->validate([
            'new_start_date' => 'required|date|after_or_equal:' . $lease->end_date,
            'new_end_date' => 'required|date|after:new_start_date',
            'new_monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'renewable' => 'boolean',
            'notes' => 'nullable|string'
        ]);
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Can only renew active leases
            if ($lease->status !== 'active') {
                return back()->with('error', 'Can only renew active leases.');
            }
            
            // Mark current lease as expired
            $lease->status = 'renewed';
            $lease->save();
            
            // Create new lease
            $newLease = $lease->replicate();
            $newLease->start_date = $request->new_start_date;
            $newLease->end_date = $request->new_end_date;
            $newLease->monthly_rent = $request->new_monthly_rent;
            $newLease->security_deposit = $request->security_deposit;
            $newLease->renewable = $request->has('renewable');
            $newLease->notes = $request->notes;
            $newLease->status = 'upcoming';
            $newLease->previous_lease_id = $lease->id;
            $newLease->save();
            
            // Unit status remains 'Occupied'
            
            DB::commit();
            
            return redirect()
                ->route('leases.show', $newLease)
                ->with('success', 'Lease renewed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to renew lease: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate lease document.
     */
    public function generateDocument(Lease $lease)
    {
        $lease->load(['tenant', 'unit.property']);
        
        // In a real app, you would generate a PDF using a library like DomPDF
        // For now, we'll just return a view with the lease details
        
        return view('admin.leases.document', compact('lease'));
    }
}