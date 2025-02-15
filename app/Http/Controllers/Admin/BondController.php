<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Issuer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class BondController extends Controller
{
    /**
     * Display a listing of the resource with search.
     */
    public function index(Request $request)
    {
        try {
            $searchTerm = $request->input('search');
            
            $bonds = Bond::with('issuer')
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    return $query->where(function ($q) use ($searchTerm) {
                        $q->where('bond_sukuk_name', 'LIKE', "%{$searchTerm}%")
                          ->orWhere('rating', 'LIKE', "%{$searchTerm}%")
                          ->orWhere('facility_code', 'LIKE', "%{$searchTerm}%");
                    });
                })
                ->latest()
                ->paginate(config('app.pagination_per_page', 10));

            return view('admin.bonds.index', compact('bonds', 'searchTerm'));

        } catch (\Exception $e) {
            Log::error('Bond index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading bonds');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $issuers = Cache::remember('issuers_list', 3600, function () {
                return Issuer::orderBy('issuer_name')->get();
            });

            return view('admin.bonds.create', compact('issuers'));

        } catch (\Exception $e) {
            Log::error('Bond create form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading form');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'issuer_id' => 'required|exists:issuers,id',
                'bond_sukuk_name' => 'required|string|max:100|unique:bonds',
                'sub_name' => 'nullable|string|max:100',
                'rating' => 'required|string|in:AAA,AA+,AA,AA-,A+,A,A-,BBB+,BBB,BBB-,BB+,BB,BB-,B+,B,B-,CCC,CC,C,D',
                'category' => 'required|string|max:50',
                'last_traded_date' => 'required|date_format:Y-m-d',
                'last_traded_yield' => 'required|numeric|between:0,99.99',
                'last_traded_price' => 'required|numeric|min:0',
                'last_traded_amount' => 'required|numeric|min:0',
                'o_s_amount' => 'required|numeric|min:0',
                'residual_tenure' => 'required|integer|min:0|max:100',
                'facility_code' => 'required|string|max:50',
                'status' => 'required|in:active,inactive,matured',
                'approval_date_time' => 'nullable|date',
            ]);

            Bond::create([
                ...$validated,
                'last_traded_date' => Carbon::parse($validated['last_traded_date']),
                'approval_date_time' => $validated['approval_date_time'] 
                    ? Carbon::parse($validated['approval_date_time'])
                    : now(),
            ]);

            return redirect()->route('bonds.index')
                ->with('success', 'Bond created successfully');

        } catch (\Exception $e) {
            Log::error('Bond store error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating bond: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bond $bond)
    {
        // Load relationships normally
        $bond->load(['issuer', 'bondInfo']);
        return view('admin.bonds.show', compact('bond'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bond $bond)
    {
        $issuers = Issuer::all();
        return view('admin.bonds.edit', compact('bond', 'issuers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bond $bond)
    {
        try {
            $validated = $request->validate([
                'issuer_id' => 'required|exists:issuers,id',
                'bond_sukuk_name' => 'required|string|max:100|unique:bonds,bond_sukuk_name,'.$bond->id,
                'sub_name' => 'nullable|string|max:100',
                'rating' => 'required|string|in:AAA,AA+,AA,AA-,A+,A,A-,BBB+,BBB,BBB-,BB+,BB,BB-,B+,B,B-,CCC,CC,C,D',
                'category' => 'required|string|max:50',
                'last_traded_date' => 'required|date_format:Y-m-d',
                'last_traded_yield' => 'required|numeric|between:0,99.99',
                'last_traded_price' => 'required|numeric|min:0',
                'last_traded_amount' => 'required|numeric|min:0',
                'o_s_amount' => 'required|numeric|min:0',
                'residual_tenure' => 'required|integer|min:0|max:100',
                'facility_code' => 'required|string|max:50',
                'status' => 'required|in:active,inactive,matured',
                'approval_date_time' => 'nullable|date',
            ]);
    
            $updateData = [
                ...$validated,
                'last_traded_date' => Carbon::parse($validated['last_traded_date']),
                'approval_date_time' => isset($validated['approval_date_time']) 
                    ? Carbon::parse($validated['approval_date_time'])
                    : $bond->approval_date_time
            ];
    
            $bond->update($updateData);
    
            return redirect()->route('bonds.index')
                ->with('success', 'Bond updated successfully');
    
        } catch (\Exception $e) {
            Log::error('Bond update error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bond $bond)
    {
        try {
            $this->authorize('delete', $bond);
            
            $bond->delete();
            
            return redirect()->route('bonds.index')
                ->with('success', 'Bond deleted successfully');

        } catch (\Exception $e) {
            Log::error('Bond destroy error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error deleting bond: ' . $e->getMessage());
        }
    }
}