<?php

namespace App\Http\Controllers\Maker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BondImport;
use App\Imports\PaymentScheduleImport;
use App\Imports\RatingMovementsImport;
use App\Imports\TradingActivityImport;

use App\Models\User;

// Bonds
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\Announcement;
use App\Models\RelatedDocument;
use App\Models\FacilityInformation;
use App\Models\RatingMovement;
use App\Models\PaymentSchedule;
use App\Models\Redemption;
use App\Models\CallSchedule;
use App\Models\LockoutPeriod;
use App\Models\TradingActivity;
use App\Models\TrusteeFee;
use App\Models\ComplianceCovenant;
use App\Models\ActivityDiary;

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
use App\Models\SiteVisitLog;
use App\Models\Appointment;
use App\Models\ApprovalForm;
use App\Models\ApprovalProperty;
use App\Models\ChecklistLegalDocumentation;
use App\Models\ChecklistTenant;
use App\Models\ChecklistExternalAreaCondition;
use App\Models\ChecklistInternalAreaCondition;
use App\Models\ChecklistPropertyDevelopment;
use App\Models\ChecklistDisposalInstallation;

use App\Http\Requests\User\BondFormRequest;


class MakerController extends Controller
{
    public function index(Request $request)
    {
        // Validate that section parameter is present and valid
        $validSection = $request->has('section') && in_array($request->section, ['reits', 'dcmtrd']);
        
        // Issuers Query
        $query = Issuer::query();
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('issuer_name', 'LIKE', '%' . $search . '%')
                ->orWhere('issuer_short_name', 'LIKE', '%' . $search . '%')
                ->orWhere('registration_number', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
    
        // Get filtered issuers with latest first and paginate
        $issuers = $query->whereIn('status', ['Active', 'Inactive', 'Rejected', 'Draft'])
                        ->latest()
                        ->paginate(10)
                        ->withQueryString();
    
        // Get count data from cache or database
        $counts = Cache::remember('dashboard_user_counts', now()->addMinutes(1), function () {
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM trustee_fees) AS trustee_fees_count,
                    (SELECT COUNT(*) FROM compliance_covenants) AS compliance_covenants_count,
                    (SELECT COUNT(*) FROM activity_diaries) AS activity_diaries_count,

                    (SELECT COUNT(*) FROM trustee_fees WHERE status = 'pending') AS trustee_fees_pending_count,
                    (SELECT COUNT(*) FROM compliance_covenants WHERE status = 'pending') AS compliance_covenants_pending_count,
                    (SELECT COUNT(*) FROM activity_diaries WHERE status = 'pending') AS activity_diaries_pending_count,
                
                    (SELECT COUNT(*) FROM portfolios) AS portfolios_count,
                    (SELECT COUNT(*) FROM properties) AS properties_count,
                    (SELECT COUNT(*) FROM financials) AS financials_count,
                    (SELECT COUNT(*) FROM leases) AS leases_count,
                    (SELECT COUNT(*) FROM tenants) AS tenants_count,
                    (SELECT COUNT(*) FROM site_visits) AS site_visists_count,
                    (SELECT COUNT(*) FROM checklists) AS checklists_count,
                    (SELECT COUNT(*) FROM site_visit_logs) AS site_visit_logs_count,
                    (SELECT COUNT(*) FROM appointments) AS appointments_count,
                    (SELECT COUNT(*) FROM approval_forms) AS approval_forms_count,
                    (SELECT COUNT(*) FROM approval_properties) AS approval_properties_count,

                    (SELECT COUNT(*) FROM portfolios WHERE status = 'pending') AS pending_portfolios_count,
                    (SELECT COUNT(*) FROM properties WHERE status = 'pending') AS pending_properties_count,
                    (SELECT COUNT(*) FROM financials WHERE status = 'pending') AS pending_financials_count,
                    (SELECT COUNT(*) FROM leases WHERE status = 'pending') AS pending_leases_count,
                    (SELECT COUNT(*) FROM tenants WHERE status = 'pending') AS pending_tenants_count,
                    (SELECT COUNT(*) FROM site_visits WHERE status = 'pending') AS pending_site_visits_count,
                    (SELECT COUNT(*) FROM checklists WHERE status = 'pending') AS pending_checklists_count,
                    (SELECT COUNT(*) FROM site_visit_logs WHERE status = 'pending') AS pending_site_visit_logs_count,
                    (SELECT COUNT(*) FROM appointments WHERE status = 'pending') AS pending_appointments_count,
                    (SELECT COUNT(*) FROM approval_forms WHERE status = 'pending') AS pending_approval_forms_count,
                    (SELECT COUNT(*) FROM approval_properties WHERE status = 'pending') AS pending_approval_properties_count
            ");
            return (array) $result[0];
        });
    
        // Portfolios Query - also section-specific
        $portfolioQuery = Portfolio::query()->whereIn('status', ['draft', 'active', 'pending', 'rejected', 'inactive']);
        
        // Apply search filter to portfolios
        if ($request->has('search') && !empty($request->search)) {
            $portfolioQuery->where('portfolio_name', 'LIKE', '%' . $request->search . '%');
        }
        
        // Apply status filter to portfolios
        if ($request->has('status') && !empty($request->status)) {
            $portfolioQuery->where('status', $request->status);
        }

        // Execute the query after all filters are applied
        $portfolios = $portfolioQuery->latest()->paginate(10)->withQueryString();
    
        return view('maker.index', [
            'issuers' => $issuers,
            'portfolios' => $portfolios,
            'currentSection' => $request->section,
            'trusteeFeesCount' => $counts['trustee_fees_count'],
            'complianceCovenantCount' => $counts['compliance_covenants_count'],
            'activityDairyCount' => $counts['activity_diaries_count'],
            'propertiesCount' => $counts['properties_count'],
            'financialsCount' => $counts['financials_count'],
            'tenantsCount' => $counts['tenants_count'],
            'appointmentsCount' => $counts['appointments_count'],
            'approvalFormsCount' => $counts['approval_forms_count'],
            'approvalPropertiesCount' => $counts['approval_properties_count'],
            'siteVisitLogsCount' => $counts['site_visit_logs_count'],
            
            // Adding pending counts
            'trusteeFeePendingCount' => $counts['trustee_fees_pending_count'],
            'complianceCovenantPendingCount' => $counts['compliance_covenants_pending_count'],
            'activityDiaryPendingCount' => $counts['activity_diaries_pending_count'],
            'propertiesPendingCount' => $counts['pending_properties_count'],
            'financialsPendingCount' => $counts['pending_financials_count'],
            'tenantsPendingCount' => $counts['pending_tenants_count'],
            'appointmentsPendingCount' => $counts['pending_appointments_count'],
            'approvalFormsPendingCount' => $counts['pending_approval_forms_count'],
            'approvalPropertiesPendingCount' => $counts['pending_approval_properties_count'],
            'siteVisitLogsPendingCount' => $counts['pending_site_visit_logs_count'],
        ]);
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
        $validated['status'] = 'draft';

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
            return redirect()->route('issuer-m.show', $issuer)->with('success', 'Issuer updated successfully.');
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
    protected function validateIssuer(Request $request)
    {
        return $request->validate([
            'issuer_short_name' => 'nullable|string|max:50',
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required' . ($issuer ? '|unique:issuers,registration_number,'.$issuer->id : '|unique:issuers'),
            'debenture' => 'nullable|string|max:255',
            'trustee_role_1' => 'nullable|string|max:255',
            'trustee_role_2' => 'nullable|string|max:255',
            'trust_deed_date' => 'nullable|date',
            'trust_amount_escrow_sum' => 'nullable|string|max:255',
            'no_of_share' => 'nullable|string|max:255',
            'outstanding_size' => 'nullable|string|max:255',
            'status' => 'nullable|in:Draft,Active,Inactive,Pending,Rejected',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'approval_datetime' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);
    }

    /**
     * Submit issuer for approval
     */
    public function submitForApproval(Issuer $issuer)
    {
        try {
            $issuer->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()->route('maker.dashboard', $issuer)->with('success', 'Issuer submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }

    // List of Details
    public function BondIndex(Issuer $issuer)
    {
        // items per page
        $perPage = 10;

        // Bonds with empty state handling
        $bonds = $issuer->bonds()
            ->paginate($perPage, ['*'], 'bondsPage');

        // Announcements with empty handling
        $announcements = $issuer->announcements()
            ->latest()
            ->paginate($perPage, ['*'], 'announcementsPage');

        // Documents with empty handling
        $documents = $issuer->documents()
            ->paginate($perPage, ['*'], 'documentsPage');

        // Facilities with empty handling
        $facilities = $issuer->facilities()
            ->paginate($perPage, ['*'], 'facilitiesPage');

        return view('maker.details', [
            'issuer' => $issuer,
            'bonds' => $bonds,
            'announcements' => $announcements,
            'documents' => $documents,
            'facilities' => $facilities,
        ]);
    }

    // Bond Module
    public function BondCreate(Issuer $issuer)
    {
        $issuerInfo = $issuer;
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.bond.create', compact('issuers', 'issuerInfo'));
    }

    public function BondStore(BondFormRequest $request, Bond $bond)
    {
        $validated = $request->validated();
        
        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Pending';

        try {
            $bond = Bond::create($validated);
            return redirect()->route('bond-m.details', $bond->issuer)->with('success', 'Bond created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function BondEdit(Bond $bond)
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.bond.edit', compact('bond', 'issuers'));
    }

    public function BondUpdate(BondFormRequest $request, Bond $bond)
    {
        $validated = $request->validated();

        try {
            $bond->update($validated);
            return redirect()->route('bond-m.details', $bond->issuer)->with('success', 'Bond updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function BondShow(Bond $bond)
    {
        $bond->load([
            'issuer',
            'ratingMovements',
            'paymentSchedules',
            'tradingActivities' => fn($q) => $q->latest()->limit(10),
            'redemption.callSchedules',
            'redemption.lockoutPeriods',
            'charts'
        ]);
        
        // Get related documents through the issuer
        $relatedDocuments = null;
        if ($bond->issuer) {
            // Get the facilityInformation linked to this bond
            $facilityCode = $bond->facility_code;
            
            if ($facilityCode) {
                $facilityInfo = $bond->issuer->facilities()
                    ->where('facility_code', $facilityCode)
                    ->first();
                    
                if ($facilityInfo) {
                    $relatedDocuments = $facilityInfo->documents()
                        ->orderBy('upload_date', 'desc')
                        ->paginate(10);
                }
            }
        }

        return view('maker.bond.show', compact('bond', 'relatedDocuments'));
    }

    public function BondUploadForm(Issuer $issuer)
    {
        return view('maker.bond.upload', compact('issuer'));
    }

    public function BondUploadStore(Request $request, Issuer $issuer)
    {
        $file = $request->file('bond_file');

        Excel::import(new BondImport, $file);

        return redirect()
            ->route('bond-m.details', $issuer)
            ->with('success', 'Bond data uploaded successfully');
    }

    protected function validateBond(Request $request)
    {
        return $request->validate([
            'bond_sukuk_name' => 'required|string|max:255',
            'sub_name' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'principal' => 'nullable|string|max:100',
            'islamic_concept' => 'nullable|string|max:100',
            'isin_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'stock_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'instrument_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('bonds')->ignore($bond?->id)
            ],
            'sub_category' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'maturity_date' => 'nullable|date|after:issue_date',
            'coupon_rate' => 'nullable|numeric|between:0,100',
            'coupon_type' => 'nullable|in:Fixed,Floating',
            'coupon_frequency' => 'nullable|in:Monthly,Quarterly,Semi-Annually,Annually',
            'day_count' => 'nullable|string|max:50',
            'issue_tenure_years' => 'nullable|numeric|min:0',
            'residual_tenure_years' => 'nullable|numeric|min:0',
            'last_traded_yield' => 'nullable|numeric|min:0',
            'last_traded_price' => 'nullable|numeric|min:0',
            'last_traded_amount' => 'nullable|numeric|min:0',
            'last_traded_date' => 'nullable|date',
            'coupon_accrual' => 'nullable|date',
            'prev_coupon_payment_date' => 'nullable|date',
            'first_coupon_payment_date' => 'nullable|date',
            'next_coupon_payment_date' => 'nullable|date',
            'last_coupon_payment_date' => 'nullable|date',
            'amount_issued' => 'nullable|numeric|min:0',
            'amount_outstanding' => 'nullable|numeric|min:0',
            'lead_arranger' => 'nullable|string|max:255',
            'facility_agent' => 'nullable|string|max:255',
            'facility_code' => [
                'nullable',
                'string',
                'max:50',
                // Changed to check if facility_code exists in facility_informations table
                // rather than requiring uniqueness across all bonds
                $bond ? 'exists:facility_informations,facility_code' : 'exists:facility_informations,facility_code'
            ],
            'status' => 'nullable|in:Active,Inactive,Matured,Pending',
            'remarks' => 'nullable|string',
            'issuer_id' => 'required|exists:issuers,id',
        ], [
            'maturity_date.after' => 'Maturity date must be after issue date',
            'coupon_rate.between' => 'Coupon rate must be between 0 and 100 percent',
            'issuer_id.exists' => 'The selected issuer is invalid',
            'unique' => 'This :attribute is already in use',
        ]);
    }

    // Announcement Module
    public function AnnouncementCreate(Issuer $issuer)
    {
        $issuerInfo = $issuer;
        $issuers = Issuer::all();
        return view('maker.announcement.create', compact('issuers', 'issuerInfo'));
    }

    public function AnnouncementStore(Request $request)
    {
        $validated = $this->validateAnnouncement($request);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments');
        }

        try {
            $announcement = Announcement::create($validated);
            return redirect()->route('bond-m.details', $announcement->issuer)->with('success', 'Announcement created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating: ' . $e->getMessage()])->withInput();
        }
    }

    public function AnnouncementEdit(Announcement $announcement)
    {
        $announcement = $announcement->load('issuer');
        $issuers = Issuer::all();
        return view('maker.announcement.edit', compact('announcement', 'issuers'));
    }
    
    public function AnnouncementUpdate(Request $request, Announcement $announcement)
    {
        $validated = $this->validateAnnouncement($request);

        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($announcement->attachment) {
                Storage::delete($announcement->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('attachments');
        }

        try {
            $announcement->update($validated);
            return redirect()->route('bond-m.details', $announcement->issuer)->with('success', 'Announcement updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    public function AnnouncementShow(Announcement $announcement)
    {
        $announcement = $announcement->load('issuer');
        return view('maker.announcement.show', compact('announcement'));
    }

    protected function validateAnnouncement(Request $request)
    {
        return $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'category' => 'required|string|max:50',
            'sub_category' => 'nullable|string|max:50',
            'source' => 'required|string|max:100',
            'announcement_date' => 'required|date',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
    }

    // Document Module
    public function DocumentCreate(Issuer $issuer)
    {
        $facilities = FacilityInformation::all();
        return view('maker.related-document.create', compact('facilities', 'issuer'));
    }
    
    public function DocumentStore(Request $request)
    {
        $validated = $this->validateDocument($request);

        $file = $request->file('document_file');
        $validated['file_path'] = $file->store('documents');

        $relatedDocument = RelatedDocument::create($validated);
        $facility = FacilityInformation::findOrFail($validated['facility_id']);
        return redirect()->route('bond-m.details', $facility->issuer)->with('success', 'Document created successfully');
    }

    public function DocumentEdit(RelatedDocument $document)
    {
        $facilities = FacilityInformation::all();
        return view('maker.related-document.edit', compact('document', 'facilities'));
    }

    public function DocumentUpdate(Request $request, RelatedDocument $document)
    {
        $validated = $this->validateDocument($request);

        dd($request->hasFile('document_file'));

        if ($request->hasFile('document_file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::delete($document->file_path);
            }
            // Store new file
            $validated['file_path'] = $request->file('document_file')->store('documents');
        }

        $document->update($validated);
        $facility = FacilityInformation::findOrFail($validated['facility_id']);
        return redirect()->route('bond-m.details', $facility->issuer)->with('success', 'Document updated successfully');
    }

    public function DocumentShow(RelatedDocument $document)
    {
        return view('maker.related-document.show', compact('document'));
    }

    protected function validateDocument(Request $request)
    {
        return $request->validate([
            'facility_id' => 'required|exists:facility_informations,id',
            'document_name' => 'required|max:200',
            'document_type' => 'required|max:50',
            'upload_date' => 'required|date',
            'document_file' => 'nullable|file|mimes:pdf|max:51200'
        ]);
    }

    // Facility Information Module
    public function FacilityInfoCreate(Issuer $issuer)
    {
        $issuerInfo = $issuer;
        $issuers = Issuer::all();
        return view('maker.facility-information.create', compact('issuers', 'issuerInfo'));
    }

    public function FacilityInfoStore(Request $request)
    {
        $validated = $this->validateFacilityInfo($request);

        // Set guaranteed to false if not present
        $validated['guaranteed'] = $request->has('guaranteed') ? true : false;

        $facilityInformation = FacilityInformation::create($validated);
        return redirect()->route('bond-m.details', $facilityInformation->issuer)->with('success', 'Facility Information created successfully');
    }

    public function FacilityInfoEdit(FacilityInformation $facility)
    {
        $issuers = Issuer::all();
        return view('maker.facility-information.edit', compact('facility', 'issuers'));
    }

    public function FacilityInfoUpdate(Request $request, FacilityInformation $facility)
    {
        $validated = $this->validateFacilityInfo($request, $facility);

        // Set guaranteed to false if not present
        $validated['guaranteed'] = $request->has('guaranteed') ? true : false;

        $facility->update($validated);
        return redirect()->route('bond-m.details', $facility->issuer)->with('success', 'Facility Information updated successfully');
    }

    public function FacilityInfoShow(FacilityInformation $facility)
    {
        // Items per page
        $perPage = 10;
    
        // Fetch bonds with pagination
        $bonds = $facility->issuer->bonds()
            ? $facility->issuer->bonds()->paginate($perPage, ['*'], 'bondsPage')
            : collect(); // Use an empty collection instead of $emptyPaginator
    
        // Documents Pagination
        $documents = $facility->documents()
            ? $facility->documents()->paginate($perPage, ['*'], 'documentsPage')
            : collect(); // Use an empty collection instead of $emptyPaginator
    
        // Load all rating movements across all bonds
        $allRatingMovements = $facility->issuer->bonds->flatMap(function ($bond) {
            return $bond->ratingMovements; // Collect rating movements from each bond
        });

        // Paginate the rating movements
        $currentPage = request()->get('ratingMovementsPage', 1); // Get current page from request
        $currentPageItems = $allRatingMovements->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Slice the collection
        $ratingMovements = new LengthAwarePaginator($currentPageItems, $allRatingMovements->count(), $perPage, $currentPage, [
            'path' => request()->url(), // Set the path for pagination links
            'query' => request()->query(), // Preserve query parameters
        ]);

        return view('maker.facility-information.show', [
            'issuer' => $facility->issuer,
            'facility' => $facility,
            'activeBonds' => $bonds,
            'documents' => $documents,
            'ratingMovements' => $ratingMovements,
        ]);
    }

    protected function validateFacilityInfo(Request $request)
    {
        return $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'facility_code' => 'required|max:50|' . ($facility ? 'unique:facility_informations,facility_code,'.$facility->id : 'unique:facility_informations'),
            'facility_number' => 'required|max:50|' . ($facility ? 'unique:facility_informations,facility_number,'.$facility->id : 'unique:facility_informations'),
            'facility_name' => 'required|max:100',
            'principle_type' => 'nullable|max:50',
            'islamic_concept' => 'nullable|max:100',
            'maturity_date' => 'nullable|date',
            'instrument' => 'nullable|max:50',
            'instrument_type' => 'nullable|max:50',
            'guaranteed' => 'nullable|boolean',
            'total_guaranteed' => 'nullable|numeric|min:0',
            'indicator' => 'nullable|max:50',
            'facility_rating' => 'nullable|max:50',
            'facility_amount' => 'nullable|numeric|min:0',
            'available_limit' => 'nullable|numeric|min:0',
            'outstanding_amount' => 'nullable|numeric|min:0',
            'trustee_security_agent' => 'nullable|max:100',
            'lead_arranger' => 'nullable|max:100',
            'facility_agent' => 'nullable|max:100',
            'availability_date' => 'nullable|date',
        ]);
    }

    // Rating Movement Module
    public function RatingMovementCreate(Bond $bond)
    {
        $bondInfo = $bond;
        $issuerId = $bondInfo->issuer->id;
        $bonds = Bond::where('issuer_id', $issuerId)->get();
        return view('maker.rating-movement.create', compact('bonds', 'bondInfo'));
    }

    public function RatingMovementStore(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'rating_agency' => 'required|string|max:100',
            'effective_date' => 'required|date',
            'rating_tenure' => 'required|string|max:50',
            'rating' => 'nullable|string|max:50',
            'rating_action' => 'nullable|string|max:50',
            'rating_outlook' => 'nullable|string|max:50',
            'rating_watch' => 'nullable|string|max:50',
        ]);

        try {
            $rating = RatingMovement::create($validated);
            return redirect()->route('bond-m.show', $rating->bond)->with('success', 'Rating movement created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function RatingMovementShow(RatingMovement $rating)
    {
        $rating->load('bond.issuer');
        return view('maker.rating-movement.show', compact('rating'));
    }

    public function RatingMovementEdit(RatingMovement $rating)
    {
        $issuerId = $rating->bond->issuer->id;
        $bonds = Bond::where('issuer_id', $issuerId)->get();
        return view('maker.rating-movement.edit', compact('rating', 'bonds'));
    }

    public function RatingMovementUpdate(Request $request, RatingMovement $rating)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'rating_agency' => 'required|string|max:100',
            'effective_date' => 'required|date',
            'rating_tenure' => 'required|string|max:50',
            'rating' => 'nullable|string|max:50',
            'rating_action' => 'nullable|string|max:50',
            'rating_outlook' => 'nullable|string|max:50',
            'rating_watch' => 'nullable|string|max:50',
        ]);

        try {
            $rating->update($validated);
            return redirect()->route('bond-m.show', $rating->bond)->with('success', 'Rating movement updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function RatingMovementDestroy(RatingMovement $rating)
    {
        try {
            $rating->delete();
            return redirect()->route('dashboard')->with('success', 'Rating movement deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }

    public function RatingMovementUploadForm(Bond $bond)
    {
        return view('maker.rating-movement.upload', compact('bond'));
    }

    public function RatingMovementUploadStore(Request $request, Bond $bond)
    {
        $file = $request->file('rating_movement_file');

        Excel::import(new RatingMovementsImport, $file);

        return redirect()
            ->route('bond-m.show', $bond)
            ->with('success', 'Rating Movements data uploaded successfully');
    }

    // Payment Schedule Module
    public function PaymentScheduleCreate(Bond $bond)
    {
        $bondInfo = $bond;
        $issuerId = $bond->issuer->id;
        $bonds = Bond::where('issuer_id', $issuerId)->get();
        return view('maker.payment-schedule.create', compact('bonds', 'bondInfo'));
    }

    public function PaymentScheduleStore(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_date' => 'required|date',
            'ex_date' => 'nullable|date',
            'coupon_rate' => 'nullable|decimal:2|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);

        try {
            $payment = PaymentSchedule::create($validated);
            return redirect()->route('bond-m.show', $payment->bond)->with('success', 'Payment schedule created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function PaymentScheduleShow(PaymentSchedule $payment)
    {
        $payment->load('bond.issuer');
        return view('maker.payment-schedule.show', compact('payment'));
    }

    public function PaymentScheduleEdit(PaymentSchedule $payment)
    {
        $issuerId = $payment->bond->issuer->id;
        $bonds = Bond::where('issuer_id', $issuerId)->get();
        return view('maker.payment-schedule.edit', compact('payment', 'bonds'));
    }

    public function PaymentScheduleUpdate(Request $request, PaymentSchedule $payment)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_date' => 'required|date',
            'ex_date' => 'required|date',
            'coupon_rate' => 'required|decimal:2|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);

        try{
            $payment->update($validated);
            return redirect()->route('bond-m.show', $payment->bond)->with('success', 'Payment schedule updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function PaymentScheduleDestroy(PaymentSchedule $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('payment-schedules-info.index')>with('success', 'Payment schedule deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }

    public function PaymentScheduleUploadForm(Bond $bond)
    {
        return view('maker.payment-schedule.upload', compact('bond'));
    }

    public function PaymentScheduleUploadStore(Request $request, Bond $bond)
    {
        $file = $request->file('payment_schedule_file');

        Excel::import(new PaymentScheduleImport, $file);

        return redirect()
            ->route('bond-m.show', $bond)
            ->with('success', 'Payment Schedule data uploaded successfully');
    }

    // Redemption Module
    public function RedemptionCreate(Bond $bond)
    {
        $bondInfo = $bond;
        $issuerId = $bond->issuer->id;
        $bonds = Bond::where('issuer_id', $issuerId)->get();
        return view('maker.redemption.create', compact('bonds', 'bondInfo'));
    }

    public function RedemptionStore(Request $request)
    {
        $request->merge([
            'allow_partial_call' => $request->has('allow_partial_call'),
            'redeem_nearest_denomination' => $request->has('redeem_nearest_denomination')
        ]);

        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'allow_partial_call' => 'nullable|boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'nullable|boolean'
        ]);

        try {
            $redemption = Redemption::create($validated);
            return redirect()->route('bond-m.show', $redemption->bond)->with('success', 'Redemption created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function RedemptionShow(Redemption $redemption)
    {
        $redemption->load('bond.issuer');
        return view('maker.redemption.show', compact('redemption'));
    }

    public function RedemptionEdit(Redemption $redemption)
    {
        $issuerId = $redemption->bond->issuer->id;
        $bonds = Bond::where('issuer_id', $issuerId)->get();
        return view('maker.redemption.edit', compact('redemption', 'bonds'));
    }

    public function RedemptionUpdate(Request $request, Redemption $redemption)
    {
        $request->merge([
            'allow_partial_call' => $request->has('allow_partial_call'),
            'redeem_nearest_denomination' => $request->has('redeem_nearest_denomination')
        ]);

        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'allow_partial_call' => 'nullable|boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'nullable|boolean'
        ]);

        try{
            $redemption->update($validated);
            return redirect()->route('bond-m.show', $redemption->bond)->with('success', 'Redemption updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function RedemptionDestroy(Redemption $redemption)
    {
        try {
            $redemption->delete();
            return redirect()->route('bond-m.show', $redemption->bond)>with('success', 'Redemption deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }

    // Call Schedule Module
    public function CallScheduleCreate(Bond $bond)
    {
        $redemptions = Redemption::where('bond_id', $bond->id)->get();
        return view('maker.call-schedule.create', compact('redemptions', 'bond'));
    }

    public function CallScheduleStore(Request $request)
    {
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'call_price' => 'nullable|numeric|min:0|max:99999999999999.99',
        ]);

        // Check for overlapping schedules
        $exists = CallSchedule::where('redemption_id', $validated['redemption_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'A call schedule already exists for this period'])->withInput();
        }

        try {
            $call = CallSchedule::create($validated);
            return redirect()->route('bond-m.show', $call->redemption->bond)->with('success', 'Call schedule created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function CallScheduleShow(CallSchedule $call)
    {
        $call->load('redemption.bond');
        return view('maker.call-schedule.show', compact('call'));
    }

    public function CallScheduleEdit(CallSchedule $call)
    {
        $redemptions = Redemption::where('bond_id', $call->redemption->bond->id)->get();
        return view('maker.call-schedule.edit', compact('call', 'redemptions'));
    }

    public function CallScheduleUpdate(Request $request, CallSchedule $call)
    {
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'call_price' => 'nullable|numeric|min:0|max:99999999999999.99',
        ]);

        // Check for overlapping schedules excluding current
        $exists = CallSchedule::where('redemption_id', $validated['redemption_id'])
            ->where('id', '!=', $call->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'A call schedule already exists for this period'])->withInput();
        }

        try {
            $call->update($validated);
            return redirect()->route('bond-m.show', $call->redemption->bond)->with('success', 'Call schedule updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function CallScheduleDestroy(CallSchedule $call)
    {
        try {
            $call->delete();
            return redirect()->route('dashboard')->with('success', 'Call schedule deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }

    // Lockout Period Module
    public function LockoutPeriodCreate(Bond $bond)
    {
        $redemptions = Redemption::where('bond_id', $bond->redemption->bond->id)->get();
        return view('maker.lockout-period.create', compact('redemptions', 'bond'));
    }

    public function LockoutPeriodStore(Request $request)
    {
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $lock = LockoutPeriod::create($validated);
            return redirect()->route('bond-m.show', $lock->redemption->bond)->with('success', 'Lockout period created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating: ' . $e->getMessage()])->withInput();
        }
    }

    public function LockoutPeriodShow(LockoutPeriod $lockout)
    {
        $period = $lockout->load('redemption.bond');
        return view('maker.lockout-period.show', compact('period'));
    }

    public function LockoutPeriodEdit(LockoutPeriod $lockout)
    {
        $redemptions = Redemption::where('bond_id', $lockout->redemption->bond->id)->get();
        return view('maker.lockout-period.edit', compact('lockout', 'redemptions'));
    }

    public function LockoutPeriodUpdate(Request $request, LockoutPeriod $lockout)
    {
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $lockout->update($validated);
            return redirect()->route('bond-m.show', $lockout->redemption->bond)->with('success', 'Lockout period updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    public function LockoutPeriodDestroy(LockoutPeriod $lockout)
    {
        $lockoutPeriod = $lockout_periods_info;

        try {
            $lockoutPeriod->delete();
            return redirect()->route('lockout-periods-info.index')->with('success', 'Lockout period deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting: ' . $e->getMessage()])->withInput();
        }
    }

    // Trading Activity Module
    public function TradingActivityCreate(Bond $bond)
    {
        $bondInfo = $bond;
        $bonds = Bond::where('issuer_id', $bond->issuer->id)->get();
        return view('maker.trading-activity.create', compact('bonds', 'bondInfo'));
    }

    public function TradingActivityStore(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'trade_date' => 'required|date',
            'input_time' => 'required|date_format:H:i:s',
            'amount' => 'nullable|numeric|min:0.01|max:999999999999.99',
            'price' => 'nullable|numeric|min:0.0001|max:9999.9999',
            'yield' => 'nullable|numeric|min:0.01|max:100.00',
            'value_date' => 'nullable|date|after:trade_date',
        ]);

        try {
            $trading = TradingActivity::create($validated);
            return redirect()->route('bond-m.show', $trading->bond)->with('success', 'Trading activity created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function TradingActivityShow(TradingActivity $trading)
    {
        $trading->load('bond.issuer');
        return view('maker.trading-activity.show', compact('trading'));
    }

    public function TradingActivityEdit(TradingActivity $trading)
    {
        $bonds = Bond::where('issuer_id', $trading->bond->issuer->id)->get();
        return view('maker.trading-activity.edit', compact('trading', 'bonds'));
    }

    public function TradingActivityUpdate(Request $request, TradingActivity $trading)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'trade_date' => 'required|date',
            'input_time' => 'nullable|date_format:H:i:s',
            'amount' => 'nullable|numeric|min:0.01|max:999999999999.99',
            'price' => 'nullable|numeric|min:0.0001|max:9999.9999',
            'yield' => 'nullable|numeric|min:0.01|max:100.00',
            'value_date' => 'nullable|date|after:trade_date',
        ]);

        try{
            $trading->update($validated);
            return redirect()->route('bond-m.show', $trading->bond)->with('success', 'Trading activity updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    public function TradingActivityDestroy(PaymentSchedule $payment_schedules_info)
    {
        $paymentSchedule = $payment_schedules_info;

        try {
            $paymentSchedule->delete();
            return redirect()->route('dashboard')>with('success', 'Payment schedule deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }

    public function TradingActivityUploadForm(Bond $bond)
    {
        return view('maker.trading-activity.upload', compact('bond'));
    }

    public function TradingActivityUploadStore(Request $request, Bond $bond)
    {
        $file = $request->file('trading_activity_file');

        Excel::import(new TradingActivityImport, $file);

        return redirect()
            ->route('bond-m.show', $bond)
            ->with('success', 'Trading Activity data uploaded successfully');
    }

    // Trustee Fee
    public function TrusteeFeeIndex(Request $request)
    {
        // Use the proper relationship - facility.issuer instead of direct issuer
        $query = TrusteeFee::with(['facility', 'facility.issuer']);
        
        // Filter by facility_information_id if provided
        if ($request->has('facility_information_id') && !empty($request->facility_information_id)) {
            $query->where('facility_information_id', $request->facility_information_id);
        }
        
        // Filter by issuer_id through the facility relationship
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->whereHas('facility', function($q) use ($request) {
                $q->where('issuer_id', $request->issuer_id);
            });
        }
        
        if ($request->has('invoice_no') && !empty($request->invoice_no)) {
            $query->where('invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
        }
        
        if ($request->has('month') && !empty($request->month)) {
            $query->where('month', $request->month);
        }
        
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            if ($request->payment_status === 'paid') {
                $query->whereNotNull('payment_received');
            } elseif ($request->payment_status === 'unpaid') {
                $query->whereNull('payment_received');
            }
        }
        
        // Get all issuers for the dropdown
        $issuers = Issuer::orderBy('issuer_name')->get();
        
        // Get facilities for dropdown if needed
        $facilities = FacilityInformation::orderBy('facility_name')->get();
        
        $trustee_fees = $query->latest()->paginate(10);
        return view('maker.trustee-fee.index', compact('trustee_fees', 'issuers', 'facilities'));
    }

    public function TrusteeFeeCreate()
    {
        // Get all issuers for the dropdown
        $issuers = Issuer::orderBy('issuer_name')->get();

        // Get facilities for dropdown if needed
        $facilities = FacilityInformation::orderBy('facility_name')->get();
        
        return view('maker.trustee-fee.create', compact('issuers', 'facilities'));
    }

    public function TrusteeFeeStore(Request $request)
    {
        $validated = $this->validateTrusteeFee($request);

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'draft';

        $trusteeFee = TrusteeFee::create($validated);

        return redirect()
            ->route('trustee-fee-m.show', $trusteeFee)
            ->with('success', 'Trustee fee created successfully.');
    }

    public function TrusteeFeeEdit(TrusteeFee $trusteeFee)
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        $facilities = FacilityInformation::orderBy('facility_name')->get();
        return view('maker.trustee-fee.edit', compact('trusteeFee', 'issuers', 'facilities'));
    }

    public function TrusteeFeeUpdate(Request $request, TrusteeFee $trusteeFee)
    {
        $validated = $this->validateTrusteeFee($request, $trusteeFee);

        $trusteeFee->update($validated);

        return redirect()
            ->route('trustee-fee-m.show', $trusteeFee)
            ->with('success', 'Trustee fee updated successfully.');
    }

    public function TrusteeFeeShow(TrusteeFee $trusteeFee)
    {
        // Eager load the facility and issuer relationships
        $trusteeFee->load(['facility', 'facility.issuer']);
        return view('maker.trustee-fee.show', compact('trusteeFee'));
    }

    public function TrusteeFeeDestroy(TrusteeFee $trusteeFee)
    {
        $trusteeFee->delete();

        return redirect()
            ->route('trustee-fee-m.index')
            ->with('success', 'Trustee fee deleted successfully.');
    }

    public function SubmitApprovalTrusteeFee(TrusteeFee $trusteeFee)
    {
        try {
            $trusteeFee->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()
                ->route('trustee-fee-m.show', $trusteeFee)
                ->with('success', 'Trustee Fee submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }

    protected function validateTrusteeFee(Request $request)
    {
        return $request->validate([
            'facility_information_id' => 'required|exists:facility_informations,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'start_anniversary_date' => 'required|date',
            'end_anniversary_date' => 'required|date|after_or_equal:start_anniversary_date',
            'invoice_no' => 'required|string|' . ($trusteeFee ? 'unique:trustee_fees,invoice_no,'.$trusteeFee->id : 'unique:trustee_fees'),
            'month' => 'nullable|string|max:10',
            'date' => 'nullable|integer|min:1|max:31',
            'memo_to_fad' => 'nullable|date',
            'date_letter_to_issuer' => 'nullable|date',
            'first_reminder' => 'nullable|date',
            'second_reminder' => 'nullable|date',
            'third_reminder' => 'nullable|date',
            'payment_received' => 'nullable|date',
            'tt_cheque_no' => 'nullable|string|max:255',
            'memo_receipt_to_fad' => 'nullable|date',
            'receipt_to_issuer' => 'nullable|date',
            'receipt_no' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'status' => 'nullable|in:Draft,Active,Inactive,Pending,Rejected',
            'remarks' => 'nullable|string',
        ]);
    }

    // Compliance Covenants
    public function ComplianceIndex(Request $request)
    {
        $query = ComplianceCovenant::query();

        // Filter by issuer_id
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->where('issuer_id', $request->issuer_id);
        }

        // Search by issuer short name
        if ($request->has('issuer_short_name') && !empty($request->issuer_short_name)) {
            $query->where('issuer_short_name', 'LIKE', '%' . $request->issuer_short_name . '%');
        }

        // Search by financial year end
        if ($request->has('financial_year_end') && !empty($request->financial_year_end)) {
            $query->where('financial_year_end', 'LIKE', '%' . $request->financial_year_end . '%');
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'draft':
                    $query->where('status', 'Draft');
                    break;
                case 'active':
                    $query->where('status', 'Active');
                    break;
                case 'inactive':
                    $query->where('status', 'Inactive');
                    break;
                case 'pending':
                    $query->where('status', 'Pending');
                    break;
                case 'rejected':
                    $query->where('status', 'Rejected');
                    break;
            }
        }

        // Get all issuers for the dropdown
        $issuers = Issuer::orderBy('issuer_name')->get();

        // Get results with pagination
        $covenants = $query->latest()->paginate(10);
        $covenants->appends($request->all());
        
        return view('maker.compliance-covenant.index', compact('covenants', 'issuers'));
    }

    public function ComplianceCreate()
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.compliance-covenant.create', compact('issuers'));
    }

    public function ComplianceStore(Request $request)
    {
        $validated = $this->validateCompliance($request);

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'draft';

        $compliance = ComplianceCovenant::create($validated);

        return redirect()
            ->route('compliance-covenant-m.show', $compliance)
            ->with('success', 'Compliance covenant created successfully.');
    }

    public function ComplianceEdit(ComplianceCovenant $compliance)
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.compliance-covenant.edit', compact('compliance', 'issuers'));
    }

    public function ComplianceUpdate(Request $request, ComplianceCovenant $compliance)
    {
        $validated = $this->validateCompliance($request);

        $compliance->update($validated);

        return redirect()
            ->route('compliance-covenant-m.show', $compliance)
            ->with('success', 'Compliance covenant updated successfully.');
    }

    public function ComplianceShow(ComplianceCovenant $compliance)
    {
        return view('maker.compliance-covenant.show', compact('compliance'));
    }

    public function ComplianceDestroy(ComplianceCovenant $compliance)
    {
        $compliance->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Compliance covenant deleted successfully.');
    }

    public function SubmitApprovalCompliance(ComplianceCovenant $compliance)
    {
        try {
            $compliance->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()
                ->route('compliance-covenant-m.show', $compliance)
                ->with('success', 'Compliance Covenant submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }

    protected function validateCompliance(Request $request)
    {
        return $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'financial_year_end' => 'required|string|max:255',
            'audited_financial_statements' => 'nullable|string|max:255',
            'unaudited_financial_statements' => 'nullable|string|max:255',
            'compliance_certificate' => 'nullable|string|max:255',
            'finance_service_cover_ratio' => 'nullable|string|max:255',
            'annual_budget' => 'nullable|string|max:255',
            'computation_of_finance_to_ebitda' => 'nullable|string|max:255',
            'ratio_information_on_use_of_proceeds' => 'nullable|string|max:255',
            'status' => 'nullable|in:Draft,Active,Inactive,Pending,Rejected',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);
    }

    // Activity Diary
    /**
     * Display a listing of activity diaries.
     *
     * @return \Illuminate\Http\Response
     */
    public function ActivityIndex(Request $request)
    {
        $query = ActivityDiary::with('issuer');
        
        // Filter by issuer_id
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->where('issuer_id', $request->issuer_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        // Get all issuers for the dropdown
        $issuers = Issuer::orderBy('issuer_name')->get();
        
        $activities = $query->latest()->paginate(10)->withQueryString();
        
        return view('maker.activity-diary.index', compact('activities', 'issuers'));
    }

    /**
     * Show the form for creating a new activity diary.
     *
     * @return \Illuminate\Http\Response
     */
    public function ActivityCreate()
    {
        $issuers = Issuer::all();
        return view('maker.activity-diary.create', compact('issuers'));
    }

    /**
     * Store a newly created activity diary in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ActivityStore(Request $request)
    {
        $validated = $this->validateActivity($request);

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'draft';

        $activity = ActivityDiary::create($validated);

        return redirect()
            ->route('activity-diary-m.index')
            ->with('success', 'Activity diary created successfully');
    }

    /**
     * Display the specified activity diary.
     *
     * @param  \App\Models\ActivityDiary  $activity
     * @return \Illuminate\Http\Response
     */
    public function ActivityShow(ActivityDiary $activity)
    {
        $activity->load('issuer');
        return view('maker.activity-diary.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity diary.
     *
     * @param  \App\Models\ActivityDiary  $activity
     * @return \Illuminate\Http\Response
     */
    public function ActivityEdit(ActivityDiary $activity)
    {
        $issuers = Issuer::all();
        return view('maker.activity-diary.edit', compact('activity', 'issuers'));
    }

    /**
     * Update the specified activity diary in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activity
     * @return \Illuminate\Http\Response
     */
    public function ActivityUpdate(Request $request, ActivityDiary $activity)
    {
        $validated = $this->validateActivity($request);

        // Handle approval if status is changed to completed
        if (($request->input('status') === 'completed') && ($activity->status !== 'completed')) {
            $validated['approval_datetime'] = now();
        }

        $activity->update($validated);

        return redirect()
            ->route('activity-diary-m.index')
            ->with('success', 'Activity diary updated successfully');
    }

    /**
     * Remove the specified activity diary from storage.
     *
     * @param  \App\Models\ActivityDiary  $activity
     * @return \Illuminate\Http\Response
     */
    public function ActivityDestroy(ActivityDiary $activity)
    {
        $activity->delete();

        return redirect()
            ->route('activity-diary-m.index')
            ->with('success', 'Activity diary deleted successfully');
    }

    /**
     * Display a listing of activity diaries by issuer ID.
     *
     * @param  int  $issuerId
     * @return \Illuminate\Http\Response
     */
    public function ActivityGetByIssuer($issuerId, Request $request)
    {
        $issuer = Issuer::findOrFail($issuerId);
        $query = ActivityDiary::where('issuer_id', $issuerId);
        
        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
        
        $activities = $query->latest()->paginate(10)->withQueryString();
        
        return view('maker.activity-diary.by-issuer', compact('activities', 'issuer'));
    }

    /**
     * Display a listing of upcoming due activity diaries.
     *
     * @return \Illuminate\Http\Response
     */
    public function ActivityUpcoming(Request $request)
    {
        $today = now()->format('Y-m-d');
        $nextWeek = now()->addDays(7)->format('Y-m-d');
        
        $query = ActivityDiary::with('issuer')
            ->whereBetween('due_date', [$today, $nextWeek])
            ->where('status', '!=', 'completed');
        
        // Apply filters if provided
        if ($request->filled('issuer')) {
            $query->whereHas('issuer', function($q) use ($request) {
                $q->where('issuer_name', 'like', '%' . $request->issuer . '%')
                  ->orWhere('issuer_short_name', 'like', '%' . $request->issuer . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $activities = $query->latest()->paginate(10)->withQueryString();
        
        return view('maker.activity-diary.upcoming', compact('activities'));
    }

    /**
     * Update the status of the activity diary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activity
     * @return \Illuminate\Http\Response
     */
    public function ActivityUpdateStatus(Request $request, ActivityDiary $activity)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['Draft', 'Active', 'Rejected', 'Pending', 'In_progress', 'Completed', 'Overdue', 'Compiled', 'Notification', 'Passed'])],
        ]);

        // Handle approval datetime if status is changing to completed
        if ($validated['status'] === 'Completed' && $activity->status !== 'Completed') {
            $activity->update([
                'status' => $validated['status'],
                'approval_datetime' => now()
            ]);
        } else {
            $activity->update(['status' => $validated['status']]);
        }

        return redirect()->back()->with('success', 'Activity diary status updated successfully');
    }

    /**
     * Export activities to CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function ActivityExportActivities()
    {
        $activities = ActivityDiary::with('issuer')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activities.csv"',
        ];
        
        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 'Issuer', 'Purpose', 'Letter Date', 'Due Date', 
                'Extension Date 1', 'Extension Note 1', 
                'Extension Date 2', 'Extension Note 2',
                'Status', 'Remarks', 'Prepared By', 'Verified By', 'Approval Date'
            ]);
            
            // Add data rows
            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->id,
                    $activity->issuer->name ?? 'N/A',
                    $activity->purpose,
                    $activity->letter_date ? $activity->letter_date->format('Y-m-d') : null,
                    $activity->due_date ? $activity->due_date->format('Y-m-d') : null,
                    $activity->extension_date_1 ? $activity->extension_date_1->format('Y-m-d') : null,
                    $activity->extension_note_1,
                    $activity->extension_date_2 ? $activity->extension_date_2->format('Y-m-d') : null,
                    $activity->extension_note_2,
                    $activity->status,
                    $activity->remarks,
                    $activity->prepared_by,
                    $activity->verified_by,
                    $activity->approval_datetime ? $activity->approval_datetime->format('Y-m-d H:i:s') : null
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function SubmitApprovalActivityDiary(ActivityDiary $activity)
    {
        try {
            $activity->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()
                ->route('activity-diary-m.show', $activity)
                ->with('success', 'Activity diary submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }

    protected function validateActivity(Request $request)
    {
        return $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'purpose' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'extension_date_1' => 'nullable|date',
            'extension_note_1' => 'nullable|string',
            'extension_date_2' => 'nullable|date',
            'extension_note_2' => 'nullable|string',
            'status' => ['nullable', 'string', Rule::in(['Draft', 'Active', 'Rejected', 'Pending', 'In_progress', 'Completed', 'Overdue', 'Compiled', 'Notification', 'Passed'])],
            'remarks' => 'nullable|string',
            'verified_by' => 'nullable|string',
        ]);
    }

    // REITs : Portfolio
    public function PortfolioCreate()
    {
        $portfolioTypes = PortfolioType::where('status', 'active')->get();
        return view('maker.portfolio.create', compact('portfolioTypes'));
    }

    public function PortfolioStore(Request $request)
    {
        $validated = $this->validatePortfolio($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'draft';

        // Handle file uploads
        if ($request->hasFile('annual_report')) {
            $validated['annual_report'] = $request->file('annual_report')->store('annual_reports');
        }

        if ($request->hasFile('trust_deed_document')) {
            $validated['trust_deed_document'] = $request->file('trust_deed_document')->store('trust_deed_documents');
        }

        if ($request->hasFile('insurance_document')) {
            $validated['insurance_document'] = $request->file('insurance_document')->store('insurance_documents');
        }

        if ($request->hasFile('valuation_report')) {
            $validated['valuation_report'] = $request->file('valuation_report')->store('valuation_reports');
        }

        try {
            $portfolio = Portfolio::create($validated);
            return redirect()
                ->route('maker.dashboard', ['section' => 'reits'])->with('success', 'Portfolio created successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error creating portfolio: ' . $e->getMessage());
        }
    }

    public function PortfolioEdit(Portfolio $portfolio)
    {
        $portfolioTypes = PortfolioType::where('status', 'active')->get();
        return view('maker.portfolio.edit', compact('portfolio', 'portfolioTypes'));
    }

    public function PortfolioUpdate(Request $request, Portfolio $portfolio)
    {
        $validated = $this->validatePortfolio($request, $portfolio);

        // Handle file uploads
        if ($request->hasFile('annual_report')) {
            // Remove old file if it exists
            if ($portfolio->annual_report) {
                Storage::delete($portfolio->annual_report);
            }

            // Store the new file and get its path
            $validated['annual_report'] = $request->file('annual_report')->store('annual_reports');
        }

        if ($request->hasFile('trust_deed_document')) {
            // Remove old file if it exists
            if ($portfolio->trust_deed_document) {
                Storage::delete($portfolio->trust_deed_document);
            }

            // Store the new file and get its path
            $validated['trust_deed_document'] = $request->file('trust_deed_document')->store('trust_deed_documents');
        }

        if ($request->hasFile('insurance_document')) {
            // Remove old file if it exists
            if ($portfolio->insurance_document) {
                Storage::delete($portfolio->insurance_document);
            }

            // Store the new file and get its path
            $validated['insurance_document'] = $request->file('insurance_document')->store('insurance_documents');
        }

        if ($request->hasFile('valuation_report')) {
            // Remove old file if it exists
            if ($portfolio->valuation_report) {
                Storage::delete($portfolio->valuation_report);
            }

            // Store the new file and get its path
            $validated['valuation_report'] = $request->file('valuation_report')->store('valuation_reports');
        }

        try {
            $portfolio->update($validated);
            return redirect()
                ->route('portfolio-m.show', $portfolio)
                ->with('success', 'Portfolio updated successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating portfolio: ' . $e->getMessage());
        }
    }

    public function PortfolioShow(Portfolio $portfolio)
    {
        return view('maker.portfolio.show', compact('portfolio'));
    }

    public function SubmitApprovalPortfolio(Portfolio $portfolio)
    {
        try {
            $portfolio->update([
                'status' => 'pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()
                ->route('maker.dashboard', ['section' => 'reits'])
                ->with('success', 'Portfolio submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }
    
    protected function validatePortfolio(Request $request)
    {
        return $request->validate([
            'portfolio_types_id' => 'required|exists:portfolio_types,id',
            'portfolio_name' => 'required|string|max:255',
            'annual_report' => 'nullable|file|mimes:pdf,doc,docx',
            'trust_deed_document' => 'nullable|file|mimes:pdf,doc,docx',
            'insurance_document' => 'nullable|file|mimes:pdf,doc,docx',
            'valuation_report' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'nullable|string|in:active,inactive'
        ]);
    }

    // Financial Module
    public function FinancialIndex(Portfolio $portfolio, Request $request)
    {
        $query = Financial::with(['bank', 'financialType', 'properties'])->orderBy('bank_id')->get();
        $financials = $query->where('portfolio_id', $portfolio->id);
        return view('maker.financial.index', compact('financials', 'portfolio'));
    }

    public function FinancialCreate(Portfolio $portfolio)
    {
        $portfolioInfo = $portfolio;
        $portfolios = Portfolio::orderBy('portfolio_name')->get();
        $banks = Bank::orderBy('name')->get();
        $financialTypes = FinancialType::orderBy('name')->get();
        
        // Get all properties from the portfolio for selection
        $properties = Property::where('portfolio_id', $portfolio->id)
            ->orderBy('name')
            ->get();

        return view('maker.financial.create', compact('portfolios', 'banks', 'financialTypes', 'portfolioInfo', 'properties'));
    }

    public function FinancialStore(Request $request)
    {
        // Validate financial data
        $validated = $this->FinancialValidate($request);
    
        // Add prepared_by from authenticated user and set status
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'active';
        
        try {
            // Create the financial record
            $financial = Financial::create($validated);
            
            // Process property data from flat arrays to nested format
            if ($request->has('property_ids') && !empty($request->property_ids)) {
                $count = count($request->property_ids);
                $propertyData = [];
                
                for ($i = 0; $i < $count; $i++) {
                    if (empty($request->property_ids[$i])) continue;
                    
                    $propertyData[$request->property_ids[$i]] = [
                        'property_value' => $request->property_values[$i] ?? 0,
                        'financed_amount' => $request->financed_amounts[$i] ?? 0,
                        'security_value' => $request->security_values[$i] ?? 0,
                        'valuation_date' => $request->valuation_dates[$i] ?? null,
                        'remarks' => $request->property_remarks[$i] ?? null,
                        'status' => 'active',
                        'prepared_by' => Auth::user()->name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                
                // Attach properties to the financial
                $financial->properties()->attach($propertyData);
            }
            
            return redirect()
                ->route('property-m.index', $financial->portfolio)
                ->with('success', 'Financial created successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error creating financial: ' . $e->getMessage());
        }
    }

    public function FinancialEdit(Financial $financial)
    {
        $portfolios = Portfolio::orderBy('portfolio_name')->get();
        $banks = Bank::orderBy('name')->get();
        $financialTypes = FinancialType::orderBy('name')->get();
        
        // Get all properties from the portfolio
        $properties = Property::where('portfolio_id', $financial->portfolio_id)
            ->orderBy('name')
            ->get();
        
        // Load existing properties attached to this financial
        $financial->load('properties');

        return view('maker.financial.edit', compact('financial', 'portfolios', 'banks', 'financialTypes', 'properties'));
    }

    public function FinancialUpdate(Financial $financial, Request $request)
    {
        // Validate financial data
        $validated = $this->FinancialValidate($request);
        
        try {
            // Update the financial record
            $financial->update($validated);
            
            // Process property data from flat arrays to nested format
            $syncData = [];
            if ($request->has('property_ids') && !empty($request->property_ids)) {
                $count = count($request->property_ids);
                
                for ($i = 0; $i < $count; $i++) {
                    if (empty($request->property_ids[$i])) continue;
                    
                    $syncData[$request->property_ids[$i]] = [
                        'property_value' => $request->property_values[$i] ?? 0,
                        'financed_amount' => $request->financed_amounts[$i] ?? 0,
                        'security_value' => $request->security_values[$i] ?? 0,
                        'valuation_date' => $request->valuation_dates[$i] ?? null,
                        'remarks' => $request->property_remarks[$i] ?? null,
                        'status' => 'active',
                        'prepared_by' => Auth::user()->name,
                        'updated_at' => now()
                    ];
                }
            }
            
            // Sync will remove any properties that are not in the request
            $financial->properties()->sync($syncData);
            
            return redirect()
                ->route('property-m.index', $financial->portfolio)
                ->with('success', 'Financial updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating financial: ' . $e->getMessage());
        }
    }

    public function FinancialShow(Financial $financial)
    {
        // Load the properties associated with this financial
        $financial->load(['properties', 'portfolio', 'bank', 'financialType']);
        
        return view('maker.financial.show', compact('financial'));
    }

    public function FinancialValidate(Request $request) {
        return $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'bank_id' => 'required|exists:banks,id',
            'financial_type_id' => 'required|exists:financial_types,id',
            'batch_no' => 'nullable|string|max:255',
            'purpose' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'installment_date' => 'required|string|max:255',
            'profit_type' => 'nullable|string|max:255',
            'profit_rate' => 'nullable|numeric|min:0|max:100',
            'process_fee' => 'nullable|numeric|min:0',
            'total_facility_amount' => 'nullable|numeric|min:0',
            'utilization_amount' => 'nullable|numeric|min:0',
            'outstanding_amount' => 'nullable|numeric|min:0',
            'interest_monthly' => 'nullable|numeric|min:0',
            'security_value_monthly' => 'nullable|numeric|min:0',
            'facilities_agent' => 'nullable|string|max:255',
            'agent_contact' => 'nullable|string|max:255',
            'valuer' => 'nullable|string|max:255',
        ]);
    }
    
    public function FinancialPropertyValidate(Request $request) {
        return $request->validate([
            'property_ids' => 'required|array|min:1',
            'property_ids.*' => 'required|exists:properties,id',
            'property_values.*' => 'required|numeric|min:0',
            'financed_amounts.*' => 'required|numeric|min:0',
            'security_values.*' => 'required|numeric|min:0',
            'valuation_dates.*' => 'required|date',
        ]);
    }

    // Property Module
    public function PropertyIndex(Portfolio $portfolio, Request $request)
    {
        // Start with a base query, including relevant relationships
        $query = Property::with([
            'portfolio',
            'tenants' => function($q) {
                $q->where('status', 'active');
            },
            'siteVisits' => function($q) {
                $q->where('status', 'scheduled');
            }
        ]);
        
        // Filter by portfolio if provided
        if ($portfolio->exists) {
            $query->where('portfolio_id', $portfolio->id);
            
            // Eager load portfolio with its relationships when we're looking at a specific portfolio
            $portfolio->load([
                'portfolioType',
                'properties.tenants',
                'properties.siteVisits',
                'financials.bank',
                'financials.financialType'
            ]);
        }
        
        // Apply filters based on request parameters
        if ($request->filled('batch_no')) {
            $query->where('batch_no', $request->batch_no);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('batch_no', 'like', "%{$search}%");
            });
        }
        
        // Add sorting capability
        $sortField = $request->filled('sort') ? $request->sort : 'created_at';
        $sortDirection = $request->filled('direction') ? $request->direction : 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        // Execute the query with pagination
        $properties = $query->paginate(10)->appends($request->except('page'));
        
        // Get unique values for filters dropdowns
        $batchNumbers = Property::select('batch_no')->distinct()->pluck('batch_no');
        $categories = Property::select('category')->distinct()->pluck('category');
        $cities = Property::select('city')->distinct()->pluck('city');
        $statuses = Property::select('status')->distinct()->pluck('status');
        $portfolios = Portfolio::where('status', 'active')->get();
        
        return view('maker.property.index', compact(
            'portfolios',
            'properties',
            'batchNumbers', 
            'categories', 
            'cities',
            'statuses',
            'portfolio',
            'sortField',
            'sortDirection'
        ));
    }

    public function PropertyCreate(Portfolio $portfolio)
    {
        $portfolioInfo = $portfolio;
        $portfolios = Portfolio::orderBy('portfolio_name')->get();
        return view('maker.property.create', compact('portfolios', 'portfolioInfo'));
    }

    public function PropertyStore(Request $request)
    {
        // Validate all form inputs
        $validated = $this->PropertyValidate($request);
        
        // Check if a master lease agreement file was uploaded
        if ($request->hasFile('master_lease_agreement')) {
            // Store the file and get its path
            $filePath = $request->file('master_lease_agreement')->store('property-documents');
            
            // Save the file path to the database
            $validated['master_lease_agreement'] = $filePath;
        }
        
        // Check if a valuation report file was uploaded
        if ($request->hasFile('valuation_report')) {
            // Store the file and get its path
            $filePath = $request->file('valuation_report')->store('property-documents');
            
            // Save the file path to the database
            $validated['valuation_report'] = $filePath;
        }
        
        // Create the property with all data
        
        try {
            $property = Property::create($validated);
            return redirect()->route('property-m.index', $property->portfolio)
                ->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating property: ' . $e->getMessage());
        }
    }

    public function PropertyEdit(Property $property)
    {
        $portfolios = Portfolio::orderBy('portfolio_name')->get();
        return view('maker.property.edit', compact('portfolios', 'property'));
    }

    public function PropertyUpdate(Request $request, Property $property)
    {
        // Validate all form inputs
        $validated = $this->PropertyValidate($request);
        
         // Check if a new master lease agreement file was uploaded
         if ($request->hasFile('master_lease_agreement')) {
            // Remove old file if it exists
            if ($property->master_lease_agreement) {
                Storage::delete($property->master_lease_agreement);
            }
            
            // Store the new file and get its path
            $validated['master_lease_agreement'] = $request->file('master_lease_agreement')
                ->store('property-documents');
        }
        
        // Check if a new valuation report file was uploaded
        if ($request->hasFile('valuation_report')) {
            // Remove old file if it exists
            if ($property->valuation_report) {
                Storage::delete($property->valuation_report);
            }
            
            // Store the new file and get its path
            $validated['valuation_report'] = $request->file('valuation_report')
                ->store('property-documents');
        }
        try {
            $property->update($validated);
            return redirect()
                ->route('property-m.index', $property->portfolio)
                ->with('success', 'Property updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating property: ' . $e->getMessage());
        }
    }

    public function PropertyShow(Property $property)
    {
        return view('maker.property.show', compact('property'));
    }

    public function PropertyValidate(Request $request)
    {
        return $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'category' => 'required|string|max:255',
            'batch_no' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'land_size' => 'nullable|numeric|min:0',
            'gross_floor_area' => 'nullable|numeric|min:0',
            'usage' => 'nullable|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'ownership' => 'nullable|string|max:255',
            'share_amount' => 'nullable|numeric|min:0',
            'market_value' => 'nullable|numeric|min:0',
            'master_lease_agreement' => 'nullable|file|mimes:pdf|max:10240',
            'valuation_report' => 'nullable|file|mimes:pdf|max:10240',
        ]);
    }

    // Tenant Module
    public function TenantIndex(Property $property)
    {
        $tenants = $property->tenants()
            ->with('leases')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();
        
        $siteVisits = $property->siteVisits()
            ->with('checklist')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    
        return view('maker.tenant.index', compact('tenants', 'siteVisits', 'property'));
    }

    public function TenantCreate(Property $property)
    {
        $propertyInfo = $property;
        $properties = Property::orderBy('name')->get();
        return view('maker.tenant.create', compact('properties', 'propertyInfo'));
    }

    public function TenantStore(Request $request)
    {
        $validated = $this->TenantValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'active';

        try {
            $tenant = Tenant::create($validated);
            return redirect()
                ->route('tenant-m.index', $tenant->property)
                ->with('success', 'Tenant created successfully.');
        } catch(\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating tenant: ' . $e->getMessage());
        }
    }

    public function TenantEdit(Tenant $tenant)
    {
        $properties = Property::orderBy('name')->get();
        return view('maker.tenant.edit', compact('tenant', 'properties'));
    }

    public function TenantUpdate(Request $request, Tenant $tenant)
    {
        $validated = $this->TenantValidate($request);

        try {
            $tenant->update($validated);
            return redirect()
                ->route('tenant-m.index', $tenant->property)->with('success', 'Tenant updated successfully.');
        } catch(\Exception $e) {
            return back()->withInput()->with('error', 'Error updating tenant: ' . $e->getMessage());
        }
    }

    public function TenantShow(Tenant $tenant)
    {
        return view('maker.tenant.show', compact('tenant'));
    }

    public function TenantValidate(Request $request)
    {
        return $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'commencement_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:commencement_date',
        ]);
    }

    // Lease Module
    public function LeaseIndex(Property $property)
    {
        // Get all tenants for this property
        $tenantIds = $property->tenants->pluck('id');
        
        // Get all leases for these tenants with pagination
        $leases = Lease::whereIn('tenant_id', $tenantIds)
            ->with(['tenant', 'tenant.property']) // Eager load relationships
            ->latest()
            ->paginate(10);
        
        // Get property details with necessary relationships
        $property->load(['portfolio', 'portfolio.portfolioType']);
        
        // Calculate lease metrics for property summary
        $activeLeaseCount = Lease::whereIn('tenant_id', $tenantIds)
            ->where('status', 'active')
            ->count();
        
        $totalLeaseCount = Lease::whereIn('tenant_id', $tenantIds)->count();
        
        // Calculate total rental for active leases using base rate year 1
        $totalActiveRental = Lease::whereIn('tenant_id', $tenantIds)
            ->where('status', 'active')
            ->sum('base_rate_year_1');
        
        // Pass calculated metrics to view
        return view('maker.lease.index', compact(
            'property',
            'leases',
            'activeLeaseCount',
            'totalLeaseCount',
            'totalActiveRental'
        ));
    }

    public function LeaseCreate(Property $property)
    {
        $tenants = Tenant::where('property_id', $property->id)->orderBy('name')->get();
        return view('maker.lease.create', compact('tenants', 'property'));
    }

    public function LeaseStore(Request $request)
    {
        $validated = $this->LeaseValidate($request);

        // Set default values
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('lease-attachments', 'public');
        }

        try {
            $lease = Lease::create($validated);
            return redirect()->route('lease-m.index', $lease->tenant->property)->with('success', 'Lease created successfully.');
        } catch(\Exception $e) {
            return back()->with('error', 'Error creating lease: ' . $e->getMessage());
        }
    }

    public function LeaseEdit(Lease $lease)
    {
        $tenants = Tenant::where('property_id', $lease->tenant->property_id)->orderBy('name')->get();
        return view('maker.lease.edit', compact('tenants', 'lease'));
    }

    public function LeaseUpdate(Request $request, Lease $lease)
    {
        $validated = $this->LeaseValidate($request);
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($lease->attachment && Storage::disk('public')->exists($lease->attachment)) {
                Storage::disk('public')->delete($lease->attachment);
            }
            
            $validated['attachment'] = $request->file('attachment')->store('lease-attachments', 'public');
        }

        try {
            $lease->update($validated);
            return redirect()->route('lease-m.show', $lease)->with('success', 'Lease updated successfully.');
        } catch(\Exception $e) {
            return back()->with('error', 'Error updating lease: ' . $e->getMessage());
        }
    }

    public function LeaseShow(Lease $lease)
    {
        return view('maker.lease.show', compact('lease'));
    }

    public function LeaseValidate(Request $request)
    {
        return $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'nullable|string|max:255',
            'permitted_use' => 'nullable|string|max:255',
            'option_to_renew' => 'nullable|string|max:255',
            'term_years' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'base_rate_year_1' => 'nullable|numeric|min:0',
            'monthly_gsto_year_1' => 'nullable|numeric|min:0',
            'base_rate_year_2' => 'nullable|numeric|min:0',
            'monthly_gsto_year_2' => 'nullable|numeric|min:0',
            'base_rate_year_3' => 'nullable|numeric|min:0',
            'monthly_gsto_year_3' => 'nullable|numeric|min:0',
            'space' => 'nullable|numeric|min:0',
            'tenancy_type' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    // Site Visit Module
    public function SiteVisitIndex(Property $property)
    {
        $siteVisits = $property->siteVisits()
                        ->orderBy('created_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();
                        
        return view('maker.site-visit.index', compact('siteVisits', 'propertyInfo'));
    }

    public function SiteVisitCreate(Property $property)
    {
        $propertyInfo = $property;
        $properties = Property::orderBy('name')->get();
        return view('maker.site-visit.create', compact('properties', 'propertyInfo'));
    }

    public function SiteVisitStore(Request $request)
    {
        $validated = $this->SiteVisitValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';

        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('site-visit-attachments', 'public');
        }

        if ($request->has('follow_up_required')) {
            $validated['follow_up_required'] = $request->follow_up_required ? 1 : 0;
        }

        try {
            $siteVisit = SiteVisit::create($validated);
            return redirect()->route('tenant-m.index', $siteVisit->property)->with('success', 'Site visit created successfully.');
        } catch(\Exception $e) {
            return back()->with('error', 'Error creating site visit: ' . $e->getMEssage());
        }
    }

    public function SiteVisitEdit(SiteVisit $siteVisit)
    {
        $properties = Property::orderBy('name')->get();
        return view('maker.site-visit.edit', compact('siteVisit', 'properties'));
    }

    public function SiteVisitUpdate(Request $request, SiteVisit $siteVisit)
    {
        $validated = $this->SiteVisitValidate($request);

        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($siteVisit->attachment && Storage::disk('public')->exists($siteVisit->attachment)) {
                Storage::disk('public')->delete($siteVisit->attachment);
            }
            
            $validated['attachment'] = $request->file('attachment')->store('site-visit-attachments', 'public');
        }

        if ($request->has('follow_up_required')) {
            $validated['follow_up_required'] = $request->follow_up_required ? 1 : 0;
        }

        try {
            $siteVisit->update($validated);
            return redirect()->route('tenant-m.index', $siteVisit->property)->with('success', 'Site visit updated successfully.');
        } catch(\Exception $e) {
            return back()->with('error', 'Error updating site visit: ' . $e->getMessage());
        }
    }

    public function SiteVisitShow(SiteVisit $siteVisit)
    {
        return view('maker.site-visit.show', compact('siteVisit'));
    }

    public function SiteVisitValidate(Request $request)
    {
        return $request->validate([
            'property_id' => 'required|exists:properties,id',
            'date_visit' => 'required|date',
            'time_visit' => 'required|date_format:H:i',
            'trustee' => 'nullable|string|max:255',
            'manager' => 'nullable|string|max:255',
            'maintenance_manager' => 'nullable|string|max:255',
            'building_manager' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'submission_date' => 'nullable|date',
            'follow_up_required' => 'nullable|boolean',
            'attachment' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    // Checklist Module
    public function ChecklistIndex(Request $request, Property $property)
    {
        // Start with a base query that includes the relationship
        $query = Checklist::with('siteVisit');
        
        // Filter by property if provided
        if ($property->exists) {
            $query->whereHas('siteVisit', function ($query) use ($property) {
                $query->where('property_id', $property->id);
            });
            
            // For statistics, we need to get counts from the entire dataset
            $pendingCount = (clone $query)->where('status', 'pending')->count();
            $completedCount = (clone $query)->where('status', 'completed')->count();
        }
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('property_title', 'like', "%{$search}%")
                  ->orWhere('property_location', 'like', "%{$search}%")
                  ->orWhere('tenant_name', 'like', "%{$search}%")
                  ->orWhere('title_ref', 'like', "%{$search}%")
                  ->orWhere('remarks', 'like', "%{$search}%");
            });
        }
        
        // Handle status filtering
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Get paginated results
        $checklists = $query->latest()->paginate(10)->withQueryString();
        
        // If we're viewing a specific property, include the statistics
        if ($property->exists) {
            return view('maker.checklist.index', compact(
                'property', 
                'checklists',
                'pendingCount',
                'completedCount'
            ));
        }
        
        return view('maker.checklist.index', compact('checklists'));
    }

    public function ChecklistCreate(Property $property)
    {
        // Get only active site visits related to the current property
        $siteVisits = SiteVisit::where('property_id', $property->id)
                            ->where('status', 'pending')
                            ->orderBy('date_visit', 'desc')
                            ->get();
        
        // Eager load the tenants relationship to avoid N+1 query issues
        // Only get active tenants
        $property->load(['tenants' => function($query) {
            $query->where('status', 'active');
        }]);
        
        return view('maker.checklist.create', compact('property', 'siteVisits'));
    }

    public function ChecklistStore(Request $request)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->checklistValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        try {
            // create checklist
            $checklist = Checklist::create($validated);

            // create a legal documentation
            ChecklistLegalDocumentation::create([
                'checklist_id' => $checklist->id,
                'prepared_by' => Auth::user()->name,
                'status' => 'pending',
            ]);

            // create external area condition
            ChecklistExternalAreaCondition::create([
                'checklist_id' => $checklist->id,
                'prepared_by' => Auth::user()->name,
                'status' => 'pending',
            ]);

            // create internal area condition
            ChecklistInternalAreaCondition::create([
                'checklist_id' => $checklist->id,
                'prepared_by' => Auth::user()->name,
                'status' => 'pending',
            ]);

            // create property development
            ChecklistPropertyDevelopment::create([
                'checklist_id' => $checklist->id,
                'prepared_by' => Auth::user()->name,
                'status' => 'pending',
            ]);

            // create disposal installation
            ChecklistDisposalInstallation::create([
                'checklist_id' => $checklist->id,
                'prepared_by' => Auth::user()->name,
                'status' => 'pending',
            ]);

            return redirect()
                ->route('tenant-m.index', $checklist->siteVisit->property)
                ->with('success', 'Checklist created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistEdit(Checklist $checklist)
    {
        // Get site visits related to the property
        $property = $checklist->siteVisit->property;
        $siteVisits = SiteVisit::where('property_id', $property->id)
                            ->where('status', 'active')
                            ->orderBy('date_visit', 'desc')
                            ->get();
        
        // Eager load the property's tenants
        $property->load(['tenants' => function($query) {
            $query->where('status', 'active');
        }]);
        
        // Eager load the tenants associated with this checklist along with pivot data
        $checklist->load(['tenants' => function($query) {
            $query->withPivot('notes', 'status', 'prepared_by', 'verified_by');
        }]);
        
        return view('maker.checklist.edit', compact('checklist', 'siteVisits', 'property'));
    }

    public function ChecklistUpdate(Request $request, Checklist $checklist)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->ChecklistValidate($request, $checklist);
        
        // Record the last update
        $validated['updated_at'] = now();

        try {
            // Update the checklist with validated data
            $checklist->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklist)
                ->with('success', 'Checklist updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistShow(Checklist $checklist)
    {
        return view('maker.checklist.show', compact('checklist'));
    }

    // Checklist Legal Documentation
    public function ChecklistLegalDocumentationIndex(Checklist $checklist)
    {
        // Eager load the checklist with its relationships
        $checklist->load(['siteVisit', 'property', 'legalDocumentation']);
        
        return view('maker.checklist.legal-documentation.index', compact('checklist'));
    }

    public function ChecklistLegalDocumentationCreate(Checklist $checklist)
    {
        return view('maker.checklist.legal-documentation.create', compact('checklist'));
    }

    public function ChecklistLegalDocumentationStore(Request $request, Checklist $checklist)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->legalDocumentationValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        try {
            // create legal documentation
            ChecklistLegalDocumentation::create($validated);
            
            return redirect()
                ->route('checklist-m.legal-documentation.index', $checklist)
                ->with('success', 'Legal documentation created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating legal documentation: ' . $e->getMessage());
        }
    }

    public function ChecklistLegalDocumentationEdit(Checklist $checklist, ChecklistLegalDocumentation $legalDocumentation)
    {
        return view('maker.checklist.legal-documentation.edit', compact('checklist', 'legalDocumentation'));
    }

    public function ChecklistLegalDocumentationUpdate(Request $request, ChecklistLegalDocumentation $legalDocumentation)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->legalDocumentationValidate($request, $legalDocumentation);
        
        // Record the last update
        $validated['updated_at'] = now();

        try {
            // Update the legal documentation with validated data
            $legalDocumentation->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $legalDocumentation->checklist->siteVisit->property)
                ->with('success', 'Legal documentation updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating legal documentation: ' . $e->getMessage());
        }
    }

    public function ChecklistLegalDocumentationShow(Checklist $checklist, ChecklistLegalDocumentation $legalDocumentation)
    {
        return view('maker.checklist.legal-documentation.show', compact('checklist', 'legalDocumentation'));
    }

    // Checklist Tenant
    public function ChecklistTenantIndex(Checklist $checklist)
    {
        $checklist->load(['siteVisit', 'property', 'tenants']);
        return view('maker.checklist.tenant.index', compact('checklist'));
    }

    public function ChecklistTenantCreate(Checklist $checklist)
    {
        $checklist->load(['siteVisit', 'tenants']);
        return view('maker.checklist.tenant.create', compact('checklist'));
    }

    public function ChecklistTenantStore(Request $request)
    {
        $validated = $this->tenantChecklistValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';

        try {
            $checklistTenant = ChecklistTenant::create($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistTenant->checklist->siteVisit->property)
                ->with('success', 'Tenant association created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating tenant association: ' . $e->getMessage());
        }
    }

    public function ChecklistTenantEdit(ChecklistTenant $checklistTenant)
    {
        return view('maker.checklist.tenant.edit', compact('checklistTenant'));
    }

    public function ChecklistTenantUpdate(Request $request, ChecklistTenant $checklistTenant)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->tenantChecklistValidate($request, $checklistTenant);

        // Record the last update
        $validated['updated_at'] = now();

        try {
            $checklistTenant->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistTenant->checklist->siteVisit->property)
                ->with('success', 'Tenant updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating tenant: ' . $e->getMessage());
        }
    }

    public function ChecklistTenantShow(ChecklistTenant $checklistTenant)
    {
        return view('maker.checklist.tenant.show', compact('checklistTenant'));
    }

    // Checklist External Area Condition
    public function ChecklistExternalAreaConditionIndex(Checklist $checklist)
    {
        // Eager load the checklist with its relationships
        $checklist->load(['siteVisit', 'property', 'externalAreaCondition']);
        
        return view('maker.checklist.external-area-condition.index', compact('checklist'));
    }

    public function ChecklistExternalAreaConditionCreate(Checklist $checklist)
    {
        return view('maker.checklist.external-area-condition.create', compact('checklist'));
    }

    public function ChecklistExternalAreaConditionStore(Request $request, Checklist $checklist)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->externalAreaConditionValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        try {
            // create external area condition
            ChecklistExternalAreaCondition::create($validated);
            
            return redirect()
                ->route('checklist-m.external-area-condition.index', $checklist)
                ->with('success', 'External area condition created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating external area condition: ' . $e->getMessage());
        }
    }

    public function ChecklistExternalAreaConditionEdit(ChecklistExternalAreaCondition $checklistExternalAreaCondition)
    {
        return view('maker.checklist.external-area-condition.edit', compact('checklistExternalAreaCondition'));
    }

    public function ChecklistExternalAreaConditionUpdate(Request $request, ChecklistExternalAreaCondition $checklistExternalAreaCondition)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->externalAreaConditionValidate($request, $checklistExternalAreaCondition);
        
        // Record the last update
        $validated['updated_at'] = now();

        // Verified By
        $validated['verified_by'] = Auth::user()->name;

        // Status
        $validated['status'] = 'completed';

        try {
            // Update the external area condition with validated data
            $checklistExternalAreaCondition->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistExternalAreaCondition->checklist->siteVisit->property)
                ->with('success', 'External area condition updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating external area condition: ' . $e->getMessage());
        }
    }

    public function ChecklistExternalAreaConditionShow(Checklist $checklist, ChecklistExternalAreaCondition $externalCond)
    {
        return view('maker.checklist.external-area-condition.show', compact('checklist', 'externalCond'));
    }

    // Checklist Internal Area Condition
    public function ChecklistInternalAreaConditionIndex(Checklist $checklist)
    {
        // Eager load the checklist with its relationships
        $checklist->load(['siteVisit', 'property', 'internalAreaCondition']);
        
        return view('maker.checklist.internal-area-condition.index', compact('checklist'));
    }

    public function ChecklistInternalAreaConditionCreate(Checklist $checklist)
    {
        return view('maker.checklist.internal-area-condition.create', compact('checklist'));
    }

    public function ChecklistInternalAreaConditionStore(Request $request, Checklist $checklist)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->internalAreaConditionValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        try {
            // create internal area condition
            ChecklistInternalAreaCondition::create($validated);
            
            return redirect()
                ->route('checklist-m.internal-area-condition.index', $checklist)
                ->with('success', 'Internal area condition created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating internal area condition: ' . $e->getMessage());
        }
    }

    public function ChecklistInternalAreaConditionEdit(ChecklistInternalAreaCondition $checklistInternalAreaCondition)
    {
        // Eager load the checklist with its relationships
        $checklistInternalAreaCondition->load(['checklist']);
        return view('maker.checklist.internal-area-condition.edit', compact('checklistInternalAreaCondition'));
    }

    public function ChecklistInternalAreaConditionUpdate(Request $request, ChecklistInternalAreaCondition $checklistInternalAreaCondition)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->internalAreaConditionValidate($request, $checklistInternalAreaCondition);
        
        // Record the last update
        $validated['updated_at'] = now();

        // Verified By
        $validated['verified_by'] = Auth::user()->name;

        // Status
        $validated['status'] = 'completed';

        try {
            // Update the internal area condition with validated data
            $checklistInternalAreaCondition->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistInternalAreaCondition->checklist->siteVisit->property)
                ->with('success', 'Internal area condition updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating internal area condition: ' . $e->getMessage());
        }
    }

    public function ChecklistInternalAreaConditionShow(ChecklistInternalAreaCondition $checklistInternalAreaCondition)
    {
        return view('maker.checklist.internal-area-condition.show', compact('checklistInternalAreaCondition'));
    }

    // Checklist Property Condition
    public function ChecklistPropertyDevelopmentIndex(Checklist $checklist)
    {
        // Eager load the checklist with its relationships
        $checklist->load(['siteVisit', 'property', 'propertyCondition']);
        
        return view('maker.checklist.property-development.index', compact('checklist'));
    }

    public function ChecklistPropertyDevelopmentCreate(Checklist $checklist)
    {
        return view('maker.checklist.property-development.create', compact('checklist'));
    }

    public function ChecklistPropertyDevelopmentStore(Request $request, Checklist $checklist)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->propertyConditionValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        try {
            // create property development
            ChecklistPropertyDevelopment::create($validated);
            
            return redirect()
                ->route('checklist-m.property-development.index', $checklist)
                ->with('success', 'Property development created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating property development: ' . $e->getMessage());
        }
    }

    public function ChecklistPropertyDevelopmentEdit(ChecklistPropertyDevelopment $checklistPropertyDevelopment)
    {
        return view('maker.checklist.property-development.edit', compact('checklistPropertyDevelopment'));
    }

    public function ChecklistPropertyDevelopmentUpdate(Request $request, ChecklistPropertyDevelopment $checklistPropertyDevelopment)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->propertyDevelopmentValidate($request, $checklistPropertyDevelopment);
        
        // Record the last update
        $validated['updated_at'] = now();

        // Verified By
        $validated['verified_by'] = Auth::user()->name;

        // Status
        $validated['status'] = 'completed';

        try {
            // Update the property development with validated data
            $checklistPropertyDevelopment->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistPropertyDevelopment->checklist->siteVisit->property)
                ->with('success', 'Property development updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating property development: ' . $e->getMessage());
        }
    }

    public function ChecklistPropertyDevelopmentShow(ChecklistPropertyDevelopment $checklistPropertyDevelopment)
    {
        return view('maker.checklist.property-development.show', compact('checklistPropertyDevelopment'));
    }


    // Checklist Disposal Installation
    public function ChecklistDisposalInstallationIndex(Checklist $checklist)
    {
        // Eager load the checklist with its relationships
        $checklist->load(['siteVisit', 'property', 'disposalInstallation']);
        
        return view('maker.checklist.disposal-installation.index', compact('checklist'));
    }

    public function ChecklistDisposalInstallationCreate(Checklist $checklist)
    {
        return view('maker.checklist.disposal-installation.create', compact('checklist'));
    }

    public function ChecklistDisposalInstallationStore(Request $request, ChecklistDisposalInstallation $checklistDisposalInstallation)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->disposalInstallationValidate($request);
        
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        
        try {
            // create disposal installation
            $checklistDisposalInstallation = ChecklistDisposalInstallation::create($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistDisposalInstallation->checklist->siteVisit->property)
                ->with('success', 'Disposal installation created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating disposal installation: ' . $e->getMessage());
        }
    }

    public function ChecklistDisposalInstallationEdit(ChecklistDisposalInstallation $checklistDisposalInstallation)
    {
        return view('maker.checklist.disposal-installation.edit', compact('checklistDisposalInstallation'));
    }

    public function ChecklistDisposalInstallationUpdate(Request $request, ChecklistDisposalInstallation $checklistDisposalInstallation)
    {
        // Get the validated data from the separate validation methods
        $validated = $this->disposalInstallationValidate($request, $checklistDisposalInstallation);
        
        // Record the last update
        $validated['updated_at'] = now();

        // Verified By
        $validated['verified_by'] = Auth::user()->name;

        // Status
        $validated['status'] = 'completed';

        try {
            // Update the disposal installation with validated data
            $checklistDisposalInstallation->update($validated);
            
            return redirect()
                ->route('checklist-m.show', $checklistDisposalInstallation->checklist->siteVisit->property)
                ->with('success', 'Disposal installation updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating disposal installation: ' . $e->getMessage());
        }
    }

    public function ChecklistDisposalInstallationShow(Checklist $checklist, ChecklistDisposalInstallation $disposalInst)
    {
        return view('maker.checklist.disposal-installation.show', compact('checklist', 'disposalInst'));
    }

    /**
     * Validate main checklist data
     *
     * @param Request $request
     * @param Checklist|null $checklist
     * @return array
     */
    public function checklistValidate(Request $request, Checklist $checklist = null)
    {
        return $request->validate([
            'site_visit_id' => 'required|exists:site_visits,id',
        ]);
    }

    /**
     * Validate legal documentation data
     *
     * @param Request $request
     * @param ChecklistLegalDocumentation|null $legalDoc
     * @return array
     */
    public function legalDocumentationValidate(Request $request, ChecklistLegalDocumentation $legalDocumentationValidate = null)
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
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    /**
     * Validate tenant checklist pivot data
     *
     * @param Request $request
     * @return array
     */
    public function tenantChecklistValidate(Request $request, ChecklistTenant $checklistTenant = null)
    {
        return $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'tenant_id' => 'required|exists:tenants,id',
            'notes' => 'nullable|string',
        ]);
    }

    /**
     * Validate external area condition data
     *
     * @param Request $request
     * @param ChecklistExternalAreaCondition|null $externalCond
     * @return array
     */
    public function externalAreaConditionValidate(Request $request, ChecklistExternalAreaCondition $externalCond = null)
    {
        return $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'is_general_cleanliness_satisfied' => 'nullable|boolean',
            'general_cleanliness_remarks' => 'nullable|string',
            'is_fencing_gate_satisfied' => 'nullable|boolean',
            'fencing_gate_remarks' => 'nullable|string',
            'is_external_facade_satisfied' => 'nullable|boolean',
            'external_facade_remarks' => 'nullable|string',
            'is_car_park_satisfied' => 'nullable|boolean',
            'car_park_remarks' => 'nullable|string',
            'is_land_settlement_satisfied' => 'nullable|boolean',
            'land_settlement_remarks' => 'nullable|string',
            'is_rooftop_satisfied' => 'nullable|boolean',
            'rooftop_remarks' => 'nullable|string',
            'is_drainage_satisfied' => 'nullable|boolean',
            'drainage_remarks' => 'nullable|string',
            'external_remarks' => 'nullable|string',
            'status' => ['nullable', Rule::in(['pending', 'in_progress', 'completed', 'rejected'])],
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    /**
     * Validate internal area condition data
     *
     * @param Request $request
     * @param ChecklistInternalAreaCondition|null $internalCond
     * @return array
     */
    public function internalAreaConditionValidate(Request $request, ChecklistInternalAreaCondition $internalCond = null)
    {
        return $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'is_door_window_satisfied' => 'nullable|boolean',
            'door_window_remarks' => 'nullable|string',
            'is_staircase_satisfied' => 'nullable|boolean',
            'staircase_remarks' => 'nullable|string',
            'is_toilet_satisfied' => 'nullable|boolean',
            'toilet_remarks' => 'nullable|string',
            'is_ceiling_satisfied' => 'nullable|boolean',
            'ceiling_remarks' => 'nullable|string',
            'is_wall_satisfied' => 'nullable|boolean',
            'wall_remarks' => 'nullable|string',
            'is_water_seeping_satisfied' => 'nullable|boolean',
            'water_seeping_remarks' => 'nullable|string',
            'is_loading_bay_satisfied' => 'nullable|boolean',
            'loading_bay_remarks' => 'nullable|string',
            'is_basement_car_park_satisfied' => 'nullable|boolean',
            'basement_car_park_remarks' => 'nullable|string',
            'internal_remarks' => 'nullable|string',
            'status' => ['nullable', Rule::in(['pending', 'in_progress', 'completed', 'rejected'])],
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    /**
     * Validate property development data
     *
     * @param Request $request
     * @param ChecklistPropertyDevelopment|null $propertyDev
     * @return array
     */
    public function propertyDevelopmentValidate(Request $request, ChecklistPropertyDevelopment $propertyDev = null)
    {
        return $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            // Development fields
            'development_date' => 'nullable|date',
            'development_scope_of_work' => 'nullable|string',  // Changed from development_expansion_status
            'development_status' => 'nullable|string|max:255',
            
            // Renovation fields
            'renovation_date' => 'nullable|date',
            'renovation_scope_of_work' => 'nullable|string',  // Added missing field
            'renovation_status' => 'nullable|string|max:255',  // This replaces renovation_completion_status
            
            // External repainting fields
            'external_repainting_date' => 'nullable|date',  // Changed from repainting_date
            'external_repainting_scope_of_work' => 'nullable|string',  // Added missing field
            'external_repainting_status' => 'nullable|string|max:255',  // This replaces repainting_completion_status
            
            // Others/Proposals/Approvals fields
            'others_proposals_approvals_date' => 'nullable|date',  // Added missing field
            'others_proposals_approvals_scope_of_work' => 'nullable|string',  // Added missing field
            'others_proposals_approvals_status' => 'nullable|string|max:255',  // Added missing field
        ]);
    }

    /**
     * Validate disposal installation data
     *
     * @param Request $request
     * @param ChecklistDisposalInstallation|null $disposalInst
     * @return array
     */
    public function disposalInstallationValidate(Request $request, ChecklistDisposalInstallation $disposalInst = null)
    {
        return $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'component_name' => 'nullable|string|max:255',
            'component_date' => 'nullable|date',
            'component_scope_of_work' => 'nullable|string',
            'component_status' => 'nullable|string|max:255',
            'status' => ['nullable', Rule::in(['active', 'inactive', 'pending', 'completed'])],
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'approval_datetime' => 'nullable|date',
        ]);
    }
    
    public function ChecklistSubmissionLegal(Checklist $checklist)
    {
        try {
            $checklist->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()
                ->route('tenant-m.index', $checklist->property)
                ->with('success', 'Checklist submitted for legal approval successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error submitting for legal approval: ' . $e->getMessage());
        }
    }

    // Appointment Module
    public function AppointmentIndex(Request $request)
    {
        // Retrieve appointments with related portfolio, handling search and filtering
        $query = Appointment::with('portfolio')
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('party_name', 'like', "%{$search}%")
                    ->orWhere('appointment_title', 'like', "%{$search}%")
                    ->orWhereHas('portfolio', function($portfolio) use ($search) {
                        $portfolio->where('portfolio_name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->input('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        // Get distinct years for filter
        $years = Appointment::orderBy('date_of_approval', 'desc')->get();

        // Get status options
        $statuses = ['pending', 'approved', 'completed', 'cancelled'];

        return view('maker.appointment.index', [
            'appointments' => $query,
            'years' => $years,
            'statuses' => $statuses
        ]);
    }

    public function AppointmentCreate()
    {
        // Retrieve portfolios for selection
        $portfolios = Portfolio::select('id', 'portfolio_name')->get();

        return view('maker.appointment.create', [
            'portfolios' => $portfolios
        ]);
    }

    public function AppointmentStore(Request $request)
    {
        // Validate the request
        $validated = $this->AppointmentValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('appointments', 'public');
        }

        try {
            $appointment = Appointment::create($validated);
            
            return redirect()
                ->route('appointment-m.show', $appointment)
                ->with('success', 'Appointment created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error checking existing appointment: ' . $e->getMessage());
        }
    }

    public function AppointmentEdit(Appointment $appointment)
    {
        // Retrieve portfolios for selection
        $portfolios = Portfolio::select('id', 'portfolio_name')->get();

        return view('maker.appointment.edit', [
            'appointment' => $appointment,
            'portfolios' => $portfolios
        ]);
    }

    public function AppointmentUpdate(Request $request, Appointment $appointment)
    {
        // Validate the request
        $validated = $this->AppointmentValidate($request, $appointment);

        if ($request->hasFile('attachment')) {
            // delete exist
            if ($appointment->attachment && Storage::disk('public')->exists($appointment->attachment)) {
                Storage::disk('public')->delete($appointment->attachment);
            }
            
            $validated['attachment'] = $request->file('attachment')->store('appointments', 'public');
        }

        try {
            $appointment->update($validated);
            
            return redirect()
                ->route('appointment-m.show', $appointment)
                ->with('success', 'Appointment updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error checking existing appointment: ' . $e->getMessage());
        }
    }

    public function AppointmentShow(Appointment $appointment)
    {
        // Load related portfolio
        $appointment->load('portfolio');

        return view('maker.appointment.show', [
            'appointment' => $appointment
        ]);
    }

    public function AppointmentValidate(Request $request, Appointment $appointment = null)
    {
        return $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'date_of_approval' => 'required|date',
            'party_name' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    // Approval Form Module
    public function ApprovalFormIndex(Request $request)
    {
        // Retrieve approval forms with related portfolio and property, handling search and filtering
        $query = ApprovalForm::with(['portfolio', 'property'])
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('form_title', 'like', "%{$search}%")
                    ->orWhere('form_number', 'like', "%{$search}%")
                    ->orWhere('reference_code', 'like', "%{$search}%")
                    ->orWhereHas('portfolio', function($portfolio) use ($search) {
                        $portfolio->where('portfolio_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('property', function($property) use ($search) {
                        $property->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->input('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->input('form_category'), function ($query, $category) {
                return $query->where('form_category', $category);
            })
            ->when($request->input('date_range'), function ($query, $dateRange) {
                $dates = explode(' to ', $dateRange);
                if (count($dates) == 2) {
                    return $query->whereBetween('received_date', $dates);
                }
            })
            ->latest()
            ->paginate(15);

        // Get distinct form categories and statuses for filters
        $formCategories = ApprovalForm::select('form_category')->distinct()->get();
        $statuses = ['pending', 'approved', 'rejected', 'in_review'];

        return view('maker.approval-form.index', [
            'approvalForms' => $query,
            'formCategories' => $formCategories,
            'statuses' => $statuses
        ]);
    }

    public function ApprovalFormCreate()
    {
        // Retrieve portfolios and properties for selection
        $portfolios = Portfolio::select('id', 'portfolio_name')->get();
        $properties = Property::select('id', 'name')->get();

        return view('maker.approval-form.create', [
            'portfolios' => $portfolios,
            'properties' => $properties
        ]);
    }

    public function ApprovalFormStore(Request $request)
    {
        // Validate the request
        $validated = $this->ApprovalFormValidate($request);

        // Set default status and prepared_by
        $validated['status'] = 'pending';
        $validated['prepared_by'] = Auth::user()->name;

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('approval-forms', 'public');
        }

        try {
            $approvalForm = ApprovalForm::create($validated);

            return redirect()
                ->route('approval-form-m.show', $approvalForm)
                ->with('success', 'Approval Form created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating approval form: ' . $e->getMessage());
        }
    }

    public function ApprovalFormEdit(ApprovalForm $approvalForm)
    {
        // Retrieve portfolios and properties for selection
        $portfolios = Portfolio::select('id', 'portfolio_name')->get();
        $properties = Property::select('id', 'name', 'portfolio_id')->get();

        return view('maker.approval-form.edit', [
            'approvalForm' => $approvalForm,
            'portfolios' => $portfolios,
            'properties' => $properties
        ]);
    }

    public function ApprovalFormUpdate(Request $request, ApprovalForm $approvalForm)
    {
        $validated = $this->ApprovalFormValidate($request, $approvalForm);

        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($approvalForm->attachment) {
                Storage::disk('public')->delete($approvalForm->attachment);
            }

            $validated['attachment'] = $request->file('attachment')->store('approval-forms', 'public');
        }
        
        // Check if send_date is being added or updated
        $sendDateAdded = !$approvalForm->send_date && !empty($validated['send_date']);
        $sendDateUpdated = $approvalForm->send_date && 
                        !empty($validated['send_date']) && 
                        $approvalForm->send_date->format('Y-m-d') !== $validated['send_date'];
                        
        // If send_date is added or updated, change status to "completed"
        if ($sendDateAdded || $sendDateUpdated) {
            $validated['status'] = 'completed';
        }

        try {
            $approvalForm->update($validated);

            return redirect()
                ->route('approval-form-m.show', $approvalForm)
                ->with('success', 'Approval Form updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating approval form: ' . $e->getMessage());
        }
    }

    public function ApprovalFormShow(ApprovalForm $approvalForm)
    {
        // Load related models
        $approvalForm->load('portfolio', 'property');

        return view('maker.approval-form.show', [
            'approvalForm' => $approvalForm
        ]);
    }

    public function ApprovalFormValidate(Request $request, ApprovalForm $approvalForm = null)
    {
        // Validation rules based on the actual database schema
        $rules = [
            'portfolio_id' => 'nullable|exists:portfolios,id',
            'property_id' => 'nullable|exists:properties,id',
            'category' => 'nullable|string|max:100',
            'details' => 'nullable|string',
            'received_date' => 'required|date',
            'send_date' => 'nullable|date|after_or_equal:received_date',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
            'remarks' => 'nullable|string',
            'status' => 'nullable|string',
            'prepared_by' => 'nullable|string',
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        return $validatedData;
    }

    // Optional: Method to download attachment
    public function ApprovalFormDownloadAttachment(ApprovalForm $approvalForm)
    {
        if (!$approvalForm->attachment) {
            abort(404, 'No attachment found');
        }

        $path = storage_path('app/public/' . $approvalForm->attachment);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->download($path);
    }

    // Site Visit Log (Activity Diary)
    public function SiteVisitLogIndex(Request $request)
    {
        $query = SiteVisitLog::query();
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('visitation_date', [$request->start_date, $request->end_date]);
        }
        
        // Order by visitation date descending by default
        $siteVisitLogs = $query->orderBy('visitation_date', 'desc')
                              ->paginate(10);

        $siteVisits = SiteVisit::where('status', 'active')->get();

        return view('maker.site-visit-log.index', compact('siteVisitLogs', 'siteVisits'));
    }

    public function SiteVisitLogCreate()
    {
        $properties = Property::where('status', 'active')->get();
        return view('maker.site-visit-log.create', compact('properties'));
    }

    public function SiteVisitLogStore(Request $request)
    {
        $validated = $this->SiteVisitLogValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';

        // Handle file upload if present
        if ($request->hasFile('report_attachment')) {
            $path = $request->file('report_attachment')->store('site-visit-logs', 'public');
            $validated['report_attachment'] = $path;
        }

        // Handle follow-up required
        if ($request->has('follow_up_required')) {
            $validated['follow_up_required'] = true;
        } else {
            $validated['follow_up_required'] = false;
        }

        try {
            SiteVisitLog::create($validated);
            
            return redirect()
                ->route('site-visit-log-m.index')
                ->with('success', 'Activity Diary created successfully.');
        } catch(\Exception $e) {
            return back()
                ->with('Error creating activity diary : ' . $e->getMessage());
        }
    }

    public function SiteVisitLogEdit(SiteVisitLog $siteVisitLog)
    {
        $properties = Property::where('status', 'active')->get();
        return view('maker.site-visit-log.edit', compact('siteVisitLog', 'properties'));
    }
    
    public function SiteVisitLogUpdate(Request $request, SiteVisitLog $siteVisitLog)
    {
        $validated = $this->SiteVisitLogValidate($request);

        // Handle file upload if present
        if ($request->hasFile('report_attachment')) {
            $path = $request->file('report_attachment')->store('site-visit-logs', 'public');
            $validated['report_attachment'] = $path;
        }

        // Handle follow-up required
        if ($request->has('follow_up_required')) {
            $validated['follow_up_required'] = true;
        } else {
            $validated['follow_up_required'] = false;
        }

        try {
            $siteVisitLog->update($validated);
            return redirect()
                ->route('site-visit-log-m.index')
                ->with('success', 'Activity Diary updated successfully.');
        } catch(\Exception $e) {
            return back()
                ->with('Error updating activity diary : ' . $e->getMessage());
        }
    }

    public function SiteVisitLogShow(SiteVisitLog $siteVisitLog)
    {
        return view('maker.site-visit-log.show', compact('siteVisitLog'));
    }

    public function SiteVisitLogValidate(Request $request)
    {
        return $request->validate([
            'site_visit_id' => 'required|exists:site_visits,id',
            'visitation_date' => 'required|date',
            'purpose' => 'nullable|string',
            'report_submission_date' => 'nullable|date',
            'report_attachment' => 'nullable|file|mimes:pdf|max:10240',
            'follow_up_required' => 'boolean',
            'remarks' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'approval_datetime' => 'nullable|date',
        ]);
    }

    // Module Approval Property
    public function ApprovalPropertyIndex(Request $request)
    {
        $approvalProperties = ApprovalProperty::where('status', 'pending')->paginate(10);
        return view('maker.approval-property.index', compact('approvalProperties'));
    }

    public function ApprovalPropertyCreate()
    {
        $properties = Property::where('status', 'active')->paginate(10);
        return view('maker.approval-property.create', compact('properties'));
    }

    public function ApprovalPropertyStore(Request $request)
    {
        $validated = $this->ApprovalPropertyValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending';
        

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('approval-properties', 'public');
            $validated['attachment'] = $path;
        }

        try {
            ApprovalProperty::create($validated);

            return redirect()
                ->route('approval-property-m.index')
                ->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error creating property: ' . $e->getMessage());
        }
    }

    public function ApprovalPropertyEdit(ApprovalProperty $approvalProperty)
    {
        $properties = Property::where('status', 'active')->paginate(10);
        return view('maker.approval-property.edit', compact('approvalProperty', 'properties'));
    }

    public function ApprovalPropertyUpdate(Request $request, ApprovalProperty $approvalProperty)
    {
        $validated = $this->ApprovalPropertyValidate($request);
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($approvalProperty->attachment) {
                Storage::disk('public')->delete($approvalProperty->attachment);
            }
            
            // Store new attachment
            $path = $request->file('attachment')->store('approval-properties', 'public');
            $validated['attachment'] = $path;
        }
        
        try {
            $approvalProperty->update($validated);

            return redirect()
                ->route('approval-property-m.index')
                ->with('success', 'Property approval updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating property approval: ' . $e->getMessage());
        }
    }

    public function ApprovalPropertyShow(ApprovalProperty $approvalProperty)
    {
        return view('maker.approval-property.show', compact('approvalProperty'));
    }

    public function ApprovalPropertyValidate(Request $request)
    {
        return $request->validate([
            'property_id' => 'required|exists:properties,id',
            'date_of_approval' => 'required|date',
            'description' => 'required|string',
            'estimated_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240',
        ]);
    }
}
