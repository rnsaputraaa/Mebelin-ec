<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mebelin - Pengiriman</title>
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
                <div class="w-12 h-12 rounded-full bg-[#CBAF87] flex items-center justify-center text-white font-bold">2</div>
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
            <!-- Left Side - Shipping Form -->
            <div class="lg:w-2/3">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h2 class="text-xl font-bold mb-4">Data Pengiriman</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                        <div class="relative">
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#BF654B] appearance-none">
                                <option selected>Pilih Alamat</option>
                                <option>Alamat Rumah</option>
                                <option>Alamat Kantor</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#BF654B]" placeholder="Masukkan alamat lengkap"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#BF654B]" placeholder="Tambahkan catatan untuk pengiriman">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pengiriman</label>
                        <div class="relative">
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#BF654B] appearance-none">
                                <option selected>JNE</option>
                                <option>J&T</option>
                                <option>SiCepat</option>
                                <option>Anteraja</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <div class="mb-6">
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
                    <div class="flex justify-between mb-6 border-t pt-4">
                        <span class="font-bold">Total:</span>
                        <span class="font-bold">Rp 600.000</span>
                    </div>
                    
                    <button class="w-full bg-[#BF654B] text-white py-3 rounded-lg hover:bg-orange-900 mb-2">
                        Checkout
                    </button>
                    <button class="w-full text-[#BF654B] py-2 rounded-lg hover:bg-gray-50 border border-[#BF654B]">
                        Lanjut Belanja
                    </button>
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