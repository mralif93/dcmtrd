<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Portfolio;
use App\Models\Unit;
use App\Http\Requests\Admin\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $query = Property::query();
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }
        
        // Apply portfolio filter
        if ($request->has('portfolio_id') && !empty($request->portfolio_id)) {
            $query->where('portfolio_id', $request->portfolio_id);
        }
        
        // Apply property type filter
        if ($request->has('property_type') && !empty($request->property_type)) {
            $query->where('property_type', $request->property_type);
        }
        
        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Get properties with their relations
        $properties = $query->with(['portfolio'])
                            ->withCount('units')
                            ->latest()
                            ->paginate(10);
        
        // Get all portfolios for the filter dropdown
        $portfolios = Portfolio::pluck('name', 'id');
        
        // Property types for the filter dropdown
        $propertyTypes = [
            'Apartment' => 'Apartment',
            'Office' => 'Office',
            'Retail' => 'Retail',
            'Mixed-Use' => 'Mixed-Use'
        ];
        
        // Statuses for the filter dropdown
        $statuses = [
            'Active' => 'Active',
            'Under Renovation' => 'Under Renovation',
            'For Sale' => 'For Sale'
        ];
        
        return view('admin.properties.index', compact(
            'properties', 
            'portfolios', 
            'propertyTypes', 
            'statuses'
        ));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create(Request $request)
    {
        $portfolios = Portfolio::pluck('name', 'id');
        $selectedPortfolio = $request->has('portfolio_id') ? $request->portfolio_id : null;
        
        return view('admin.properties.create', compact('portfolios', 'selectedPortfolio'));
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(PropertyRequest $request)
    {
        $property = Property::create($request->validated());
        
        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Property created successfully');
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        // Load related data
        $property->load([
            'portfolio', 
            'units' => function($query) {
                $query->withCount('leases');
            },
            'maintenanceRecords' => function($query) {
                $query->latest()->take(5);
            }
        ]);
        
        // Calculate vacancy data
        $totalUnits = $property->units->count();
        $vacantUnits = $property->units->where('status', 'Available')->count();
        $occupiedUnits = $property->units->where('status', 'Occupied')->count();
        $maintenanceUnits = $property->units->where('status', 'Maintenance')->count();
        
        $vacancyData = [
            'total_units' => $totalUnits,
            'vacant_units' => $vacantUnits,
            'occupied_units' => $occupiedUnits,
            'under_maintenance' => $maintenanceUnits
        ];
        
        // Calculate upcoming lease expirations
        $upcomingExpirations = 0;
        foreach ($property->units as $unit) {
            if ($unit->currentLease && $unit->currentLease->end_date->diffInDays(now()) <= 60) {
                $upcomingExpirations++;
            }
        }
        $vacancyData['upcoming_expirations'] = $upcomingExpirations;
        
        // Calculate financials
        $monthlyRevenue = 0;
        $monthlyExpenses = 0;
        foreach ($property->units as $unit) {
            if ($unit->currentLease) {
                $monthlyRevenue += $unit->currentLease->monthly_rent;
            }
        }
        
        // Estimate monthly expenses (in a real app, would come from actual expense records)
        $monthlyExpenses = $property->annual_property_tax / 12 + $property->insurance_cost / 12;
        $monthlyExpenses += $monthlyRevenue * 0.2; // Estimated 20% of revenue for maintenance, utilities, etc.
        
        $financialData = [
            'monthly_revenue' => $monthlyRevenue,
            'monthly_expenses' => $monthlyExpenses,
            'monthly_noi' => $monthlyRevenue - $monthlyExpenses,
            'annual_noi' => ($monthlyRevenue - $monthlyExpenses) * 12,
            'cap_rate' => $property->current_value > 0 ? (($monthlyRevenue - $monthlyExpenses) * 12) / $property->current_value * 100 : 0,
            'roi' => $property->purchase_price > 0 ? (($monthlyRevenue - $monthlyExpenses) * 12) / $property->purchase_price * 100 : 0
        ];
        
        return view('admin.properties.show', compact(
            'property', 
            'vacancyData', 
            'financialData'
        ));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        $portfolios = Portfolio::pluck('name', 'id');
        
        return view('admin.properties.edit', compact('property', 'portfolios'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(PropertyRequest $request, Property $property)
    {
        $property->update($request->validated());
        
        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Property updated successfully');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        // Check if the property has units
        $unitsCount = $property->units()->count();
        
        if ($unitsCount > 0) {
            return redirect()
                ->route('properties.show', $property)
                ->with('error', 'Cannot delete property with units. Please delete all units first.');
        }
        
        $property->delete();
        
        return redirect()
            ->route('properties.index')
            ->with('success', 'Property deleted successfully');
    }
    
    /**
     * Generate a vacancy report for the property.
     */
    public function vacancyReport(Property $property)
    {
        $property->load(['units' => function($query) {
            $query->with('currentLease', 'currentTenant');
        }]);
        
        // Calculate current vacancy and occupancy
        $totalUnits = $property->units->count();
        $vacantUnits = $property->units->where('status', 'Available')->count();
        $occupiedUnits = $property->units->where('status', 'Occupied')->count();
        $maintenanceUnits = $property->units->where('status', 'Maintenance')->count();
        
        $occupancyRate = $totalUnits > 0 ? ($occupiedUnits / $totalUnits) * 100 : 0;
        
        // Calculate vacancy by unit type
        $vacancyByType = [];
        $unitTypes = $property->units->pluck('unit_type')->unique();
        
        foreach ($unitTypes as $type) {
            $typeUnits = $property->units->where('unit_type', $type);
            $typeTotal = $typeUnits->count();
            $typeVacant = $typeUnits->where('status', 'Available')->count();
            $typeOccupied = $typeUnits->where('status', 'Occupied')->count();
            
            $vacancyByType[] = [
                'type' => $type,
                'total' => $typeTotal,
                'vacant' => $typeVacant,
                'occupied' => $typeOccupied,
                'occupancy_rate' => $typeTotal > 0 ? ($typeOccupied / $typeTotal) * 100 : 0
            ];
        }
        
        // Get upcoming lease expirations
        $upcomingExpirations = [];
        foreach ($property->units as $unit) {
            if ($unit->currentLease && $unit->currentLease->status === 'Active') {
                $daysUntilExpiration = $unit->currentLease->end_date->diffInDays(now());
                if ($daysUntilExpiration <= 90) {
                    $upcomingExpirations[] = [
                        'unit' => $unit,
                        'tenant' => $unit->currentTenant,
                        'expiration_date' => $unit->currentLease->end_date,
                        'days_remaining' => $daysUntilExpiration
                    ];
                }
            }
        }
        
        // Sort expirations by days remaining
        usort($upcomingExpirations, function($a, $b) {
            return $a['days_remaining'] - $b['days_remaining'];
        });
        
        return view('admin.properties.vacancy-report', compact(
            'property',
            'totalUnits',
            'vacantUnits',
            'occupiedUnits',
            'maintenanceUnits',
            'occupancyRate',
            'vacancyByType',
            'upcomingExpirations'
        ));
    }
    
    /**
     * Generate a financial report for the property.
     */
    public function financialReport(Property $property, Request $request)
    {
        // Default period is last 12 months
        $period = $request->period ?? 12;
        
        $property->load(['units' => function($query) {
            $query->with('currentLease');
        }]);
        
        // Current financial snapshot
        $currentMonthlyRevenue = 0;
        foreach ($property->units as $unit) {
            if ($unit->currentLease) {
                $currentMonthlyRevenue += $unit->currentLease->monthly_rent;
            }
        }
        
        $annualExpenses = $property->annual_property_tax + $property->insurance_cost;
        $monthlyExpenses = $annualExpenses / 12;
        $monthlyExpenses += $currentMonthlyRevenue * 0.2; // Estimated maintenance, utilities, etc.
        
        $currentFinancials = [
            'monthly_revenue' => $currentMonthlyRevenue,
            'monthly_expenses' => $monthlyExpenses,
            'monthly_noi' => $currentMonthlyRevenue - $monthlyExpenses,
            'annual_revenue' => $currentMonthlyRevenue * 12,
            'annual_expenses' => $annualExpenses + ($currentMonthlyRevenue * 0.2 * 12),
            'annual_noi' => ($currentMonthlyRevenue - $monthlyExpenses) * 12,
            'cap_rate' => $property->current_value > 0 ? (($currentMonthlyRevenue - $monthlyExpenses) * 12) / $property->current_value * 100 : 0,
            'roi' => $property->purchase_price > 0 ? (($currentMonthlyRevenue - $monthlyExpenses) * 12) / $property->purchase_price * 100 : 0
        ];
        
        // Historical data - in a real app, this would come from financial records
        $monthlyData = [];
        
        // Generate simulated historical data
        for ($i = $period - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            
            // Add random variations for simulation
            $varianceFactor = 0.95 + (rand(-5, 5) / 100); // -5% to +5% variance
            $monthlyRevenue = $currentMonthlyRevenue * $varianceFactor;
            $monthlyExpenseFactor = 0.95 + (rand(-5, 5) / 100);
            $monthlyExpenses = ($annualExpenses / 12) * $monthlyExpenseFactor + ($monthlyRevenue * 0.2);
            $monthlyNoi = $monthlyRevenue - $monthlyExpenses;
            
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'revenue' => round($monthlyRevenue, 2),
                'expenses' => round($monthlyExpenses, 2),
                'noi' => round($monthlyNoi, 2),
                'occupancy' => min(100, max(80, $property->occupancy_rate + (rand(-5, 5))))
            ];
        }
        
        // Calculate trends
        $trendData = [
            'revenue_trend' => $this->calculateTrend(array_column($monthlyData, 'revenue')),
            'expense_trend' => $this->calculateTrend(array_column($monthlyData, 'expenses')),
            'noi_trend' => $this->calculateTrend(array_column($monthlyData, 'noi')),
            'occupancy_trend' => $this->calculateTrend(array_column($monthlyData, 'occupancy'))
        ];
        
        return view('properties.financial-report', compact(
            'property',
            'currentFinancials',
            'monthlyData',
            'trendData',
            'period'
        ));
    }
    
    /**
     * Calculate trend as percentage change from first to last period.
     */
    private function calculateTrend($data)
    {
        if (count($data) < 2 || $data[0] == 0) {
            return 0;
        }
        
        $first = $data[0];
        $last = $data[count($data) - 1];
        
        return (($last - $first) / $first) * 100;
    }
    
    /**
     * Export property data as CSV.
     */
    public function export(Property $property)
    {
        $property->load(['units' => function($query) {
            $query->with('currentLease', 'currentTenant');
        }]);
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="property_' . $property->id . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($property) {
            $handle = fopen('php://output', 'w');
            
            // Add property details
            fputcsv($handle, ['Property Details']);
            fputcsv($handle, ['ID', $property->id]);
            fputcsv($handle, ['Name', $property->name]);
            fputcsv($handle, ['Address', $property->address]);
            fputcsv($handle, ['City', $property->city]);
            fputcsv($handle, ['State', $property->state]);
            fputcsv($handle, ['Type', $property->property_type]);
            fputcsv($handle, ['Units', $property->units->count()]);
            fputcsv($handle, ['Occupancy Rate', $property->occupancy_rate . '%']);
            fputcsv($handle, ['Purchase Price', '$' . number_format($property->purchase_price, 2)]);
            fputcsv($handle, ['Current Value', '$' . number_format($property->current_value, 2)]);
            fputcsv($handle, ['Square Footage', number_format($property->square_footage)]);
            fputcsv($handle, ['Acquisition Date', $property->acquisition_date->format('Y-m-d')]);
            fputcsv($handle, ['Status', $property->status]);
            fputcsv($handle, []); // Empty row for spacing
            
            // Add units details
            fputcsv($handle, ['Units']);
            fputcsv($handle, [
                'Unit Number', 'Unit Type', 'Bedrooms', 'Bathrooms', 'Square Footage', 
                'Base Rent', 'Status', 'Tenant', 'Lease End Date'
            ]);
            
            foreach ($property->units as $unit) {
                fputcsv($handle, [
                    $unit->unit_number,
                    $unit->unit_type,
                    $unit->bedrooms,
                    $unit->bathrooms,
                    $unit->square_footage,
                    '$' . number_format($unit->base_rent, 2),
                    $unit->status,
                    $unit->currentTenant ? $unit->currentTenant->first_name . ' ' . $unit->currentTenant->last_name : 'N/A',
                    $unit->currentLease ? $unit->currentLease->end_date->format('Y-m-d') : 'N/A'
                ]);
            }
            
            fclose($handle);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
