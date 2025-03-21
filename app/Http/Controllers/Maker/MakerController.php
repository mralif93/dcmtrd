<?php

namespace App\Http\Controllers\Maker;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\Announcement;
use App\Models\RelatedDocument;
use App\Models\FacilityInformation;
use App\Models\TrusteeFee;
use App\Models\ComplianceCovenant;
use App\Models\Portfolio;


class MakerController extends Controller
{
    // List of Issuers and Portfolio
    public function index()
    {
        $issuers = Issuer::query()->whereIn('status', ['Active', 'Inactive', 'Rejected', 'Draft'])->latest()->paginate(10);
        $trustee_fees = TrusteeFee::query()->whereIn('status', ['Active', 'Inactive', 'Rejected', 'Draft'])->latest()->paginate(10);
        $covenants = ComplianceCovenant::query()->latest()->paginate(10);
        $portfolios = Portfolio::query()->latest()->paginate(10);
        return view('maker.index', compact('issuers', 'trustee_fees', 'covenants', 'portfolios'));
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
            'status' => 'nullable|in:Active,Inactive,Pending,Rejected',
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

    public function BondStore(Request $request, Bond $bond)
    {
        $validated = $this->validateBond($request);

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Pending';

        try {
            $bond = Bond::create($validated);
            return redirect()->route('bond-m.show', $bond)->with('success', 'Bond created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    public function BondEdit(Bond $bond)
    {
        $issuers = Issuer::orderBy('issuer_name')->get();
        return view('maker.bond.edit', compact('bond', 'issuers'));
    }

    public function BondUpdate(Request $request, Bond $bond)
    {
        $validated = $this->validateBond($request, $bond);

        try {
            $bond->update($validated);
            return redirect()->route('bond-m.show', $bond)->with('success', 'Bond updated successfully');
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

    public function BondUploadForm()
    {
        return view('maker.bond.upload');
    }

    public function BondUploadStore(Bond $bond)
    {
        return view('maker.bond.show');
    }

    protected function validateBond(Request $request, Bond $bond = null)
    {
        return $request->validate([
            'bond_sukuk_name' => 'required|string|max:255',
            'sub_name' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'principal' => 'nullable|string|max:100',
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
                Rule::unique('bonds')->ignore($bond?->id)
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
        $validated = $request->validate([
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

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments');
        }

        try {
            $announcement = Announcement::create($validated);
            return redirect()->route('announcement-m.show', $announcement->issuer)->with('success', 'Announcement created successfully');
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
        $validated = $request->validate([
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

        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($announcement->attachment) {
                Storage::delete($announcement->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('attachments');
        }

        try {
            $announcement->update($validated);
            return redirect()->route('announcement-m.show', $announcement->issuer)->with('success', 'Announcement updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    public function AnnouncementShow(Announcement $announcement)
    {
        $announcement = $announcement->load('issuer');
        return view('maker.announcement.show', compact('announcement'));
    }

    // Document Module
    public function DocumentCreate(Issuer $issuer)
    {
        $facilities = FacilityInformation::all();
        return view('maker.related-document.create', compact('facilities', 'issuer'));
    }
    
    public function DocumentStore(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facility_informations,id',
            'document_name' => 'required|max:200',
            'document_type' => 'required|max:50',
            'upload_date' => 'required|date',
            'document_file' => 'required|file|mimes:pdf|max:2048'
        ]);

        $file = $request->file('document_file');
        $validated['file_path'] = $file->store('documents');

        $relatedDocument = RelatedDocument::create($validated);
        return redirect()->route('document-m.show', $relatedDocument)->with('success', 'Document created successfully');
    }

    public function DocumentEdit(RelatedDocument $document)
    {
        $facilities = FacilityInformation::all();
        return view('maker.related-document.edit', compact('document', 'facilities'));
    }

    public function DocumentUpdate(Request $request, RelatedDocument $document)
    {
        $relatedDocument = $document;
        $validated = $request->validate([
            'facility_id' => 'required|exists:facility_informations,id',
            'document_name' => 'required|max:200',
            'document_type' => 'required|max:50',
            'upload_date' => 'required|date',
            'document_file' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        if ($request->hasFile('document_file')) {
            // Delete old file
            if ($relatedDocument->file_path) {
                Storage::delete($relatedDocument->file_path);
            }
            // Store new file
            $validated['file_path'] = $request->file('file_path')->store('documents');
        }

        $relatedDocument->update($validated);
        return redirect()->route('document-m.show', $relatedDocument)->with('success', 'Document updated successfully');
    }

    public function DocumentShow ()
    {
        return view('maker.related-document.show');
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
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'facility_code' => 'required|unique:facility_informations|max:50',
            'facility_number' => 'required|unique:facility_informations|max:50',
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

        // Set guaranteed to false if not present
        $validated['guaranteed'] = $request->has('guaranteed') ? true : false;

        $facilityInformation = FacilityInformation::create($validated);
        return redirect()->route('facility-info-m.show', $facilityInformation)->with('success', 'Facility Information created successfully');
    }

    public function FacilityInfoEdit(FacilityInformation $facility)
    {
        $issuers = Issuer::all();
        return view('maker.facility-information.edit', compact('facility', 'issuers'));
    }

    public function FacilityInfoUpdate(Request $request, FacilityInformation $facility)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'facility_code' => 'required|max:50|unique:facility_informations,facility_code,'.$facilityInformation->id,
            'facility_number' => 'required|max:50|unique:facility_informations,facility_number,'.$facilityInformation->id,
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

        // Set guaranteed to false if not present
        $validated['guaranteed'] = $request->has('guaranteed') ? true : false;

        $facilityInformation->update($validated);
        return redirect()->route('facility-info-m.show', $facilityInformation)->with('success', 'Facility Information updated successfully');
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

    // Trustee Fee
    public function TrusteeFeeCreate()
    {
        $issuers = Issuer::orderBy('name')->get();
        return view('maker.trustee-fee.create', compact('issuers'));
    }

    public function TrusteeFeeStore(Request $request)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'start_anniversary_date' => 'required|date',
            'end_anniversary_date' => 'required|date|after_or_equal:start_anniversary_date',
            'invoice_no' => 'required|string|unique:trustee_fees,invoice_no',
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

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Draft';

        TrusteeFee::create($request->all());

        return redirect()
            ->route('dashboard')
            ->with('success', 'Trustee fee created successfully.');
    }

    public function TrusteeFeeEdit(TrusteeFee $trusteeFee)
    {
        $issuers = Issuer::orderBy('name')->get();
        return view('maker.trustee-fee.edit', compact('trusteeFee', 'issuers'));
    }

    public function TrusteeFeeUpdate(Request $request, TrusteeFee $trusteeFee)
    {
        $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'start_anniversary_date' => 'required|date',
            'end_anniversary_date' => 'required|date|after_or_equal:start_anniversary_date',
            'invoice_no' => 'required|string|unique:trustee_fees,invoice_no,' . $trusteeFee->id,
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

        $trusteeFee->update($request->all());

        return redirect()
            ->route('dashboard')
            ->with('success', 'Trustee fee updated successfully.');
    }

    public function TrusteeFeeShow(TrusteeFee $trusteeFee)
    {
        return view('maker.trustee-fee.show', compact('trusteeFee'));
    }

    public function destroy(TrusteeFee $trusteeFee)
    {
        $trusteeFee->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Trustee fee deleted successfully.');
    }

    public function SubmitApprovalTrusteeFee(TrusteeFee $trusteeFee)
    {
        try {
            $trusteeFee->update([
                'status' => 'Pending',
                'prepared_by' => Auth::user()->name,
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Trustee Fee submitted for approval successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting for approval: ' . $e->getMessage());
        }
    }

    // Compliance Covenants
    public function ComplianceCreate()
    {
        $issuers = Issuer::orderBy('name')->get();
        return view('maker.compliance-covenant.create', compact('issuers'));
    }

    public function ComplianceStore(Request $request)
    {
        $validated = $request->validate([
            'issuer_short_name' => 'required|string|max:255',
            'financial_year_end' => 'required|string|max:255',
            'audited_financial_statements' => 'nullable|string|max:255',
            'unaudited_financial_statements' => 'nullable|string|max:255',
            'compliance_certificate' => 'nullable|string|max:255',
            'finance_service_cover_ratio' => 'nullable|string|max:255',
            'annual_budget' => 'nullable|string|max:255',
            'computation_of_finance_to_ebitda' => 'nullable|string|max:255',
            'ratio_information_on_use_of_proceeds' => 'nullable|string|max:255',
        ]);

        // Add prepared_by from authenticated user and set status to pending
        $validated['prepared_by'] = Auth::user()->name;
        $validated['status'] = 'Draft';

        ComplianceCovenant::create($request->all());

        return redirect()
            ->route('dashboard')
            ->with('success', 'Compliance covenant created successfully.');
    }

    public function ComplianceEdit(ComplianceCovenant $compliance)
    {
        $issuers = Issuer::orderBy('name')->get();
        return view('maker.compliance-covenant.edit', compact('compliance', 'issuers'));
    }

    public function ComplianceUpdate(Request $request, ComplianceCovenant $compliance)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'financial_year_end' => 'required|string|max:255',
            'audited_financial_statements' => 'nullable|string|max:255',
            'unaudited_financial_statements' => 'nullable|string|max:255',
            'compliance_certificate' => 'nullable|string|max:255',
            'finance_service_cover_ratio' => 'nullable|string|max:255',
            'annual_budget' => 'nullable|string|max:255',
            'computation_of_finance_to_ebitda' => 'nullable|string|max:255',
            'ratio_information_on_use_of_proceeds' => 'nullable|string|max:255',
        ]);

        $compliance->update($request->all());

        return redirect()
            ->route('dashboard')
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


    // REITs : Portfolio
    public function PortfolioCreate()
    {
        return view('maker.portfolio.create');
    }

    public function PortfolioStore(Request $request)
    {
        return redirect()->route('portfolio-m.show', $portfolio)->with('success', 'Portfolio created successfully');
    }

    public function PortfolioEdit(Request $request, Portfolio $portfolio)
    {
        return view('maker.portfolio.edit', compact('portfolio'));
    }

    public function PortfolioUpdate(Request $request, Portfolio $portfolio)
    {
        return redirect()->route('portfolio-m.show', $portfolio)->with('success', 'Portfolio updated successfully');
    }

    public function PortfolioShow(Portfolio $portfolio)
    {
        return view('make.portfolio.show');
    }

}
