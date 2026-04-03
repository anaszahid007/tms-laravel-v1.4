@extends('layouts.public')

@section('content')
    <div class="flex flex-col items-center justify-center py-12">
        <div
            class="sm:max-w-md w-full px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border-t-4 border-indigo-600">
            <h2 class="text-center text-2xl font-bold text-gray-900 mb-8">{{ __('Welcome Back') }}</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400"></i>
                        </div>
                        <x-text-input id="email" class="block w-full pl-10" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" placeholder="enter your email" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4" x-data="{ showPassword: false }">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <x-text-input id="password" class="block w-full pl-10 pr-10" 
                            x-bind:type="showPassword ? 'text' : 'password'" 
                            name="password" required
                            autocomplete="current-password" placeholder="••••••••" />
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                            class="text-indigo-600 hover:underline">Register</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection
