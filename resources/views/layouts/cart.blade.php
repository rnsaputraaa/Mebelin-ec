<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link rel="icon" type="image/png" href="img/logo1.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="pt-10 px-4">
        <div class="relative max-w-screen-xl mx-auto h-32 rounded-lg bg-[#CBAF87]">
            <div class="absolute left-4 top-4 flex items-center space-x-2">
                <img src="img/logo.png" alt="Mebelin" class="h-20 pt-5">
                <span class="text-xl font-bold pt-5">x</span>
                <img src="img/unira.png" alt="Unira" class="h-20 pt-5">
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white mt-10">
        <div class="w-full border-t border-gray-400"></div>
        <div class="mx-auto max-w-screen-xl px-4 pt-8 pb-8 sm:px-6 lg:px-8">
            <p class="text-center text-xs/relaxed text-gray-500">
                © Mebelin 2025. All rights reserved.
            </p>
        </div>
    </footer>

</body>

</html>
