<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TailorOnDesk') }} - Shop Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 hidden md:flex flex-col">
                <div class="h-16 flex items-center justify-center border-b border-gray-100 dark:border-gray-700">
                    <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">TailorOnDesk</span>
                </div>
                
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Core Modules -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
                    </div>
                    
                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('Customers') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('Orders') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('measurements.index')" :active="request()->routeIs('measurements.*')" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('Measurements') }}
                    </x-nav-link>

                    <!-- Finance -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</p>
                    </div>
                    
                    <x-nav-link :href="route('subscription.index')" :active="request()->routeIs('subscription.*')" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('Subscription') }}
                    </x-nav-link>
                </nav>

                <!-- User Profile (Bottom) -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col">
                <!-- Mobile Header -->
                <header class="bg-white dark:bg-gray-800 shadow p-4 md:hidden flex justify-between items-center">
                    <span class="font-bold text-lg">TailorOnDesk</span>
                    <button class="text-gray-500">Menu</button> <!-- Placeholder for mobile menu toggle -->
                </header>

                <!-- Page Header (Optional) -->
                @if (isset($header))
                    <div class="bg-white dark:bg-gray-800 shadow px-6 py-4">
                        {{ $header }}
                    </div>
                @endif

                <!-- Page Content -->
                <div class="p-6 overflow-y-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
