@extends('layouts.shop')

@section('header', 'Customers')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="p-6 text-gray-900">

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex w-full md:w-auto relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="customer-search" placeholder="Search by name, phone or ID..."
                        oninput="toggleClearButton()"
                        value="{{ request('search') }}"
                        class="w-full md:w-64 pl-10 pr-10 rounded-l-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" />
                    
                    <!-- Clear Button -->
                    <button type="button" id="clear-search" onclick="clearSearch()" 
                        class="absolute right-[110px] top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors hidden">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>

                    <button type="button" onclick="performSearch()" id="search-btn"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-r-lg hover:bg-indigo-700 font-medium transition flex items-center gap-2 min-w-[100px] justify-center">
                        <span id="search-text">Search</span>
                        <i id="search-spinner" class="fa-solid fa-circle-notch fa-spin hidden"></i>
                    </button>
                </div>  
                <a href="{{ route('customers.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 flex items-center gap-2 shadow-md transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-user-plus"></i>
                    New Customer
                </a>
            </div>

            <div id="customers-table-container">
                @include('shop.customers._table')
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function toggleClearButton() {
            const input = document.getElementById('customer-search');
            const clearBtn = document.getElementById('clear-search');
            if (input.value.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        function clearSearch() {
            const input = document.getElementById('customer-search');
            input.value = '';
            toggleClearButton();
            performSearch();
            input.focus();
        }

        function performSearch(page = 1) {
            const query = document.getElementById('customer-search').value;
            const container = document.getElementById('customers-table-container');
            const btn = document.getElementById('search-btn');
            const text = document.getElementById('search-text');
            const spinner = document.getElementById('search-spinner');

            // Show loading state
            spinner.classList.remove('hidden');
            text.classList.add('hidden');
            btn.disabled = true;
            container.style.opacity = '0.5';

            fetch(`{{ route('customers.index') }}?search=${encodeURIComponent(query)}&page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                // Re-bind pagination links
                bindPagination();
            })
            .catch(error => {
                console.error('Search error:', error);
                alert('An error occurred while searching. Please try again.');
            })
            .finally(() => {
                // Hide loading state
                spinner.classList.add('hidden');
                text.classList.remove('hidden');
                btn.disabled = false;
                container.style.opacity = '1';
            });
        }

        function bindPagination() {
            document.querySelectorAll('.ajax-pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page');
                    performSearch(page);
                });
            });
        }

        // Search on Enter key
        document.getElementById('customer-search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Initialize pagination binding
        document.addEventListener('DOMContentLoaded', bindPagination);
    </script>
    @endpush
@endsection
