@extends('layouts.admin')

@section('header', 'Subscription Plan Details')

@section('content')
    <div class="max-w-4xl">
        <!-- Header Actions -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.subscription-plans.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white border border-gray-200 hover:border-gray-300 rounded-lg transition-all">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Plans
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit Plan
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Plan Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Plan Information</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Plan
                                Name</label>
                            <p class="text-lg font-bold text-gray-900">{{ $subscriptionPlan->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Price</label>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rs. {{ number_format($subscriptionPlan->price, 0) }}</p>
                                <p class="text-xs text-gray-500 mt-1">PKR</p>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Duration</label>
                                <p class="text-2xl font-bold text-gray-900">{{ $subscriptionPlan->duration_days }}</p>
                                <p class="text-xs text-gray-500 mt-1">days</p>
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Slug</label>
                            <p
                                class="text-sm font-mono text-gray-700 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                                {{ $subscriptionPlan->slug }}
                            </p>
                        </div>
                        @if ($subscriptionPlan->description)
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $subscriptionPlan->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Features Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Features</h3>
                    </div>
                    <div class="p-6">
                        @if ($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                            <ul class="space-y-3">
                                @foreach ($subscriptionPlan->features as $feature)
                                    <li class="flex items-start gap-3">
                                        <div
                                            class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fa-solid fa-check text-emerald-600 text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <i class="fa-solid fa-list-ul text-3xl text-gray-200 mb-3"></i>
                                <p class="text-sm text-gray-500">No features defined for this plan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800">Status</h3>
                    </div>
                    <div class="p-6">
                        @if ($subscriptionPlan->is_active)
                            <div
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-50 border border-emerald-200">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                <span class="text-sm font-semibold text-emerald-700">Active</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">This plan is currently active and available for
                                subscription.</p>
                        @else
                            <div
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-50 border border-gray-200">
                                <i class="fa-solid fa-circle-xmark text-gray-600"></i>
                                <span class="text-sm font-semibold text-gray-700">Inactive</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">This plan is currently inactive and not available for new
                                subscriptions.</p>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800">Statistics</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Subscribers</span>
                            <span class="text-lg font-bold text-gray-900">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Active Subscribers</span>
                            <span class="text-lg font-bold text-emerald-600">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Revenue Generated</span>
                            <span class="text-lg font-bold text-gray-900">Rs. 0</span>
                        </div>
                    </div>
                </div>

                <!-- Metadata Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800">Metadata</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Created
                                At</span>
                            <span class="text-gray-700">{{ $subscriptionPlan->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Last
                                Updated</span>
                            <span class="text-gray-700">{{ $subscriptionPlan->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-red-200 bg-red-50">
                        <h3 class="text-sm font-bold text-red-800">Danger Zone</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-xs text-gray-600 mb-4">Deleting this plan is permanent and cannot be undone.</p>
                        <form method="POST"
                            action="{{ route('admin.subscription-plans.destroy', $subscriptionPlan->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this subscription plan? This action cannot be undone and may affect existing subscribers.')"
                                class="w-full px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-trash-can"></i>
                                Delete Plan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
