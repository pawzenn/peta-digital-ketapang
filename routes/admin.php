<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\HomestayController;
use App\Http\Controllers\Admin\KategoriUmkmController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\BencanaController;
use App\Models\Bencana;
use App\Models\Homestay;
use App\Models\KategoriUmkm;
use App\Models\Umkm;
use App\Models\Wisata;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', function () {
            $counts = [
                'wisata' => Wisata::count(),
                'homestay' => Homestay::count(),
                'umkm' => Umkm::count(),
                'kategori_umkm' => KategoriUmkm::count(),
                'bencana' => Bencana::count(),
            ];

            $recentWisata = Wisata::latest()->take(5)->get();
            $recentHomestay = Homestay::latest()->take(5)->get();
            $recentUmkm = Umkm::with('kategori')->latest()->take(5)->get();

            return view('admin.dashboard', compact('counts', 'recentWisata', 'recentHomestay', 'recentUmkm'));
        })->name('dashboard');

        // ✅ PROFIL DESA (single record)
        Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [ProfilController::class, 'update'])->name('profil.update');

        // ✅ CRUD
        Route::resource('wisata', WisataController::class)->names('wisata');
        Route::resource('homestay', HomestayController::class)->names('homestay');
        Route::resource('kategori-umkm', KategoriUmkmController::class)->names('kategori-umkm');
        Route::resource('umkm', UmkmController::class)->names('umkm');

        Route::put('bencana-peta-wilayah', [BencanaController::class, 'updatePetaBencana'])->name('bencana.peta-bencana.update');
        Route::resource('bencana', BencanaController::class)->names('bencana');
    });
});
