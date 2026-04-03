@extends('layouts.public')

@section('content')
    <div class="relative overflow-hidden w-full">
        <!-- Hero Section -->
        <div class="relative w-full pt-16 pb-20 sm:pt-24 sm:pb-32 lg:pb-40 overflow-hidden">
            <div class="relative mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-6xl">
                            Modernize Your <span class="text-indigo-600">Tailoring Business</span>
                        </h1>
                        <p class="mt-4 text-xl text-gray-500">
                            Manage measurements, orders, and customers in one place. Say goodbye to paper receipts and messy
                            notebooks.
                        </p>
                        <div class="mt-10 flex gap-4 justify-center lg:justify-start">
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Start Free Trial') }}
                            </a>
                            <a href="#"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Learn More
                            </a>
                        </div>
                    </div>

                    <!-- Decorative Visual with Enhanced Animations -->
                    <div class="relative mt-10 lg:mt-0" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
                        <div
                            class="relative bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl p-6 sm:p-8 overflow-hidden">
                            <!-- Animated Background Decoration -->
                            <div class="absolute inset-0 overflow-hidden">
                                <div
                                    class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-200 rounded-full opacity-30 animate-pulse">
                                </div>
                                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-purple-200 rounded-full opacity-30 animate-pulse"
                                    style="animation-delay: 1s;"></div>
                            </div>

                            <!-- Floating Cards Container -->
                            <div class="relative grid grid-cols-1 sm:grid-cols-2 gap-4 w-full max-w-md mx-auto">
                                <!-- Customer Card with Staggered Animation -->
                                <div x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-100"
                                    x-transition:enter-start="opacity-0 translate-y-8"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="bg-white p-5 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                                    <div class="flex flex-col items-center text-center">
                                        <div
                                            class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fa-solid fa-users text-indigo-600 text-2xl animate-bounce"
                                                style="animation-duration: 2s;"></i>
                                        </div>
                                        <div class="w-full space-y-2">
                                            <div class="h-3 bg-gradient-to-r from-indigo-200 to-indigo-100 rounded-full">
                                            </div>
                                            <div class="h-2 w-3/4 bg-indigo-50 rounded-full mx-auto"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order/Shirt Card with Staggered Animation -->
                                <div x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-300"
                                    x-transition:enter-start="opacity-0 translate-y-8"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="bg-white p-5 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                                    <div class="flex flex-col items-center text-center">
                                        <div
                                            class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fa-solid fa-shirt text-emerald-600 text-2xl animate-bounce"
                                                style="animation-duration: 2s; animation-delay: 0.5s;"></i>
                                        </div>
                                        <div class="w-full space-y-2">
                                            <div class="h-3 bg-gradient-to-r from-emerald-200 to-emerald-100 rounded-full">
                                            </div>
                                            <div class="h-2 w-3/4 bg-emerald-50 rounded-full mx-auto"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Large Order Details Card -->
                                <div x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-500"
                                    x-transition:enter-start="opacity-0 translate-y-8"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="col-span-1 sm:col-span-2 bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 group">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="h-3 w-40 bg-gradient-to-r from-gray-200 to-gray-100 rounded-full"></div>
                                        <div
                                            class="h-7 w-20 bg-gradient-to-r from-indigo-100 to-indigo-50 rounded-full flex items-center justify-center">
                                            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-pulse"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                            <div
                                                class="h-full w-2/3 bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full animate-pulse">
                                            </div>
                                        </div>
                                        <div class="h-2 w-5/6 bg-gray-50 rounded-full"></div>
                                        <div class="h-2 w-4/6 bg-gray-50 rounded-full"></div>
                                    </div>

                                    <!-- Animated Progress Indicator -->
                                    <div class="mt-4 flex gap-2">
                                        <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce"
                                            style="animation-delay: 0s;"></div>
                                        <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce"
                                            style="animation-delay: 0.2s;"></div>
                                        <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce"
                                            style="animation-delay: 0.4s;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div id="features" class="bg-white w-full py-24">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-indigo-600 text-2xl">
                            <i class="fa-solid fa-ruler-combined"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Digital Measurements</h3>
                        <p class="text-gray-500">Save detailed body measurements and access them instantly anytime.</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-pink-600 text-2xl">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">SMS Notifications</h3>
                        <p class="text-gray-500">Automatically notify customers when their order is ready (Coming Soon).</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-green-600 text-2xl">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Expense Tracking</h3>
                        <p class="text-gray-500">Keep track of your earnings and expenses with our built-in reports.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Section -->
        <div id="pricing" class="bg-gray-50 w-full py-24">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        {{ __('Simple, Transparent Pricing') }}
                    </h2>
                    <p class="mt-4 text-xl text-gray-500">
                        {{ __("Choose the plan that's right for your tailoring business") }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($plans as $plan)
                        @php
                            $isPopular = $plan->price > 0 && $plans->count() > 1 && $loop->iteration == 2;
                            $isFree = $plan->price == 0;
                            $isPremium = $plan->price >= 1499;
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
                                    @elseif($isPremium)
                                        <i class="fa-solid fa-crown text-xl"></i>
                                    @else
                                        <i class="fa-solid fa-rocket text-xl"></i>
                                    @endif
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                                <div class="mt-4 flex items-center justify-center">
                                    @if ($isFree)
                                        <span
                                            class="text-3xl font-extrabold text-gray-900">{{ $plan->duration_days }}</span>
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

                            <ul class="mt-8 space-y-4 flex-1">
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
                                class="mt-8 block w-full {{ $isPopular ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-md hover:shadow-lg' : ($isFree ? 'bg-gray-100 text-gray-900 hover:bg-gray-200' : ($isPremium ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-indigo-500 text-white hover:bg-indigo-600')) }} text-center px-4 py-3 rounded-2xl font-extrabold text-base transition-all duration-300">
                                {{ $isFree ? __('Start Free Trial') : ($isPremium ? __('Go Premium') : __('Get Started')) }}
                            </a>
                        </div>
                    @endforeach
                </div>

                <p class="text-center text-gray-500 mt-12 text-sm">
                    All plans include a 7-day free trial. No credit card required. Cancel anytime.
                </p>
            </div>
        </div>

    </div>
@endsection
