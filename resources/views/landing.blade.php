@extends('layouts.home')

@section('content')
    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl pt-24">
            <div id="carousel-container" class="relative w-full overflow-hidden rounded-lg">

                <div id="carousel-slides" class="flex transition-transform duration-500 ease-in-out">
                    <div class="carousel-slide w-full flex-shrink-0">
                        <div class="relative w-full h-48 sm:h-64 md:h-80 lg:h-96">
                            <img src="img/banner1.png" alt="Promo Banner 1" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="carousel-slide w-full flex-shrink-0">
                        <div class="relative w-full h-48 sm:h-64 md:h-80 lg:h-96">
                            <img src="img/banner2.jpg" alt="Promo Banner 2" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="carousel-slide w-full flex-shrink-0">
                        <div class="relative w-full h-48 sm:h-64 md:h-80 lg:h-96">
                            <img src="img/banner3.jpg" alt="Promo Banner 3" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button
                        class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-opacity"
                        data-index="0"></button>
                    <button
                        class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-opacity"
                        data-index="1"></button>
                    <button
                        class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-opacity"
                        data-index="2"></button>
                </div>

                <button id="prev-btn"
                    class="absolute top-1/2 left-2 transform -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-black bg-opacity-30 text-white rounded-full hover:bg-opacity-50 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="next-btn"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-black bg-opacity-30 text-white rounded-full hover:bg-opacity-50 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="max-w-prose text-left">
                    <h1 class="text-4xl font-bold text-gray-900 sm:text-4xl">
                        Modern Furniture for Modern Living
                    </h1>

                    <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
                        Discover out collection of handcrafted furniture pieces that blend style and comfort
                    </p>

                    <div class="mt-4 flex gap-4 sm:mt-6 pt-5">
                        <a href="{{ route('produk') }}"
                            class="inline-block rounded-lg border border-[#BF654B] bg-[#BF654B] px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-orange-900">Shop
                            Now</a>
                    </div>
                </div>

                <div class="flex justify-center lg:justify-end">
                    <img src="img/banner.png" alt="Modern Furniture" class="rounded-lg object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Kategori Produk</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <a href="" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c1.png" alt="Living Room" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Living Room</span>
                </a>

                <a href="/category/bedroom"
                    class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c2.png" alt="Bedroom" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Bedroom</span>
                </a>

                <a href="/category/dining-room"
                    class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c3.png" alt="Dining Room" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Dining Room</span>
                </a>

                <a href="/category/kitchen"
                    class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c4.png" alt="Kitchen" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Kitchen</span>
                </a>

                <a href="/category/workspace"
                    class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c5.png" alt="Workspace" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Workspace</span>
                </a>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Produk Pilihan</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-2">Rp 200.000</p>
                    <div class="flex items-center mb-4">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm text-gray-600 ml-1">4.8</span>
                    </div>
                    @auth
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @else
                        <a href="#" onclick="return showLoginAlert(event)"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @endauth
                </div>

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-2">Rp 200.000</p>
                    <div class="flex items-center mb-4">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm text-gray-600 ml-1">4.8</span>
                    </div>
                    @auth
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @else
                        <a href="#" onclick="return showLoginAlert(event)"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @endauth
                </div>

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-2">Rp 200.000</p>
                    <div class="flex items-center mb-4">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm text-gray-600 ml-1">4.8</span>
                    </div>
                    @auth
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @else
                        <a href="#" onclick="return showLoginAlert(event)"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @endauth
                </div>

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-2">Rp 200.000</p>
                    <div class="flex items-center mb-4">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm text-gray-600 ml-1">4.8</span>
                    </div>
                    @auth
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @else
                        <a href="#" onclick="return showLoginAlert(event)"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Testimoni</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 1" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="text-lg font-semibold">Adit</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 2" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="text-lg font-semibold">Reynal</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 3" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="text-lg font-semibold">Walid</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 4" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="text-lg font-semibold">Rama</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 5" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="text-lg font-semibold">Amir</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 6" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="text-lg font-semibold">Zaini</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">Pelayanan sangat baik dan memuaskan!</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">(FAQ's) Pertanyaan yang sering diajukan</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Bagaimana cara memesan produk di Mebelin?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Cukup pilih produk yang Anda inginkan, klik "Add to Card", lalu lanjutkan ke proses Checkout. Ikuti
                        langkah-langkah pembayaran yang tersedia
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Apakah produk yang dijual di Mebelin ready stock?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Sebagian besar produk kami ready stock. Namun, beberapa produk custom membutuhkan waktu produksi
                        tambahan. Informasi ketersediaan akan tertera di halaman produk
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Berapa lama estimasi pengiriman?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        2-5 hari kerja
                        5-14 hari kerja Untuk produk custom, waktu pengiriman dihitung setelah proses produksi selesai.
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium"> Apakah saya bisa request custom ukuran atau warna?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Ya, Mebelin menerima custom order untuk ukuran dan warna tertentu. Silakan hubungi tim customer
                        service kami untuk konsultasi lebih lanjut.
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Metode pembayaran apa saja yang tersedia?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Transfer Bank (BCA, BRI, Mandiri, BNI)
                        E-Wallet (Gopay, OVO, DANA,)
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Apakah ada garansi untuk produk yang dibeli?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Ya, kami memberikan garansi 3 Bulan untuk kerusakan pabrikasi pada sebagian besar produk kami.
                        Syarat dan ketentuan berlaku.
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Bagaimana prosedur retur atau penukaran barang?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Jika Anda menerima produk dalam kondisi rusak atau tidak sesuai, silakan hubungi kami dalam waktu
                        maksimal 3 hari setelah barang diterima. Tim kami akan membantu proses retur atau penggantian.
                    </p>
                </details>

                <details class="group [&_summary::-webkit-details-marker]:hidden mb-5">
                    <summary
                        class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                        <h2 class="text-lg font-medium">Apakah ada layanan instalasi/pemasangan furniture?</h2>
                        <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="px-4 pt-4 text-gray-900">
                        Untuk area tertentu seperti pamekasan, kami menyediakan layanan instalasi dengan biaya tambahan.
                        Info lengkap dapat ditanyakan ke customer service.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl mb-10">
            <div class="flex flex-col md:flex-row gap-12">
                <div class="md:w-1/2">
                    <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Tentang Kami</h2>
                    <p class="text-gray-700 mb-4 text-justify">
                        Mebelin adalah e-commerce mebel yang didedikasikan untuk menghadirkan keindahan dan kenyamanan ke
                        dalam setiap rumah.
                        Dengan perpaduan antara desain tradisional dan sentuhan modern, kami menciptakan furnitur
                        berkualitas tinggi yang menjadi bagian dari cerita hidup Anda.
                    </p>
                    <p class="text-gray-700 mb-6 text-justify">
                        Berawal dari sebuah bengkel kecil, Mebelin kini telah berkembang menjadi destinasi utama bagi mereka
                        yang mencari furnitur berkualitas dengan harga terjangkau.
                        Kami memahami bahwa setiap perabot bukan hanya sekadar benda fungsional, tetapi juga cerminan dari
                        kepribadian dan gaya hidup Anda.
                    </p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-center space-x-4">
                            <div class="bg-[#BF654B] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-medium">Kualitas Premium</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-[#BF654B] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-medium">Desain Modern</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-[#BF654B] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-medium">Pengiriman Cepat</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-[#BF654B] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-medium">Bergaransi</span>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2">
                    <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Kenapa Mebelin?</h2>
                    <ul class="space-y-4 text-gray-700 text-justify list-disc pl-5">
                        <li>
                            <strong>Pengrajin dan Desainer Profesional</strong><br>
                            Tim kami terdiri dari para pengrajin berpengalaman dan desainer kreatif yang bersama-sama untuk
                            menciptakan karya terbaik.
                        </li>
                        <li>
                            <strong>Kualitas Produk yang Terjamin</strong><br>
                            Setiap produk dibuat dengan ketelitian dan cinta, menghasilkan furnitur yang tidak hanya indah
                            dipandang, tetapi juga kuat dan tahan lama.
                        </li>
                        <li>
                            <strong>Proses Belanja yang Mudah dan Aman</strong><br>
                            Mulai dari pemilihan bahan baku berkualitas hingga pengiriman ke rumah Anda, kami memastikan
                            setiap detail diperhatikan dengan seksama untuk memberikan pengalaman belanja yang memuaskan.
                        </li>
                        <li>
                            <strong>Harga Terjangkau</strong><br>
                            Kami menawarkan produk berkualitas tinggi dengan harga yang tetap ramah di kantong, karena
                            setiap rumah berhak mendapatkan furnitur terbaik.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('carousel-container');
            const slides = document.getElementById('carousel-slides');
            const slideElements = document.querySelectorAll('.carousel-slide');
            const dotsElements = document.querySelectorAll('.carousel-dot');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            let currentIndex = 0;
            const slideCount = slideElements.length;
            let slideWidth = container.clientWidth;
            let autoplayInterval;

            function initCarousel() {
                container.style.width = '100%';

                slideElements.forEach(slide => {
                    slide.style.width = `${slideWidth}px`;
                });

                slides.style.width = `${slideWidth * slideCount}px`;

                goToSlide(currentIndex, false);
            }

            updateActiveDot();

            function updateSlideWidth() {
                slideWidth = container.clientWidth;

                slideElements.forEach(slide => {
                    slide.style.width = `${slideWidth}px`;
                });

                slides.style.width = `${slideWidth * slideCount}px`;

                goToSlide(currentIndex, false);
            }

            initCarousel();
            window.addEventListener('resize', updateSlideWidth);

            function goToSlide(index, animate = true) {
                if (index < 0) {
                    index = slideCount - 1;
                } else if (index >= slideCount) {
                    index = 0;
                }

                currentIndex = index;
                const offset = -currentIndex * slideWidth;

                if (!animate) {
                    slides.style.transition = 'none';
                    slides.style.transform = `translateX(${offset}px)`;
                    // Force reflow
                    slides.offsetHeight;
                    slides.style.transition = 'transform 500ms ease-in-out';
                } else {
                    slides.style.transform = `translateX(${offset}px)`;
                }

                updateActiveDot();
                resetAutoplay();
            }

            function updateActiveDot() {
                dotsElements.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.classList.add('opacity-100');
                        dot.classList.remove('opacity-50');
                    } else {
                        dot.classList.add('opacity-50');
                        dot.classList.remove('opacity-100');
                    }
                });
            }

            prevBtn.addEventListener('click', () => {
                goToSlide(currentIndex - 1);
            });

            nextBtn.addEventListener('click', () => {
                goToSlide(currentIndex + 1);
            });

            dotsElements.forEach(dot => {
                dot.addEventListener('click', () => {
                    const index = parseInt(dot.getAttribute('data-index'));
                    goToSlide(index);
                });
            });

            function startAutoplay() {
                autoplayInterval = setInterval(() => {
                    goToSlide(currentIndex + 1);
                }, 5000);
            }

            function resetAutoplay() {
                clearInterval(autoplayInterval);
                startAutoplay();
            }

            let touchStartX = 0;
            let touchEndX = 0;

            container.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, {
                passive: true
            });

            container.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, {
                passive: true
            });

            function handleSwipe() {
                const threshold = 50;
                if (touchEndX < touchStartX - threshold) {
                    goToSlide(currentIndex + 1);
                } else if (touchEndX > touchStartX + threshold) {
                    goToSlide(currentIndex - 1);
                }
            }
            startAutoplay();
        });
    </script>
@endsection
