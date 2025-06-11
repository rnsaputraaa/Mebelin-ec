@extends('layouts.cart')

@section('content')
    <div class="pt-10 px-4">
        <div
            class="relative max-w-screen-xl mx-auto after:absolute after:inset-x-0 after:top-1/2 after:block after:h-0.5 after:-translate-y-1/2 after:rounded-lg after:bg-gray-400">
            <ol class="relative z-10 flex justify-between text-sm font-medium text-gray-900">
                <li class="flex items-center gap-2 bg-gray-100 p-2">
                    <span class="size-12 rounded-full bg-[#CBAF87] text-center text-[12px]/10 font-bold text-gray-900"> 1
                    </span>
                    <span class="hidden sm:block"> Keranjang </span>
                </li>

                <li class="flex items-center gap-2 bg-gray-100 p-2">
                    <span class="size-12 rounded-full bg-gray-200 text-center text-[12px]/10 font-bold text-gray-900"> 2
                    </span>
                    <span class="hidden sm:block"> Pengiriman </span>
                </li>

                <li class="flex items-center gap-2 bg-gray-100 p-2">
                    <span class="size-12 rounded-full bg-gray-200 text-center text-[12px]/10 font-bold text-gray-900"> 3
                    </span>
                    <span class="hidden sm:block"> Pembayaran </span>
                </li>

                <li class="flex items-center gap-2 bg-gray-100 p-2">
                    <span class="size-12 rounded-full bg-gray-200 text-center text-[12px]/10 font-bold text-gray-900"> 3
                    </span>
                    <span class="hidden sm:block"> Konfirmasi </span>
                </li>
            </ol>
        </div>
    </div>

    <div class="pt-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                        <h2 class="text-2xl font-medium mb-6">Keranjang Belanja</h2>
                        <div class="product border-b border-gray-400 pb-4 mb-4">
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="img/produk.png" alt="Modern Sofa" class="h-auto max-h-20 object-contain">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium">Modern Sofa</h3>
                                    <p class="text-sm text-gray-600">warna: Hijau Tua</p>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <button
                                        class="decrement w-8 h-8 border border-[#BF654B] rounded flex items-center justify-center">-</button>
                                    <span class="quantity px-3">1</span>
                                    <button
                                        class="increment w-8 h-8 border border-[#BF654B] rounded flex items-center justify-center">+</button>
                                </div>
                                <div class="text-right">
                                    <div class="price">Rp 300.000</div>
                                </div>
                            </div>
                        </div>

                        <div class="product border-b border-gray-400 pb-4 mb-4">
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="img/produk.png" alt="Modern Sofa" class="h-auto max-h-20 object-contain">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium">Modern Sofa</h3>
                                    <p class="text-sm text-gray-600">warna: Hijau Tua</p>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <button
                                        class="decrement w-8 h-8 border border-[#BF654B] rounded flex items-center justify-center">-</button>
                                    <span class="quantity px-3">1</span>
                                    <button
                                        class="increment w-8 h-8 border border-[#BF654B] rounded flex items-center justify-center">+</button>
                                </div>
                                <div class="text-right">
                                    <div class="price">Rp 300.000</div>
                                </div>
                            </div>
                        </div>

                        <div class="product border-b border-gray-400 pb-4 mb-4">
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="img/produk.png" alt="Modern Sofa" class="h-auto max-h-20 object-contain">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium">Modern Sofa</h3>
                                    <p class="text-sm text-gray-600">warna: Hijau Tua</p>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <button
                                        class="decrement w-8 h-8 border border-[#BF654B] rounded flex items-center justify-center">-</button>
                                    <span class="quantity px-3">1</span>
                                    <button
                                        class="increment w-8 h-8 border border-[#BF654B] rounded flex items-center justify-center">+</button>
                                </div>
                                <div class="text-right">
                                    <div class="price">Rp 300.000</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button
                                class="font-medium flex-1 py-2 px-4 border border-[#BF654B] rounded-lg text-gray-900 hover:bg-gray-100">
                                + Tambahkan Produk Lainnya
                            </button>
                            <button
                                class="font-medium flex-1 py-2 px-4 border border-[#BF654B] rounded-lg text-gray-900 hover:bg-gray-100">
                                Simpan ke Validasi
                            </button>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">

                        <div class="space-y-3 mb-4 rounded-lg p-6 border border-[#BF654B]">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>Rp 900.000</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Diskon:</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-900 pt-3">
                                <span>Total:</span>
                                <span>Rp 900.000</span>
                            </div>
                        </div>

                        <a href="{{ route('pengiriman') }}"
                            class="mb-3 block text-center w-full text-sm sm:text-base bg-[#BF654B] hover:bg-orange-900 text-white py-3 px-4 rounded-lg font-medium">
                            Checkout
                        </a>

                        <a href="{{ route('produk') }}"
                            class="block text-center w-full text-sm sm:text-base bg-white hover:bg-gray-100 text-[#BF654B] py-3 px-4 rounded-lg border border-[#BF654B] font-medium">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-medium mb-6">Rekomendasi untuk Anda</h2>
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
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
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
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
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
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
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
                        <a href="{{ route('detail-produk') }}"
                            class="w-full bg-[#BF654B] hover:bg-orange-900 text-white py-2 px-4 rounded-lg text-center block">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const products = document.querySelectorAll('.product');

            products.forEach(product => {
                const decrementBtn = product.querySelector('.decrement');
                const incrementBtn = product.querySelector('.increment');
                const quantitySpan = product.querySelector('.quantity');

                decrementBtn.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.textContent);
                    if (quantity > 1) {
                        quantity--;
                        quantitySpan.textContent = quantity;
                    }
                });

                incrementBtn.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.textContent);
                    quantity++;
                    quantitySpan.textContent = quantity;
                });
            });
        });
    </script>
@endsection
