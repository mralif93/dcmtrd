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
use App\Http\Controllers\Admin\SiteVisitLogController;

// Bonds
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

// Welcome Page & 2FA Routes
Route::middleware(['auth'])->group(function() {
    // Welcome Page
    Route::get('/welcome', function() {
        return view('welcome');
    })->name('main');

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
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Bond
    Route::resource('/admin/users', UserAdminController::class);
    Route::resource('/admin/issuers', IssuerController::class);

    Route::resource('/admin/bonds', BondController::class);

    // Additional
    Route::prefix('/admin/bonds')->name('bonds.')->group(function () {
        Route::get('/admin/bonds/trashed', [BondController::class, 'trashed'])->name('trashed');
        Route::patch('/admin/bonds/{id}/restore', [BondController::class, 'restore'])->name('restore');
        Route::delete('/admin/bonds/{id}/force-delete', [BondController::class, 'forceDelete'])->name('/adminforce-delete');
    });

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
        Route::get('/admin/compliance-covenants/report', [ComplianceCovenantController::class, 'report'])->name('report');
        Route::get('/admin/compliance-covenants-trashed', [ComplianceCovenantController::class, 'trashed'])->name('trashed');
        Route::patch('/admin/compliance-covenants/{id}/restore', [ComplianceCovenantController::class, 'restore'])->name('restore');
        Route::delete('/admin/compliance-covenants/{id}/force-delete', [ComplianceCovenantController::class, 'forceDelete'])->name('force-delete');
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
    Route::resource('/admin/site-visit-logs', SiteVisitLogController::class);

    // Additional
    Route::prefix('/admin/properties')->name('properties.')->group(function () {
        Route::get('{property}/tenants', [PropertyController::class, 'tenants'])->name('tenants');
        Route::get('{property}/checklists', [PropertyController::class, 'checklists'])->name('checklists');
        Route::get('{property}/site-visits', [PropertyController::class, 'siteVisits'])->name('site-visits');
    });

    // Additional
    Route::prefix('/admin/site-visits')->name('site-visits.')->group(function () {
        Route::get('upcoming', [SiteVisitController::class, 'upcoming'])->name('upcoming');
        Route::get('{siteVisit}/download-attachment', [SiteVisitController::class, 'downloadAttachment'])->name('download-attachment');
        Route::patch('{siteVisit}/mark-as-completed', [SiteVisitController::class, 'markAsCompleted'])->name('mark-as-completed');
        Route::patch('{siteVisit}/mark-as-cancelled', [SiteVisitController::class, 'markAsCancelled'])->name('mark-as-cancelled');
    });

    // Additional
    Route::prefix('/admin/site-visit-logs')->name('site-visit-logs.')->group(function () {
        Route::get('{siteVisitLog}/download-report', [SiteVisitLogController::class, 'downloadReport'])->name('download-report');
    });
});

// User routes
Route::middleware(['auth', 'two-factor', 'role:user'])->group(function () {
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
    // Dashboard
    Route::get('/legal/dashboard', [LegalController::class, 'index'])->name('legal.dashboard');

    // Site Visit Module
    Route::get('legal/site-visit/{siteVisit}/show', [LegalController::class, 'SiteVisitShow'])->name('site-visit-l.show')->middleware('permission:REITS');

    // Checklist Module
    Route::get('legal/checklist/{checklist}/edit', [LegalController::class, 'ChecklistEdit'])->name('checklist-l.edit')->middleware('permission:REITS');
    Route::patch('legal/checklist/{checklist}/update', [LegalController::class, 'ChecklistUpdate'])->name('checklist-l.update')->middleware('permission:REITS');
    Route::get('legal/checklist/{checklist}/show', [LegalController::class, 'ChecklistShow'])->name('checklist-l.show')->middleware('permission:REITS');
});

// Compliance routes
Route::middleware(['auth', 'two-factor', 'role:compliance'])->group(function () {
    // Dashboard
    Route::get('/compliance/dashboard', [ComplianceController::class, 'index'])->name('compliance.dashboard');
});

// Maker routes
Route::middleware(['auth', 'two-factor', 'role:maker'])->group(function () {
    // Dashboard
    Route::get('/maker/dashboard', [MakerController::class, 'index'])->name('maker.dashboard');

    // Issuer Module
    Route::get('maker/issuer/create', [MakerController::class, 'IssuerCreate'])->name('issuer-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/issuer/create', [MakerController::class, 'IssuerStore'])->name('issuer-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/issuer/{issuer}/edit', [MakerController::class, 'IssuerEdit'])->name('issuer-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/issuer/{issuer}/update', [MakerController::class, 'IssuerUpdate'])->name('issuer-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/issuer/{issuer}/show', [MakerController::class, 'IssuerShow'])->name('issuer-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/issuer/{issuer}/submit-for-approval', [MakerController::class, 'submitForApproval'])->name('issuer-m.approval')->middleware('permission:DCMTRD');

    // Bond Module
    Route::get('maker/{issuer}/details', [MakerController::class, 'BondIndex'])->name('bond-m.details')->middleware('permission:DCMTRD');
    Route::get('maker/bond/{issuer}/create', [MakerController::class, 'BondCreate'])->name('bond-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/bond/{issuer}/create', [MakerController::class, 'BondStore'])->name('bond-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/bond/{bond}/edit', [MakerController::class, 'BondEdit'])->name('bond-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/bond/{bond}/update', [MakerController::class, 'BondUpdate'])->name('bond-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/bond/{bond}/show', [MakerController::class, 'BondShow'])->name('bond-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/bond/{issuer}/upload', [MakerController::class, 'BondUploadForm'])->name('bond-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/bond/{issuer}/upload', [MakerController::class, 'BondUploadStore'])->name('bond-m.upload-store')->middleware('permission:DCMTRD');

    // Announcement Module
    Route::get('maker/announcement/{issuer}/create', [MakerController::class, 'AnnouncementCreate'])->name('announcement-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/announcement/{issuer}/create', [MakerController::class, 'AnnouncementStore'])->name('announcement-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/announcement/{announcement}/edit', [MakerController::class, 'AnnouncementEdit'])->name('announcement-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/announcement/{announcement}/update', [MakerController::class, 'AnnouncementUpdate'])->name('announcement-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/announcement/{announcement}/show', [MakerController::class, 'AnnouncementShow'])->name('announcement-m.show')->middleware('permission:DCMTRD');

    // Document Module
    Route::get('maker/document/{issuer}/create', [MakerController::class, 'DocumentCreate'])->name('document-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/document/{issuer}/create', [MakerController::class, 'DocumentStore'])->name('document-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/document/{document}/edit', [MakerController::class, 'DocumentEdit'])->name('document-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/document/{document}/update', [MakerController::class, 'DocumentUpdate'])->name('document-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/document/{document}/show', [MakerController::class, 'DocumentShow'])->name('document-m.show')->middleware('permission:DCMTRD');

    // Facility Info Module
    Route::get('maker/facility-info/{issuer}/create', [MakerController::class, 'FacilityInfoCreate'])->name('facility-info-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/facility-info/{issuer}/create', [MakerController::class, 'FacilityInfoStore'])->name('facility-info-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/facility-info/{facility}/edit', [MakerController::class, 'FacilityInfoEdit'])->name('facility-info-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/facility-info/{facility}/update', [MakerController::class, 'FacilityInfoUpdate'])->name('facility-info-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/facility-info/{facility}/show', [MakerController::class, 'FacilityInfoShow'])->name('facility-info-m.show')->middleware('permission:DCMTRD');

    // Rating Movement Module
    Route::get('maker/rating-movement/{bond}/create', [MakerController::class, 'RatingMovementCreate'])->name('rating-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/rating-movement/{bond}/create', [MakerController::class, 'RatingMovementStore'])->name('rating-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/rating-movement/{rating}/edit', [MakerController::class, 'RatingMovementEdit'])->name('rating-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/rating-movement/{rating}/update', [MakerController::class, 'RatingMovementUpdate'])->name('rating-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/rating-movement/{rating}/show', [MakerController::class, 'RatingMovementShow'])->name('rating-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/rating-movement/{bond}/upload', [MakerController::class, 'RatingMovementUploadForm'])->name('rating-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/rating-movement/{bond}/upload', [MakerController::class, 'RatingMovementUploadStore'])->name('rating-m.upload-store')->middleware('permission:DCMTRD');

    // Payment Schedule Module
    Route::get('maker/payment-schedule/{bond}/create', [MakerController::class, 'PaymentScheduleCreate'])->name('payment-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/payment-schedule/{bond}/create', [MakerController::class, 'PaymentScheduleStore'])->name('payment-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/payment-schedule/{payment}/edit', [MakerController::class, 'PaymentScheduleEdit'])->name('payment-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/payment-schedule/{payment}/update', [MakerController::class, 'PaymentScheduleUpdate'])->name('payment-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/payment-schedule/{payment}/show', [MakerController::class, 'PaymentScheduleShow'])->name('payment-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/payment-schedule/{bond}/upload', [MakerController::class, 'PaymentScheduleUploadForm'])->name('payment-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/payment-schedule/{bond}/upload', [MakerController::class, 'PaymentScheduleUploadStore'])->name('payment-m.upload-store')->middleware('permission:DCMTRD');

    // Redemption Module
    Route::get('maker/redemption/{bond}/create', [MakerController::class, 'RedemptionCreate'])->name('redemption-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/redemption/{bond}/create', [MakerController::class, 'RedemptionStore'])->name('redemption-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/redemption/{redemption}/edit', [MakerController::class, 'RedemptionEdit'])->name('redemption-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/redemption/{redemption}/update', [MakerController::class, 'RedemptionUpdate'])->name('redemption-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/redemption/{redemption}/show', [MakerController::class, 'RedemptionShow'])->name('redemption-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/redemption/{bond}/upload', [MakerController::class, 'RedemptionUploadForm'])->name('redemption-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/redemption/{bond}/upload', [MakerController::class, 'RedemptionUploadStore'])->name('redemption-m.upload-store')->middleware('permission:DCMTRD');

    // Call Schedule Module
    Route::get('maker/call-schedule/{bond}/create', [MakerController::class, 'CallScheduleCreate'])->name('call-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/call-schedule/{bond}/create', [MakerController::class, 'CallScheduleStore'])->name('call-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/call-schedule/{call}/edit', [MakerController::class, 'CallScheduleEdit'])->name('call-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/call-schedule/{call}/update', [MakerController::class, 'CallScheduleUpdate'])->name('call-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/call-schedule/{call}/show', [MakerController::class, 'CallScheduleShow'])->name('call-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/call-schedule/{bond}/upload', [MakerController::class, 'CallScheduleUploadForm'])->name('call-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/call-schedule/{bond}/upload', [MakerController::class, 'CallScheduleUploadStore'])->name('call-m.upload-store')->middleware('permission:DCMTRD');

    // Lockout Period Module
    Route::get('maker/lockout-period/{bond}/create', [MakerController::class, 'LockoutPeriodCreate'])->name('lockout-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/lockout-period/{bond}/create', [MakerController::class, 'LockoutPeriodStore'])->name('lockout-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/lockout-period/{lockout}/edit', [MakerController::class, 'LockoutPeriodEdit'])->name('lockout-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/lockout-period/{lockout}/update', [MakerController::class, 'LockoutPeriodUpdate'])->name('lockout-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/lockout-period/{lockout}/show', [MakerController::class, 'LockoutPeriodShow'])->name('lockout-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/lockout-period/{bond}/upload', [MakerController::class, 'LockoutPeriodUploadForm'])->name('lockout-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/lockout-period/{bond}/upload', [MakerController::class, 'LockoutPeriodUploadStore'])->name('lockout-m.upload-store')->middleware('permission:DCMTRD');

    // Trading Activity Module
    Route::get('maker/trading-activity/{bond}/create', [MakerController::class, 'TradingActivityCreate'])->name('trading-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/trading-activity/{bond}/create', [MakerController::class, 'TradingActivityStore'])->name('trading-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/trading-activity/{trading}/edit', [MakerController::class, 'TradingActivityEdit'])->name('trading-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/trading-activity/{trading}/update', [MakerController::class, 'TradingActivityUpdate'])->name('trading-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/trading-activity/{trading}/show', [MakerController::class, 'TradingActivityShow'])->name('trading-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/trading-activity/{bond}/upload', [MakerController::class, 'TradingActivityUploadForm'])->name('trading-m.upload-form')->middleware('permission:DCMTRD');
    Route::post('maker/trading-activity/{bond}/upload', [MakerController::class, 'TradingActivityUploadStore'])->name('trading-m.upload-store')->middleware('permission:DCMTRD');
    
    // Trustee Fee Module
    Route::get('maker/trustee-fee', [MakerController::class, 'TrusteeFeeIndex'])->name('trustee-fee-m.index')->middleware('permission:DCMTRD');
    Route::get('maker/trustee-fee/create', [MakerController::class, 'TrusteeFeeCreate'])->name('trustee-fee-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/trustee-fee/create', [MakerController::class, 'TrusteeFeeStore'])->name('trustee-fee-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/trustee-fee/{trusteeFee}/edit', [MakerController::class, 'TrusteeFeeEdit'])->name('trustee-fee-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/trustee-fee/{trusteeFee}/update', [MakerController::class, 'TrusteeFeeUpdate'])->name('trustee-fee-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/trustee-fee/{trusteeFee}/show', [MakerController::class, 'TrusteeFeeShow'])->name('trustee-fee-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/trustee-fee/{trusteeFee}/submit-for-approval', [MakerController::class, 'SubmitApprovalTrusteeFee'])->name('trustee-fee-m.approval')->middleware('permission:DCMTRD');

    // Compliance Covenant Module
    Route::get('maker/compliance-covenant', [MakerController::class, 'ComplianceIndex'])->name('compliance-covenant-m.index')->middleware('permission:DCMTRD');
    Route::get('maker/compliance-covenant/create', [MakerController::class, 'ComplianceCreate'])->name('compliance-covenant-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/compliance-covenant/create', [MakerController::class, 'ComplianceStore'])->name('compliance-covenant-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/compliance-covenant/{compliance}/edit', [MakerController::class, 'ComplianceEdit'])->name('compliance-covenant-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/compliance-covenant/{compliance}/update', [MakerController::class, 'ComplianceUpdate'])->name('compliance-covenant-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/compliance-covenant/{compliance}/show', [MakerController::class, 'ComplianceShow'])->name('compliance-covenant-m.show')->middleware('permission:DCMTRD');
    Route::get('maker/compliance-covenant/{compliance}/submit-for-approval', [MakerController::class, 'SubmitApprovalCompliance'])->name('compliance-covenant-m.approval')->middleware('permission:DCMTRD');

    // Activity Diary Module
    Route::get('maker/activity-diary', [MakerController::class, 'ActivityIndex'])->name('activity-diary-m.index')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/create', [MakerController::class, 'ActivityCreate'])->name('activity-diary-m.create')->middleware('permission:DCMTRD');
    Route::post('maker/activity-diary/create', [MakerController::class, 'ActivityStore'])->name('activity-diary-m.store')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/{activity}/edit', [MakerController::class, 'ActivityEdit'])->name('activity-diary-m.edit')->middleware('permission:DCMTRD');
    Route::put('maker/activity-diary/{activity}/update', [MakerController::class, 'ActivityUpdate'])->name('activity-diary-m.update')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/{activity}/show', [MakerController::class, 'ActivityShow'])->name('activity-diary-m.show')->middleware('permission:DCMTRD');
    Route::patch('maker/activity-diary/{activity}/status', [MakerController::class, 'ActivityUpdateStatus'])->name('activity-diary-m.update-status')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/by-issuer/{issuerId}', [MakerController::class, 'ActivityGetByIssuer'])->name('activity-diary-m.by-issuer')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/upcoming', [MakerController::class, 'ActivityUpcoming'])->name('activity-diary-m.upcoming')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/export', [MakerController::class, 'ActivityExportActivities'])->name('activity-diary-m.export')->middleware('permission:DCMTRD');
    Route::get('maker/activity-diary/{activity}/submit-for-approval', [MakerController::class, 'SubmitApprovalActivityDiary'])->name('activity-diary-m.approval')->middleware('permission:DCMTRD');

    // Portfolio Module
    Route::get('maker/portfolio', [MakerController::class, 'PortfolioIndex'])->name('portfolio-m.index')->middleware('permission:REITS');
    Route::get('maker/portfolio/create', [MakerController::class, 'PortfolioCreate'])->name('portfolio-m.create')->middleware('permission:REITS');
    Route::post('maker/portfolio/create', [MakerController::class, 'PortfolioStore'])->name('portfolio-m.store')->middleware('permission:REITS');
    Route::get('maker/portfolio/{portfolio}/edit', [MakerController::class, 'PortfolioEdit'])->name('portfolio-m.edit')->middleware('permission:REITS');
    Route::put('maker/portfolio/{portfolio}/update', [MakerController::class, 'PortfolioUpdate'])->name('portfolio-m.update')->middleware('permission:REITS');
    Route::get('maker/portfolio/{portfolio}/show', [MakerController::class, 'PortfolioShow'])->name('portfolio-m.show')->middleware('permission:REITS');
    Route::get('maker/portfolio/{portfolio}/submit-for-approval', [MakerController::class, 'SubmitApprovalPortfolio'])->name('portfolio-m.approval')->middleware('permission:REITS');

    // Financial Module
    Route::get('maker/financial/{portfolio}/', [MakerController::class, 'FinancialIndex'])->name('financial-m.index')->middleware('permission:REITS');
    Route::get('maker/financial/{portfolio}/create', [MakerController::class, 'FinancialCreate'])->name('financial-m.create')->middleware('permission:REITS');
    Route::post('maker/financial/create', [MakerController::class, 'FinancialStore'])->name('financial-m.store')->middleware('permission:REITS');
    Route::get('maker/financial/{financial}/edit', [MakerController::class, 'FinancialEdit'])->name('financial-m.edit')->middleware('permission:REITS');
    Route::put('maker/financial/{financial}/update', [MakerController::class, 'FinancialUpdate'])->name('financial-m.update')->middleware('permission:REITS');
    Route::get('maker/financial/{financial}/show', [MakerController::class, 'FinancialShow'])->name('financial-m.show')->middleware('permission:REITS');
    
    // Property Module
    Route::get('maker/property/{portfolio}/', [MakerController::class, 'PropertyIndex'])->name('property-m.index')->middleware('permission:REITS');
    Route::get('maker/property/{portfolio}/create', [MakerController::class, 'PropertyCreate'])->name('property-m.create')->middleware('permission:REITS');
    Route::post('maker/property/create', [MakerController::class, 'PropertyStore'])->name('property-m.store')->middleware('permission:REITS');
    Route::get('maker/property/{property}/edit', [MakerController::class, 'PropertyEdit'])->name('property-m.edit')->middleware('permission:REITS');
    Route::put('maker/property/{property}/update', [MakerController::class, 'PropertyUpdate'])->name('property-m.update')->middleware('permission:REITS');
    Route::get('maker/property/{property}/show', [MakerController::class, 'PropertyShow'])->name('property-m.show')->middleware('permission:REITS');

    // Tenant Module
    Route::get('maker/tenant/{property}/', [MakerController::class, 'TenantIndex'])->name('tenant-m.index')->middleware('permission:REITS');
    Route::get('maker/tenant/{property}/create', [MakerController::class, 'TenantCreate'])->name('tenant-m.create')->middleware('permission:REITS');
    Route::post('maker/tenant/create', [MakerController::class, 'TenantStore'])->name('tenant-m.store')->middleware('permission:REITS');
    Route::get('maker/tenant/{tenant}/edit', [MakerController::class, 'TenantEdit'])->name('tenant-m.edit')->middleware('permission:REITS');
    Route::put('maker/tenant/{tenant}/update', [MakerController::class, 'TenantUpdate'])->name('tenant-m.update')->middleware('permission:REITS');
    Route::get('maker/tenant/{tenant}/show', [MakerController::class, 'TenantShow'])->name('tenant-m.show')->middleware('permission:REITS');

    // Lease Module
    Route::get('maker/lease/{property}/', [MakerController::class, 'LeaseIndex'])->name('lease-m.index')->middleware('permission:REITS');
    Route::get('maker/lease/{property}/create', [MakerController::class, 'LeaseCreate'])->name('lease-m.create')->middleware('permission:REITS');
    Route::post('maker/lease/create', [MakerController::class, 'LeaseStore'])->name('lease-m.store')->middleware('permission:REITS');
    Route::get('maker/lease/{lease}/edit', [MakerController::class, 'LeaseEdit'])->name('lease-m.edit')->middleware('permission:REITS');
    Route::put('maker/lease/{lease}/update', [MakerController::class, 'LeaseUpdate'])->name('lease-m.update')->middleware('permission:REITS');
    Route::get('maker/lease/{lease}/show', [MakerController::class, 'LeaseShow'])->name('lease-m.show')->middleware('permission:REITS');

    // Site Visit Module
    Route::get('maker/site-visit/{property}/', [MakerController::class, 'SiteVisitIndex'])->name('site-visit-m.index')->middleware('permission:REITS');
    Route::get('maker/site-visit/{property}/create', [MakerController::class, 'SiteVisitCreate'])->name('site-visit-m.create')->middleware('permission:REITS');
    Route::post('maker/site-visit/create', [MakerController::class, 'SiteVisitStore'])->name('site-visit-m.store')->middleware('permission:REITS');
    Route::get('maker/site-visit/{siteVisit}/edit', [MakerController::class, 'SiteVisitEdit'])->name('site-visit-m.edit')->middleware('permission:REITS');
    Route::put('maker/site-visit/{siteVisit}/update', [MakerController::class, 'SiteVisitUpdate'])->name('site-visit-m.update')->middleware('permission:REITS');
    Route::get('maker/site-visit/{siteVisit}/show', [MakerController::class, 'SiteVisitShow'])->name('site-visit-m.show')->middleware('permission:REITS');
    
    // Checklist Module
    Route::get('maker/checklist/{property}/', [MakerController::class, 'ChecklistIndex'])->name('checklist-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist/{property}/create', [MakerController::class, 'ChecklistCreate'])->name('checklist-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist/create', [MakerController::class, 'ChecklistStore'])->name('checklist-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist/{checklist}/edit', [MakerController::class, 'ChecklistEdit'])->name('checklist-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist/{checklist}/update', [MakerController::class, 'ChecklistUpdate'])->name('checklist-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist/{checklist}/show', [MakerController::class, 'ChecklistShow'])->name('checklist-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist/{checklist}/submission-legal', [MakerController::class, 'ChecklistSubmissionLegal'])->name('checklist-m.submission-legal')->middleware('permission:REITS');

    // Checklist Legal Documentation Module
    Route::get('maker/checklist-legal-documentation/{checklist}/', [MakerController::class, 'ChecklistLegalDocumentationIndex'])->name('checklist-legal-documentation-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist-legal-documentation/{checklist}/create', [MakerController::class, 'ChecklistLegalDocumentationCreate'])->name('checklist-legal-documentation-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist-legal-documentation/create', [MakerController::class, 'ChecklistLegalDocumentationStore'])->name('checklist-legal-documentation-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist-legal-documentation/{legalDocumentation}/edit', [MakerController::class, 'ChecklistLegalDocumentationEdit'])->name('checklist-legal-documentation-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist-legal-documentation/{legalDocumentation}/update', [MakerController::class, 'ChecklistLegalDocumentationUpdate'])->name('checklist-legal-documentation-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist-legal-documentation/{legalDocumentation}/show', [MakerController::class, 'ChecklistLegalDocumentationShow'])->name('checklist-legal-documentation-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist-legal-documentation/{legalDocumentation}/submission-legal', [MakerController::class, 'ChecklistLegalDocumentationSubmissionLegal'])->name('checklist-legal-documentation-m.submission-legal')->middleware('permission:REITS');

    // Checklist Tenant Module
    Route::get('maker/checklist-tenant/{checklist}/', [MakerController::class, 'ChecklistTenantIndex'])->name('checklist-tenant-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist-tenant/{checklist}/create', [MakerController::class, 'ChecklistTenantCreate'])->name('checklist-tenant-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist-tenant/create', [MakerController::class, 'ChecklistTenantStore'])->name('checklist-tenant-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist-tenant/{checklistTenant}/edit', [MakerController::class, 'ChecklistTenantEdit'])->name('checklist-tenant-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist-tenant/{checklistTenant}/update', [MakerController::class, 'ChecklistTenantUpdate'])->name('checklist-tenant-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist-tenant/{checklistTenant}/show', [MakerController::class, 'ChecklistTenantShow'])->name('checklist-tenant-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist-tenant/{checklistTenant}/submission-legal', [MakerController::class, 'ChecklistTenantSubmissionLegal'])->name('checklist-tenant-m.submission-legal')->middleware('permission:REITS');

    // Checklist External Area Condition Module
    Route::get('maker/checklist-external-area-condition/{checklist}/', [MakerController::class, 'ChecklistExternalAreaConditionIndex'])->name('checklist-external-area-condition-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist-external-area-condition/{checklist}/create', [MakerController::class, 'ChecklistExternalAreaConditionCreate'])->name('checklist-external-area-condition-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist-external-area-condition/create', [MakerController::class, 'ChecklistExternalAreaConditionStore'])->name('checklist-external-area-condition-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist-external-area-condition/{checklistExternalAreaCondition}/edit', [MakerController::class, 'ChecklistExternalAreaConditionEdit'])->name('checklist-external-area-condition-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist-external-area-condition/{checklistExternalAreaCondition}/update', [MakerController::class, 'ChecklistExternalAreaConditionUpdate'])->name('checklist-external-area-condition-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist-external-area-condition/{checklistExternalAreaCondition}/show', [MakerController::class, 'ChecklistExternalAreaConditionShow'])->name('checklist-external-area-condition-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist-external-area-condition/{checklistExternalAreaCondition}/submission-legal', [MakerController::class, 'ChecklistExternalAreaConditionSubmissionLegal'])->name('checklist-external-area-condition-m.submission-legal')->middleware('permission:REITS');

    // Checklist Internal Area Condition Module
    Route::get('maker/checklist-internal-area-condition/{checklist}/', [MakerController::class, 'ChecklistInternalAreaConditionIndex'])->name('checklist-internal-area-condition-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist-internal-area-condition/{checklist}/create', [MakerController::class, 'ChecklistInternalAreaConditionCreate'])->name('checklist-internal-area-condition-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist-internal-area-condition/create', [MakerController::class, 'ChecklistInternalAreaConditionStore'])->name('checklist-internal-area-condition-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist-internal-area-condition/{checklistInternalAreaCondition}/edit', [MakerController::class, 'ChecklistInternalAreaConditionEdit'])->name('checklist-internal-area-condition-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist-internal-area-condition/{checklistInternalAreaCondition}/update', [MakerController::class, 'ChecklistInternalAreaConditionUpdate'])->name('checklist-internal-area-condition-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist-internal-area-condition/{checklistInternalAreaCondition}/show', [MakerController::class, 'ChecklistInternalAreaConditionShow'])->name('checklist-internal-area-condition-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist-internal-area-condition/{checklistInternalAreaCondition}/submission-legal', [MakerController::class, 'ChecklistInternalAreaConditionSubmissionLegal'])->name('checklist-internal-area-condition-m.submission-legal')->middleware('permission:REITS');

    // Checklist Property Development Module
    Route::get('maker/checklist-property-development/{checklist}/', [MakerController::class, 'ChecklistPropertyDevelopmentIndex'])->name('checklist-property-development-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist-property-development/{checklist}/create', [MakerController::class, 'ChecklistPropertyDevelopmentCreate'])->name('checklist-property-development-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist-property-development/create', [MakerController::class, 'ChecklistPropertyDevelopmentStore'])->name('checklist-property-development-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist-property-development/{checklistPropertyDevelopment}/edit', [MakerController::class, 'ChecklistPropertyDevelopmentEdit'])->name('checklist-property-development-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist-property-development/{checklistPropertyDevelopment}/update', [MakerController::class, 'ChecklistPropertyDevelopmentUpdate'])->name('checklist-property-development-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist-property-development/{checklistPropertyDevelopment}/show', [MakerController::class, 'ChecklistPropertyDevelopmentShow'])->name('checklist-property-development-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist-property-development/{checklistPropertyDevelopment}/submission-legal', [MakerController::class, 'ChecklistPropertyDevelopmentSubmissionLegal'])->name('checklist-property-development-m.submission-legal')->middleware('permission:REITS');

    // Checklist Disposal Installation
    Route::get('maker/checklist-disposal-installation/{checklist}/', [MakerController::class, 'ChecklistDisposalInstallationIndex'])->name('checklist-disposal-installation-m.index')->middleware('permission:REITS');
    Route::get('maker/checklist-disposal-installation/{checklist}/create', [MakerController::class, 'ChecklistDisposalInstallationCreate'])->name('checklist-disposal-installation-m.create')->middleware('permission:REITS');
    Route::post('maker/checklist-disposal-installation/create', [MakerController::class, 'ChecklistDisposalInstallationStore'])->name('checklist-disposal-installation-m.store')->middleware('permission:REITS');
    Route::get('maker/checklist-disposal-installation/{checklistDisposalInstallation}/edit', [MakerController::class, 'ChecklistDisposalInstallationEdit'])->name('checklist-disposal-installation-m.edit')->middleware('permission:REITS');
    Route::put('maker/checklist-disposal-installation/{checklistDisposalInstallation}/update', [MakerController::class, 'ChecklistDisposalInstallationUpdate'])->name('checklist-disposal-installation-m.update')->middleware('permission:REITS');
    Route::get('maker/checklist-disposal-installation/{checklistDisposalInstallation}/show', [MakerController::class, 'ChecklistDisposalInstallationShow'])->name('checklist-disposal-installation-m.show')->middleware('permission:REITS');
    Route::get('maker/checklist-disposal-installation/{checklistDisposalInstallation}/submission-legal', [MakerController::class, 'ChecklistDisposalInstallationSubmissionLegal'])->name('checklist-disposal-installation-m.submission-legal')->middleware('permission:REITS');
    
    // Appointment Module
    Route::get('maker/appointment/', [MakerController::class, 'AppointmentIndex'])->name('appointment-m.index')->middleware('permission:REITS');
    Route::get('maker/appointment/create', [MakerController::class, 'AppointmentCreate'])->name('appointment-m.create')->middleware('permission:REITS');
    Route::post('maker/appointment/create', [MakerController::class, 'AppointmentStore'])->name('appointment-m.store')->middleware('permission:REITS');
    Route::get('maker/appointment/{appointment}/edit', [MakerController::class, 'AppointmentEdit'])->name('appointment-m.edit')->middleware('permission:REITS');
    Route::put('maker/appointment/{appointment}/update', [MakerController::class, 'AppointmentUpdate'])->name('appointment-m.update')->middleware('permission:REITS');
    Route::get('maker/appointment/{appointment}/show', [MakerController::class, 'AppointmentShow'])->name('appointment-m.show')->middleware('permission:REITS');
    Route::get('maker/appointment/{appointment}/submit-for-approval', [MakerController::class, 'SubmitApprovalAppointment'])->name('appointment-m.approval')->middleware('permission:REITS');

    // Approval Form Module
    Route::get('maker/approval-form/', [MakerController::class, 'ApprovalFormIndex'])->name('approval-form-m.index')->middleware('permission:REITS');
    Route::get('maker/approval-form/create', [MakerController::class, 'ApprovalFormCreate'])->name('approval-form-m.create')->middleware('permission:REITS');
    Route::post('maker/approval-form/create', [MakerController::class, 'ApprovalFormStore'])->name('approval-form-m.store')->middleware('permission:REITS');
    Route::get('maker/approval-form/{approvalForm}/edit', [MakerController::class, 'ApprovalFormEdit'])->name('approval-form-m.edit')->middleware('permission:REITS');
    Route::put('maker/approval-form/{approvalForm}/update', [MakerController::class, 'ApprovalFormUpdate'])->name('approval-form-m.update')->middleware('permission:REITS');
    Route::get('maker/approval-form/{approvalForm}/show', [MakerController::class, 'ApprovalFormShow'])->name('approval-form-m.show')->middleware('permission:REITS');
    Route::get('maker/approval-form/{approvalForm}/submit-for-approval', [MakerController::class, 'SubmitApprovalForm'])->name('approval-form-m.approval')->middleware('permission:REITS');

    // Approval Form Module
    Route::get('maker/approval-property/', [MakerController::class, 'ApprovalPropertyIndex'])->name('approval-property-m.index')->middleware('permission:REITS');
    Route::get('maker/approval-property/create', [MakerController::class, 'ApprovalPropertyCreate'])->name('approval-property-m.create')->middleware('permission:REITS');
    Route::post('maker/approval-property/create', [MakerController::class, 'ApprovalPropertyStore'])->name('approval-property-m.store')->middleware('permission:REITS');
    Route::get('maker/approval-property/{approvalProperty}/edit', [MakerController::class, 'ApprovalPropertyEdit'])->name('approval-property-m.edit')->middleware('permission:REITS');
    Route::put('maker/approval-property/{approvalProperty}/update', [MakerController::class, 'ApprovalPropertyUpdate'])->name('approval-property-m.update')->middleware('permission:REITS');
    Route::get('maker/approval-property/{approvalProperty}/show', [MakerController::class, 'ApprovalPropertyShow'])->name('approval-property-m.show')->middleware('permission:REITS');
    Route::get('maker/approval-property/{approvalProperty}/submit-for-approval', [MakerController::class, 'SubmitApprovalProperty'])->name('approval-property-m.approval')->middleware('permission:REITS');

    // Site Visit Log Module
    Route::get('maker/site-visit-log/', [MakerController::class, 'SiteVisitLogIndex'])->name('site-visit-log-m.index')->middleware('permission:REITS');
    Route::get('maker/site-visit-log/create', [MakerController::class, 'SiteVisitLogCreate'])->name('site-visit-log-m.create')->middleware('permission:REITS');
    Route::post('maker/site-visit-log/create', [MakerController::class, 'SiteVisitLogStore'])->name('site-visit-log-m.store')->middleware('permission:REITS');
    Route::get('maker/site-visit-log/{siteVisitLog}/edit', [MakerController::class, 'SiteVisitLogEdit'])->name('site-visit-log-m.edit')->middleware('permission:REITS');
    Route::put('maker/site-visit-log/{siteVisitLog}/update', [MakerController::class, 'SiteVisitLogUpdate'])->name('site-visit-log-m.update')->middleware('permission:REITS');
    Route::get('maker/site-visit-log/{siteVisitLog}/show', [MakerController::class, 'SiteVisitLogShow'])->name('site-visit-log-m.show')->middleware('permission:REITS');
    Route::get('maker/site-visit-log/{siteVisitLog}/follow-up', [MakerController::class, 'SiteVisitLogFollowUp'])->name('site-visit-log-m.follow-up')->middleware('permission:REITS');
});

// Approver routes
Route::middleware(['auth', 'two-factor', 'role:approver'])->group(function () {
    // Dashboard
    Route::get('/approver/dashboard', [ApproverController::class, 'index'])->name('approver.dashboard');

    // Issuer Module
    Route::get('approver/issuer/{issuer}/show', [ApproverController::class, 'IssuerShow'])->name('issuer-a.show')->middleware('permission:DCMTRD');
    Route::post('approver/{issuer}/approve', [ApproverController::class, 'IssuerApprove'])->name('issuer-a.approve')->middleware('permission:DCMTRD');
    Route::post('approver/{issuer}/reject', [ApproverController::class, 'IssuerReject'])->name('issuer-a.reject')->middleware('permission:DCMTRD');
    
    // Bond Module
    Route::get('approver/{issuer}/details', [ApproverController::class, 'BondIndex'])->name('bond-a.details')->middleware('permission:DCMTRD');
    Route::get('approver/bond/{bond}/show', [ApproverController::class, 'BondShow'])->name('bond-a.show')->middleware('permission:DCMTRD');

    // Announcement Module
    Route::get('approver/announcement/{announcement}/show', [ApproverController::class, 'AnnouncementShow'])->name('announcement-a.show')->middleware('permission:DCMTRD');

    // Document Module
    Route::get('approver/document/{document}/show', [ApproverController::class, 'DocumentShow'])->name('document-a.show')->middleware('permission:DCMTRD');

    // Facility Info Module
    Route::get('approver/facility-info/{facility}/show', [ApproverController::class, 'FacilityInfoShow'])->name('facility-info-a.show')->middleware('permission:DCMTRD');

    // Trustee Fee Module
    Route::get('approver/trustee-fee', [ApproverController::class, 'TrusteeFeeIndex'])->name('trustee-fee-a.index')->middleware('permission:DCMTRD');
    Route::get('approver/trustee-fee/{trusteeFee}/show', [ApproverController::class, 'TrusteeFeeShow'])->name('trustee-fee-a.show')->middleware('permission:DCMTRD');
    Route::post('approver/trustee-fee/{trustee_fee}/approve', [ApproverController::class, 'TrusteeFeeApprove'])->name('trustee-fee-a.approve')->middleware('permission:DCMTRD');
    Route::post('approver/trustee-fee/{trustee_fee}/reject', [ApproverController::class, 'TrusteeFeeReject'])->name('trustee-fee-a.reject')->middleware('permission:DCMTRD');

    // Compliance Covenant Module
    Route::get('approver/compliance-covenant', [ApproverController::class, 'ComplianceIndex'])->name('compliance-covenant-a.index')->middleware('permission:DCMTRD');
    Route::get('approver/compliance-covenant/{compliance}/show', [ApproverController::class, 'ComplianceShow'])->name('compliance-covenant-a.show')->middleware('permission:DCMTRD');
    Route::post('approver/compliance-covenant/{compliance}/approve', [ApproverController::class, 'ComplianceApprove'])->name('compliance-covenant-a.approve')->middleware('permission:DCMTRD');
    Route::post('approver/compliance-covenant/{compliance}/reject', [ApproverController::class, 'ComplianceReject'])->name('compliance-covenant-a.reject')->middleware('permission:DCMTRD');

    // Activity Diary Module
    Route::get('approver/activity-diary', [ApproverController::class, 'ActivityIndex'])->name('activity-diary-a.index')->middleware('permission:DCMTRD');
    Route::get('approver/activity-diary/{activity}/show', [ApproverController::class, 'ActivityShow'])->name('activity-diary-a.show')->middleware('permission:DCMTRD');
    Route::patch('approver/activity-diary/{activity}/status', [ApproverController::class, 'ActivityUpdateStatus'])->name('activity-diary-a.update-status')->middleware('permission:DCMTRD');
    Route::get('approver/activity-diary/by-issuer/{issuerId}', [ApproverController::class, 'ActivityGetByIssuer'])->name('activity-diary-a.by-issuer')->middleware('permission:DCMTRD');
    Route::get('approver/activity-diary/upcoming', [ApproverController::class, 'ActivityUpcoming'])->name('activity-diary-a.upcoming')->middleware('permission:DCMTRD');
    Route::get('approver/activity-diary/export', [ApproverController::class, 'ActivityExportActivities'])->name('activity-diary-a.export')->middleware('permission:DCMTRD');
    Route::post('approver/activity-diary/{activity}/approve', [ApproverController::class, 'ActivityApprove'])->name('activity-diary-a.approve')->middleware('permission:DCMTRD');
    Route::post('approver/activity-diary/{activity}/reject', [ApproverController::class, 'ActivityReject'])->name('activity-diary-a.reject')->middleware('permission:DCMTRD');


    // REITS Section

    // Portfolio Module
    Route::get('approver/portfolio', [ApproverController::class, 'PortfolioIndex'])->name('portfolio-a.index')->middleware('permission:REITS');
    Route::get('approver/portfolio/{portfolio}/show', [ApproverController::class, 'PortfolioShow'])->name('portfolio-a.show')->middleware('permission:REITS');
    Route::post('approver/portfolio/{portfolio}/approve', [ApproverController::class, 'PortfolioApprove'])->name('portfolio-a.approve')->middleware('permission:REITS');
    Route::post('approver/portfolio/{portfolio}/reject', [ApproverController::class, 'PortfolioReject'])->name('portfolio-a.reject')->middleware('permission:REITS');

    // Property Module
    Route::get('approver/property/', [ApproverController::class, 'PropertyMain'])->name('property-a.main')->middleware('permission:REITS');
    Route::get('approver/property/{property}/details', [ApproverController::class, 'PropertyDetails'])->name('property-a.details')->middleware('permission:REITS');
    Route::post('approver/property/{property}/approve', [ApproverController::class, 'PropertyApprove'])->name('property-a.approve')->middleware('permission:REITS');
    Route::post('approver/property/{property}/reject', [ApproverController::class, 'PropertyReject'])->name('property-a.reject')->middleware('permission:REITS');
    Route::get('approver/property/{portfolio}', [ApproverController::class, 'PropertyIndex'])->name('property-a.index')->middleware('permission:REITS');
    Route::get('approver/property/{property}/show', [ApproverController::class, 'PropertyShow'])->name('property-a.show')->middleware('permission:REITS');

    // Financial Module
    Route::get('approver/financial/', [ApproverController::class, 'FinancialMain'])->name('financial-a.main')->middleware('permission:REITS');
    Route::get('approver/financial/{financial}/details', [ApproverController::class, 'FinancialDetails'])->name('financial-a.details')->middleware('permission:REITS');
    Route::post('approver/financial/{financial}/approve', [ApproverController::class, 'FinancialApprove'])->name('financial-a.approve')->middleware('permission:REITS');
    Route::post('approver/financial/{financial}/reject', [ApproverController::class, 'FinancialReject'])->name('financial-a.reject')->middleware('permission:REITS');
    Route::get('approver/financial/{financial}', [ApproverController::class, 'FinancialIndex'])->name('financial-a.index')->middleware('permission:REITS');
    Route::get('approver/financial/{financial}/show', [ApproverController::class, 'FinancialShow'])->name('financial-a.show')->middleware('permission:REITS');

    // Tenant Module
    Route::get('approver/tenant/{property}', [ApproverController::class, 'TenantIndex'])->name('tenant-a.index')->middleware('permission:REITS');
    Route::get('approver/tenant/{tenant}/show', [ApproverController::class, 'TenantShow'])->name('tenant-a.show')->middleware('permission:REITS');
    Route::get('approver/tenant/', [ApproverController::class, 'TenantMain'])->name('tenant-a.main')->middleware('permission:REITS');
    Route::get('approver/tenant/{tenant}/details', [ApproverController::class, 'TenantDetails'])->name('tenant-a.details')->middleware('permission:REITS');
    Route::post('approver/tenant/{tenant}/approve', [ApproverController::class, 'TenantApprove'])->name('tenant-a.approve')->middleware('permission:REITS');
    Route::post('approver/tenant/{tenant}/reject', [ApproverController::class, 'TenantReject'])->name('tenant-a.reject')->middleware('permission:REITS');

    // Lease Module
    Route::get('approver/lease/{property}', [ApproverController::class, 'LeaseIndex'])->name('lease-a.index')->middleware('permission:REITS');
    Route::get('approver/lease/{lease}/show', [ApproverController::class, 'LeaseShow'])->name('lease-a.show')->middleware('permission:REITS');

    // SiteVisit Module
    Route::get('approver/site-visit/', [ApproverController::class, 'SiteVisitIndex'])->name('site-visit-a.index')->middleware('permission:REITS');
    Route::get('approver/site-visit/{siteVisit}/show', [ApproverController::class, 'SiteVisitShow'])->name('site-visit-a.show')->middleware('permission:REITS');

    // Checklist Module
    Route::get('approver/checklist/{property}', [ApproverController::class, 'ChecklistIndex'])->name('checklist-a.index')->middleware('permission:REITS');
    Route::get('approver/checklist/{checklist}/show', [ApproverController::class, 'ChecklistShow'])->name('checklist-a.show')->middleware('permission:REITS');

    // Appointment Module
    Route::get('approver/appointment/', [ApproverController::class, 'AppointmentIndex'])->name('appointment-a.index')->middleware('permission:REITS');
    Route::get('approver/appointment/{appointment}/show', [ApproverController::class, 'AppointmentShow'])->name('appointment-a.show')->middleware('permission:REITS');
    Route::post('approver/appointment/{appointment}/approve', [ApproverController::class, 'AppointmentApprove'])->name('appointment-a.approve')->middleware('permission:REITS');
    Route::post('approver/appointment/{appointment}/reject', [ApproverController::class, 'AppointmentReject'])->name('appointment-a.reject')->middleware('permission:REITS');

    // Approval Form Module
    Route::get('approver/approval-form/', [ApproverController::class, 'ApprovalFormIndex'])->name('approval-form-a.index')->middleware('permission:REITS');
    Route::get('approver/approval-form/{approvalForm}/show', [ApproverController::class, 'ApprovalFormShow'])->name('approval-form-a.show')->middleware('permission:REITS');
    Route::post('approver/approval-form/{approvalForm}/approve', [ApproverController::class, 'ApprovalFormApprove'])->name('approval-form-a.approve')->middleware('permission:REITS');
    Route::post('approver/approval-form/{approvalForm}/reject', [ApproverController::class, 'ApprovalFormReject'])->name('approval-form-a.reject')->middleware('permission:REITS');

    // Site Visit Log Module
    Route::get('approver/site-visit-log/', [ApproverController::class, 'SiteVisitLogIndex'])->name('site-visit-log-a.index')->middleware('permission:REITS');
    Route::get('approver/site-visit-log/{siteVisitLog}/show', [ApproverController::class, 'SiteVisitLogShow'])->name('site-visit-log-a.show')->middleware('permission:REITS');
    Route::post('approver/site-visit-log/{siteVisitLog}/approve', [ApproverController::class, 'SiteVisitLogApprove'])->name('site-visit-log-a.approve')->middleware('permission:REITS');
    Route::post('approver/site-visit-log/{siteVisitLog}/reject', [ApproverController::class, 'SiteVisitLogReject'])->name('site-visit-log-a.reject')->middleware('permission:REITS');

    // Approval Property Module
    Route::get('approver/approval-property/', [ApproverController::class, 'ApprovalPropertyIndex'])->name('approval-property-a.index')->middleware('permission:REITS');
    Route::get('approver/approval-property/{approvalProperty}/show', [ApproverController::class, 'ApprovalPropertyShow'])->name('approval-property-a.show')->middleware('permission:REITS');
    Route::post('approver/approval-property/{approvalProperty}/approve', [ApproverController::class, 'ApprovalPropertyApprove'])->name('approval-property-a.approve')->middleware('permission:REITS');
    Route::post('approver/approval-property/{approvalProperty}/reject', [ApproverController::class, 'ApprovalPropertyReject'])->name('approval-property-a.reject')->middleware('permission:REITS');


});
