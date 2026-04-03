@extends('layouts.admin')

@section('header', 'Shop Management')

@section('content')
    <div x-data="{
        selected: [],
        get allSelected() {
            return this.selected.length === {{ $shops->count() }};
        },
        toggleAll() {
            if (this.allSelected) {
                this.selected = [];
            } else {
                this.selected = [@foreach ($shops as $shop) '{{ $shop->id }}'{{ !$loop->last ? ',' : '' }} @endforeach];
            }
        }
    }" class="mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">

            <!-- Toolbar: Title, Filters, Search -->
            <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">

                <!-- Left Side: Title & Filters -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <h2 class="text-lg font-bold text-gray-800 whitespace-nowrap">All Shops</h2>

                    <div class="flex bg-gray-100/80 p-1 rounded-lg self-start sm:self-auto">
                        <a href="{{ route('admin.shops') }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ !request('status') ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            All
                        </a>
                        <a href="{{ route('admin.shops', ['status' => 'active']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'active' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Active
                        </a>
                        <a href="{{ route('admin.shops', ['status' => 'suspended']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'suspended' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Suspended
                        </a>
                    </div>
                </div>

                <!-- Right Side: Bulk Actions & Search -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                    <!-- Bulk Actions (Visible when selected) -->
                    <div x-show="selected.length > 0" x-transition.opacity.duration.200ms
                        class="bg-indigo-50 border border-indigo-100 px-3 py-2 rounded-lg flex items-center justify-between gap-3"
                        style="display: none;">
                        <span class="text-xs font-bold text-indigo-700 whitespace-nowrap"
                            x-text="selected.length + ' selected'"></span>

                        <form method="POST" action="{{ route('admin.shops.bulk-action') }}"
                            class="flex items-center gap-1">
                            @csrf
                            <template x-for="id in selected" :key="id">
                                <input type="hidden" name="ids[]" :value="id">
                            </template>

                            <button type="submit" name="action" value="activate"
                                onclick="return confirm('Activate selected shops?')"
                                class="w-7 h-7 flex items-center justify-center rounded bg-white text-emerald-600 hover:text-emerald-700 shadow-sm border border-emerald-100 transition-colors"
                                title="Activate Selected">
                                <i class="fa-solid fa-check text-xs"></i>
                            </button>
                            <button type="submit" name="action" value="suspend"
                                onclick="return confirm('Suspend selected shops?')"
                                class="w-7 h-7 flex items-center justify-center rounded bg-white text-red-600 hover:text-red-700 shadow-sm border border-red-100 transition-colors"
                                title="Suspend Selected">
                                <i class="fa-solid fa-ban text-xs"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.shops') }}" class="relative w-full sm:w-64">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Find by name, email..."
                            class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-gray-400">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="py-4 px-6 w-10">
                                <input type="checkbox" @click="toggleAll()" :checked="allSelected"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer w-4 h-4">
                            </th>
                            <th class="py-4 px-4">Shop Name</th>
                            <th class="py-4 px-4">Owner</th>
                            <th class="py-4 px-4 text-center">Account Status</th>
                            <th class="py-4 px-4 text-center">Subscription</th>
                            <th class="py-4 px-4 text-right">Created</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($shops as $shop)
                            <tr class="hover:bg-gray-50/80 transition-colors group"
                                :class="selected.includes('{{ $shop->id }}') ? 'bg-indigo-50/40' : ''">
                                <td class="py-4 px-6">
                                    <input type="checkbox" value="{{ $shop->id }}" x-model="selected"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer w-4 h-4">
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm ring-1 ring-black/5">
                                            {{ substr($shop->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p
                                                class="font-bold text-sm text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $shop->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-mono tracking-wide">
                                                ID:{{ $shop->shop_key ?? $shop->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-medium text-gray-700">{{ $shop->user->name ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">{{ $shop->user->email ?? '' }}</span>
                                    </div>
                                </td>
                                <!-- Account Status Column -->
                                <td class="py-4 px-4 text-center">
                                    @if ($shop->is_suspended)
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100 uppercase tracking-tight">
                                            <i class="fa-solid fa-ban text-[8px]"></i>
                                            <span>Suspended</span>
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-tight">
                                            <i class="fa-solid fa-check text-[8px]"></i>
                                            <span>Active</span>
                                        </div>
                                    @endif
                                </td>
                                <!-- Subscription Status Column -->
                                <td class="py-4 px-4 text-center">
                                    @php
                                        $displayStatus = $shop->display_status;
                                        $statusClasses = [
                                            'active' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'trial' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'grace' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'expired' => 'bg-orange-100 text-orange-700 border-orange-200',
                                            'cancelled' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        ];
                                        $statusClass =
                                            $statusClasses[$displayStatus] ??
                                            'bg-gray-100 text-gray-700 border-gray-200';

                                        $statusIcons = [
                                            'active' => 'fa-circle-check',
                                            'trial' => 'fa-clock',
                                            'grace' => 'fa-hourglass-half',
                                            'expired' => 'fa-circle-exclamation',
                                            'cancelled' => 'fa-circle-xmark',
                                        ];
                                        $statusIcon = $statusIcons[$displayStatus] ?? 'fa-circle';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                        <i class="fa-solid {{ $statusIcon }} text-[10px]"></i>
                                        {{ ucfirst($displayStatus === 'grace' ? 'Grace Period' : $displayStatus) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <p class="text-xs font-medium text-gray-600">{{ $shop->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-[10px] text-gray-400">{{ $shop->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 group-hover:opacity-100 transition-opacity">
                                        @if (!$shop->is_suspended)
                                            <form method="POST" action="{{ route('admin.shops.suspend', $shop->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to suspend this shop?')"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                    title="Suspend Shop">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.shops.activate', $shop->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to activate this shop?')"
                                                    class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                                    title="Activate Shop">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.shops.show', $shop->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-store-slash text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold mb-1">No Shops Found</h3>
                                        <p class="text-gray-500 text-sm mb-6">We couldn't find any shops matching your
                                            search criteria. Try adjusting your filters.</p>
                                        <a href="{{ route('admin.shops') }}"
                                            class="text-indigo-600 font-medium text-sm hover:underline">Clear all
                                            filters</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $shops->links() }}
            </div>
        </div>
    </div>
@endsection
