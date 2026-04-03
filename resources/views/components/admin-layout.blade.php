<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TailorOnDesk') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex">
            <!-- Admin Sidebar -->
            <aside class="w-64 bg-zinc-900 text-white border-r border-zinc-700 hidden md:flex flex-col">
                <div class="h-16 flex items-center justify-center border-b border-zinc-700 bg-zinc-950">
                    <span class="text-xl font-bold text-red-500">ADMIN</span>
                </div>
                
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    
                     <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-zinc-800 {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-800 text-white' : 'text-gray-400' }}">
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Platform</p>
                    </div>
                    
                    <a href="#" class="flex items-center px-4 py-2 rounded-md hover:bg-zinc-800 text-gray-400">
                        <span>Shops</span>
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-2 rounded-md hover:bg-zinc-800 text-gray-400">
                        <span>Visitors</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 rounded-md hover:bg-zinc-800 text-gray-400">
                        <span>Settings</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-zinc-700 bg-zinc-950">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">
                                {{ Auth::user()->name }}
                            </p>
                            <span class="text-xs text-green-500">Super Admin</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-xs text-gray-400 hover:text-white flex items-center gap-1 w-full justify-start">
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col">
                 <!-- Page Header (Optional) -->
                @if (isset($header))
                    <div class="bg-white dark:bg-gray-800 shadow px-6 py-4 border-b border-gray-200 dark:border-gray-700">
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
