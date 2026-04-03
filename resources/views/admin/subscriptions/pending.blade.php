@extends('layouts.admin')

@section('header', 'Pending Payment Approvals')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Stats Card -->
        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6 rounded-lg shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium opacity-90">Pending Approvals</h3>
                    <p class="text-4xl font-extrabold mt-2">{{ $pendingCount }}</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shop
                                Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transaction</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proof
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pendingSubscriptions as $sub)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $sub->user->shop->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $sub->user->email }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $sub->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $sub->plan_name }}</div>
                                    <div class="text-sm text-green-600 font-bold">Rs.
                                        {{ number_format($sub->plan_price, 0) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 font-mono">
                                        {{ $sub->transaction_id }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($sub->payment_proof_path)
                                        <a href="{{ asset('storage/' . $sub->payment_proof_path) }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                                            <i class="fa-solid fa-image"></i> View Screenshot
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">No proof</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Approve -->
                                        <form action="{{ route('admin.subscriptions.approve', $sub) }}" method="POST"
                                            onsubmit="return confirm('Approve this subscription? This will activate the shop and trigger referral commissions.')">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition flex items-center gap-1">
                                                <i class="fa-solid fa-check"></i> Approve
                                            </button>
                                        </form>

                                        <!-- Reject -->
                                        <button
                                            onclick="openRejectModal({{ $sub->id }}, '{{ $sub->user->shop->name ?? 'Shop' }}')"
                                            class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition flex items-center gap-1">
                                            <i class="fa-solid fa-times"></i> Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fa-solid fa-check-circle text-4xl text-green-500 mb-2"></i>
                                    <p class="font-medium">All caught up! No pending approvals.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $pendingSubscriptions->links() }}
            </div>
        </div>

    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Reject Subscription</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                        <textarea name="admin_notes" rows="4" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                            placeholder="e.g. Payment amount mismatch, invalid screenshot..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                            Confirm Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(subscriptionId, shopName) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/subscriptions/${subscriptionId}/reject`;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endsection
