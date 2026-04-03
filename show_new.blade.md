@extends('layouts.shop_owner')

@section('header')
<div class="flex justify-between items-center w-full">
    <span>{{ $customer->name }}</span>
    <div class="flex space-x-2">
        <a href="{{ route('measurements.create', ['customer_id' => $customer->id]) }}">
            <button class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                + Measurement
            </button>
        </a>
        <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                + Order
            </button>
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    
    <!-- Customer Info -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <span class="block text-gray-500 text-sm uppercase tracking-wide">Phone</span>
                <span class="text-lg font-medium text-gray-900">{{ $customer->phone }}</span>
            </div>
            <div>
                <span class="block text-gray-500 text-sm uppercase tracking-wide">Gender</span>
                <span class="text-lg font-medium text-gray-900 capitalize">{{ $customer->gender }}</span>
            </div>
            <div>
                <span class="block text-gray-500 text-sm uppercase tracking-wide">Address</span>
                <span class="text-lg font-medium text-gray-900">{{ $customer->address ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout: Measurements & Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Measurements -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-900">Measurements</h3>
            </div>

            @if($customer->measurements->isEmpty())
                <p class="text-gray-500 italic">No measurements recorded.</p>
            @else
                <div class="space-y-4">
                    @foreach($customer->measurements as $measurement)
                    <div class="border border-gray-100 rounded-lg p-4 relative bg-gray-50">
                         <div class="absolute top-3 right-3">
                            <a href="{{ route('measurements.edit', $measurement) }}" class="text-xs text-indigo-500 hover:text-indigo-700 font-bold uppercase">Edit</a>
                         </div>
                        <div class="font-bold capitalize mb-2 text-indigo-600">{{ str_replace('_', ' ', $measurement->type) }}</div>
                        <div class="text-sm grid grid-cols-2 gap-y-1 gap-x-4">
                            @foreach($measurement->data as $key => $value)
                                <div class="flex justify-between border-b border-gray-200 pb-1">
                                    <span class="text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                    <span class="font-medium text-gray-900">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                        @if($measurement->notes)
                            <div class="mt-3 text-xs text-gray-500 italic">
                                "{{ $measurement->notes }}"
                            </div>
                        @endif
                        <div class="text-xs text-right text-gray-400 mt-2">{{ $measurement->created_at->format('d M Y') }}</div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Orders -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border border-gray-200">
             <h3 class="font-bold text-lg text-gray-900 mb-4">Recent Orders</h3>
             @if($customer->orders->isEmpty())
                <p class="text-gray-500 italic">No orders found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400 uppercase text-xs">
                                <th class="py-2">Order #</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Due</th>
                                <th class="py-2">Balance</th>
                                <th class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->orders as $order)
                            <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                                <td class="py-3 font-mono text-gray-700">{{ $order->order_key }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 text-gray-600">{{ $order->delivery_date ? $order->delivery_date->format('d M') : '-' }}</td>
                                <td class="py-3 font-bold text-red-500">{{ number_format($order->total_price - $order->advance_payment) }}</td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('orders.edit', $order) }}" class="text-indigo-500 hover:underline">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
