@extends('layouts.admin')

@section('header', 'Referral Partners')

@section('content')
    <div x-data="{
        selected: [],
        showCreateModal: false,
        showEditModal: false,
        editPartner: null,
        get allSelected() {
            return this.selected.length === {{ $partners->count() }};
        },
        toggleAll() {
            if (this.allSelected) {
                this.selected = [];
            } else {
                this.selected = [@foreach ($partners as $p)'{{ $p->id }}'@if (!$loop->last),@endif @endforeach];
            }
        },
        copyReferralLink(code) {
            const url = '{{ url('/register') }}?ref=' + code;
            navigator.clipboard.writeText(url).then(() => {
                showToast('Referral link copied to clipboard!', 'success');
            }).catch(() => {
                showToast('Failed to copy link', 'error');
            });
        }
    }" class="mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">

            <!-- Toolbar: Title, Filters, Search, Create Button -->
            <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">

                <!-- Left Side: Title & Filters -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <h2 class="text-lg font-bold text-gray-800 whitespace-nowrap">All Partners</h2>

                    <div class="flex bg-gray-100/80 p-1 rounded-lg self-start sm:self-auto">
                        <a href="{{ route('admin.referrals.index') }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ !request('status') ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            All
                        </a>
                        <a href="{{ route('admin.referrals.index', ['status' => 'active']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'active' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Active
                        </a>
                        <a href="{{ route('admin.referrals.index', ['status' => 'suspended']) }}"
                            class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('status') === 'suspended' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Suspended
                        </a>
                    </div>
                </div>

                <!-- Right Side: Bulk Actions, Search & Create Button -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                    <!-- Bulk Actions (Visible when selected) -->
                    <div x-show="selected.length > 0" x-transition.opacity.duration.200ms
                        class="bg-indigo-50 border border-indigo-100 px-3 py-2 rounded-lg flex items-center justify-between gap-3"
                        style="display: none;">
                        <span class="text-xs font-bold text-indigo-700 whitespace-nowrap"
                            x-text="selected.length + ' selected'"></span>

                        <form method="POST" action="{{ route('admin.referrals.bulk-action') }}"
                            class="flex items-center gap-1">
                            @csrf
                            <template x-for="id in selected" :key="id">
                                <input type="hidden" name="ids[]" :value="id">
                            </template>

                            <button type="submit" name="action" value="activate"
                                onclick="return confirm('Activate selected partners?')"
                                class="w-7 h-7 flex items-center justify-center rounded bg-white text-emerald-600 hover:text-emerald-700 shadow-sm border border-emerald-100 transition-colors"
                                title="Activate Selected">
                                <i class="fa-solid fa-check text-xs"></i>
                            </button>
                            <button type="submit" name="action" value="suspend"
                                onclick="return confirm('Suspend selected partners?')"
                                class="w-7 h-7 flex items-center justify-center rounded bg-white text-red-600 hover:text-red-700 shadow-sm border border-red-100 transition-colors"
                                title="Suspend Selected">
                                <i class="fa-solid fa-ban text-xs"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.referrals.index') }}" class="relative w-full sm:w-64">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, email..."
                            class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-gray-400">
                    </form>

                    <!-- Create Button -->
                    <button @click="showCreateModal = true"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-plus"></i>
                        Add Partner
                    </button>
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
                            <th class="py-4 px-4">Partner Info</th>
                            <th class="py-4 px-4 text-center">Referral Code</th>
                            <th class="py-4 px-4 text-center">Commission</th>
                            <th class="py-4 px-4 text-center">Conversions</th>
                            <th class="py-4 px-4 text-center">Earnings</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($partners as $partner)
                            <tr class="hover:bg-gray-50/80 transition-colors group"
                                :class="selected.includes('{{ $partner->id }}') ? 'bg-indigo-50/40' : ''">
                                <td class="py-4 px-6">
                                    <input type="checkbox" value="{{ $partner->id }}" x-model="selected"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer w-4 h-4">
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 text-purple-600 flex items-center justify-center font-bold text-sm shadow-sm ring-1 ring-black/5">
                                            {{ substr($partner->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p
                                                class="font-bold text-sm text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $partner->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $partner->email }}</p>
                                            @if ($partner->phone)
                                                <p class="text-[10px] text-gray-400">{{ $partner->phone }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <code
                                            class="px-3 py-1.5 bg-gray-100 border border-gray-200 rounded-lg text-xs font-mono font-bold text-gray-800">
                                            {{ $partner->referral_code }}
                                        </code>
                                        <button @click="copyReferralLink('{{ $partner->referral_code }}')"
                                            class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-all"
                                            title="Copy Referral Link">
                                            <i class="fa-solid fa-copy text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex flex-col items-center">
                                        @if ($partner->commission_type === 'percentage')
                                            <span
                                                class="text-sm font-bold text-gray-900">{{ $partner->commission_value }}%</span>
                                            <span class="text-[10px] text-gray-400 uppercase">Percentage</span>
                                        @else
                                            <span class="text-sm font-bold text-gray-900">Rs.
                                                {{ number_format($partner->commission_value, 0) }}</span>
                                            <span class="text-[10px] text-gray-400 uppercase">Fixed</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $partner->conversions_count ?? 0 }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-sm font-bold text-emerald-600">Rs.
                                        {{ number_format($partner->earnings_sum_amount ?? 0, 0) }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if ($partner->status === 'active')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                            <i class="fa-solid fa-ban text-[10px]"></i>
                                            Suspended
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.referrals.show', $partner->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <button @click="editPartner = {{ $partner }}; showEditModal = true"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                            title="Edit Partner">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <form method="POST"
                                            action="{{ route('admin.referrals.destroy', $partner->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this partner? This action cannot be undone.')"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Delete Partner">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-handshake-slash text-2xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold mb-1">No Partners Found</h3>
                                        <p class="text-gray-500 text-sm mb-6">
                                            @if (request('search'))
                                                We couldn't find any partners matching "{{ request('search') }}".
                                            @else
                                                Get started by adding your first referral partner.
                                            @endif
                                        </p>
                                        @if (request('search') || request('status'))
                                            <a href="{{ route('admin.referrals.index') }}"
                                                class="text-indigo-600 font-medium text-sm hover:underline">Clear all
                                                filters</a>
                                        @else
                                            <button @click="showCreateModal = true"
                                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">
                                                <i class="fa-solid fa-plus mr-2"></i>Add Your First Partner
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $partners->links() }}
            </div>
        </div>

        <!-- Create Modal -->
        @include('admin.referrals.partials.create-modal')

        <!-- Edit Modal -->
        @include('admin.referrals.partials.edit-modal')
    </div>
@endsection
