<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;


Route::get('/', function () {
    return view('landing');
});
Route::get('produk/detail', function () {
    return view('produk.detail');
});

Route::get('/produk', [ProdukController::class, 'index']);


Route::get('/pemesanan', function () {
    return view('payment.pemesanan');
});

Route::get('/pengiriman', function () {
    return view('payment.pengiriman');
});

Route::get('/pembayaran', function () {
    return view('payment.pembayaran');
});
Route::get('/konfirmasi', function () {
    return view('payment.konfirmasi');
});

Route::get('/home', function () {
    return view('layouts.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
