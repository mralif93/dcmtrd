<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// REITs
use App\Models\Bank;
use App\Models\FinancialType;
use App\Models\PortfolioType;
use App\Models\Portfolio;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Financial;
use App\Models\Checklist;
use App\Models\SiteVisit;

class LegalController extends Controller
{
    public function index(Request $request)
    {
        $query = Checklist::query();
        $checklists = $query->latest()->paginate(10)->withQueryString();
        return view('legal.index', compact('checklists'));
    }

    // Checklist Module
    public function ChecklistEdit(Checklist $checklist)
    {
        $siteVisits = SiteVisit::where('status', 'Active')->get();
        return view('legal.checklist.edit', compact('checklist', 'siteVisits'));
    }

    public function ChecklistUpdate(Request $request, Checklist $checklist)
    {
        $validated = $this->ChecklistValidate($request);

        $validated['verified_by'] = Auth::user()->name;
        $validated['status'] = 'Active';

        try {
            $checklist->update($validated);
            return redirect()->route('legal.dashboard', ['section' => 'reits'])->with('success', 'Checklist updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistValidate(Request $request, Checklist $checklist = null)
    {
        return $request->validate([
            // 1.0 Legal Documentation
            'title_ref' => 'nullable|string|max:255',
            'title_location' => 'nullable|string|max:255',
            'trust_deed_ref' => 'nullable|string|max:255',
            'trust_deed_location' => 'nullable|string|max:255',
            'sale_purchase_agreement' => 'nullable|string|max:255',
            'lease_agreement_ref' => 'nullable|string|max:255',
            'lease_agreement_location' => 'nullable|string|max:255',
            'agreement_to_lease' => 'nullable|string|max:255',
            'maintenance_agreement_ref' => 'nullable|string|max:255',
            'maintenance_agreement_location' => 'nullable|string|max:255',
            'development_agreement' => 'nullable|string|max:255',
            'other_legal_docs' => 'nullable|string',
        ]);
    }

    public function ChecklistShow(Checklist $checklist)
    {
        return view('legal.checklist.show', compact('checklist'));
    }
}
