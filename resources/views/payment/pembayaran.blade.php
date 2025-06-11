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
                        <h2 class="text-xl font-medium mb-6">Pilih Metode Pembayaran</h2>

                        <div class="flex mb-4 bg-gray-100 rounded-lg p-1 shadow-md"
                            style="box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);">
                            <button onclick="showPaymentType('ewallet')" id="ewallet-tab"
                                class="flex-1 py-2 px-4 text-sm font-medium rounded-md bg-white text-gray-900">
                                E-Wallet
                            </button>
                            <button onclick="showPaymentType('bank')" id="bank-tab"
                                class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                                Bank
                            </button>
                        </div>

                        <div id="ewallet-options" class="space-y-3">
                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('gopay')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="gopay" class="mr-3 text-cyan-500">
                                    <img src="img/gopay.png" alt="GoPay" class="mr-3 h-4">
                                    <span class="font-medium">GoPay</span>
                                </div>
                            </div>

                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('ovo')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="ovo" class="mr-3 text-purple-500">
                                    <img src="img/ovo.png" alt="OVO" class="mr-3 h-6">
                                    <span class="font-medium">OVO</span>
                                </div>
                            </div>

                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('dana')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="dana" class="mr-3 text-blue-500">
                                    <img src="img/dana.png" alt="DANA" class="mr-3 h-3">
                                    <span class="font-medium">DANA</span>
                                </div>
                            </div>

                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('linkaja')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="linkaja" class="mr-3 text-red-500">
                                    <img src="img/link.png" alt="LinkAja" class="mr-3 h-5">
                                    <span class="font-medium">LinkAja</span>
                                </div>
                            </div>
                        </div>

                        <div id="bank-options" class="space-y-3 hidden">
                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('bca')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="bca" class="mr-3 text-blue-500">
                                    <img src="img/bca.png" alt="BCA" class="mr-3 h-3">
                                    <span class="font-medium">BCA</span>
                                </div>
                            </div>

                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('bri')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="bri" class="mr-3 text-blue-500">
                                    <img src="img/bri.png" alt="BRI" class="mr-3 h-5">
                                    <span class="font-medium">BRI</span>
                                </div>
                            </div>

                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('mandiri')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="mandiri"
                                        class="mr-3 text-yellow-500">
                                    <img src="img/mandiri.png" alt="Mandiri" class="mr-3 h-10">
                                    <span class="font-medium">Mandiri</span>
                                </div>
                            </div>

                            <div class="payment-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                                onclick="selectPayment('bni')">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="bni"
                                        class="mr-3 text-orange-500">
                                    <img src="img/bni.png" alt="BNI" class="mr-3 h-3">
                                    <span class="font-medium">BNI</span>
                                </div>
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
                            <div class="flex flex-col space-y-4 rounded-lg p-6 border border-[#BF654B]">
                                <span>Barang 1</span>
                                <span>Barang 2</span>
                                <span>Barang 3</span>
                            </div>
                        </div>

                        <a href="{{ route('konfirmasi') }}"
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

    <script>
        function showPaymentType(type) {
            const ewalletTab = document.getElementById('ewallet-tab');
            const bankTab = document.getElementById('bank-tab');
            const ewalletOptions = document.getElementById('ewallet-options');
            const bankOptions = document.getElementById('bank-options');

            if (type === 'ewallet') {
                ewalletTab.className =
                    'flex-1 py-2 px-4 text-sm font-medium rounded-lg bg-white text-gray-900 shadow-sm';
                bankTab.className =
                    'flex-1 py-2 px-4 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900';
                ewalletOptions.classList.remove('hidden');
                bankOptions.classList.add('hidden');
            } else {
                bankTab.className =
                    'flex-1 py-2 px-4 text-sm font-medium rounded-lg bg-white text-gray-900 shadow-sm';
                ewalletTab.className =
                    'flex-1 py-2 px-4 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900';
                bankOptions.classList.remove('hidden');
                ewalletOptions.classList.add('hidden');
            }
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected', 'border-[#CBAF87]');
                option.classList.add('border-gray-200');
            });

            event.currentTarget.classList.add('selected', 'border-[#CBAF87]');
            event.currentTarget.classList.remove('border-gray-200');

            const radio = event.currentTarget.querySelector('input[type="radio"]');
            radio.checked = true;
        }
    </script>
@endsection
