@extends('layouts.admin')

@section('header', 'Visitor Analytics')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Total Visits -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Visits</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalVisits }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <!-- Today's Visits -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Today's Visits</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $todayVisits }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-eye"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-800">Recent Visitor Activity</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">IP Address
                        </th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Page</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Device
                        </th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Location
                        </th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentVisits as $visit)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <span class="font-mono text-sm text-gray-900">{{ $visit->ip_address }}</span>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-600">
                                {{ $visit->referer }}
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-600">
                                {{ $visit->device_type }}
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-600">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fa-solid fa-map-marker-alt text-gray-400"></i>
                                    {{ $visit->location_name }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-600">
                                {{ $visit->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500 italic">No visitor data available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
