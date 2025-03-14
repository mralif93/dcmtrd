<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Issuer;

class ApproverController extends Controller
{
    public function index()
    {
        $issuers = Issuer::query()->where('status', 'Pending')->latest()->paginate(10);
        return view('approver.index', compact('issuers'));
    }

    public function IssuerEdit(Issuer $issuer)
    {
        return view('approver.issuer.edit', compact('issuer'));
    }

    public function IssuerUpdate(Request $request, Issuer $issuer)
    {
        $validated = $this->validateIssuer($request, $issuer);

        try {
            $issuer->update($validated);
            return redirect()->route('issuer.show', $issuer)->with('success', 'Issuer updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating issuer: ' . $e->getMessage());
        }
    }

    public function IssuerShow(Issuer $issuer)
    {
        // Load related bonds if relationship exists
        if (method_exists($issuer, 'bonds')) {
            $issuer->load('bonds');
        }
        return view('approver.issuer.show', compact('issuer'));
    }

    /**
     * Validate issuer data based on schema
     */
    protected function validateIssuer(Request $request, Issuer $issuer = null)
    {
        return $request->validate([
            'issuer_short_name' => 'required|string|max:50' . ($issuer ? '|unique:issuers,issuer_short_name,'.$issuer->id : '|unique:issuers'),
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required' . ($issuer ? '|unique:issuers,registration_number,'.$issuer->id : '|unique:issuers'),
            'debenture' => 'nullable|string|max:255',
            'trustee_role_1' => 'nullable|string|max:255',
            'trustee_role_2' => 'nullable|string|max:255',
            'trust_deed_date' => 'nullable|date',
            'trust_amount_escrow_sum' => 'nullable|string|max:255',
            'no_of_share' => 'nullable|string|max:255',
            'outstanding_size' => 'nullable|string|max:255',
            'status' => 'nullable|in:Active,Inactive,Pending,Rejected',
            'remarks' => 'nullable|string',
        ]);
    }

    /**
     * Approve the issuer
     */
    public function approve(Issuer $issuer)
    {
        try {
            $issuer->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Issuer approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving issuer: ' . $e->getMessage());
        }
    }

    /**
     * Reject the issuer
     */
    public function reject(Request $request, Issuer $issuer)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $issuer->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Issuer rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting issuer: ' . $e->getMessage());
        }
    }
}
