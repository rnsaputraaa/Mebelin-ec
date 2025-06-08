@extends('layouts.home')

@section('content')
    <div class="w-full mx-auto p-4 mt-5 bg-white">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl pt-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="relative bg-gray-100 rounded-lg overflow-hidden">
                        <img id="mainImage" src="img/produk.png" alt="Modern Sofa" class="w-full h-80 object-cover">
                    </div>

                    <div class="flex items-center space-x-2">
                        <button class="p-2 rounded-full bg-gray-200 hover:bg-gray-300" onclick="previousImage()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        
                        <div class="flex space-x-2 overflow-x-auto" id="thumbnailContainer">
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded border-2 border-blue-500 cursor-pointer" data-index="0" onclick="changeMainImage('img/produk.png', this)">
                                <img src="img/produk.png" alt="Sofa 1" class="w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded cursor-pointer" data-index="1" onclick="changeMainImage('img/produk1.jpg', this)">
                                <img src="img/produk1.jpg" alt="Sofa 2" class="w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded cursor-pointer" data-index="2" onclick="changeMainImage('img/produk2.jpg', this)">
                                <img src="img/produk2.jpg" alt="Sofa 3" class="w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded cursor-pointer" data-index="3" onclick="changeMainImage('img/produk3.jpg', this)">
                                <img src="img/produk3.jpg" alt="Sofa 4" class="w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded cursor-pointer" data-index="4" onclick="changeMainImage('img/produk4.jpg', this)">
                                <img src="img/produk4.jpg" alt="Sofa 5" class="w-full h-full object-cover rounded">
                            </div>
                        </div>
                        
                        <button class="p-2 rounded-full bg-gray-200 hover:bg-gray-300" onclick="nextImage()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Modern Sofa</h1>
                        <p class="text-1xl">Rp 200.000</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Warna</h3>
                        <div class="grid grid-cols-3 gap-2">
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded hover:border-[#BF654B] focus:border-[#BF654B] focus:ring-1 focus:ring-[#BF654B]" onclick="selectColor(this)">
                                Warna 1
                            </button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded hover:border-[#BF654B] focus:border-[#BF654B] focus:ring-1 focus:ring-[#BF654B]" onclick="selectColor(this)">
                                Warna 2
                            </button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded hover:border-[#BF654B] focus:border-[#BF654B] focus:ring-1 focus:ring-[#BF654B]" onclick="selectColor(this)">
                                Warna 3
                            </button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded hover:border-[#BF654B] focus:border-[#BF654B] focus:ring-1 focus:ring-[#BF654B]" onclick="selectColor(this)">
                                warna 4
                            </button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded hover:border-[#BF654B] focus:border-[#BF654B] focus:ring-1 focus:ring-[#BF654B]" onclick="selectColor(this)">
                                Warna 5
                            </button>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Kuantitas</h3>
                        <div class="flex items-center space-x-3">
                            <button class="w-8 h-8 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-50" onclick="decreaseQuantity()">
                                <span>-</span>
                            </button>
                            <span id="quantity" class="text-lg font-medium">1</span>
                            <button class="w-8 h-8 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-50" onclick="increaseQuantity()">
                                <span>+</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-3 md:flex-row md:space-y-0 md:space-x-4 mt-10">
                        <a href="{{ route('pemesanan') }}" class="w-full md:w-auto bg-[#BF654B] text-white py-3 px-6 rounded-lg font-medium hover:bg-orange-900 text-center">
                            Tambah keranjang
                        </a>
                        <a href="{{ route('pemesanan') }}" class="w-full md:w-auto border border-[#BF654B] text-[#BF654B] py-3 px-6 rounded-lg font-medium hover:bg-gray-100 text-center">
                            Beli Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="w-full mx-auto p-4 mt-5">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Deskripsi</h2>
            <div class="bg-white rounded-lg p-6 border border-[#BF654B]">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.
                </p>
            </div>
        </div>
    </section>

    <section class="w-full mx-auto p-4 mt-5">
        <div class="container mx-auto px-6 lg:px-16 max-w-7xl">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Spesifikasi</h2>
            <div class="bg-white rounded-lg p-6 border border-[#BF654B]">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.
                </p>
            </div>
        </div>
    </section>

    <div class="flex flex-col lg:flex-row gap-6 px-12 py-6 max-w-7xl mx-auto mt-5">
        <section class="lg:w-1/3 w-full p-4">
            <h2 class="text-2xl font-bold mb-4 text-gray-900">Rating</h2>
            <div class="bg-white rounded-lg p-6 border border-[#BF654B] shadow-sm">

                <div class="flex gap-6">
                    <div class="flex flex-col">
                        <div class="text-4xl font-semibold">★ 4.7</div>
                        <p class="text-sm text-gray-700 mt-1">100% pembeli merasa puas</p>
                    </div>

                    <ul class="text-sm space-y-1">
                        <li class="flex justify-between">
                            <span class="text-gray-700">★ 5</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-700">★ 4</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-700">★ 3</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-700">★ 2</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-700">★ 1</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="lg:w-2/3 w-full p-4">
            <h2 class="text-2xl font-bold mb-4 text-gray-900">Comment Reviews</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <p class="text-gray-700">Barangnya sesuai ekspektasi! Kualitas kayu solid dan finishing-nya rapi banget. Pengiriman juga cepat. Pasti repeat order di Mebelin!</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="flex items-center mb-4">
                        <img src="https://i.pravatar.cc/100?img=6" alt="User 2" class="w-12 h-12 rounded-full mr-4">
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
                    <p class="text-gray-700">Sangat puas dengan meja makan dari Mebelin. Desainnya elegan, kayunya kokoh, dan hasil akhirnya halus. Terasa sekali kalau pakai material premium. Terima kasih Mebelin</p>
                </div>
            </div>
        </section>
    </div>

    <script>
        function changeMainImage(src, element) {
            document.getElementById('mainImage').src = src;

            if (element.hasAttribute('data-index')) {
                currentImageIndex = parseInt(element.getAttribute('data-index'));
            }
            
            const thumbnails = document.querySelectorAll('.flex-shrink-0');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('border-2', 'border-blue-500');
            });

            element.classList.add('border-2', 'border-blue-500');
        }

        const images = [
            'img/produk.png',
            'img/produk1.jpg',
            'img/produk2.jpg',
            'img/produk3.jpg',
            'img/produk4.jpg'
        ];
        
        let currentImageIndex = 0;
        
        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            const thumbnails = document.querySelectorAll('[data-index]');
            const currentThumbnail = document.querySelector(`[data-index="${currentImageIndex}"]`);
            changeMainImage(images[currentImageIndex], currentThumbnail);
        }
        
        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            const thumbnails = document.querySelectorAll('[data-index]');
            const currentThumbnail = document.querySelector(`[data-index="${currentImageIndex}"]`);
            changeMainImage(images[currentImageIndex], currentThumbnail);
        }

        function selectColor(element) {
            const colorButtons = document.querySelectorAll('[onclick="selectColor(this)"]');
            colorButtons.forEach(button => {
                button.classList.remove('border-[#BF654B]', 'ring-1', 'ring-[#BF654B]');
                button.classList.add('border-gray-300');
            });

            element.classList.remove('border-gray-300');
            element.classList.add('border-[#BF654B]', 'ring-1', 'ring-[#BF654B]');
        }

        function increaseQuantity() {
            const quantityElement = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityElement.textContent);
            quantityElement.textContent = currentQuantity + 1;
        }
        
        function decreaseQuantity() {
            const quantityElement = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityElement.textContent);
            if (currentQuantity > 1) {
                quantityElement.textContent = currentQuantity - 1;
            }
        }
    </script>
@endsection