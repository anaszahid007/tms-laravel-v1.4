<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureShopIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        // Allow access to logout and notification routes to prevent infinite loops
        if ($request->routeIs('logout', 'account.suspended', 'account.expired', 'contact-us')) {
            return $next($request);
        }

        // Check if individual user account is suspended
        if ($user->is_suspended) {
            return redirect()->route('account.suspended');
        }

        // If user has no shop, skip (likely admin or incomplete setup)
        if (! $user->shop) {
            return $next($request);
        }

        $shop = $user->shop;

        // Check if shop is suspended
        if ($shop && $shop->is_suspended) {
            return redirect()->route('account.suspended');
        }

        // Allow access to subscription/payment routes even if expired
        if ($request->routeIs('subscription.*', 'payments.*', 'profile.*')) {
            return $next($request);
        }

        return $next($request);
    }
}
