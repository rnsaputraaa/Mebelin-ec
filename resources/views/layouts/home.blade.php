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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
</head>

<body class="font-[Inter]">
    
    <header class="bg-[#CBAF87] fixed top-0 w-full z-50 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-2">
                    <img src="img/logo.png" alt="Logo Mebelin" class="h-10 w-auto">
                    <span class="text-xl font-bold">x</span>
                    <img src="img/unira.png" alt="Logo Kolaborasi" class="h-10 w-auto">
                </div>

                <div class="md:hidden">
                    <button id="menu-toggle" class="text-gray-800 focus:outline-none text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div class="hidden md:flex flex-1 mx-8">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 21l-4.35-4.35M16 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Cari di Mebelin" class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#BF654B]">
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-6">
                    <div class="flex gap-4 text-gray-900 text-xl">
                        @auth
                            <a href="{{ route('pemesanan') }}" class="hover:text-[#BF654B]"><i class="fas fa-shopping-cart"></i></a>
                            <a href="{{ url('/dashboard') }}" class="hover:text-[#BF654B]"><i class="fas fa-user-circle"></i></a>
                        @else
                            <a href="#" onclick="return showLoginAlert(event)" class="hover:text-[#BF654B]"><i class="fas fa-shopping-cart"></i></a>
                            <a href="#" onclick="return showLoginAlert(event)" class="hover:text-[#BF654B]"><i class="fas fa-user-circle"></i></a>
                        @endauth
                    </div>

                    @guest
                        @if (Route::has('login'))
                            <nav class="flex items-center gap-2">
                                <a href="{{ route('login') }}"
                                    class="rounded-lg bg-[#BF654B] px-5 py-2 text-sm font-medium text-white hover:bg-orange-900">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-lg bg-white px-5 py-2 text-sm font-medium text-[#BF654B] hover:bg-gray-100">
                                        Daftar
                                    </a>
                                @endif
                            </nav>
                        @endif
                    @endguest
                </div>
            </div>

            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <div class="flex flex-col gap-4 text-gray-900">
                    <div class="relative">
                        <input type="text" placeholder="Cari di Mebelin"
                            class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#BF654B]">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 21l-4.35-4.35M16 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0z" />
                            </svg>
                        </span>
                    </div>

                    <div class="flex gap-4 text-xl justify-center">
                        @auth
                            <a href="{{ route('pemesanan') }}" class="hover:text-[#BF654B]">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            <a href="{{ url('/dashboard') }}" class="hover:text-[#BF654B]">
                                <i class="fas fa-user-circle"></i>
                            </a>
                        @else
                            <a href="#" onclick="return showLoginAlert(event)" class="hover:text-[#BF654B]">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            <a href="#" onclick="return showLoginAlert(event)" class="hover:text-[#BF654B]">
                                <i class="fas fa-user-circle"></i>
                            </a>
                        @endauth
                    </div>

                    <div class="flex justify-center gap-2 mt-2">
                        @guest
                            <a href="{{ route('login') }}"
                                class="rounded-lg bg-[#BF654B] px-5 py-2 text-sm font-medium text-white hover:bg-orange-900">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-lg bg-white px-5 py-2 text-sm font-medium text-[#BF654B] hover:bg-gray-100">
                                    Daftar
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-400">
        <div class="container mx-auto max-w-screen-xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 text-sm text-center sm:text-left">

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><a href="#" class="hover:text-[#BF654B]">About Us</a></li>
                        <li><a href="#" class="hover:text-[#BF654B]">Shipping</a></li>
                        <li><a href="#" class="hover:text-[#BF654B]">Returns</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Customer Service</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><a href="#" class="hover:text-[#BF654B]">FAQ's</a></li>
                        <li><a href="#" class="hover:text-[#BF654B]">Track Order</a></li>
                        <li><a href="#" class="hover:text-[#BF654B]">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-[#BF654B]">Terms & Conditions</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Enjoy special benefits in the app</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li>70% off in-app only</li>
                        <li>App-only promo</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Payment</h3>
                    <div class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-2">
                        <img src="img/gopay.png" alt="Gopay" class="h-5 mx-auto lg:mx-0">
                        <img src="img/ovo.png" alt="OVO" class="h-6 mx-auto lg:mx-0">
                        <img src="img/dana.png" alt="Dana" class="h-4 mx-auto lg:mx-0">
                        <img src="img/link.png" alt="LinkAja" class="h-6 mx-auto lg:mx-0">
                        <img src="img/bca.png" alt="BCA" class="h-4 mx-auto lg:mx-0">
                        <img src="img/bri.png" alt="BRI" class="h-5 mx-auto lg:mx-0">
                        <img src="img/mandiri.png" alt="Mandiri" class="h-12 mx-auto lg:mx-0">
                        <img src="img/bni.png" alt="BNI" class="h-3 mx-auto lg:mx-0">
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Shipping</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-2">
                        <img src="img/logo2.png" alt="logo" class="h-12 mx-auto lg:mx-0">
                        <img src="img/sicepat.png" alt="SiCepat" class="h-4 mx-auto lg:mx-0">
                        <img src="img/jne.png" alt="JNE" class="h-8 mx-auto lg:mx-0">
                        <img src="img/jnt.png" alt="J&T" class="h-12 mx-auto lg:mx-0">
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-400 pt-4 text-center text-xs text-gray-500">
                © 2025 Mebelin all rights reserved
            </div>
        </div>
    </footer>
    
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    <script>
        function showLoginAlert(event) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Akses Ditolak',
                text: 'login dulu untuk mengakses fitur ini',
                confirmButtonColor: '#BF654B',
                confirmButtonText: 'Login',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    </script>

</body>
</html>