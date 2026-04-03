<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Display a listing of referral partners.
     */
    public function index(Request $request)
    {
        $query = ReferralPartner::withCount('conversions')
            ->withSum('earnings', 'amount');

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('referral_code', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $partners = $query->latest()->paginate(10)->withQueryString();

        return view('admin.referrals.index', compact('partners'));
    }

    /**
     * Store a newly created referral partner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:referral_partners,email',
            'phone' => 'nullable|string|max:20',
            'commission_type' => 'required|in:percentage,fixed',
            'commission_value' => 'required|numeric|min:0',
            'duration_type' => 'required|in:forever,one_time,limited',
            'duration_limit' => 'nullable|integer|min:1',
            'code_suffix' => 'nullable|string|min:3|max:10|alpha_num|unique:referral_partners,referral_code',
        ]);

        // Generate unique code if not provided or append random string
        $code = $validated['code_suffix']
            ? strtoupper($validated['code_suffix'])
            : strtoupper(Str::random(8));

        // Ensure code is unique if we auto-generated it (basic check)
        if (! $validated['code_suffix']) {
            while (ReferralPartner::where('referral_code', $code)->exists()) {
                $code = strtoupper(Str::random(8));
            }
        }

        ReferralPartner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'referral_code' => $code,
            'commission_type' => $validated['commission_type'],
            'commission_value' => $validated['commission_value'],
            'duration_type' => $validated['duration_type'],
            'duration_limit' => $validated['duration_type'] === 'limited' ? ($validated['duration_limit'] ?? null) : null,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Referral Partner created successfully. Code: '.$code);
    }

    /**
     * Update the specified referral partner.
     */
    public function update(Request $request, ReferralPartner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,suspended',
            'commission_type' => 'required|in:percentage,fixed',
            'commission_value' => 'required|numeric|min:0',
        ]);

        $partner->update($validated);

        return redirect()->back()->with('success', 'Partner updated successfully.');
    }

    /**
     * Remove the specified referral partner.
     */
    public function destroy(ReferralPartner $partner)
    {
        $partner->delete();

        return redirect()->back()->with('success', 'Partner deleted successfully.');
    }

    /**
     * Display the specified referral partner.
     */
    public function show(ReferralPartner $partner)
    {
        $partner->load(['conversions.shop.user', 'earnings', 'payouts']);

        return view('admin.referrals.show', compact('partner'));
    }

    /**
     * Handle bulk actions on referral partners.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:referral_partners,id',
            'action' => 'required|in:activate,suspend',
        ]);

        $status = $validated['action'] === 'activate' ? 'active' : 'suspended';

        ReferralPartner::whereIn('id', $validated['ids'])->update(['status' => $status]);

        $message = ucfirst($validated['action']) . 'd ' . count($validated['ids']) . ' partner(s) successfully.';

        return redirect()->back()->with('success', $message);
    }
}
