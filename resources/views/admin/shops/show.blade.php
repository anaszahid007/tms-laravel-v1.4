@extends('layouts.admin')

@section('header', 'Shop Details')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.shops') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Shops
            </a>
            <div class="flex gap-2">
                @if ($shop->is_suspended)
                    <form method="POST" action="{{ route('admin.shops.activate', $shop->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Activate this shop?')"
                            class="px-4 py-2 text-sm font-medium rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-100 transition shadow-sm">
                            <i class="fa-solid fa-check mr-2"></i> Activate Shop
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.shops.suspend', $shop->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Suspend this shop?')"
                            class="px-4 py-2 text-sm font-medium rounded-lg bg-red-50 text-red-600 hover:bg-red-100 border border-red-100 transition shadow-sm">
                            <i class="fa-solid fa-ban mr-2"></i> Suspend Shop
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Shop Info & Owner -->
            <div class="space-y-6">
                <!-- Shop Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-md">
                            {{ substr($shop->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $shop->name }}</h2>
                            <p class="text-sm text-gray-500 font-mono">ID: {{ $shop->shop_key ?? $shop->id }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 py-3 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Account Status</span>
                            @if ($shop->is_suspended)
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Suspended</span>
                            @else
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Active</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Subscription</span>
                            <span
                                class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 capitalize">{{ $shop->status }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Joined</span>
                            <span class="text-sm font-medium text-gray-800">{{ $shop->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Owner Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Owner Details</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">{{ $shop->user->name }}</div>
                            <div class="text-xs text-gray-500">Owner</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 text-sm text-gray-600 p-2 hover:bg-gray-50 rounded transition">
                            <i class="fa-solid fa-envelope w-5 text-center text-gray-400"></i>
                            <a href="mailto:{{ $shop->user->email }}"
                                class="hover:text-indigo-600">{{ $shop->user->email }}</a>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600 p-2 hover:bg-gray-50 rounded transition">
                            <i class="fa-solid fa-phone w-5 text-center text-gray-400"></i>
                            <span>{{ $shop->phone ?? 'No phone provided' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600 p-2 hover:bg-gray-50 rounded transition">
                            <i class="fa-solid fa-location-dot w-5 text-center text-gray-400"></i>
                            <span>{{ $shop->address ?? 'No address provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Stats & Activity -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Orders</dt>
                        <dd class="mt-2 text-2xl font-bold text-indigo-600">{{ $shop->orders->count() }}</dd>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Customers</dt>
                        <dd class="mt-2 text-2xl font-bold text-emerald-600">{{ $shop->customers->count() }}</dd>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Measurements</dt>
                        <dd class="mt-2 text-2xl font-bold text-blue-600">{{ $shop->measurements->count() }}</dd>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Recent Orders</h3>
                        <span class="text-xs text-gray-500">Last 5 records</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-400 font-bold">
                                <tr>
                                    <th class="px-6 py-3">Order ID</th>
                                    <th class="px-6 py-3">Customer</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($shop->orders()->latest()->take(5)->get() as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3 font-mono text-gray-600">#{{ $order->order_key }}</td>
                                        <td class="px-6 py-3 font-medium text-gray-800">
                                            {{ $order->customer->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-right text-gray-500">
                                            {{ $order->created_at->format('M d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No orders
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
