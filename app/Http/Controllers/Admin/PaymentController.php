<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display pending payments for admin review
     */
    public function index(Request $request)
    {
        $query = Payment::with(['shop.user', 'subscriptionPlan', 'processedBy'])
            ->latest();

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by shop name or transaction ID
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('shop', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $payments = $query->paginate(20)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show payment details
     */
    public function show(Payment $payment)
    {
        $payment->load(['shop.user', 'subscriptionPlan', 'processedBy']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Approve a payment
     */
    public function approve(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payment has already been processed.');
        }

        try {
            $this->subscriptionService->approvePayment($payment, auth()->user(), $request->admin_notes);

            return redirect()->route('admin.payments.index', ['status' => 'approved'])
                ->with('success', 'Payment approved successfully. Subscription activated.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to approve payment: ' . $e->getMessage());
        }
    }

    /**
     * Reject a payment
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payment has already been processed.');
        }

        try {
            $this->subscriptionService->rejectPayment($payment, auth()->user(), $request->admin_notes);

            return redirect()->route('admin.payments.index', ['status' => 'rejected'])
                ->with('success', 'Payment rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reject payment: ' . $e->getMessage());
        }
    }

    /**
     * Download payment proof
     */
    public function downloadProof(Payment $payment)
    {
        if (!$payment->payment_proof_path) {
            abort(404, 'Payment proof not found.');
        }

        $filePath = storage_path('app/public/' . $payment->payment_proof_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'Payment proof file not found.');
        }

        return response()->download($filePath, 'payment-proof-' . $payment->transaction_id . '.jpg');
    }
}