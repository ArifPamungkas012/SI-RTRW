<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\DataWarga\WargaController;
use App\Http\Controllers\DataWarga\KartuKeluargaController;
use App\Http\Controllers\DataWarga\AnggotaKKController;

use App\Http\Controllers\Kegiatan\KegiatanController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Account / User Profile Dropdown
    |--------------------------------------------------------------------------
    */
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
        Route::get('/me-json', [AccountController::class, 'meJson'])->name('me.json');
    });

    /*
    |--------------------------------------------------------------------------
    | Data Warga Module
    |--------------------------------------------------------------------------
    */
    Route::prefix('datawarga')->name('datawarga.')->group(function () {

        // ------------------ WARGA ------------------
        Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
        Route::get('/warga/json', [WargaController::class, 'indexJson'])->name('warga.index.json');

        Route::get('/warga/create', [WargaController::class, 'create'])->name('warga.create');
        Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');

        Route::get('/warga/{warga}', [WargaController::class, 'show'])->name('warga.show');
        Route::get('/warga/{warga}/edit', [WargaController::class, 'edit'])->name('warga.edit');
        Route::put('/warga/{warga}', [WargaController::class, 'update'])->name('warga.update');
        Route::delete('/warga/{warga}', [WargaController::class, 'destroy'])->name('warga.destroy');

        Route::post('/warga/{id}/restore', [WargaController::class, 'restore'])->name('warga.restore');


        // ------------------ KARTU KELUARGA ------------------
        Route::get('/kk', [KartuKeluargaController::class, 'index'])->name('kk.index');
        Route::get('/kk/create', [KartuKeluargaController::class, 'create'])->name('kk.create');
        Route::post('/kk', [KartuKeluargaController::class, 'store'])->name('kk.store');

        Route::get('/kk/{kk}', [KartuKeluargaController::class, 'show'])->name('kk.show');
        Route::get('/kk/{kk}/edit', [KartuKeluargaController::class, 'edit'])->name('kk.edit');
        Route::put('/kk/{kk}', [KartuKeluargaController::class, 'update'])->name('kk.update');
        Route::delete('/kk/{kk}', [KartuKeluargaController::class, 'destroy'])->name('kk.destroy');


        // ------------------ ANGGOTA KK ------------------
        Route::post('/kk/{kk}/anggota', [AnggotaKKController::class, 'store'])->name('kk.anggota.store');
        Route::delete('/kk/{kk}/anggota/{anggota}', [AnggotaKKController::class, 'destroy'])->name('kk.anggota.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KEGIATAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', [KegiatanController::class, 'index'])->name('index');
        Route::post('/', [KegiatanController::class, 'store'])->name('store');
        Route::put('/{id}', [KegiatanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KegiatanController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [KegiatanController::class, 'restore'])->name('restore');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
