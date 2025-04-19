<<<<<<< HEAD
<div>
<h1>ini adalah produk </h1>    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
=======
@extends('layouts.home')

@section('content')
<div class="container mx-auto p-4 pt-10 mt-20">
    <div class="flex flex-col md:flex-row gap-4">
        <div id="filter-menu" class="hidden md:block md:w-60 lg:w-72 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 mb-4">
                <h2 class="font-bold mb-2">Kategori</h2>
                <ul class="space-y-2">
                    <li class="py-1">Ruang Tamu</li>
                    <li class="py-1">Ruang Keluarga</li>
                    <li class="py-1">Kamar Tidur</li>
                    <li class="py-1">Ruang Makan</li>
                    <li class="py-1">Dapur</li>
                    <li class="py-1">Kamar Mandi</li>
                    <li class="py-1">Kantor / Ruang Kerja</li>
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 mb-4">
                <h2 class="font-bold mb-2">Gaya Desain</h2>
                <ul class="space-y-2">
                    <li class="py-1">Minimalis</li>
                    <li class="py-1">Klasik</li>
                    <li class="py-1">Modern</li>
                    <li class="py-1">Industrial</li>
                    <li class="py-1">Scandinavian</li>
                    <li class="py-1">Vintage/Rustic</li>
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4">
                <h2 class="font-bold mb-2">Bahan</h2>
                <ul class="space-y-2">
                    <li class="py-1">Kayu Solid</li>
                    <li class="py-1">Kayu Olahan (MDF, HPL, dll)</li>
                    <li class="py-1">Logam / Besi</li>
                    <li class="py-1">Kaca</li>
                    <li class="py-1">Plastik</li>
                    <li class="py-1">Rotan/ Anyaman</li>
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 mt-4">
                <h2 class="font-bold mb-2">Harga</h2>
                <form class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="harga" class="form-radio text-[#BF654B]">
                        <span>Rp 0 - Rp 500.000</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="harga" class="form-radio text-[#BF654B]">
                        <span>Rp 500.000 - Rp 1.000.000</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="harga" class="form-radio text-[#BF654B]">
                        <span>Rp 1.000.000 - Rp 1.500.000</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="harga" class="form-radio text-[#BF654B]">
                        <span>Rp 1.500.000 - Rp 2.000.000</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="harga" class="form-radio text-[#BF654B]">
                        <span>Rp 2.000.000 - Rp 2.500.000</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="harga" class="form-radio text-[#BF654B]">
                        <span>Rp 2.500.000 - Rp 3.000.000</span>
                    </label>
                </form>
            </div>
        </div>

        <div class="flex-1">
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4">

                <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-2 md:p-4">
                        <img src="" alt="Modern Sofa" class="w-full h-auto object-cover rounded">
                        <h3 class="text-center font-medium mt-2 text-sm md:text-base">Modern Sofa</h3>
                        <p class="text-center mt-1 text-sm md:text-base">Rp 200.000</p>
                        <button class="w-full bg-[#BF654B] text-white hover:bg-orange-900 py-1 md:py-2 rounded-full mt-2 text-xs md:text-sm">Add to Cart</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
>>>>>>> origin/rama_produk
</div>
@endsection