@extends('layouts.public')

@section('content')
    <div
        class="sm:max-w-md w-full mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border-t-4 border-indigo-600">
        <h2 class="text-center text-2xl font-bold text-gray-900 mb-4">{{ __('Confirm Password') }}</h2>

        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button>
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
