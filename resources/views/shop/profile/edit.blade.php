@extends('layouts.shop')

@section('header', 'Profile Management')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        <!-- Enhanced Profile Header -->
        <div class="bg-indigo-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center gap-6">
                <div
                    class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-4xl font-bold border-4 border-white/30">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ auth()->user()->name }}</h1>
                    <p class="text-white/90 text-lg mb-3">{{ auth()->user()->email }}</p>
                    @if (auth()->user()->shop)
                        <div class="flex items-center gap-2 text-white/80">
                            <i class="fa-solid fa-store text-white/70"></i>
                            <span class="font-medium">{{ auth()->user()->shop->name }}</span>
                            <span class="px-2 py-1 bg-white/20 rounded-full text-xs font-medium">
                                {{ ucfirst(auth()->user()->role) }} Account
                            </span>
                        </div>
                    @endif
                </div>
                <div class="text-right">
                    <div class="text-sm text-white/70 mb-1">Member since</div>
                    <div class="font-semibold">{{ auth()->user()->created_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ activeTab: '{{ session('active_tab', 'personal') }}' }">
            <div class="border-b border-gray-100">
                <nav class="flex space-x-8 px-6">
                    <button @click="activeTab = 'personal'"
                        :class="activeTab === 'personal' ? 'border-indigo-500 text-indigo-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <i class="fa-solid fa-user mr-2"></i>Personal Information
                    </button>
                    <button @click="activeTab = 'shop'"
                        :class="activeTab === 'shop' ? 'border-indigo-500 text-indigo-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <i class="fa-solid fa-store mr-2"></i>Shop Details
                    </button>
                    <button @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'border-indigo-500 text-indigo-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <i class="fa-solid fa-shield-halved mr-2"></i>Security
                    </button>
                    {{-- <button @click="activeTab = 'danger'"
                        :class="activeTab === 'danger' ? 'border-red-500 text-red-600' :
                            'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>Danger Zone
                    </button> --}}
                </nav>
            </div>

            <div class="p-6">
                <!-- Personal Information Tab -->
                <div x-show="activeTab === 'personal'" class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-user-edit text-indigo-600"></i>
                            Update Personal Information
                        </h3>
                        <p class="text-gray-600 mb-6">Keep your personal details up to date for better account management.
                        </p>

                        <form method="post" action="{{ route('shop.profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fa-solid fa-user text-gray-400 mr-1"></i> Full Name
                                    </label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        required autofocus autocomplete="name">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fa-solid fa-envelope text-gray-400 mr-1"></i> Email Address
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        required autocomplete="email">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-yellow-600">
                                                <i class="fa-solid fa-exclamation-triangle mr-1"></i>
                                                Your email address is unverified.
                                                <button form="send-verification" class="underline hover:text-yellow-700">
                                                    Click here to re-send verification email.
                                                </button>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow-md">
                                    <i class="fa-solid fa-save mr-2"></i>Update Profile
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <div class="flex items-center text-green-600 text-sm font-medium">
                                        <i class="fa-solid fa-check-circle mr-2"></i>
                                        Profile updated successfully!
                                    </div>
                                @endif
                            </div>
                        </form>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>
                    </div>
                </div>

                <!-- Shop Details Tab -->
                <div x-show="activeTab === 'shop'" class="space-y-6">
                    @if (auth()->user()->shop)
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-store text-indigo-600"></i>
                                Shop Information
                            </h3>
                            <p class="text-gray-600 mb-6">Manage your shop details and business information.</p>

                            <form method="post" action="{{ route('shop.profile.shop.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fa-solid fa-store text-gray-400 mr-1"></i> Shop Name
                                        </label>
                                        <input type="text" id="shop_name" name="shop_name"
                                            value="{{ old('shop_name', $user->shop->name) }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                            required>
                                    </div>

                                    <div>
                                        <label for="shop_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fa-solid fa-phone text-gray-400 mr-1"></i> Shop Phone
                                        </label>
                                        <input type="tel" id="shop_phone" name="shop_phone"
                                            value="{{ old('shop_phone', $user->shop->phone ?? '') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="shop_address" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> Shop Address
                                        </label>
                                        <textarea id="shop_address" name="shop_address" rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                            placeholder="Enter your shop address">{{ old('shop_address', $user->shop->address ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 pt-4">
                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow-md">
                                        <i class="fa-solid fa-save mr-2"></i>Update Shop Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-triangle-exclamation text-yellow-600 text-xl"></i>
                                <h3 class="text-lg font-bold text-yellow-800">Shop Not Found</h3>
                            </div>
                            <p class="text-yellow-700 mt-2">You don't have a shop associated with your account. Please
                                contact support for assistance.</p>
                        </div>
                    @endif
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-key text-indigo-600"></i>
                            Change Password
                        </h3>
                        <p class="text-gray-600 mb-6">Ensure your account is using a long, random password to stay secure.
                        </p>

                        <form method="post" action="{{ route('shop.password.update') }}" class="space-y-6">
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
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-2">
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
                    </div>
                </div>

                <!-- Danger Zone Tab -->
                {{-- <div x-show="activeTab === 'danger'" class="space-y-6">
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-red-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                            Delete Account
                        </h3>
                        <p class="text-red-700 mb-6">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            This action cannot be undone.
                        </p>

                        @include('shop.profile.partials.delete-user-form')
                    </div>
                </div> --}}
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        // Add Alpine.js if not already loaded
        if (typeof Alpine === 'undefined') {
            document.write('<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer><\/script>');
        }
    </script>
@endpush
