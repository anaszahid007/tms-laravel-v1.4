@extends('layouts.admin')

@section('header', 'Subscription Plans')

@section('content')
    <div class="mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">

            <!-- Toolbar: Title, Filters, Search, Create Button -->
            <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">

                <!-- Left Side: Title & Filters -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <h2 class="text-lg font-bold text-gray-800 whitespace-nowrap">All Plans</h2>

                    <div class="flex bg-gray-100/80 p-1 rounded-lg self-start sm:self-auto">
                        <a href="{{ route('admin.subscription-plans.index') }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ !request('status') ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            All
                        </a>
                        <a href="{{ route('admin.subscription-plans.index', ['status' => 'active']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'active' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Active
                        </a>
                        <a href="{{ route('admin.subscription-plans.index', ['status' => 'inactive']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'inactive' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Inactive
                        </a>
                    </div>
                </div>

                <!-- Right Side: Search & Create Button -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.subscription-plans.index') }}"
                        class="relative w-full sm:w-64">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search plans..."
                            class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-gray-400">
                    </form>

                    <!-- Create Button -->
                    <a href="{{ route('admin.subscription-plans.create') }}"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-plus"></i>
                        Create Plan
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="py-4 px-6">Plan Name</th>
                            <th class="py-4 px-4 text-right">Price</th>
                            <th class="py-4 px-4 text-center">Duration</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-4 text-center">Subscribers</th>
                            <th class="py-4 px-4 text-right">Created</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm ring-1 ring-black/5">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="font-bold text-sm text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $plan->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-mono tracking-wide">
                                                {{ $plan->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="text-lg font-bold text-gray-900">Rs.
                                            {{ number_format($plan->price, 0) }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase">PKR</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        <i class="fa-solid fa-calendar-days text-[10px]"></i>
                                        {{ $plan->duration_days }} days
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex flex-col gap-1">
                                        @if ($plan->is_active)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                                <i class="fa-solid fa-circle-xmark text-[10px]"></i>
                                                Inactive
                                            </span>
                                        @endif
                                        @if ($plan->is_free)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                <i class="fa-solid fa-gift text-[10px]"></i>
                                                Free
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-sm font-medium text-gray-700">0</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <p class="text-xs font-medium text-gray-600">{{ $plan->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-[10px] text-gray-400">{{ $plan->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.subscription-plans.show', $plan->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                            title="Edit Plan">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form method="POST"
                                            action="{{ route('admin.subscription-plans.destroy', $plan->id) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this plan? This action cannot be undone.')"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Delete Plan">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-tags text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold mb-1">No Plans Found</h3>
                                        <p class="text-gray-500 text-sm mb-6">
                                            @if (request('search'))
                                                We couldn't find any plans matching "{{ request('search') }}".
                                            @else
                                                Get started by creating your first subscription plan.
                                            @endif
                                        </p>
                                        @if (request('search') || request('status'))
                                            <a href="{{ route('admin.subscription-plans.index') }}"
                                                class="text-indigo-600 font-medium text-sm hover:underline">Clear all
                                                filters</a>
                                        @else
                                            <a href="{{ route('admin.subscription-plans.create') }}"
                                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">
                                                <i class="fa-solid fa-plus mr-2"></i>Create Your First Plan
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $plans->links() }}
            </div>
        </div>
    </div>
@endsection
