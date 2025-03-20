<?php

namespace App\Http\Controllers\Maker;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\Announcement;
use App\Models\RelatedDocument;
use App\Models\FacilityInformation;
use App\Models\Portfolio;


class MakerController extends Controller
{
    // List of Issuers and Portfolio
    public function index()
    {
        $issuers = Issuer::query()->whereIn('status', ['Active', 'Draft'])->latest()->paginate(10);
        $portfolios = Portfolio::query()->latest()->paginate(10);
        return view('maker.index', compact('issuers', 'portfolios'));
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

    public function DocumentEdit()
    {
        return view('maker.related-document.edit');
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

    public function FacilityInfoShow()
    {
        return view('maker.facility-information.show');
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
