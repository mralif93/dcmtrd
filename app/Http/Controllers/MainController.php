<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Issuer;
use App\Models\Announcement;
use App\Models\Bond;
use App\Models\BondInfo;
use App\Models\CallSchedule;
use App\Models\LockoutPeriod;
use App\Models\FacilityInformation;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $issuers = Issuer::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('issuer_name', 'like', "%{$search}%")
                      ->orWhere('issuer_short_name', 'like', "%{$search}%")
                      ->orWhere('registration_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('issuer_name')
            ->paginate(10)
            ->appends(['search' => $search]); // Preserve search in pagination links
    
        return view('main.index', [
            'issuers' => $issuers,
            'searchTerm' => $search
        ]);
    }

    public function info(Issuer $issuer)
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
    
        // dd($bonds->toArray());
        return view('main.info', [
            'issuer' => $issuer,
            'bonds' => $bonds->isEmpty() ? null : $bonds,
            'announcements' => $announcements->isEmpty() ? null : $announcements,
            'documents' => $documents->isEmpty() ? null : $documents,
            'facilities' => $facilities->isEmpty() ? null : $facilities,
        ]);
    }

    public function bondInfo(Bond $bond)
    {
        $bond->load([
            'issuer',
            'charts',
        ]);

        // Pagination configuration
        $perPage = 10; // Items per page
        $emptyPaginator = new LengthAwarePaginator([], 0, $perPage);

        // Documents Pagination
        $documents = $bond->issuer
            ? $bond->issuer->documents()->paginate($perPage, ['*'], 'documentsPage')
            : $emptyPaginator;

        // Rating Movements Pagination
        $ratingMovements = $bond
            ? $bond->ratingMovements()->paginate($perPage, ['*'], 'ratingMovementsPage')
            : $emptyPaginator;

        // Payment Schedules Pagination
        $paymentSchedules = $bond
            ? $bond->paymentSchedules()->paginate($perPage, ['*'], 'paymentSchedulesPage')
            : $emptyPaginator;

        // Call Schedules Pagination
        $callSchedules = $bond && $bond->redemption
            ? CallSchedule::whereIn('redemption_id', $bond->redemption->pluck('id'))
                ->paginate($perPage, ['*'], 'callSchedulesPage')
            : $emptyPaginator;

        // Lockout Periods Pagination
        $lockoutPeriods = $bond && $bond->redemption
            ? LockoutPeriod::whereIn('redemption_id', $bond->redemption->pluck('id'))
                ->paginate($perPage, ['*'], 'lockoutPeriodsPage')
            : $emptyPaginator;

        // Trading Activities Pagination
        $tradingActivities = $bond->tradingActivities()
                ->orderBy('trade_date', 'desc')
                ->paginate($perPage, ['*'], 'tradingActivitiesPage')
            ?? $emptyPaginator;

        // dd($tradingActivities->toArray());
        return view('main.bond', [
            'bond' => $bond,
            'documents' => $documents,
            'ratingMovements' => $ratingMovements,
            'paymentSchedules' => $paymentSchedules,
            'redemptions' => $bond->redemption ?? collect(),
            'tradingActivities' => $tradingActivities,
            'callSchedules' => $callSchedules,
            'lockoutPeriods' => $lockoutPeriods,
            'charts' => $bond->charts ?? collect()
        ]);
    }
    
    public function announcement(Announcement $announcement)
    {
        // dd($announcement->toArray());
        return view('main.announcement', compact('announcement'));
    }

    public function facility(FacilityInformation $facilityInformation)
    {
        // Items per page
        $perPage = 10;
    
        // Fetch bonds with pagination
        $bonds = $facilityInformation->issuer->bonds()
            ? $facilityInformation->issuer->bonds()->paginate($perPage, ['*'], 'bondsPage')
            : collect(); // Use an empty collection instead of $emptyPaginator
    
        // Documents Pagination
        $documents = $facilityInformation->documents()
            ? $facilityInformation->documents()->paginate($perPage, ['*'], 'documentsPage')
            : collect(); // Use an empty collection instead of $emptyPaginator
    
        // Load all rating movements across all bonds
        $allRatingMovements = $facilityInformation->issuer->bonds->flatMap(function ($bond) {
            return $bond->ratingMovements; // Collect rating movements from each bond
        });

        // Paginate the rating movements
        $currentPage = request()->get('ratingMovementsPage', 1); // Get current page from request
        $currentPageItems = $allRatingMovements->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Slice the collection
        $ratingMovements = new LengthAwarePaginator($currentPageItems, $allRatingMovements->count(), $perPage, $currentPage, [
            'path' => request()->url(), // Set the path for pagination links
            'query' => request()->query(), // Preserve query parameters
        ]);

        // dd($bonds->toArray());
    
        return view('main.facility', [
            'issuer' => $facilityInformation->issuer,
            'facility' => $facilityInformation,
            'activeBonds' => $bonds,
            'documents' => $documents,
            'ratingMovements' => $ratingMovements,
        ]);
    }

    // Issuer Section
    public function IssuerCreate()
    {
        return view('main.issuers.create');
    }

    public function IssuerStore(Request $request)
    {
        $validated = $request->validate([
            'issuer_short_name' => 'required|string|max:50|unique:issuers',
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required|unique:issuers',
            'debenture' => 'nullable|string|max:100',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'reminder_1' => 'nullable|date',
            'reminder_2' => 'nullable|date',
            'reminder_3' => 'nullable|date',
            'trustee_role_1' => 'nullable|string|max:100',
            'trustee_role_2' => 'nullable|string|max:100',
            'trust_deed_date' => 'required|date',
        ]);

        $issuer = Issuer::create($validated);
        return redirect()->route('issuers-search.index', $issuer)->with('success', 'Issuer created successfully.');
    }

    public function IssuerEdit(Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        return view('main.issuers.edit', compact('issuer'));
    }

    public function IssuerUpdate(Request $request, Issuer $issuers_info)
    {
        $issuer = $issuers_info;
        $validated = $request->validate([
            'issuer_short_name' => 'required|string|max:50|unique:issuers,issuer_short_name,' . $issuer->id,
            'issuer_name' => 'required|string|max:100',
            'registration_number' => 'required|unique:issuers,registration_number,' . $issuer->id,
            'debenture' => 'nullable|string|max:100',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
            'reminder_1' => 'nullable|date',
            'reminder_2' => 'nullable|date',
            'reminder_3' => 'nullable|date',
            'trustee_role_1' => 'nullable|string|max:100',
            'trustee_role_2' => 'nullable|string|max:100',
            'trust_deed_date' => 'required|date',
        ]);

        $issuer->update($validated);
        return redirect()->route('issuers-search.index', $issuer)->with('success', 'Issuer updated successfully.');
    }
}
