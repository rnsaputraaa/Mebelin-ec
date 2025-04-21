<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto p-4">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Left side - Images -->
            <div class="md:w-1/2">
                <div class="relative mb-4">
                    <img src="{{ asset('img/produk.png') }}" alt="Modern Sofa" class="w-[30] object-cover rounded">

                    <button class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>

                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>

                <div class="flex gap-2 overflow-x-auto">
                    <div class="cursor-pointer border-2 border-gray-700">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                    </div>
                    <div class="cursor-pointer border-2 border-gray-200">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                    </div>
                    <div class="cursor-pointer border-2 border-gray-200">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                    </div>
                    <div class="cursor-pointer border-2 border-gray-200">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                    </div>
                </div>
            </div>

            <!-- Right side - Product info -->
            <div class="md:w-1/2">
                <h1 class="text-2xl font-bold mb-2">Modern Sofa</h1>
                <p class="text-xl mb-4">Rp 200.000</p>

                <div class="mb-6">
                    <h3 class="font-medium mb-2">Warna</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <button class="py-2 px-4 border border-gray-300 rounded hover:border-gray-700">Warna 1</button>
                        <button class="py-2 px-4 border border-gray-300 rounded hover:border-gray-700">Warna 2</button>
                        <button class="py-2 px-4 border border-gray-300 rounded hover:border-gray-700">Warna 3</button>
                        <button class="py-2 px-4 border border-gray-300 rounded hover:border-gray-700">warna 4</button>
                        <button class="py-2 px-4 border border-gray-300 rounded hover:border-gray-700">Warna 5</button>
                        <button class="py-2 px-4 border border-gray-300 rounded hover:border-gray-700">Warna 6</button>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-medium mb-2">Kuantitas</h3>
                    <div class="flex items-center">
                        <button class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-l hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                        </button>
                        <div class="w-12 h-8 flex items-center justify-center border-t border-b border-gray-300">
                            1
                        </div>
                        <button class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-r hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    <button class="w-full py-3 bg-red-400 text-white rounded-md hover:bg-red-500 transition">
                        Tambah keranjang
                    </button>
                    <button class="w-full py-3 border border-red-400 text-red-400 rounded-md hover:bg-red-50 transition">
                        Beli Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-12">
            <h2 class="font-medium mb-2">Deskripsi</h2>
            <div class="border border-gray-300 rounded-md p-4">
                <p class="text-gray-700">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.
                </p>
            </div>
        </div>

        <!-- Specifications -->
        <div class="mt-6 mb-12">
            <h2 class="font-medium mb-2">Spesifikasi</h2>
            <div class="border border-gray-300 rounded-md p-4">
                <p class="text-gray-700">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
