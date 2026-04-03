@extends('layouts.shop')

@section('header', 'Customer Details')

@section('content')
    <div class="space-y-6">

        <!-- Customer Info Card -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div
                            class="w-16 h-16 rounded-2xl bg-white shadow-lg flex items-center justify-center text-indigo-600 font-bold text-2xl border-2 border-indigo-100">
                            {{ substr($customer->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fa-solid fa-user text-indigo-500"></i>
                                <span class="capitalize">{{ $customer->gender }}</span>
                                <span class="text-gray-400">•</span>
                                <span>Customer ID: <strong>{{ $customer->customer_key }}</strong></span>
                                @if ($customer->father_name)
                                    <span class="text-gray-400">•</span>
                                    <span>Father's Name: <strong>{{ $customer->father_name }}</strong></span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Member since</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-address-card text-indigo-600"></i>
                            Contact Information
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone Number</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fa-solid fa-envelope text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->email ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Location -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-map-marker-alt text-red-600"></i>
                            Location
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mt-1">
                                    <i class="fa-solid fa-home text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Address</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->address ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout: Measurements & Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Measurements -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-xl text-gray-900 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-ruler-combined"></i>
                            </div>
                            Measurements
                        </h3>
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $customer->measurements->count() }} Total
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if ($customer->measurements->isEmpty())
                        <div class="text-center py-8">
                            <div
                                class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-4">
                                <i class="fa-solid fa-ruler-combined text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">No Measurements Yet</h4>
                            <p class="text-gray-500 mb-4">Start by adding your first measurement for this customer.</p>
                            <a href="{{ route('measurements.create', ['customer_id' => $customer->id]) }}"
                                class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                <i class="fa-solid fa-plus"></i>
                                Add First Measurement
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($customer->measurements as $measurement)
                                <div
                                    class="border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-indigo-200 transition-all duration-200 bg-gradient-to-br from-white to-gray-50">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                                                <i class="fa-solid fa-tshirt text-sm"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-900 capitalize">
                                                    {{ str_replace('_', ' ', $measurement->type) }}
                                                </h4>
                                                <p class="text-sm text-gray-500">Added
                                                    {{ $measurement->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('customers.measurements.edit', $customer) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold hover:bg-indigo-200 transition">
                                                <i class="fa-solid fa-pen"></i>
                                                Edit
                                            </a>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                        @foreach ($measurement->data as $key => $value)
                                            <div class="bg-white rounded-lg p-3 border border-gray-100">
                                                <p class="text-xs text-gray-500 uppercase tracking-wide">
                                                    {{ str_replace('_', ' ', $key) }}</p>
                                                <p class="font-bold text-gray-900 text-lg">{{ $value }}"</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($measurement->notes)
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                            <p class="text-sm text-gray-700">
                                                <i class="fa-solid fa-sticky-note text-yellow-600 mr-2"></i>
                                                <span class="font-medium">Notes:</span> {{ $measurement->notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Orders -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-xl text-gray-900 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                                <i class="fa-solid fa-shopping-bag"></i>
                            </div>
                            Recent Orders
                        </h3>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $customer->orders->count() }} Total
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if ($customer->orders->isEmpty())
                        <div class="text-center py-8">
                            <div
                                class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-4">
                                <i class="fa-solid fa-shopping-bag text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">No Orders Yet</h4>
                            <p class="text-gray-500 mb-4">Create your first order for this customer.</p>
                            <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}"
                                class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                <i class="fa-solid fa-plus"></i>
                                Create First Order
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($customer->orders as $order)
                                <div
                                    class="border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-green-200 transition-all duration-200 bg-gradient-to-br from-white to-gray-50">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                                <i class="fa-solid fa-receipt text-sm"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-900">Order #{{ $order->order_key }}
                                                </h4>
                                                <p class="text-sm text-gray-500">Created
                                                    {{ $order->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold uppercase {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : ($order->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ str_replace('_', ' ', $order->status) }}
                                            </span>
                                            <a href="{{ route('orders.edit', $order) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition">
                                                <i class="fa-solid fa-eye"></i>
                                                View
                                            </a>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div class="bg-white rounded-lg p-3 border border-gray-100">
                                            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Amount</p>
                                            <p class="font-bold text-gray-900 text-lg">Rs.
                                                {{ number_format($order->total_price) }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 border border-gray-100">
                                            <p class="text-xs text-gray-500 uppercase tracking-wide">Advance Paid</p>
                                            <p class="font-bold text-green-600 text-lg">Rs.
                                                {{ number_format($order->advance_payment) }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 border border-gray-100">
                                            <p class="text-xs text-gray-500 uppercase tracking-wide">Remaining Balance</p>
                                            <p class="font-bold text-red-600 text-lg">Rs.
                                                {{ number_format($order->total_price - $order->advance_payment) }}</p>
                                        </div>
                                    </div>

                                    @if ($order->delivery_date)
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                            <p class="text-sm text-blue-700">
                                                <i class="fa-solid fa-calendar-check text-blue-600 mr-2"></i>
                                                <span class="font-medium">Delivery Due:</span>
                                                {{ $order->delivery_date->format('l, M d, Y') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
