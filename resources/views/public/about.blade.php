@extends('layouts.public')

@section('content')
    <!-- Full Width Header -->
    <div class="w-full bg-white py-20 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                {{ __('About') }} <span class="text-indigo-600">TailorOnDesk</span>
            </h1>
            <p class="mt-4 text-xl text-gray-500 max-w-3xl mx-auto">
                Empowering tailoring businesses with modern digital solutions
            </p>
        </div>
    </div>

    <!-- The Problem Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold mb-4">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        The Problem
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">
                        Lost in Piles of Paper?
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        Traditional tailoring businesses face significant challenges with paper-based record keeping.
                        Sound familiar?
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-search text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Difficult to Find Old Records</h3>
                                <p class="text-gray-600">Need measurements from a year ago? Good luck searching through
                                    stacks of notebooks and receipts!</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-file-circle-xmark text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Risk of Lost Data</h3>
                                <p class="text-gray-600">One spilled cup of tea or misplaced notebook can mean losing
                                    years of valuable customer data.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-clock text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Time Wasted</h3>
                                <p class="text-gray-600">Hours spent manually writing measurements, searching for old
                                    orders, and managing paperwork instead of focusing on your craft.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-user-slash text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Poor Customer Experience</h3>
                                <p class="text-gray-600">Customers have to wait while you hunt for their measurements or
                                    try to remember their preferences.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white p-8 rounded-2xl shadow-xl border-4 border-red-100">
                        <div class="text-center mb-6">
                            <i class="fa-solid fa-book text-6xl text-red-300"></i>
                        </div>
                        <div class="space-y-4 opacity-60">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600">Customer: Ahmed...</span>
                                <span class="text-xs text-gray-400">???</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600 line-through">Last order: 2023...</span>
                                <span class="text-xs text-red-500">Lost</span>
                            </div>
                            <div class="p-4 border-2 border-dashed border-red-200 rounded-lg text-center">
                                <i class="fa-solid fa-question text-2xl text-red-300"></i>
                                <p class="text-xs text-gray-500 mt-2">Where is the notebook?</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-red-200 rounded-full opacity-20 animate-pulse">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Solution Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-2xl shadow-xl border-4 border-indigo-200">
                        <div class="text-center mb-6">
                            <i class="fa-solid fa-laptop text-6xl text-indigo-600 animate-pulse"></i>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-white rounded-lg shadow-sm">
                                <span class="text-sm font-medium text-gray-900">Ahmed Khan</span>
                                <span class="text-xs text-emerald-600 font-bold">Found!</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white rounded-lg shadow-sm">
                                <span class="text-sm text-gray-600">Last order: Jan 2025</span>
                                <i class="fa-solid fa-check-circle text-emerald-500"></i>
                            </div>
                            <div class="p-4 bg-white rounded-lg shadow-sm">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fa-solid fa-ruler text-indigo-600"></i>
                                    <span class="text-xs font-bold text-gray-700">Measurements</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 text-xs text-gray-600">
                                    <div>Chest: 38"</div>
                                    <div>Length: 42"</div>
                                    <div>Sleeve: 24"</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-indigo-200 rounded-full opacity-20 animate-pulse"
                        style="animation-delay: 0.5s;"></div>
                </div>

                <div class="order-1 lg:order-2">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold mb-4">
                        <i class="fa-solid fa-lightbulb mr-2"></i>
                        The Solution
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">
                        Your Digital Tailoring Assistant
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        TailorOnDesk transforms your business by replacing messy paperwork with a clean, organized
                        digital system accessible from anywhere.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-bolt text-emerald-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Instant Access to Records</h3>
                                <p class="text-gray-600">Find any customer's measurements or order history in seconds,
                                    not hours. Just type and search!</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Never Lose Data Again</h3>
                                <p class="text-gray-600">Your data is securely stored in the cloud and backed up
                                    automatically. Accessible 24/7 from any device.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-rocket text-emerald-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Save Time, Grow Revenue</h3>
                                <p class="text-gray-600">Spend less time on paperwork and more time serving customers.
                                    Better service = more happy customers = more business!</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-star text-emerald-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-900">Professional Image</h3>
                                <p class="text-gray-600">Impress customers with quick, professional service. They'll
                                    appreciate that you remember their preferences!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why TailorOnDesk?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    We understand tailoring businesses because we built this solution specifically for you
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-hand-holding-dollar text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Affordable Pricing</h3>
                    <p class="text-gray-600">Starting at just Rs. 999/month - less than the cost of losing one
                        customer!</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-language text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Local Support</h3>
                    <p class="text-gray-600">Built for local markets with support in your language. We understand your
                        needs!</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-gift text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('Free Trial') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Try it risk-free for 7 days. No credit card required. See the difference yourself!') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-600 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Ready to Transform Your Tailoring Business?
            </h2>
            <p class="text-xl text-indigo-100 mb-8">
                Join hundreds of tailors who have already made the switch to digital
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-indigo-600 bg-white hover:bg-gray-50 shadow-xl hover:shadow-2xl transition">
                    Start Free Trial <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
                <a href="{{ route('contact-us') }}"
                    class="inline-flex items-center px-8 py-4 border-2 border-white text-lg font-medium rounded-lg text-white hover:bg-indigo-700 transition">
                    {{ __('Contact Us') }}
                </a>
            </div>
        </div>
    @endsection
