@extends('layouts.public')

@section('content')
    <!-- Full Width Header with Gray Background -->
    <div class="w-full bg-white py-16 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Privacy Policy
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Your privacy and trust matter to us
            </p>
            <p class="mt-2 text-sm text-gray-500">Last updated: January 13, 2026</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Trust Statement -->
            <div
                class="bg-gradient-to-r from-indigo-50 to-purple-50 border-l-4 border-indigo-600 p-6 mb-12 rounded-r-xl shadow-sm">
                <div class="flex items-start">
                    <i class="fa-solid fa-shield-halved text-indigo-600 text-4xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">We Protect Your Privacy</h3>
                        <p class="text-gray-700 leading-relaxed">
                            At TailorOnDesk, safeguarding your data is our top priority. We are committed to transparency
                            and earning your trust through responsible data practices.
                        </p>
                    </div>
                </div>
            </div>

            <!-- What We Collect -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-clipboard-list text-indigo-600 mr-3"></i>
                    What Information We Collect
                </h2>
                <p class="text-gray-700 mb-6 text-lg">
                    We only collect information necessary to provide you with the best service:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200 shadow-sm hover:shadow-md transition">
                        <i class="fa-solid fa-user-circle text-indigo-600 text-3xl mb-3"></i>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Account Information</h3>
                        <p class="text-gray-700">Your name, email, phone number, and shop details when you create an
                            account.</p>
                    </div>
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200 shadow-sm hover:shadow-md transition">
                        <i class="fa-solid fa-briefcase text-purple-600 text-3xl mb-3"></i>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Business Data</h3>
                        <p class="text-gray-700">Customer information, measurements, and orders that you choose to store in
                            our system.</p>
                    </div>
                </div>
            </section>

            <!-- How We Use It -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-bullseye text-indigo-600 mr-3"></i>
                    How We Use Your Information
                </h2>
                <p class="text-gray-700 mb-6 text-lg">
                    Your information is used solely to deliver and improve our service:
                </p>
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Provide you access to TailorOnDesk features</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Process your subscription payments securely</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Send you important updates about your account</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">Improve our service based on your feedback</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Data Security -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-lock text-indigo-600 mr-3"></i>
                    How We Keep Your Data Safe
                </h2>
                <p class="text-gray-700 mb-6 text-lg">
                    We implement industry-standard security measures to protect your information:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200 shadow-sm hover:shadow-md transition">
                        <i class="fa-solid fa-shield-alt text-indigo-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Encrypted Storage</h3>
                        <p class="text-gray-700">All your data is encrypted and stored securely</p>
                    </div>
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200 shadow-sm hover:shadow-md transition">
                        <i class="fa-solid fa-server text-purple-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Secure Servers</h3>
                        <p class="text-gray-700">Hosted on protected servers with 24/7 monitoring</p>
                    </div>
                    <div
                        class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 rounded-xl border border-emerald-200 shadow-sm hover:shadow-md transition">
                        <i class="fa-solid fa-cloud-arrow-up text-emerald-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Regular Backups</h3>
                        <p class="text-gray-700">Automatic backups ensure your data is never lost</p>
                    </div>
                    <div
                        class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-xl border border-amber-200 shadow-sm hover:shadow-md transition">
                        <i class="fa-solid fa-user-lock text-amber-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-900 mb-2">Access Control</h3>
                        <p class="text-gray-700">Strict access controls protect your privacy</p>
                    </div>
                </div>
            </section>

            <!-- Your Rights -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-hand-holding-heart text-indigo-600 mr-3"></i>
                    Your Rights and Control
                </h2>
                <p class="text-gray-700 mb-6 text-lg">
                    You have complete control over your data. You can:
                </p>
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-8 rounded-xl border border-gray-200">
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <div
                                class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fa-solid fa-eye text-indigo-600"></i>
                            </div>
                            <span class="text-gray-700 text-lg"><strong>View</strong> all your stored information
                                anytime</span>
                        </li>
                        <li class="flex items-center">
                            <div
                                class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fa-solid fa-pen text-indigo-600"></i>
                            </div>
                            <span class="text-gray-700 text-lg"><strong>Update</strong> or correct your information</span>
                        </li>
                        <li class="flex items-center">
                            <div
                                class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fa-solid fa-download text-indigo-600"></i>
                            </div>
                            <span class="text-gray-700 text-lg"><strong>Export</strong> your data in a portable
                                format</span>
                        </li>
                        <li class="flex items-center">
                            <div
                                class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fa-solid fa-trash text-indigo-600"></i>
                            </div>
                            <span class="text-gray-700 text-lg"><strong>Delete</strong> your account and data
                                permanently</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- What We DON'T Do -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-ban text-red-600 mr-3"></i>
                    What We DON'T Do
                </h2>
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 p-8 rounded-r-xl shadow-sm">
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fa-solid fa-times-circle text-red-600 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800 text-lg"><strong>We never sell your data</strong> to advertisers or
                                third parties</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-times-circle text-red-600 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800 text-lg"><strong>We don't share your information</strong> without
                                your permission</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fa-solid fa-times-circle text-red-600 text-xl mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-800 text-lg"><strong>We don't use your data</strong> for marketing
                                purposes</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Contact -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-comments text-indigo-600 mr-3"></i>
                    Questions or Concerns?
                </h2>
                <p class="text-gray-700 mb-6 text-lg">
                    We're here to help! If you have any questions about your privacy or how we handle your data, please
                    don't hesitate to reach out.
                </p>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-8 rounded-xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="text-center">
                            <i class="fa-solid fa-envelope text-4xl mb-3"></i>
                            <p class="text-sm mb-2 opacity-90">Email Us</p>
                            <a href="mailto:privacy@tailorondesk.com"
                                class="text-lg font-bold hover:underline block">privacy@tailorondesk.com</a>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-headset text-4xl mb-3"></i>
                            <p class="text-sm mb-2 opacity-90">Support</p>
                            <a href="mailto:support@tailorondesk.com"
                                class="text-lg font-bold hover:underline block">support@tailorondesk.com</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Commitment -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-10 rounded-2xl text-center shadow-xl">
                <i class="fa-solid fa-heart text-6xl mb-4 opacity-80 animate-pulse" style="animation-duration: 2s;"></i>
                <h3 class="text-3xl font-bold mb-4">Our Commitment to You</h3>
                <p class="text-xl opacity-90 max-w-2xl mx-auto">
                    Your trust is everything to us. We promise to always handle your data with care, respect, and the
                    highest security standards.
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
