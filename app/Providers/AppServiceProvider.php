<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->runningInConsole()) {
            \Illuminate\Support\Facades\View::share('siteSettings', [
                'name' => \App\Models\Setting::get('site_name', 'TailorOnDesk'),
                'email' => \App\Models\Setting::get('contact_email', 'admin@tailorondesk.com'),
                'phone' => \App\Models\Setting::get('contact_phone', '0339842374834'),
            ]);
        }
    }
}
