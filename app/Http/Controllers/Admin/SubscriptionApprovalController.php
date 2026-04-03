<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Services\ReferralService;
use Illuminate\Http\Request;

class SubscriptionApprovalController extends Controller
{
    /**
     * Display pending subscriptions.
     */
    public function index()
    {
        $pendingSubscriptions = UserSubscription::where('payment_status', 'pending')
            ->with(['user.shop'])
            ->latest()
            ->paginate(15);

        $pendingCount = UserSubscription::where('payment_status', 'pending')->count();

        return view('admin.subscriptions.pending', compact('pendingSubscriptions', 'pendingCount'));
    }

    /**
     * Approve a subscription.
     */
    public function approve(UserSubscription $subscription)
    {
        if ($subscription->payment_status !== 'pending') {
            return redirect()->back()->with('error', 'This subscription has already been processed.');
        }

        // Update subscription status
        $subscription->update([
            'payment_status' => 'approved',
        ]);

        // Update shop subscription end date
        $shop = $subscription->user->shop;
        if ($shop) {
            $shop->update([
                'status' => 'active',
                'subscription_ends_at' => $subscription->ends_at,
            ]);
        }

        // Trigger referral commission (if applicable)
        app(ReferralService::class)->processCommission($subscription);

        return redirect()->back()->with('success', 'Subscription approved successfully!');
    }

    /**
     * Reject a subscription.
     */
    public function reject(Request $request, UserSubscription $subscription)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        if ($subscription->payment_status !== 'pending') {
            return redirect()->back()->with('error', 'This subscription has already been processed.');
        }

        $subscription->update([
            'payment_status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->back()->with('success', 'Subscription rejected. User has been notified.');
    }
}
