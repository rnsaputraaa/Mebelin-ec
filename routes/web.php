<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.home');
});

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
