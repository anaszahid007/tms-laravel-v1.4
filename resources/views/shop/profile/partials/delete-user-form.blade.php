<section>
    <div class="space-y-6">
        <div class="bg-red-100 border border-red-300 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-exclamation-triangle text-red-600 mt-1"></i>
                <div>
                    <h4 class="font-bold text-red-800 mb-2">Warning: Account Deletion</h4>
                    <ul class="text-red-700 text-sm space-y-1">
                        <li><i class="fa-solid fa-dot-circle mr-2 text-xs"></i>All your personal data will be permanently deleted</li>
                        <li><i class="fa-solid fa-dot-circle mr-2 text-xs"></i>Your shop information and customer data will be removed</li>
                        <li><i class="fa-solid fa-dot-circle mr-2 text-xs"></i>Orders, measurements, and all related records will be lost</li>
                        <li><i class="fa-solid fa-dot-circle mr-2 text-xs"></i>This action cannot be undone or reversed</li>
                    </ul>
                </div>
            </div>
        </div>

        <button type="button" 
                onclick="confirmDeletion()"
                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium shadow-md flex items-center gap-2">
            <i class="fa-solid fa-trash"></i>
            Delete My Account
        </button>
    </div>

    <!-- Deletion Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Confirm Account Deletion</h3>
                        <p class="text-sm text-gray-600">This action is permanent and cannot be undone.</p>
                    </div>
                </div>

                <form method="post" action="{{ route('shop.profile.destroy') }}" id="deleteForm" class="space-y-4">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-lock text-gray-400 mr-1"></i> Confirm your password
                        </label>
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               required autocomplete="current-password">
                        @error('password', 'userDeletion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <label class="flex items-start gap-3">
                            <input type="checkbox" id="confirmDelete" name="confirmDelete" 
                                   class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <span class="text-sm text-red-700">
                                I understand that this will permanently delete my account and all associated data
                            </span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" 
                                onclick="closeDeleteModal()"
                                class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                id="confirmDeleteBtn"
                                disabled
                                class="flex-1 bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function confirmDeletion() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
    document.getElementById('deleteForm').reset();
}

// Enable delete button only when checkbox is checked
document.getElementById('confirmDelete').addEventListener('change', function() {
    document.getElementById('confirmDeleteBtn').disabled = !this.checked;
});

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>