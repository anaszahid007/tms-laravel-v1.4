<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $shop = Auth::user()->shop ?? Auth::user()->ownedShop;

        if (! $shop) {
            // Handle case where user has no shop (maybe redirect to create shop or show empty state)
            return view('shop.dashboard', [
                'totalCustomers' => 0,
                'activeOrders' => 0,
                'monthlyRevenue' => 0,
                'shop' => null,
                'subscriptionStatus' => null,
            ]);
        }

        $totalCustomers = $shop->customers()->count();
        $activeOrders = $shop->orders()->whereIn('status', ['pending', 'in_progress'])->count();

        // Current Month Stats
        $currentMonthStart = now()->startOfMonth();
        $currentMonthRevenue = $shop->orders()
            ->where('created_at', '>=', $currentMonthStart)
            ->sum('total_price');
        $currentMonthOrders = $shop->orders()
            ->where('created_at', '>=', $currentMonthStart)
            ->count();
        $currentMonthCustomers = $shop->customers()
            ->where('created_at', '>=', $currentMonthStart)
            ->count();

        // Last 12 Months Stats
        $last12MonthsStart = now()->subMonths(11)->startOfMonth();
        $last12MonthsRevenue = $shop->orders()
            ->where('created_at', '>=', $last12MonthsStart)
            ->sum('total_price');
        $last12MonthsOrders = $shop->orders()
            ->where('created_at', '>=', $last12MonthsStart)
            ->count();
        $last12MonthsCustomers = $shop->customers()
            ->where('created_at', '>=', $last12MonthsStart)
            ->count();

        // Last 12 Months Monthly Revenue & Orders
        $monthExpr = 'EXTRACT(MONTH FROM created_at)';
        $yearExpr = 'EXTRACT(YEAR FROM created_at)';

        $monthlyTrendRaw = $shop->orders()
            ->selectRaw("{$monthExpr} as month, {$yearExpr} as year, SUM(total_price) as total, COUNT(*) as count")
            ->where('created_at', '>=', $last12MonthsStart)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $yearlyChartData = ['labels' => [], 'values' => [], 'orders' => []];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $m = (int) $date->month;
            $y = (int) $date->year;

            $match = $monthlyTrendRaw->first(fn ($item) => (int) $item->month == $m && (int) $item->year == $y);

            $yearlyChartData['labels'][] = $date->format('M');
            $yearlyChartData['values'][] = (float) ($match ? $match->total : 0);
            $yearlyChartData['orders'][] = (int) ($match ? $match->count : 0);
        }

        // Current Month Daily Revenue & Orders
        $dayExpr = 'EXTRACT(DAY FROM created_at)';
        $dailyTrendRaw = $shop->orders()
            ->selectRaw("{$dayExpr} as day, SUM(total_price) as total, COUNT(*) as count")
            ->where('created_at', '>=', $currentMonthStart)
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $monthlyChartData = ['labels' => [], 'values' => [], 'orders' => []];
        $daysInMonth = now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $match = $dailyTrendRaw->first(fn ($item) => (int) $item->day == $i);

            $monthlyChartData['labels'][] = $i;
            $monthlyChartData['values'][] = (float) ($match ? $match->total : 0);
            $monthlyChartData['orders'][] = (int) ($match ? $match->count : 0);
        }

        // Get subscription status
        $subscriptionStatus = $this->subscriptionService->getSubscriptionStatus($shop);

        return view('shop.dashboard', compact(
            'totalCustomers',
            'activeOrders',
            'currentMonthRevenue',
            'currentMonthOrders',
            'currentMonthCustomers',
            'last12MonthsRevenue',
            'last12MonthsOrders',
            'last12MonthsCustomers',
            'shop',
            'subscriptionStatus',
            'yearlyChartData',
            'monthlyChartData'
        ));
    }
}
