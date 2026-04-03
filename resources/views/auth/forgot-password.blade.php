@extends('layouts.public')

@section('content')
    <div
        class="sm:max-w-md w-full mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border-t-4 border-indigo-600">
        <h2 class="text-center text-2xl font-bold text-gray-900 mb-4">{{ __('Forgot Password') }}</h2>

        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10" type="email" name="email" :value="old('email')"
                        required autofocus placeholder="enter your email" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
