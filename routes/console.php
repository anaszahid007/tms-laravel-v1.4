<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the subscription expiry check to run daily
Schedule::command('subscriptions:check-expiry')->daily();

// Schedule the subscription expiry check to run hourly for testing (remove in production)
Schedule::command('subscriptions:check-expiry')->hourly();