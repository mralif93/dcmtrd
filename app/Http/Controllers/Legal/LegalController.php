<?php

namespace App\Http\Controllers\Legal;

use App\Models\Bank;
use App\Models\Lease;
use App\Models\Tenant;

// REITs
use App\Models\Property;
use App\Models\Checklist;
use App\Models\Financial;
use App\Models\Portfolio;
use App\Models\SiteVisit;
use App\Models\ListSecurity;
use Illuminate\Http\Request;
use App\Models\FinancialType;
use App\Models\PortfolioType;
use App\Models\SecurityDocRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ChecklistLegalDocumentation;
use App\Http\Requests\RequestDocumentsStoreRequest;

class LegalController extends Controller
{
    public function index(Request $request)
    {
        // Start with the Checklist query
        $query = Checklist::with(['siteVisit.property', 'legalDocumentation']);

        // Get checklists with related data
        $checklists = $query->latest()->paginate(10)->withQueryString();

        return view('legal.index', compact('checklists'));
    }

    // Checklist Module
    public function ChecklistShow(Checklist $checklist)
    {
        return view('legal.checklist.show', compact('checklist'));
    }

    // Checklist Legal Module
    public function ChecklistLegalDocumentationEdit(Checklist $checklist)
    {
        $checklistLegalDocumentation = $checklist->legalDocumentation;
        return view('legal.checklist.legal-documentation.edit', compact('checklistLegalDocumentation'));
    }

    public function ChecklistLegalDocumentationUpdate(Request $request, ChecklistLegalDocumentation $checklistLegalDocumentation)
    {
        $validated = $this->ChecklistLegalDocumentationValidate($request);

        $validated['verified_by'] = Auth::user()->name;
        $validated['status'] = 'Active';

        try {
            // Update the legal documentation
            $checklistLegalDocumentation->update($validated);

            // Updated checklist to active
            $checklist = $checklistLegalDocumentation->checklist;
            $checklist['verified_by'] = Auth::user()->name;
            $checklist['status'] = 'Active';
            $checklist['approval_datetime'] = now();
            $checklist->update();

            return redirect()->route('legal.dashboard', ['section' => 'reits'])->with('success', 'Legal documentation updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating legal documentation: ' . $e->getMessage());
        }
    }

    public function ChecklistLegalDocumentationValidate(Request $request, ChecklistLegalDocumentation $checklistLegalDocumentation = null)
    {
        return $request->validate([
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
            'status' => 'nullable|string|in:active,pending,rejected,inactive',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    public function ChecklistLegalDocumentationShow(Checklist $checklist)
    {
        return view('legal.checklist-legal-documentation.show', compact('checklist'));
    }

    public function SecDocuments(Request $request)
    {
        $getListReq = SecurityDocRequest::with('listSecurity.issuer')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $securities = ListSecurity::with('issuer')->latest()->where('status', 'Active')->paginate(10)->withQueryString();

        return view('legal.dcmt.index', compact('getListReq', 'securities'));
    }

    public function RequestDocuments($id): View
    {
        $getListSec = ListSecurity::with('issuer')->findOrFail($id);

        $getListReq = SecurityDocRequest::with('listSecurity.issuer')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('legal.dcmt.request', compact('getListSec', 'getListReq'));
    }

    public function RequestDocumentsStore(RequestDocumentsStoreRequest $request, $id)
    {
        // Add the list_security_id to the validated data
        $validated = $request->validated();
        $validated['list_security_id'] = $id;  // This will add the list_security_id

        // Add extra fields
        $validated['prepared_by'] = Auth::user()->name;

        // Set the status to 'Pending' by default
        $validated['status'] = 'Pending';
        $validated['request_date'] = now(); // Set the request date to the current date

        // Create the document request
        SecurityDocRequest::create($validated);

        return redirect()->route('legal.sec-documents')->with('success', 'Document request created successfully.');
    }
}
