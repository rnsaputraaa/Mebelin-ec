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
                        <h2 class="text-2xl font-medium mb-6">Data Pengiriman</h2>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBAF87] focus:border-[#CBAF87] bg-white">
                                <option value="" disabled selected hidden>Pilih Alamat</option>
                                <option value="">Alamat 1</option>
                                <option value="">Alamat 2</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBAF87] focus:border-[#CBAF87] h-20 resize-none"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (opsional)</label>
                            <textarea
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBAF87] focus:border-[#CBAF87] h-24 resize-none"></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pengiriman</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBAF87] focus:border-[#CBAF87] bg-white">
                                <option value="" disabled selected hidden>Pilih Metode Pengiriman</option>
                                <option value="mebelin">Mebelin Express</option>
                                <option value="jnt">JNT</option>
                            </select>
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

                        <a href="{{ route('pembayaran') }}"
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
@endsection
