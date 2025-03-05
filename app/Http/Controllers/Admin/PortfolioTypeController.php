<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioType;
use Illuminate\Http\Request;

class PortfolioTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolioTypes = PortfolioType::all();
        return view('admin.portfolio-types.index', compact('portfolioTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.portfolio-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        PortfolioType::create($request->all());

        return redirect()->route('portfolio-types.index')
            ->with('success', 'Portfolio type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortfolioType  $portfolioType
     * @return \Illuminate\Http\Response
     */
    public function show(PortfolioType $portfolio_type)
    {
        $portfolioType = $portfolio_type;
        $portfolioType->load('portfolios');

        return view('admin.portfolio-types.show', compact('portfolioType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PortfolioType  $portfolioType
     * @return \Illuminate\Http\Response
     */
    public function edit(PortfolioType $portfolioType)
    {
        return view('admin.portfolio-types.edit', compact('portfolioType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PortfolioType  $portfolioType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortfolioType $portfolioType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $portfolioType->update($request->all());

        return redirect()->route('portfolio-types.index')
            ->with('success', 'Portfolio type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PortfolioType  $portfolioType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortfolioType $portfolioType)
    {
        try {
            $portfolioType->delete();
            return redirect()->route('portfolio-types.index')
                ->with('success', 'Portfolio type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('portfolio-types.index')
                ->with('error', 'Cannot delete this portfolio type. It may be in use.');
        }
    }
}
