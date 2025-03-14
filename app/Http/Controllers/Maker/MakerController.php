<?php

namespace App\Http\Controllers\Maker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;
use Illuminate\Support\Facades\Auth;

class MakerController extends Controller
{
    public function index()
    {
        $issuers = Issuer::query()->where('status', 'Active')->latest()->paginate(10);
        return view('maker.index', compact('issuers'));
    }

    // Issuer Module
    public function IssuerCreate()
    {
        return view('maker.issuer.create');
    }

    public function IssuerStore(Request $request, Issuer $issuer)
    {
        $validated = $this->validateIssuer($request);
        
        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Pending';

        try {
            $issuer = Issuer::create($validated);
            return redirect()->route('dashboard')->with('success', 'Issuer created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating issuer: ' . $e->getMessage());
        }
    }

    public function IssuerEdit(Issuer $issuer)
    {
        return view('maker.issuer.edit', compact('issuer'));
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
        return view('maker.issuer.show', compact('issuer'));
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

    // public function IssuerCreate()
    // {
    //     return view('maker.issuer.create');
    // }

    // public function IssuerStore(Request $request, Issuer $issuer)
    // {
    //     return back()->with('success', 'Issuer created successfully.');
    // }

    // public function IssuerEdit()
    // {
    //     return view('maker.issuer.edit');
    // }

    // public function IssuerUpdate(Request $request, Issuer $issuer)
    // {
    //     return back()->with('success', 'Issuer updated successfully.');
    // }

    // public function IssuerShow(Issuer $issuer)
    // {
    //     return view('maker.issuer.show');
    // }
}
