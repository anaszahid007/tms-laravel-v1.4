@extends('layouts.shop')

@section('header', 'Orders')

@section('content')
    <div x-data="{
        selectedOrders: [],
        confirmStatus: false,
        confirmFulfill: false,
        currentStatus: 'pending',
        processingAction: null, // 'status', 'fulfill', 'search', 'filter', 'table'
        filterStatus: 'all',
        paymentStatus: 'all', // 'all', 'paid', 'unpaid'
        perPage: 30,
        searchQuery: '{{ request('search') }}',
    
        toggleAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            if (this.selectedOrders.length === checkboxes.length && checkboxes.length > 0) {
                this.selectedOrders = [];
            } else {
                this.selectedOrders = Array.from(checkboxes).map(c => c.value);
            }
        },
    
        async performBulkAction(action) {
            if (this.selectedOrders.length === 0) return;
    
            this.processingAction = action;
    
            try {
                const payload = {
                    order_ids: this.selectedOrders,
                    action: action
                };
                if (action === 'status') {
                    payload.status = this.currentStatus;
                }
    
                const response = await fetch('{{ route('orders.bulk-update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(payload)
                });
    
                const data = await response.json();
    
                if (response.ok) {
                    this.selectedOrders = [];
                    this.confirmStatus = false;
                    this.confirmFulfill = false;
    
                    // Refresh table
                    this.refreshTable(1, 'table');
    
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                } else {
                    let errorMsg = data.message || 'Validation failed';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors).flat().join('\n');
                    }
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error (' + response.status + ')',
                            text: errorMsg
                        });
                    }
                }
            } catch (error) {
                console.error('Bulk Action Failed:', error);
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.'
                    });
                }
            } finally {
                this.processingAction = null;
            }
        },
    
        async refreshTable(page = 1, action = 'filter') {
            this.processingAction = action;
            const container = document.getElementById('orders-table-container');
            if (container) container.style.opacity = '0.5';
    
            const url = new URL(`{{ route('orders.index') }}`, window.location.origin);
            url.searchParams.append('search', this.searchQuery);
            url.searchParams.append('page', page);
            url.searchParams.append('status', this.filterStatus);
            url.searchParams.append('payment_status', this.paymentStatus);
            url.searchParams.append('per_page', this.perPage);
    
            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                if (container) {
                    container.innerHTML = html;
                    this.selectedOrders = [];
    
                    // Re-bind pagination buttons after table update
                    this.$nextTick(() => {
                        window.bindOrderPagination();
                    });
                }
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                this.processingAction = null;
                if (container) container.style.opacity = '1';
                this.toggleClearButton();
            }
        },
    
        toggleClearButton() {
            const clearBtn = document.getElementById('clear-search');
            if (clearBtn) {
                if (this.searchQuery.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }
        },
    
        clearSearch() {
            this.searchQuery = '';
            this.refreshTable(1, 'search');
            this.$refs.searchInput.focus();
        },
    
        init() {
            window.refreshOrdersTable = (page) => this.refreshTable(page, 'table');
            this.toggleClearButton();
        }
    }" class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 relative">
        <div class="p-6 text-gray-900">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-600"></i> Manage Orders
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Track and manage your tailor shop orders</p>
                </div>

                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <div class="flex w-full md:w-auto relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="text" x-model="searchQuery" x-ref="searchInput" @input="toggleClearButton()"
                            @keypress.enter="refreshTable()" placeholder="Search order # or customer..."
                            class="w-full md:w-72 pl-10 pr-10 rounded-l-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all">

                        <!-- Clear Button -->
                        <button type="button" id="clear-search" @click="clearSearch()"
                            class="absolute right-[110px] top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors hidden">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>

                        <button type="button" @click="refreshTable(1, 'search')" :disabled="processingAction"
                            class="bg-indigo-600 text-white px-5 py-2.5 rounded-r-xl hover:bg-indigo-700 font-bold transition flex items-center gap-2 min-w-[100px] justify-center shadow-md">
                            <span x-show="processingAction !== 'search'">Search</span>
                            <i x-show="processingAction === 'search'" class="fa-solid fa-circle-notch fa-spin"></i>
                        </button>
                    </div>

                    <a href="{{ route('orders.create') }}"
                        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl hover:bg-indigo-700 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 font-bold">
                        <i class="fa-solid fa-plus-circle"></i>
                        New Order
                    </a>
                </div>
            </div>

            <!-- Filters Section -->
            <div
                class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-6 p-5 bg-gray-50/50 rounded-2xl border border-gray-100">
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest min-w-[100px]">Filter
                            Status:</span>
                        <div class="flex flex-wrap items-center gap-1.5">
                            <button @click="filterStatus = 'all'"
                                :class="filterStatus === 'all' ? 'bg-indigo-600 text-white shadow-indigo-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                All
                            </button>
                            <button @click="filterStatus = 'pending'"
                                :class="filterStatus === 'pending' ? 'bg-yellow-500 text-white shadow-yellow-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                Pending
                            </button>
                            <button @click="filterStatus = 'in_progress'"
                                :class="filterStatus === 'in_progress' ? 'bg-blue-500 text-white shadow-blue-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                In Progress
                            </button>
                            <button @click="filterStatus = 'completed'"
                                :class="filterStatus === 'completed' ? 'bg-green-500 text-white shadow-green-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                Completed
                            </button>
                            <button @click="filterStatus = 'delivered'"
                                :class="filterStatus === 'delivered' ? 'bg-purple-500 text-white shadow-purple-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                Delivered
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span
                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest min-w-[100px]">Payment:</span>
                        <div class="flex flex-wrap items-center gap-1.5">
                            <button @click="paymentStatus = 'all'"
                                :class="paymentStatus === 'all' ? 'bg-indigo-600 text-white shadow-indigo-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                All
                            </button>
                            <button @click="paymentStatus = 'paid'"
                                :class="paymentStatus === 'paid' ? 'bg-emerald-600 text-white shadow-emerald-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                Paid
                            </button>
                            <button @click="paymentStatus = 'unpaid'"
                                :class="paymentStatus === 'unpaid' ? 'bg-red-600 text-white shadow-red-200' :
                                    'bg-white text-gray-600 hover:bg-gray-100'"
                                class="px-3 py-2 rounded-xl text-[11px] font-bold transition-all shadow-sm border border-transparent">
                                Unpaid (Remaining)
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 xl:ml-auto xl:self-end">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Show:</span>
                        <select x-model="perPage"
                            class="h-10 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-2 pl-4 pr-10 cursor-pointer transition-all appearance-none shadow-sm">
                            <option value="10">10 Rows</option>
                            <option value="30">30 Rows</option>
                            <option value="50">50 Rows</option>
                            <option value="100">100 Rows</option>
                        </select>
                    </div>

                    <button @click="refreshTable(1, 'filter')" :disabled="processingAction"
                        class="h-10 bg-indigo-600 text-white px-6 rounded-xl hover:bg-indigo-700 font-bold text-[10px] uppercase tracking-widest transition-all shadow-md flex items-center gap-2 min-w-[140px] justify-center">
                        <span x-show="processingAction !== 'filter'" class="flex items-center gap-2">
                            <i class="fa-solid fa-filter text-[10px]"></i>
                            Apply Filters
                        </span>
                        <i x-show="processingAction === 'filter'" class="fa-solid fa-circle-notch fa-spin"></i>
                    </button>
                </div>
            </div>

            <div id="orders-table-container">
                @include('shop.orders._table')
            </div>

        </div>

        <!-- Bulk Action Toolbar (AJAX Powered) -->
        <div x-show="selectedOrders.length > 0" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-20" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-20"
            class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 bg-white/95 backdrop-blur-md border border-indigo-100 shadow-[0_-15px_40px_-15px_rgba(0,0,0,0.15),0_15px_40px_-15px_rgba(0,0,0,0.15)] rounded-3xl p-2.5 flex items-center gap-2 min-w-[320px] max-w-full md:min-w-[600px] ring-1 ring-black/5"
            x-cloak>

            <!-- Selection Counter -->
            <div class="flex items-center gap-2.5 px-4 h-11 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                <span
                    class="bg-indigo-600 text-white w-6 h-6 rounded-lg flex items-center justify-center font-bold text-[10px] shadow-sm shadow-indigo-200"
                    x-text="selectedOrders.length"></span>
                <span class="text-indigo-900 font-black text-[10px] uppercase tracking-tighter">Selected</span>
            </div>

            <div class="flex-1 flex items-center gap-2">
                <!-- Status Update Action -->
                <div class="relative flex items-center gap-2">
                    <select x-model="currentStatus"
                        class="h-11 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 pl-4 pr-10 cursor-pointer hover:bg-white transition-all appearance-none">
                        <option value="pending">Mark as Pending</option>
                        <option value="in_progress">Mark as In Progress</option>
                        <option value="completed">Mark as Completed</option>
                        <option value="delivered">Mark as Delivered</option>
                    </select>

                    <div class="relative">
                        <button @click="confirmStatus = !confirmStatus; confirmFulfill = false"
                            :disabled="processingAction"
                            class="h-11 bg-indigo-600 text-white px-5 rounded-2xl hover:bg-indigo-700 font-black text-[10px] uppercase tracking-widest shadow-md shadow-indigo-200 transition-all active:scale-95 whitespace-nowrap flex items-center gap-2">
                            <span x-show="processingAction !== 'status'">Update Status</span>
                            <i x-show="processingAction === 'status'" class="fa-solid fa-circle-notch fa-spin"></i>
                        </button>

                        <!-- CONFIRMATION DROPDOWN (Status) -->
                        <div x-show="confirmStatus" @click.away="confirmStatus = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute bottom-full mb-3 right-0 w-64 bg-white border border-gray-100 shadow-2xl rounded-2xl overflow-hidden z-[60] p-4 ring-1 ring-black/5">
                            <div class="text-center">
                                <i class="fa-solid fa-circle-question text-indigo-500 text-2xl mb-2"></i>
                                <h4 class="text-gray-900 font-bold text-sm">Are you sure?</h4>
                                <p class="text-gray-500 text-[11px] mt-1 mb-4">You are about to change the status of <span
                                        x-text="selectedOrders.length"></span> orders.</p>
                                <div class="flex gap-2">
                                    <button @click="confirmStatus = false"
                                        class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-xl text-[10px] font-bold hover:bg-gray-200 transition">Cancel</button>
                                    <button @click="performBulkAction('status')" :disabled="processingAction"
                                        class="flex-1 px-3 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-bold hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                                        <span x-show="processingAction !== 'status'">Yes, Update</span>
                                        <i x-show="processingAction === 'status'"
                                            class="fa-solid fa-circle-notch fa-spin"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-px h-8 bg-gray-100 mx-1"></div>

                <!-- Fulfill Action -->
                <div class="relative">
                    <button @click="confirmFulfill = !confirmFulfill; confirmStatus = false" :disabled="processingAction"
                        class="h-11 bg-emerald-600 text-white px-5 rounded-2xl hover:bg-emerald-700 font-black text-[10px] uppercase tracking-widest shadow-md shadow-emerald-200 transition-all active:scale-95 flex items-center gap-2 whitespace-nowrap">
                        <span x-show="processingAction !== 'fulfill'" class="flex items-center gap-2">
                            <i class="fa-solid fa-check-double text-xs"></i>
                            Fulfill All Remaining
                        </span>
                        <i x-show="processingAction === 'fulfill'" class="fa-solid fa-circle-notch fa-spin"></i>
                    </button>

                    <!-- CONFIRMATION DROPDOWN (Fulfill) -->
                    <div x-show="confirmFulfill" @click.away="confirmFulfill = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute bottom-full mb-3 right-0 w-72 bg-white border border-gray-100 shadow-2xl rounded-2xl overflow-hidden z-[60] p-4 ring-1 ring-black/5">
                        <div class="text-center">
                            <i class="fa-solid fa-money-bill-transfer text-emerald-500 text-2xl mb-2"></i>
                            <h4 class="text-gray-900 font-bold text-sm">Clear Remaining Balances?</h4>
                            <p class="text-gray-500 text-[11px] mt-1 mb-4">This will mark these <span
                                    x-text="selectedOrders.length"></span> orders as <span
                                    class="text-emerald-600 font-bold italic">Fully Paid</span>. This action cannot be
                                undone.</p>
                            <div class="flex gap-2">
                                <button @click="confirmFulfill = false"
                                    class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-xl text-[10px] font-bold hover:bg-gray-200 transition">Go
                                    Back</button>
                                <button @click="performBulkAction('fulfill')" :disabled="processingAction"
                                    class="flex-1 px-3 py-2 bg-emerald-600 text-white rounded-xl text-[10px] font-bold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                                    <span x-show="processingAction !== 'fulfill'">Confirm Payment</span>
                                    <i x-show="processingAction === 'fulfill'"
                                        class="fa-solid fa-circle-notch fa-spin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="selectedOrders = []"
                class="w-11 h-11 rounded-2xl flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all group"
                title="Clear selection">
                <i class="fa-solid fa-xmark text-lg group-hover:rotate-90 transition-all duration-300"></i>
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            window.bindOrderPagination = function() {
                document.querySelectorAll('.ajax-pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page');
                        if (window.refreshOrdersTable) {
                            window.refreshOrdersTable(page);
                        }
                    });
                });
            }

            // Initialize pagination binding
            document.addEventListener('DOMContentLoaded', window.bindOrderPagination);
        </script>
    @endpush
@endsection
