<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/produk', function () {
    return view('produk.produk');
})->name('produk');

Route::get('/detail', function () {
    return view('produk.detail-produk');
})->name('detail-produk');

Route::get('/pesanan', function () {
    return view('payment.pemesanan');
})->name('pemesanan');

Route::get('/kirim', function () {
    return view('payment.pengiriman');
})->name('pengiriman');

Route::get('/bayar', function () {
    return view('payment.pembayaran');
})->name('pembayaran');

Route::get('/konfirmasi', function () {
    return view('payment.konfirmasi');
})->name('konfirmasi');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
