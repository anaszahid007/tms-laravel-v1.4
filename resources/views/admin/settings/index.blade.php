@extends('layouts.admin')

@section('header', 'System Settings')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Application Settings</h2>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Site Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Site phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                    <input type="tel" name="contact_phone" value="{{ $settings['contact_phone'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Site Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Maintenance Mode -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Maintenance Mode</h3>
                        <p class="text-sm text-gray-500">Temporarily disable the application</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                            class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                        </div>
                    </label>
                </div>

                <!-- Registration -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Allow Registration</h3>
                        <p class="text-sm text-gray-500">Allow new users to register</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="allow_registration"
                            {{ $settings['allow_registration'] ? 'checked' : '' }} class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                        </div>
                    </label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6 mt-6">
            <h2 class="text-xl font-bold text-red-600 mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i> Danger Zone
            </h2>
            <p class="text-sm text-gray-600 mb-4">These actions are irreversible. Please be certain.</p>

            <div class="space-y-3">
                <button
                    class="w-full text-left px-4 py-3 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 transition flex items-center gap-3 border border-red-200">
                    <i class="fa-solid fa-database w-5 text-center"></i> Clear All Cache
                </button>
                <button
                    class="w-full text-left px-4 py-3 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 transition flex items-center gap-3 border border-red-200">
                    <i class="fa-solid fa-trash-alt w-5 text-center"></i> Reset Application
                </button>
            </div>
        </div>
    </div>
@endsection
