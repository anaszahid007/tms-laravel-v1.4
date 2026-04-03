<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteSettings['name'] }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logos/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Urdu Font Adjustments */
        html[lang="ur"] {
            font-family: 'Figtree', 'Noto Sans Arabic', sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700&display=swap');
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    @include('partials.alerts')

    <header x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 'bg-white shadow-md': scrolled, 'bg-transparent': !scrolled }"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">

        <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center">
            <!-- Left Side: Logo (flex-1 to push nav to center) -->
            <div class="flex-1 flex items-center gap-2">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <i class="fa-solid fa-scissors text-indigo-600 text-2xl"></i>
                    <span class="text-xl font-bold text-gray-900">{{ $siteSettings['name'] }}</span>
                </a>
            </div>

            <!-- Center: Desktop Navigation (not flex-1, centered naturally) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/') }}"
                    class="font-medium {{ request()->is('/') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600 transition">{{ __('Home') }}</a>
                <a href="{{ route('about') }}"
                    class="font-medium {{ request()->routeIs('about') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600 transition">{{ __('About') }}</a>
                <a href="{{ route('pricing') }}"
                    class="font-medium {{ request()->routeIs('pricing') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600 transition">{{ __('Pricing') }}</a>
                <a href="{{ route('contact-us') }}"
                    class="font-medium {{ request()->routeIs('contact-us') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600 transition">{{ __('Contact') }}</a>
            </div>

            <!-- Right Side: Auth & Language Toggle (flex-1 + justify-end) -->
            <div class="hidden md:flex flex-1 items-center justify-end space-x-4 ml-4">
                <!-- Language Toggle -->
                <div class="flex bg-gray-50 p-1 rounded-xl border border-gray-100">
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        EN
                    </a>
                    <a href="{{ route('lang.switch', 'ur') }}"
                        class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ app()->getLocale() == 'ur' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        اردو
                    </a>
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-600 hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-indigo-600">{{ __('Log in') }}</a>
                        @if (Route::has('register') && \App\Models\Setting::get('allow_registration', true))
                            <a href="{{ route('register') }}"
                                class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">{{ __('Get Started') }}</a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center ml-auto">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                    <i class="fa-solid fa-xmark text-2xl" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden bg-white shadow-lg absolute w-full left-0 border-t border-gray-100" style="display: none;">
            <div class="px-6 py-4 space-y-4 flex flex-col">
                <a href="{{ url('/') }}"
                    class="font-medium {{ request()->is('/') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600">{{ __('Home') }}</a>
                <a href="{{ route('about') }}"
                    class="font-medium {{ request()->routeIs('about') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600">{{ __('About') }}</a>
                <a href="{{ route('pricing') }}"
                    class="font-medium {{ request()->routeIs('pricing') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600">{{ __('Pricing') }}</a>
                <a href="{{ route('contact-us') }}"
                    class="font-medium {{ request()->routeIs('contact-us') ? 'text-indigo-600' : 'text-gray-600' }} hover:text-indigo-600">{{ __('Contact') }}</a>
                <hr class="border-gray-100">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-indigo-600">{{ __('Log in') }}</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 text-center shadow">{{ __('Get Started') }}</a>
                @endauth
                <hr class="border-gray-100">
                <div class="flex items-center gap-3 bg-gray-100 rounded-xl p-1 w-fit">
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-bold rounded-lg transition {{ app()->getLocale() == 'en' ? 'bg-white shadow text-indigo-600' : 'text-gray-500' }}">
                        <span>🇺🇸</span> English
                    </a>
                    <a href="{{ route('lang.switch', 'ur') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-bold rounded-lg transition {{ app()->getLocale() == 'ur' ? 'bg-white shadow text-indigo-600' : 'text-gray-500' }}">
                        <span>🇵🇰</span> اردو
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen max-w-7xl mx-auto pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-scissors text-indigo-400 text-2xl"></i>
                        <span class="text-xl font-bold text-white">{{ $siteSettings['name'] }}</span>
                    </a>
                    <p class="text-gray-400 text-sm mb-4">
                        {{ __('Modern digital solution for tailoring businesses. Manage customers, measurements, and orders effortlessly.') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold mb-4">{{ __('Quick Links') }}</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('Home') }}</a>
                        </li>
                        <li><a href="{{ route('about') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('About') }}</a>
                        </li>
                        <li><a href="{{ route('pricing') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('Pricing') }}</a>
                        </li>
                        <li><a href="{{ route('contact-us') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-white font-bold mb-4">{{ __('Legal') }}</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li><a href="{{ route('terms') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('Terms of Service') }}</a>
                        </li>
                        <li><a href="{{ route('register') }}"
                                class="text-gray-400 hover:text-indigo-400 transition text-sm">{{ __('Start Free Trial') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} {{ $siteSettings['name'] }}.
                    {{ __('All rights reserved.') }}</p>
            </div>
        </div>
    </footer>

</body>

</html>
