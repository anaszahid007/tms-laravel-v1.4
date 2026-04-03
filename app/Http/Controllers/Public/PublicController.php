<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;

class PublicController extends Controller
{
    public function home()
    {
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('price')->get();
        return view('public.home', compact('plans'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact-us');
    }

    public function privacy()
    {
        return view('public.privacy');
    }

    public function terms()
    {
        return view('public.terms');
    }

    public function pricing()
    {
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('price')->get();
        return view('public.pricing', compact('plans'));
    }

    public function suspended()
    {
        return view('public.suspended');
    }

    public function expired()
    {
        return view('public.expired');
    }
}

