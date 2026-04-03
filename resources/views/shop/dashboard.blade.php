@extends('layouts.shop')

@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stat Card 1: Customers -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-indigo-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Customers</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-black text-gray-800">{{ $currentMonthCustomers }}</p>
                    <p class="text-xs font-medium text-gray-500">this month</p>
                </div>
            </div>
            <div
                class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-indigo-100/50">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Stat Card 2: Orders -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1">Orders</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-black text-gray-800">{{ $currentMonthOrders }}</p>
                    <p class="text-xs font-medium text-gray-500">this month</p>
                </div>
            </div>
            <div
                class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-yellow-100/50">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <!-- Stat Card 3: Revenue -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-emerald-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Revenue</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-2xl font-black text-gray-800">Rs. {{ number_format($currentMonthRevenue) }}</p>
                    <p class="text-xs font-medium text-gray-500">this month</p>
                </div>
            </div>
            <div
                class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-emerald-100/50">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Visualization -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-area text-indigo-500"></i> Revenue Insights
                </h3>
                <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-auto overflow-hidden">
                    <button onclick="updateChart('month')" id="btn-month-rev"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all bg-white text-indigo-600 shadow-sm">
                        This Month
                    </button>
                    <button onclick="updateChart('year')" id="btn-year-rev"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all text-gray-400 hover:text-gray-600">
                        This Year
                    </button>
                </div>
            </div>
            <div class="relative h-[300px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Order Visualization -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-emerald-500"></i> Order Insights
                </h3>
                <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-auto overflow-hidden">
                    <button onclick="updateChart('month')" id="btn-month-ord"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all bg-white text-emerald-600 shadow-sm">
                        This Month
                    </button>
                    <button onclick="updateChart('year')" id="btn-year-ord"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all text-gray-400 hover:text-gray-600">
                        This Year
                    </button>
                </div>
            </div>
            <div class="relative h-[300px]">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- <!-- Customer Quick Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-indigo-500"></i> Customer Quick Search
            </h3>
            
            <div class="relative mb-4">
                <input type="text" id="customer-search-input" 
                    placeholder="Search by name, phone or ID..." 
                    class="w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa-solid fa-search"></i>
                </div>
                <!-- Loading Spinner -->
                <div id="search-spinner" class="absolute right-3 top-1/2 -translate-y-1/2 text-indigo-600 hidden">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </div>
            </div>

            <!-- Search Results Container -->
            <div id="search-results" class="flex-1 space-y-3 max-h-[300px] overflow-y-auto custom-scrollbar pr-1">
                <div class="text-center py-8 text-gray-400 bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                    <i class="fa-solid fa-user-tag text-3xl mb-2 opacity-20"></i>
                    <p class="text-xs">Type to find a customer...</p>
                </div>
            </div>
        </div> --}}

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-yellow-500"></i> Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('orders.create') }}"
                    class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-indigo-50 border border-gray-200 hover:border-indigo-300 rounded-xl transition group">
                    <div
                        class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">New Order</span>
                </a>

                <a href="{{ route('customers.create') }}"
                    class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-300 rounded-xl transition group">
                    <div
                        class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">New Customer</span>
                </a>
            </div>
        </div>

        <!-- Subscription Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-bell text-gray-500"></i> Subscription Status
            </h3>
            @if ($shop)
                <div class="flex items-center gap-4 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Current Plan</p>
                        <p class="text-lg font-bold text-indigo-700 uppercase">
                            {{ $subscriptionStatus['subscription'] ? $subscriptionStatus['subscription']->plan_name : $shop->status }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Expires On</p>
                        <p class="font-medium text-gray-800">
                            @if ($subscriptionStatus['subscription'])
                                {{ $subscriptionStatus['subscription']->ends_at->format('d M, Y') }}
                            @elseif($shop->subscription_ends_at)
                                {{ $shop->subscription_ends_at->format('d M, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('shop.subscriptions.index') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline font-medium">Manage
                        Subscription <i class="fa-solid fa-arrow-right text-xs"></i></a>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fa-solid fa-store-slash text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No shop configured</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data from Backend
            const monthlyData = @json($monthlyChartData);
            const yearlyData = @json($yearlyChartData);

            // Revenue Chart
            const ctxRev = document.getElementById('revenueChart').getContext('2d');
            const gradientRev = ctxRev.createLinearGradient(0, 0, 0, 300);
            gradientRev.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
            gradientRev.addColorStop(1, 'rgba(99, 102, 241, 0)');

            let revenueChart = new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: monthlyData.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: monthlyData.values,
                        borderColor: '#6366f1',
                        borderWidth: 3,
                        backgroundColor: gradientRev,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#1e293b',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: (context) => ' Rs. ' + context.parsed.y.toLocaleString()
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                color: '#94a3b8'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [5, 5],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                color: '#94a3b8',
                                callback: (value) => 'Rs. ' + value.toLocaleString()
                            }
                        }
                    }
                }
            });

            // Order Chart
            const ctxOrd = document.getElementById('orderChart').getContext('2d');
            const gradientOrd = ctxOrd.createLinearGradient(0, 0, 0, 300);
            gradientOrd.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
            gradientOrd.addColorStop(1, 'rgba(16, 185, 129, 0)');

            let orderChart = new Chart(ctxOrd, {
                type: 'line',
                data: {
                    labels: monthlyData.labels,
                    datasets: [{
                        label: 'Orders',
                        data: monthlyData.orders,
                        borderColor: '#10b981',
                        borderWidth: 3,
                        backgroundColor: gradientOrd,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#1e293b',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: (context) => ' ' + context.parsed.y + ' Orders'
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                color: '#94a3b8'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [5, 5],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                color: '#94a3b8',
                                stepSize: 1,
                                callback: (value) => value + ' '
                            }
                        }
                    }
                }
            });

            function updateChart(type) {
                const isMonth = type === 'month';
                const data = isMonth ? monthlyData : yearlyData;

                // Update Revenue Chart
                revenueChart.data.labels = data.labels;
                revenueChart.data.datasets[0].data = data.values;
                revenueChart.update();

                // Update Order Chart
                orderChart.data.labels = data.labels;
                orderChart.data.datasets[0].data = data.orders;
                orderChart.update();

                // Update Buttons
                const activeBtn =
                    'flex-1 sm:flex-none px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all bg-white shadow-sm';
                const inactiveBtn =
                    'flex-1 sm:flex-none px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all text-gray-400 hover:text-gray-600';

                document.getElementById('btn-month-rev').className = isMonth ? activeBtn + ' text-indigo-600' : inactiveBtn;
                document.getElementById('btn-year-rev').className = !isMonth ? activeBtn + ' text-indigo-600' : inactiveBtn;

                document.getElementById('btn-month-ord').className = isMonth ? activeBtn + ' text-emerald-600' : inactiveBtn;
                document.getElementById('btn-year-ord').className = !isMonth ? activeBtn + ' text-emerald-600' : inactiveBtn;
            }
        </script>
    @endpush
@endsection
