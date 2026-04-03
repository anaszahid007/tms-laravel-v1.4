<?php

use App\Http\Controllers\Shop\CustomerController;
use App\Http\Controllers\Shop\DashboardController;
use App\Http\Controllers\Shop\MeasurementController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Shop\ShopProfileController;
use App\Http\Controllers\Shop\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Shop
Route::middleware(['auth', 'verified', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ShopProfileController::class, 'edit'])->name('shop.profile.edit');
    Route::patch('/profile', [ShopProfileController::class, 'update'])->name('shop.profile.update');
    Route::delete('/profile', [ShopProfileController::class, 'destroy'])->name('shop.profile.destroy');
    Route::patch('/profile/shop', [ShopProfileController::class, 'updateShop'])->name('shop.profile.shop.update');
    Route::put('/password', [ShopProfileController::class, 'updatePassword'])->name('shop.password.update');

    // Customer Routes
    Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::resource('customers', CustomerController::class);

    // Measurement Routes
    Route::resource('measurements', MeasurementController::class);
    Route::get('/measurements/{measurement}/print', [MeasurementController::class, 'print'])->name('measurements.print');
    Route::get('/customers/{customer}/measurements/print-latest', [MeasurementController::class, 'printLatest'])->name('customers.measurements.print-latest');
    Route::get('/customers/{customer}/measurements/edit', [MeasurementController::class, 'editForCustomer'])->name('customers.measurements.edit');
    Route::get('/measurements/template-columns/{template}', [MeasurementController::class, 'getTemplateColumns'])->name('measurements.template-columns');

    // Order Routes
    Route::resource('orders', OrderController::class);
    Route::post('orders/bulk-update', [OrderController::class, 'bulkUpdate'])->name('orders.bulk-update');
    // Deprecated, using bulkUpdate now
    // Route::post('orders/bulk-status', [OrderController::class, 'bulkStatusUpdate'])->name('orders.bulk-status');
    // Route::post('orders/bulk-fulfill', [OrderController::class, 'bulkFulfillRemaining'])->name('orders.bulk-fulfill');

    // Subscription
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('shop.subscriptions.index');
    Route::get('/subscriptions/{plan}/checkout', [SubscriptionController::class, 'checkout'])->name('shop.subscriptions.checkout');
    Route::post('/subscriptions/{plan}/submit', [SubscriptionController::class, 'store'])->name('shop.subscriptions.store');
});
