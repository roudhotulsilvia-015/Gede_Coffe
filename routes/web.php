<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TransaksiController;
use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\Transaksi;

// 1. Halaman utama diarahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// 2. Route untuk Proses Login dan Register
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

// 3. Route khusus untuk user yang sudah Login
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        $user = Auth::user();

        $stats = [
            'total_karyawan' => $user->role === 'admin' ? Karyawan::count() : null,
            'total_produk' => $user->role === 'admin' ? Produk::count() : null,
            'total_transaksi' => $user->role === 'admin'
                ? Transaksi::count()
                : Transaksi::where('user_id', $user->id)->count(),
        ];

        return view('home', compact('user', 'stats'));
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

    // Admin: akses semua fitur
    Route::middleware('role:admin')->group(function () {
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('users', App\Http\Controllers\UserController::class);
        // Sesi aktif: dihapus — fitur manajemen sesi dihapus
    });

    // Kasir dan Admin: akses kasir dan riwayat transaksi
    Route::middleware('role:admin|kasir')->group(function () {
        Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
        Route::get('/riwayat-transaksi', [TransaksiController::class, 'index'])->name('transaksi.riwayat');
        Route::get('/laporan-transaksi', [TransaksiController::class, 'report'])->name('transaksi.report');
        Route::get('/transaksi/export/pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.export.pdf');
        Route::get('/transaksi/export/excel', [TransaksiController::class, 'exportExcel'])->name('transaksi.export.excel');
        Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show')->whereNumber('id');
    });

    // Hanya Admin: edit dan hapus transaksi
    Route::middleware('role:admin')->group(function () {
        Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit')->whereNumber('id');
        Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update')->whereNumber('id');
        Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy')->whereNumber('id');
    });
});