<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\Announcement;
use App\Models\RelatedDocument;
use App\Models\FacilityInformation;
use App\Models\TrusteeFee;
use App\Models\ComplianceCovenant;
use App\Models\Portfolio;

class ApproverController extends Controller
{
    public function index()
    {
        $issuers = Issuer::query()->whereIn('status', ['Pending', 'Active', 'Rejected'])->latest()->paginate(10);
        return view('approver.index', compact('issuers'));
    }

    public function IssuerEdit(Issuer $issuer)
    {
        return view('approver.issuer.edit', compact('issuer'));
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
        return view('approver.issuer.show', compact('issuer'));
    }

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
     * Approve the issuer
     */
    public function IssuerApprove(Issuer $issuer)
    {
        try {
            $issuer->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Issuer approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving issuer: ' . $e->getMessage());
        }
    }

    /**
     * Reject the issuer
     */
    public function IssuerReject(Request $request, Issuer $issuer)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $issuer->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Issuer rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting issuer: ' . $e->getMessage());
        }
    }

    // Bond Module
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

        return view('approver.details', [
            'issuer' => $issuer,
            'bonds' => $bonds,
            'announcements' => $announcements,
            'documents' => $documents,
            'facilities' => $facilities,
        ]);
    }

    /**
     * Show bond details with optimized performance.
     */
    public function BondShow(Bond $bond)
    {
        // STRATEGY 1: Load only what's shown on initial page view
        // Deferred loading for elements that might not be immediately visible
        
        // Get bare minimum data first to render the page quickly
        $bond->load([
            'issuer:id,issuer_name,issuer_short_name',
            // Only get the 3 most recent rating movements
            'ratingMovements' => function($q) { 
                $q->select('id', 'bond_id', 'rating', 'effective_date')
                ->orderBy('effective_date', 'desc')
                ->limit(3); 
            },
            // Only load upcoming payment schedules
            'paymentSchedules' => function($q) {
                $q->select('id', 'bond_id', 'payment_date', 'coupon_rate')
                ->where('payment_date', '>=', now())
                ->orderBy('payment_date')
                ->limit(3);
            },
            // Only most recent trading activity
            'tradingActivities' => function($q) {
                $q->select('id', 'bond_id', 'trade_date', 'price', 'yield', 'amount')
                ->latest('trade_date')
                ->limit(5);
            },
        ]);
        
        // STRATEGY 2: Perform manual efficient query for related documents
        // Skip nested relationships entirely
        $relatedDocuments = null;
        if ($bond->facility_code) {
            // Direct DB query with specific columns and indexes
            $relatedDocuments = DB::table('related_documents AS rd')
                ->join('facility_informations AS fi', 'fi.id', '=', 'rd.facility_id')
                ->select('rd.id', 'rd.document_name', 'rd.document_type', 'rd.upload_date', 'rd.file_path')
                ->where('fi.facility_code', $bond->facility_code)
                ->where('fi.issuer_id', $bond->issuer_id)
                ->orderBy('rd.upload_date', 'desc')
                ->limit(5) // Use limit instead of paginate for faster response
                ->get();
        }
        
        // STRATEGY 3: Use separate AJAX endpoints for heavy data
        // Instead of loading redemption data here, create a separate endpoint
        // Then load it via AJAX after the page renders
        
        // STRATEGY 4: Tell the view which parts of the bond object to render immediately
        // and which parts to defer
        $viewData = [
            'bond' => $bond,
            'relatedDocuments' => $relatedDocuments,
            'showFullData' => false // Flag for view to know to show minimal UI initially
        ];
        
        return view('approver.bond.show', $viewData);
    }

    /**
     * Get additional bond data via AJAX after initial page load
     */
    public function getBondAdditionalData($bondId)
    {
        $bond = Bond::findOrFail($bondId);
        
        // Load the heavier relationships only when requested
        $bond->load([
            'redemption:id,bond_id,last_call_date',
            'redemption.callSchedules:id,redemption_id,start_date,end_date,call_price',
            'redemption.lockoutPeriods:id,redemption_id,start_date,end_date',
            'charts:id,bond_id,chart_type,period_from,period_to'
        ]);
        
        return response()->json([
            'redemption' => $bond->redemption,
            'charts' => $bond->charts
        ]);
    }

    // Announcement Module
    public function AnnouncementShow(Announcement $announcement)
    {
        $announcement = $announcement->load('issuer');
        return view('approver.announcement.show', compact('announcement'));
    }

    // Related Document & Financial Module
    public function DocumentShow ()
    {
        return view('approver.related-document.show');
    }

    // Facility Information Module
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

        return view('approver.facility-information.show', [
            'issuer' => $facility->issuer,
            'facility' => $facility,
            'activeBonds' => $bonds,
            'documents' => $documents,
            'ratingMovements' => $ratingMovements,
        ]);
    }

    // Trustee Fee Module
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
        return view('approver.trustee-fee.index', compact('trustee_fees', 'issuers'));
    }

    public function TrusteeFeeShow(TrusteeFee $trusteeFee)
    {
        return view('approver.trustee-fee.show', compact('trusteeFee'));
    }

    public function TrusteeFeeApprove(TrusteeFee $trusteeFee)
    {
        try {
            $trusteeFee->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Trustee Fee approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving issuer: ' . $e->getMessage());
        }
    }

    public function TrusteeFeeReject(Request $request, TrusteeFee $trusteeFee)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $trusteeFee->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Trustee Fee rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting issuer: ' . $e->getMessage());
        }
    }

    // Compliance Covenant Module
    public function ComplianceShow(ComplianceCovenant $compliance)
    {
        return view('approver.compliance-covenant.show', compact('compliance'));
    }
}
