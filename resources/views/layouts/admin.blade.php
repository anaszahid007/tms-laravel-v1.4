<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteSettings['name'] }} - Super Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logos/favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Prevent Sidebar Flicker -->
    <script>
        (function() {
            const collapsed = localStorage.getItem('admin_sidebarCollapsed') === 'true';
            if (collapsed && window.innerWidth >= 768) {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>

    <style>
        .sidebar-collapsed aside {
            width: 5rem !important;
        }

        .sidebar-collapsed aside .sidebar-label,
        .sidebar-collapsed aside .sidebar-text,
        .sidebar-collapsed aside .logo-text,
        .sidebar-collapsed aside .user-details {
            display: none !important;
        }

        .sidebar-collapsed .main-content-wrapper {
            margin-left: 5rem !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @include('partials.toast-alerts')

    <div x-data="{
        sidebarOpen: false,
        sidebarCollapsed: document.documentElement.classList.contains('sidebar-collapsed'),
        get isExpanded() {
            if (window.innerWidth < 768) return true;
            return !this.sidebarCollapsed;
        }
    }" x-init="$watch('sidebarCollapsed', val => {
        localStorage.setItem('admin_sidebarCollapsed', val);
        if (val) {
            document.documentElement.classList.add('sidebar-collapsed');
        } else {
            document.documentElement.classList.remove('sidebar-collapsed');
        }
    })" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 text-gray-800 transition-all duration-300 ease-in-out transform flex flex-col"
            :class="[
                sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0',
                isExpanded ? 'md:w-64' : 'md:w-20'
            ]">

            <!-- Logo -->
            <div class="flex items-center h-16 bg-white border-b border-gray-200 overflow-hidden"
                :class="isExpanded ? 'justify-between px-6' : 'justify-center px-0'">
                <div class="flex items-center gap-2 transition-all duration-300">
                    <i class="fa-solid fa-shield-halved text-2xl text-indigo-600 flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="logo-text text-xl font-bold tracking-widest uppercase flex items-center gap-2 whitespace-nowrap">
                        <span>{{ $siteSettings['name'] }}</span>
                    </span>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto overflow-x-hidden custom-scrollbar flex-shrink-0">
                <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="sidebar-label px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Overview
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Dashboard">
                    <i class="fa-solid fa-chart-line w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Dashboard</span>
                </a>

                <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="sidebar-label px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">
                    Platform
                </div>

                <a href="{{ route('admin.shops') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.shops') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Shops">
                    <i class="fa-solid fa-store w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Shops</span>
                </a>

                <a href="{{ route('admin.visitors') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.visitors') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Visitors">
                    <i class="fa-solid fa-users-viewfinder w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Visitors</span>
                </a>

                <a href="{{ route('admin.referrals.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.referrals*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Partners">
                    <i class="fa-solid fa-handshake w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Partners</span>
                </a>

                <a href="{{ route('admin.inquiries') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.inquiries') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Inquiries">
                    <i class="fa-solid fa-envelope-open-text w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Inquiries</span>
                </a>

                <a href="{{ route('admin.bulk-email.create') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.bulk-email*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Bulk Email">
                    <i class="fa-solid fa-paper-plane w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Bulk Email</span>
                </a>

                {{-- <a href="{{ route('admin.measurement-templates.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.measurement-templates*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Measurement Templates">
                    <i class="fa-solid fa-ruler-combined w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Measurement Templates</span>
                </a> --}}

                <a href="{{ route('admin.subscription-plans.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.subscription-plans*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Subscription Plans">
                    <i class="fa-solid fa-tags w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Subscription
                        Plans</span>
                </a>

                <a href="{{ route('admin.payments.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.payments*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Payment Management">
                    <i class="fa-solid fa-credit-card w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Payments</span>
                </a>

                <a href="{{ route('admin.payment-accounts.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.payment-accounts*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Payment Accounts">
                    <i class="fa-solid fa-building-columns w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Payment
                        Accounts</span>
                </a>

                <a href="{{ route('admin.backups.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.backups.index') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Database Backups">
                    <i class="fa-solid fa-database w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Backups</span>
                </a>

                <a href="{{ route('admin.settings') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Settings">
                    <i class="fa-solid fa-gears w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Settings</span>
                </a>
            </nav>

            <!-- User Info (Bottom) -->
            <div class="p-4 border-t border-gray-200 bg-gray-50 overflow-hidden mt-auto">
                <div class="flex items-center gap-3 mb-4" :class="isExpanded ? 'px-1' : 'justify-center'">
                    <div
                        class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-sm flex-shrink-0">
                        S.A
                    </div>
                    <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="user-details flex-1 min-w-0 transition-opacity duration-300">
                        <div class="text-sm font-bold text-gray-900 truncate">Super Admin</div>
                        <div class="text-xs text-gray-500 truncate">System Owner</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs uppercase tracking-wide font-bold text-gray-500 hover:text-red-600 hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded transition whitespace-nowrap"
                        title="Logout">
                        <i class="fa-solid fa-power-off"></i>
                        <span x-show="isExpanded" x-cloak
                            x-transition:enter="transition ease-out duration-300 delay-100"
                            x-transition:enter-start="opacity-0 translate-x-2"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="sidebar-text transition-opacity duration-300">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper flex-1 flex flex-col h-screen overflow-hidden bg-gray-50 transition-all duration-300"
            :class="isExpanded ? 'md:ml-64' : 'md:ml-20'">

            <!-- Top Header -->
            <header
                class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <button
                        @click="if(window.innerWidth >= 768) { sidebarCollapsed = !sidebarCollapsed } else { sidebarOpen = !sidebarOpen }"
                        class="p-2 rounded-lg bg-gray-50 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-colors focus:outline-none">
                        <i class="fa-solid text-xl transition-all duration-300"
                            :class="window.innerWidth >= 768 ?
                                (sidebarCollapsed ? 'fa-bars-staggered' : 'fa-chevron-left') :
                                (sidebarOpen ? 'fa-xmark' : 'fa-bars')"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800 tracking-tight">
                        @yield('header')
                    </h1>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 custom-scrollbar">
                @yield('content')
            </main>

        </div>

        <!-- Overlay for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-gray-900 opacity-50 md:hidden" style="display: none;"></div>

    </div>
</body>

</html>
