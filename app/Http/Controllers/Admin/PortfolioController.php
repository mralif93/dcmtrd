<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Models\Portfolio;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PortfolioController extends Controller
{
    /**
     * Display a listing of the portfolios.
     */
    public function index(Request $request)
    {
        $query = Portfolio::query();
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Apply type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }
        
        // Apply risk profile filter
        if ($request->has('risk_profile') && !empty($request->risk_profile)) {
            $query->where('risk_profile', $request->risk_profile);
        }
        
        // Get portfolios with property count
        $portfolios = $query->withCount('properties')
                            ->latest()
                            ->paginate(10);
        
        // Get totals for summary statistics
        $totalProperties = Property::count();
        $totalAssetValue = Portfolio::sum('total_assets');
        
        // Calculate average occupancy across all properties
        $averageOccupancy = Property::avg('occupancy_rate') ?? 0;
        
        return view('admin.portfolios.index', compact(
            'portfolios', 
            'totalProperties', 
            'totalAssetValue', 
            'averageOccupancy'
        ));
    }

    /**
     * Show the form for creating a new portfolio.
     */
    public function create()
    {
        return view('admin.portfolios.create');
    }

    /**
     * Store a newly created portfolio in storage.
     */
    public function store(PortfolioRequest $request)
    {
        $portfolio = Portfolio::create($request->validated());

        return redirect()
            ->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio created successfully');
    }

    /**
     * Display the specified portfolio.
     */
    public function show(Portfolio $portfolio)
    {
        // Load properties with the counts of their units
        $portfolio->load(['properties' => function ($query) {
            $query->withCount('units');
        }, 'financialReports']);
        
        // Count total units across all properties
        $totalUnits = $portfolio->properties->sum('units_count');
        
        // Calculate occupancy rate - weighted average based on unit count
        $occupancyRate = 0;
        $totalUnitCount = 0;
        
        foreach ($portfolio->properties as $property) {
            $unitCount = $property->units_count;
            if ($unitCount > 0) {
                $occupancyRate += $property->occupancy_rate * $unitCount;
                $totalUnitCount += $unitCount;
            }
        }
        
        $occupancyRate = $totalUnitCount > 0 ? $occupancyRate / $totalUnitCount : 0;
        
        // Calculate monthly revenue across all properties and units
        $monthlyRevenue = 0;
        foreach ($portfolio->properties as $property) {
            // Get all units with their current leases
            $units = Unit::where('property_id', $property->id)
                         ->whereHas('currentLease')
                         ->with('currentLease')
                         ->get();
                         
            foreach ($units as $unit) {
                if ($unit->currentLease) {
                    $monthlyRevenue += $unit->currentLease->monthly_rent;
                }
            }
        }
        
        return view('admin.portfolios.show', compact(
            'portfolio', 
            'totalUnits', 
            'occupancyRate', 
            'monthlyRevenue'
        ));
    }

    /**
     * Show the form for editing the specified portfolio.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified portfolio in storage.
     */
    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $portfolio->update($request->validated());
        
        return redirect()
            ->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio updated successfully');
    }

    /**
     * Remove the specified portfolio from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        // First check if this portfolio has properties
        $propertiesCount = $portfolio->properties()->count();
        
        if ($propertiesCount > 0) {
            return redirect()
                ->route('portfolios.index')
                ->with('error', 'Cannot delete portfolio that has properties. Please remove all properties first.');
        }
        
        $portfolio->delete();
        
        return redirect()
            ->route('portfolios.index')
            ->with('success', 'Portfolio deleted successfully');
    }
    
    /**
     * Display analytics for the portfolio.
     */
    public function analytics(Portfolio $portfolio)
    {
        // Basic analytics
        $analytics = [
            'total_properties' => $portfolio->properties()->count(),
            'total_units' => $portfolio->properties()->withCount('units')->get()->sum('units_count'),
            'occupancy_rate' => $portfolio->properties()->avg('occupancy_rate') ?? 0,
            'total_value' => $portfolio->properties()->sum('current_value'),
            'monthly_revenue' => 0,
        ];
        
        // Monthly revenue calculation
        $properties = $portfolio->properties()->with(['units' => function($query) {
            $query->with('currentLease');
        }])->get();
        
        $totalRevenue = 0;
        foreach ($properties as $property) {
            foreach ($property->units as $unit) {
                if ($unit->currentLease) {
                    $totalRevenue += $unit->currentLease->monthly_rent;
                }
            }
        }
        $analytics['monthly_revenue'] = $totalRevenue;
        
        // Calculate financial metrics
        $totalInvestment = $portfolio->properties()->sum('purchase_price');
        $analytics['cash_on_cash_return'] = $totalInvestment > 0 ? 
            ($totalRevenue * 12) / $totalInvestment * 100 : 0;
            
        $analytics['cap_rate'] = $analytics['total_value'] > 0 ? 
            ($totalRevenue * 12) / $analytics['total_value'] * 100 : 0;
            
        $analytics['roi'] = $totalInvestment > 0 ? 
            ($analytics['total_value'] - $totalInvestment) / $totalInvestment * 100 : 0;
            
        $totalDebt = $portfolio->properties()->sum('mortgage_balance') ?? 0;
        $analytics['debt_ratio'] = $analytics['total_value'] > 0 ? 
            $totalDebt / $analytics['total_value'] * 100 : 0;
        
        // Chart data for last 12 months
        $months = [];
        $revenue = [];
        $expenses = [];
        $netIncome = [];
        $occupancy = [];
        $marketAverage = [];
        
        // In a real app, this would come from financial records, but we'll simulate it
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('M Y');
            $months[] = $month;
            
            // Simulated data - in a real app, this would be queried from actual financial records
            $monthlyRevenue = $totalRevenue * (0.95 + (rand(-5, 5) / 100));
            $monthlyExpenses = $monthlyRevenue * (0.4 + (rand(-5, 5) / 100));
            $monthlyNetIncome = $monthlyRevenue - $monthlyExpenses;
            $monthlyOccupancy = $analytics['occupancy_rate'] + (rand(-3, 3));
            
            $revenue[] = round($monthlyRevenue);
            $expenses[] = round($monthlyExpenses);
            $netIncome[] = round($monthlyNetIncome);
            $occupancy[] = min(100, max(80, $monthlyOccupancy));
            $marketAverage[] = 92 + (rand(-2, 2));
        }
        
        $chartData = compact('months', 'revenue', 'expenses', 'netIncome', 'occupancy', 'marketAverage');
        
        // Property analytics for comparison table
        $propertyAnalytics = [];
        foreach ($properties as $property) {
            $propertyRevenue = 0;
            foreach ($property->units as $unit) {
                if ($unit->currentLease) {
                    $propertyRevenue += $unit->currentLease->monthly_rent;
                }
            }
            
            $propertyExpenses = $propertyRevenue * 0.4; // Simulated expense ratio
            $propertyNetIncome = $propertyRevenue - $propertyExpenses;
            $propertyRoi = $property->purchase_price > 0 ? 
                ($propertyNetIncome * 12) / $property->purchase_price * 100 : 0;
            
            // Compare to target ROI - difference in percentage points
            $performanceDiff = $propertyRoi - $portfolio->target_return;
            
            $propertyAnalytics[] = [
                'id' => $property->id,
                'name' => $property->name,
                'units' => $property->units->count(),
                'occupancy_rate' => $property->occupancy_rate,
                'monthly_revenue' => $propertyRevenue,
                'monthly_expenses' => $propertyExpenses,
                'net_income' => $propertyNetIncome,
                'roi' => $propertyRoi,
                'performance' => round($performanceDiff, 1)
            ];
        }
        
        return view('admin.portfolios.analytics', compact(
            'portfolio', 
            'analytics', 
            'chartData', 
            'propertyAnalytics'
        ));
    }
    
    /**
     * Display a report of portfolio performance over time.
     */
    public function performanceReport(Portfolio $portfolio, Request $request)
    {
        // Default to last 12 months if not specified
        $period = $request->period ?? 12;
        
        // Get historical data - would come from actual financial records in a real application
        $monthlyData = $this->getHistoricalPerformanceData($portfolio, $period);
        
        // Calculate metrics over time
        $metrics = [
            'revenue_growth' => $this->calculateGrowthRate($monthlyData, 'revenue'),
            'expense_growth' => $this->calculateGrowthRate($monthlyData, 'expenses'),
            'income_growth' => $this->calculateGrowthRate($monthlyData, 'net_income'),
            'occupancy_trend' => $this->calculateGrowthRate($monthlyData, 'occupancy'),
            'avg_monthly_revenue' => collect($monthlyData)->avg('revenue'),
            'avg_monthly_expenses' => collect($monthlyData)->avg('expenses'),
            'avg_net_income' => collect($monthlyData)->avg('net_income'),
            'avg_occupancy' => collect($monthlyData)->avg('occupancy'),
        ];
        
        return view('admin.portfolios.performance', compact('portfolio', 'monthlyData', 'metrics', 'period'));
    }
    
    /**
     * Helper method to get historical performance data.
     * In a real app, this would query actual data from financial records.
     */
    private function getHistoricalPerformanceData($portfolio, $months)
    {
        $data = [];
        
        // Baseline numbers
        $baseRevenue = $portfolio->properties()->with(['units' => function($query) {
            $query->with('currentLease');
        }])->get()->sum(function($property) {
            return $property->units->sum(function($unit) {
                return $unit->currentLease ? $unit->currentLease->monthly_rent : 0;
            });
        });
        
        $baseExpenses = $baseRevenue * 0.4; // Simulated expense ratio
        $baseOccupancy = $portfolio->properties()->avg('occupancy_rate') ?? 90;
        
        // Generate simulated historical data
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            
            // Add random variations to simulate real data
            $varianceFactor = 0.95 + (rand(-10, 15) / 100); // -5% to +5% variance
            $monthlyRevenue = $baseRevenue * $varianceFactor;
            $monthlyExpenses = $baseExpenses * (0.98 + (rand(-8, 12) / 100));
            $monthlyNetIncome = $monthlyRevenue - $monthlyExpenses;
            $monthlyOccupancy = min(100, max(75, $baseOccupancy + (rand(-5, 5))));
            
            $data[] = [
                'month' => $month->format('M Y'),
                'revenue' => round($monthlyRevenue, 2),
                'expenses' => round($monthlyExpenses, 2),
                'net_income' => round($monthlyNetIncome, 2),
                'occupancy' => round($monthlyOccupancy, 1)
            ];
        }
        
        return $data;
    }
    
    /**
     * Helper method to calculate growth rate for a metric.
     */
    private function calculateGrowthRate($data, $metric)
    {
        if (count($data) < 2) {
            return 0;
        }
        
        $first = $data[0][$metric];
        $last = $data[count($data) - 1][$metric];
        
        if ($first == 0) {
            return 0;
        }
        
        return (($last - $first) / $first) * 100;
    }
}