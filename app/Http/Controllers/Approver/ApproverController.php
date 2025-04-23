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
use App\Models\SiteVisit;

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
                    (SELECT COUNT(*) FROM site_visits) AS siteVisits_count,
                    (SELECT COUNT(*) FROM checklists) AS checklists_count,
                    (SELECT COUNT(*) FROM appointments) AS appointments_count,
                    (SELECT COUNT(*) FROM approval_forms) AS approvalForms_count,
                    (SELECT COUNT(*) FROM approval_properties) AS approvalProperties_count,
                    (SELECT COUNT(*) FROM site_visit_logs) AS siteVisitLogs_count,
                    
                    -- Add pending counts
                    (SELECT COUNT(*) FROM trustee_fees WHERE status = 'pending') AS pending_trusteeFees_count,
                    (SELECT COUNT(*) FROM compliance_covenants WHERE status = 'pending') AS pending_complianceCovenants_count,
                    (SELECT COUNT(*) FROM activity_diaries WHERE status = 'pending') AS pending_activityDiaries_count,
                    (SELECT COUNT(*) FROM portfolios WHERE status = 'pending') AS pending_portfolios_count,
                    (SELECT COUNT(*) FROM properties WHERE status = 'pending') AS pending_properties_count,
                    (SELECT COUNT(*) FROM financials WHERE status = 'pending') AS pending_financials_count,
                    (SELECT COUNT(*) FROM tenants WHERE status = 'pending') AS pending_tenants_count,
                    (SELECT COUNT(*) FROM leases WHERE status = 'pending') AS pending_leases_count,
                    (SELECT COUNT(*) FROM site_visits WHERE status = 'pending') AS pending_siteVisits_count,
                    (SELECT COUNT(*) FROM checklists WHERE status = 'pending') AS pending_checklists_count,
                    (SELECT COUNT(*) FROM appointments WHERE status = 'pending') AS pending_appointments_count,
                    (SELECT COUNT(*) FROM approval_forms WHERE status = 'pending') AS pending_approvalForms_count,
                    (SELECT COUNT(*) FROM approval_properties WHERE status = 'pending') AS pending_approvalProperties_count,
                    (SELECT COUNT(*) FROM site_visit_logs WHERE status = 'pending') AS pending_siteVisitLogs_count
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
            'siteVisitsCount' => $counts['siteVisits_count'],
            'checklistsCount' => $counts['checklists_count'],
            'appointmentsCount' => $counts['appointments_count'],
            'approvalFormsCount' => $counts['approvalForms_count'],
            'approvalPropertiesCount' => $counts['approvalProperties_count'],
            'siteVisitLogsCount' => $counts['siteVisitLogs_count'],
            
            // Add pending counts to view data
            'pendingPropertiesCount' => $counts['pending_properties_count'],
            'pendingFinancialsCount' => $counts['pending_financials_count'],
            'pendingTenantsCount' => $counts['pending_tenants_count'],
            'pendingLeaseCount' => $counts['pending_leases_count'],
            'pendingSiteVisitCount' => $counts['pending_siteVisits_count'],
            'pendingChecklistCount' => $counts['pending_checklists_count'],
            'pendingAppointmentsCount' => $counts['pending_appointments_count'],
            'pendingApprovalFormsCount' => $counts['pending_approvalForms_count'],
            'pendingApprovalPropertiesCount' => $counts['pending_approvalProperties_count'],
            'pendingSiteVisitLogsCount' => $counts['pending_siteVisitLogs_count'],
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
            
            return redirect()->route('activity-diary-a.index')->with('success', 'Activity Diary approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving activity diary: ' . $e->getMessage());
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
            
            return redirect()->route('activity-diary-a.index')->with('success', 'Activity Diary rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting activity diary: ' . $e->getMessage());
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
        return view('approver.portfolio.show', compact('portfolio'));
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

    // Property
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

    public function PropertyReject(Request $request, Property $property) {
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

    public function PropertyIndex(Request $request, Portfolio $portfolio)
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

    // Financial Module
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

    public function FinancialReject(Financial $financial)    
    {
        try {
            $financial->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
            ]);

            return redirect()
                ->route('financial-a.main', ['tab' => 'pending'])
                ->with('success', 'Financial rejected successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error rejecting activity diary: ' . $e->getMessage());
        }
    }

    // Tenant
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
        
        // search & filter
        $query = Tenant::with(['leases', 'property', 'property.portfolio']);

        // Apply status filter based on tab
        if ($activeTab !== 'all') {
            $query->where('status', $activeTab);
        }

        // fetch tenants
        $tenants = $query->latest()->paginate(10)->withQueryString();

        // fetch all property using list tenant
        $properties = $query->distinct('property_id')->pluck('property_id');
        $properties = Property::whereIn('id', $properties)->get();

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

    public function TenantReject(Tenant $tenant)
    {
        try {
            $tenant->update([
                'status' => 'rejected',
                'verified_by' => Auth::user()->name,
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

    // Lease
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
        
        $totalActiveRental = Lease::whereIn('tenant_id', $tenantIds)
            ->where('status', 'active');

        return view('approver.lease.index', compact(
            'property',
            'leases',
            'activeLeaseCount',
            'totalLeaseCount',
            'totalActiveRental'
        ));
    }

    public function LeaseShow(Lease $lease)
    {
        return view('approver.lease.show', compact('lease'));
    }

    // Site Visit
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

    // Checklist
    public function ChecklistIndex(Request $request, Property $property)
    {
        // Start with a base query that includes the relationship
        $query = Checklist::with('siteVisit');
                
        // Filter by property if provided
        if ($property->exists) {
            $query->where('site_visit_id', function ($subquery) use ($property) {
                $subquery->select('id')
                    ->from('site_visits')
                    ->where('property_id', $property->id);
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
}
