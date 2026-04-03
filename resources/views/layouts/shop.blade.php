<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TailorOnDesk') }} - Shop Panel</title>

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
            const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (collapsed && window.innerWidth >= 768) {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>

    <style>
        /* Base styles to prevent layout jump before Tailwind/Alpine load */
        .sidebar-collapsed aside {
            width: 5rem !important;
        }

        .sidebar-collapsed aside .sidebar-label,
        .sidebar-collapsed aside .sidebar-text {
            display: none !important;
        }

        .sidebar-collapsed aside .logo-text {
            display: none !important;
        }

        .sidebar-collapsed aside .user-details {
            display: none !important;
        }

        .sidebar-collapsed .main-content-wrapper {
            margin-left: 5rem !important;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Urdu Font Adjustments */
        html[lang="ur"] {
            font-family: 'Inter', 'Noto Sans Arabic', sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700&display=swap');
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
        localStorage.setItem('sidebarCollapsed', val);
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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition-all duration-300">
                    <i class="fa-solid fa-scissors text-2xl text-indigo-600 flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="logo-text text-xl font-bold tracking-tight text-gray-900 whitespace-nowrap truncate max-w-[160px]">
                        {{ auth()->user()->shop->name ?? 'TailorOnDesk' }}
                    </span>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto overflow-x-hidden custom-scrollbar flex-shrink-0">
                <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="sidebar-label px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Main</div>

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Dashboard">
                    <i class="fa-solid fa-gauge-high w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Dashboard</span>
                </a>

                <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="sidebar-label px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">
                    Operations</div>

                <a href="{{ route('customers.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('customers.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Customers">
                    <i class="fa-solid fa-users w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Customers</span>
                </a>

                <a href="{{ route('measurements.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('measurements.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Measurements">
                    <i class="fa-solid fa-ruler w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Measurements</span>
                </a>

                <a href="{{ route('orders.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('orders.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Orders">
                    <i class="fa-solid fa-list-check w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Orders</span>
                </a>

                <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="sidebar-label px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">
                    Account</div>

                <a href="{{ route('shop.subscriptions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('shop.subscriptions*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Subscription">
                    <i
                        class="fa-solid fa-crown w-5 text-center flex-shrink-0 {{ auth()->user()->shop->status === 'active' && !request()->routeIs('shop.subscriptions*') ? 'text-yellow-500' : '' }}"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Subscription</span>
                </a>

                <a href="{{ route('shop.profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('shop.profile.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    title="Profile">
                    <i class="fa-solid fa-user-gear w-5 text-center flex-shrink-0"></i>
                    <span x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300">Profile</span>
                </a>
            </nav>

            <!-- User Info (Bottom) -->
            <div class="p-4 border-t border-gray-200 bg-gray-50 overflow-hidden mt-auto">
                <div class="flex items-center gap-3 mb-4" :class="isExpanded ? 'px-1' : 'justify-center'">
                    <div
                        class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-sm flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div x-show="isExpanded" x-cloak x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="user-details flex-1 min-w-0 transition-opacity duration-300">
                        <div class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ auth()->user()->shop->name ?? 'No Shop' }}
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs uppercase tracking-wide font-bold text-gray-500 hover:text-red-600 hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded transition-all"
                        title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
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
                class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-20 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <!-- Menu Button (Desktop: Toggle Collapse, Mobile: Toggle Menu) -->
                    <button
                        @click="if(window.innerWidth >= 768) { sidebarCollapsed = !sidebarCollapsed } else { sidebarOpen = !sidebarOpen }"
                        class="p-2 rounded-lg bg-gray-50 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-colors focus:outline-none">
                        <i class="fa-solid text-xl transition-all duration-300"
                            :class="window.innerWidth >= 768 ?
                                (sidebarCollapsed ? 'fa-bars-staggered' : 'fa-chevron-left') :
                                (sidebarOpen ? 'fa-xmark' : 'fa-bars')"></i>
                    </button>

                    <h1 class="text-xl font-bold text-gray-800 hidden lg:block">
                        @yield('header')
                    </h1>
                </div>

                <!-- Global Quick Search -->
                <div x-data="{
                    search: '',
                    results: [],
                    loading: false,
                    showResults: false,
                
                    async fetchResults() {
                        if (this.search.length < 2) {
                            this.results = [];
                            this.showResults = false;
                            return;
                        }
                
                        this.loading = true;
                        this.showResults = true;
                        try {
                            const response = await fetch('{{ route('customers.search') }}?query=' + encodeURIComponent(this.search));
                            this.results = await response.json();
                        } catch (error) {
                            console.error('Search error:', error);
                        } finally {
                            this.loading = false;
                        }
                    }
                }" class="relative flex-1 max-w-md mx-4 hidden sm:block"
                    @click.away="showResults = false">
                    <div class="relative">
                        <input type="text" x-model="search" @input.debounce.300ms="fetchResults()"
                            @focus="if(results.length > 0 || search.length >= 2) showResults = true"
                            placeholder="Quick search customer (Name or Phone)..."
                            class="w-full pl-10 pr-10 py-2 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm h-10 font-medium">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </div>
                        <div x-show="loading" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-indigo-500"
                            x-cloak>
                            <i class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                        </div>
                        <button x-show="search.length > 0 && !loading"
                            @click="search = ''; results = []; showResults = false"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500"
                            x-cloak>
                            <i class="fa-solid fa-circle-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Dropdown Results -->
                    <div x-show="showResults" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-100 shadow-2xl rounded-2xl overflow-hidden z-[100] p-1.5 ring-1 ring-black/5">

                        <template x-if="results.length > 0">
                            <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
                                <div
                                    class="px-3 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 mb-1">
                                    Customer Results
                                </div>
                                <template x-for="customer in results" :key="customer.id">
                                    <div class="flex items-center gap-3 p-2.5 hover:bg-indigo-50/50 rounded-xl transition group relative cursor-pointer"
                                        @click="window.location.href = '/customers/' + customer.id">
                                        <div
                                            class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                            <span x-text="customer.name.substring(0, 1)"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-bold text-gray-900 truncate group-hover:text-indigo-700 transition-colors"
                                                x-text="customer.name"></div>
                                            <div class="text-[10px] text-gray-500 flex items-center gap-2">
                                                <i class="fa-solid fa-phone text-[8px] opacity-50"></i>
                                                <span x-text="customer.phone"></span>
                                                <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                                                <span x-text="customer.customer_key"
                                                    class="font-mono opacity-60"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <!-- Add Measurement Button -->
                                            <a :href="'/measurements/create?customer_id=' + customer.id" @click.stop
                                                class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-400 border border-gray-100 rounded-lg hover:bg-amber-500 hover:text-white hover:border-amber-500 transition-all"
                                                title="Add Measurement">
                                                <i class="fa-solid fa-ruler-combined text-xs"></i>
                                            </a>
                                            <!-- Book Order Button -->
                                            <a :href="'/orders/create?customer_id=' + customer.id" @click.stop
                                                class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-400 border border-gray-100 rounded-lg hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all"
                                                title="Book Quick Order">
                                                <i class="fa-solid fa-cart-plus text-xs"></i>
                                            </a>
                                            <i
                                                class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-0.5 transition-all"></i>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="results.length === 0 && !loading && search.length >= 2">
                            <div class="p-6 text-center">
                                <div
                                    class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fa-solid fa-user-slash text-gray-300 text-lg"></i>
                                </div>
                                <p class="text-xs font-bold text-gray-900">No customers found</p>
                                <p class="text-[10px] text-gray-500 mt-1">Try searching by name, phone or ID</p>
                            </div>
                        </template>

                        <template x-if="search.length < 2 && !loading">
                            <div class="p-4 text-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Enter at
                                    least 2 characters...</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3">
                    <!-- Language Toggle -->
                    <div class="flex bg-gray-100 p-1 rounded-xl">
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            EN
                        </a>
                        <a href="{{ route('lang.switch', 'ur') }}"
                            class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ app()->getLocale() == 'ur' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            اردو
                        </a>
                    </div>

                    {{-- Notification Bell (Commented out until backend is implemented)
                    <div x-data="{
                        open: false,
                        notifications: [
                            { id: 1, title: 'Welcome!', message: 'Happy tailoring with TailorOnDesk.', time: 'Just now', icon: 'fa-hand-wave', color: 'indigo', read: false },
                            { id: 2, title: 'Tips', message: 'You can search customers by phone numbering.', time: '2 hours ago', icon: 'fa-lightbulb', color: 'amber', read: false }
                        ],
                        get unreadCount() {
                            return this.notifications.filter(n => !n.read).length;
                        },
                        markAllRead() {
                            this.notifications.forEach(n => n.read = true);
                        }
                    }" class="relative">
                        <button @click="open = !open"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all relative">
                            <i class="fa-regular fa-bell text-lg"></i>
                            <template x-if="unreadCount > 0">
                                <span
                                    class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                            </template>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute top-full right-0 mt-2 w-80 bg-white border border-gray-100 shadow-2xl rounded-2xl overflow-hidden z-[110] ring-1 ring-black/5"
                            style="display: none;">
                            <div
                                class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Notifications
                                </h3>
                                <button @click="markAllRead()" x-show="unreadCount > 0"
                                    class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-widest">
                                    Mark all read
                                </button>
                            </div>
                            <div class="max-h-[350px] overflow-y-auto custom-scrollbar">
                                <template x-for="notif in notifications" :key="notif.id">
                                    <div class="p-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors cursor-pointer relative"
                                        :class="notif.read ? 'opacity-60' : ''" @click="notif.read = true">
                                        <div class="flex gap-3">
                                            <div
                                                :class="`w-9 h-9 rounded-lg bg-${notif.color}-50 text-${notif.color}-600 flex items-center justify-center text-sm flex-shrink-0`
                                                shadow - sm">
                                                <i class="fa-solid" :class="notif.icon"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start">
                                                    <p class="text-sm font-bold text-gray-900" x-text="notif.title">
                                                    </p>
                                                    <span class="text-[9px] font-medium text-gray-400"
                                                        x-text="notif.time"></span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed"
                                                    x-text="notif.message"></p>
                                            </div>
                                        </div>
                                        <template x-if="!notif.read">
                                            <div
                                                class="absolute top-4 right-4 w-1.5 h-1.5 bg-indigo-500 rounded-full shadow-[0_0_8px_rgba(99,102,241,0.5)]">
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="notifications.length === 0">
                                    <div class="py-12 text-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fa-solid fa-bell-slash text-gray-200 text-lg"></i>
                                        </div>
                                        <p class="text-xs font-bold text-gray-400">All caught up!</p>
                                    </div>
                                </template>
                            </div>
                            <div class="px-4 py-2 bg-gray-50/50 border-t border-gray-50 text-center">
                                <a href="#"
                                    class="text-[10px] font-bold text-gray-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">
                                    View settings
                                </a>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 custom-scrollbar">

                {{-- @if (isset($subscriptionStatus) && !request()->routeIs('shop.subscriptions.index'))
                    @if (
                        $subscriptionStatus['has_subscription'] &&
                            $subscriptionStatus['is_expiring_soon'] &&
                            !$subscriptionStatus['is_expired']
                    )
                        <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-exclamation-triangle text-yellow-500 text-xl flex-shrink-0"></i>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Subscription expiring soon</p>
                                    <p class="text-sm text-yellow-700 mt-0.5">
                                        Your subscription will expire in
                                        @if ($subscriptionStatus['days_until_expiry'] <= 0)
                                            less than 1 day
                                        @else
                                            {{ $subscriptionStatus['days_until_expiry'] }}
                                            {{ Str::plural('day', $subscriptionStatus['days_until_expiry']) }}
                                        @endif.
                                        <a href="{{ route('shop.subscriptions.index') }}"
                                            class="font-semibold underline">Renew now</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif(
                        $subscriptionStatus['has_subscription'] &&
                            isset($subscriptionStatus['subscription']) &&
                            $subscriptionStatus['subscription']->status === 'grace' &&
                            !$subscriptionStatus['subscription']->hasExpired())
                        <div class="mb-4 bg-orange-50 border-l-4 border-orange-400 p-4 rounded-r-lg">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clock text-orange-500 text-xl flex-shrink-0"></i>
                                <div>
                                    <p class="text-sm font-medium text-orange-800">In grace period</p>
                                    <p class="text-sm text-orange-700 mt-0.5">Your subscription has expired. Renew
                                        before
                                        {{ $subscriptionStatus['subscription']->grace_period_ends_at->format('M d, Y') }}
                                        to avoid service interruption. <a
                                            href="{{ route('shop.subscriptions.index') }}"
                                            class="font-semibold underline">Renew now</a></p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif --}}

                 <!-- Subscription Status Banner -->
                @if (isset($subscriptionStatus) && $subscriptionStatus['has_subscription'])
                    @if ($subscriptionStatus['is_expiring_soon'])
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-lg">
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
                        <div class="bg-orange-50 border-l-4 border-orange-400 mb-4 p-4 rounded-lg">
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
                        <div class="bg-emerald-50 border-l-4 border-emerald-400 mb-4 p-4 rounded-lg">
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
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-info-circle text-red-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">No Active Subscription</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>You don't have an active subscription. Choose a plan below to get started.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

        </div>

        <!-- Overlay for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-gray-900 opacity-50 md:hidden" style="display: none;"></div>

    </div>

    @stack('scripts')
</body>

</html>
