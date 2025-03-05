<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get search query parameters
        $search = $request->input('search');
        $status = $request->input('status');
        
        // Start with a base query
        $query = Portfolio::query();
        
        // Apply search filters if provided
        if ($search) {
            $query->where('portfolio_name', 'LIKE', "%{$search}%");
        }
        
        // Apply status filter if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Paginate the results (10 items per page)
        $portfolios = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Get all possible statuses for the filter dropdown
        $statuses = Portfolio::distinct('status')->pluck('status')->filter()->toArray();
        
        return view('user.portfolios.index', compact('portfolios', 'statuses', 'search', 'status'));
    }

    /**
     * Show the form for creating a new portfolio.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $portfolioTypes = PortfolioType::where('status', 'active')->get();
        
        return view('user.portfolios.create', compact('portfolioTypes'));
    }

    /**
     * Store a newly created portfolio in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_types_id' => 'required|exists:portfolio_types,id',
            'portfolio_name' => 'required|string|max:255',
            'annual_report' => 'nullable|file|mimes:pdf,doc,docx',
            'trust_deed_document' => 'nullable|file|mimes:pdf,doc,docx',
            'insurance_document' => 'nullable|file|mimes:pdf,doc,docx',
            'valuation_report' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'nullable|string|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $portfolio = new Portfolio();
        $portfolio->portfolio_types_id = $request->portfolio_types_id;
        $portfolio->portfolio_name = $request->portfolio_name;
        $portfolio->status = $request->status ?? 'active';

        // Handle file uploads
        if ($request->hasFile('annual_report')) {
            $portfolio->annual_report = $this->uploadFile($request->file('annual_report'), 'portfolios/annual_reports');
        }
        
        if ($request->hasFile('trust_deed_document')) {
            $portfolio->trust_deed_document = $this->uploadFile($request->file('trust_deed_document'), 'portfolios/trust_deeds');
        }
        
        if ($request->hasFile('insurance_document')) {
            $portfolio->insurance_document = $this->uploadFile($request->file('insurance_document'), 'portfolios/insurance');
        }
        
        if ($request->hasFile('valuation_report')) {
            $portfolio->valuation_report = $this->uploadFile($request->file('valuation_report'), 'portfolios/valuation');
        }

        $portfolio->save();

        return redirect()->route('portfolios-info.show', $portfolio)
            ->with('success', 'Portfolio created successfully.');
    }

    /**
     * Display the specified portfolio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portfolio = Portfolio::with(['portfolioType', 'properties', 'financials'])->findOrFail($id);
        
        return view('user.portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified portfolio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolioTypes = PortfolioType::where('status', 'active')->get();
        
        return view('user.portfolios.edit', compact('portfolio', 'portfolioTypes'));
    }

    /**
     * Update the specified portfolio in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_types_id' => 'required|exists:portfolio_types,id',
            'portfolio_name' => 'required|string|max:255',
            'annual_report' => 'nullable|file|mimes:pdf,doc,docx',
            'trust_deed_document' => 'nullable|file|mimes:pdf,doc,docx',
            'insurance_document' => 'nullable|file|mimes:pdf,doc,docx',
            'valuation_report' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'nullable|string|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $portfolio = Portfolio::findOrFail($id);
        $portfolio->portfolio_types_id = $request->portfolio_types_id;
        $portfolio->portfolio_name = $request->portfolio_name;
        $portfolio->status = $request->status ?? $portfolio->status;

        // Handle file uploads
        if ($request->hasFile('annual_report')) {
            $this->deleteOldFile($portfolio->annual_report);
            $portfolio->annual_report = $this->uploadFile($request->file('annual_report'), 'portfolios/annual_reports');
        }
        
        if ($request->hasFile('trust_deed_document')) {
            $this->deleteOldFile($portfolio->trust_deed_document);
            $portfolio->trust_deed_document = $this->uploadFile($request->file('trust_deed_document'), 'portfolios/trust_deeds');
        }
        
        if ($request->hasFile('insurance_document')) {
            $this->deleteOldFile($portfolio->insurance_document);
            $portfolio->insurance_document = $this->uploadFile($request->file('insurance_document'), 'portfolios/insurance');
        }
        
        if ($request->hasFile('valuation_report')) {
            $this->deleteOldFile($portfolio->valuation_report);
            $portfolio->valuation_report = $this->uploadFile($request->file('valuation_report'), 'portfolios/valuation');
        }

        $portfolio->save();

        return redirect()->route('portfolios-info.show', $portfolio)
            ->with('success', 'Portfolio updated successfully.');
    }

    /**
     * Remove the specified portfolio from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Delete associated files
        $this->deleteOldFile($portfolio->annual_report);
        $this->deleteOldFile($portfolio->trust_deed_document);
        $this->deleteOldFile($portfolio->insurance_document);
        $this->deleteOldFile($portfolio->valuation_report);
        
        $portfolio->delete();

        return redirect()->route('portfolios-info.index')
            ->with('success', 'Portfolio deleted successfully.');
    }

    /**
     * Upload a file and return the filename.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $path
     * @return string
     */
    private function uploadFile($file, $path)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $filename, 'public');
        
        return $path . '/' . $filename;
    }

    /**
     * Delete an old file if it exists.
     *
     * @param  string|null  $filePath
     * @return void
     */
    private function deleteOldFile($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}