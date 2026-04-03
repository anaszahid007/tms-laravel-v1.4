@extends('layouts.shop')

@section('header', 'Edit Order #' . $order->order_key)

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('orders.index') }}"
                class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Orders
            </a>
        </div>

        <form method="POST" action="{{ route('orders.update', $order) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Context Card -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Customer Info</h4>
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-lg">
                                {{ substr($order->customer->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">{{ $order->customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->customer->phone }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">

                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="text-xs text-gray-400">Order Created</div>
                            <div class="font-medium text-sm text-gray-700">{{ $order->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800">Order Details</h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Status -->
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status"
                                        class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>
                                            In Progress</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                    </select>
                                </div>

                                <!-- Delivery Date -->
                                <div>
                                    <x-input-label for="delivery_date" :value="__('Delivery Date')" />
                                    <x-text-input id="delivery_date" class="block mt-1 w-full" type="date"
                                        name="delivery_date" :value="old(
                                            'delivery_date',
                                            optional($order->delivery_date)->format('Y-m-d'),
                                        )" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <!-- Total Price -->
                                <div>
                                    <x-input-label for="total_price" :value="__('Total Price')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rs.</span>
                                        </div>
                                        <x-text-input id="total_price" class="block w-full pl-10 font-bold" type="number"
                                            name="total_price" :value="old('total_price', $order->total_price)" required />
                                    </div>
                                </div>

                                <!-- Advance -->
                                <div>
                                    <x-input-label for="advance_payment" :value="__('Advance Payment')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rs.</span>
                                        </div>
                                        <x-text-input id="advance_payment" class="block w-full pl-10" type="number"
                                            name="advance_payment" :value="old('advance_payment', $order->advance_payment)" />
                                    </div>
                                </div>

                                <!-- Remaining -->
                                <div>
                                    <x-input-label for="remaining_amount" :value="__('Remaining')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rs.</span>
                                        </div>
                                        <x-text-input id="remaining_amount"
                                            class="block w-full pl-10 text-red-600 font-bold" type="number"
                                            name="remaining_amount" :value="old('remaining_amount', $order->remaining_amount)" />
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <x-input-label for="notes" :value="__('Notes')" />
                                <textarea id="notes" name="notes" rows="3"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">{{ old('notes', $order->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                            <button type="button"
                                onclick="if(confirm('Are you sure? This cannot be undone.')) document.getElementById('delete-order-form').submit()"
                                class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1 px-3 py-2 rounded hover:bg-red-50 transition">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                            <x-primary-button class="gap-2">
                                <i class="fa-solid fa-save"></i> {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form id="delete-order-form" action="{{ route('orders.destroy', $order) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
    <script>
        document.getElementById('total_price').addEventListener('input', updateRemaining);
        document.getElementById('advance_payment').addEventListener('input', updateRemaining);

        function updateRemaining() {
            const total = parseFloat(document.getElementById('total_price').value) || 0;
            const advance = parseFloat(document.getElementById('advance_payment').value) || 0;
            document.getElementById('remaining_amount').value = Math.max(0, total - advance);
        }
    </script>
@endsection
