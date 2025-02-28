<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TenantRequest;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\Lease;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    /**
     * Display a listing of the tenants.
     */
    public function index(Request $request)
    {
        $query = Tenant::query();
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Apply status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('active_status', true);
            } elseif ($request->status === 'inactive') {
                $query->where('active_status', false);
            } elseif ($request->status === 'prospective') {
                $query->doesntHave('leases');
            }
        }
        
        // Apply property filter
        if ($request->filled('property')) {
            $propertyId = $request->property;
            $query->whereHas('leases.unit.property', function($q) use ($propertyId) {
                $q->where('properties.id', $propertyId);
            });
        }
        
        // Get tenants with related models
        $tenants = $query->withCount('leases')
                        ->with(['currentLease', 'currentUnit', 'currentUnit.property'])
                        ->latest()
                        ->paginate(10)
                        ->withQueryString();
        
        // Get all properties for the filter dropdown
        $properties = Property::orderBy('name')->pluck('name', 'id');
        
        // Get summary statistics
        $activeLeases = Lease::where('status', 'active')->count();
        $monthlyRevenue = Lease::where('status', 'active')->sum('monthly_rent');
        $totalUnits = Unit::count();
        $occupiedUnits = Unit::whereHas('leases', function($q) {
            $q->where('status', 'active');
        })->count();
        $occupancyRate = $totalUnits > 0 ? ($occupiedUnits / $totalUnits) * 100 : 0;
        
        return view('admin.tenants.index', compact(
            'tenants', 
            'properties', 
            'activeLeases', 
            'monthlyRevenue', 
            'occupancyRate'
        ));
    }

    /**
     * Show the form for creating a new tenant.
     */
    public function create()
    {
        return view('admin.tenants.create');
    }

    /**
     * Store a newly created tenant in storage.
     */
    public function store(TenantRequest $request)
    {
        $tenant = Tenant::create($request->validated());

        return redirect()
            ->route('tenants.show', $tenant)
            ->with('success', 'Tenant created successfully');
    }

    /**
     * Display the specified tenant.
     */
    public function show(Tenant $tenant)
    {
        // Load related models
        $tenant->load([
            'leases.unit.property', 
            'currentLease', 
            'currentUnit',
            'siteVisits',
            'checklistResponses'
        ]);

        // Get maintenance records related to tenant's units
        $maintenanceRecords = [];
        if ($tenant->currentUnit) {
            $maintenanceRecords = $tenant->currentUnit->maintenanceRecords()
                ->latest()
                ->take(5)
                ->get();
        }

        // Get lease history
        $leaseHistory = $tenant->leases()
            ->with('unit.property')
            ->orderBy('start_date', 'desc')
            ->get();

        // Calculate some tenant metrics
        $totalRentPaid = 0; // In a real app, would query from payments model
        $averageMonthlyRent = $tenant->leases->avg('monthly_rent') ?? 0;
        $leaseCount = $tenant->leases->count();
        $averageLeaseDuration = 0;
        
        if ($leaseCount > 0) {
            $totalDays = 0;
            foreach ($tenant->leases as $lease) {
                $totalDays += $lease->start_date->diffInDays($lease->end_date);
            }
            $averageLeaseDuration = round($totalDays / $leaseCount);
        }

        $tenantMetrics = [
            'total_rent_paid' => $totalRentPaid,
            'average_monthly_rent' => $averageMonthlyRent,
            'lease_count' => $leaseCount,
            'average_lease_duration' => $averageLeaseDuration
        ];

        return view('admin.tenants.show', compact(
            'tenant', 
            'maintenanceRecords', 
            'leaseHistory',
            'tenantMetrics'
        ));
    }

    /**
     * Show the form for editing the specified tenant.
     */
    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified tenant in storage.
     */
    public function update(TenantRequest $request, Tenant $tenant)
    {
        $tenant->update($request->validated());

        return redirect()
            ->route('tenants.show', $tenant)
            ->with('success', 'Tenant updated successfully');
    }

    /**
     * Remove the specified tenant from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Check if tenant has active leases
        if ($tenant->leases()->where('status', 'active')->exists()) {
            return redirect()
                ->route('tenants.show', $tenant)
                ->with('error', 'Cannot delete tenant with active leases. Please terminate all leases first.');
        }

        $tenant->delete();

        return redirect()
            ->route('tenants.index')
            ->with('success', 'Tenant deleted successfully');
    }

    /**
     * Display tenant's lease history
     */
    public function leaseHistory(Tenant $tenant)
    {
        $leases = $tenant->leases()
            ->with(['unit.property'])
            ->orderBy('start_date', 'desc')
            ->get();

        // Calculate metrics for each lease
        foreach ($leases as $lease) {
            $lease->duration_days = $lease->start_date->diffInDays($lease->end_date);
            $lease->total_value = $lease->monthly_rent * $lease->start_date->diffInMonths($lease->end_date);
            
            // Calculate rent change from previous lease if available
            $lease->rent_change_percent = null;
            if (isset($previousLease) && $previousLease->unit_id === $lease->unit_id) {
                $lease->rent_change_percent = $previousLease->monthly_rent > 0 
                    ? (($lease->monthly_rent - $previousLease->monthly_rent) / $previousLease->monthly_rent) * 100 
                    : null;
            }
            
            $previousLease = $lease;
        }

        // Calculate overall lease metrics
        $totalLeaseDays = $leases->sum('duration_days');
        $averageLeaseDuration = $leases->count() > 0 ? $totalLeaseDays / $leases->count() : 0;
        $averageRentIncrease = $leases->whereNotNull('rent_change_percent')->avg('rent_change_percent') ?? 0;
        
        $leaseMetrics = [
            'total_leases' => $leases->count(),
            'average_duration' => round($averageLeaseDuration),
            'average_rent_increase' => round($averageRentIncrease, 2),
            'properties_rented' => $leases->pluck('unit.property_id')->unique()->count()
        ];

        return view('admin.tenants.lease-history', compact(
            'tenant',
            'leases',
            'leaseMetrics'
        ));
    }

    /**
     * Generate a payment history report for the tenant
     */
    public function paymentHistory(Tenant $tenant)
    {
        // In a real app, you would load actual payment records here
        // For now, we'll simulate payment history based on lease data
        
        $tenant->load(['leases' => function($query) {
            $query->with('unit.property')->orderBy('start_date', 'desc');
        }]);
        
        $paymentHistory = [];
        $paymentMetrics = [
            'total_paid' => 0,
            'on_time_payments' => 0,
            'late_payments' => 0,
            'average_days_late' => 0
        ];
        
        // In a real app, replace this with actual payment data
        foreach ($tenant->leases as $lease) {
            // Only process completed months for active leases
            $endDate = $lease->status === 'active' ? now() : $lease->end_date;
            $monthCount = $lease->start_date->diffInMonths($endDate);
            
            // Generate a simulated payment record for each month
            for ($i = 0; $i < $monthCount; $i++) {
                $dueDate = $lease->start_date->copy()->addMonths($i)->startOfMonth()->addDays(1);
                
                // 85% chance of on-time payment
                $daysLate = rand(1, 100) > 85 ? rand(1, 10) : 0;
                $paymentDate = $dueDate->copy()->addDays($daysLate);
                
                $paymentAmount = $lease->monthly_rent;
                
                // Sometimes add fees for late payments
                $lateFee = $daysLate > 0 ? 50 : 0;
                
                $paymentHistory[] = [
                    'lease_id' => $lease->id,
                    'property_name' => $lease->unit->property->name,
                    'unit_number' => $lease->unit->unit_number,
                    'period' => $dueDate->format('M Y'),
                    'due_date' => $dueDate->format('Y-m-d'),
                    'payment_date' => $paymentDate->format('Y-m-d'),
                    'days_late' => $daysLate,
                    'amount_due' => $paymentAmount,
                    'amount_paid' => $paymentAmount + $lateFee,
                    'status' => 'Paid',
                    'late_fee' => $lateFee
                ];
                
                // Update metrics
                $paymentMetrics['total_paid'] += $paymentAmount + $lateFee;
                if ($daysLate > 0) {
                    $paymentMetrics['late_payments']++;
                    $paymentMetrics['average_days_late'] += $daysLate;
                } else {
                    $paymentMetrics['on_time_payments']++;
                }
            }
        }
        
        // Sort by payment date, most recent first
        usort($paymentHistory, function($a, $b) {
            return strtotime($b['payment_date']) - strtotime($a['payment_date']);
        });
        
        // Calculate average days late
        if ($paymentMetrics['late_payments'] > 0) {
            $paymentMetrics['average_days_late'] /= $paymentMetrics['late_payments'];
        }
        
        // Calculate on-time payment percentage
        $totalPayments = count($paymentHistory);
        $paymentMetrics['on_time_percentage'] = $totalPayments > 0 
            ? ($paymentMetrics['on_time_payments'] / $totalPayments) * 100 
            : 0;

        return view('admin.tenants.payment-history', compact(
            'tenant',
            'paymentHistory',
            'paymentMetrics'
        ));
    }

    /**
     * Search tenants by name, email or phone for autocomplete
     */
    public function search(Request $request)
    {
        $search = $request->q;
        $tenants = Tenant::where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->select('id', 'first_name', 'last_name', 'email', 'phone')
            ->limit(10)
            ->get();

        return response()->json($tenants);
    }
}