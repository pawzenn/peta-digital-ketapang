<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\HomestayController;
use App\Http\Controllers\Admin\KategoriUmkmController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\BencanaController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // ✅ PROFIL DESA (single record)
        Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [ProfilController::class, 'update'])->name('profil.update');

        // ✅ CRUD
        Route::resource('wisata', WisataController::class)->names('wisata');
        Route::resource('homestay', HomestayController::class)->names('homestay');
        Route::resource('kategori-umkm', KategoriUmkmController::class)->names('kategori-umkm');
        Route::resource('umkm', UmkmController::class)->names('umkm');
        Route::resource('bencana', BencanaController::class)->names('bencana');
    });
});
