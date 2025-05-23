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
use App\Jobs\ListSecurity\SendListSecurityRequestEmail;

class LegalController extends Controller
{
    public function indexMain(Request $request)
    {
        // Start with the Checklist query
        $query = Checklist::with(['siteVisit.property', 'legalDocumentation']);

        // Get checklists with related data
        $checklists = $query->latest()->paginate(10)->withQueryString();

        return view('legal.checklist.index', compact('checklists'));
    }
    public function index(Request $request)
    {
        // Start with the Checklist query
        $query = Checklist::with(['siteVisit.property', 'legalDocumentation']);

        // Apply filters if provided
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('legalDocumentation', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('siteVisit.property', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

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

    public function SecDocuments(Request $request)
    {
        $search = $request->input('search');

        $securitiesQuery = ListSecurity::with('issuer')
            ->where('status', 'Active')
            ->latest();

        // Apply search filter if provided
        if ($search) {
            $securitiesQuery->where(function ($query) use ($search) {
                $query->where('security_name', 'like', "%{$search}%")
                    ->orWhereHas('issuer', function ($q) use ($search) {
                        $q->where('issuer_short_name', 'like', "%{$search}%");
                    });
            });
        }

        $securities = $securitiesQuery->paginate(10)->withQueryString();

        $getListReq = SecurityDocRequest::with('listSecurity.issuer')
            ->latest()
            ->paginate(10)
            ->withQueryString();

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

    public function RequestDocumentsCreate()
    {
        $user = Auth::user();

        $listSecurities = ListSecurity::with('issuer')
            ->where('status', 'Active')
            ->latest()
            ->get();

        return view('legal.dcmt.create', compact('user', 'listSecurities'));
    }


    public function RequestDocumentsStore(Request $request)
    {
        $request->validate([
            'security_id' => 'required|exists:list_securities,id',
            'request_date' => 'required|date',
            'purpose' => 'required|string',
        ]);

        SecurityDocRequest::create([
            'list_security_id' => $request->security_id,
            'request_date' => $request->request_date,
            'purpose' => $request->purpose,
            'status' => 'Draft', // or 'Draft'
            'prepared_by' => Auth::user()->name,
        ]);

        return redirect()->route('legal.request-documents.history', $request->security_id)->with('success', 'Document request created successfully.');
    }

    public function RequestDocumentsHistory(ListSecurity $security)
    {
        $history = $security->securityDocRequests()->latest()->get();

        return view('legal.dcmt.history', compact('security', 'history'));
    }

    public function RequestDocumentsEdit(Request $request, $id)
    {
        $documentRequest = SecurityDocRequest::findOrFail($id);

        $listSecurities = ListSecurity::with('issuer')
            ->where('status', 'Active')
            ->latest()
            ->get();

        return view('legal.dcmt.edit', compact('documentRequest', 'listSecurities'));
    }

    public function RequestDocumentsUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'security_id'  => 'required|exists:list_securities,id',
            'request_date' => 'required|date',
            'purpose'      => 'required|string|max:1000',
            'prepared_by'  => 'required|string|max:255',
        ]);

        $documentRequest = SecurityDocRequest::findOrFail($id);

        $documentRequest->update([
            'list_security_id' => $validated['security_id'],
            'request_date'     => $validated['request_date'],
            'purpose'          => $validated['purpose'],
            'prepared_by'      => $validated['prepared_by'],
        ]);

        return redirect()->route('legal.request-documents.history', [
            'security' => $documentRequest->list_security_id,
        ])->with('success', 'Document request updated successfully!');
    }

    public function submitRequest(Request $request, $id)
    {
        $documentRequest = SecurityDocRequest::findOrFail($id);

        $documentRequest->update([
            'status' => 'Pending',
        ]);

        dispatch(new SendListSecurityRequestEmail($documentRequest));

        return redirect()->back()->with('success', 'Document request submitted successfully!');
    }
}
