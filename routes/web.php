<?php

use App\Http\Controllers\Public\ContactUsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/privacy', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');
Route::get('/pricing', [PublicController::class, 'pricing'])->name('pricing');
Route::get('/contact-us', [ContactUsController::class, 'show'])->name('contact-us');
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');
Route::get('/account/suspended', [PublicController::class, 'suspended'])->name('account.suspended');
Route::get('/account/expired', [PublicController::class, 'expired'])->name('account.expired');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/shop.php';
