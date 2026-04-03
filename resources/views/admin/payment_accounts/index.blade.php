@extends('layouts.admin')

@section('header', 'Payment Accounts')

@section('content')
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Payment Accounts</h2>
                    <p class="text-sm text-gray-500">Manage accounts where shops will transfer their subscription fees.</p>
                </div>
                <a href="{{ route('admin.payment-accounts.create') }}"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i>
                    Add Account
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="py-4 px-6">Provider</th>
                            <th class="py-4 px-4">Account Title</th>
                            <th class="py-4 px-4">Account Number</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-4 text-center">Priority</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($accounts as $account)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold shadow-sm">
                                            {{ substr($account->provider, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-gray-900">{{ $account->provider }}</p>
                                            @if($account->bank_name)
                                                <p class="text-[10px] text-gray-400 uppercase tracking-wide">{{ $account->bank_name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-sm text-gray-700">{{ $account->account_title }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-sm font-mono text-gray-700">{{ $account->account_number }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if ($account->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center text-sm text-gray-500">
                                    {{ $account->priority }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.payment-accounts.edit', $account->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="Edit Account">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.payment-accounts.destroy', $account->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this account?')"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Delete Account">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-credit-card text-xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold mb-1">No Accounts Found</h3>
                                        <p class="text-gray-500 text-sm mb-6">Create your first payment account to start accepting subscription payments.</p>
                                        <a href="{{ route('admin.payment-accounts.create') }}"
                                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">
                                            <i class="fa-solid fa-plus mr-2"></i>Add First Account
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
