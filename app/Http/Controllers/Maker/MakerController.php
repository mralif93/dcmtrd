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
use App\Models\Portfolio;

use App\Http\Requests\User\BondFormRequest;


class MakerController extends Controller
{
    // List of Issuers and Portfolio
    public function index(Request $request)
    {
        // Start with a base query
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
        
        $portfolios = Portfolio::query()->latest()->paginate(10);

        $counts = Cache::remember('dashboard_user_counts', now()->addMinutes(5), function () {
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM trustee_fees) AS trustee_fees_count,
                    (SELECT COUNT(*) FROM compliance_covenants) AS compliance_covenants_count,
                    (SELECT COUNT(*) FROM activity_diaries) AS activity_diaries_count
            ");
            return (array) $result[0];
        });

        
        return view('maker.index', [
            'issuers' => $issuers,
            'portfolios' => $portfolios,
            'trusteeFeesCount' => $counts['trustee_fees_count'],
            'complianceCovenantCount' => $counts['compliance_covenants_count'],
            'activityDairyCount' => $counts['activity_diaries_count'],
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
        $validated['status'] = 'Draft';

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
            'status' => 'nullable|in:Draft,Active,Inactive,Pending,Rejected',
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

    public function DocumentShow ()
    {
        return view('maker.related-document.show');
    }

    protected function validateDocument(Request $request)
    {
        return $request->validate([
            'facility_id' => 'required|exists:facility_informations,id',
            'document_name' => 'required|max:200',
            'document_type' => 'required|max:50',
            'upload_date' => 'required|date',
            'document_file' => 'required|file|mimes:pdf|max:2048'
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
            'principle_type' => 'required|max:50',
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
        $paymentSchedule->load('bond.issuer');
        return view('maker.payment-schedule.show', compact('paymentSchedule'));
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
        $schedule->load('redemption.bond');
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
        return view('maker.lockout-periods.show', compact('period'));
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
        $query = TrusteeFee::with('issuer');
        
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->where('issuer_id', $request->issuer_id);
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
        $issuers = Issuer::orderBy('name')->get();
        
        $trustee_fees = $query->latest()->paginate(10);
        return view('maker.trustee-fee.index', compact('trustee_fees', 'issuers'));
    }

    public function TrusteeFeeCreate()
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.trustee-fee.create', compact('issuers'));
    }

    public function TrusteeFeeStore(Request $request)
    {
        $validated = $this->validateTrusteeFee($request);

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Draft';

        TrusteeFee::create($validated);

        return redirect()
            ->route('trustee-fee-m.show', $trusteeFee)
            ->with('success', 'Trustee fee created successfully.');
    }

    public function TrusteeFeeEdit(TrusteeFee $trusteeFee)
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.trustee-fee.edit', compact('trusteeFee', 'issuers'));
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
            'issuer_id' => 'required|exists:issuers,id',
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

        // Search by issuer short name
        if ($request->has('issuer_short_name') && !empty($request->issuer_short_name)) {
            $query->where('issuer_short_name', 'LIKE', '%' . $request->issuer_short_name . '%');
        }

        // Search by financial year end
        if ($request->has('financial_year_end') && !empty($request->financial_year_end)) {
            $query->where('financial_year_end', 'LIKE', '%' . $request->financial_year_end . '%');
        }

        // Filter by compliance status
        if ($request->has('status')) {
            if ($request->status === 'compliant') {
                $query->compliant();
            } elseif ($request->status === 'non_compliant') {
                $query->nonCompliant();
            }
        }

        // Get results with pagination
        $covenants = $query->latest()->paginate(10);
        $covenants->appends($request->all());
        
        return view('maker.compliance-covenant.index', compact('covenants'));
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
        $validated['status'] = 'Draft';

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
        
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
        
        $activities = $query->latest()->paginate(10)->withQueryString();
        
        return view('maker.activity-diary.index', compact('activities'));
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
        $validated['status'] = 'Draft';

        $activity = ActivityDiary::create($validated);

        return redirect()
            ->route('activity-diary-m.show', $activity)
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
            ->route('activity-diary-m.show', $activity)
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
    public function updateStatus(Request $request, ActivityDiary $activity)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'compiled', 'notification', 'passed'])],
        ]);

        // Handle approval datetime if status is changing to completed
        if ($validated['status'] === 'completed' && $activity->status !== 'completed') {
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
            'status' => ['nullable', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'compiled', 'notification', 'passed'])],
            'remarks' => 'nullable|string',
            'verified_by' => 'nullable|string',
        ]);
    }

    // REITs : Portfolio
    public function PortfolioCreate()
    {
        return view('maker.portfolio.create');
    }

    public function PortfolioStore(Request $request)
    {
        $validated = $this->validatePortfolio($request);
        
        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Draft';
        
        $portfolio = Portfolio::create($validated);
        
        return redirect()->route('portfolio-m.show', $portfolio)->with('success', 'Portfolio created successfully');
    }

    public function PortfolioEdit(Portfolio $portfolio)
    {
        return view('maker.portfolio.edit', compact('portfolio'));
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
    
    protected function validatePortfolio(Request $request, Portfolio $portfolio = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'acquisition_date' => 'required|date',
            'acquisition_cost' => 'required|numeric|min:0',
            'market_value' => 'required|numeric|min:0',
            'gross_floor_area' => 'nullable|numeric|min:0',
            'net_lettable_area' => 'nullable|numeric|min:0',
            'occupancy_rate' => 'nullable|numeric|between:0,100',
            'property_type' => 'required|string|max:100',
            'status' => 'nullable|in:Draft,Active,Inactive,Pending,Rejected',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
    }
}
