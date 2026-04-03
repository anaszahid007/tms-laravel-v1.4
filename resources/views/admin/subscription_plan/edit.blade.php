@extends('layouts.admin')

@section('header', 'Edit Subscription Plan')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.subscription-plans.index') }}"
                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Edit Plan</h2>
                        <p class="text-sm text-gray-500">Update subscription plan details</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.subscription-plans.update', $subscriptionPlan->id) }}"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Plan Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Plan Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $subscriptionPlan->name) }}" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('name') border-red-500 @enderror"
                            placeholder="e.g., Monthly Basic, Yearly Premium">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Price (PKR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rs.</span>
                            <input type="number" name="price" id="price"
                                value="{{ old('price', $subscriptionPlan->price) }}" step="0.01" min="0" required
                                class="w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('price') border-red-500 @enderror"
                                placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration_days" class="block text-sm font-semibold text-gray-700 mb-2">
                            Duration (Days) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="duration_days" id="duration_days"
                            value="{{ old('duration_days', $subscriptionPlan->duration_days) }}" min="1" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('duration_days') border-red-500 @enderror"
                            placeholder="e.g., 30 for monthly, 365 for yearly">
                        <p class="mt-1.5 text-xs text-gray-500">Common: 7 (weekly), 30 (monthly), 365 (yearly)</p>
                        @error('duration_days')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('description') border-red-500 @enderror"
                            placeholder="Brief description of what this plan offers...">{{ old('description', $subscriptionPlan->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Features -->
                    <div x-data="{ features: {{ json_encode(old('features', $subscriptionPlan->features ?? [''])) }} }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Features
                        </label>
                        <div class="space-y-2 mb-3">
                            <template x-for="(feature, index) in features" :key="index">
                                <div class="flex gap-2">
                                    <input type="text" :name="`features[${index}]`" x-model="features[index]"
                                        class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                        placeholder="e.g., Unlimited customers, 24/7 support">
                                    <button type="button" @click="features.splice(index, 1)"
                                        class="px-3 py-2.5 text-red-600 hover:bg-red-50 border border-red-200 rounded-lg transition-all">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="features.push('')"
                            class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i>
                            Add Feature
                        </button>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_active" class="text-sm font-medium text-gray-700">
                            This plan is active and available
                        </label>
                    </div>

                    <!-- Free Plan -->
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <input type="checkbox" name="is_free" id="is_free" value="1"
                            {{ old('is_free', $subscriptionPlan->is_free) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_free" class="text-sm font-medium text-gray-700">
                            This is a free plan (no payment required)
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.subscription-plans.index') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white border border-gray-200 hover:border-gray-300 rounded-lg transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-check"></i>
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
