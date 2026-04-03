<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // If user is logged in and already verified, go to dashboard
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // If user is NOT logged in but has a registered email in session (just registered)
        if (!auth()->check() && !session('registered_email')) {
            return redirect()->route('login');
        }

        return view('auth.verify-email');
    }
}
