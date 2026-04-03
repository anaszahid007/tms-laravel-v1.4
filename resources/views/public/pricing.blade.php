@extends('layouts.public')

@section('content')
    <!-- Full Width Header -->
    <div class="w-full bg-white py-16 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                {{ __('Simple, Transparent') }} <span class="text-indigo-600">{{ __('Pricing') }}</span>
            </h1>
            <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto">
                {{ __("Choose the plan that's right for your tailoring business") }}.
                {{ __('All plans include a 7-day free trial.') }}
            </p>
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @foreach ($plans as $plan)
                    @php
                        $isPopular = $plan->price > 0 && $plans->count() > 1 && $loop->iteration == 2;
                        $isFree = $plan->price == 0;
                    @endphp
                    <!-- Plan Card -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border {{ $isPopular ? 'border-2 border-indigo-600 transform md:scale-105 shadow-xl relative' : 'border-gray-200 hover:shadow-lg' }} p-8 transition duration-300 flex flex-col h-full">

                        @if ($isPopular)
                            <div class="absolute -top-5 left-0 right-0 flex justify-center">
                                <span class="bg-indigo-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                    {{ __('Most Popular') }}
                                </span>
                            </div>
                        @endif

                        <div class="text-center">
                            <div
                                class="inline-flex items-center justify-center w-12 h-12 {{ $isPopular ? 'bg-indigo-100 text-indigo-600' : ($isFree ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-600') }} rounded-full mb-4">
                                @if ($isFree)
                                    <i class="fa-solid fa-gift text-xl"></i>
                                @elseif($isPopular)
                                    <i class="fa-solid fa-rocket text-xl"></i>
                                @else
                                    <i class="fa-solid fa-crown text-xl"></i>
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                            <div class="mt-4 flex items-center justify-center">
                                @if ($isFree)
                                    <span class="text-3xl font-extrabold text-gray-900">{{ $plan->duration_days }}</span>
                                    <span class="ml-2 text-lg text-gray-500">{{ __('days') }}</span>
                                @else
                                    <span class="text-3xl font-extrabold text-gray-900">Rs.
                                        {{ number_format($plan->price) }}</span>
                                    <span class="ml-2 text-lg text-gray-500">/{{ $plan->duration_days }}
                                        {{ __('days') }}</span>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                {{ $isFree ? __('No credit card required') : __('Billed every ' . $plan->duration_days . ' days') }}
                            </p>
                        </div>

                        <ul class="mt-8 space-y-4">
                            @if (is_array($plan->features))
                                @foreach ($plan->features as $feature)
                                    <li class="flex items-start">
                                        <i
                                            class="fa-solid fa-check {{ $isPopular ? 'text-indigo-600' : 'text-green-500' }} mt-1 mr-3"></i>
                                        <span class="text-gray-600">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <a href="{{ route('register') }}"
                            class="mt-auto block w-full {{ $isPopular ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-md hover:shadow-lg' : ($isFree ? 'bg-gray-100 text-gray-900 hover:bg-gray-200' : 'bg-yellow-500 text-white hover:bg-yellow-600') }} text-center px-4 py-3 rounded-2xl font-extrabold text-base transition-all duration-300">
                            {{ $isFree ? __('Start Free Trial') : __('Get Started') }}
                        </a>
                    </div>
                @endforeach
            </div>

            <div class=" bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 mb-4">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Secure Payments</h4>
                        <p class="text-sm text-gray-500 mt-1">Processed with Secure Payments</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 mb-4">
                            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Free Trial</h4>
                        <p class="text-sm text-gray-500 mt-1">7 days for all plans</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 mb-4">
                            <i class="fa-solid fa-ban text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Cancel Anytime</h4>
                        <p class="text-sm text-gray-500 mt-1">No long-term contracts</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 mb-4">
                            <i class="fa-solid fa-headset text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Expert Support</h4>
                        <p class="text-sm text-gray-500 mt-1">We're here to help</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
