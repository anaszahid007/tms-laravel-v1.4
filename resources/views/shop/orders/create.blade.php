@extends('layouts.shop')

@section('header', 'New Order')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('orders.index') }}"
                class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Orders
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                    @csrf

                    <div class="bg-white shadow-lg rounded-xl border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-user-tag text-indigo-500"></i> Customer & Status
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Customer Selection -->
                            <div id="customer_section">
                                <x-input-label for="customer_id" :value="__('Select Customer')" />

                                <div class="relative mt-1">
                                    <!-- Search Input -->
                                    <div id="search_container" class="{{ isset($selectedCustomer) ? 'hidden' : '' }}">
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                                            </div>
                                            <input type="text" id="customer_search"
                                                class="block w-full pl-10 pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm py-3"
                                                placeholder="Search by Name or Phone (e.g. 0300...)" autocomplete="off">
                                            <div id="search_loading"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                                                <i class="fa-solid fa-circle-notch fa-spin text-indigo-500"></i>
                                            </div>
                                        </div>

                                        <!-- Search Results Dropdown -->
                                        <div id="customer_results"
                                            class="absolute z-[100] mt-1 w-full bg-white shadow-2xl rounded-lg border border-gray-200 max-h-60 overflow-y-auto hidden">
                                            <!-- Results injected via JS -->
                                        </div>
                                    </div>

                                    <!-- Selected Customer Display -->
                                    <div id="selected_customer_container"
                                        class="{{ isset($selectedCustomer) ? '' : 'hidden' }}">
                                        <input type="hidden" name="customer_id" id="hidden_customer_id"
                                            value="{{ $selectedCustomer->id ?? '' }}">

                                        <div
                                            class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg flex items-center gap-4 group hover:border-indigo-300 transition-colors">
                                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg shrink-0"
                                                id="selected_avatar">
                                                {{ isset($selectedCustomer) ? substr($selectedCustomer->name, 0, 1) : '' }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-bold text-gray-900 truncate" id="selected_name">
                                                    {{ $selectedCustomer->name ?? '' }}
                                                </div>
                                                <div class="text-sm text-gray-500 flex items-center gap-2">
                                                    <i class="fa-solid fa-phone text-[10px]"></i>
                                                    <span id="selected_phone">{{ $selectedCustomer->phone ?? '' }}</span>
                                                </div>
                                            </div>
                                            <button type="button" onclick="resetCustomerSelection()"
                                                class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors"
                                                title="Change Customer">
                                                <i class="fa-solid fa-xmark text-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Create New Customer Prompt -->
                                    <div id="no_results_found"
                                        class="hidden mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800 flex items-center justify-between">
                                        <span>Customer not found.</span>
                                        <a href="{{ route('customers.create') }}"
                                            class="font-bold underline hover:text-yellow-900">Create New</a>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Status -->
                                <div>
                                    <x-input-label for="status" :value="__('Order Status')" />
                                    <div class="relative mt-1">
                                        <select id="status" name="status"
                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                                            <option value="pending">Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                            <option value="delivered">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Start Date -->
                                <div>
                                    <x-input-label for="start_date" :value="__('Start Date')" />
                                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date"
                                        :value="old('start_date', date('Y-m-d'))" />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>
                                <!-- Delivery Date -->
                                <div>
                                    <x-input-label for="delivery_date" :value="__('Delivery Date')" />
                                    <x-text-input id="delivery_date" class="block mt-1 w-full" type="date"
                                        name="delivery_date" :value="old('delivery_date')" />
                                    <x-input-error :messages="$errors->get('delivery_date')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden mt-6">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-money-bill-wave text-green-500"></i> Payment Details
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Total Price -->
                                <div>
                                    <x-input-label for="total_price" :value="__('Total Amount')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rs.</span>
                                        </div>
                                        <input type="number" name="total_price" id="total_price"
                                            class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 font-bold text-lg"
                                            placeholder="0" value="{{ old('total_price') }}" required>
                                    </div>
                                </div>

                                <!-- Advance -->
                                <div>
                                    <x-input-label for="advance_payment" :value="__('Advance Received')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rs.</span>
                                        </div>
                                        <input type="number" name="advance_payment" id="advance_payment"
                                            class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"
                                            placeholder="0" value="{{ old('advance_payment') }}">
                                    </div>
                                </div>

                                <!-- Remaining (New) -->
                                <div>
                                    <x-input-label for="remaining_amount" :value="__('Remaining Amount')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rs.</span>
                                        </div>
                                        <input type="number" name="remaining_amount" id="remaining_amount"
                                            class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 text-red-600 font-bold"
                                            placeholder="0" value="{{ old('remaining_amount') }}">
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1 italic">* Fixed balance to be recovered later.
                                    </p>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <x-input-label for="notes" :value="__('Order Notes')" />
                                <textarea id="notes" name="notes" rows="3"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                                    placeholder="Any special instructions for this order...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Create Button - Moved to bottom of form -->
                    <div class="mt-6">
                        <button type="submit" form="order-form"
                            class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow flex justify-center items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> Create Order
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar / Summary -->
            <div class="lg:col-span-1">
                <div class="bg-indigo-900 text-white shadow-lg rounded-xl overflow-hidden sticky top-6">
                    <div class="p-6 border-b border-indigo-800">
                        <h3 class="font-bold text-lg">Order Summary</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <p class="text-indigo-200 text-sm">Please review the details before creating the order.</p>

                        <div class="bg-indigo-800/50 rounded-lg p-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-indigo-300">Total:</span>
                                <span class="font-bold" id="summary_total">Rs. 0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-indigo-300">Advance:</span>
                                <span class="font-medium" id="summary_advance">Rs. 0</span>
                            </div>
                            <div class="flex justify-between text-sm border-t border-indigo-700/30 pt-2">
                                <span class="text-indigo-300">Remaining:</span>
                                <span class="font-bold" id="summary_remaining">Rs. 0</span>
                            </div>
                        </div>

                        <!-- Create button removed from summary - now at bottom of form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Debounce function to limit API calls
        let searchTimeout;
        const searchInput = document.getElementById('customer_search');
        const resultsContainer = document.getElementById('customer_results');
        const loadingIndicator = document.getElementById('search_loading');
        const noResults = document.getElementById('no_results_found');

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();

            // Clear previous timeout
            clearTimeout(searchTimeout);

            // Hide everything initially
            resultsContainer.classList.add('hidden');
            noResults.classList.add('hidden');

            if (query.length < 2) return;

            // Show loading
            loadingIndicator.classList.remove('hidden');

            // Set new timeout (300ms delay)
            searchTimeout = setTimeout(() => {
                fetchCustomers(query);
            }, 300);
        });

        function fetchCustomers(query) {
            fetch(`{{ route('orders.create') }}?search=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadingIndicator.classList.add('hidden');

                    if (data.customers && data.customers.length > 0) {
                        renderResults(data.customers);
                    } else {
                        noResults.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingIndicator.classList.add('hidden');
                });
        }

        function renderResults(customers) {
            let html = '<ul class="divide-y divide-gray-100">';
            customers.forEach(customer => {
                html += `
                    <li class="p-3 hover:bg-gray-50 cursor-pointer transition-colors flex items-center gap-3"
                        onclick="selectCustomer('${customer.id}', '${customer.name.replace(/'/g, "\\'")}', '${customer.phone}')">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                            ${customer.name.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">${customer.name}</div>
                            <div class="text-xs text-gray-500">${customer.phone}</div>
                        </div>
                    </li>
                `;
            });
            html += '</ul>';

            resultsContainer.innerHTML = html;
            resultsContainer.classList.remove('hidden');
        }

        function selectCustomer(id, name, phone) {
            // Update UI
            document.getElementById('search_container').classList.add('hidden');
            document.getElementById('selected_customer_container').classList.remove('hidden');

            // Set Values
            document.getElementById('hidden_customer_id').value = id;
            document.getElementById('selected_name').textContent = name;
            document.getElementById('selected_phone').textContent = phone;
            document.getElementById('selected_avatar').textContent = name.charAt(0).toUpperCase();

            // Clear search
            searchInput.value = '';
            resultsContainer.classList.add('hidden');
        }

        function resetCustomerSelection() {
            // Update UI
            document.getElementById('selected_customer_container').classList.add('hidden');
            document.getElementById('search_container').classList.remove('hidden');

            // Reset Values
            document.getElementById('hidden_customer_id').value = '';

            // Focus search
            searchInput.focus();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });

        // Update order summary dynamically
        function updateOrderSummary() {
            const totalInput = document.getElementById('total_price');
            const advanceInput = document.getElementById('advance_payment');
            const remainingInput = document.getElementById('remaining_amount');

            const total = parseFloat(totalInput.value) || 0;
            const advance = parseFloat(advanceInput.value) || 0;
            const remaining = Math.max(0, total - advance);

            // Update the summary sidebar
            document.getElementById('summary_total').textContent = `Rs. ${total.toLocaleString()}`;
            document.getElementById('summary_advance').textContent = `Rs. ${advance.toLocaleString()}`;
            document.getElementById('summary_remaining').textContent = `Rs. ${remaining.toLocaleString()}`;

            // Also update the input field for remaining amount
            remainingInput.value = remaining;
        }

        // Add event listeners for real-time updates
        document.getElementById('total_price').addEventListener('input', updateOrderSummary);
        document.getElementById('advance_payment').addEventListener('input', updateOrderSummary);
    </script>
@endsection
