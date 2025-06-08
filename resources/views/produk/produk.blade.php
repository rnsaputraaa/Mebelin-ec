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
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Ruang Tamu
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Ruang Keluarga
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Kamar Tidur
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Ruang Makan
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Dapur
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Kamar Mandi
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Kantor / Ruang Kerja
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                <h2 class="font-bold mb-2">Gaya Desain</h2>
                <ul class="space-y-2">
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Minimalis
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Klasik
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Modern
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Industrial
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Scandinavian
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Vintage/Rustic
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-lg p-6 mb-4 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                <h2 class="font-bold mb-2">Bahan</h2>
                <ul class="space-y-2">
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Kayu Solid
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Kayu Olahan (MDF, HPL, dll)
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Logam / Besi
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Kaca
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Plastik
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="" class="filter-link block text-gray-700 hover:text-[#BF654B]">
                            Rotan/ Anyaman
                        </a>
                    </li>
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
                    <p class="font-bold text-gray-900 mb-2">Rp 200.000</p>
                    <div class="flex items-center mb-4">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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

            <div class="flex justify-end mt-8">
                <nav class="flex items-center space-x-1">
                    <a href="#" class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="px-3 py-2 bg-[#BF654B] text-white rounded-md">1</a>
                    <a href="#" class="px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md">2</a>
                    <a href="#" class="px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md">3</a>
                    <a href="#" class="px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md">4</a>
                    <a href="#" class="px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md">5</a>
                    <a href="#" class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
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