<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = Portfolio::all();
        
        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_name' => 'required|string|max:255',
            'annual_report' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'trust_deed_document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'insurance_document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'valuation_report' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $portfolio = new Portfolio();
            $portfolio->portfolio_name = $request->portfolio_name;
            
            // Handle file uploads
            if ($request->hasFile('annual_report')) {
                $portfolio->annual_report = $request->file('annual_report')->store('portfolios/annual_reports');
            }

            if ($request->hasFile('trust_deed_document')) {
                $portfolio->trust_deed_document = $request->file('trust_deed_document')->store('portfolios/trust_deeds');
            }

            if ($request->hasFile('insurance_document')) {
                $portfolio->insurance_document = $request->file('insurance_document')->store('portfolios/insurance');
            }

            if ($request->hasFile('valuation_report')) {
                $portfolio->valuation_report = $request->file('valuation_report')->store('portfolios/valuations');
            }

            $portfolio->save();

            return redirect()->route('portfolios.index')
                ->with('success', 'Portfolio created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating portfolio: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        return view('admin.portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_name' => 'required|string|max:255',
            'annual_report' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'trust_deed_document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'insurance_document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'valuation_report' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $portfolio->portfolio_name = $request->portfolio_name;

            // Handle file uploads
            if ($request->hasFile('annual_report')) {
                // Delete old file if exists
                if ($portfolio->annual_report) {
                    Storage::delete($portfolio->annual_report);
                }
                $portfolio->annual_report = $request->file('annual_report')->store('portfolios/annual_reports');
            }

            if ($request->hasFile('trust_deed_document')) {
                if ($portfolio->trust_deed_document) {
                    Storage::delete($portfolio->trust_deed_document);
                }
                $portfolio->trust_deed_document = $request->file('trust_deed_document')->store('portfolios/trust_deeds');
            }

            if ($request->hasFile('insurance_document')) {
                if ($portfolio->insurance_document) {
                    Storage::delete($portfolio->insurance_document);
                }
                $portfolio->insurance_document = $request->file('insurance_document')->store('portfolios/insurance');
            }

            if ($request->hasFile('valuation_report')) {
                if ($portfolio->valuation_report) {
                    Storage::delete($portfolio->valuation_report);
                }
                $portfolio->valuation_report = $request->file('valuation_report')->store('portfolios/valuations');
            }

            $portfolio->save();

            return redirect()->route('portfolios.index')
                ->with('success', 'Portfolio updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating portfolio: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        try {
            // Delete associated files
            if ($portfolio->annual_report) {
                Storage::delete($portfolio->annual_report);
            }
            if ($portfolio->trust_deed_document) {
                Storage::delete($portfolio->trust_deed_document);
            }
            if ($portfolio->insurance_document) {
                Storage::delete($portfolio->insurance_document);
            }
            if ($portfolio->valuation_report) {
                Storage::delete($portfolio->valuation_report);
            }
            
            $portfolio->delete();
            
            return redirect()->route('portfolios.index')
                ->with('success', 'Portfolio deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting portfolio: ' . $e->getMessage());
        }
    }
}