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

// User Main
use App\Http\Controllers\MainController;

// Permission
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionUserController;

// Bonds
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
use App\Http\Controllers\Admin\ActivityDiaryController;

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
use App\Http\Controllers\Admin\DocumentationItemController;
use App\Http\Controllers\Admin\TenantApprovalController;
use App\Http\Controllers\Admin\ConditionCheckController;
use App\Http\Controllers\Admin\PropertyImprovementController;
use App\Http\Controllers\Admin\SiteVisitLogController;

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
use App\Http\Controllers\User\UserUploadController;
use App\Http\Controllers\User\UserActivityDiaryController;

// REITs
use App\Http\Controllers\User\UserPortfolioController;
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserTenantController;
use App\Http\Controllers\User\UserLeaseController;
use App\Http\Controllers\User\UserChecklistController;
use App\Http\Controllers\User\UserFinancialController;
use App\Http\Controllers\User\UserSiteVisitController;
use App\Http\Controllers\User\UserDocumentationItemController;
use App\Http\Controllers\User\UserTenantApprovalController;
use App\Http\Controllers\User\UserConditionCheckController;
use App\Http\Controllers\User\UserPropertyImprovementController;
use App\Http\Controllers\User\UserSiteVisitLogController;

// Main: Login
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 2FA Routes
Route::middleware(['auth'])->group(function() {
    // These routes are available to authenticated users that need to complete 2FA
    Route::get('/two-factor/verify', [TwoFactorController::class, 'show'])
        ->name('two-factor.show');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])
        ->name('two-factor.verify');
    Route::post('/two-factor/generate', [TwoFactorController::class, 'generateCode'])
        ->name('two-factor.generate');
    Route::post('/two-factor/toggle', [TwoFactorController::class, 'toggle'])
        ->name('two-factor.toggle');
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
    
    // Additional
    Route::prefix('/admin/trustee-fees')->name('trustee-fees.')->group(function () {
        Route::get('/admin/trustee-fees-search', [TrusteeFeeController::class, 'search'])->name('search');
        Route::get('/admin/trustee-fees-report', [TrusteeFeeController::class, 'report'])->name('report');
        Route::get('/admin/trustee-fees-trashed', [TrusteeFeeController::class, 'trashed'])->name('trashed');
        Route::patch('/admin/trustee-fees/{id}/restore', [TrusteeFeeController::class, 'restore'])->name('restore');
        Route::delete('/admin/trustee-fees/{id}/force-delete', [TrusteeFeeController::class, 'forceDelete'])->name('force-delete');
    });

    Route::resource('/admin/compliance-covenants', ComplianceCovenantController::class);

    // Additional
    Route::prefix('/admin/compliance-covenants')->name('compliance-covenants.')->group(function () {
        Route::get('/compliance-covenants/report', [ComplianceCovenantController::class, 'report'])->name('report');
        Route::get('/compliance-covenants-trashed', [ComplianceCovenantController::class, 'trashed'])->name('trashed');
        Route::patch('/compliance-covenants/{id}/restore', [ComplianceCovenantController::class, 'restore'])->name('restore');
        Route::delete('/compliance-covenants/{id}/force-delete', [ComplianceCovenantController::class, 'forceDelete'])->name('force-delete');
    });

    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

    // Additional
    Route::prefix('/admin/permissions')->name('permissions.')->group(function () {
        Route::post('{permission}/assign-users', [\App\Http\Controllers\Admin\PermissionController::class, 'assignUsers'])->name('assign-users');
        Route::delete('{permission}/users/{user}', [\App\Http\Controllers\Admin\PermissionController::class, 'removeUser'])->name('remove-user');
    });

    Route::resource('/admin/activity-diaries', ActivityDiaryController::class);

    // Additional routes for activity diaries
    Route::get('/admin/activity-diaries-upcoming', [ActivityDiaryController::class, 'upcoming'])->name('activity-diaries.upcoming');
    Route::get('/admin/activity-diaries/by-bond/{bond}', [ActivityDiaryController::class, 'getByBond'])->name('activity-diaries.by-bond');
    Route::patch('/admin/activity-diaries/{activity_diaries_info}/update-status', [ActivityDiaryController::class, 'updateStatus'])->name('activity-diaries.update-status');

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
    Route::resource('/admin/documentation-items', DocumentationItemController::class);
    Route::resource('/admin/tenant-approvals', TenantApprovalController::class);
    Route::resource('/admin/condition-checks', ConditionCheckController::class);
    Route::resource('/admin/property-improvements', PropertyImprovementController::class);
    Route::resource('/admin/site-visit-logs', SiteVisitLogController::class);

    // Additional
    Route::prefix('/admin/properties')->name('properties.')->group(function () {
        Route::get('{property}/tenants', [PropertyController::class, 'tenants'])->name('tenants');
        Route::get('{property}/checklists', [PropertyController::class, 'checklists'])->name('checklists');
        Route::get('{property}/site-visits', [PropertyController::class, 'siteVisits'])->name('site-visits');
    });

    // Additional
    Route::prefix('/admin/site-visits')->name('site-visits.')->group(function () {
        Route::get('{site_visit}/download', [SiteVisitController::class, 'downloadAttachment'])->name('download');
    });

    // Additional
    Route::prefix('/admin/tenant-approvals')->name('tenant-approvals.')->group(function () {
        Route::post('{tenantApproval}/approve-by-od', [TenantApprovalController::class, 'approveByOD'])->name('approve-by-od');
        Route::post('{tenantApproval}/verify-by-ld', [TenantApprovalController::class, 'verifyByLD'])->name('verify-by-ld');
        Route::post('{tenantApproval}/submit-to-ld', [TenantApprovalController::class, 'submitToLD'])->name('submit-to-ld');
    });

    // Additional
    Route::prefix('/admin/site-visit-logs')->name('site-visit-logs.')->group(function () {
        Route::get('{siteVisitLog}/download-report', [SiteVisitLogController::class, 'downloadReport'])->name('download-report');
    });
});

// User routes
Route::middleware(['auth', 'two-factor', 'role:user'])->group(function () {
    // Welcome
    Route::get('/welcome', function() {
        return view('welcome');
    })->name('main');

    // Dashboard
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Frontend routes
    Route::get('issuer-search', [MainController::class, 'index'])->name('issuer-search.index');
    Route::get('issuer-info/{issuer}', [MainController::class, 'IssuerInfo'])->name('issuer-search.show');
    Route::get('security-info/{bond}', [MainController::class, 'BondInfo'])->name('security-info.show');
    Route::get('announcement/{announcement}', [MainController::class, 'AnnouncementInfo'])->name('announcement.show');
    Route::get('facility-info/{facilityInformation}', [MainController::class, 'FacilityInfo'])->name('facility.show');

    Route::get('/issuer-details/create', [MainController::class, 'IssuerCreate'])->name('issuer-details.create');
    Route::post('/issuer-details/create', [MainController::class, 'IssuerStore'])->name('issuer-details.store');
    Route::get('/issuer-details/{issuer}/edit', [MainController::class, 'IssuerEdit'])->name('issuer-details.edit');
    Route::patch('/issuer-details/{issuer}/edit', [MainController::class, 'IssuerUpdate'])->name('issuer-details.update');

    Route::get('/bond-details/create/{issuer}', [MainController::class, 'BondCreate'])->name('bond-details.create');
    Route::post('/bond-details/create', [MainController::class, 'BondStore'])->name('bond-details.store');
    Route::get('/bond-details/{bond}/edit', [MainController::class, 'BondEdit'])->name('bond-details.edit');
    Route::patch('/bond-details/{bond}/edit', [MainController::class, 'BondUpdate'])->name('bond-details.update');

    Route::get('/announcement-details/create/{issuer}', [MainController::class, 'AnnouncementCreate'])->name('announcement-details.create');
    Route::post('/announcement-details/create', [MainController::class, 'AnnouncementStore'])->name('announcement-details.store');
    Route::get('/announcement-details/{announcement}/edit', [MainController::class, 'AnnouncementEdit'])->name('announcement-details.edit');
    Route::patch('/announcement-details/{announcement}/edit', [MainController::class, 'AnnouncementUpdate'])->name('announcement-details.update');

    Route::get('/document-details/create/{issuer}', [MainController::class, 'DocumentCreate'])->name('document-details.create');
    Route::post('/document-details/create', [MainController::class, 'DocumentStore'])->name('document-details.store');
    Route::get('/document-details/{document}/edit', [MainController::class, 'DocumentEdit'])->name('document-details.edit');
    Route::patch('/document-details/{document}/edit', [MainController::class, 'DocumentUpdate'])->name('document-details.update');

    Route::get('/facility-info-details/create/{issuer}', [MainController::class, 'FacilityInfoCreate'])->name('facility-info-details.create');
    Route::post('/facility-info-details/create', [MainController::class, 'FacilityInfoStore'])->name('facility-info-details.store');
    Route::get('/facility-info-details/{facility}/edit', [MainController::class, 'FacilityInfoEdit'])->name('facility-info-details.edit');
    Route::patch('/facility-info-details/{facility}/edit', [MainController::class, 'FacilityInfoUpdate'])->name('facility-info-details.update');

    // Bonds
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

    // Additional
    Route::prefix('/user/trustee-fees-info')->name('trustee-fees-info.')->group(function () {
        Route::get('/user/trustee-fees-info/report', [UserTrusteeFeeController::class, 'report'])->name('report');
        Route::get('/user/trustee-fees-info/trashed', [UserTrusteeFeeController::class, 'trashed'])->name('trashed');
        Route::patch('/user/trustee-fees-info{id}/restore', [UserTrusteeFeeController::class, 'restore'])->name('restore');
        Route::delete('/user/trustee-fees-info{id}/force-delete', [UserTrusteeFeeController::class, 'forceDelete'])->name('force-delete');
    });

    Route::resource('/user/compliance-covenants-info', UserComplianceCovenantController::class);
    
    // Additional
    Route::prefix('/user/compliance-covenants-info')->name('compliance-covenants-info.')->group(function () {
        Route::get('/compliance-covenants/report', [UserComplianceCovenantController::class, 'report'])->name('report');
        Route::get('/compliance-covenants-trashed', [UserComplianceCovenantController::class, 'trashed'])->name('trashed');
        Route::patch('/compliance-covenants/{id}/restore', [UserComplianceCovenantController::class, 'restore'])->name('restore');
        Route::delete('/compliance-covenants/{id}/force-delete', [UserComplianceCovenantController::class, 'forceDelete'])->name('force-delete');
    });

    // Additional
    Route::prefix('/user/facility-informations-info')->name('facility-informations-info.')->group(function () {
        Route::get('/user/facility-informations-info-report', [UserFacilityInformationController::class, 'report'])->name('report');
        Route::get('/user/facility-informations-info-trashed', [UserFacilityInformationController::class, 'trashed'])->name('trashed');
    });

    // Additional
    Route::prefix('/user/related-documents-info')->name('related-documents-info.')->group(function () {
        Route::get('/user/related-documents-info/trashed', [UserRelatedDocumentController::class, 'trashed'])->name('trashed');
        Route::post('/user/related-documents-info/{id}/restore', [UserRelatedDocumentController::class, 'restore'])->name('restore');
        Route::post('/user/related-documents-info/{id}/force-delete', [UserRelatedDocumentController::class, 'forceDelete'])->name('force-delete');
    });
    
    // For Issuers
    Route::post('/issuers-info/{issuers_info}/submit', [UserIssuerController::class, 'submitForApproval'])->name('issuers-info.submit');
    Route::post('/issuers-info/{issuers_info}/approve', [UserIssuerController::class, 'approve'])->name('issuers-info.approve');
    Route::post('/issuers-info/{issuers_info}/reject', [UserIssuerController::class, 'reject'])->name('issuers-info.reject');

    // For Bonds
    Route::post('/bonds-info/{bonds_info}/submit', [UserBondController::class, 'submitForApproval'])->name('bonds-info.submit');
    Route::post('/bonds-info/{bonds_info}/approve', [UserBondController::class, 'approve'])->name('bonds-info.approve');
    Route::post('/bonds-info/{bonds_info}/reject', [UserBondController::class, 'reject'])->name('bonds-info.reject');

    Route::resource('/user/activity-diaries-info', UserActivityDiaryController::class);

    // Additional routes for activity diaries
    Route::get('/user/activity-diaries-upcoming', [UserActivityDiaryController::class, 'upcoming'])->name('activity-diaries-info.upcoming');
    Route::get('/user/activity-diaries/by-bond/{bond}', [UserActivityDiaryController::class, 'getByBond'])->name('activity-diaries-info.by-bond');
    Route::patch('/user/activity-diaries/{activity_diaries_info}/update-status', [UserActivityDiaryController::class, 'updateStatus'])->name('activity-diaries-info.update-status');

    // Frontend Upload routes
    Route::prefix('/user/bonds-info')->name('bonds-info.')->group(function () {
        Route::get('/user/bonds-info/upload', [UserUploadController::class, 'UploadBond'])->name('upload-form');
        Route::post('/user/bonds-info/upload', [UserUploadController::class, 'StoreBond'])->name('upload-store');
    });

    Route::prefix('/user/rating-movements-info')->name('rating-movements-info.')->group(function () {
        Route::get('/user/rating-movements-info/upload', [UserUploadController::class, 'UploadRatingMovement'])->name('upload-form');
        Route::post('/user/rating-movements-info/upload', [UserUploadController::class, 'StoreRatingMovement'])->name('upload-store');
    });

    Route::prefix('/user/payment-schedules-info')->name('payment-schedules-info.')->group(function () {
        Route::get('/user/payment-schedules-info/upload', [UserUploadController::class, 'UploadPaymentSchedule'])->name('upload-form');
        Route::post('/user/payment-schedules-info/upload', [UserUploadController::class, 'StorePaymentSchedule'])->name('upload-store');
    });

    Route::prefix('/user/trading-activities-info')->name('trading-activities-info.')->group(function () {
        Route::get('/user/trading-activities-info/upload', [UserUploadController::class, 'UploadTradingActivity'])->name('upload-form');
        Route::post('/user/trading-activities-info/upload', [UserUploadController::class, 'StoreTradingActivity'])->name('upload-store');
    });

    // Routes for Approve and Reject
    Route::post('/user/bonds/{bond}/approve', [BondController::class, 'approve'])->name('bonds.approve');
    Route::post('/user/bonds/{bond}/reject', [BondController::class, 'reject'])->name('bonds.reject');


    // REITs
    Route::resource('/user/portfolios-info', UserPortfolioController::class);
    Route::resource('/user/properties-info', UserPropertyController::class);
    Route::resource('/user/tenants-info', UserTenantController::class);
    Route::resource('/user/leases-info', UserLeaseController::class);
    Route::resource('/user/checklists-info', UserChecklistController::class);
    Route::resource('/user/financials-info', UserFinancialController::class);
    Route::resource('/user/site-visits-info', UserSiteVisitController::class);
    Route::resource('/user/documentation-items-info', UserDocumentationItemController::class);
    Route::resource('/user/tenant-approvals-info', UserTenantApprovalController::class);
    Route::resource('/user/condition-checks-info', UserConditionCheckController::class);
    Route::resource('/user/property-improvements-info', UserPropertyImprovementController::class);
    Route::resource('/user/site-visit-logs-info', UserSiteVisitLogController::class);

    // Additional custom routes
    Route::prefix('/user/leases-info')->name('leases-info.')->group(function () {
        Route::get('expiring/soon', [UserLeaseController::class, 'expiringLeases'])->name('expiring');
        Route::patch('{lease}/status', [UserLeaseController::class, 'updateStatus'])->name('update-status');
    });

    // Additional
    Route::prefix('/user/site-visit-logs-info')->name('site-visit-logs-info.')->group(function () {
        Route::get('{site_visit_logs_info}/download-report', [UserSiteVisitLogController::class, 'downloadReport'])->name('download-report');
    });
});

// Legal routes
Route::middleware(['auth', 'two-factor', 'role:legal'])->group(function () {
    Route::get('/legal/dashboard', [LegalController::class, 'index'])->name('legal.dashboard');
});

// Compliance routes
Route::middleware(['auth', 'two-factor', 'role:compliance'])->group(function () {
    Route::get('/compliance/dashboard', [ComplianceController::class, 'index'])->name('compliance.dashboard');
});

// Maker routes
Route::middleware(['auth', 'two-factor', 'role:maker'])->group(function () {
    // Welcome
    Route::get('/welcome', function() {
        return view('welcome');
    })->name('main');

    // Dashboard
    Route::get('/maker/dashboard', [MakerController::class, 'index'])->name('maker.dashboard');

    // Issuer Module
    Route::get('maker/issuer/create', [MakerController::class, 'IssuerCreate'])->name('issuer-m.create');
    Route::post('maker/issuer/create', [MakerController::class, 'IssuerStore'])->name('issuer-m.store');
    Route::get('maker/issuer/{issuer}/edit', [MakerController::class, 'IssuerEdit'])->name('issuer-m.edit');
    Route::put('maker/issuer/{issuer}/update', [MakerController::class, 'IssuerUpdate'])->name('issuer-m.update');
    Route::get('maker/issuer/{issuer}/show', [MakerController::class, 'IssuerShow'])->name('issuer-m.show');
    Route::get('maker/issuer/{issuer}/submit-for-approval', [MakerController::class, 'submitForApproval'])->name('issuer-m.approval');

    // Bond Module
    Route::get('maker/{issuer}/details', [MakerController::class, 'BondIndex'])->name('bond-m.details');
    Route::get('maker/bond/{issuer}/create', [MakerController::class, 'BondCreate'])->name('bond-m.create');
    Route::post('maker/bond/{issuer}/create', [MakerController::class, 'BondStore'])->name('bond-m.store');
    Route::get('maker/bond/{bond}/edit', [MakerController::class, 'BondEdit'])->name('bond-m.edit');
    Route::put('maker/bond/{bond}/update', [MakerController::class, 'BondUpdate'])->name('bond-m.update');
    Route::get('maker/bond/{bond}/show', [MakerController::class, 'BondShow'])->name('bond-m.show');
    Route::get('maker/bond/{issuer}/upload', [MakerController::class, 'BondUploadForm'])->name('bond-m.upload-form');
    Route::post('maker/bond/{issuer}/upload', [MakerController::class, 'BondUploadStore'])->name('bond-m.upload-store');

    // Announcement Module
    Route::get('maker/announcement/{issuer}/create', [MakerController::class, 'AnnouncementCreate'])->name('announcement-m.create');
    Route::post('maker/announcement/{issuer}/create', [MakerController::class, 'AnnouncementStore'])->name('announcement-m.store');
    Route::get('maker/announcement/{announcement}/edit', [MakerController::class, 'AnnouncementEdit'])->name('announcement-m.edit');
    Route::put('maker/announcement/{announcement}/update', [MakerController::class, 'AnnouncementUpdate'])->name('announcement-m.update');
    Route::get('maker/announcement/{announcement}/show', [MakerController::class, 'AnnouncementShow'])->name('announcement-m.show');

    // Document Module
    Route::get('maker/document/{issuer}/create', [MakerController::class, 'DocumentCreate'])->name('document-m.create');
    Route::post('maker/document/{issuer}/create', [MakerController::class, 'DocumentStore'])->name('document-m.store');
    Route::get('maker/document/{document}/edit', [MakerController::class, 'DocumentEdit'])->name('document-m.edit');
    Route::put('maker/document/{document}/update', [MakerController::class, 'DocumentUpdate'])->name('document-m.update');
    Route::get('maker/document/{document}/show', [MakerController::class, 'DocumentShow'])->name('document-m.show');

    // Facility Info Module
    Route::get('maker/facility-info/{issuer}/create', [MakerController::class, 'FacilityInfoCreate'])->name('facility-info-m.create');
    Route::post('maker/facility-info/{issuer}/create', [MakerController::class, 'FacilityInfoStore'])->name('facility-info-m.store');
    Route::get('maker/facility-info/{facility}/edit', [MakerController::class, 'FacilityInfoEdit'])->name('facility-info-m.edit');
    Route::put('maker/facility-info/{facility}/update', [MakerController::class, 'FacilityInfoUpdate'])->name('facility-info-m.update');
    Route::get('maker/facility-info/{facility}/show', [MakerController::class, 'FacilityInfoShow'])->name('facility-info-m.show');

    // Rating Movement Module
    Route::get('maker/rating-movement/{bond}/create', [MakerController::class, 'RatingMovementCreate'])->name('rating-m.create');
    Route::post('maker/rating-movement/{bond}/create', [MakerController::class, 'RatingMovementStore'])->name('rating-m.store');
    Route::get('maker/rating-movement/{rating}/edit', [MakerController::class, 'RatingMovementEdit'])->name('rating-m.edit');
    Route::put('maker/rating-movement/{rating}/update', [MakerController::class, 'RatingMovementUpdate'])->name('rating-m.update');
    Route::get('maker/rating-movement/{rating}/show', [MakerController::class, 'RatingMovementShow'])->name('rating-m.show');
    Route::get('maker/rating-movement/{bond}/upload', [MakerController::class, 'RatingMovementUploadForm'])->name('rating-m.upload-form');
    Route::post('maker/rating-movement/{bond}/upload', [MakerController::class, 'RatingMovementUploadStore'])->name('rating-m.upload-store');

    // Payment Schedule Module
    Route::get('maker/payment-schedule/{bond}/create', [MakerController::class, 'PaymentScheduleCreate'])->name('payment-m.create');
    Route::post('maker/payment-schedule/{bond}/create', [MakerController::class, 'PaymentScheduleStore'])->name('payment-m.store');
    Route::get('maker/payment-schedule/{payment}/edit', [MakerController::class, 'PaymentScheduleEdit'])->name('payment-m.edit');
    Route::put('maker/payment-schedule/{payment}/update', [MakerController::class, 'PaymentScheduleUpdate'])->name('payment-m.update');
    Route::get('maker/payment-schedule/{payment}/show', [MakerController::class, 'PaymentScheduleShow'])->name('payment-m.show');
    Route::get('maker/payment-schedule/{bond}/upload', [MakerController::class, 'PaymentScheduleUploadForm'])->name('payment-m.upload-form');
    Route::post('maker/payment-schedule/{bond}/upload', [MakerController::class, 'PaymentScheduleUploadStore'])->name('payment-m.upload-store');

    // Redemption Module
    Route::get('maker/redemption/{bond}/create', [MakerController::class, 'RedemptionCreate'])->name('redemption-m.create');
    Route::post('maker/redemption/{bond}/create', [MakerController::class, 'RedemptionStore'])->name('redemption-m.store');
    Route::get('maker/redemption/{redemption}/edit', [MakerController::class, 'RedemptionEdit'])->name('redemption-m.edit');
    Route::put('maker/redemption/{redemption}/update', [MakerController::class, 'RedemptionUpdate'])->name('redemption-m.update');
    Route::get('maker/redemption/{redemption}/show', [MakerController::class, 'RedemptionShow'])->name('redemption-m.show');
    Route::get('maker/redemption/{bond}/upload', [MakerController::class, 'RedemptionUploadForm'])->name('redemption-m.upload-form');
    Route::post('maker/redemption/{bond}/upload', [MakerController::class, 'RedemptionUploadStore'])->name('redemption-m.upload-store');

    // Call Schedule Module
    Route::get('maker/call-schedule/{bond}/create', [MakerController::class, 'CallScheduleCreate'])->name('call-m.create');
    Route::post('maker/call-schedule/{bond}/create', [MakerController::class, 'CallScheduleStore'])->name('call-m.store');
    Route::get('maker/call-schedule/{call}/edit', [MakerController::class, 'CallScheduleEdit'])->name('call-m.edit');
    Route::put('maker/call-schedule/{call}/update', [MakerController::class, 'CallScheduleUpdate'])->name('call-m.update');
    Route::get('maker/call-schedule/{call}/show', [MakerController::class, 'CallScheduleShow'])->name('call-m.show');
    Route::get('maker/call-schedule/{bond}/upload', [MakerController::class, 'CallScheduleUploadForm'])->name('call-m.upload-form');
    Route::post('maker/call-schedule/{bond}/upload', [MakerController::class, 'CallScheduleUploadStore'])->name('call-m.upload-store');

    // Lockout Period Module
    Route::get('maker/lockout-period/{bond}/create', [MakerController::class, 'LockoutPeriodCreate'])->name('lockout-m.create');
    Route::post('maker/lockout-period/{bond}/create', [MakerController::class, 'LockoutPeriodStore'])->name('lockout-m.store');
    Route::get('maker/lockout-period/{lockout}/edit', [MakerController::class, 'LockoutPeriodEdit'])->name('lockout-m.edit');
    Route::put('maker/lockout-period/{lockout}/update', [MakerController::class, 'LockoutPeriodUpdate'])->name('lockout-m.update');
    Route::get('maker/lockout-period/{lockout}/show', [MakerController::class, 'LockoutPeriodShow'])->name('lockout-m.show');
    Route::get('maker/lockout-period/{bond}/upload', [MakerController::class, 'LockoutPeriodUploadForm'])->name('lockout-m.upload-form');
    Route::post('maker/lockout-period/{bond}/upload', [MakerController::class, 'LockoutPeriodUploadStore'])->name('lockout-m.upload-store');

    // Trading Activity Module
    Route::get('maker/trading-activity/{bond}/create', [MakerController::class, 'TradingActivityCreate'])->name('trading-m.create');
    Route::post('maker/trading-activity/{bond}/create', [MakerController::class, 'TradingActivityStore'])->name('trading-m.store');
    Route::get('maker/trading-activity/{trading}/edit', [MakerController::class, 'TradingActivityEdit'])->name('trading-m.edit');
    Route::put('maker/trading-activity/{trading}/update', [MakerController::class, 'TradingActivityUpdate'])->name('trading-m.update');
    Route::get('maker/trading-activity/{trading}/show', [MakerController::class, 'TradingActivityShow'])->name('trading-m.show');
    Route::get('maker/trading-activity/{bond}/upload', [MakerController::class, 'TradingActivityUploadForm'])->name('trading-m.upload-form');
    Route::post('maker/trading-activity/{bond}/upload', [MakerController::class, 'TradingActivityUploadStore'])->name('trading-m.upload-store');
    
    // Trustee Fee Module
    Route::get('maker/trustee-fee', [MakerController::class, 'TrusteeFeeIndex'])->name('trustee-fee-m.index');
    Route::get('maker/trustee-fee/create', [MakerController::class, 'TrusteeFeeCreate'])->name('trustee-fee-m.create');
    Route::post('maker/trustee-fee/create', [MakerController::class, 'TrusteeFeeStore'])->name('trustee-fee-m.store');
    Route::get('maker/trustee-fee/{trusteeFee}/edit', [MakerController::class, 'TrusteeFeeEdit'])->name('trustee-fee-m.edit');
    Route::put('maker/trustee-fee/{trusteeFee}/update', [MakerController::class, 'TrusteeFeeUpdate'])->name('trustee-fee-m.update');
    Route::get('maker/trustee-fee/{trusteeFee}/show', [MakerController::class, 'TrusteeFeeShow'])->name('trustee-fee-m.show');
    Route::get('maker/trustee-fee/{trusteeFee}/submit-for-approval', [MakerController::class, 'SubmitApprovalTrusteeFee'])->name('trustee-fee-m.approval');

    // Compliance Covenant Module
    Route::get('maker/compliance-covenant', [MakerController::class, 'ComplianceIndex'])->name('compliance-covenant-m.index');
    Route::get('maker/compliance-covenant/create', [MakerController::class, 'ComplianceCreate'])->name('compliance-covenant-m.create');
    Route::post('maker/compliance-covenant/create', [MakerController::class, 'ComplianceStore'])->name('compliance-covenant-m.store');
    Route::get('maker/compliance-covenant/{compliance}/edit', [MakerController::class, 'ComplianceEdit'])->name('compliance-covenant-m.edit');
    Route::put('maker/compliance-covenant/{compliance}/update', [MakerController::class, 'ComplianceUpdate'])->name('compliance-covenant-m.update');
    Route::get('maker/compliance-covenant/{compliance}/show', [MakerController::class, 'ComplianceShow'])->name('compliance-covenant-m.show');
    Route::get('maker/compliance-covenant/{compliance}/submit-for-approval', [MakerController::class, 'SubmitApprovalCompliance'])->name('compliance-covenant-m.approval');

    // Activity Diary Module
    Route::get('maker/activity-diary', [MakerController::class, 'ActivityIndex'])->name('activity-diary-m.index');
    Route::get('maker/activity-diary/create', [MakerController::class, 'ActivityCreate'])->name('activity-diary-m.create');
    Route::post('maker/activity-diary/create', [MakerController::class, 'ActivityStore'])->name('activity-diary-m.store');
    Route::get('maker/activity-diary/{activity}/edit', [MakerController::class, 'ActivityEdit'])->name('activity-diary-m.edit');
    Route::put('maker/activity-diary/{activity}/update', [MakerController::class, 'ActivityUpdate'])->name('activity-diary-m.update');
    Route::get('maker/activity-diary/{activity}/show', [MakerController::class, 'ActivityShow'])->name('activity-diary-m.show');
    // Route::delete('maker/activity-diary/{activity}', [MakerController::class, 'ActivityDestroy'])->name('activity-diary-m.destroy');
    Route::patch('maker/activity-diary/{activity}/status', [MakerController::class, 'ActivityUpdateStatus'])->name('activity-diary-m.update-status');
    Route::get('maker/activity-diary/by-issuer/{issuerId}', [MakerController::class, 'ActivityGetByIssuer'])->name('activity-diary-m.by-issuer');
    Route::get('maker/activity-diary/upcoming', [MakerController::class, 'ActivityUpcoming'])->name('activity-diary-m.upcoming');
    Route::get('maker/activity-diary/export', [MakerController::class, 'ActivityExportActivities'])->name('activity-diary-m.export');
    Route::get('maker/activity-diary/{activity}/submit-for-approval', [MakerController::class, 'SubmitApprovalActivityDiary'])->name('activity-diary-m.approval');
});

// Approver routes
Route::middleware(['auth', 'two-factor', 'role:approver'])->group(function () {
    // Welcome
    Route::get('/welcome', function() {
        return view('welcome');
    })->name('main');

    // Dashboard
    Route::get('/approver/dashboard', [ApproverController::class, 'index'])->name('approver.dashboard');

    // Issuer Module
    Route::get('approver/issuer/{issuer}/show', [ApproverController::class, 'IssuerShow'])->name('issuer-a.show');
    Route::post('approver/{issuer}/approve', [ApproverController::class, 'IssuerApprove'])->name('issuer-a.approve');
    Route::post('approver/{issuer}/reject', [ApproverController::class, 'IssuerReject'])->name('issuer-a.reject');
    
    // Bond Module
    Route::get('approver/{issuer}/details', [ApproverController::class, 'BondIndex'])->name('bond-a.details');
    Route::get('approver/bond/{bond}/show', [ApproverController::class, 'BondShow'])->name('bond-a.show');

    // Announcement Module
    Route::get('approver/announcement/{announcement}/show', [ApproverController::class, 'AnnouncementShow'])->name('announcement-a.show');

    // Document Module
    Route::get('approver/document/{document}/show', [ApproverController::class, 'DocumentShow'])->name('document-a.show');

    // Facility Info Module
    Route::get('approver/facility-info/{facility}/show', [ApproverController::class, 'FacilityInfoShow'])->name('facility-info-a.show');

    // Trustee Fee Module
    Route::get('approver/trustee-fee', [ApproverController::class, 'TrusteeFeeIndex'])->name('trustee-fee-a.index');
    // Route::get('approver/trustee-fee/create', [MakerController::class, 'TrusteeFeeCreate'])->name('trustee-fee-a.create');
    // Route::post('approver/trustee-fee/create', [MakerController::class, 'TrusteeFeeStore'])->name('trustee-fee-a.store');
    // Route::get('approver/trustee-fee/{trusteeFee}/edit', [MakerController::class, 'TrusteeFeeEdit'])->name('trustee-fee-a.edit');
    // Route::put('approver/trustee-fee/{trusteeFee}/update', [MakerController::class, 'TrusteeFeeUpdate'])->name('trustee-fee-a.update');
    Route::get('approver/trustee-fee/{trusteeFee}/show', [ApproverController::class, 'TrusteeFeeShow'])->name('trustee-fee-a.show');
    Route::post('approver/trustee-fee/{trustee_fee}/approve', [ApproverController::class, 'TrusteeFeeApprove'])->name('trustee-fee-a.approve');
    Route::post('approver/trustee-fee/{trustee_fee}/reject', [ApproverController::class, 'TrusteeFeeReject'])->name('trustee-fee-a.reject');

    // Compliance Covenant Module
    Route::get('approver/compliance-covenant', [MakerController::class, 'ComplianceIndex'])->name('compliance-covenant-a.index');
    // Route::get('approver/compliance-covenant/create', [MakerController::class, 'ComplianceCreate'])->name('compliance-covenant-a.create');
    // Route::post('approver/compliance-covenant/create', [MakerController::class, 'ComplianceStore'])->name('compliance-covenant-a.store');
    // Route::get('approver/compliance-covenant/{compliance}/edit', [MakerController::class, 'ComplianceEdit'])->name('compliance-covenant-a.edit');
    // Route::put('approver/compliance-covenant/{compliance}/update', [MakerController::class, 'ComplianceUpdate'])->name('compliance-covenant-a.update');
    Route::get('approver/compliance-covenant/{compliance}/show', [MakerController::class, 'ComplianceShow'])->name('compliance-covenant-a.show');

    // Activity Diary Module
    Route::get('approver/activity-diary', [MakerController::class, 'ActivityIndex'])->name('activity-diary-a.index');
    // Route::get('approver/activity-diary/create', [MakerController::class, 'ActivityCreate'])->name('activity-diary-a.create');
    // Route::post('approver/activity-diary/create', [MakerController::class, 'ActivityStore'])->name('activity-diary-a.store');
    // Route::get('approver/activity-diary/{activity}/edit', [MakerController::class, 'ActivityEdit'])->name('activity-diary-a.edit');
    // Route::put('approver/activity-diary/{activity}/update', [MakerController::class, 'ActivityUpdate'])->name('activity-diary-a.update');
    Route::get('approver/activity-diary/{activity}/show', [MakerController::class, 'ActivityShow'])->name('activity-diary-a.show');
    // Route::delete('approver/activity-diary/{activity}', [MakerController::class, 'ActivityDestroy'])->name('activity-diary-a.destroy');
    Route::patch('approver/activity-diary/{activity}/status', [MakerController::class, 'ActivityUpdateStatus'])->name('activity-diary-a.update-status');
    Route::get('approver/activity-diary/by-issuer/{issuerId}', [MakerController::class, 'ActivityGetByIssuer'])->name('activity-diary-a.by-issuer');
    Route::get('approver/activity-diary/upcoming', [MakerController::class, 'ActivityUpcoming'])->name('activity-diary-a.upcoming');
    Route::get('approver/activity-diary/export', [MakerController::class, 'ActivityExportActivities'])->name('activity-diary-a.export');
});
