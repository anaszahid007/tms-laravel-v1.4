<div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                <th class="p-4 font-semibold w-10">
                    <input type="checkbox" @click="toggleAll()"
                        :checked="selectedOrders.length > 0 && selectedOrders.length === document.querySelectorAll(
                            '.order-checkbox').length"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </th>
                <th class="p-4 font-semibold">Order #</th>
                <th class="p-4 font-semibold">Customer</th>
                <th class="p-4 font-semibold">Status</th>
                <th class="p-4 font-semibold">Start Date</th>
                <th class="p-4 font-semibold">Due Date</th>
                <th class="p-4 font-semibold">Total</th>
                <th class="p-4 font-semibold">Remaining</th>
                <th class="p-4 font-semibold text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition" x-bind:key="'order-row-{{ $order->id }}'"
                    :class="selectedOrders.includes('{{ $order->id }}') ? 'bg-indigo-50/30' : ''">
                    <td class="p-4">
                        <input type="checkbox" value="{{ $order->id }}" x-model="selectedOrders"
                            id="checkbox-{{ $order->id }}"
                            class="order-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </td>
                    <td class="p-4 font-mono text-xs text-indigo-500 font-bold bg-indigo-50/50 rounded-r-none">
                        {{ $order->order_key }}</td>
                    <td class="p-4 font-medium text-gray-900">{{ $order->customer->name }}</td>
                    <td class="p-4">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                                'delivered' => 'bg-purple-100 text-purple-800 border-purple-200',
                            ];
                            $icons = [
                                'pending' => 'fa-clock',
                                'in_progress' => 'fa-spinner fa-spin',
                                'completed' => 'fa-check',
                                'delivered' => 'fa-box-open',
                            ];
                        @endphp
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold border flex items-center gap-1 w-max {{ $colors[$order->status] ?? 'bg-gray-100' }}">
                            <i class="fa-solid {{ $icons[$order->status] ?? 'fa-circle' }}"></i>
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        @if ($order->start_date)
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar-alt text-gray-400"></i>
                                {{ $order->start_date->format('d M') }}
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        @if ($order->delivery_date)
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar-alt text-gray-400"></i>
                                {{ $order->delivery_date->format('d M') }}
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-gray-800">Rs. {{ number_format($order->total_price) }}</td>
                    <td class="p-4">
                        @if ($order->remaining_amount > 0)
                            <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded text-xs">Rs.
                                {{ number_format($order->remaining_amount) }}</span>
                        @else
                            <span class="text-green-600 font-bold text-xs"><i class="fa-solid fa-check-double"></i>
                                Paid</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('orders.show', $order) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                title="View Details">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('orders.edit', $order) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-200"
                                title="Edit Order">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200"
                                    title="Delete Order">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                            <p class="text-lg font-medium">No orders found.</p>
                            <a href="{{ route('orders.create') }}"
                                class="text-indigo-600 hover:underline text-sm mt-1">Create your first order</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 ajax-pagination">
    {{ $orders->links() }}
</div>
