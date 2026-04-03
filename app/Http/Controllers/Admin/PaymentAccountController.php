<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = PaymentAccount::orderBy('priority', 'asc')->get();
        return view('admin.payment_accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider' => 'required|string|max:255',
            'account_title' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PaymentAccount::create($validated);

        return redirect()->route('admin.payment-accounts.index')
            ->with('success', 'Payment account created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentAccount $paymentAccount)
    {
        return view('admin.payment_accounts.edit', compact('paymentAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentAccount $paymentAccount)
    {
        $validated = $request->validate([
            'provider' => 'required|string|max:255',
            'account_title' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $paymentAccount->update($validated);

        return redirect()->route('admin.payment-accounts.index')
            ->with('success', 'Payment account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentAccount $paymentAccount)
    {
        $paymentAccount->delete();

        return redirect()->route('admin.payment-accounts.index')
            ->with('success', 'Payment account deleted successfully.');
    }
}
