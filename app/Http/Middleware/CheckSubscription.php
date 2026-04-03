<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for admin routes
        if ($request->routeIs('admin.*')) {
            return $next($request);
        }

        // Skip for public routes
        if ($request->routeIs(['home', 'about', 'privacy', 'terms', 'pricing', 'contact-us', 'lang.switch'])) {
            return $next($request);
        }

        // Skip for auth routes
        if ($request->routeIs(['login', 'register', 'password.*', 'verification.*'])) {
            return $next($request);
        }

        // Check if user is authenticated
        if (! auth()->check()) {
            return $next($request);
        }

        // Check if user is admin (skip subscription checks)
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Get user's shop
        $shop = auth()->user()->shop;
        if (! $shop) {
            return $next($request);
        }

        // Get subscription status
        $subscriptionStatus = $this->subscriptionService->getSubscriptionStatus($shop);

        // Allow viewing (but not creating) when expired: dashboard, customers/orders/measurements view, profile, subscription
        $allowedExpiredRoutes = [
            'dashboard',
            'shop.subscriptions.index',
            'shop.subscriptions.checkout',
            'shop.subscriptions.store',
            'shop.profile.edit',
            'shop.profile.update',
            'shop.profile.destroy',
            'shop.profile.shop.update',
            'shop.password.update',
            'customers.index',
            'customers.show',
            'customers.search',
            'orders.index',
            'orders.show',
            'measurements.index',
            'measurements.show',
            'measurements.print',
            'customers.measurements.print-latest',
        ];

        // If subscription has expired and route is not allowed, redirect to subscription page
        if ($subscriptionStatus['is_expired'] && ! in_array($request->route()->getName(), $allowedExpiredRoutes)) {
            return redirect()->route('shop.subscriptions.index')
                ->with('error', 'Your subscription has expired. Please renew your subscription to continue using the service.');
        }

        // Share subscription status with all views
        view()->share('subscriptionStatus', $subscriptionStatus);

        return $next($request);
    }
}
