@extends('layouts.shop')

@section('header', 'Subscription Plans')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Subscription Status Banner -->
        {{-- @if (isset($subscriptionStatus) && $subscriptionStatus['has_subscription'])
            @if ($subscriptionStatus['is_expiring_soon'])
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-exclamation-triangle text-yellow-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Subscription Expiring Soon</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Your subscription will expire in
                                    @if ($subscriptionStatus['days_until_expiry'] <= 0)
                                        less than 1 day
                                    @else
                                        {{ $subscriptionStatus['days_until_expiry'] }}
                                        {{ Str::plural('day', $subscriptionStatus['days_until_expiry']) }}
                                    @endif
                                    on {{ $subscriptionStatus['subscription']->ends_at->format('M d, Y') }}.
                                </p>
                                <p class="mt-1">Please renew your subscription to avoid service interruption.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($subscriptionStatus['subscription']->status === 'grace')
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-clock text-orange-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-orange-800">In Grace Period</h3>
                            <div class="mt-2 text-sm text-orange-700">
                                <p>Your subscription has expired but you're in a grace period until
                                    {{ $subscriptionStatus['subscription']->grace_period_ends_at->format('M d, Y') }}.</p>
                                <p class="mt-1">Please renew your subscription to continue using premium features.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($subscriptionStatus['is_active'])
                <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-check-circle text-emerald-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-emerald-800">Active Subscription</h3>
                            <div class="mt-2 text-sm text-emerald-700">
                                <p>Your subscription is active and expires on
                                    {{ $subscriptionStatus['subscription']->ends_at->format('M d, Y') }}.</p>
                                <p class="mt-1">Plan:
                                    <strong>{{ $subscriptionStatus['subscription']->plan_name }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-info-circle text-blue-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">No Active Subscription</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>You don't have an active subscription. Choose a plan below to get started.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}

        <!-- Current Status Banner for Pending Payments -->
        @if ($currentSubscription && $currentSubscription->payment_status === 'pending')
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-clock text-yellow-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Payment Verification Pending</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Your payment proof has been submitted successfully. Our team is verifying your payment. You
                                will receive a confirmation within 24 hours.</p>
                            <p class="mt-1 font-semibold">Transaction ID: {{ $currentSubscription->transaction_id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Subscription Plans Header -->
        <div class="text-center mb-10 mt-8">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Ready to <span class="text-indigo-600">Upgrade?</span>
            </h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
                Select the plan that best fits your shop's needs. All paid plans include priority support and advanced
                tracking.
            </p>
        </div>

        <!-- Subscription Plans -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($plans as $plan)
                @php
                    $isPopular = $plan->is_featured;
                    $isFree = $plan->is_free;
                    $isPremium = $plan->price >= 1499; // Simple check for premium styling consistency
                @endphp
                <div
                    class="bg-white rounded-2xl shadow-sm border {{ $isPopular ? 'border-2 border-indigo-600 transform scale-105 shadow-xl relative' : 'border-gray-200 hover:shadow-lg' }} p-8 transition duration-300 flex flex-col h-full">

                    @if ($isPopular)
                        <div class="absolute -top-5 left-0 right-0 flex justify-center">
                            <span class="bg-indigo-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                Most Popular
                            </span>
                        </div>
                    @endif

                    @if ($plan->discount_percentage > 0)
                        <div
                            class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-[10px] font-bold">
                            {{ $plan->discount_percentage }}% OFF
                        </div>
                    @endif

                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-14 h-14 {{ $isPopular ? 'bg-indigo-100 text-indigo-600' : ($isFree ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-600') }} rounded-full mb-6">
                            @if ($isFree)
                                <i class="fa-solid fa-gift text-2xl"></i>
                            @elseif($isPremium)
                                <i class="fa-solid fa-crown text-2xl"></i>
                            @else
                                <i class="fa-solid fa-rocket text-2xl"></i>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>

                        <div class="mt-4 flex items-center justify-center">
                            @if ($isFree)
                                <span class="text-3xl font-extrabold text-gray-900">{{ $plan->duration_days }}</span>
                                <span class="ml-2 text-lg text-gray-500">Days</span>
                            @else
                                <span class="text-3xl font-extrabold text-gray-900">Rs.
                                    {{ number_format($plan->price) }}</span>
                                <span class="ml-2 text-lg text-gray-500">/{{ $plan->duration_days }} Days</span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ $isFree ? 'No credit card required' : 'Billed every ' . $plan->duration_days . ' days' }}
                        </p>
                    </div>

                    <ul class="mt-8 space-y-4 flex-1">
                        @if (is_array($plan->features))
                            @foreach ($plan->features as $feature)
                                <li class="flex items-start">
                                    <i
                                        class="fa-solid fa-check {{ $isPopular ? 'text-indigo-600' : 'text-green-500' }} mt-1 mr-3"></i>
                                    <span class="text-gray-600 text-sm">{{ $feature }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    @if ($isFree)
                        <form method="POST" action="{{ route('shop.subscriptions.store', $plan) }}" class="mt-8">
                            @csrf
                            <button type="submit"
                                class="w-full bg-gray-100 text-gray-900 text-center px-6 py-5 rounded-2xl font-extrabold text-base hover:bg-gray-200 transition-all duration-300 shadow-sm">
                                Start Free Trial
                            </button>
                        </form>
                    @else
                        <a href="{{ route('shop.subscriptions.checkout', $plan) }}"
                            class="mt-8 block w-full {{ $isPopular ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-md hover:shadow-lg' : 'bg-yellow-500 text-white hover:bg-yellow-600' }} text-center px-4 py-3 rounded-2xl font-extrabold text-base transition-all duration-300">
                            {{ $isPremium ? 'Go Premium' : 'Subscribe Now' }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
@endsection
