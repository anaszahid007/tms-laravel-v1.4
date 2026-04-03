<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ReferralConversion;
use App\Models\ReferralPartner;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        if (! Setting::get('allow_registration', true)) {
            abort(403, 'Registration is currently disabled.');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Setting::get('allow_registration', true)) {
            abort(403, 'Registration is currently disabled.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:16', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'shop', // Consistent with migration enum ['shop', 'admin']
        ]);

        $shopName = $request->name."'s Tailor";
        $shop = Shop::create([
            'name' => $shopName,
            'slug' => Str::slug($shopName.'-'.substr($user->id, 0, 8)),
            'user_id' => $user->id,
            'status' => 'trial',
            'subscription_ends_at' => now()->addDays(7), // 7-day trial
        ]);

        // Referral Logic: Check for cookie and link partner
        if ($request->hasCookie('referral_code')) {
            $referralCode = $request->cookie('referral_code');
            $partner = ReferralPartner::where('referral_code', $referralCode)
                ->where('status', 'active')
                ->first();

            if ($partner) {
                // Link shop to partner
                $shop->update(['referral_partner_id' => $partner->id]);

                // Log conversion
                ReferralConversion::create([
                    'referral_partner_id' => $partner->id,
                    'shop_id' => $shop->id,
                    'converted_at' => now(),
                ]);
            }
        }

        // Link user to their shop
        $user->update(['shop_id' => $shop->id]);

        event(new Registered($user));

        // Store email in session for the verification notice
        return redirect()->route('verification.notice')->with('registered_email', $user->email);
    }
}
