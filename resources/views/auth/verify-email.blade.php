@extends('layouts.public')

@section('title', 'Email Verification Required')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-scissors text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-900">TailorOnDesk</span>
                </div>
            </div>

            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                <i class="fas fa-envelope text-2xl text-indigo-600"></i>
            </div>

            <!-- Title -->
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Verify Your Email
            </h2>

            <!-- Message -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            Before proceeding, please check your email for a verification link. 
                            If you didn't receive the email, click the button below to request another.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Email Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600 mb-2">Verification email sent to:</p>
                <p class="font-medium text-gray-900">{{ auth()->check() ? auth()->user()->email : session('registered_email') }}</p>
            </div>

            <!-- Resend Form -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">
                                A new verification link has been sent to your email address.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            @if(auth()->check())
                <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Resend Verification Email
                    </button>
                </form>

                <!-- Logout Option -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            @else
                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-indigo-600 rounded-lg shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Back to Login
                    </a>
                </div>
            @endif

            <!-- Help Text -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Having trouble? Check your spam folder or contact support.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection