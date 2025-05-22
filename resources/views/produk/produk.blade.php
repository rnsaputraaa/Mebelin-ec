@extends('layouts.home')

@section('content')
<div class="container mx-auto p-4 pt-24 mt-0 md:pt-28">
    <button id="filter-toggle" class="w-full mb-4 bg-[#BF654B] text-white py-2 rounded-md flex items-center justify-center md:hidden">
        <span>Show Filters</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
        </svg>
    </button>

    <div class="flex flex-col md:flex-row gap-4">
        <div id="filter-menu" class="hidden md:block md:w-60 lg:w-72 flex-shrink-0">
            <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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

            <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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

            <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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

            <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4">

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                    <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                        Add to Cart
                    </button>
                </div>

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                    <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                        Add to Cart
                    </button>
                </div>

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                    <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                        Add to Cart
                    </button>
                </div>

                <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                    <div class="bg-gray-100 rounded-md p-6 flex justify-center items-center">
                        <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                    </div>
                    <h3 class="font-medium mb-2">Modern Sofa</h3>
                    <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                    <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterToggle = document.getElementById('filter-toggle');
        const filterMenu = document.getElementById('filter-menu');
        
        filterToggle.addEventListener('click', function() {
            filterMenu.classList.toggle('hidden');
            
            if (filterMenu.classList.contains('hidden')) {
                filterToggle.innerHTML = '<span>Show Filters</span> <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>';
            } else {
                filterToggle.innerHTML = '<span>Hide Filters</span> <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>';
            }
        });
    });
</script>
@endsection