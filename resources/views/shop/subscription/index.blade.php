@extends('layouts.shop')

@section('header', 'Subscription Management')

@section('content')
    <div class="max-w-5xl mx-auto">

        <!-- Current Status -->
        <div class="bg-white rounded-xl shadow-lg border border-indigo-100 overflow-hidden mb-10">
            <div
                class="p-8 flex flex-col md:flex-row items-center justify-between gap-6 bg-gradient-to-r from-indigo-900 to-indigo-800 text-white">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Current Plan:
                        {{ $activeSubscription->plan_name ?? 'Free Trial' }}</h2>
                    <p class="text-indigo-200 flex items-center gap-2">
                        <i class="fa-regular fa-clock"></i>
                        Expires on: <span
                            class="font-bold text-white">{{ $shop->subscription_ends_at ? $shop->subscription_ends_at->format('d M, Y') : 'N/A' }}</span>
                    </p>
                </div>
                <div>
                    @if ($shop->status === 'active')
                        <span
                            class="bg-green-500 text-white px-4 py-2 rounded-full font-bold text-sm uppercase tracking-wide shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> Active
                        </span>
                    @else
                        <span
                            class="bg-red-500 text-white px-4 py-2 rounded-full font-bold text-sm uppercase tracking-wide shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-circle-xmark"></i> Expired
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Available Upgrade Plans</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach ($plans as $plan)
                @php
                    $isYearly = $plan->duration_days >= 365;
                @endphp
                <div
                    class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 border {{ $isYearly ? 'border-indigo-500' : 'border-gray-100' }} overflow-hidden relative flex flex-col">
                    @if ($isYearly || $plan->discount_percentage > 0)
                        <div
                            class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-bl-lg">
                            {{ $plan->discount_percentage > 0 ? 'SAVE ' . $plan->discount_percentage . '%' : 'BEST VALUE' }}
                        </div>
                    @endif

                    @if (!$isYearly)
                        <div class="absolute top-0 left-0 w-full h-2 bg-indigo-500/20"></div>
                    @else
                        <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>
                    @endif

                    <div class="p-8 text-center flex-1">
                        <h4
                            class="text-lg font-semibold {{ $isYearly ? 'text-indigo-600' : 'text-gray-500' }} uppercase tracking-widest">
                            {{ $plan->name }}</h4>
                        <div class="mt-4 mb-6">
                            <span class="text-3xl font-bold text-gray-900">Rs. {{ number_format($plan->price) }}</span>
                            <span class="text-gray-400 text-sm">/ {{ $plan->duration_days }} days</span>
                        </div>

                        <p class="text-gray-500 text-sm mb-6 h-10 overflow-hidden">{{ $plan->description }}</p>

                        <ul class="text-left space-y-3 mb-8 text-gray-600 text-sm mx-auto w-max">
                            @if ($plan->features)
                                @foreach ($plan->features as $feature)
                                    <li class="flex items-center gap-2">
                                        <i class="fa-solid fa-check text-green-500"></i> {{ $feature }}
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="p-8 pt-0 mt-auto">
                        <form action="{{ route('subscription.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit"
                                class="w-full {{ $isYearly ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-500/30' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200' }} font-bold py-3 rounded-xl transition">
                                Choose {{ $plan->name }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
