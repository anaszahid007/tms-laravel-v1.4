@extends('layouts.shop')

@section('header', 'Checkout: ' . $plan->name)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="mb-4">
            <a href="{{ route('shop.subscriptions.index') }}"
                class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Plans
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Plan Details -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Plan Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Plan Name:</span>
                        <span class="font-bold text-gray-900">{{ $plan->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Duration:</span>
                        <span class="font-bold text-gray-900">{{ $plan->duration_days }} Days</span>
                    </div>
                    <div class="flex justify-between items-baseline">
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="text-3xl font-extrabold text-indigo-600">Rs.
                            {{ number_format($plan->price, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-6 rounded-lg shadow-sm border border-indigo-100">
                <h3 class="text-xl font-bold text-indigo-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-transfer"></i> Payment Instructions
                </h3>

                @if($paymentAccounts->isNotEmpty())
                    <!-- Payment Methods Tabs -->
                    <div x-data="{ activeTab: '{{ $paymentAccounts->first()->id }}' }" class="space-y-4">
                        <!-- Tab Buttons -->
                        <div class="flex flex-wrap gap-2 bg-white rounded-lg p-1">
                            @foreach($paymentAccounts as $account)
                                <button @click="activeTab = '{{ $account->id }}'"
                                    :class="activeTab === '{{ $account->id }}' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100'"
                                    class="flex-1 py-2 px-4 rounded-md font-medium transition text-sm whitespace-nowrap">
                                    {{ $account->provider }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Tab Content -->
                        <div class="bg-white rounded-lg p-4 space-y-3">
                            @foreach($paymentAccounts as $account)
                                <div x-show="activeTab === '{{ $account->id }}'" class="space-y-2" x-cloak>
                                    @if($account->bank_name)
                                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Bank Name:</span>
                                            <span class="font-bold text-gray-900">{{ $account->bank_name }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600 text-sm">Account Title:</span>
                                        <span class="font-bold text-gray-900">{{ $account->account_title }}</span>
                                    </div>
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600 text-sm">Account Number:</span>
                                        <span class="font-mono font-bold text-indigo-600 text-lg">{{ $account->account_number }}</span>
                                    </div>
                                    @if($account->instructions)
                                        <div class="mt-3 pt-2 border-t border-gray-50">
                                            <p class="text-xs text-gray-500 italic">
                                                <i class="fa-solid fa-info-circle mr-1"></i>
                                                {{ $account->instructions }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-xs text-yellow-800">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                <strong>Important:</strong> Please transfer the exact amount and save your transaction
                                receipt/screenshot for verification.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg p-6 text-center border border-dashed border-gray-300">
                        <i class="fa-solid fa-face-sad-tear text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">No payment methods are currently available. Please contact support.</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Payment Proof Form -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Submit Payment Proof</h3>
            <form action="{{ route('shop.subscriptions.store', $plan) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="transaction_id" value="Transaction ID / Reference Number" />
                    <x-text-input id="transaction_id" name="transaction_id" class="block mt-1 w-full" required
                        placeholder="e.g. TXN123456789" />
                    @error('transaction_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="payment_proof" value="Upload Payment Screenshot" />
                    <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG (Max: 2MB)</p>
                    @error('payment_proof')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 px-6 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors shadow-lg flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Submit for Verification
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
