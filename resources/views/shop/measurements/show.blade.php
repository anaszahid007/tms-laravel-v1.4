@extends('layouts.shop')

@section('header', 'Measurement Details')

@section('content')
    <div class="space-y-6">

        <!-- Measurement Info Card -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-white shadow-lg flex items-center justify-center text-indigo-600 font-bold text-2xl border-2 border-indigo-100">
                            <i class="fa-solid fa-ruler-combined"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $measurement->template ? $measurement->template->getDisplayName($measurement->getDisplayLanguage()) : str_replace('_', ' ', ucfirst($measurement->type)) }}
                            </h1>
                            <p class="text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fa-solid fa-user text-indigo-500"></i>
                                <span>{{ $measurement->customer->name }}</span>
                                <span class="text-gray-400">•</span>
                                <span>ID: #{{ $measurement->measurement_key }}</span>
                                @if($measurement->template)
                                    <span class="text-gray-400">•</span>
                                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">
                                        Template: {{ $measurement->template->name }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Recorded on</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $measurement->created_at->format('M d, Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $measurement->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <!-- Measurement Data Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    @if($measurement->template && $measurement->template->columns->isNotEmpty())
                        @foreach($measurement->template->columns->sortBy('sort_order') as $column)
                            @if(isset($measurement->data[$column->field_name]))
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                    <div class="text-xs uppercase tracking-wide text-gray-500 font-semibold">
                                        {{ $column->getDisplayLabel($measurement->getDisplayLanguage()) }}
                                    </div>
                                    <div class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ $measurement->data[$column->field_name] }} <span class="text-sm text-gray-500">{{ $column->unit }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        @foreach($measurement->data as $key => $value)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                <div class="text-xs uppercase tracking-wide text-gray-500 font-semibold">
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                </div>
                                <div class="text-2xl font-bold text-gray-900 mt-1">
                                    {{ $value }} <span class="text-sm text-gray-500">inches</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Notes Section -->
                @if($measurement->notes)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-note-sticky text-indigo-600"></i>
                            Special Instructions
                        </h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-gray-700">{{ $measurement->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <div class="flex gap-3">
                        <a href="{{ route('customers.measurements.edit', $measurement->customer_id) }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-edit"></i>
                            Edit Measurement
                        </a>
                        <a href="{{ route('customers.show', $measurement->customer) }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-user"></i>
                            View Customer
                        </a>
                    </div>
                    <form method="POST" action="{{ route('measurements.destroy', $measurement) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this measurement?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Recent Measurements for this Customer -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-indigo-600"></i>
                    Recent Measurements for {{ $measurement->customer->name }}
                </h2>
            </div>
            <div class="p-8">
                @php
                    $recentMeasurements = $measurement->customer->measurements()
                        ->where('id', '!=', $measurement->id)
                        ->latest()
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentMeasurements->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentMeasurements as $recent)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                                        <i class="fa-solid fa-ruler"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ str_replace('_', ' ', ucfirst($recent->type)) }}</h3>
                                        <p class="text-sm text-gray-500">{{ $recent->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-600">
                                        {{ count($recent->data) }} measurements
                                    </span>
                                    <a href="{{ route('measurements.show', $recent) }}"
                                       class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fa-solid fa-ruler-horizontal text-4xl text-gray-200 mb-3"></i>
                        <p class="text-gray-500">No other measurements found for this customer.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection