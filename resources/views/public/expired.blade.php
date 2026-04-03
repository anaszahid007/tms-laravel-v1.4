@extends('layouts.public')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-orange-100 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-orange-100 mb-6">
                <i class="fa-solid fa-clock-rotate-left text-4xl text-orange-600 animate-pulse"></i>
            </div>

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Subscription Expired
                </h2>
                <p class="mt-4 text-gray-500">
                    Your shop's subscription has expired. Please renew your plan to continue managing your tailoring
                    business seamlessly.
                </p>
            </div>

            <div class="bg-orange-50 p-4 rounded-2xl border border-orange-200">
                <p class="text-sm text-orange-700">
                    All your data is safe. You just need to reactivate your account to access it.
                </p>
            </div>

            <div class="flex flex-col space-y-3 pt-4">
                <a href="{{ route('shop.subscriptions.index') }}"
                    class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                    <i class="fa-solid fa-credit-card mr-2"></i>
                    Renew Subscription
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>

            <div class="pt-6">
                <p class="text-xs text-gray-400">
                    Tailor On Desk &bull; Digital Tailoring Management
                </p>
            </div>
        </div>
    </div>
@endsection
