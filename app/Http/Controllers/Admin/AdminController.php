<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Visit;

class AdminController extends Controller
{
    public function index()
    {
        // Stats
        $totalShops = Shop::count();
        $activeShops = Shop::where('status', 'active')->count();
        $totalVisitors = Visit::count();
        $recentShops = Shop::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalShops', 'activeShops', 'totalVisitors', 'recentShops'));
    }
}
