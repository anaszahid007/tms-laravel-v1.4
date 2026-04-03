@extends('layouts.admin')

@section('header', 'Referral Partner Details')

@section('content')
    <div class="mb-6">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.referrals.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Partners
            </a>
        </div>

        <!-- Partner Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur-sm text-white flex items-center justify-center font-bold text-2xl shadow-lg ring-4 ring-white/30">
                            {{ substr($partner->name, 0, 1) }}
                        </div>
                        <div class="text-white">
                            <h1 class="text-2xl font-bold mb-1">{{ $partner->name }}</h1>
                            <p class="text-indigo-100 text-sm">{{ $partner->email }}</p>
                            @if ($partner->phone)
                                <p class="text-indigo-100 text-sm">{{ $partner->phone }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @if ($partner->status === 'active')
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                <i class="fa-solid fa-circle-check"></i>
                                Active Partner
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold bg-red-500/20 backdrop-blur-sm text-white border border-white/30">
                                <i class="fa-solid fa-ban"></i>
                                Suspended
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6 border-b border-gray-100">
                <!-- Total Conversions -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Conversions</span>
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-users text-blue-600 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $partner->conversions->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total sign-ups</p>
                </div>

                <!-- Total Earnings -->
                <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-4 border border-emerald-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Earnings</span>
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-wave text-emerald-600 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">Rs.
                        {{ number_format($partner->earnings->sum('amount'), 0) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Total earned</p>
                </div>

                <!-- Pending Payout -->
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-4 border border-orange-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Pending</span>
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-clock text-orange-600 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">Rs.
                        {{ number_format($partner->earnings->where('is_paid', false)->sum('amount'), 0) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting payout</p>
                </div>

                <!-- Total Paid -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Paid Out</span>
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-check-circle text-purple-600 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">Rs.
                        {{ number_format($partner->payouts->sum('amount'), 0) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total paid</p>
                </div>
            </div>

            <!-- Referral Info Section -->
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-info-circle text-indigo-600"></i>
                    Referral Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Referral Code -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Referral Code</label>
                        <div class="flex items-center gap-2">
                            <code
                                class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-base font-mono font-bold text-gray-800">
                                {{ $partner->referral_code }}
                            </code>
                            <button onclick="copyReferralLink('{{ $partner->referral_code }}')"
                                class="px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-all">
                                <i class="fa-solid fa-copy mr-1.5"></i>
                                Copy Link
                            </button>
                        </div>
                    </div>

                    <!-- Commission -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Commission Rate</label>
                        <div class="px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                            @if ($partner->commission_type === 'percentage')
                                <span class="text-base font-bold text-emerald-700">{{ $partner->commission_value }}%</span>
                                <span class="text-xs text-gray-600 ml-2">of subscription price</span>
                            @else
                                <span class="text-base font-bold text-emerald-700">Rs.
                                    {{ number_format($partner->commission_value, 0) }}</span>
                                <span class="text-xs text-gray-600 ml-2">per conversion</span>
                            @endif
                        </div>
                    </div>

                    <!-- Duration Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Commission Duration</label>
                        <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg">
                            @if ($partner->duration_type === 'forever')
                                <span class="text-base font-bold text-blue-700">Forever</span>
                                <p class="text-xs text-gray-600 mt-0.5">Lifetime recurring commission</p>
                            @elseif($partner->duration_type === 'one_time')
                                <span class="text-base font-bold text-blue-700">One Time</span>
                                <p class="text-xs text-gray-600 mt-0.5">First subscription only</p>
                            @else
                                <span class="text-base font-bold text-blue-700">{{ $partner->duration_limit }}
                                    Months</span>
                                <p class="text-xs text-gray-600 mt-0.5">Limited duration commission</p>
                            @endif
                        </div>
                    </div>

                    <!-- Member Since -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-2">Member Since</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span
                                class="text-base font-bold text-gray-700">{{ $partner->created_at->format('M d, Y') }}</span>
                            <p class="text-xs text-gray-600 mt-0.5">{{ $partner->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Conversions -->
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-indigo-600"></i>
                    Recent Conversions
                </h3>

                @if ($partner->conversions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                    <th class="py-3 px-4">Shop Name</th>
                                    <th class="py-3 px-4">Owner</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-right">Converted On</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($partner->conversions->take(10) as $conversion)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="py-3 px-4">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $conversion->shop->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="text-sm text-gray-600">{{ $conversion->shop->user->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @if ($conversion->shop)
                                                @php
                                                    $statusClasses = [
                                                        'active' =>
                                                            'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                        'trial' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'expired' => 'bg-orange-100 text-orange-700 border-orange-200',
                                                        'cancelled' => 'bg-gray-100 text-gray-700 border-gray-200',
                                                    ];
                                                    $statusClass =
                                                        $statusClasses[$conversion->shop->status] ??
                                                        'bg-gray-100 text-gray-700 border-gray-200';
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                                    {{ ucfirst($conversion->shop->status) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <span
                                                class="text-xs font-medium text-gray-600">{{ $conversion->converted_at->format('M d, Y') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-inbox text-gray-300 text-xl"></i>
                        </div>
                        <p class="text-sm text-gray-500">No conversions yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyReferralLink(code) {
            const url = '{{ url('/register') }}?ref=' + code;
            navigator.clipboard.writeText(url).then(() => {
                alert('Referral link copied to clipboard!');
            });
        }
    </script>
@endsection
