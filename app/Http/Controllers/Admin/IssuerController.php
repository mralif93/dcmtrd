<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;

class IssuerController extends Controller
{
    /**
     * Display a listing of the resource (with search and filters).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $issuers = Issuer::when($search, function ($query) use ($search) {
            $query->where('issuer_short_name', 'like', "%{$search}%")
                  ->orWhere('issuer_name', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(10)
        ->appends($request->except('page')); // Preserve all filters in pagination

        return view('admin.issuers.index', compact('issuers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.issuers.create');
    }

    /**
     * Store a newly created resource (with explicit fields and validation fixes).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issuer_short_name' => 'required|string|max:50|unique:issuers',
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required|unique:issuers',
            'debenture' => 'nullable|string|max:100',
            'trustee_role_1' => 'nullable|string|max:100',
            'trustee_role_2' => 'nullable|string|max:100',
            'trust_deed_date' => 'required|date',
            'trust_amount_escrow_sum' => 'nullable|string|max:100',
            'no_of_share' => 'nullable|string|max:100',
            'outstanding_size' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'prepared_by' => 'nullable|string|max:100',
            'verified_by' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);

        try {
            $issuer = Issuer::create($validated);
            return redirect()->route('issuers.show', $issuer)->with('success', 'Issuer created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Issuer $issuer)
    {
        return view('admin.issuers.show', compact('issuer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Issuer $issuer)
    {
        return view('admin.issuers.edit', compact('issuer'));
    }

    /**
     * Update the specified resource (with validation fixes).
     */
    public function update(Request $request, Issuer $issuer)
    {
        $validated = $request->validate([
            'issuer_short_name' => 'required|string|max:50|unique:issuers,issuer_short_name,' . $issuer->id,
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required|unique:issuers,registration_number,' . $issuer->id,
            'debenture' => 'nullable|string|max:100',
            'trustee_role_1' => 'nullable|string|max:100',
            'trustee_role_2' => 'nullable|string|max:100',
            'trust_deed_date' => 'required|date',
            'trust_amount_escrow_sum' => 'nullable|string|max:100',
            'no_of_share' => 'nullable|string|max:100',
            'outstanding_size' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'prepared_by' => 'nullable|string|max:100',
            'verified_by' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);

        try {
            $issuer->update($validated);
            return redirect()->route('issuers.show', $issuer)->with('success', 'Issuer updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issuer $issuer)
    {
        try {
            $issuer->delete();
            return redirect()->route('issuers.index')->with('success', 'Issuer deleted successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }
}