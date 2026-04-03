@extends('layouts.admin')

@section('header', 'Payment Details')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.payments.index') }}"
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Payment Details</h2>
                            <p class="text-sm text-gray-500">Review and manage payment request</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if($payment->status === 'pending')
                            <button type="button"
                                onclick="if(confirm('Are you sure you want to approve this payment?')) { document.getElementById('approve-form').submit(); }"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2">
                                <i class="fa-solid fa-check"></i>
                                Approve
                            </button>
                            
                            <button type="button" onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2">
                                <i class="fa-solid fa-times"></i>
                                Reject
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Shop Information -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Shop Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Shop Name:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $payment->shop->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Shop Key:</span>
                                <span class="text-sm font-mono text-gray-900">{{ $payment->shop->shop_key }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Owner:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $payment->shop->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Email:</span>
                                <span class="text-sm text-gray-900">{{ $payment->shop->user->email }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Plan Information -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Subscription Plan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Plan Name:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $payment->subscriptionPlan->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Duration:</span>
                                <span class="text-sm text-gray-900">{{ $payment->subscriptionPlan->duration_days }} days</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Price:</span>
                                <span class="text-sm font-medium text-gray-900">Rs. {{ number_format($payment->subscriptionPlan->price, 0) }}</span>
                            </div>
                            @if($payment->subscriptionPlan->discount_percentage > 0)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Discount:</span>
                                    <span class="text-sm text-red-600">{{ $payment->subscriptionPlan->discount_percentage }}% OFF</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Payment Details</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Amount:</span>
                                <span class="text-sm font-bold text-gray-900">Rs. {{ number_format($payment->amount, 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Currency:</span>
                                <span class="text-sm text-gray-900">{{ $payment->currency }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Transaction ID:</span>
                                <span class="text-sm font-mono text-gray-900">{{ $payment->transaction_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Status:</span>
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-semibold
                                    @if($payment->status === 'pending') bg-yellow-100 text-yellow-700 border border-yellow-200
                                    @elseif($payment->status === 'approved') bg-emerald-100 text-emerald-700 border border-emerald-200
                                    @elseif($payment->status === 'rejected') bg-red-100 text-red-700 border border-red-200
                                    @endif">
                                    <i class="fa-solid @if($payment->status === 'pending') fa-clock @elseif($payment->status === 'approved') fa-check @else fa-times @endif text-[10px]"></i>
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Timeline</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Submitted:</span>
                                <span class="text-sm text-gray-900">{{ $payment->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            @if($payment->processed_at)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Processed:</span>
                                    <span class="text-sm text-gray-900">{{ $payment->processed_at->format('M d, Y h:i A') }}</span>
                                </div>
                                @if($payment->processedBy)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Processed By:</span>
                                        <span class="text-sm text-gray-900">{{ $payment->processedBy->name }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Proof -->
                @if($payment->payment_proof_path)
                    <div class="mt-6 bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Payment Proof</h3>
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                            </div>
                            <div>
                                <a href="{{ route('admin.payments.download-proof', $payment->id) }}" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-all">
                                    <i class="fa-solid fa-download"></i>
                                    Download Payment Proof
                                </a>
                                <p class="text-xs text-gray-500 mt-2">File: {{ basename($payment->payment_proof_path) }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                @if($payment->shop_notes || $payment->admin_notes)
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($payment->shop_notes)
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <h3 class="text-sm font-semibold text-blue-700 mb-2">Shop Notes</h3>
                                <p class="text-sm text-blue-900">{{ $payment->shop_notes }}</p>
                            </div>
                        @endif
                        @if($payment->admin_notes)
                            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                                <h3 class="text-sm font-semibold text-green-700 mb-2">Admin Notes</h3>
                                <p class="text-sm text-green-900">{{ $payment->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Reject Payment</h3>
                <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rejection Reason <span class="text-red-500">*</span>
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all"
                            placeholder="Please provide a reason for rejecting this payment..."></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white border border-gray-200 hover:border-gray-300 rounded-lg transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                            Reject Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden forms for approval -->
    <form id="approve-form" method="POST" action="{{ route('admin.payments.approve', $payment->id) }}" class="hidden">
        @csrf
    </form>
@endsection