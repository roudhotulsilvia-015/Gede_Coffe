<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;

// 1. Halaman utama diarahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// 2. Route untuk Proses Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 3. Route khusus untuk user yang sudah Login
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('home'); 
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

    // Admin: akses semua fitur
    Route::middleware('role:admin')->group(function () {
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('produk', ProdukController::class);
    });

    // Kasir dan Admin: akses kasir dan riwayat transaksi
    Route::middleware('role:admin|kasir')->group(function () {
        Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
        Route::get('/riwayat-transaksi', [TransaksiController::class, 'index'])->name('transaksi.riwayat');
        Route::get('/transaksi/export/pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.export.pdf');
        Route::get('/transaksi/export/excel', [TransaksiController::class, 'exportExcel'])->name('transaksi.export.excel');
    });
});