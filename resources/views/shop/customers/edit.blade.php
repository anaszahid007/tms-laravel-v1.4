@extends('layouts.shop')

@section('header', 'Edit Customer')

@section('content')
    <div class="max-w-3xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('customers.index') }}"
                class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="bg-yellow-50 px-6 py-4 border-b border-gray-200">
                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-yellow-600"></i> Edit Details
                </h3>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('customers.update', $customer) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="name" :value="__('Full Name')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-gray-400"></i>
                                </div>
                                <x-text-input id="name" class="block w-full pl-10" type="text" name="name"
                                    :value="old('name', $customer->name)" required autofocus />
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
                                    :value="old('father_name', $customer->father_name)" placeholder="e.g. Haji Barkatullah" />
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
                                    :value="old('phone', $customer->phone)" required />
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
                                    <option value="male" {{ $customer->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $customer->gender == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other" {{ $customer->gender == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="address" :value="__('Address')" />
                            <div class="relative mt-1">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                                </div>
                                <textarea id="address" name="address"
                                    class="block w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="3">{{ old('address', $customer->address) }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100">
                        <button type="button" onclick="history.back()"
                            class="mr-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                        <x-primary-button class="gap-2">
                            <i class="fa-solid fa-save"></i> {{ __('Update Customer') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
