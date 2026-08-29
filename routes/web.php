<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\BencanaController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\HomestayController;
use App\Http\Controllers\Public\UmkmController;
use App\Http\Controllers\Public\WisataController;


Route::redirect('/login', '/admin/login');

Route::get('/', [HomeController::class, 'home']);
Route::get('/profil', [HomeController::class, 'profil']);

Route::get('/wisata', [WisataController::class, 'index']);
Route::get('/wisata/{slug}', [WisataController::class, 'show']);

Route::get('/homestay', [HomestayController::class, 'index']);
Route::get('/homestay/{slug}', [HomestayController::class, 'show']);

Route::get('/umkm', [UmkmController::class, 'index']);
Route::get('/umkm/{slug}', [UmkmController::class, 'show']);

Route::get('/bencana', [BencanaController::class, 'index']);
Route::get('/bencana/{slug}', [BencanaController::class, 'show']);

require __DIR__ . '/auth.php';
