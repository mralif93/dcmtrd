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
use App\Models\ChecklistLegalDocumentation;
use App\Models\ChecklistTenant;
use App\Models\ChecklistExternalAreaCondition;
use App\Models\ChecklistInternalAreaCondition;
use App\Models\ChecklistPropertyDevelopment;
use App\Models\ChecklistDisposalInstallation;
use App\Models\SiteVisit;
use App\Models\SiteVisitLog;
use App\Models\Appointment;
use App\Models\ApprovalForm;
use App\Models\ApprovalProperty;

class ApproverController extends Controller
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
        $issuers = $query->whereIn('status', ['active', 'pending', 'rejected', 'draft'])
                        ->latest()
                        ->paginate(10)
                        ->withQueryString();

        // Query for portfolios
        $portfolioQuery = Portfolio::query()->whereIn('status', ['pending', 'active', 'rejected']);
        $portfolios = $portfolioQuery->latest()->paginate(10)->withQueryString();

        $counts = Cache::remember('dashboard_user_counts', now()->addMinutes(1), function () {
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM trustee_fees) AS trustee_fees_count,
                    (SELECT COUNT(*) FROM compliance_covenants) AS compliance_covenants_count,
                    (SELECT COUNT(*) FROM activity_diaries) AS activity_diaries_count,
                    (SELECT COUNT(*) FROM portfolios) AS portfolios_count,
                    (SELECT COUNT(*) FROM properties) AS properties_count,
                    (SELECT COUNT(*) FROM financials) AS financials_count,
                    (SELECT COUNT(*) FROM tenants) AS tenants_count,
                    (SELECT COUNT(*) FROM leases) AS leases_count,
                    (SELECT COUNT(*) FROM site_visits) AS site_visits_count,
                    (SELECT COUNT(*) FROM checklists) AS checklists_count,
                    (SELECT COUNT(*) FROM appointments) AS appointments_count,
                    (SELECT COUNT(*) FROM approval_forms) AS approval_forms_count,
                    (SELECT COUNT(*) FROM approval_properties) AS approval_properties_count,
                    (SELECT COUNT(*) FROM site_visit_logs) AS site_visit_logs_count,
                    
                    -- Add pending counts
                    (SELECT COUNT(*) FROM trustee_fees WHERE status = 'pending') AS pending_trustee_fees_count,
                    (SELECT COUNT(*) FROM compliance_covenants WHERE status = 'pending') AS pending_compliance_covenants_count,
                    (SELECT COUNT(*) FROM activity_diaries WHERE status = 'pending') AS pending_activity_diaries_count,
                    (SELECT COUNT(*) FROM portfolios WHERE status = 'pending') AS pending_portfolios_count,
                    (SELECT COUNT(*) FROM properties WHERE status = 'pending') AS pending_properties_count,
                    (SELECT COUNT(*) FROM financials WHERE status = 'pending') AS pending_financials_count,
                    (SELECT COUNT(*) FROM tenants WHERE status = 'pending') AS pending_tenants_count,
                    (SELECT COUNT(*) FROM leases WHERE status = 'pending') AS pending_leases_count,
                    (SELECT COUNT(*) FROM site_visits WHERE status = 'pending') AS pending_site_visits_count,
                    (SELECT COUNT(*) FROM checklists WHERE status = 'pending') AS pending_checklists_count,
                    (SELECT COUNT(*) FROM appointments WHERE status = 'pending') AS pending_appointments_count,
                    (SELECT COUNT(*) FROM approval_forms WHERE status = 'pending') AS pending_approval_forms_count,
                    (SELECT COUNT(*) FROM approval_properties WHERE status = 'pending') AS pending_approval_properties_count,
                    (SELECT COUNT(*) FROM site_visit_logs WHERE status = 'pending') AS pending_site_visit_logs_count
            ");
            return (array) $result[0];
        });
        
        return view('approver.index', [
            'issuers' => $issuers,
            'portfolios' => $portfolios,
            'trusteeFeesCount' => $counts['trustee_fees_count'],
            'complianceCovenantCount' => $counts['compliance_covenants_count'],
            'activityDairyCount' => $counts['activity_diaries_count'],
            'portfoliosCount' => $counts['portfolios_count'],
            'propertiesCount' => $counts['properties_count'],
            'financialsCount' => $counts['financials_count'],
            'tenantsCount' => $counts['tenants_count'],
            'leasesCount' => $counts['leases_count'],
            'siteVisitsCount' => $counts['site_visits_count'],
            'checklistsCount' => $counts['checklists_count'],
            'appointmentsCount' => $counts['appointments_count'],
            'approvalFormsCount' => $counts['approval_forms_count'],
            'approvalPropertiesCount' => $counts['approval_properties_count'],
            'siteVisitLogsCount' => $counts['site_visit_logs_count'],
            
            // Add pending counts to view data
            'pendingPropertiesCount' => $counts['pending_properties_count'],
            'pendingFinancialsCount' => $counts['pending_financials_count'],
            'pendingTenantsCount' => $counts['pending_tenants_count'],
            'pendingLeaseCount' => $counts['pending_leases_count'],
            'pendingSiteVisitCount' => $counts['pending_site_visits_count'],
            'pendingChecklistCount' => $counts['pending_checklists_count'],
            'pendingAppointmentsCount' => $counts['pending_appointments_count'],
            'pendingApprovalFormsCount' => $counts['pending_approval_forms_count'],
            'pendingApprovalPropertiesCount' => $counts['pending_approval_properties_count'],
            'pendingSiteVisitLogsCount' => $counts['pending_site_visit_logs_count'],
        ]);
    }

    public function IssuerEdit(Issuer $issuer)
    {
        return view('approver.issuer.edit', compact('issuer'));
    }

    public function IssuerShow(Issuer $issuer)
    {
        // Load related bonds if relationship exists
        if (method_exists($issuer, 'bonds')) {
            $issuer->load('bonds');
        }
        return view('approver.issuer.show', compact('issuer'));
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
    public function DocumentShow (RelatedDocument $document)
    {
        return view('approver.related-document.show', compact('document'));
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
     /**
     * Display a listing of the trustee fees.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function TrusteeFeeIndex(Request $request)
    {
        $query = TrusteeFee::with('facility');
        
        if ($request->has('facility_information_id') && !empty($request->facility_information_id)) {
            $query->where('facility_information_id', $request->facility_information_id);
        }
        
        if ($request->has('invoice_no') && !empty($request->invoice_no)) {
            $query->where('invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
        }
        
        if ($request->has('month') && !empty($request->month)) {
            $query->where('month', $request->month);
        }
        
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            if ($request->payment_status === 'paid') {
                $query->paid(); // Using the scope defined in the model
            } elseif ($request->payment_status === 'unpaid') {
                $query->unpaid(); // Using the scope defined in the model
            }
        }
        
        // Get all facilities for the dropdown
        $facilities = FacilityInformation::orderBy('facility_name')->get();
        
        $trustee_fees = $query->latest()->paginate(10);
        return view('approver.trustee-fee.index', compact('trustee_fees', 'facilities'));
    }

    /**
     * Display the specified trustee fee.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function TrusteeFeeShow(TrusteeFee $trusteeFee)
    {
        return view('approver.trustee-fee.show', compact('trusteeFee'));
    }

    /**
     * Approve the specified trustee fee.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function TrusteeFeeApprove(TrusteeFee $trusteeFee)
    {
        try {
            $trusteeFee->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()->route('trustee-fee-a.index')->with('success', 'Trustee Fee approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving trustee fee: ' . $e->getMessage());
        }
    }

    /**
     * Reject the specified trustee fee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
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
            
            return redirect()->route('trustee-fee-a.index')->with('success', 'Trustee Fee rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting trustee fee: ' . $e->getMessage());
        }
    }

    // Compliance Covenant Module
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
        
        return view('approver.compliance-covenant.index', compact('covenants', 'issuers'));
    }

    public function ComplianceShow(ComplianceCovenant $compliance)
    {
        return view('approver.compliance-covenant.show', compact('compliance'));
    }

    public function ComplianceApprove(ComplianceCovenant $compliance)
    {
        try {
            $compliance->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()->route('compliance-covenant-a.index')->with('success', 'Compliance Covenant approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving compliance covenant: ' . $e->getMessage());
        }
    }

    public function ComplianceReject(Request $request, ComplianceCovenant $compliance)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $compliance->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);
            
            return redirect()->route('compliance-covenant-a.index')->with('success', 'Compliance Covenant rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting compliance covenant: ' . $e->getMessage());
        }
    }

    // Activity Diary Module
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
        
        return view('approver.activity-diary.index', compact('activities', 'issuers'));
    }

    public function ActivityShow(ActivityDiary $activity)
    {
        $activity->load('issuer');
        return view('approver.activity-diary.show', compact('activity'));
    }

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
        
        return view('approver.activity-diary.upcoming', compact('activities'));
    }

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
        
        return view('approver.activity-diary.by-issuer', compact('activities', 'issuer'));
    }

    public function ActivityApprove(ActivityDiary $activity)
    {
        try {
            $activity->update([
                'status' => 'Active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);
            
            return redirect()
                ->route('activity-diary-a.index')
                ->with('success', 'Activity Diary approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error approving activity diary: ' . $e->getMessage());
        }
    }

    public function ActivityReject(Request $request, ActivityDiary $activity)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $activity->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);
            
            return redirect()
                ->route('activity-diary-a.index')
                ->with('success', 'Activity Diary rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error rejecting activity diary: ' . $e->getMessage());
        }
    }

    // Portfolio
    public function PortfolioIndex()
    {
        $portfolios = Portfolio::orderBy('portfolio_name')->get();
        return view('approver.portfolio.index', compact('portfolios'));
    }

    public function PortfolioShow(Portfolio $portfolio)
    {
        // Get paginated properties with a unique page name
        $properties = $portfolio->properties()->paginate(10, ['*'], 'properties_page');
        
        // Get paginated financials with a different page name
        $financials = $portfolio->financials()->paginate(10, ['*'], 'financials_page');
        
        return view('approver.portfolio.show', compact('portfolio', 'properties', 'financials'));
    }

    public function PortfolioApprove(Portfolio $portfolio)
    {
        try {
            $portfolio->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()->route('approver.dashboard', ['section' => 'reits'])->with('success', 'Portfolio approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving activity diary: ' . $e->getMessage());
        }
    }
        
    public function PortfolioReject(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $portfolio->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()->route('approver.dashboard', ['section' => 'reits'])->with('success', 'Portfolio rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting activity diary: ' . $e->getMessage());
        }
    }

    // Property Module
    public function PropertyIndex(Request $request, Portfolio $portfolio)
    {
        // Start with a base query, including relevant relationships
        $query = Property::with([
            'portfolio',
            'tenants',
            'siteVisits',
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

        return view('approver.property.index', compact(
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

    public function PropertyShow(Property $property)
    {
        return view('approver.property.show', compact('property'));
    }

    public function PropertyMain(Request $request)
    {
        // Get the active tab (default to 'pending' if not specified)
        $activeTab = $request->tab ?? 'all';
        
        // Base query with portfolio relationship
        $query = Property::with('portfolio');
        
        // Apply tab filtering
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        
        // Apply additional filters
        $query->when($request->filled('search'), function($query) use ($request) {
            return $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->filled('category'), function($query) use ($request) {
            return $query->where('category', $request->category);
        });
        
        // Get paginated results
        $properties = $query->orderBy('name')->paginate(15)->withQueryString();
        
        // Get counts for each status tab
        $tabCounts = [
            'all' => Property::count(),
            'pending' => Property::where('status', 'pending')->count(),
            'active' => Property::where('status', 'active')->count(),
            'rejected' => Property::where('status', 'rejected')->count(),
        ];
        
        // Return view with data
        return view('approver.property.main', compact('properties', 'activeTab', 'tabCounts'));
    }

    public function PropertyDetails(Property $property) {
        return view('approver.property.details', compact('property'));
    }

    public function PropertyApprove(Property $property) {
        try {
            $property->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('property-a.main', ['tab' => 'pending'])
                ->with('success', 'Property approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving activity diary: ' . $e->getMessage());
        }
    }

    public function PropertyReject(Request $request, Property $property)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $property->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('property-a.main', ['tab' => 'pending'])
                ->with('success', 'Property rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting activity diary: ' . $e->getMessage());
        }
    }

    // Financial Module
    public function FinancialIndex(Portfolio $portfolio, Request $request)
    {
        $query = Financial::with(['bank', 'financialType', 'properties'])->orderBy('bank_id')->get();
        $financials = $query->where('portfolio_id', $portfolio->id);
        return view('approver.financial.index', compact('financials', 'portfolio'));
    }

    public function FinancialShow(Financial $financial) {
        return view('approver.financial.show', compact('financial'));
    }

    public function FinancialMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
        
        // Base query for financials
        $query = Financial::with(['portfolio', 'bank', 'financialType']);
        
        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        
        // Apply search filter if provided
        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('purpose', 'like', "%{$search}%")
                ->orWhere('batch_no', 'like', "%{$search}%")
                ->orWhereHas('portfolio', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('bank', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        // Apply financial type filter if provided
        if ($financialType = $request->query('financial_type')) {
            $query->where('financial_type_id', $financialType);
        }
        
        // Get paginated results
        $financials = $query->latest()->paginate(10)->withQueryString();
        
        // Count records for each tab
        $tabCounts = [
            'all' => Financial::count(),
            'pending' => Financial::where('status', 'pending')->count(),
            'rejected' => Financial::where('status', 'rejected')->count(),
            'active' => Financial::where('status', 'active')->count(),
        ];
        
        // Get all financial types for the filter dropdown
        $financialTypes = FinancialType::orderBy('name')->get();
        
        return view('approver.financial.main', compact(
            'financials', 
            'activeTab', 
            'tabCounts', 
            'financialTypes'
        ));
    }

    public function FinancialDetails(Financial $financial)
    {
        return view('approver.financial.details', compact('financial'));
    }

    public function FinancialApprove(Financial $financial)
    {
        try {
            $financial->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('financial-a.main', ['tab' => 'pending'])
                ->with('success', 'Financial approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving activity diary: ' . $e->getMessage());
        }
    }

    public function FinancialReject(Request $request, Financial $financial)    
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);
        
        try {
            $financial->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('financial-a.main', ['tab' => 'pending'])
                ->with('success', 'Financial rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting activity diary: ' . $e->getMessage());
        }
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
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('approver.tenant.index', compact('tenants', 'siteVisits', 'property'));
    }

    public function TenantShow(Tenant $tenant)
    {
        return view('approver.tenant.show', compact('tenant'));
    }

    public function TenantMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
        
        // Base query with relationships
        $query = Tenant::with(['property']);
        
        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Apply property filter if provided
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->input('property_id'));
        }
        
        // Fetch tenants with pagination
        $tenants = $query->orderBy('name')->paginate(10)->withQueryString();
        
        // Fetch all properties for the filter dropdown (not just those related to displayed tenants)
        $properties = Property::orderBy('name')->get();
        
        // Count records for each tab
        $tabCounts = [
            'all' => Tenant::count(),
            'pending' => Tenant::where('status', 'pending')->count(),
            'active' => Tenant::where('status', 'active')->count(),
            'inactive' => Tenant::where('status', 'inactive')->count(),
            'rejected' => Tenant::where('status', 'rejected')->count(),
        ];
        
        return view('approver.tenant.main', compact('tenants', 'activeTab', 'tabCounts', 'properties'));
    }

    public function TenantDetails(Tenant $tenant)
    {
        return view('approver.tenant.details', compact('tenant'));
    }

    public function TenantApprove(Tenant $tenant)
    {
        try {
            $tenant->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('tenant-a.main', ['tab' => 'pending'])
                ->with('success', 'Tenant approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving tenant: ' . $e->getMessage());
        }
    }

    public function TenantReject(Request $request, Tenant $tenant)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);


        try {
            $tenant->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('tenant-a.main', ['tab' => 'pending'])
                ->with('success', 'Tenant rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error rejecting tenant: ' . $e->getMessage());
        }
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
        
        $totalLeaseCount = Lease::whereIn('tenant_id', $tenantIds)
            ->count();

        return view('approver.lease.index', compact(
            'property',
            'leases',
            'activeLeaseCount',
            'totalLeaseCount',
        ));
    }

    public function LeaseShow(Lease $lease)
    {
        return view('approver.lease.show', compact('lease'));
    }

    public function LeaseMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
        
        // Base query with necessary relationships
        $query = Lease::with(['tenant']);
        
        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('lease_name', 'like', "%{$search}%")
                  ->orWhereHas('tenant', function($tq) use ($search) {
                      $tq->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Apply tenancy type filter if provided
        if ($request->filled('tenancy_type')) {
            $query->where('tenancy_type', $request->input('tenancy_type'));
        }
        
        // Fetch leases with pagination
        $leases = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Count records for each tab
        $tabCounts = [
            'all' => Lease::count(),
            'active' => Lease::where('status', 'active')->count(),
            'pending' => Lease::where('status', 'pending')->count(),
            'rejected' => Lease::where('status', 'rejected')->count(),
            'inactive' => Lease::where('status', 'inactive')->count(),
        ];
        
        return view('approver.lease.main', compact('leases', 'activeTab', 'tabCounts'));
    }

    public function LeaseDetails(Lease $lease)
    {
        return view('approver.lease.details', compact('lease'));
    }
    public function LeaseApprove(Lease $lease)
    {
        try {
            $lease->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('lease-a.main', ['tab' => 'pending'])
                ->with('success', 'Lease approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving lease: ' . $e->getMessage());
        }
    }

    public function LeaseReject(Request $request, Lease $lease)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $lease->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('lease-a.main', ['tab' => 'pending'])
                ->with('success', 'Lease rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting lease: ' . $e->getMessage());
        }
    }

    // Site Visit Module
    public function SiteVisitIndex(Property $property)
    {
        $siteVisits = $property->siteVisits()
                        ->orderBy('created_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return view('approver.site-visit.index', compact('siteVisits', 'propertyInfo'));
    }

    public function SiteVisitShow(SiteVisit $siteVisit)
    {
        return view('approver.site-visit.show', compact('siteVisit'));
    }

    public function SiteVisitMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
        
        // Base query with relationships
        $query = SiteVisit::with(['property']);
        
        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            if ($activeTab === 'active') {
                $query->where('status', 'active');
            } elseif ($activeTab === 'pending') {
                $query->where('status', 'pending');
            } elseif ($activeTab === 'rejected') {
                $query->where('status', 'rejected');
            } elseif ($activeTab === 'inactive') {
                $query->where('status', 'inactive');
            } else {
                $query->where('status', $activeTab);
            }
        }
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('property', function($propertyQuery) use ($search) {
                    $propertyQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('address', 'like', "%{$search}%");
                })
                ->orWhere('manager', 'like', "%{$search}%")
                ->orWhere('trustee', 'like', "%{$search}%");
            });
        }
        
        // Apply property filter if provided
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->input('property_id'));
        }
        
        // Apply date range filter if provided
        if ($request->filled('date_range')) {
            $dateRange = $request->input('date_range');
            $today = now()->startOfDay();
            
            switch ($dateRange) {
                case 'today':
                    $query->whereDate('date_visit', $today);
                    break;
                case 'upcoming':
                    $query->whereDate('date_visit', '>', $today);
                    break;
                case 'past':
                    $query->whereDate('date_visit', '<', $today);
                    break;
                case 'this_week':
                    $query->whereBetween('date_visit', [$today, $today->copy()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('date_visit', [$today, $today->copy()->endOfMonth()]);
                    break;
            }
        }
        
        // Fetch site visits with pagination
        $siteVisits = $query->orderBy('date_visit', 'desc')->paginate(10)->withQueryString();
        
        // Fetch all properties for the filter dropdown
        $properties = Property::orderBy('name')->get();
        
        // Count records for each tab
        $tabCounts = [
            'all' => SiteVisit::count(),
            'active' => SiteVisit::where('status', 'active')->count(),
            'pending' => SiteVisit::where('status', 'pending')->count(),
            'rejected' => SiteVisit::where('status', 'rejected')->count(),
            'inactive' => SiteVisit::where('status', 'inactive')->count(),
        ];
        
        return view('approver.site-visit.main', compact('siteVisits', 'properties', 'activeTab', 'tabCounts'));
    }

    public function SiteVisitDetails(SiteVisit $siteVisit)
    {
        return view('approver.site-visit.details', compact('siteVisit'));
    }

    public function SiteVisitApprove(SiteVisit $siteVisit)
    {
        try {
            $siteVisit->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('site-visit-a.main', ['tab' => 'pending'])
                ->with('success', 'Site Visit approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving site visit: ' . $e->getMessage());
        }
    }

    public function SiteVisitReject(Request $request, SiteVisit $siteVisit)
    {
        // Validate the rejection reason
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $siteVisit->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('site-visit-a.main', ['tab' => 'pending'])
                ->with('success', 'Site Visit rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting site visit: ' . $e->getMessage());
        }
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

        // Get related data for summary statistics if we're viewing a specific property
        if ($property->exists) {
            // You might want to add additional statistics here if needed
            $pendingCount = $checklists->where('status', 'pending')->count();
            $completedCount = $checklists->where('status', 'completed')->count();
            
            return view('approver.checklist.index', compact(
                'property', 
                'checklists',
                'pendingCount',
                'completedCount'
            ));
        }

        return view('approver.checklist.index', compact('checklists'));
    }

    public function ChecklistShow(Checklist $checklist)
    {
        return view('approver.checklist.show', compact('checklist'));
    }

    public function checklistMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
        
        // Base query with necessary relationships
        $query = Checklist::with(['siteVisit', 'siteVisit.property']);
        
        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('prepared_by', 'like', "%{$search}%")
                ->orWhere('verified_by', 'like', "%{$search}%")
                ->orWhereHas('siteVisit.property', function($propertyQuery) use ($search) {
                    $propertyQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        // Apply property filter if provided
        if ($request->filled('property_id')) {
            $query->whereHas('siteVisit', function($q) use ($request) {
                $q->where('property_id', $request->input('property_id'));
            });
        }
        
        // Apply site visit filter if provided
        if ($request->filled('site_visit_id')) {
            $query->where('site_visit_id', $request->input('site_visit_id'));
        }
        
        // Fetch checklists with pagination
        $checklists = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Fetch all site visits for the dropdown
        $siteVisits = SiteVisit::with('property')
                    ->orderBy('date_visit', 'desc')
                    ->get();
        
        // Fetch available properties for filter dropdown
        $properties = Property::orderBy('name')->get();
        
        // Count records for each tab
        $tabCounts = [
            'all' => Checklist::count(),
            'active' => Checklist::where('status', 'active')->count(),
            'pending' => Checklist::where('status', 'pending')->count(),
            'rejected' => Checklist::where('status', 'rejected')->count(),
            'inactive' => Checklist::where('status', 'inactive')->count(),
        ];
        
        return view('approver.checklist.main', compact(
            'checklists', 
            'siteVisits', 
            'properties', 
            'activeTab', 
            'tabCounts'
        ));
    }

    public function ChecklistDetails(Checklist $checklist)
    {
        
        // Load the checklist with its relationships
        $checklist->load([
            'siteVisit',
            'siteVisit.property',
            'siteVisit.property.portfolio',
            'siteVisit.property.tenants',
            'siteVisit.property.tenants.leases',
            'siteVisit.property.financials',
            'siteVisit.property.siteVisits',
        ]);
        return view('approver.checklist.details', compact('checklist'));
    }

    public function ChecklistApprove(Checklist $checklist)
    {
        try {
            $checklist->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklist)
                ->with('success', 'Checklist approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistReject(Request $request, Checklist $checklist)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklist->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklist)
                ->with('success', 'Checklist rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting checklist: ' . $e->getMessage());
        }
    }

    // Checklist Legal Documentation Module
    public function ChecklistLegalDocumentationApprove(ChecklistLegalDocumentation $checklistLegalDocumentation)
    {
        try {
            $checklistLegalDocumentation->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistLegalDocumentation->checklist)
                ->with('success', 'Checklist Legal Documentation approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving legal documentation: ' . $e->getMessage());
        }
    }

    public function ChecklistLegalDocumentationReject(Request $request, ChecklistLegalDocumentation $checklistLegalDocumentation)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklistLegalDocumentation->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistLegalDocumentation->checklist)
                ->with('success', 'Checklist Legal Documentation rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting legal documentation: ' . $e->getMessage());
        }
    }

    // Checklist Tenant Module
    public function ChecklistTenantApprove(ChecklistTenant $checklistTenant)
    {
        try {
            $checklistTenant->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistTenant->checklist)
                ->with('success', 'Checklist Tenant approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving tenant checklist: ' . $e->getMessage());
        }
    }

    public function ChecklistTenantReject(Request $request, ChecklistTenant $checklistTenant)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklistTenant->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistTenant->checklist)
                ->with('success', 'ChecklistTenant rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting tenant checklist: ' . $e->getMessage());
        }
    }

    // Checklist External Area Condition Module
    public function ChecklistExternalAreaConditionApprove(ChecklistExternalAreaCondition $checklistExternalAreaCondition)
    {
        try {
            $checklistExternalAreaCondition->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistExternalAreaCondition->checklist)
                ->with('success', 'Checklist External Area Condition approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving external area condition: ' . $e->getMessage());
        }
    }

    public function ChecklistExternalAreaConditionReject(Request $request, ChecklistExternalAreaCondition $checklistExternalAreaCondition)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklistExternalAreaCondition->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistExternalAreaCondition->checklist)
                ->with('success', 'Checklist External Area Condition rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting external area condition: ' . $e->getMessage());
        }
    }

    // Checklist Internal Area Condition Module
    public function ChecklistInternalAreaConditionApprove(ChecklistInternalAreaCondition $checklistInternalAreaCondition)
    {
        try {
            $checklistInternalAreaCondition->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistInternalAreaCondition->checklist)
                ->with('success', 'Checklist Internal Area Condition approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving internal area condition: ' . $e->getMessage());
        }
    }

    public function ChecklistInternalAreaConditionReject(Request $request, ChecklistInternalAreaCondition $checklistInternalAreaCondition)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklistInternalAreaCondition->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistInternalAreaCondition->checklist)
                ->with('success', 'Checklist Internal Area Condition rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting internal area condition: ' . $e->getMessage());
        }
    }

    // Checklist Property Development Module
    public function ChecklistPropertyDevelopmentApprove(ChecklistPropertyDevelopment $checklistPropertyDevelopment)
    {
        try {
            $checklistPropertyDevelopment->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return back()
                ->route('checklist-a.show', $checklistPropertyDevelopment->checklist)
                ->with('success', 'Property Development approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving property development: ' . $e->getMessage());
        }
    }

    public function ChecklistPropertyDevelopmentReject(Request $request, ChecklistPropertyDevelopment $checklistPropertyDevelopment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklist->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistPropertyDevelopment->checklist)
                ->with('success', 'Property Development rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting property development: ' . $e->getMessage());
        }
    }

    // Checklist Disposal/Installation/Replacement Module
    public function ChecklistDisposalInstallationApprove(ChecklistDisposalInstallation $checklistDisposalInstallation)
    {
        try {
            $checklistDisposalInstallation->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistDisposalInstallation->checklist)
                ->with('success', 'Disposal/Installation/Replacement approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving disposal/installation/replacement: ' . $e->getMessage());
        }
    }

    public function ChecklistDisposalInstallationReject(Request $request, ChecklistDisposalInstallation $checklistDisposalInstallation)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $checklistDisposalInstallation->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('checklist-a.show', $checklistDisposalInstallation->checklist)
                ->with('success', 'Disposal/Installation/Replacement rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting disposal/installation/replacement: ' . $e->getMessage());
        }
    }

    // Appointment Module
    public function AppointmentIndex()
    {
        $query = Appointment::with(['siteVisit', 'siteVisit.property', 'siteVisit.property.portfolio']);

        // Apply filters if provided
        if (request()->has('status') && !empty(request()->status)) {
            $query->where('status', request()->status);
        }

        // Get paginated results
        $appointments = $query->latest()->paginate(10)->withQueryString();

        // Get all properties for the dropdown
        $propertyIds = $appointments->pluck('site_visit.property_id')->unique();
        $properties = Property::whereIn('id', $propertyIds)->get();

        return view('approver.appointment.index', compact('appointments', 'properties'));
    }

    public function AppointmentShow(Appointment $appointment)
    {
        return view('approver.appointment.show', compact('appointment'));
    }

    public function AppointmentMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
    
        // Initialize query builder with relationships
        $query = Appointment::with(['portfolio']);
    
        // Apply status filter based on active tab
        if ($activeTab != 'all') {
            $query->where('status', $activeTab);
        }
    
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('party_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply portfolio filter if provided
        if ($request->has('portfolio_id') && !empty($request->portfolio_id)) {
            $query->where('portfolio_id', $request->portfolio_id);
        }
    
        // Fetch appointments with pagination and maintain query string
        $appointments = $query->latest()->paginate(10)->withQueryString();
        
        // Get list of portfolios from appointment data
        $portfolios = Portfolio::whereIn('id', Appointment::distinct()->pluck('portfolio_id'))
                        ->orderBy('name')
                        ->get();
    
        // Count records for each tab
        $tabCounts = [
            'all' => Appointment::count(),
            'active' => Appointment::status('active')->count(),
            'pending' => Appointment::status('pending')->count(),
            'rejected' => Appointment::status('rejected')->count(),
            'inactive' => Appointment::status('inactive')->count(),
        ];
    
        return view('approver.appointment.main', compact('appointments', 'activeTab', 'tabCounts', 'portfolios'));
    }
    
    public function AppointmentDetails(Appointment $appointment)
    {
        return view('approver.appointment.details', compact('appointment'));
    }

    public function AppointmentApprove(Appointment $appointment)
    {
        try {
            $appointment->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('appointment-a.main', ['status' => 'pending'])
                ->with('success', 'Appointment approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving appointment: ' . $e->getMessage());
        }
    }

    public function AppointmentReject(Request $request, Appointment $appointment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $appointment->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('appointment-a.main', ['status' => 'pending'])
                ->with('success', 'Appointment rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting appointment: ' . $e->getMessage());
        }
    }

    // Approval Form Module
    public function ApprovalFormIndex()
    {
        $query = ApprovalForm::with(['portfolio', 'property']);

        // Apply filters if provided
        if (request()->has('status') && !empty(request()->status)) {
            $query->where('status', request()->status);
        }

        // Get paginated results
        $approvalForms = $query->latest()->paginate(10)->withQueryString();

        // portfolio
        $portfolioIds = $approvalForms->pluck('portfolio_id')->unique();
        $portfolios = Portfolio::whereIn('id', $portfolioIds)->get();

        // category
        $categories = ApprovalForm::select('category')->distinct()->pluck('category');

        return view('approver.approval-form.index', compact('approvalForms', 'portfolios', 'categories'));
    }

    public function ApprovalFormShow(ApprovalForm $approvalForm)
    {
        return view('approver.approval-form.show', compact('approvalForm'));
    }

    public function ApprovalFormMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
    
        // Base query
        $query = ApprovalForm::with(['portfolio', 'property']);
    
        // Apply status filter based on tab
        if ($activeTab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($activeTab === 'active') {
            $query->where('status', 'active');
        } elseif ($activeTab === 'rejected') {
            $query->where('status', 'rejected');
        } elseif ($activeTab === 'inactive') {
            $query->where('status', 'inactive');
        }
        // 'all' tab shows everything, so no status filter needed
    
        // Apply date filters if provided
        if ($request->filled('received_date')) {
            $query->whereDate('received_date', $request->received_date);
        }
        
        if ($request->filled('send_date')) {
            $query->whereDate('send_date', $request->send_date);
        }
        
        // Apply category filter if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        // Fetch approval forms with pagination
        $approvalForms = $query->latest()->paginate(10)->withQueryString();
    
        // Count records for each tab - these should be filtered by the same criteria as the main query
        // except for the status which defines each tab
        $baseCountQuery = ApprovalForm::query();
        
        // Apply the same filters to the count queries (except status)
        if ($request->filled('received_date')) {
            $baseCountQuery->whereDate('received_date', $request->received_date);
        }
        
        if ($request->filled('send_date')) {
            $baseCountQuery->whereDate('send_date', $request->send_date);
        }
        
        if ($request->filled('category')) {
            $baseCountQuery->where('category', $request->category);
        }
        
        $tabCounts = [
            'all' => (clone $baseCountQuery)->count(),
            'pending' => (clone $baseCountQuery)->where('status', 'pending')->count(),
            'active' => (clone $baseCountQuery)->where('status', 'active')->count(),
            'rejected' => (clone $baseCountQuery)->where('status', 'rejected')->count(),
            'inactive' => (clone $baseCountQuery)->where('status', 'inactive')->count(),
        ];
    
        // Get all categories for the dropdown - no need to tie this to the current results
        $categories = ApprovalForm::select('category')->distinct()->pluck('category');
    
        return view('approver.approval-form.main', compact(
            'approvalForms', 
            'activeTab', 
            'tabCounts', 
            'categories'
        ));
    }

    public function ApprovalFormDetails(ApprovalForm $approvalForm)
    {
        return view('approver.approval-form.details', compact('approvalForm'));
    }

    public function ApprovalFormApprove(ApprovalForm $approvalForm)
    {
        try {
            $approvalForm->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('approval-form-a.main', ['status' => 'pending'])
                ->with('success', 'Approval Form approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving approval form: ' . $e->getMessage());
        }
    }

    public function ApprovalFormReject(Request $request, ApprovalForm $approvalForm)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $approvalForm->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('approval-form-a.main', ['status' => 'pending'])
                ->with('success', 'Approval Form rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting approval form: ' . $e->getMessage());
        }
    }
    
    // Approval Property Module
    public function ApprovalPropertyIndex()
    {
        $query = ApprovalProperty::with(['portfolio', 'property']);

        // Apply filters if provided
        if (request()->has('status') && !empty(request()->status)) {
            $query->where('status', request()->status);
        }

        // Get paginated results
        $approvalProperties = $query->latest()->paginate(10)->withQueryString();

        // portfolio
        $portfolioIds = $approvalProperties->pluck('portfolio_id')->unique();
        $portfolios = Portfolio::whereIn('id', $portfolioIds)->get();

        // category
        $categories = ApprovalProperty::select('category')->distinct()->pluck('category');

        return view('approver.approval-property.index', compact('approvalProperties', 'portfolios', 'categories'));
    }

    public function ApprovalPropertyShow(ApprovalProperty $approvalProperty)
    {
        return view('approver.approval-property.show', compact('approvalProperty'));
    }

    public function ApprovalPropertyMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
    
        // Base query with relationships
        $query = ApprovalProperty::with(['property.portfolio']);
    
        // Apply filter by tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
    
        // Apply search filter if present
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('property', function($propertyQuery) use ($searchTerm) {
                    $propertyQuery->where('name', 'like', "%{$searchTerm}%");
                })
                ->orWhere('estimated_amount', 'like', "%{$searchTerm}%")
                ->orWhere('prepared_by', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
    
        // Apply portfolio filter if present
        if ($request->has('portfolio_id') && !empty($request->portfolio_id)) {
            $query->whereHas('property', function($propertyQuery) use ($request) {
                $propertyQuery->where('portfolio_id', $request->portfolio_id);
            });
        }
    
        // Fetch approval properties with pagination
        $approvalProperties = $query->latest()->paginate(10)->withQueryString();
    
        // Count records for each tab
        $tabCounts = [
            'all' => ApprovalProperty::count(),
            'active' => ApprovalProperty::where('status', 'active')->count(),
            'pending' => ApprovalProperty::where('status', 'pending')->count(),
            'rejected' => ApprovalProperty::where('status', 'rejected')->count(),
            'inactive' => ApprovalProperty::where('status', 'inactive')->count(),
        ];
    
        // Get all properties for the dropdown - only get what's needed for the current page
        $propertyIds = $approvalProperties->pluck('property_id')->unique();
        $properties = Property::whereIn('id', $propertyIds)->get();
    
        // Get all portfolios for the dropdown - only get what's needed for the current page
        $portfolioIds = $properties->pluck('portfolio_id')->unique()->filter();
        $portfolios = Portfolio::whereIn('id', $portfolioIds)->get();
    
        // Get all statuses for the dropdown
        $statuses = ApprovalProperty::select('status')->distinct()->pluck('status');
    
        return view('approver.approval-property.main', compact(
            'approvalProperties', 
            'activeTab', 
            'tabCounts', 
            'properties', 
            'portfolios', 
            'statuses'
        ));
    }

    public function ApprovalPropertyDetails(ApprovalProperty $approvalProperty)
    {
        return view('approver.approval-property.details', compact('approvalProperty'));
    }

    public function ApprovalPropertyApprove(ApprovalProperty $approvalProperty)
    {
        try {
            $approvalProperty->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('approval-property-a.index', ['status' => 'pending'])
                ->with('success', 'Approval Property approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving approval property: ' . $e->getMessage());
        }
    }

    public function ApprovalPropertyReject(Request $request, ApprovalProperty $approvalProperty)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $approvalProperty->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('approval-property-a.index', ['status' => 'pending'])
                ->with('success', 'Approval Property rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting approval property: ' . $e->getMessage());
        }
    }

    // Site Visit Log Module
    public function SiteVisitLogIndex(Request $request)
    {
        $siteVisitLogs = SiteVisitLog::latest()->paginate(10)->withQueryString();
        return view('approver.site-visit-log.index', compact('siteVisitLogs'));
    }

    public function SiteVisitLogShow(SiteVisitLog $siteVisitLog)
    {
        return view('approver.site-visit-log.show', compact('siteVisitLog'));
    }

    public function SiteVisitLogMain(Request $request)
    {
        // Get current tab or default to 'all'
        $activeTab = $request->query('tab', 'all');
    
        // Initialize the query with relationships
        $query = SiteVisitLog::with(['property', 'property.portfolio']);
        
        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purpose', 'like', "%{$search}%")
                  ->orWhereHas('property', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                  });
            });
        }
        
        // Apply category filter if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Apply portfolio filter if provided
        if ($request->has('portfolio_id') && !empty($request->portfolio_id)) {
            $query->whereHas('property', function($q) use ($request) {
                $q->where('portfolio_id', $request->portfolio_id);
            });
        }
        
        // Apply property filter if provided
        if ($request->has('property_id') && !empty($request->property_id)) {
            $query->where('property_id', $request->property_id);
        }
    
        // Fetch site visit logs
        $siteVisitLogs = $query->latest()->paginate(10)->withQueryString();
    
        // Get all property IDs referenced in the current filtered records
        $filteredPropertyIds = $siteVisitLogs->pluck('property_id')->unique();
        
        // Include the currently selected property even if it's not in the result set
        if ($request->has('property_id') && !empty($request->property_id)) {
            $filteredPropertyIds->push($request->property_id);
        }
        
        // Get properties for the dropdown based on current query results
        $properties = Property::whereIn('id', $filteredPropertyIds)->orderBy('name')->get();
        
        // Get all portfolio IDs from the filtered properties
        $filteredPortfolioIds = $properties->pluck('portfolio_id')->unique();
        
        // Include the currently selected portfolio even if it's not in the result set
        if ($request->has('portfolio_id') && !empty($request->portfolio_id)) {
            $filteredPortfolioIds->push($request->portfolio_id);
        }
        
        // Get portfolios for the dropdown based on current query results
        $portfolios = Portfolio::whereIn('id', $filteredPortfolioIds)->orderBy('name')->get();
    
        // Get all category values from the current query results
        $filteredCategories = $siteVisitLogs->pluck('category')->unique()->filter();
        
        // Include the currently selected category even if it's not in the result set
        if ($request->has('category') && !empty($request->category)) {
            $filteredCategories->push($request->category);
        }
        
        // Get categories for the dropdown
        $categories = $filteredCategories;
    
        // Count records for each tab
        $tabCounts = [
            'all' => SiteVisitLog::count(),
            'active' => SiteVisitLog::where('status', 'active')->count(),
            'pending' => SiteVisitLog::where('status', 'pending')->count(),
            'rejected' => SiteVisitLog::where('status', 'rejected')->count(),
            'inactive' => SiteVisitLog::where('status', 'inactive')->count(),
        ];
    
        return view('approver.site-visit-log.main', compact(
            'siteVisitLogs', 
            'activeTab', 
            'portfolios', 
            'properties', 
            'categories', 
            'tabCounts'
        ));
    }

    public function SiteVisitLogDetails(SiteVisitLog $siteVisitLog)
    {
        return view('approver.site-visit-log.details', compact('siteVisitLog'));
    }

    public function SiteVisitLogApprove(SiteVisitLog $siteVisitLog)
    {
        try {
            $siteVisitLog->update([
                'status' => 'active',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('site-visit-log-a.main', ['status' => 'pending'])
                ->with('success', 'Site Visit Log approved successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error approving site visit log: ' . $e->getMessage());
        }
    }

    public function SiteVisitLogReject(Request $request, SiteVisitLog $siteVisitLog)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        try {
            $siteVisitLog->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'remarks' => $request->input('rejection_reason'),
            ]);

            return redirect()
                ->route('site-visit-log-a.main', ['status' => 'pending'])
                ->with('success', 'Site Visit Log rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting site visit log: ' . $e->getMessage());
        }
    }
}
