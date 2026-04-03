<div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                <th class="p-4 font-semibold">Name</th>
                <th class="p-4 font-semibold">Phone</th>
                <th class="p-4 font-semibold">Measurement</th>
                <th class="p-4 font-semibold text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($customers as $customer)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs uppercase">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold">{{ $customer->name }}</div>
                                @if ($customer->father_name)
                                    <div class="text-[11px] text-gray-500 font-medium">s/o {{ $customer->father_name }}
                                    </div>
                                @endif
                                <div class="text-[10px] text-indigo-600 font-medium">{{ $customer->customer_key }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-gray-600">
                        <i class="fa-solid fa-phone text-xs text-gray-400 mr-1"></i> {{ $customer->phone }}
                    </td>
                    <td class="p-4">
                        @if ($customer->measurements_count > 0)
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                <i class="fa-solid fa-check-circle mr-1"></i> Available
                            </span>
                        @else
                            <a href="{{ route('measurements.create', ['customer_id' => $customer->id]) }}"
                                class="inline-flex items-center justify-center w-8 h-8 bg-orange-50 text-orange-600 rounded-full hover:bg-orange-500 hover:text-white transition"
                                title="Create Measurement">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </a>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('customers.show', $customer) }}"
                            class="inline-flex items-center justify-center w-8 h-8 bg-indigo-50 text-indigo-600 rounded-full hover:bg-indigo-600 hover:text-white transition"
                            title="View Details">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        @if ($customer->measurements_count > 0)
                            <a href="{{ route('customers.measurements.print-latest', $customer) }}" target="_blank"
                                class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition"
                                title="Print Measurement Slip">
                                <i class="fa-solid fa-print text-xs"></i>
                            </a>
                        @endif
                        <a href="{{ route('customers.edit', $customer) }}"
                            class="inline-flex items-center justify-center w-8 h-8 bg-yellow-50 text-yellow-600 rounded-full hover:bg-yellow-500 hover:text-white transition"
                            title="Edit Customer">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <a href="{{ route('customers.measurements.edit', $customer) }}"
                            class="inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-full hover:bg-green-500 hover:text-white transition"
                            title="Edit Measurement">
                            <i class="fa-solid fa-ruler-combined text-xs"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-users-slash text-4xl text-gray-300 mb-3"></i>
                            <p>No customers found.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 ajax-pagination">
    {{ $customers->links() }}
</div>
