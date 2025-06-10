<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ url('/') }}" class="mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex items-center gap-2">
                    <img src="img/logo.png" alt="Logo Mebelin" class="h-10 w-auto">
                    <span class="text-xl font-bold">x</span>
                    <img src="img/unira.png" alt="Logo Kolaborasi" class="h-10 w-auto">
                </div>
            </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-56">
                    <div class="p-6 text-gray-900 flex flex-col items-center">
                        <div class="w-24 h-24 bg-gray-200 rounded-full mb-2"></div>
                        <div class="font-medium">Mebelin User</div>
                        
                        <div class="w-full mt-4">
                            <a href="{{ route('profile.edit') }}" class="block bg-[#BF654B] text-center py-2 px-4 rounded text-white font-medium mb-2">
                                Profil Saya
                            </a>

                            <a href="#" class="block py-2 px-4 hover:bg-gray-100">
                                Pesanan Saya
                            </a>

                            <a href="#" class="block py-2 px-4 hover:bg-gray-100">
                                Favorit
                            </a>

                            <a href="#" class="block py-2 px-4 hover:bg-gray-100">
                                Alamat
                            </a>

                            <a href="#" class="block py-2 px-4 hover:bg-gray-100">
                                Ulasan Produk
                            </a>

                            <a href="#" class="block py-2 px-4 hover:bg-gray-100">
                                Pengaturan
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left py-2 px-4 hover:bg-gray-100 text-red-600">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-medium mb-4">Profil Saya</h3>
                        <hr class="mb-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" class="w-full border border-gray-300 rounded px-3 py-2">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="tel" class="w-full border border-gray-300 rounded px-3 py-2">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                <div class="relative">
                                    <input type="date" class="w-full border border-gray-300 rounded px-3 py-2">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jenis Kelamin</label>
                                <select class="w-full border border-gray-300 rounded px-3 py-2" name="jenis_kelamin" required>
                                    <option value="" disabled selected hidden>-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                                <button type="button" class="bg-white border border-gray-500 text-gray-700 py-2 px-6 rounded hover:bg-gray-100">
                                    Batal
                                </button>
                                <button type="button" class="bg-[#BF654B] text-white py-2 px-6 rounded hover:bg-orange-900">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>