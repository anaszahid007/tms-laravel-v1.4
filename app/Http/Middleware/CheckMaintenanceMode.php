<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('MAINTENACE_MODE', false)) {
            // Allow admin to bypass maintenance mode
            if ($request->user() && $request->user()->isAdmin()) {
                return $next($request);
            }

            // Also allow access to login and admin routes so admin can log in to turn it off
            if ($request->is('login') || $request->is('admin*') || $request->is('logout')) {
                return $next($request);
            }

            return response()->view('public.maintenance', [], 503);
        }

        return $next($request);
    }
}
