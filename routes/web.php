<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\VerifikasiPenjualController;

/*
|--------------------------------------------------------------------------
| PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/katalog', [BarangController::class, 'katalog']);

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| AREA LOGIN (semua role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profil', [ProfileController::class, 'show']);
    Route::get('/profil/edit', [ProfileController::class, 'edit']);
    Route::put('/profil', [ProfileController::class, 'update']);

    // Favorit
    Route::get('/favorit', [FavoritController::class, 'index']);
    Route::post('/favorit/{barang}/toggle', [FavoritController::class, 'toggle']);

    // Follow
    Route::post('/follow/{user}/toggle', [FollowController::class, 'toggle']);

    // Chat
    Route::get('/chat', [ChatController::class, 'index']);
    Route::get('/chat/mulai/{barang}', [ChatController::class, 'mulai']);
    Route::get('/chat/{barang}/{lawan}', [ChatController::class, 'show']);
    Route::post('/chat/{barang}/{lawan}', [ChatController::class, 'store']);

    // Transaksi & Review
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::get('/transaksi/{transaksi}/review', [ReviewController::class, 'create']);
    Route::post('/transaksi/{transaksi}/review', [ReviewController::class, 'store']);

    // Daftar sebagai penjual
    Route::get('/penjual/daftar', [VerifikasiPenjualController::class, 'create']);
    Route::post('/penjual/daftar', [VerifikasiPenjualController::class, 'store']);

    // Edit toko sendiri (harus sebelum /toko/{id})
    Route::get('/toko/edit', [TokoController::class, 'edit']);
    Route::put('/toko/update', [TokoController::class, 'update']);
});

/*
|--------------------------------------------------------------------------
| PENJUAL (role: penjual) — kelola barang
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/create', [BarangController::class, 'create']);
    Route::post('/barang/store', [BarangController::class, 'store']);
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit']);
    Route::post('/barang/update/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->whereNumber('id');
});

/*
|--------------------------------------------------------------------------
| ADMIN (role: admin) — verifikasi penjual
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/verifikasi', [AdminController::class, 'verifikasi']);
    Route::get('/verifikasi/{id}/ktp', [AdminController::class, 'ktp']);
    Route::post('/verifikasi/{id}/approve', [AdminController::class, 'approve']);
    Route::post('/verifikasi/{id}/reject', [AdminController::class, 'reject']);
});

/*
|--------------------------------------------------------------------------
| PUBLIK (lanjutan) — detail toko & barang (numeric agar tak bentrok)
|--------------------------------------------------------------------------
*/
Route::get('/toko/{id}', [TokoController::class, 'show'])->whereNumber('id');
Route::get('/barang/{id}', [BarangController::class, 'show'])->whereNumber('id');
