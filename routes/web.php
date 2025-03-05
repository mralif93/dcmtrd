<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Legal\LegalController;
use App\Http\Controllers\Compliance\ComplianceController;
use App\Http\Controllers\Maker\MakerController;
use App\Http\Controllers\Approver\ApproverController;
use App\Http\Controllers\TwoFactorController;

use App\Http\Controllers\MainController;

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\IssuerController;
use App\Http\Controllers\Admin\BondController;
use App\Http\Controllers\Admin\RatingMovementController;
use App\Http\Controllers\Admin\PaymentScheduleController;
use App\Http\Controllers\Admin\RedemptionController;
use App\Http\Controllers\Admin\CallScheduleController;
use App\Http\Controllers\Admin\LockoutPeriodController;
use App\Http\Controllers\Admin\TradingActivityController;
use App\Http\Controllers\Admin\FacilityInformationController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\RelatedDocumentController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\TrusteeFeeController;
use App\Http\Controllers\Admin\ComplianceCovenantController;

// REITs
use App\Http\Controllers\Admin\FinancialTypeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\PortfolioTypeController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\LeaseController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\SiteVisitController;

use App\Http\Controllers\User\UserIssuerController;
use App\Http\Controllers\User\UserBondController;
use App\Http\Controllers\User\UserRatingMovementController;
use App\Http\Controllers\User\UserPaymentScheduleController;
use App\Http\Controllers\User\UserRedemptionController;
use App\Http\Controllers\User\UserCallScheduleController;
use App\Http\Controllers\User\UserLockoutPeriodController;
use App\Http\Controllers\User\UserTradingActivityController;
use App\Http\Controllers\User\UserFacilityInformationController;
use App\Http\Controllers\User\UserAnnouncementController;
use App\Http\Controllers\User\UserRelatedDocumentController;
use App\Http\Controllers\User\UserChartController;
use App\Http\Controllers\User\UserTrusteeFeeController;
use App\Http\Controllers\User\UserComplianceCovenantController;

// REITs
use App\Http\Controllers\User\UserPortfolioController;
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserTenantController;
use App\Http\Controllers\User\UserLeaseController;
use App\Http\Controllers\User\UserChecklistController;
use App\Http\Controllers\User\UserFinancialController;
use App\Http\Controllers\User\UserSiteVisitController;

// Main
Route::get('/', function () {
    return view('welcome');
});

// Frontend routes
Route::get('issuer-search', [MainController::class, 'index'])->name('issuer-search.index');
Route::get('issuer-info/{issuer}', [MainController::class, 'info'])->name('issuer-search.show');
Route::get('security-info/{bond}', [MainController::class, 'bondInfo'])->name('security-info.show');
Route::get('announcement/{announcement}', [MainController::class, 'announcement'])->name('announcement.show');
Route::get('facility-info/{facilityInformation}', [MainController::class, 'facility'])->name('facility.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 2FA
Route::middleware(['auth', 'two-factor'])->group(function() {
    Route::get('/two-factor/verify', [TwoFactorController::class, 'show'])
        ->name('two-factor.show');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])
        ->name('two-factor.verify');
});


// Admin routes
Route::middleware(['auth', 'two-factor', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

        // Bond
    Route::resource('/admin/users', UserAdminController::class);
    Route::resource('/admin/issuers', IssuerController::class);
    Route::resource('/admin/bonds', BondController::class);
    Route::resource('/admin/rating-movements', RatingMovementController::class);
    Route::resource('/admin/payment-schedules', PaymentScheduleController::class);
    Route::resource('/admin/redemptions', RedemptionController::class);
    Route::resource('/admin/call-schedules', CallScheduleController::class);
    Route::resource('/admin/lockout-periods', LockoutPeriodController::class);
    Route::resource('/admin/trading-activities', TradingActivityController::class);
    Route::resource('/admin/announcements', AnnouncementController::class);
    Route::resource('/admin/facility-informations', FacilityInformationController::class);
    Route::resource('/admin/related-documents', RelatedDocumentController::class);
    Route::resource('/admin/charts', ChartController::class);

    Route::resource('/admin/trustee-fees', TrusteeFeeController::class);
    Route::get('/admin/trustee-fees-search', [TrusteeFeeController::class, 'search'])->name('trustee-fees.search');
    Route::get('/admin/trustee-fees-report', [TrusteeFeeController::class, 'report'])->name('trustee-fees.report');
    Route::get('/admin/trustee-fees-trashed', [TrusteeFeeController::class, 'trashed'])->name('trustee-fees.trashed');
    Route::patch('/admin/trustee-fees/{id}/restore', [TrusteeFeeController::class, 'restore'])->name('trustee-fees.restore');
    Route::delete('/admin/trustee-fees/{id}/force-delete', [TrusteeFeeController::class, 'forceDelete'])->name('trustee-fees.force-delete');

    Route::resource('/admin/compliance-covenants', ComplianceCovenantController::class);
    Route::get('/admin/compliance-covenants-trashed', [ComplianceCovenantController::class, 'trashed'])->name('compliance-covenants.trashed');
    Route::patch('/admin/compliance-covenants/{id}/restore', [ComplianceCovenantController::class, 'restore'])->name('compliance-covenants.restore');
    Route::delete('/admin/compliance-covenants/{id}/force-delete', [ComplianceCovenantController::class, 'forceDelete'])->name('compliance-covenants.force-delete');

    //  REITs
    Route::resource('/admin/banks', BankController::class);
    Route::resource('/admin/financial-types', FinancialTypeController::class);
    Route::resource('/admin/portfolio-types', PortfolioTypeController::class);
    Route::resource('/admin/portfolios', PortfolioController::class);
    Route::resource('/admin/properties', PropertyController::class);
    Route::resource('/admin/checklists', ChecklistController::class);
    Route::resource('/admin/tenants', TenantController::class);
    Route::resource('/admin/leases', LeaseController::class);
    Route::resource('/admin/financials', FinancialController::class);
    Route::resource('/admin/site-visits', SiteVisitController::class);

    // Additional Property-specific Routes
    Route::prefix('/admin/properties')->name('properties.')->group(function () {
        // Tenants listing for a specific property
        Route::get('{property}/tenants', [PropertyController::class, 'tenants'])
            ->name('tenants');
        
        // Checklists listing for a specific property
        Route::get('{property}/checklists', [PropertyController::class, 'checklists'])
            ->name('checklists');
        
        // Site Visits listing for a specific property
        Route::get('{property}/site-visits', [PropertyController::class, 'siteVisits'])
            ->name('site-visits');
    });

    Route::prefix('/admin/site-visits')->name('site-visits.')->group(function () {
        Route::get('{site_visit}/download', [SiteVisitController::class, 'downloadAttachment'])
            ->name('download');
    });

    
});

// Default user route
Route::middleware(['auth', 'two-factor', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])
        ->name('dashboard');

    Route::resource('/user/issuers-info', UserIssuerController::class);
    Route::resource('/user/bonds-info', UserBondController::class);
    Route::resource('/user/rating-movements-info', UserRatingMovementController::class);
    Route::resource('/user/payment-schedules-info', UserPaymentScheduleController::class);
    Route::resource('/user/redemptions-info', UserRedemptionController::class);
    Route::resource('/user/call-schedules-info', UserCallScheduleController::class);
    Route::resource('/user/lockout-periods-info', UserLockoutPeriodController::class);
    Route::resource('/user/trading-activities-info', UserTradingActivityController::class);
    Route::resource('/user/announcements-info', UserAnnouncementController::class);
    Route::resource('/user/facility-informations-info', UserFacilityInformationController::class);
    Route::resource('/user/related-documents-info', UserRelatedDocumentController::class);
    Route::resource('/user/charts-info', UserChartController::class);
    Route::resource('/user/trustee-fees-info', UserTrusteeFeeController::class);
    Route::resource('/user/compliance-covenants-info', UserComplianceCovenantController::class);

    // REITs
    Route::resource('/user/portfolios-info', UserPortfolioController::class);
    Route::resource('/user/properties-info', UserPropertyController::class);
    Route::resource('/user/tenants-info', UserTenantController::class);
    Route::resource('/user/leases-info', UserLeaseController::class);
    Route::resource('/user/checklists-info', UserChecklistController::class);
    Route::resource('/user/financials-info', UserFinancialController::class);
    Route::resource('/user/site-visits-info', UserSiteVisitController::class);

    // Additional custom routes
    Route::prefix('/user/leases-info')->name('leases-info.')->group(function () {
        Route::get('expiring/soon', [UserLeaseController::class, 'expiringLeases'])->name('expiring');
        Route::patch('{lease}/status', [UserLeaseController::class, 'updateStatus'])->name('update-status');
    });
});

// Legal routes
Route::middleware(['auth', 'two-factor', 'role:legal'])->group(function () {
    Route::get('/legal/dashboard', [LegalController::class, 'index'])
        ->name('legal.dashboard');
});

// Compliance routes
Route::middleware(['auth', 'two-factor', 'role:compliance'])->group(function () {
    Route::get('/compliance/dashboard', [ComplianceController::class, 'index'])
        ->name('compliance.dashboard');
});

// Maker routes
Route::middleware(['auth', 'two-factor', 'role:maker'])->group(function () {
    Route::get('/maker/dashboard', [MakerController::class, 'index'])
        ->name('maker.dashboard');
});

// Approver routes
Route::middleware(['auth', 'two-factor', 'role:approver'])->group(function () {
    Route::get('/approver/dashboard', [ApproverController::class, 'index'])
        ->name('approver.dashboard');
});