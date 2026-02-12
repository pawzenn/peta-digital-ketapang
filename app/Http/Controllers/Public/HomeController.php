<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use App\Models\Wisata;

class HomeController extends Controller
{
    public function home()
{
    $profil = \App\Models\Profil::first();

    // TOP WISATA
    $wisataTop = \App\Models\Wisata::query()
        ->orderByRaw('rating IS NULL')
        ->orderByDesc('rating')
        ->orderByDesc('created_at')
        ->take(3)
        ->get();

    // TOP HOMESTAY
    $homestayTop = \App\Models\Homestay::query()
        ->orderByRaw('rating IS NULL')
        ->orderByDesc('rating')
        ->orderByDesc('created_at')
        ->take(3)
        ->get();

    return view('public.home', compact(
        'profil',
        'wisataTop',
        'homestayTop'
    ));
}


    public function profil()
    {
        $profil = Profil::first();

        return view('public.profil', compact('profil'));
    }
}
