<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;

class IssuerController extends Controller
{
    /**
     * Display a listing of the resource (with search).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $issuers = Issuer::when($search, function ($query) use ($search) {
            $query->where('issuer_short_name', 'like', "%{$search}%")
                  ->orWhere('issuer_name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->appends(['search' => $search]); // Preserve search in pagination

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
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'reminder_1' => 'nullable|date',
            'reminder_2' => 'nullable|date',
            'reminder_3' => 'nullable|date',
            'trustee_role_1' => 'nullable|string|max:100',
            'trustee_role_2' => 'nullable|string|max:100',
            'trust_deed_date' => 'required|date',
        ]);

        // Explicit field mapping (safer than $request->all())
        Issuer::create($validated);
        
        return redirect()->route('issuers.index')->with('success', 'Issuer created successfully.');
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
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'reminder_1' => 'nullable|date',
            'reminder_2' => 'nullable|date',
            'reminder_3' => 'nullable|date',
            'trustee_role_1' => 'nullable|string|max:100',
            'trustee_role_2' => 'nullable|string|max:100',
            'trust_deed_date' => 'required|date',
        ]);

        // Explicit field mapping
        $issuer->update($validated);
        
        return redirect()->route('issuers.index')->with('success', 'Issuer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issuer $issuer)
    {
        $issuer->delete();
        return redirect()->route('issuers.index')->with('success', 'Issuer deleted successfully.');
    }
}