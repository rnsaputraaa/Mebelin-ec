<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mebelin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-wood {
            background-color: #d6c6a8;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-wood ">
        <!-- Logo -->
        <div class="mb-6">
            <img src="{{ asset(path: 'img/logo.png') }}" alt="Mebelin Logo" class="max-w-full h-40" />
        </div>

        <!-- Login Card -->
        <div class="w-full sm:max-w-4xl mt-6 p-4 bg-white shadow-md overflow-hidden sm:rounded-3xl">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Left Side -->
                <div class="w-full md:w-2/3 flex items-center justify-center bg-[#ffffff] rounded-xl">
                    @if (Request::is('login'))
                        <img src="{{ asset('img/auth-banner/1.jpg') }}" alt="Login Image" class="max-w-full h-auto" />
                    @elseif (Request::is('register'))
                        <img src="{{ asset('img/auth-banner/2.jpg') }}" alt="Register Image"
                            class="max-w-full h-auto" />
                    @else
                        <img src="{{ asset('img/default-image.png') }}" alt="Default Image" class="max-w-full h-auto" />
                    @endif
                </div>
        
                <!-- Right Side -->
                <div class="w-full md:w-1/3 bg-[#ceb795] p-6 rounded-xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
        <footer class="w-full text-center py-4 text-black text-sm mt-7 mb-7">
            &copy; {{ date('Y') }} Mebelin. All rights reserved.
        </footer>
        
    </div>
    
</body>

<footer>
    <h1></h1>
</footer>
</html>
