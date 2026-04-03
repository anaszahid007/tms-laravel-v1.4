<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ShopProfileController extends Controller
{
    /**
     * Display the shop owner's profile form.
     */
    public function edit(Request $request): View
    {
        return view('shop.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the shop owner's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('shop.profile.edit')->with([
            'status' => 'profile-updated',
            'active_tab' => 'personal'
        ]);
    }

    /**
     * Update the shop owner's shop details.
     */
    public function updateShop(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_phone' => ['nullable', 'string', 'max:20'],
            'shop_address' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();
        
        // Update shop details
        if ($user->shop) {
            $user->shop->update([
                'name' => $validated['shop_name'],
                'phone' => $validated['shop_phone'],
                'address' => $validated['shop_address'],
            ]);
        }

        return Redirect::route('shop.profile.edit')->with([
            'status' => 'shop-updated',
            'active_tab' => 'shop'
        ]);
    }

    /**
     * Update the shop owner's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('shop.profile.edit')->with([
            'status' => 'password-updated',
            'active_tab' => 'security'
        ]);
    }

    /**
     * Delete the shop owner's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}