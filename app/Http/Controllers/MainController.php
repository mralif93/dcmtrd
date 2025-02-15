<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\BondInfo;
use App\Models\CallSchedule;
use App\Models\LockoutPeriod;

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
        $ratingMovements = $bond->bondInfo
            ? $bond->bondInfo->ratingMovements()->paginate($perPage, ['*'], 'ratingMovementsPage')
            : $emptyPaginator;

        // Payment Schedules Pagination
        $paymentSchedules = $bond->bondInfo
            ? $bond->bondInfo->paymentSchedules()->paginate($perPage, ['*'], 'paymentSchedulesPage')
            : $emptyPaginator;

        // Call Schedules Pagination
        $callSchedules = $bond->bondInfo && $bond->bondInfo->redemptions
            ? CallSchedule::whereIn('redemption_id', $bond->bondInfo->redemptions->pluck('id'))
                ->paginate($perPage, ['*'], 'callSchedulesPage')
            : $emptyPaginator;

        // Lockout Periods Pagination
        $lockoutPeriods = $bond->bondInfo && $bond->bondInfo->redemptions
            ? LockoutPeriod::whereIn('redemption_id', $bond->bondInfo->redemptions->pluck('id'))
                ->paginate($perPage, ['*'], 'lockoutPeriodsPage')
            : $emptyPaginator;

        // Trading Activities Pagination
        $tradingActivities = $bond->bondInfo
            ? $bond->bondInfo->tradingActivities()
                ->orderBy('trade_date', 'desc')
                ->paginate($perPage, ['*'], 'tradingActivitiesPage')
            : $emptyPaginator;

        return view('main.bond', [
            'bond' => $bond,
            'documents' => $documents,
            'ratingMovements' => $ratingMovements,
            'paymentSchedules' => $paymentSchedules,
            'redemptions' => $bond->bondInfo->redemptions ?? collect(),
            'tradingActivities' => $tradingActivities,
            'callSchedules' => $callSchedules,
            'lockoutPeriods' => $lockoutPeriods,
            'charts' => $bond->charts ?? collect()
        ]);
    }
}
