@extends('layouts.shop')

@section('header', 'Order Details')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('orders.index') }}"
                class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Orders
            </a>
            <div class="flex gap-2">
                <a href="{{ route('orders.edit', $order) }}"
                    class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition flex items-center gap-2 shadow-sm font-bold text-sm">
                    <i class="fa-solid fa-pen"></i> Edit Order
                </a>
                <button onclick="window.print()"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2 shadow-md font-bold text-sm">
                    <i class="fa-solid fa-print"></i> Print Invoice
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Order Status & Basic Info -->
                <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-file-invoice text-indigo-500"></i> Order #{{ $order->order_key }}
                        </h3>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                                'delivered' => 'bg-purple-100 text-purple-800 border-purple-200',
                            ];
                        @endphp
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-2 gap-8 mb-8">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-1">Creation Date</p>
                                <p class="text-gray-900 font-medium">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-1">Expected Delivery
                                </p>
                                <p class="text-indigo-600 font-bold">
                                    {{ optional($order->delivery_date)->format('d M Y') ?? 'Not specified' }}
                                </p>
                            </div>
                        </div>

                        <div class="border-t border-gray-50 pt-6">
                            <p class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-2">Special Instructions
                            </p>
                            <div class="bg-gray-50 rounded-xl p-4 text-gray-700 italic border border-gray-100">
                                {{ $order->notes ?: 'No special instructions recorded for this order.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-money-check-dollar text-green-500"></i> Payment Details
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-lg">
                                <span class="text-gray-500">Total Bill</span>
                                <span class="font-bold text-gray-900">Rs. {{ number_format($order->total_price) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-lg">
                                <span class="text-gray-500">Advance Paid</span>
                                <span class="font-bold text-green-600">Rs.
                                    {{ number_format($order->advance_payment) }}</span>
                            </div>
                            <div
                                class="border-t border-dashed border-gray-200 my-4 pt-4 flex justify-between items-center text-2xl">
                                <span class="font-bold text-gray-900">Remaining Balance</span>
                                @php $remaining = $order->total_price - $order->advance_payment; @endphp
                                <span class="font-black {{ $remaining > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    Rs. {{ number_format($remaining) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="md:col-span-1 space-y-6">
                <!-- Customer Card -->
                <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Customer Profile</h4>
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-bold text-4xl mb-4 border border-indigo-100 shadow-sm">
                            {{ substr($order->customer->name, 0, 1) }}
                        </div>
                        <h5 class="font-black text-xl text-gray-900">{{ $order->customer->name }}</h5>
                        <p class="text-gray-500 mb-6">{{ $order->customer->phone }}</p>

                        <a href="{{ route('customers.show', $order->customer_id) }}"
                            class="w-full bg-indigo-50 text-indigo-700 font-bold py-3 rounded-xl hover:bg-indigo-100 transition text-sm">
                            View Full Profile
                        </a>
                    </div>
                </div>

                <!-- Actions/Quick Tips -->
                <div class="bg-indigo-900 text-white shadow-lg rounded-2xl p-6">
                    <h4 class="font-bold mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-lightbulb text-yellow-400"></i> Quick Actions
                    </h4>
                    <div class="space-y-3">
                        <p class="text-indigo-200 text-xs">You can update the status as work progresses to keep track of
                            your workshop output.</p>
                        <div class="grid grid-cols-1 gap-2 mt-4">
                            <form action="{{ route('orders.update', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
                                <input type="hidden" name="total_price" value="{{ $order->total_price }}">
                                <input type="hidden" name="advance_payment" value="{{ $order->advance_payment }}">

                                @if ($order->status == 'pending')
                                    <button name="status" value="in_progress"
                                        class="w-full bg-indigo-700/50 hover:bg-indigo-800 text-white text-xs font-bold py-2 rounded-lg transition border border-indigo-700 mt-2">
                                        Start Progress
                                    </button>
                                @elseif($order->status == 'in_progress')
                                    <button name="status" value="completed"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded-lg transition mt-2">
                                        Mark Completed
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
