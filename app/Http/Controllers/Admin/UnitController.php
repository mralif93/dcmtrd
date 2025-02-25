<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;
use App\Models\Unit;
use App\Models\Property;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the units.
     */
    public function index(Request $request)
    {
        $query = Unit::query();
        
        // Apply property filter
        if ($request->has('property_id') && !empty($request->property_id)) {
            $query->where('property_id', $request->property_id);
        }
        
        // Apply unit type filter
        if ($request->has('unit_type') && !empty($request->unit_type)) {
            $query->where('unit_type', $request->unit_type);
        }
        
        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Apply search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('unit_number', 'like', '%' . $request->search . '%');
        }
        
        $units = $query->with(['property', 'currentLease', 'currentTenant'])
                       ->latest()
                       ->paginate(10);
        
        // Get all properties for filter dropdown
        $properties = Property::pluck('name', 'id');
        
        // Unit types for filter dropdown
        $unitTypes = [
            'Studio' => 'Studio',
            '1BR' => '1 Bedroom',
            '2BR' => '2 Bedrooms',
            '3BR' => '3 Bedrooms',
            '4BR+' => '4+ Bedrooms'
        ];
        
        // Statuses for filter dropdown
        $statuses = [
            'Available' => 'Available',
            'Occupied' => 'Occupied',
            'Maintenance' => 'Under Maintenance'
        ];
        
        return view('admin.units.index', compact('units', 'properties', 'unitTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create(Request $request)
    {
        $properties = Property::pluck('name', 'id');
        $selectedProperty = $request->has('property_id') ? $request->property_id : null;
        
        return view('admin.units.create', compact('properties', 'selectedProperty'));
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->validated());
        
        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Unit created successfully');
    }

    /**
     * Display the specified unit.
     */
    public function show(Unit $unit)
    {
        // Load related data
        $unit->load([
            'property',
            'currentLease' => function($query) {
                $query->with('tenant');
            },
            'leases' => function($query) {
                $query->with('tenant')->latest()->take(5);
            },
            'maintenanceRecords' => function($query) {
                $query->latest()->take(5);
            }
        ]);
        
        // Calculate financials
        $financials = $this->calculateFinancials($unit);
        
        return view('admin.units.show', compact('unit', 'financials'));
    }

    /**
     * Show the form for editing the specified unit.
     */
    public function edit(Unit $unit)
    {
        $properties = Property::pluck('name', 'id');
        
        return view('admin.units.edit', compact('unit', 'properties'));
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        
        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Unit updated successfully');
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy(Unit $unit)
    {
        // Check if unit has leases
        $leasesCount = $unit->leases()->count();
        
        if ($leasesCount > 0) {
            return redirect()
                ->route('units.show', $unit)
                ->with('error', 'Cannot delete unit with leases. Please delete all leases first.');
        }
        
        $unit->delete();
        
        return redirect()
            ->route('units.index')
            ->with('success', 'Unit deleted successfully');
    }
    
    /**
     * Display maintenance history for the unit.
     */
    public function maintenanceHistory(Unit $unit)
    {
        $unit->load(['property']);
        
        $maintenanceRecords = $unit->maintenanceRecords()
                                  ->with('property')
                                  ->latest()
                                  ->paginate(15);
        
        return view('admin.units.maintenance-history', compact('unit', 'maintenanceRecords'));
    }
    
    /**
     * Display lease history for the unit.
     */
    public function leaseHistory(Unit $unit)
    {
        $unit->load(['property']);
        
        $leases = $unit->leases()
                     ->with('tenant')
                     ->latest()
                     ->paginate(15);
        
        return view('admin.units.lease-history', compact('unit', 'leases'));
    }
    
    /**
     * Calculate financial metrics for a unit.
     */
    private function calculateFinancials(Unit $unit)
    {
        $financials = [
            'monthly_rent' => $unit->currentLease ? $unit->currentLease->monthly_rent : $unit->base_rent,
            'annual_rent' => $unit->currentLease ? $unit->currentLease->monthly_rent * 12 : $unit->base_rent * 12,
            'rent_per_sqft' => 0,
            'occupancy_rate' => 0,
            'vacancy_days' => 0,
        ];
        
        // Calculate rent per square foot
        if ($unit->square_footage > 0) {
            $financials['rent_per_sqft'] = $financials['monthly_rent'] / $unit->square_footage;
        }
        
        // Calculate occupancy rate based on lease history
        $totalDays = 365; // Last year
        $leases = $unit->leases()
                      ->where('start_date', '<=', now())
                      ->where(function($query) {
                          $query->where('end_date', '>=', now()->subYear())
                                ->orWhere('status', 'Active');
                      })
                      ->get();
        
        $occupiedDays = 0;
        $now = now();
        $yearAgo = now()->subYear();
        
        foreach ($leases as $lease) {
            $leaseStart = $lease->start_date > $yearAgo ? $lease->start_date : $yearAgo;
            $leaseEnd = $lease->status == 'Active' ? $now : $lease->end_date;
            
            if ($leaseEnd > $yearAgo) {
                $occupiedDays += $leaseStart->diffInDays($leaseEnd);
            }
        }
        
        $financials['occupancy_rate'] = min(100, round(($occupiedDays / $totalDays) * 100, 1));
        $financials['vacancy_days'] = $totalDays - $occupiedDays;
        
        return $financials;
    }
    
    /**
     * Set unit's status to Available.
     */
    public function markAvailable(Unit $unit)
    {
        $unit->update(['status' => 'Available']);
        
        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Unit marked as Available');
    }
    
    /**
     * Set unit's status to Maintenance.
     */
    public function markMaintenance(Unit $unit)
    {
        $unit->update(['status' => 'Maintenance']);
        
        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Unit marked as Under Maintenance');
    }
}
