<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mebelin</title>
    <link rel="icon" type="image/png" href="img/logo1.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-[Inter]">

    <header class="bg-[#CBAF87] fixed top-0 w-full z-50 p-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-0">
            <div class="flex flex-col md:flex-row items-center gap-4 w-full md:flex-1 md:mx-8">
                <img src="img/logo.png" alt="Logo Mebelin" class="h-14 w-auto">

                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 21l-4.35-4.35M16 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/>
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari di Mebelin" class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#BF654B]">
                </div>
            </div>


            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                <div class="flex gap-4 text-gray-900 text-xl">
                    <a href="#" class="hover:text-[#BF654B]"><i class="fas fa-shopping-cart"></i></a>
                    <a href="#" class="hover:text-[#BF654B]"><i class="fas fa-user-circle"></i></a>
                </div>

                <div class="flex gap-2 sm:gap-2">
                    @if (Route::has('login'))
                        <nav class="flex items-center justify-end gap-4">
                            @auth
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-full border border-[#BF654B] bg-[#BF654B] px-5 py-2.5 font-medium text-white hover:bg-orange-900">  Logout</button>

                                    </a>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full bg-[#BF654B] px-5 py-2.5 text-sm font-medium text-white hover:bg-orange-900">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-full bg-white px-5 py-2.5 text-sm font-medium text-[#BF654B] hover:bg-gray-100">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t-2 border-gray-300">
        <div class="container mx-auto max-w-screen-xl space-y-8 px-4 py-16 sm:px-6 lg:space-y-16 lg:px-8">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
              <img src="img/logo.png" alt="Logo Mebelin" class="h-14 w-auto">
            </div>

            <div>
              <h1 class="font-bold text-gray-900">Mebelin</h1>
              <p class="mt-6 space-y-4 text-sm text-gray-700">Quality furniture for modern living</p>
            </div>

            <div>
              <p class="font-bold text-gray-900">Quick Links</p>
              <ul class="mt-6 space-y-4 text-sm">
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">About Us</a></li>
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">Shipping</a></li>
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">Returns</a></li>
              </ul>
            </div>

            <div>
              <p class="font-bold text-gray-900">Customer Services</p>
              <ul class="mt-6 space-y-4 text-sm">
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">FAQ</a></li>
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">Track Order</a></li>
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">Privacy Policy</a></li>
                <li><a href="#" class="text-gray-700 transition hover:opacity-75">Terms & Conditions</a></li>
              </ul>
            </div>
          </div>

          <div class="border-t-2 border-gray-300 pt-6 text-center">
            <p class="text-xs text-gray-500">&copy; 2025. Mebelin. All rights reserved.</p>
          </div>
        </div>
    </footer>
    
    <script>
        function toggleSearch() {
            const searchContainer = document.getElementById('searchContainer');
            searchContainer.classList.toggle('hidden');
            
            if (!searchContainer.classList.contains('hidden')) {
                document.getElementById('searchInput').focus();
            }
        }
    </script>
    
</body>
</html>
