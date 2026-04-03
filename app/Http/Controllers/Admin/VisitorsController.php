<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;

class VisitorsController extends Controller
{
    public function index()
    {
        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('created_at', today())->count();
        $recentVisits = Visit::latest()->take(20)->get();

        // Location data is now handled by the Visit model accessor and stored in the database.

        return view('admin.visitors.index', compact('totalVisits', 'todayVisits', 'recentVisits'));
    }
}
