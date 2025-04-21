@extends('layouts.home')

@section('content')
<section class="bg-white lg:h-screen lg:flex lg:items-center pt-8 mt-8">
    <div class="container mx-auto max-w-screen-xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="max-w-prose text-left">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-4xl">
                    Modern Furniture for Modern Living
                </h1>
            
                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
                    Discover out collection of handcrafted furniture pieces that blend style and comfort
                </p>
            
                <div class="mt-4 flex gap-4 sm:mt-6 pt-5">
                    <a class="inline-block rounded-full border border-[#BF654B] bg-[#BF654B] px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-orange-900" href="#">Shop Now</a>
                </div>
            </div>

            <div class="flex justify-center lg:justify-end">
                <img src="img/banner.png" alt="Modern Furniture" class="rounded-lg object-cover" />
            </div>
        </div>
    </div>
</section>

<section class="py-8 bg-white mb-8 mt-10 pt-10">
    <div class="container mx-auto px-6 lg:px-16 max-w-7xl mb-8">
        <div class="bg-white rounded-lg p-6 shadow md" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
            <h2 class="text-2xl font-bold mb-6 mt-6 text-gray-900">Shop by Category</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <a href="" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c1.png" alt="Living Room" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Living Room</span>
                </a>

                <a href="/category/bedroom" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c2.png" alt="Bedroom" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Bedroom</span>
                </a>

                <a href="/category/dining-room" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c3.png" alt="Dining Room" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Dining Room</span>
                </a>

                <a href="/category/kitchen" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c4.png" alt="Kitchen" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Kitchen</span>
                </a>

                <a href="/category/workspace" class="flex flex-col items-center cursor-pointer hover:opacity-80 transition-opacity">
                    <div class="rounded-lg overflow-hidden shadow-md mb-2 w-full h-24 md:h-32">
                        <img src="img/c5.png" alt="Workspace" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-medium">Workspace</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-6 lg:px-16 max-w-7xl mb-8">
        <h2 class="text-2xl font-bold mb-6 mt-8 text-gray-900">Featured Product</h2>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
                    <img src="img/produk.png" alt="Modern Sofa" class="h-36 object-contain">
                </div>
                <h3 class="font-medium mb-2">Modern Sofa</h3>
                <p class="font-bold text-gray-900 mb-4">Rp 200.000</p>
                <button class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-full">
                    Add to Cart
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden shadow-md p-4">
                <div class="bg-gray-100 rounded-md p-6 mb-4 flex justify-center items-center">
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
</section>
@endsection