<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fa-solid fa-lock text-gray-400 mr-1"></i> Current Password
                </label>
                <input type="password" id="current_password" name="current_password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                       required autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div></div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fa-solid fa-key text-gray-400 mr-1"></i> New Password
                </label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                       required autocomplete="new-password">
                @error('password', 'updatePassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fa-solid fa-check-circle text-gray-400 mr-1"></i> Confirm New Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                       required autocomplete="new-password">
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow-md">
                <i class="fa-solid fa-save mr-2"></i>Update Password
            </button>

            @if (session('status') === 'password-updated')
                <div class="flex items-center text-green-600 text-sm font-medium">
                    <i class="fa-solid fa-check-circle mr-2"></i>
                    Password updated successfully!
                </div>
            @endif
        </div>
    </form>
</section>