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

use App\Http\Requests\User\BondFormRequest;


class MakerController extends Controller
{
    public function index(Request $request)
    {
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
                        ->withQueryString(); // This preserves the query parameters in pagination links
    
        // Get count data from cache or database
        $counts = Cache::remember('dashboard_user_counts', now()->addMinutes(5), function () {
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM trustee_fees) AS trustee_fees_count,
                    (SELECT COUNT(*) FROM compliance_covenants) AS compliance_covenants_count,
                    (SELECT COUNT(*) FROM activity_diaries) AS activity_diaries_count,
                    (SELECT COUNT(*) FROM properties) AS properties_count,
                    (SELECT COUNT(*) FROM financials) AS financials_count,
                    (SELECT COUNT(*) FROM tenants) AS tenants_count,
                    (SELECT COUNT(*) FROM appointments) AS appointments_count,
                    (SELECT COUNT(*) FROM approval_forms) AS approval_forms_count,
                    (SELECT COUNT(*) FROM site_visit_logs) AS site_visit_logs_count
            ");
            return (array) $result[0];
        });
    
        // Query for portfolios
        $portfolioQuery = Portfolio::query()->whereIn('status', ['draft', 'active', 'rejected']);
        $portfolios = $portfolioQuery->latest()->paginate(10)->withQueryString();
        
        // Apply search filter to portfolios
        if ($request->has('search') && !empty($request->search)) {
            $portfolioQuery->where('portfolio_name', 'LIKE', '%' . $request->search . '%');
        }
        
        // Apply status filter to portfolios
        if ($request->has('status') && !empty($request->status)) {
            $portfolioQuery->where('status', $request->status);
        }
    
        return view('maker.index', [
            'issuers' => $issuers,
            'portfolios' => $portfolios,
            'trusteeFeesCount' => $counts['trustee_fees_count'],
            'complianceCovenantCount' => $counts['compliance_covenants_count'],
            'activityDairyCount' => $counts['activity_diaries_count'],
            'propertiesCount' => $counts['properties_count'],
            'financialsCount' => $counts['financials_count'],
            'tenantsCount' => $counts['tenants_count'],
            'appointmentsCount' => $counts['appointments_count'],
            'approvalFormsCount' => $counts['approval_forms_count'],
            'siteVisitLogsCount' => $counts['site_visit_logs_count'],
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
    protected function validateIssuer(Request $request, Issuer $issuer = null)
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

    protected function validateBond(Request $request, Bond $bond = null)
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

    protected function validateFacilityInfo(Request $request, FacilityInformation $facility = null)
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

    protected function validateTrusteeFee(Request $request, TrusteeFee $trusteeFee = null)
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
        
        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'draft';
        
        $portfolio = Portfolio::create($validated);
        
        return redirect()->route('maker.dashboard', ['section' => 'reits'])->with('success', 'Portfolio created successfully');
    }

    public function PortfolioEdit(Portfolio $portfolio)
    {
        $portfolioTypes = PortfolioType::where('status', 'active')->get();
        return view('maker.portfolio.edit', compact('portfolio', 'portfolioTypes'));
    }

    public function PortfolioUpdate(Request $request, Portfolio $portfolio)
    {
        $validated = $this->validatePortfolio($request, $portfolio);
        
        $portfolio->update($validated);
        
        return redirect()->route('portfolio-m.show', $portfolio)->with('success', 'Portfolio updated successfully');
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
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }
    
    protected function validatePortfolio(Request $request, Portfolio $portfolio = null)
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
            
            return redirect()->route('property-m.index', $financial->portfolio)->with('success', 'Financial created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating financial: ' . $e->getMessage());
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
        
        // Remove the dd() statement that's stopping execution
        // dd($request->toArray());
        
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
            
            return redirect()->route('property-m.index', $financial->portfolio)->with('success', 'Financial updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating financial: ' . $e->getMessage());
        }
    }

    public function FinancialShow(Financial $financial)
    {
        // Load the properties associated with this financial
        $financial->load(['properties', 'portfolio', 'bank', 'financialType']);
        
        return view('maker.financial.show', compact('financial'));
    }

    public function FinancialValidate(Request $request, Financial $financial = null) {
        return $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'bank_id' => 'required|exists:banks,id',
            'financial_type_id' => 'required|exists:financial_types,id',
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
        $validated = $this->PropertyValidate($request);

        // Add prepared_by from authenticated user and set status
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Active';

        try {
            $property = Property::create($validated);
            return redirect()->route('property-m.index', $property->portfolio)->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating property: ' . $e->getMessage());
        }
    }

    public function PropertyEdit(Property $property)
    {
        $portfolios = Portfolio::orderBy('portfolio_name')->get();
        return view('maker.property.edit', compact('portfolios', 'property'));
    }

    public function PropertyUpdate(Request $request, Property $property)
    {
        $validated = $this->PropertyValidate($request);

        try {
            $property->update($validated);
            return redirect()->route('property-m.index', $property->portfolio)->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating property: ' . $e->getMessage());
        }
    }

    public function PropertyShow(Property $property)
    {
        return view('maker.property.show', compact('property'));
    }

    public function PropertyValidate(Request $request, Property $property = null)
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
            'status' => 'nullable|string|in:Draft,Active,Pending,Inactive'
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
        $properties = Property::orderBy('property_name')->get();
        return view('maker.tenant.create', compact('properties', 'propertyInfo'));
    }

    public function TenantStore(Request $request)
    {
        $validated = $this->TenantValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Active';

        try {
            $tenant = Tenant::create($validated);
            return redirect()->route('tenant-m.index', $tenant->property)->with('success', 'Tenant created successfully.');
        } catch(\Exception $e) {
            return back()->withInput()->with('error', 'Error creating tenant: ' . $e->getMessage());
        }
    }

    public function TenantEdit(Tenant $tenant)
    {
        $properties = Property::orderBy('property_name')->get();
        return view('maker.tenant.edit', compact('tenant', 'properties'));
    }

    public function TenantUpdate(Request $request, Tenant $tenant)
    {
        $validated = $this->TenantValidate($request);

        try {
            $tenant->update($validated);
            return redirect()->route('tenant-m.index', $tenant->property)->with('success', 'Tenant updated successfully.');
        } catch(\Exception $e) {
            return back()->withInput()->with('error', 'Error updating tenant: ' . $e->getMessage());
        }
    }

    public function TenantShow(Tenant $tenant)
    {
        return view('maker.tenant.show', compact('tenant'));
    }

    public function TenantValidate(Request $request, Tenant $tenant = null)
    {
        return $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'commencement_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:commencement_date',
            'status' => 'nullable|in:active,inactive',
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

    public function LeaseStore(Request $request, Property $property)
    {
        $validated = $this->LeaseValidate($request);

        // Set default values
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'pending'; // Setting initial status to pending
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('lease-attachments', 'public');
        }

        try {
            $lease = Lease::create($validated);
            return redirect()->route('lease-m.index', $property)->with('success', 'Lease created successfully.');
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

        // Update prepared_by field only if not already set
        if (empty($lease->prepared_by)) {
            $validated['prepared_by'] = Auth::user()->name;
        }
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($lease->attachment && Storage::disk('public')->exists($lease->attachment)) {
                Storage::disk('public')->delete($lease->attachment);
            }
            
            $validated['attachment'] = $request->file('attachment')->store('lease-attachments', 'public');
        } else {
            // If no new file is uploaded, keep the existing one
            unset($validated['attachment']);
        }

        try {
            $lease->update($validated);
            return redirect()->route('lease-m.show', $lease->tenant->property)->with('success', 'Lease updated successfully.');
        } catch(\Exception $e) {
            return back()->with('error', 'Error updating lease: ' . $e->getMessage());
        }
    }

    public function LeaseShow(Lease $lease)
    {
        return view('maker.lease.show', compact('lease'));
    }

    public function LeaseValidate(Request $request, Lease $lease = null)
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
            'base_rate_year_1' => 'required|numeric|min:0',
            'monthly_gsto_year_1' => 'required|numeric|min:0',
            'base_rate_year_2' => 'required|numeric|min:0',
            'monthly_gsto_year_2' => 'required|numeric|min:0',
            'base_rate_year_3' => 'required|numeric|min:0',
            'monthly_gsto_year_3' => 'required|numeric|min:0',
            'space' => 'required|numeric|min:0',
            'tenancy_type' => 'nullable|string|max:255',
            'attachment' => $lease ? 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240' : 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
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
        $validated['status'] = 'Active';

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

    public function SiteVisitValidate(Request $request, SiteVisit $siteVisit = null)
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
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
    }

    // Checklist Module
    public function ChecklistIndex(Property $property, Request $request)
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
                            ->where('status', 'completed')
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
        $tenantData = $this->validateChecklistTenants($request);
        
        // Add the authenticated user's ID as prepared_by
        $validated['prepared_by'] = Auth::id();
        
        // Set default status to 'pending' to match schema default
        $validated['status'] = 'pending';
        
        try {
            // Create the checklist with validated data
            $checklist = Checklist::create($validated);
            
            // Attach tenants if any were selected and validated
            if (!empty($tenantData) && isset($tenantData['tenants']) && !empty($tenantData['tenants'])) {
                $pivotData = [];
                
                foreach ($tenantData['tenants'] as $tenantId) {
                    $pivotData[$tenantId] = [
                        'notes' => $request->input('tenant_notes.' . $tenantId),
                        'status' => 'pending',
                        'prepared_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                
                $checklist->tenants()->attach($pivotData);
            }
            
            // Get property_id from site_visit for redirection
            $siteVisit = SiteVisit::findOrFail($request->site_visit_id);
            
            return redirect()->route('tenant-m.index', $siteVisit->property_id)
                ->with('success', 'Checklist created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistEdit(Checklist $checklist)
    {
        // Check if the user has permission to edit this checklist
        // Only allow editing if status is pending
        if ($checklist->status !== 'pending') {
            return redirect()->route('checklist-m.show', $checklist->id)
                ->with('error', 'Cannot edit a checklist that has already been processed.');
        }
        
        // Get site visits related to the property
        $property = $checklist->siteVisit->property;
        $siteVisits = SiteVisit::where('property_id', $property->id)
                            ->whereIn('status', ['completed', 'scheduled'])
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
        // Check if the user has permission to update this checklist
        if ($checklist->status !== 'pending') {
            return redirect()->route('checklist-m.show', $checklist->id)
                ->with('error', 'Cannot update a checklist that has already been processed.');
        }
        
        // Get the validated data from the separate validation methods
        $validated = $this->checklistValidate($request, $checklist);
        $tenantData = $this->validateChecklistTenants($request, $checklist);
        
        // Update prepared_by only if it's not already set
        if (empty($checklist->prepared_by)) {
            $validated['prepared_by'] = Auth::id();
        }
        
        // Record the last update
        $validated['updated_at'] = now();
    
        try {
            // Update the checklist with validated data
            $checklist->update($validated);
            
            // Only update tenants if we're allowed to (not verified) and have tenant data
            if (!empty($tenantData) && isset($tenantData['tenants'])) {
                // Sync tenants (this will detach any removed tenants and attach any new ones)
                $syncData = [];
                
                foreach ($tenantData['tenants'] as $tenantId) {
                    // Get existing pivot data if any
                    $existingPivot = $checklist->tenants()
                        ->where('tenant_id', $tenantId)
                        ->first()?->pivot;
                    
                    $syncData[$tenantId] = [
                        'notes' => $request->input('tenant_notes.' . $tenantId),
                        'status' => 'pending',
                        'prepared_by' => $existingPivot?->prepared_by ?? Auth::id(),
                        'updated_at' => now(),
                    ];
                }
                
                $checklist->tenants()->sync($syncData);
            }
            
            return redirect()->route('checklist-m.show', $checklist->id)
                ->with('success', 'Checklist updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistShow(Checklist $checklist)
    {
        return view('maker.checklist.show', compact('checklist'));
    }

    /**
     * Validate the main checklist data
     */
    public function checklistValidate(Request $request, Checklist $checklist = null)
    {
        $rules = [
            // General Property Info
            'property_title' => 'nullable|string|max:255',
            'property_location' => 'nullable|string|max:255',
            'site_visit_id' => 'required|exists:site_visits,id',
            
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
            
            // 3.0 External Area Conditions
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
            
            // 4.0 Internal Area Conditions
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
            
            // 5.0 Property Development
            'development_date' => 'nullable|date',
            'development_expansion_status' => 'nullable|string|max:255',
            'development_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            'renovation_date' => 'nullable|date',
            'renovation_status' => 'nullable|string|max:255',
            'renovation_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            'repainting_date' => 'nullable|date',
            'external_repainting_status' => 'nullable|string|max:255',
            'repainting_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            
            // 5.4 Disposal/Installation/Replacement
            'water_tank_date' => 'nullable|date',
            'water_tank_status' => 'nullable|string|max:255',
            'water_tank_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            'air_conditioning_approval_date' => 'nullable|date',
            'air_conditioning_scope' => 'nullable|string',
            'air_conditioning_status' => 'nullable|string|max:255',
            'air_conditioning_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            'lift_date' => 'nullable|date',
            'lift_escalator_scope' => 'nullable|string',
            'lift_escalator_status' => 'nullable|string|max:255',
            'lift_escalator_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            'fire_system_date' => 'nullable|date',
            'fire_system_scope' => 'nullable|string',
            'fire_system_status' => 'nullable|string|max:255',
            'fire_system_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            'other_system_date' => 'nullable|date',
            'other_property' => 'nullable|string',
            'other_completion_status' => 'nullable|string|in:n/a,pending,in_progress,completed',
            
            // 5.5 Other Proposals/Approvals
            'other_proposals_approvals' => 'nullable|string',
            
            // System Information
            'status' => 'nullable|string|in:pending,active,completed,verified',
            'remarks' => 'nullable|string',
        ];
        
        // Different rules for create vs. update
        if ($checklist) {
            // Update operation
            
            // If the checklist is already verified, restrict certain fields
            if ($checklist->verified_by) {
                // Only allow updating remarks if already verified
                return $request->validate([
                    'remarks' => 'nullable|string'
                ]);
            }
            
            // If the checklist has a prepared_by but no verified_by, it's in review
            if ($checklist->prepared_by && !$checklist->verified_by) {
                // Allow verification-related fields
                $rules['verified_by'] = 'nullable|exists:users,id';
                $rules['approval_datetime'] = 'nullable|date';
                
                // Status can only be changed to specific values during verification
                $rules['status'] = 'nullable|string|in:pending,active,completed';
            }
        } else {
            // Create operation
            // For create, prepared_by is handled in the controller, not via validation
            // Don't allow setting verification fields on create
            unset($rules['verified_by']);
            unset($rules['approval_datetime']);
            
            // For create, status is limited to 'pending'
            $rules['status'] = 'nullable|string|in:pending';
        }
        
        return $request->validate($rules);
    }

    /**
     * Validate tenant data for checklist
     */
    public function validateChecklistTenants(Request $request, Checklist $checklist = null)
    {
        $rules = [
            'tenants' => 'nullable|array',
            'tenants.*' => 'exists:tenants,id',
            'tenant_notes' => 'nullable|array',
            'tenant_notes.*' => 'nullable|string|max:1000',
        ];
        
        // If the checklist is already verified, don't allow tenant changes
        if ($checklist && $checklist->verified_by) {
            // Return an empty array since tenant updates aren't allowed for verified checklists
            return [];
        }
        
        return $request->validate($rules);
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
            ->when($request->input('year'), function ($query, $year) {
                return $query->where('year', $year);
            })
            ->latest()
            ->paginate(15);

        // Get distinct years for filter
        $years = Appointment::select('year')->distinct()->orderBy('year', 'desc')->get();

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
        $validatedData = $this->AppointmentValidate($request);

        // Create the appointment
        $appointment = Appointment::create($validatedData);

        // Redirect with success message
        return redirect()->route('appointment-m.show', $appointment)
            ->with('success', 'Appointment created successfully.');
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
        $validatedData = $this->AppointmentValidate($request, $appointment);

        // Update the appointment
        $appointment->update($validatedData);

        // Redirect with success message
        return redirect()->route('appointment-m.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function AppointmentShow(Appointment $appointment)
    {
        // Load related portfolio
        $appointment->load('portfolio', 'preparedBy', 'verifiedBy');

        return view('maker.appointment.show', [
            'appointment' => $appointment
        ]);
    }

    public function AppointmentValidate(Request $request, Appointment $appointment = null)
    {
        // Validation rules
        $rules = [
            'portfolio_id' => 'required|exists:portfolios,id',
            'party_name' => 'required|string|max:255',
            'date_of_approval' => 'required|date',
            'appointment_title' => 'required|string|max:255',
            'appointment_description' => 'required|string',
            'estimated_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 5),
            'reference_no' => 'nullable|string|max:100',
        ];

        // Unique reference number validation (optional)
        if (!$appointment) {
            $rules['reference_no'] .= '|unique:appointments';
        } else {
            $rules['reference_no'] .= '|unique:appointments,reference_no,' . $appointment->id;
        }

        // Validate the request
        $validatedData = $request->validate($rules);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('appointments', 'public');
            $validatedData['attachment'] = $path;
        }

        // Add current user as prepared_by if creating new
        if (!$appointment) {
            $validatedData['prepared_by'] = auth()->id();
        }

        // Set the year if not provided
        $validatedData['year'] = $validatedData['year'] ?? date('Y');

        return $validatedData;
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
        $users = User::select('id', 'name')->get();

        return view('maker.approval-form.create', [
            'users' => $users,
            'portfolios' => $portfolios,
            'properties' => $properties
        ]);
    }

    public function ApprovalFormStore(Request $request)
    {
        // Validate the request
        $validatedData = $this->ApprovalFormValidate($request);

        // Create the approval form
        $approvalForm = ApprovalForm::create($validatedData);

        // Redirect with success message
        return redirect()->route('approval-form-m.show', $approvalForm)
            ->with('success', 'Approval Form created successfully.');
    }

    public function ApprovalFormEdit(ApprovalForm $approvalForm)
    {
        // Retrieve portfolios and properties for selection
        $portfolios = Portfolio::select('id', 'portfolio_name')->get();
        $properties = Property::select('id', 'name', 'portfolio_id')->get();
        $users = User::select('id', 'name')->get();

        return view('maker.approval-form.edit', [
            'users' => $users,
            'approvalForm' => $approvalForm,
            'portfolios' => $portfolios,
            'properties' => $properties
        ]);
    }

    public function ApprovalFormUpdate(Request $request, ApprovalForm $approvalForm)
    {
        // Validate the request
        $validatedData = $this->ApprovalFormValidate($request, $approvalForm);

        // Update the approval form
        $approvalForm->update($validatedData);

        // Redirect with success message
        return redirect()->route('approval-form-m.show', $approvalForm)
            ->with('success', 'Approval Form updated successfully.');
    }

    public function ApprovalFormShow(ApprovalForm $approvalForm)
    {
        // Load related models
        $approvalForm->load('portfolio', 'property', 'preparedBy', 'verifiedBy');

        return view('maker.approval-form.show', [
            'approvalForm' => $approvalForm
        ]);
    }

    public function ApprovalFormValidate(Request $request, ApprovalForm $approvalForm = null)
    {
        // Validation rules
        $rules = [
            'portfolio_id' => 'nullable|exists:portfolios,id',
            'property_id' => 'nullable|exists:properties,id',
            'form_number' => 'nullable|string|max:50',
            'form_title' => 'required|string|max:255',
            'form_category' => 'nullable|string|max:100',
            'reference_code' => 'nullable|string|max:100',
            'received_date' => 'required|date',
            'send_date' => 'nullable|date|after_or_equal:received_date',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];

        // Unique reference code validation (optional)
        if (!$approvalForm) {
            $rules['reference_code'] .= '|unique:approval_forms';
        } else {
            $rules['reference_code'] .= '|unique:approval_forms,reference_code,' . $approvalForm->id;
        }

        // Validate the request
        $validatedData = $request->validate($rules);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('approval-forms', 'public');
            $validatedData['attachment'] = $path;
        }

        // Add current user as prepared_by if creating new
        if (!$approvalForm) {
            $validatedData['prepared_by'] = auth()->id();
        }

        return $validatedData;
    }

    // Optional: Method to verify/approve an approval form
    public function ApprovalFormVerify(ApprovalForm $approvalForm)
    {
        // Check user permissions
        $this->authorize('verify', $approvalForm);

        $approvalForm->update([
            'status' => 'approved',
            'verified_by' => auth()->id(),
            'approval_datetime' => now()
        ]);

        return redirect()->route('approval-form-m.show', $approvalForm)
            ->with('success', 'Approval Form verified successfully.');
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
        $siteVisits = SiteVisit::where('status', 'active')->get();
        return view('maker.site-visit-log.create', compact('siteVisits'));
    }

    public function SiteVisitLogStore(Request $request)
    {
        $validated = $this->SiteVisitLogValidate($request);

        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'status';

        try {
            SiteVisitLog::create($validated);
            return redirect()->route('site-visit-log-m.index')->with('success', 'Site visit log created successfully.');
        } catch(\Exception $e) {
            return back()->with('Error creating site visit log : ' . $e->getMessage());
        }
    }

    public function SiteVisitLogEdit(SiteVisitLog $siteVisitLog)
    {
        $siteVisits = SiteVisit::where('status', 'active')->get();
        return view('maker.site-visit-log.edit', compact('siteVisitLog', 'siteVisits'));
    }

    public function SiteVisitLogUpdate(Request $request, SiteVisitLog $siteVisitLog)
    {
        $validated = $this->SiteVisitLogValidate($request);

        try {
            $siteVisitLog->update($validated);
            return redirect()->route('site-visit-log-m.index')->with('success', 'Site visit log updated successfully.');
        } catch(\Exception $e) {
            return back()->with('Error updating site visit log : ' . $e->getMessage());
        }
    }

    public function SiteVisitLogShow(SiteVisitLog $siteVisitLog)
    {
        return view('maker.site-visit-log.show', compact('siteVisitLog'));
    }

    public function SiteVisitLogValidate(Request $request, SiteVisitLog $siteVisitLog = null)
    {
        return $request->validate([
            'site_visit_id' => 'required|exists:site_visits,id',
            'no' => 'required|integer',
            'visitation_date' => 'required|date',
            'purpose' => 'required|string',
            'report_submission_date' => 'nullable|date',
            'report_attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'follow_up_required' => 'boolean',
            'remarks' => 'nullable|string',
        ]);
    }
}
