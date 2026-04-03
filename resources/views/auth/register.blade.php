@extends('layouts.public')

@section('content')
    <div class="flex flex-col items-center justify-center py-12">
        <div
            class="sm:max-w-md w-full px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border-t-4 border-indigo-600">
            <h2 class="text-center text-2xl font-bold text-gray-900 mb-8">{{ __('Create Account') }}</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400"></i>
                        </div>
                        <x-text-input id="name" class="block w-full pl-10" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your Name" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400"></i>
                        </div>
                        <x-text-input id="phone" class="block w-full pl-10" type="text" name="phone"
                            :value="old('phone')" required autofocus autocomplete="phone" placeholder="03312345678" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400"></i>
                        </div>
                        <x-text-input id="email" class="block w-full pl-10" type="email" name="email"
                            :value="old('email')" required autocomplete="username" placeholder="Enter your Email" />
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
                            autocomplete="new-password" placeholder="••••••••" />
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4" x-data="{ showConfirmPassword: false }">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <x-text-input id="password_confirmation" class="block w-full pl-10 pr-10" 
                            x-bind:type="showConfirmPassword ? 'text' : 'password'"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        <button type="button" 
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fa-solid" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4 gap-2">
                        <i class="fa-solid fa-users"></i> {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
