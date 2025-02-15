<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Issuer;
use App\Models\Bond;
use App\Models\BondInfo;
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
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'issuersCount' => Issuer::count(),
            'bondsCount' => Bond::count(),
            'bondInfoCount' => BondInfo::count(),
            'ratingMovementsCount' => RatingMovement::count(),
            'paymentSchedulesCount' => PaymentSchedule::count(),
            'redemptionsCount' => Redemption::count(),
            'callSchedulesCount' => CallSchedule::count(),
            'lockoutPeriodsCount' => LockoutPeriod::count(),
            'tradingActivitiesCount' => TradingActivity::count(),
            'announcementsCount' => Announcement::count(),
            'facilityInformationsCount' => FacilityInformation::count(),
            'relatedDocumentsCount' => RelatedDocument::count(),
            'chartsCount' => Chart::count(),
        ]);
    }
}
