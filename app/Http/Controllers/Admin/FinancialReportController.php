<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FinancialReportRequest;
use App\Models\FinancialReport;
use App\Models\Portfolio;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class FinancialReportController extends Controller
{
    /**
     * Display a listing of the financial reports.
     */
    public function index(Request $request)
    {
        $query = FinancialReport::query();
        
        // Apply portfolio filter
        if ($request->filled('portfolio_id')) {
            $query->where('portfolio_id', $request->portfolio_id);
        }
        
        // Apply report type filter
        if ($request->filled('report_type')) {
            $query->where('report_type', $request->report_type);
        }
        
        // Apply year filter - SQLite compatible
        if ($request->filled('year')) {
            $query->whereRaw('strftime("%Y", report_date) = ?', [$request->year]);
        }
        
        // Apply date range filter
        if ($request->filled('start_date')) {
            $query->where('report_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->where('report_date', '<=', $request->end_date);
        }
        
        // Get reports with their portfolio
        $reports = $query->with('portfolio')
                        ->latest('report_date')
                        ->paginate(15)
                        ->withQueryString();
        
        // Get all portfolios for filter dropdown
        $portfolios = Portfolio::orderBy('name')->pluck('name', 'id');
        
        // Get all years for filter dropdown - SQLite compatible
        $years = DB::table('financial_reports')
                  ->select(DB::raw('strftime("%Y", report_date) as year'))
                  ->distinct()
                  ->orderBy('year', 'desc')
                  ->pluck('year');
        
        // Calculate summary metrics
        $summaryMetrics = $this->calculateSummaryMetrics($query->get());
        
        return view('admin.financial-reports.index', compact(
            'reports', 
            'portfolios', 
            'years', 
            'summaryMetrics'
        ));
    }

    /**
     * Show the form for creating a new financial report.
     */
    public function create(Request $request)
    {
        $portfolios = Portfolio::orderBy('name')->pluck('name', 'id');
        $selectedPortfolio = $request->filled('portfolio_id') ? Portfolio::find($request->portfolio_id) : null;
        
        // Prepare report types
        $reportTypes = [
            'Monthly' => 'Monthly',
            'Quarterly' => 'Quarterly',
            'Annual' => 'Annual'
        ];
        
        return view('admin.financial-reports.create', compact('portfolios', 'selectedPortfolio', 'reportTypes'));
    }

    /**
     * Store a newly created financial report in storage.
     */
    public function store(FinancialReportRequest $request)
    {
        // Ensure the net_operating_income is calculated correctly
        $totalRevenue = $request->rental_revenue + $request->other_revenue;
        $operatingExpenses = $request->operating_expenses + $request->maintenance_expenses + 
                            $request->administrative_expenses + $request->utility_expenses + 
                            $request->insurance_expenses + $request->property_tax;
        
        $noi = $totalRevenue - $operatingExpenses;
        $netIncome = $noi - $request->debt_service - $request->capex;
        
        // Calculate cap rate
        $portfolioValue = Portfolio::find($request->portfolio_id)->total_assets ?? 0;
        $capRate = $portfolioValue > 0 ? ($noi * 12 / $portfolioValue) * 100 : 0;
        
        // Calculate ROI
        $totalInvestment = Portfolio::find($request->portfolio_id)->properties()->sum('purchase_price') ?? 0;
        $roi = $totalInvestment > 0 ? ($netIncome * 12 / $totalInvestment) * 100 : 0;
        
        // Create financial report
        $report = new FinancialReport($request->validated());
        $report->total_revenue = $totalRevenue;
        $report->net_operating_income = $noi;
        $report->net_income = $netIncome;
        $report->cap_rate = $capRate;
        $report->roi = $roi;
        $report->save();
        
        return redirect()
            ->route('financial-reports.show', $report)
            ->with('success', 'Financial report created successfully');
    }

    /**
     * Display the specified financial report.
     */
    public function show(FinancialReport $financialReport)
    {
        $financialReport->load('portfolio');
        
        // Calculate metrics for display
        $metrics = [
            'net_margin' => $financialReport->total_revenue > 0 
                ? ($financialReport->net_income / $financialReport->total_revenue) * 100 
                : 0,
            'debt_ratio' => $financialReport->portfolio->total_assets > 0
                ? ($financialReport->portfolio->properties()->sum('mortgage_balance') / $financialReport->portfolio->total_assets) * 100
                : 0,
            'expense_ratio' => $financialReport->total_revenue > 0
                ? (($financialReport->operating_expenses + $financialReport->maintenance_expenses + 
                    $financialReport->administrative_expenses + $financialReport->utility_expenses + 
                    $financialReport->insurance_expenses + $financialReport->property_tax) / $financialReport->total_revenue) * 100
                : 0,
            'debt_service_coverage' => $financialReport->debt_service > 0
                ? $financialReport->net_operating_income / $financialReport->debt_service
                : 'N/A'
        ];
        
        // Get comparative data (if available)
        $previousPeriod = null;
        if ($financialReport->report_type === 'Monthly') {
            $previousPeriod = FinancialReport::where('portfolio_id', $financialReport->portfolio_id)
                ->where('report_type', 'Monthly')
                ->where('report_date', '<', $financialReport->report_date)
                ->latest('report_date')
                ->first();
        } elseif ($financialReport->report_type === 'Quarterly') {
            $previousPeriod = FinancialReport::where('portfolio_id', $financialReport->portfolio_id)
                ->where('report_type', 'Quarterly')
                ->where('report_date', '<', $financialReport->report_date)
                ->latest('report_date')
                ->first();
        } elseif ($financialReport->report_type === 'Annual') {
            $previousYear = date('Y', strtotime($financialReport->report_date)) - 1;
            $previousPeriod = FinancialReport::where('portfolio_id', $financialReport->portfolio_id)
                ->where('report_type', 'Annual')
                ->whereRaw('strftime("%Y", report_date) = ?', [$previousYear])
                ->first();
        }
        
        // Calculate percent changes if previous period exists
        $changes = [];
        if ($previousPeriod) {
            $changes = [
                'revenue' => $previousPeriod->total_revenue > 0 
                    ? (($financialReport->total_revenue - $previousPeriod->total_revenue) / $previousPeriod->total_revenue) * 100
                    : null,
                'expenses' => $previousPeriod->operating_expenses > 0
                    ? ((($financialReport->operating_expenses + $financialReport->maintenance_expenses + 
                         $financialReport->administrative_expenses + $financialReport->utility_expenses + 
                         $financialReport->insurance_expenses + $financialReport->property_tax) - 
                        ($previousPeriod->operating_expenses + $previousPeriod->maintenance_expenses + 
                         $previousPeriod->administrative_expenses + $previousPeriod->utility_expenses + 
                         $previousPeriod->insurance_expenses + $previousPeriod->property_tax)) / 
                       ($previousPeriod->operating_expenses + $previousPeriod->maintenance_expenses + 
                        $previousPeriod->administrative_expenses + $previousPeriod->utility_expenses + 
                        $previousPeriod->insurance_expenses + $previousPeriod->property_tax)) * 100
                    : null,
                'noi' => $previousPeriod->net_operating_income > 0
                    ? (($financialReport->net_operating_income - $previousPeriod->net_operating_income) / $previousPeriod->net_operating_income) * 100
                    : null,
                'net_income' => $previousPeriod->net_income > 0
                    ? (($financialReport->net_income - $previousPeriod->net_income) / $previousPeriod->net_income) * 100
                    : null,
                'occupancy' => $previousPeriod->occupancy_rate > 0
                    ? $financialReport->occupancy_rate - $previousPeriod->occupancy_rate
                    : null
            ];
        }
        
        return view('admin.financial-reports.show', compact('financialReport', 'metrics', 'previousPeriod', 'changes'));
    }

    /**
     * Show the form for editing the specified financial report.
     */
    public function edit(FinancialReport $financialReport)
    {
        $portfolios = Portfolio::orderBy('name')->pluck('name', 'id');
        
        // Prepare report types
        $reportTypes = [
            'Monthly' => 'Monthly',
            'Quarterly' => 'Quarterly',
            'Annual' => 'Annual'
        ];
        
        return view('admin.financial-reports.edit', compact('financialReport', 'portfolios', 'reportTypes'));
    }

    /**
     * Update the specified financial report in storage.
     */
    public function update(FinancialReportRequest $request, FinancialReport $financialReport)
    {
        // Ensure the net_operating_income is calculated correctly
        $totalRevenue = $request->rental_revenue + $request->other_revenue;
        $operatingExpenses = $request->operating_expenses + $request->maintenance_expenses + 
                            $request->administrative_expenses + $request->utility_expenses + 
                            $request->insurance_expenses + $request->property_tax;
        
        $noi = $totalRevenue - $operatingExpenses;
        $netIncome = $noi - $request->debt_service - $request->capex;
        
        // Calculate cap rate
        $portfolioValue = Portfolio::find($request->portfolio_id)->total_assets ?? 0;
        $capRate = $portfolioValue > 0 ? ($noi * 12 / $portfolioValue) * 100 : 0;
        
        // Calculate ROI
        $totalInvestment = Portfolio::find($request->portfolio_id)->properties()->sum('purchase_price') ?? 0;
        $roi = $totalInvestment > 0 ? ($netIncome * 12 / $totalInvestment) * 100 : 0;
        
        // Update financial report
        $financialReport->fill($request->validated());
        $financialReport->total_revenue = $totalRevenue;
        $financialReport->net_operating_income = $noi;
        $financialReport->net_income = $netIncome;
        $financialReport->cap_rate = $capRate;
        $financialReport->roi = $roi;
        $financialReport->save();
        
        return redirect()
            ->route('financial-reports.show', $financialReport)
            ->with('success', 'Financial report updated successfully');
    }

    /**
     * Remove the specified financial report from storage.
     */
    public function destroy(FinancialReport $financialReport)
    {
        $financialReport->delete();
        
        return redirect()
            ->route('financial-reports.index')
            ->with('success', 'Financial report deleted successfully');
    }
    
    /**
     * Export the financial report as CSV.
     */
    public function export(FinancialReport $financialReport)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="financial_report_' . $financialReport->id . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($financialReport) {
            $handle = fopen('php://output', 'w');
            
            // Add report header
            fputcsv($handle, ['Financial Report']);
            fputcsv($handle, ['Portfolio', $financialReport->portfolio->name]);
            fputcsv($handle, ['Period', $financialReport->fiscal_period]);
            fputcsv($handle, ['Report Type', $financialReport->report_type]);
            fputcsv($handle, ['Report Date', $financialReport->report_date->format('Y-m-d')]);
            fputcsv($handle, []);
            
            // Add revenue section
            fputcsv($handle, ['Revenue']);
            fputcsv($handle, ['Rental Revenue', '$' . number_format($financialReport->rental_revenue, 2)]);
            fputcsv($handle, ['Other Revenue', '$' . number_format($financialReport->other_revenue, 2)]);
            fputcsv($handle, ['Total Revenue', '$' . number_format($financialReport->total_revenue, 2)]);
            fputcsv($handle, []);
            
            // Add expenses section
            fputcsv($handle, ['Expenses']);
            fputcsv($handle, ['Operating Expenses', '$' . number_format($financialReport->operating_expenses, 2)]);
            fputcsv($handle, ['Maintenance Expenses', '$' . number_format($financialReport->maintenance_expenses, 2)]);
            fputcsv($handle, ['Administrative Expenses', '$' . number_format($financialReport->administrative_expenses, 2)]);
            fputcsv($handle, ['Utility Expenses', '$' . number_format($financialReport->utility_expenses, 2)]);
            fputcsv($handle, ['Insurance Expenses', '$' . number_format($financialReport->insurance_expenses, 2)]);
            fputcsv($handle, ['Property Tax', '$' . number_format($financialReport->property_tax, 2)]);
            fputcsv($handle, ['Total Expenses', '$' . number_format(
                $financialReport->operating_expenses + 
                $financialReport->maintenance_expenses + 
                $financialReport->administrative_expenses + 
                $financialReport->utility_expenses + 
                $financialReport->insurance_expenses + 
                $financialReport->property_tax, 2)]);
            fputcsv($handle, []);
            
            // Add income section
            fputcsv($handle, ['Income']);
            fputcsv($handle, ['Net Operating Income (NOI)', '$' . number_format($financialReport->net_operating_income, 2)]);
            fputcsv($handle, ['Debt Service', '$' . number_format($financialReport->debt_service, 2)]);
            fputcsv($handle, ['Capital Expenditures', '$' . number_format($financialReport->capex, 2)]);
            fputcsv($handle, ['Net Income', '$' . number_format($financialReport->net_income, 2)]);
            fputcsv($handle, ['Cash Flow', '$' . number_format($financialReport->cash_flow, 2)]);
            fputcsv($handle, []);
            
            // Add metrics section
            fputcsv($handle, ['Metrics']);
            fputcsv($handle, ['Occupancy Rate', $financialReport->occupancy_rate . '%']);
            fputcsv($handle, ['Debt Ratio', $financialReport->debt_ratio . '%']);
            fputcsv($handle, ['ROI', $financialReport->roi . '%']);
            fputcsv($handle, ['Cap Rate', $financialReport->cap_rate . '%']);
            
            fclose($handle);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Generate a financial summary for a given portfolio.
     */
    public function portfolioSummary(Portfolio $portfolio, Request $request)
    {
        // Set default period to 12 months if not specified
        $period = $request->period ?? 12;
        
        // Get financial reports for this portfolio
        $reports = FinancialReport::where('portfolio_id', $portfolio->id)
                                ->latest('report_date')
                                ->take($period)
                                ->get();
        
        // Calculate summary metrics
        $summaryMetrics = $this->calculateSummaryMetrics($reports);
        
        // Get monthly data for charts
        $monthlyData = [];
        foreach ($reports as $report) {
            $monthlyData[] = [
                'month' => $report->report_date->format('M Y'),
                'revenue' => $report->total_revenue,
                'expenses' => $report->operating_expenses + $report->maintenance_expenses + 
                              $report->administrative_expenses + $report->utility_expenses + 
                              $report->insurance_expenses + $report->property_tax,
                'noi' => $report->net_operating_income,
                'net_income' => $report->net_income,
                'occupancy' => $report->occupancy_rate
            ];
        }
        
        // Reverse to show in chronological order
        $monthlyData = array_reverse($monthlyData);
        
        // Calculate trends
        $trends = [
            'revenue_trend' => $this->calculateTrend(array_column($monthlyData, 'revenue')),
            'expense_trend' => $this->calculateTrend(array_column($monthlyData, 'expenses')),
            'noi_trend' => $this->calculateTrend(array_column($monthlyData, 'noi')),
            'income_trend' => $this->calculateTrend(array_column($monthlyData, 'net_income')),
            'occupancy_trend' => $this->calculateTrend(array_column($monthlyData, 'occupancy'))
        ];
        
        return view('admin.financial-reports.portfolio-summary', compact(
            'portfolio', 
            'summaryMetrics', 
            'monthlyData', 
            'trends', 
            'period'
        ));
    }
    
    /**
     * Calculate summary metrics from a collection of financial reports.
     */
    private function calculateSummaryMetrics($reports)
    {
        $totalRevenue = $reports->sum('total_revenue');
        $rentalRevenue = $reports->sum('rental_revenue');
        $otherRevenue = $reports->sum('other_revenue');
        $operatingExpenses = $reports->sum('operating_expenses');
        $maintenanceExpenses = $reports->sum('maintenance_expenses');
        $administrativeExpenses = $reports->sum('administrative_expenses');
        $utilityExpenses = $reports->sum('utility_expenses');
        $insuranceExpenses = $reports->sum('insurance_expenses');
        $propertyTax = $reports->sum('property_tax');
        $netOperatingIncome = $reports->sum('net_operating_income');
        $netIncome = $reports->sum('net_income');
        $debtService = $reports->sum('debt_service');
        $capex = $reports->sum('capex');
        $cashFlow = $reports->sum('cash_flow');
        
        // Calculate averages
        $avgOccupancyRate = $reports->avg('occupancy_rate');
        $avgDebtRatio = $reports->avg('debt_ratio');
        $avgRoi = $reports->avg('roi');
        $avgCapRate = $reports->avg('cap_rate');
        
        // Calculate total expenses
        $totalExpenses = $operatingExpenses + $maintenanceExpenses + $administrativeExpenses + 
                         $utilityExpenses + $insuranceExpenses + $propertyTax;
        
        return [
            'total_revenue' => $totalRevenue,
            'rental_revenue' => $rentalRevenue,
            'other_revenue' => $otherRevenue,
            'operating_expenses' => $operatingExpenses,
            'maintenance_expenses' => $maintenanceExpenses,
            'administrative_expenses' => $administrativeExpenses,
            'utility_expenses' => $utilityExpenses,
            'insurance_expenses' => $insuranceExpenses,
            'property_tax' => $propertyTax,
            'total_expenses' => $totalExpenses,
            'net_operating_income' => $netOperatingIncome,
            'net_income' => $netIncome,
            'debt_service' => $debtService,
            'capex' => $capex,
            'cash_flow' => $cashFlow,
            'avg_occupancy_rate' => $avgOccupancyRate,
            'avg_debt_ratio' => $avgDebtRatio,
            'avg_roi' => $avgRoi,
            'avg_cap_rate' => $avgCapRate
        ];
    }
    
    /**
     * Calculate trend as percentage change from first to last value.
     */
    private function calculateTrend($data)
    {
        if (count($data) < 2 || $data[0] == 0) {
            return 0;
        }
        
        $first = $data[0];
        $last = $data[count($data) - 1];
        
        return (($last - $first) / abs($first)) * 100;
    }
}