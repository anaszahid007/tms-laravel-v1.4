@extends('layouts.admin')

@section('header', 'Edit Payment Account')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.payment-accounts.index') }}"
                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Edit Account</h2>
                        <p class="text-sm text-gray-500">Update details for {{ $paymentAccount->provider }}.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.payment-accounts.update', $paymentAccount->id) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Provider -->
                        <div>
                            <label for="provider" class="block text-sm font-semibold text-gray-700 mb-2">
                                Provider <span class="text-red-500">*</span>
                            </label>
                            <select name="provider" id="provider" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                <option value="JazzCash" {{ old('provider', $paymentAccount->provider) == 'JazzCash' ? 'selected' : '' }}>JazzCash</option>
                                <option value="EasyPaisa" {{ old('provider', $paymentAccount->provider) == 'EasyPaisa' ? 'selected' : '' }}>EasyPaisa</option>
                                <option value="Bank Transfer" {{ old('provider', $paymentAccount->provider) == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="Other" {{ old('provider', $paymentAccount->provider) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('provider')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bank Name -->
                        <div>
                            <label for="bank_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Bank Name (Optional)
                            </label>
                            <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $paymentAccount->bank_name) }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="e.g., Meezan Bank">
                            @error('bank_name')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Account Title -->
                        <div>
                            <label for="account_title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Account Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="account_title" id="account_title" value="{{ old('account_title', $paymentAccount->account_title) }}" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="e.g., Tailor On Desk">
                            @error('account_title')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Account Number -->
                        <div>
                            <label for="account_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                Account Number / Phone <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $paymentAccount->account_number) }}" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="e.g., 03001234567">
                            @error('account_number')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Priority & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">
                                Priority (Lower shows first)
                            </label>
                            <input type="number" name="priority" id="priority" value="{{ old('priority', $paymentAccount->priority) }}" required min="0"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('priority')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-end">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100 w-full">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $paymentAccount->is_active) ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="is_active" class="text-sm font-medium text-gray-700">
                                    Account is Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label for="instructions" class="block text-sm font-semibold text-gray-700 mb-2">
                            Additional Instructions (Optional)
                        </label>
                        <textarea name="instructions" id="instructions" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            placeholder="e.g., Please mention your shop name in the transfer notes.">{{ old('instructions', $paymentAccount->instructions) }}</textarea>
                        @error('instructions')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.payment-accounts.index') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white border border-gray-200 hover:border-gray-300 rounded-lg transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-check"></i>
                        Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
