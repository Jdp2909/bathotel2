<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KamarController;



    //   ngecek  login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // pencarian kamar
Route::get('/kamar/search', [KamarController::class, 'search'])->name('kamar.search');

// user wajib login
Route::middleware('auth')->group(function () {
    
    // Dashboard user
    Route::get('/dashboard', function () {
        return view('bat-hotel.index');
    })->name('dashboard');

    // Booking: Halaman konfirmasi
    Route::get('/pembayaran', [TransaksiController::class, 'create'])->name('pembayaran');
    // Booking: Proses booking
    Route::post('/pembayaran', [TransaksiController::class, 'store'])->name('pembayaran.store');

    // Halaman upload bukti pembayaran
    Route::get('/transaksi/{id}/pembayaran', [TransaksiController::class, 'showPembayaran'])
          ->name('transaksi.pembayaran');

    // Proses upload bukti pembayaran
    Route::post('/transaksi/{id}/upload_bukti', [TransaksiController::class, 'uploadBukti'])
           ->name('transaksi.upload_bukti');

    // Halaman Riwayat Transaksi User
    Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('user.riwayat');
});

// admin ngecek role sekalian
Route::middleware(['auth', 'isAdmin'])->group(function () {
    
    // Dashboard admin (lihat semua transaksi)
    Route::get('/admin', [TransaksiController::class, 'index'])->name('admin.dashboard');

    /* ---- Kamar ---- */
    Route::prefix('admin/kamar')->name('admin.kamar.')->group(function () {
        Route::get('/', [KamarController::class, 'index'])->name('index');
        Route::get('/create', [KamarController::class, 'create'])->name('create');
        Route::post('/', [KamarController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KamarController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KamarController::class, 'update'])->name('update');
        Route::delete('/{id}', [KamarController::class, 'destroy'])->name('destroy');
    });

    /* ---- Transaksi ---- */
    Route::prefix('admin/transaksi')->name('admin.transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::put('/{id}', [TransaksiController::class, 'update'])->name('update');
    });
});

// tambahan
Route::get('/home', function () {
    return redirect()->route('dashboard'); 
})->name('home');
