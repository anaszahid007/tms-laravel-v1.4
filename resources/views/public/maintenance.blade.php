@extends('layouts.public')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-indigo-100 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-indigo-100 mb-6">
                <i class="fa-solid fa-screwdriver-wrench text-4xl text-indigo-600 animate-bounce"></i>
            </div>

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Under Maintenance
                </h2>
                <p class="mt-4 text-gray-500">
                    We are currently performing some scheduled maintenance. We will be back online shortly. Thank you for
                    your patience!
                </p>
            </div>

            <div class="bg-indigo-50 p-4 rounded-2xl border border-indigo-200">
                <p class="text-sm text-indigo-700">
                    Site Name: {{ \App\Models\Setting::get('site_name', 'TailorOnDesk') }}
                </p>
            </div>

            <div class="pt-6">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'TailorOnDesk') }} &bull; All Rights
                    Reserved
                </p>
            </div>
        </div>
    </div>
@endsection
