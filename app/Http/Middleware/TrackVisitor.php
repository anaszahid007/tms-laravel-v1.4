<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Don't track admin or authenticated users for visitor stats
        // (Assuming you only want guests. Remove auth()->check() if you want logged-in users too)
        if ($request->is('admin*') || auth()->check()) {
            return $next($request);
        }

        // 1. Handle Visit Tracking (Once per session)
        if (! Session::has('visitor_id')) {
            $userAgent = $request->header('User-Agent');
            // Fetch Location Data
            $location = \Stevebauman\Location\Facades\Location::get($request->ip());

            $visit = Visit::create([
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'device_type' => $this->getDeviceType($userAgent),
                'browser' => $this->getBrowser($userAgent),
                'platform' => $this->getPlatform($userAgent),
                'referer' => $request->header('referer'),
                'city' => $location ? $location->cityName : null,
                'region' => $location ? $location->regionName : null,
                'country' => $location ? $location->countryName : null,
            ]);

            Session::put('visitor_id', $visit->id);
        }

        // 2. Handle Activity Logging
        $response = $next($request);

        if (Session::has('visitor_id')) {
            $action = $request->isMethod('GET') ? 'page_view' : strtolower($request->method());

            ActivityLog::create([
                'visit_id' => Session::get('visitor_id'),
                'url' => $request->getRequestUri(),
                'action' => $action,
                'metadata' => [
                    'ajax' => $request->ajax(),
                    'secure' => $request->secure(),
                ],
            ]);
        }

        return $response;
    }

    private function getDeviceType($userAgent): string
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $userAgent)) {
            return 'tablet';
        }
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    private function getBrowser($userAgent): string
    {
        if (str_contains($userAgent, 'MSIE')) {
            return 'Internet Explorer';
        }
        if (str_contains($userAgent, 'Firefox')) {
            return 'Firefox';
        }
        if (str_contains($userAgent, 'Chrome')) {
            return 'Chrome';
        }
        if (str_contains($userAgent, 'Safari')) {
            return 'Safari';
        }
        if (str_contains($userAgent, 'Opera')) {
            return 'Opera';
        }

        return 'Other';
    }

    private function getPlatform($userAgent): string
    {
        if (str_contains($userAgent, 'Windows')) {
            return 'Windows';
        }
        if (str_contains($userAgent, 'Macintosh')) {
            return 'macOS';
        }
        if (str_contains($userAgent, 'Linux')) {
            return 'Linux';
        }
        if (str_contains($userAgent, 'Android')) {
            return 'Android';
        }
        if (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) {
            return 'iOS';
        }

        return 'Other';
    }
}
