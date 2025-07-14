<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="icon" type="image/png" href="img/logo1.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8" style="background-color: #C9B194;">
    <div class="w-full max-w-sm sm:max-w-md lg:max-w-lg xl:max-w-xl">
        <div class="text-center mb-6 sm:mb-8">
            <div class="mb-4 sm:mb-6">
                <img src="{{ asset('img/logo.png') }}" alt="Company Logo" class="mx-auto h-12 sm:h-16 lg:h-20 w-auto">
            </div>
        </div>

        <div
            class="bg-white rounded-xl sm:rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8 lg:p-10 backdrop-blur-sm">
            <div class="text-center mb-6 sm:mb-8">
                <p class="text-gray-600 text-xs sm:text-sm lg:text-base leading-relaxed px-2 sm:px-0">
                    {{ __('Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi melalui email yang memungkinkan Anda memilih kata sandi baru.') }}
                </p>
            </div>

            @if (session('status'))
                <div
                    class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm sm:text-base font-semibold text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                        <input id="email"
                            class="block w-full pl-9 sm:pl-10 pr-4 py-2.5 sm:py-3 lg:py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-900 focus:border-orange-900 transition-all duration-200 bg-gray-50 focus:bg-white text-gray-900 placeholder-gray-500 focus:outline-none text-sm sm:text-base"
                            type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="Masukkan email Anda" />
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 sm:pt-4">
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 lg:py-4 bg-orange-900 hover:bg-[#BF654B] text-white font-semibold rounded-lg shadow-lg">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>

            <div class="mt-4 sm:mt-6 text-center">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center text-xs sm:text-sm text-gray-600 hover:text-orange-900 transition-colors duration-200">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Login
                </a>
            </div>

            <div class="text-center mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-400 text-xs text-gray-900">
                <p>© 2025 Mebelin. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
