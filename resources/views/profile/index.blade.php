@extends('layouts.app')

@section('title','My Profile')

@section('page_title','My Profile')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->

    <div class="bg-white rounded-xl shadow border mb-6">

        <div class="px-6 py-5 border-b">

            <h2 class="text-2xl font-bold text-gray-800">

                My Profile

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Manage your account information and password.

            </p>

        </div>

        <!-- Tabs -->

        <div class="flex border-b">

            <button
                id="profileTab"
                class="flex-1 py-4 text-center font-semibold text-red-700 border-b-2 border-red-700">

                <i class="fa-solid fa-user mr-2"></i>

                My Profile

            </button>

            <button
                id="passwordTab"
                class="flex-1 py-4 text-center font-semibold text-gray-500">

                <i class="fa-solid fa-lock mr-2"></i>

                Change Password

            </button>

        </div>

        <div class="p-6">

            <!-- ============================= -->
            <!-- Profile Section -->
            <!-- ============================= -->

            <div id="profileSection">

                <form
                    action="{{ route('profile.update') }}"
                    method="POST">

                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Name

                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ $user->name }}"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-600">

                        </div>

                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ $user->email }}"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-600">

                        </div>

                    </div>

                    <div class="mt-6">

                        <button
                            type="submit"
                            class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg">

                            Update Profile

                        </button>

                    </div>

                </form>

            </div>

            <!-- ============================= -->
            <!-- Password Section -->
            <!-- ============================= -->

            <div
                id="passwordSection"
                class="hidden">

                                <form
                    action="{{ route('profile.password') }}"
                    method="POST">

                    @csrf

                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5">

                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Current Password

                            </label>

                            <input
                                type="password"
                                name="current_password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-600">

                        </div>

                        <div>

                            <label class="block text-sm font-medium mb-2">

                                New Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-600">

                        </div>

                        <div>

                            <label class="block text-sm font-medium mb-2">

                                Confirm Password

                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-600">

                        </div>

                    </div>

                    <div class="mt-6">

                        <button
                            type="submit"
                            class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg">

                            Change Password

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

$(function(){

    function showProfile(){

        $("#profileSection").show();

        $("#passwordSection").hide();

        $("#profileTab")
            .addClass("text-red-700 border-b-2 border-red-700")
            .removeClass("text-gray-500");

        $("#passwordTab")
            .removeClass("text-red-700 border-b-2 border-red-700")
            .addClass("text-gray-500");

    }

    function showPassword(){

        $("#profileSection").hide();

        $("#passwordSection").show();

        $("#passwordTab")
            .addClass("text-red-700 border-b-2 border-red-700")
            .removeClass("text-gray-500");

        $("#profileTab")
            .removeClass("text-red-700 border-b-2 border-red-700")
            .addClass("text-gray-500");

    }

    $("#profileTab").on("click", function(){

        showProfile();

    });

    $("#passwordTab").on("click", function(){

        showPassword();

    });

    // Open Password tab if URL has #change-password
    if(window.location.hash === "#change-password"){

        showPassword();

    }else{

        showProfile();

    }

});

</script>

@endpush