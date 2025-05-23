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
use App\Models\ChecklistLegalDocumentation;

class LegalController extends Controller
{
    public function index(Request $request)
    {
        // Start with the Checklist query
        $query = Checklist::with(['siteVisit.property', 'legalDocumentation']);
        
        // Apply filters if provided
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('legalDocumentation', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('siteVisit.property', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }
        
        // Get checklists with related data
        $checklists = $query->latest()->paginate(10)->withQueryString();
        
        // Get statuses for dropdown
        $statuses = ['draft', 'active', 'pending', 'rejected', 'inactive'];

        return view('legal.index', compact('checklists', 'statuses'));
    }

    // Checklist Module
    public function ChecklistShow(Checklist $checklist)
    {
        return view('legal.checklist.show', compact('checklist'));
    }

    // Checklist Legal Module
    public function ChecklistLegalDocumentationEdit(ChecklistLegalDocumentation $checklistLegalDocumentation)
    {
        return view('legal.checklist.legal-documentation.edit', compact('checklistLegalDocumentation'));
    }

    public function ChecklistLegalDocumentationUpdate(Request $request, ChecklistLegalDocumentation $checklistLegalDocumentation)
    {
        $validated = $this->ChecklistLegalDocumentationValidate($request);
    
        $validated['verified_by'] = Auth::user()->name;
        $validated['status'] = 'pending';

        try {
            // Update the legal documentation
            $checklistLegalDocumentation->update($validated);
            
            return redirect()
                ->route('legal.dashboard', ['section' => 'reits'])
                ->with('success', 'Legal documentation updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating legal documentation: ' . $e->getMessage());
        }
    }

    public function ChecklistLegalDocumentationShow(ChecklistLegalDocumentation $checklistLegalDocumentation)
    {
        return view('legal.checklist.legal-documentation.show', compact('checklistLegalDocumentation'));
    }

    public function ChecklistLegalDocumentationValidate(Request $request, ChecklistLegalDocumentation $checklistLegalDocumentation = null)
    {
        return $request->validate([
            'title_ref' => 'nullable|string|max:255',
            'title_location' => 'nullable|string|max:255',
            'trust_deed_ref' => 'nullable|string|max:255',
            'trust_deed_location' => 'nullable|string|max:255',
            'sale_purchase_agreement_ref' => 'nullable|string|max:255',
            'sale_purchase_agreement_location' => 'nullable|string|max:255',
            'lease_agreement_ref' => 'nullable|string|max:255',
            'lease_agreement_location' => 'nullable|string|max:255',
            'agreement_to_lease_ref' => 'nullable|string|max:255',
            'agreement_to_lease_location' => 'nullable|string|max:255',
            'maintenance_agreement_ref' => 'nullable|string|max:255',
            'maintenance_agreement_location' => 'nullable|string|max:255',
            'development_agreement_ref' => 'nullable|string|max:255',
            'development_agreement_location' => 'nullable|string|max:255',
            'others_ref' => 'nullable|string|max:255',
            'others_location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,pending,rejected,inactive',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);
    }
}
