<!-- Edit Partner Modal -->
<div x-show="showEditModal" x-cloak @click.away="showEditModal = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" style="display: none;">
    <div @click.stop class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100">

        <template x-if="editPartner">
            <div>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 rounded-t-2xl z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Edit Referral Partner</h3>
                                <p class="text-xs text-gray-500">Update partner information</p>
                            </div>
                        </div>
                        <button @click="showEditModal = false"
                            class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-all">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form method="POST" :action="`{{ route('admin.referrals.index') }}/${editPartner.id}`" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Partner Information Section -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user text-blue-600 text-xs"></i>
                                Partner Information
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" required :value="editPartner?.name"
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                </div>

                                <!-- Email (Read-only) -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Email Address
                                    </label>
                                    <input type="email" :value="editPartner?.email" disabled
                                        class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm text-gray-500">
                                    <p class="text-[10px] text-gray-500 mt-1">
                                        <i class="fa-solid fa-lock text-[8px]"></i> Email cannot be changed
                                    </p>
                                </div>

                                <!-- Phone -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Phone Number
                                    </label>
                                    <input type="text" name="phone" :value="editPartner?.phone"
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-toggle-on text-blue-600 text-xs"></i>
                                Status
                            </h4>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Partner Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required
                                    class="w-full px-3 py-2 bg-white border border-blue-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                    <option value="active" :selected="editPartner?.status === 'active'">Active
                                    </option>
                                    <option value="suspended" :selected="editPartner?.status === 'suspended'">Suspended
                                    </option>
                                </select>
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
                                        <option value="percentage"
                                            :selected="editPartner?.commission_type === 'percentage'">Percentage (%)
                                        </option>
                                        <option value="fixed" :selected="editPartner?.commission_type === 'fixed'">
                                            Fixed
                                            Amount (Rs.)</option>
                                    </select>
                                </div>

                                <!-- Commission Value -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Commission Value <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="commission_value" required min="0" step="0.01"
                                        :value="editPartner?.commission_value"
                                        class="w-full px-3 py-2 bg-white border border-emerald-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Referral Code Display (Read-only) -->
                        <div
                            class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-code text-purple-600 text-xs"></i>
                                Referral Code
                            </h4>

                            <div class="flex items-center gap-3">
                                <code
                                    class="flex-1 px-4 py-3 bg-white border border-purple-200 rounded-lg text-base font-mono font-bold text-gray-800"
                                    x-text="editPartner?.referral_code"></code>
                                <button type="button" @click="copyReferralLink(editPartner?.referral_code)"
                                    class="px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-lg transition-all">
                                    <i class="fa-solid fa-copy mr-1.5"></i>
                                    Copy Link
                                </button>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-2">
                                <i class="fa-solid fa-lock text-[8px]"></i> Referral code cannot be changed
                            </p>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-all">
                            <i class="fa-solid fa-xmark mr-1.5"></i>
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                            <i class="fa-solid fa-check mr-1.5"></i>
                            Update Partner
                        </button>
                    </div>
                </form>
            </div>
        </template>
    </div>
</div>
