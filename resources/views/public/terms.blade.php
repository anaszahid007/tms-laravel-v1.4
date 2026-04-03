@extends('layouts.public')

@section('content')
    <!-- Full Width Header -->
    <div class="w-full bg-white py-16 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Terms of Service
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Simple, fair terms for using TailorOnDesk
            </p>
            <p class="mt-2 text-sm text-gray-500">Last updated: January 13, 2026</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Statement -->
            <div
                class="bg-gradient-to-r from-indigo-50 to-purple-50 border-l-4 border-indigo-600 p-6 mb-12 rounded-r-xl shadow-sm">
                <div class="flex items-start">
                    <i class="fa-solid fa-handshake text-indigo-600 text-4xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Welcome to TailorOnDesk</h3>
                        <p class="text-gray-700 leading-relaxed">
                            By using our service, you agree to these terms. We've written them in plain language to make
                            them easy to understand. If you have questions, we're here to help!
                        </p>
                    </div>
                </div>
            </div>

            <!-- 1. Service Overview -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-circle-check text-indigo-600 mr-3"></i>
                    What We Provide
                </h2>
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <p class="text-gray-700 text-lg mb-4">
                        TailorOnDesk is a cloud-based software service designed to help tailoring businesses manage:
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fa-solid fa-check text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Customer information and measurements</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Order tracking and management</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Business records and reports</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- 2. Your Account -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-user-tie text-indigo-600 mr-3"></i>
                    Your Account Responsibilities
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200">
                        <i class="fa-solid fa-shield-halved text-indigo-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Keep It Secure</h3>
                        <p class="text-gray-700">Protect your password and don't share your account with others.</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                        <i class="fa-solid fa-file-contract text-purple-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Accurate Information</h3>
                        <p class="text-gray-700">Provide truthful information when registering and keep it updated.</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 rounded-xl border border-emerald-200">
                        <i class="fa-solid fa-user-check text-emerald-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">You're Responsible</h3>
                        <p class="text-gray-700">You're accountable for all activities under your account.</p>
                    </div>
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-xl border border-amber-200">
                        <i class="fa-solid fa-18 text-amber-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Age Requirement</h3>
                        <p class="text-gray-700">You must be 18 or older to use TailorOnDesk.</p>
                    </div>
                </div>
            </section>

            <!-- 3. Subscription & Payment -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-credit-card text-indigo-600 mr-3"></i>
                    Subscription & Payment
                </h2>
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fa-solid fa-gift text-green-600 mr-2"></i>
                            Free Trial
                        </h3>
                        <p class="text-gray-700">
                            New users get a <strong>7-day free trial</strong>. No credit card required. You can cancel
                            anytime during the trial with no charges.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fa-solid fa-calendar-days text-indigo-600 mr-2"></i>
                            Paid Subscriptions
                        </h3>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Subscriptions are billed monthly in advance</li>
                            <li>• Prices are shown in Pakistani Rupees (PKR)</li>
                            <li>• Payment is due on the same day each month</li>
                            <li>• We'll notify you before charging your card</li>
                        </ul>
                    </div>

                    <div class="bg-red-50 p-6 rounded-xl border-l-4 border-red-600">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fa-solid fa-ban text-red-600 mr-2"></i>
                            No Refunds Policy
                        </h3>
                        <p class="text-gray-700 mb-3">
                            <strong>All subscription payments are non-refundable.</strong> Once you purchase a subscription
                            plan, no refunds will be provided for any remaining time on your subscription.
                        </p>
                        <p class="text-gray-700 text-sm">
                            We encourage you to use our <strong>7-day free trial</strong> to test the service before
                            committing to a paid subscription.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 4. Acceptable Use -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-scale-balanced text-indigo-600 mr-3"></i>
                    Fair Use Policy
                </h2>
                <p class="text-gray-700 mb-6 text-lg">You agree to use TailorOnDesk responsibly. Please don't:</p>
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 p-6 rounded-r-xl">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fa-solid fa-ban text-red-600 text-lg mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800">Use the service for illegal activities</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-ban text-red-600 text-lg mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800">Share your account credentials with others</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-ban text-red-600 text-lg mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800">Attempt to hack or disrupt our service</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-ban text-red-600 text-lg mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800">Copy or resell our software</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- 5. Data & Privacy -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-database text-indigo-600 mr-3"></i>
                    Your Data
                </h2>
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-indigo-600 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg"><strong>You own your data.</strong> All customer information
                                and business data you enter belongs to you.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-indigo-600 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg"><strong>We keep it safe.</strong> We backup your data
                                regularly and protect it with encryption.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-indigo-600 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg"><strong>Export anytime.</strong> You can download your data
                                in a portable format whenever you want.</span>
                        </li>
                    </ul>
                    <div class="mt-4 pt-4 border-t border-indigo-200">
                        <p class="text-gray-700">
                            For more details, see our <a href="{{ route('privacy') }}"
                                class="text-indigo-600 font-semibold hover:underline">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 6. Service Availability -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-clock text-indigo-600 mr-3"></i>
                    Service Availability
                </h2>
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <p class="text-gray-700 text-lg mb-4">
                        We work hard to keep TailorOnDesk running smoothly 24/7. However:
                    </p>
                    <ul class="space-y-3 text-gray-700">
                        <li>• Occasional maintenance or updates may cause brief downtime</li>
                        <li>• We'll notify you in advance of planned maintenance</li>
                        <li>• We can't guarantee 100% uptime due to factors outside our control</li>
                        <li>• We'll do our best to minimize any disruptions</li>
                    </ul>
                </div>
            </section>

            <!-- 7. Cancellation -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-door-open text-indigo-600 mr-3"></i>
                    Cancellation Policy
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                        <h3 class="font-bold text-gray-900 mb-3">You Can Cancel Anytime</h3>
                        <p class="text-gray-700">
                            Cancel your subscription from your account settings. You'll have access until the end of your
                            billing period.
                        </p>
                    </div>
                    <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                        <h3 class="font-bold text-gray-900 mb-3">We May Suspend Access</h3>
                        <p class="text-gray-700">
                            If payment fails or terms are violated, we may suspend your account after notification.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 8. Limitation of Liability -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-gavel text-indigo-600 mr-3"></i>
                    Limitations
                </h2>
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200">
                    <p class="text-gray-700 text-lg">
                        TailorOnDesk is provided "as is." While we strive for excellence, we cannot guarantee the service
                        will always be error-free or uninterrupted. We're not liable for any business losses that may occur
                        from using our service.
                    </p>
                </div>
            </section>

            <!-- 9. Changes to Terms -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-pen-to-square text-indigo-600 mr-3"></i>
                    Updates to These Terms
                </h2>
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <p class="text-gray-700 text-lg">
                        We may update these terms occasionally. We'll notify you by email of any significant changes.
                        Continued use of the service after changes means you accept the new terms.
                    </p>
                </div>
            </section>

            <!-- Contact -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-headset text-indigo-600 mr-3"></i>
                    Questions?
                </h2>
                <p class="text-gray-700 mb-6 text-lg">
                    If you have any questions about these terms, we're happy to help clarify.
                </p>
                <div
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-8 rounded-xl shadow-lg text-center">
                    <i class="fa-solid fa-envelope text-4xl mb-3"></i>
                    <p class="text-sm mb-2 opacity-90">Contact Us</p>
                    <a href="mailto:support@tailorondesk.com"
                        class="text-xl font-bold hover:underline block">support@tailorondesk.com</a>
                </div>
            </section>

            <!-- Thank You -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-10 rounded-2xl text-center shadow-xl">
                <i class="fa-solid fa-thumbs-up text-6xl mb-4 opacity-80"></i>
                <h3 class="text-3xl font-bold mb-4">Thank You!</h3>
                <p class="text-xl opacity-90 max-w-2xl mx-auto">
                    Thank you for choosing TailorOnDesk. We're committed to providing you with the best service possible and
                    helping your business grow.
                </p>
            </div>

            <!-- Back Button -->
            <div class="mt-12 text-center">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium text-lg transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
@endsection
