@extends('layouts.shop')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow-lg sm:rounded-2xl border-t-4 border-indigo-600">
            <div class="max-w-xl">
                @include('pages.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow-lg sm:rounded-2xl border-t-4 border-indigo-600">
            <div class="max-w-xl">
                @include('pages.profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow-lg sm:rounded-2xl border-t-4 border-red-600">
            <div class="max-w-xl">
                @include('pages.profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
