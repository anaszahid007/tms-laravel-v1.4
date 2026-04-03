<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopsController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::with(['user', 'subscriptions' => function($q) {
            $q->latest();
        }]);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_suspended', false);
            } elseif ($status === 'suspended') {
                $query->where('is_suspended', true);
            }
        }

        $shops = $query->latest()->paginate(20)->withQueryString();
        
        return view('admin.shops.index', compact('shops'));
    }

    public function show($id)
    {
        $shop = Shop::with(['user', 'customers', 'orders', 'measurements'])->findOrFail($id);
        
        return view('admin.shops.show', compact('shop'));
    }

    public function suspend($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update(['is_suspended' => true]);
        
        return back()->with('success', 'Shop has been suspended successfully.');
    }

    public function activate($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update(['is_suspended' => false]);
        
        return back()->with('success', 'Shop has been activated successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|in:activate,suspend',
        ]);

        $ids = $request->ids;
        $is_suspended = $request->action === 'suspend';

        Shop::whereIn('id', $ids)->update(['is_suspended' => $is_suspended]);

        $message = $is_suspended ? 'Selected shops have been suspended.' : 'Selected shops have been activated.';

        return back()->with('success', $message);
    }
}
