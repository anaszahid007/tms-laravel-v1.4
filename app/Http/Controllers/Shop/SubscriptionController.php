<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\PaymentAccount;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display subscription plans.
     */
    public function index()
    {
        $shop = Auth::user()->shop;

        // Check if shop has ever used a free plan
        $hasUsedFreePlan = $shop->subscriptions()
            ->where(function ($query) {
                $query->where('plan_price', 0)
                    ->orWhereHas('subscriptionPlan', function ($q) {
                        $q->where('is_free', true);
                    });
            })
            ->exists();

        // Only show active plans, exclude free plans if already used
        $plans = SubscriptionPlan::where('is_active', true)
            ->when($hasUsedFreePlan, function ($query) {
                return $query->where('is_free', false);
            })
            ->orderBy('price', 'asc')
            ->get();

        $currentSubscription = $shop->currentSubscription();
        $subscriptionStatus = $this->subscriptionService->getSubscriptionStatus($shop);

        return view('shop.subscriptions.index', compact('plans', 'currentSubscription', 'subscriptionStatus'));
    }

    /**
     * Show checkout page for a specific plan.
     */
    public function checkout(SubscriptionPlan $plan)
    {
        if (! $plan->is_active) {
            abort(404, 'This plan is not available.');
        }

        $shop = Auth::user()->shop;
        
        // Check if shop already has an active subscription for this plan
        $existingSubscription = $shop->subscriptions()
            ->where('subscription_plan_id', $plan->id)
            ->where('status', 'active')
            ->exists();

        if ($existingSubscription) {
            return redirect()->route('shop.subscriptions.index')
                ->with('info', 'You already have an active subscription for this plan.');
        }

        $paymentAccounts = PaymentAccount::active()->get();

        return view('shop.subscriptions.checkout', compact('plan', 'paymentAccounts'));
    }

    /**
     * Store payment proof submission or activate free plan.
     */
    public function store(Request $request, SubscriptionPlan $plan)
    {
        if (! $plan->is_active) {
            abort(404, 'This plan is not available.');
        }

        $shop = Auth::user()->shop;

        // Handle free plans
        if ($plan->is_free) {
            try {
                // Check if shop has already used a free plan
                $hasUsedFreePlan = $shop->subscriptions()
                    ->where(function ($query) {
                        $query->where('plan_price', 0)
                            ->orWhereHas('subscriptionPlan', function ($q) {
                                $q->where('is_free', true);
                            });
                    })
                    ->exists();

                if ($hasUsedFreePlan) {
                    return redirect()->route('shop.subscriptions.index')
                        ->with('error', 'You have already used a free trial plan.');
                }

                // Check if shop already has an active subscription
                if ($shop->hasActiveSubscription()) {
                    return redirect()->route('shop.subscriptions.index')
                        ->with('info', 'You already have an active subscription.');
                }

                // Create free subscription immediately
                $this->subscriptionService->createFreeSubscription($shop, $plan);

                return redirect()->route('shop.subscriptions.index')
                    ->with('success', 'Free plan activated successfully!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Failed to activate free plan. Please try again.');
            }
        }

        // Handle paid plans with payment proof
        $validated = $request->validate([
            'transaction_id' => 'required|string|max:255',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if shop already has a pending payment for this plan
        $existingPayment = $shop->payments()
            ->where('subscription_plan_id', $plan->id)
            ->where('status', 'pending')
            ->exists();

        if ($existingPayment) {
            return redirect()->route('shop.subscriptions.index')
                ->with('info', 'You already have a pending payment for this plan. Please wait for approval.');
        }

        // Store the uploaded image
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        try {
            // Create payment and temporary subscription
            $payment = $this->subscriptionService->createPayment($shop, $plan, [
                'payment_proof_path' => $proofPath,
                'transaction_id' => $validated['transaction_id'],
                'shop_notes' => $validated['notes'] ?? null,
            ]);

            return redirect()->route('shop.subscriptions.index')
                ->with('success', 'Payment proof submitted successfully! We will verify and activate your subscription within 24 hours. You have temporary access for 48 hours while we review your payment.');
        } catch (\Exception $e) {
            // Delete the uploaded file if payment creation failed
            if (isset($proofPath)) {
                \Storage::disk('public')->delete($proofPath);
            }

            return redirect()->back()
                ->with('error', 'Failed to submit payment. Please try again.')
                ->withInput();
        }
    }
}