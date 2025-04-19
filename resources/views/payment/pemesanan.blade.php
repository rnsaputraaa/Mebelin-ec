<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mebelin - Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="fixed top-0 z-50 w-[70%] left-[15%] right-[15%] mt-4 bg-[#CBAF87] p-4 rounded-lg">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
            <div class="flex flex-col md:flex-row items-center gap-4 w-full md:flex-1 md:mx-8">
                <img src="img/logo.png" alt="Logo Mebelin" class="h-14 w-auto">
            </div>
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                <div class="flex gap-4 text-gray-900 text-xl">
                    <a href="#" class="hover:text-[#BF654B] gap-4 mr-5" ><i class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content with margin top to avoid header overlap -->
    <main class="pt-32 pb-16 w-[70%] mx-auto">
        <!-- Stepper -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-[#CBAF87] flex items-center justify-center text-white font-bold">1</div>
                <span class="mt-2 text-sm">Keranjang</span>
            </div>
            <div class="flex-1 h-px bg-gray-300 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center text-gray-500 font-bold">2</div>
                <span class="mt-2 text-sm">Pengiriman</span>
            </div>
            <div class="flex-1 h-px bg-gray-300 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center text-gray-500 font-bold">3</div>
                <span class="mt-2 text-sm">Pembayaran</span>
            </div>
            <div class="flex-1 h-px bg-gray-300 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center text-gray-500 font-bold">4</div>
                <span class="mt-2 text-sm">Konfirmasi</span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Side - Cart Items -->
            <div class="lg:w-2/3">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Keranjang Belanja</h2>
                        <span class="text-gray-600">3 Barang</span>
                    </div>

                    <!-- Cart Item 1 -->
                    <div class="border rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-medium">Modern Sofa</h3>
                                        <p class="text-sm text-gray-600">Warna: Hijau tua</p>
                                    </div>
                                    <div class="flex items-center">
                                        <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">-</button>
                                        <span class="mx-2">1</span>
                                        <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">+</button>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <span class="font-medium">Rp 200.000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Item 2 -->
                    <div class="border rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-medium">Modern Sofa</h3>
                                        <p class="text-sm text-gray-600">Warna: Hijau tua</p>
                                    </div>
                                    <div class="flex items-center">
                                        <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">-</button>
                                        <span class="mx-2">1</span>
                                        <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">+</button>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <span class="font-medium">Rp 200.000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Item 3 -->
                    <div class="border rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <img src="img/produk.png" alt="Modern Sofa" class="w-24 h-16 object-cover rounded">
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-medium">Modern Sofa</h3>
                                        <p class="text-sm text-gray-600">Warna: Hijau tua</p>
                                    </div>
                                    <div class="flex items-center">
                                        <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">-</button>
                                        <span class="mx-2">1</span>
                                        <button class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">+</button>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <span class="font-medium">Rp 200.000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-4">
                        <button class="border border-[#BF654B] text-[#BF654B] py-2 px-4 rounded-lg hover:bg-gray-50">
                            + Tambahkan Produk Lainnya
                        </button>
                        <button class="border border-[#BF654B] text-[#BF654B] py-2 px-4 rounded-lg hover:bg-gray-50">
                            Simpan ke Wishlist
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right Side - Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal:</span>
                            <span class="font-medium">Rp 600.000</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Diskon:</span>
                            <span class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Ongkos Kirim:</span>
                            <span class="font-medium">Rp 0</span>
                        </div>
                    </div>
                    <div class="flex justify-between mb-6">
                        <span class="font-bold">Total:</span>
                        <span class="font-bold">Rp 600.000</span>
                    </div>
                    
                    <!-- Promo Code -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Promo</label>
                        <div class="flex">
                            <input type="text" placeholder="Masukkan kode promo" class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-[#BF654B]">
                            <button class="bg-[#BF654B] text-white px-4 py-2 rounded-r-lg hover:bg-orange-900">Pakai</button>
                        </div>
                    </div>
                    
                    <button class="w-full bg-[#BF654B] text-white py-3 rounded-lg hover:bg-orange-900 mb-2">
                        Checkout
                    </button>
                    <button class="w-full text-[#BF654B] py-2 rounded-lg hover:bg-gray-50">
                        Lanjut Belanja
                    </button>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-6">Rekomendasi untuk Anda</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Product 1 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-medium mb-2">Modern Sofa</h3>
                        <p class="text-[#BF654B] font-bold mb-3">Rp 200.000</p>
                        <button class="w-full bg-[#BF654B] text-white py-2 rounded-lg hover:bg-orange-900">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-medium mb-2">Modern Sofa</h3>
                        <p class="text-[#BF654B] font-bold mb-3">Rp 200.000</p>
                        <button class="w-full bg-[#BF654B] text-white py-2 rounded-lg hover:bg-orange-900">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-medium mb-2">Modern Sofa</h3>
                        <p class="text-[#BF654B] font-bold mb-3">Rp 200.000</p>
                        <button class="w-full bg-[#BF654B] text-white py-2 rounded-lg hover:bg-orange-900">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
                <!-- Product 4 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <img src="img/produk.png" alt="Modern Sofa" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-medium mb-2">Modern Sofa</h3>
                        <p class="text-[#BF654B] font-bold mb-3">Rp 200.000</p>
                        <button class="w-full bg-[#BF654B] text-white py-2 rounded-lg hover:bg-orange-900">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-8 border-t">
        <div class="w-[70%] mx-auto">
            
             
            <div class="pt-6 border-t text-center">
                <p class="text-gray-600">2025 Mebelin all right reserved</p>
            </div>
        </div>
    </footer>
</body>
</html>