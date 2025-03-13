<?php

namespace App\Http\Controllers\User;

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

class UserController extends Controller
{
    public function index() {
        $counts = Cache::remember('dashboard_user_counts', now()->addMinutes(5), function () {
            $result = DB::select("
                SELECT 
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
                    (SELECT COUNT(*) FROM charts) AS charts_count,
                    (SELECT COUNT(*) FROM trustee_fees) AS trustee_fees_count,
                    (SELECT COUNT(*) FROM compliance_covenants) AS compliance_covenants_count,
                    (SELECT COUNT(*) FROM activity_diaries) AS activity_diaries_count,

                    (SELECT COUNT(*) FROM financial_types) AS financial_types_count,
                    (SELECT COUNT(*) FROM banks) AS banks_count,
                    (SELECT COUNT(*) FROM portfolio_types) AS portfolio_types_count,
                    (SELECT COUNT(*) FROM portfolios) AS portfolios_count,
                    (SELECT COUNT(*) FROM properties) AS properties_count,
                    (SELECT COUNT(*) FROM checklists) AS checklists_count,
                    (SELECT COUNT(*) FROM tenants) AS tenants_count,
                    (SELECT COUNT(*) FROM leases) AS leases_count,
                    (SELECT COUNT(*) FROM financials) AS financials_count,
                    (SELECT COUNT(*) FROM site_visits) AS site_visits_count,
                    (SELECT COUNT(*) FROM documentation_items) AS documentation_items_count,
                    (SELECT COUNT(*) FROM tenant_approvals) AS tenant_approvals_count,
                    (SELECT COUNT(*) FROM condition_checks) AS condition_checks_count,
                    (SELECT COUNT(*) FROM property_improvements) AS property_improvements_count,
                    (SELECT COUNT(*) FROM site_visit_logs) AS site_visit_logs_count
            ");
            return (array) $result[0];
        });
    
        return view('user.dashboard', [
            // Bond counts
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
            'trusteeFeesCount' => $counts['trustee_fees_count'],
            'complianceCovenantCount' => $counts['compliance_covenants_count'],
            'activityDairyCount' => $counts['activity_diaries_count'],

            // REITs counts
            'financialTypesCount' => $counts['financial_types_count'],
            'banksCount' => $counts['banks_count'],
            'portfolioTypesCount' => $counts['portfolio_types_count'],
            'portfoliosCount' => $counts['portfolios_count'],
            'propertiesCount' => $counts['properties_count'],
            'checklistsCount' => $counts['checklists_count'],
            'tenantsCount' => $counts['tenants_count'],
            'leasesCount' => $counts['leases_count'],
            'financialsCount' => $counts['financials_count'],
            'siteVisitsCount' => $counts['site_visits_count'],
            'documentationItemsCount' => $counts['documentation_items_count'],
            'tenantApprovalsCount' => $counts['tenant_approvals_count'],
            'conditionChecksCount' => $counts['condition_checks_count'],
            'propertyImprovementsCount' => $counts['property_improvements_count'],
            'siteVisitLogsCount' => $counts['site_visit_logs_count'] ?? 0
        ]);
    }
}