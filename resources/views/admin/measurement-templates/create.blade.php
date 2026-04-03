@extends('layouts.admin')

@section('header', 'Create Measurement Template')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.measurement-templates.index') }}" 
               class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Templates
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-ruler-combined text-indigo-600"></i> Create New Template
                </h3>
                <p class="text-gray-500 text-sm mt-1">Define a new measurement template for different clothing types.</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('admin.measurement-templates.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Template Type <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="type" 
                               id="type" 
                               required
                               class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                               placeholder="e.g., shalwar_kameez, pant_coat, kurta"
                               value="{{ old('type') }}">
                        <p class="mt-1 text-sm text-gray-500">Use lowercase with underscores, no spaces.</p>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name (English) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               required
                               class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                               placeholder="e.g., Shalwar Kameez"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="name_urdu" class="block text-sm font-medium text-gray-700 mb-2">
                            Name (Urdu)
                        </label>
                        <input type="text" 
                               name="name_urdu" 
                               id="name_urdu" 
                               class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-right"
                               placeholder="e.g., شلوار قمیض"
                               value="{{ old('name_urdu') }}">
                        <p class="mt-1 text-sm text-gray-500">Optional - Will be shown when Urdu language is selected.</p>
                        @error('name_urdu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Inactive templates won't be available for use.</p>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.measurement-templates.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fa-solid fa-plus"></i> Create Template
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection