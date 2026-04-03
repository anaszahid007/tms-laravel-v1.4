@extends('layouts.shop')

@section('header', 'Add New Customer')

@section('content')
    <div class="max-w-3xl mx-auto">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('customers.index') }}"
                class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-indigo-500"></i> Customer Details
                </h3>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="name" :value="__('Full Name')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-gray-400"></i>
                                </div>
                                <x-text-input id="name" class="block w-full pl-10" type="text" name="name"
                                    :value="old('name')" required autofocus placeholder="e.g. Ali Khan" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Father Name -->
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="father_name" :value="__('Father Name')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-gray-400"></i>
                                </div>
                                <x-text-input id="father_name" class="block w-full pl-10" type="text" name="father_name"
                                    :value="old('father_name')" required autofocus placeholder="e.g. Haji Barkatullah" />
                            </div>
                            <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-phone text-gray-400"></i>
                                </div>
                                <x-text-input id="phone" class="block w-full pl-10" type="text" name="phone"
                                    :value="old('phone')" required placeholder="0300-1234567" />
                            </div>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Gender -->
                        <div>
                            <x-input-label for="gender" :value="__('Gender')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-venus-mars text-gray-400"></i>
                                </div>
                                <select id="gender" name="gender"
                                    class="block w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="address" :value="__('Address (Optional)')" />
                            <div class="relative mt-1">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                                </div>
                                <textarea id="address" name="address" rows="3"
                                    class="block w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Measurement Toggle -->
                    <div
                        class="mt-8 p-4 bg-indigo-50 rounded-lg border border-indigo-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-indigo-600 shadow-sm">
                                <i class="fa-solid fa-ruler-combined"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 leading-tight">Record Measurements</p>
                                <p class="text-xs text-gray-500">Redirect to measurement page after saving</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="add_measurements" value="1" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100">
                        <button type="button" onclick="history.back()"
                            class="mr-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                        <x-primary-button class="gap-2">
                            <i class="fa-solid fa-check"></i> {{ __('Create Customer') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
