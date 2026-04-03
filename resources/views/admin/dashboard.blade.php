@extends('layouts.admin')

@section('header', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <!-- Total Shops -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Shops</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalShops }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>

        <!-- Active Shops -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Active Subs</p>
                <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $activeShops }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Total Visits -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Visitors</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $totalVisitors }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-eye"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Shops -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Recent Registrations</h3>
                <a href="{{ route('admin.shops') }}"
                    class="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:underline cursor-pointer">View
                    All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentShops as $shop)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600 uppercase text-sm">
                                {{ substr($shop->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $shop->name }}</p>
                                <p class="text-xs text-gray-500">Owner: {{ $shop->owner->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div>
                            @if ($shop->status === 'active')
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Active</span>
                            @else
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Pending</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 italic">No shops found.</div>
                @endforelse
            </div>
        </div>

        <!-- System Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
            <h3 class="font-bold text-gray-800 mb-4">Quick Management</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.shops', ['status' => 'active']) }}"
                    class="block w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-red-50 hover:text-red-700 transition flex items-center gap-3 border border-transparent hover:border-red-100 text-gray-700">
                    <i class="fa-solid fa-ban text-red-500 w-5 text-center"></i> Suspend a Shop
                </a>
                <a href="{{ route('admin.reports.generate') }}"
                    class="block w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition flex items-center gap-3 border border-transparent hover:border-blue-100 text-gray-700">
                    <i class="fa-solid fa-file-invoice text-blue-500 w-5 text-center"></i> Generate Report
                </a>
                <a href="{{ route('admin.notifications.create') }}"
                    class="block w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center gap-3 border border-transparent hover:border-indigo-100 text-gray-700">
                    <i class="fa-solid fa-envelope text-indigo-500 w-5 text-center"></i> Email All Users
                </a>
            </div>
        </div>
    </div>
@endsection
