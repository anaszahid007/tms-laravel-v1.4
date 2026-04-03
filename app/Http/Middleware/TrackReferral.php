<?php

namespace App\Http\Middleware;

use App\Models\ReferralPartner;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class TrackReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if 'ref' parameter exists in the URL
        if ($request->has('ref')) {
            $referralCode = $request->query('ref');

            // Verify if the code belongs to a valid partner
            $partner = ReferralPartner::where('referral_code', $referralCode)
                ->where('status', 'active')
                ->first();

            if ($partner) {
                // Store/Update the cookie for 30 days (43200 minutes)
                // Cookie name: 'referral_code'
                Cookie::queue('referral_code', $referralCode, 43200);
            }
        }

        return $next($request);
    }
}
