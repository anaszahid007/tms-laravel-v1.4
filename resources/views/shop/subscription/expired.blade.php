@extends('layouts.shop')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-amber-100 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-amber-100 mb-6">
                <i class="fa-solid fa-clock-rotate-left text-4xl text-amber-600"></i>
            </div>

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Plan Expired
                </h2>
                <p class="mt-4 text-gray-500">
                    Your subscription plan for <span
                        class="font-semibold text-indigo-600">{{ auth()->user()->shop->name ?? 'your shop' }}</span> has
                    ended. Don't worry, your data is safe!
                </p>
            </div>

            <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-crown text-4xl text-indigo-600"></i>
                </div>
                <p class="text-sm text-indigo-800 font-medium">
                    Renew your subscription to continue managing your customers and orders seamlessly.
                </p>
            </div>

            <div class="flex flex-col space-y-3 pt-4">
                <a href="{{ route('shop.subscriptions.index') }}"
                    class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 transform hover:scale-[1.02]">
                    <i class="fa-solid fa-credit-card mr-2"></i>
                    Renew Subscription
                </a>

                <a href="{{ route('pricing') }}"
                    class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    View Pricing Plans
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150">
                        Logout and return home
                    </button>
                </form>
            </div>

            <div class="pt-6">
                <p class="text-xs text-gray-400">
                    Need more time? <a href="{{ route('contact-us') }}" class="text-indigo-600 hover:underline">Contact
                        Support</a>
                </p>
            </div>
        </div>
    </div>
@endsection
