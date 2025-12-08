<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\DataWarga\WargaController;
use App\Http\Controllers\DataWarga\KartuKeluargaController;
use App\Http\Controllers\DataWarga\AnggotaKKController;
use App\Http\Controllers\DataWarga\MutasiWargaController;


use App\Http\Controllers\Kegiatan\KegiatanController;
use App\Http\Controllers\Kegiatan\RiwayatKegiatanController;


use App\Http\Controllers\Keuangan\IuranTemplateController;
use App\Http\Controllers\Keuangan\IuranInstanceController;
use App\Http\Controllers\Keuangan\KasController;
use App\Http\Controllers\Keuangan\PengeluaranController;
use App\Http\Controllers\Keuangan\KategoriKeuanganController;
use App\Http\Controllers\Keuangan\MetodePembayaranController;


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
        Route::get('/warga/{warga}/detail', [WargaController::class, 'detail'])
            ->name('warga.detail');



        // ------------------ MUTASI WARGA ------------------
        Route::get('/mutasi', [MutasiWargaController::class, 'index'])->name('mutasi.index');
        Route::get('/mutasi/create', [MutasiWargaController::class, 'create'])->name('mutasi.create');
        Route::post('/mutasi', [MutasiWargaController::class, 'store'])->name('mutasi.store');

        Route::delete('/mutasi/{mutasi}', [MutasiWargaController::class, 'destroy'])->name('mutasi.destroy');


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

        Route::get('/kk/{kk}/detail', [KartuKeluargaController::class, 'detail'])
            ->name('kk.detail');
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

        Route::get('/riwayat', [RiwayatKegiatanController::class, 'index'])->name('riwayat.index');
    });

    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        // KAS
        Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
        Route::post('/kas', [KasController::class, 'store'])->name('kas.store');
        Route::delete('/kas/{kas}', [KasController::class, 'destroy'])->name('kas.destroy');

        // PENGELUARAN
        Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
        Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
        Route::delete('/pengeluaran/{kas}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

        // MASTER KATEGORI KEUANGAN
        Route::get('/kategori-keuangan', [KategoriKeuanganController::class, 'index'])->name('kategori.index');
        Route::post('/kategori-keuangan', [KategoriKeuanganController::class, 'store'])->name('kategori.store');
        Route::put('/kategori-keuangan/{kategori}', [KategoriKeuanganController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori-keuangan/{kategori}', [KategoriKeuanganController::class, 'destroy'])->name('kategori.destroy');
        Route::post('/kategori-keuangan/{id}/restore', [KategoriKeuanganController::class, 'restore'])->name('kategori.restore');

        // MASTER METODE PEMBAYARAN
        Route::get('/metode-pembayaran', [MetodePembayaranController::class, 'index'])->name('metode.index');
        Route::post('/metode-pembayaran', [MetodePembayaranController::class, 'store'])->name('metode.store');
        Route::put('/metode-pembayaran/{metode}', [MetodePembayaranController::class, 'update'])->name('metode.update');
        Route::delete('/metode-pembayaran/{metode}', [MetodePembayaranController::class, 'destroy'])->name('metode.destroy');
        Route::post('/metode-pembayaran/{id}/restore', [MetodePembayaranController::class, 'restore'])->name('metode.restore');

        // ===== IURAN (di bawah /keuangan/iuran/...) =====
        Route::prefix('iuran')->name('iuran.')->group(function () {

            // IURAN TEMPLATE → /keuangan/iuran/template
            Route::prefix('template')->name('template.')->group(function () {
                Route::get('/', [IuranTemplateController::class, 'index'])->name('index');
                Route::post('/', [IuranTemplateController::class, 'store'])->name('store');
                Route::put('/{id}', [IuranTemplateController::class, 'update'])->name('update');
                Route::delete('/{id}', [IuranTemplateController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/restore', [IuranTemplateController::class, 'restore'])->name('restore');
            });

            // IURAN INSTANCE → /keuangan/iuran/instance
            Route::prefix('instance')->name('instance.')->group(function () {
                Route::get('/', [IuranInstanceController::class, 'index'])->name('index');
                Route::post('/', [IuranInstanceController::class, 'store'])->name('store');
                Route::put('/{id}', [IuranInstanceController::class, 'update'])->name('update');
                Route::delete('/{id}', [IuranInstanceController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/restore', [IuranInstanceController::class, 'restore'])->name('restore');
            });
        });
    });








    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
