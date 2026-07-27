<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AGNI | Login</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>

        body{
            font-family:'Inter',sans-serif;
            background:#F3F4F6;
        }

    </style>

</head>

<body class="min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md">

    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

        <div class="bg-red-700 text-center py-8">

            <img src="{{ asset('images/agni-logo.png') }}" alt="AGNI" class="mx-auto h-16 w-16 rounded-full bg-white p-1 shadow">

            <h1 class="text-2xl font-bold text-white tracking-wider mt-3">

                AGNI

            </h1>

            <p class="text-red-100 mt-2">

                Dealer Management System

            </p>

        </div>

        <div class="p-8">

            @if(session('success'))

                <div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="mb-5 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">

                    {{ session('error') }}

                </div>

            @endif

            <form action="{{ route('login.post') }}" method="POST">

                @csrf

                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter Email Address"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-600">

                    @error('email')

                        <p class="text-red-600 text-sm mt-2">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter Password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-600">

                    @error('password')

                        <p class="text-red-600 text-sm mt-2">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                <div class="flex items-center justify-between mb-6">

                    <label class="flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="rounded">

                        <span class="text-sm text-gray-600">

                            Remember Me

                        </span>

                    </label>

                </div>

                <button
                    type="submit"
                    class="w-full bg-red-700 hover:bg-red-800 transition duration-300 text-white font-semibold py-3 rounded-lg">

                    LOGIN

                </button>

            </form>

        </div>

    </div>

    <div class="text-center mt-6 text-sm text-gray-500">

        © {{ date('Y') }} AGNI Steel. All Rights Reserved.

    </div>

</div>

</body>

</html>