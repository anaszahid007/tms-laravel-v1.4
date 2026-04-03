@extends('layouts.admin')

@section('header', 'Payment Management')

@section('content')
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">

            <!-- Toolbar: Title, Filters, Search -->
            <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">

                <!-- Left Side: Title & Filters -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <h2 class="text-lg font-bold text-gray-800 whitespace-nowrap">Payment Requests</h2>

                    <div class="flex bg-gray-100/80 p-1 rounded-lg self-start sm:self-auto">
                        <a href="{{ route('admin.payments.index') }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ !request('status') ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            All
                        </a>
                        <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'pending' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Pending
                        </a>
                        <a href="{{ route('admin.payments.index', ['status' => 'approved']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'approved' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Approved
                        </a>
                        <a href="{{ route('admin.payments.index', ['status' => 'rejected']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'rejected' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Rejected
                        </a>
                    </div>
                </div>

                <!-- Right Side: Search -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.payments.index') }}"
                        class="relative w-full sm:w-64">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search payments..."
                            class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-gray-400">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="py-4 px-6">Shop</th>
                            <th class="py-4 px-4">Plan</th>
                            <th class="py-4 px-4 text-right">Amount</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-4 text-center">Transaction ID</th>
                            <th class="py-4 px-4 text-right">Submitted</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm ring-1 ring-black/5">
                                            <i class="fa-solid fa-shop"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $payment->shop->name }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 font-mono tracking-wide">
                                                {{ $payment->shop->shop_key }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-sm text-gray-900">{{ $payment->subscriptionPlan->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $payment->subscriptionPlan->duration_days }} days</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="text-lg font-bold text-gray-900">Rs. {{ number_format($payment->amount, 0) }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase">{{ $payment->currency }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if ($payment->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            <i class="fa-solid fa-clock text-[10px]"></i>
                                            Pending
                                        </span>
                                    @elseif ($payment->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                            Approved
                                        </span>
                                    @elseif ($payment->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            <i class="fa-solid fa-times text-[10px]"></i>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-sm font-mono text-gray-700">{{ $payment->transaction_id }}</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <p class="text-xs font-medium text-gray-600">{{ $payment->created_at->format('M d, Y') }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $payment->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.payments.show', $payment->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        @if($payment->status === 'pending')
                                            <button type="button"
                                                onclick="if(confirm('Are you sure you want to approve this payment?')) { document.getElementById('approve-form-{{ $payment->id }}').submit(); }"
                                                class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                                title="Approve Payment">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <form id="approve-form-{{ $payment->id }}" method="POST" action="{{ route('admin.payments.approve', $payment->id) }}" class="hidden">
                                                @csrf
                                            </form>
                                            
                                            <button type="button"
                                                onclick="if(confirm('Are you sure you want to reject this payment?')) { document.getElementById('reject-form-{{ $payment->id }}').submit(); }"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Reject Payment">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                            <form id="reject-form-{{ $payment->id }}" method="POST" action="{{ route('admin.payments.reject', $payment->id) }}" class="hidden">
                                                @csrf
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-credit-card text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold mb-1">No Payments Found</h3>
                                        <p class="text-gray-500 text-sm mb-6">
                                            @if (request('search') || request('status'))
                                                No payments match your current filters.
                                            @else
                                                No payment requests have been submitted yet.
                                            @endif
                                        </p>
                                        @if (request('search') || request('status'))
                                            <a href="{{ route('admin.payments.index') }}"
                                                class="text-indigo-600 font-medium text-sm hover:underline">Clear all filters</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection