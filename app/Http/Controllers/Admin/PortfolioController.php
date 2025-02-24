<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use Illuminate\Http\Request;
use App\Models\Portfolio;


class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with(['properties'])
            ->latest()
            ->paginate(10);

        return response()->json($portfolios);
    }

    public function store(PortfolioRequest $request)
    {
        $portfolio = Portfolio::create($request->validated());

        return response()->json([
            'message' => 'Portfolio created successfully',
            'data' => $portfolio
        ], 201);
    }

    public function show(Portfolio $portfolio)
    {
        return response()->json([
            'data' => $portfolio->load(['properties', 'financialReports'])
        ]);
    }

    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $portfolio->update($request->validated());

        return response()->json([
            'message' => 'Portfolio updated successfully',
            'data' => $portfolio
        ]);
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return response()->json([
            'message' => 'Portfolio deleted successfully'
        ]);
    }

    public function analytics(Portfolio $portfolio)
    {
        $analytics = [
            'total_properties' => $portfolio->properties()->count(),
            'total_units' => $portfolio->properties()->withCount('units')->get()->sum('units_count'),
            'occupancy_rate' => $portfolio->properties()->avg('occupancy_rate'),
            'total_value' => $portfolio->properties()->sum('current_value'),
            'monthly_revenue' => $portfolio->properties()
                ->withSum('units', 'base_rent')
                ->get()
                ->sum('units_sum_base_rent'),
        ];

        return response()->json($analytics);
    }
}
