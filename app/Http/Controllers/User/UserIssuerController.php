<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;
use Illuminate\Support\Facades\Auth;

class UserIssuerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $issuers = Issuer::when($search, function ($query) use ($search) {
            $query->where('issuer_short_name', 'like', "%{$search}%")
                ->orWhere('issuer_name', 'like', "%{$search}%")
                ->orWhere('registration_number', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]); // Preserve search in pagination

        return view('user.issuers.index', compact('issuers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.issuers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateIssuer($request);
        
        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Pending';

        try {
            $issuer = Issuer::create($validated);
            return redirect()->route('issuers-info.show', $issuer)->with('success', 'Issuer created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating issuer: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        // Load related bonds
        $issuer->load('bonds');
        return view('user.issuers.show', compact('issuer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        return view('user.issuers.edit', compact('issuer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        $validated = $this->validateIssuer($request, $issuer);

        try {
            $issuer->update($validated);
            return redirect()->route('issuers-info.show', $issuer)->with('success', 'Issuer updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating issuer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        
        try {
            $issuer->delete();
            return redirect()->route('issuers-info.index')->with('success', 'Issuer deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting issuer: ' . $e->getMessage());
        }
    }

    /**
     * Submit issuer for approval
     */
    public function submitForApproval(Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        
        try {
            $issuer->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()->route('issuers-info.show', $issuer)
                ->with('success', 'Issuer submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }

    /**
     * Approve the issuer
     */
    public function approve(Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        
        try {
            $issuer->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()->route('issuers-info.show', $issuer)
                ->with('success', 'Issuer approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving issuer: ' . $e->getMessage());
        }
    }

    /**
     * Reject the issuer
     */
    public function reject(Request $request, Issuer $issuers_info)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);
        
        $issuer = $issuers_info;
        
        try {
            $issuer->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);
            
            return redirect()->route('issuers-info.show', $issuer)
                ->with('success', 'Issuer rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting issuer: ' . $e->getMessage());
        }
    }

    /**
     * Validate issuer data
     */
    protected function validateIssuer(Request $request, Issuer $issuer = null)
    {
        return $request->validate([
            'issuer_short_name' => 'required|string|max:50' . ($issuer ? '|unique:issuers,issuer_short_name,'.$issuer->id : '|unique:issuers'),
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required' . ($issuer ? '|unique:issuers,registration_number,'.$issuer->id : '|unique:issuers'),
            'debenture' => 'nullable|string|max:255',
            'trustee_fee_amount_1' => 'nullable|numeric|min:0',
            'trustee_fee_amount_2' => 'nullable|numeric|min:0',
            'trustee_role_1' => 'nullable|string|max:255',
            'trustee_role_2' => 'nullable|string|max:255',
            'reminder_1' => 'nullable|date',
            'reminder_2' => 'nullable|date',
            'reminder_3' => 'nullable|date',
            'trust_deed_date' => 'nullable|date',
            'status' => 'nullable|in:Active,Inactive,Pending,Rejected',
            'remarks' => 'nullable|string',
        ]);
    }
}