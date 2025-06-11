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
                    <span class="size-12 rounded-full bg-[#CBAF87] text-center text-[12px]/10 font-bold text-gray-900"> 2
                    </span>
                    <span class="hidden sm:block"> Pengiriman </span>
                </li>

                <li class="flex items-center gap-2 bg-gray-100 p-2">
                    <span class="size-12 rounded-full bg-[#CBAF87] text-center text-[12px]/10 font-bold text-gray-900"> 3
                    </span>
                    <span class="hidden sm:block"> Pembayaran </span>
                </li>

                <li class="flex items-center gap-2 bg-gray-100 p-2">
                    <span class="size-12 rounded-full bg-[#CBAF87] text-center text-[12px]/10 font-bold text-gray-900"> 3
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
                        <h2 class="text-xl font-medium mb-6">Konfirmasi Pesanan</h2>
                        <div class="flex items-center rounded-lg p-6 border border-gray-500">
                            <div class="w-4 h-4 mr-3 rounded-full border border-gray-500"></div>
                            <span class="font-medium">GoPay</span>
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea
                                class="w-full px-3 py-2 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#CBAF87] focus:border-[#CBAF87] h-20 resize-none"></textarea>
                        </div>
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-medium mt-5">Ringkasan Barang</h2>
                    </div>
                    <div class="product bg-white rounded-lg shadow-md p-6 mt-5"
                        style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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
                    <div class="product bg-white rounded-lg shadow-md p-6 mt-5"
                        style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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
                    <div class="product bg-white rounded-lg shadow-md p-6 mt-5"
                        style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
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
                            <div class="flex justify-between">
                                <span>Ongkir:</span>
                                <span>Rp 200.000</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-900 pt-3">
                                <span>Total:</span>
                                <span>Rp 1.200.000</span>
                            </div>
                        </div>

                        <button onclick="showCheckoutAlert(event)"
                            class="mb-3 block text-center w-full text-sm sm:text-base bg-[#BF654B] hover:bg-orange-900 text-white py-3 px-4 rounded-lg font-medium">
                            Checkout
                        </button>

                        <a href="{{ route('produk') }}"
                            class="block text-center w-full text-sm sm:text-base bg-white hover:bg-gray-100 text-[#BF654B] py-3 px-4 rounded-lg border border-[#BF654B] font-medium">
                            Lanjut Belanja
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 mt-5" style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                        <h2 class="text-center">Batas waktu Pembayaran</h2>
                        <p id="countdown" class="text-center mt-5">00:10</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCheckoutAlert(e) {
            Swal.fire({
                title: 'Checkout Berhasil',
                text: 'Pesanan Anda sedang diproses',
                icon: 'success',
                confirmButtonText: 'OK',
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    confirmBtn.style.backgroundColor = '#BF654B';
                    confirmBtn.style.color = 'white';
                }
            }).then(() => {
                window.location.href = "/pesanan";
            });
        }

        let duration = 10;

        function startCountdown(seconds) {
            const countdownElement = document.getElementById('countdown');

            const interval = setInterval(() => {
                const minutes = String(Math.floor(seconds / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                countdownElement.textContent = `${minutes}:${secs}`;

                if (seconds <= 0) {
                    clearInterval(interval);
                    countdownElement.textContent = "Waktu Habis";
                    countdownElement.style.color = "red";
                }

                seconds--;
            }, 1000);
        }

        window.onload = () => {
            startCountdown(duration);
        };

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
