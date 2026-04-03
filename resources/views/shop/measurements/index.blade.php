@extends('layouts.shop')

@section('header', 'Measurements')

@section('content')
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <i class="fa-solid fa-ruler-combined text-indigo-600"></i> Measurement Records
                </h3>
                <div class="text-sm text-gray-500">
                    Sorted by most recent
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                            <th class="p-4 font-semibold">Customer</th>
                            <th class="p-4 font-semibold">Type</th>
                            <th class="p-4 font-semibold">Date</th>
                            <th class="p-4 font-semibold">Key Specs</th>
                            <th class="p-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($measurements as $measurement)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-gray-900">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                            {{ substr($measurement->customer->name, 0, 1) }}
                                        </div>
                                        {{ $measurement->customer->name }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold border border-gray-200 uppercase">
                                        {{ $measurement->template ? $measurement->template->getDisplayName($measurement->getDisplayLanguage()) : str_replace('_', ' ', $measurement->type) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    {{ $measurement->created_at->format('d M Y') }}
                                </td>
                                <td class="p-4 text-xs text-gray-500 max-w-xs truncate">
                                    @if($measurement->template && $measurement->template->columns->isNotEmpty())
                                        @foreach($measurement->template->columns->take(3) as $column)
                                            @if(isset($measurement->data[$column->field_name]))
                                                <span class="bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 mr-1">
                                                    {{ $column->getDisplayLabel($measurement->getDisplayLanguage()) }}: {{ $measurement->data[$column->field_name] }}{{ $column->unit }}
                                                </span>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach (array_slice($measurement->data, 0, 3) as $key => $val)
                                            <span
                                                class="bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 mr-1">{{ ucfirst($key) }}:
                                                {{ $val }}</span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('measurements.show', $measurement) }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                            title="View Details">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('customers.measurements.edit', $measurement->customer_id) }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-200"
                                            title="Edit Measurement">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <a href="{{ route('customers.show', $measurement->customer_id) }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white transition-all duration-200"
                                            title="Customer Profile">
                                            <i class="fa-solid fa-user text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-ruler-horizontal text-4xl text-gray-200"></i>
                                        <p class="text-lg font-medium">No measurements recorded yet.</p>
                                        <p class="text-sm">Start by selecting a customer from the <a
                                                href="{{ route('customers.index') }}"
                                                class="text-indigo-600 underline">Customer List</a>.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $measurements->links() }}
            </div>

        </div>
    </div>
@endsection
