<!-- Create Partner Modal -->
<div x-show="showCreateModal" x-cloak @click.away="showCreateModal = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" style="display: none;">
    <div @click.stop class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100">

        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 rounded-t-2xl z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                        <i class="fa-solid fa-handshake text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Add New Referral Partner</h3>
                        <p class="text-xs text-gray-500">Create a new referral partner account</p>
                    </div>
                </div>
                <button @click="showCreateModal = false"
                    class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-all">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form method="POST" action="{{ route('admin.referrals.store') }}" class="p-6">
            @csrf

            <div class="space-y-4">
                <!-- Partner Information Section -->
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-user text-indigo-600 text-xs"></i>
                        Partner Information
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" required
                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required
                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="john@example.com">
                        </div>

                        <!-- Phone -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Phone Number
                            </label>
                            <input type="text" name="phone"
                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="+92 300 1234567">
                        </div>
                    </div>
                </div>

                <!-- Referral Code Section -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-code text-indigo-600 text-xs"></i>
                        Referral Code
                    </h4>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Custom Code (Optional)
                        </label>
                        <input type="text" name="code_suffix"
                            class="w-full px-3 py-2 bg-white border border-indigo-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            placeholder="PARTNER123">
                        <p class="text-[10px] text-gray-500 mt-1.5">
                            <i class="fa-solid fa-info-circle"></i>
                            Leave empty to auto-generate. Must be 3-10 alphanumeric characters.
                        </p>
                    </div>
                </div>

                <!-- Commission Settings Section -->
                <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-money-bill-wave text-emerald-600 text-xs"></i>
                        Commission Settings
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Commission Type -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Commission Type <span class="text-red-500">*</span>
                            </label>
                            <select name="commission_type" required
                                class="w-full px-3 py-2 bg-white border border-emerald-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (Rs.)</option>
                            </select>
                        </div>

                        <!-- Commission Value -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Commission Value <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="commission_value" required min="0" step="0.01"
                                class="w-full px-3 py-2 bg-white border border-emerald-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                                placeholder="10">
                        </div>

                        <!-- Duration Type -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Commission Duration <span class="text-red-500">*</span>
                            </label>
                            <select name="duration_type" required
                                class="w-full px-3 py-2 bg-white border border-emerald-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                                x-model="durationType">
                                <option value="forever">Forever</option>
                                <option value="one_time">One Time Only</option>
                                <option value="limited">Limited Months</option>
                            </select>
                        </div>

                        <!-- Duration Limit (shown only for limited) -->
                        <div x-data="{ durationType: 'forever' }">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Duration Limit (Months)
                            </label>
                            <input type="number" name="duration_limit" min="1"
                                class="w-full px-3 py-2 bg-white border border-emerald-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                                placeholder="12">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" @click="showCreateModal = false"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-all">
                    <i class="fa-solid fa-xmark mr-1.5"></i>
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                    <i class="fa-solid fa-check mr-1.5"></i>
                    Create Partner
                </button>
            </div>
        </form>
    </div>
</div>
