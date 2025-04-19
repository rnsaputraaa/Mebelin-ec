<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mebelin - Pembayaran</title>
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
                <div class="w-12 h-12 rounded-full bg-[#CBAF87] flex items-center justify-center text-white font-bold">3</div>
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
            <!-- Left Side - Payment Methods -->
            <div class="lg:w-2/3">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h2 class="text-xl font-bold mb-6">Pilih Metode Pembayaran</h2>
                    
                    <!-- Payment Type Tabs -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button class="py-2 px-4 border border-gray-300 rounded-lg text-center bg-white hover:bg-gray-50 focus:outline-none">E-Wallet</button>
                        <button class="py-2 px-4 border border-gray-300 rounded-lg text-center bg-white hover:bg-gray-50 focus:outline-none font-medium">Bank</button>
                    </div>
                    
                    <!-- E-Wallet Options -->
                    <div class="mb-6">
                        <!-- GoPay -->
                        <label class="flex items-center p-3 border border-blue-500 rounded-lg mb-3 cursor-pointer">
                            <input type="radio" name="payment" class="mr-3" checked>
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="GoPay Logo" class="h-6">
                                <span class="ml-2">gopay</span>
                            </div>
                        </label>
                        
                        <!-- OVO -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg mb-3 cursor-pointer hover:border-gray-400">
                            <input type="radio" name="payment" class="mr-3">
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="OVO Logo" class="h-6">
                                <span class="ml-2">ovo</span>
                            </div>
                        </label>
                        
                        <!-- DANA -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg mb-3 cursor-pointer hover:border-gray-400">
                            <input type="radio" name="payment" class="mr-3">
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="DANA Logo" class="h-6">
                                <span class="ml-2">DANA</span>
                            </div>
                        </label>
                        
                        <!-- LinkAja -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg mb-6 cursor-pointer hover:border-gray-400">
                            <input type="radio" name="payment" class="mr-3">
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="LinkAja Logo" class="h-6">
                                <span class="ml-2">LinkAja</span>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Payment Type Tabs - Second Section -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button class="py-2 px-4 border border-gray-300 rounded-lg text-center bg-white hover:bg-gray-50 focus:outline-none font-medium">E-Wallet</button>
                        <button class="py-2 px-4 border border-gray-300 rounded-lg text-center bg-white hover:bg-gray-50 focus:outline-none">Bank</button>
                    </div>
                    
                    <!-- Bank Options -->
                    <div>
                        <!-- BCA -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg mb-3 cursor-pointer hover:border-gray-400">
                            <input type="radio" name="payment" class="mr-3">
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="BCA Logo" class="h-6">
                                <span class="ml-2">BCA</span>
                            </div>
                        </label>
                        
                        <!-- BRI -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg mb-3 cursor-pointer hover:border-gray-400">
                            <input type="radio" name="payment" class="mr-3">
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="BRI Logo" class="h-6">
                                <span class="ml-2">BRI</span>
                            </div>
                        </label>
                        
                        <!-- Mandiri -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg mb-3 cursor-pointer hover:border-gray-400">
                            <input type="radio" name="payment" class="mr-3">
                            <div class="flex items-center">
                                <img src="/api/placeholder/70/25" alt="Mandiri Logo" class="h-6">
                                <span class="ml-2">mandiri</span>
                            </div>
                        </label>
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
                        <div class="border-t my-2"></div>
                        <div class="flex justify-between mt-2">
                            <span>Total:</span>
                            <span class="font-medium">Rp 600.000</span>
                        </div>
                    </div>
                    
                    <!-- Items in Cart -->
                    <div class="border rounded-lg p-4 mb-6">
                        <h3 class="font-medium mb-2">Barang 1</h3>
                        <h3 class="font-medium mb-2">Barang 2</h3>
                        <h3 class="font-medium mb-2">Barang 3</h3>
                        <h3 class="font-medium">Barang 4</h3>
                    </div>
                    
                    <button class="w-full bg-[#BF654B] text-white py-3 rounded-lg hover:bg-orange-900 mb-2">
                        Konfirmasi
                    </button>
                    <button class="w-full text-[#BF654B] py-2 rounded-lg hover:bg-gray-50 border border-[#BF654B]">
                        Kembali
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