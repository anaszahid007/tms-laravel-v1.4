<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\BulkEmailController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\MeasurementTemplateController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentAccountController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ShopsController;
use App\Http\Controllers\Admin\SubscriptionApprovalController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\VisitorsController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/shops', [ShopsController::class, 'index'])->name('shops');
    Route::get('/shops/{shop}', [ShopsController::class, 'show'])->name('shops.show');
    Route::post('/shops/{shop}/suspend', [ShopsController::class, 'suspend'])->name('shops.suspend');
    Route::post('/shops/{shop}/activate', [ShopsController::class, 'activate'])->name('shops.activate');
    Route::post('/shops/bulk-action', [ShopsController::class, 'bulkAction'])->name('shops.bulk-action');
    Route::get('/visitors', [VisitorsController::class, 'index'])->name('visitors');
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Reports
    Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');

    // Notifications
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');

    // Subscription Plans
    Route::resource('subscription-plans', SubscriptionPlanController::class);

    // Referral Partners
    Route::post('/referrals/bulk-action', [ReferralController::class, 'bulkAction'])->name('referrals.bulk-action');
    Route::post('/referrals/{partner}/payout', [ReferralController::class, 'payout'])->name('referrals.payout');
    Route::resource('referrals', ReferralController::class)->only(['index', 'store', 'update', 'destroy', 'show']);

    // Subscription Approvals
    Route::get('/subscriptions/pending', [SubscriptionApprovalController::class, 'index'])->name('subscriptions.pending');
    Route::post('/subscriptions/{subscription}/approve', [SubscriptionApprovalController::class, 'approve'])->name('subscriptions.approve');
    Route::post('/subscriptions/{subscription}/reject', [SubscriptionApprovalController::class, 'reject'])->name('subscriptions.reject');

    // Payment Management
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/payments/{payment}/download-proof', [PaymentController::class, 'downloadProof'])->name('payments.download-proof');

    // Payment Accounts
    Route::resource('payment-accounts', PaymentAccountController::class);

    // Bulk Email to Shops
    Route::get('/bulk-email', [BulkEmailController::class, 'create'])->name('bulk-email.create');
    Route::post('/bulk-email/send', [BulkEmailController::class, 'send'])->name('bulk-email.send');
    Route::post('/bulk-email/preview', [BulkEmailController::class, 'preview'])->name('bulk-email.preview');

    // Measurement Templates
    Route::resource('measurement-templates', MeasurementTemplateController::class);
    Route::post('/measurement-templates/{measurementTemplate}/columns', [MeasurementTemplateController::class, 'addColumn'])->name('measurement-templates.add-column');
    Route::put('/measurement-columns/{measurementColumn}', [MeasurementTemplateController::class, 'updateColumn'])->name('measurement-columns.update');
    Route::delete('/measurement-columns/{measurementColumn}', [MeasurementTemplateController::class, 'destroyColumn'])->name('measurement-columns.destroy');

    // Database Backups
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/{filename}/restore', [BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('/backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
});
