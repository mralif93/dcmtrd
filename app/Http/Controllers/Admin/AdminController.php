<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\RatingMovement;
use App\Models\PaymentSchedule;
use App\Models\Redemption;
use App\Models\CallSchedule;
use App\Models\LockoutPeriod;
use App\Models\TradingActivity;
use App\Models\Announcement;
use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use App\Models\Chart;

class AdminController extends Controller
{
    public function index() {
        $counts = Cache::remember('dashboard_counts', now()->addMinutes(5), function () {
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM users) AS users_count,
                    (SELECT COUNT(*) FROM issuers) AS issuers_count,
                    (SELECT COUNT(*) FROM bonds) AS bonds_count,
                    (SELECT COUNT(*) FROM rating_movements) AS rating_movements_count,
                    (SELECT COUNT(*) FROM payment_schedules) AS payment_schedules_count,
                    (SELECT COUNT(*) FROM redemptions) AS redemptions_count,
                    (SELECT COUNT(*) FROM call_schedules) AS call_schedules_count,
                    (SELECT COUNT(*) FROM lockout_periods) AS lockout_periods_count,
                    (SELECT COUNT(*) FROM trading_activities) AS trading_activities_count,
                    (SELECT COUNT(*) FROM announcements) AS announcements_count,
                    (SELECT COUNT(*) FROM facility_informations) AS facility_informations_count,
                    (SELECT COUNT(*) FROM related_documents) AS related_documents_count,
                    (SELECT COUNT(*) FROM charts) AS charts_count
            ");
            return (array) $result[0];
        });

        return view('admin.dashboard', [
            'usersCount' => $counts['users_count'],
            'issuersCount' => $counts['issuers_count'],
            'bondsCount' => $counts['bonds_count'],
            'ratingMovementsCount' => $counts['rating_movements_count'],
            'paymentSchedulesCount' => $counts['payment_schedules_count'],
            'redemptionsCount' => $counts['redemptions_count'],
            'callSchedulesCount' => $counts['call_schedules_count'],
            'lockoutPeriodsCount' => $counts['lockout_periods_count'],
            'tradingActivitiesCount' => $counts['trading_activities_count'],
            'announcementsCount' => $counts['announcements_count'],
            'facilityInformationsCount' => $counts['facility_informations_count'],
            'relatedDocumentsCount' => $counts['related_documents_count'],
            'chartsCount' => $counts['charts_count'],
        ]);
    }
}
