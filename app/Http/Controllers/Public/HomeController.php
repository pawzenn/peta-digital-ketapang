<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bencana;
use App\Models\Homestay;
use App\Models\Profil;
use App\Models\Umkm;
use App\Models\Wisata;

class HomeController extends Controller
{
    public function home()
    {
        $profil = Profil::first();

        $wisataTop = Wisata::query()
            ->orderByRaw('rating IS NULL')
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $homestayTop = Homestay::query()
            ->orderByRaw('rating IS NULL')
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $umkmTop = Umkm::query()
            ->with('kategori')
            ->orderByRaw('rating IS NULL')
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $bencanas = Bencana::orderBy('nama')->get();

        return view('public.home', compact(
            'profil',
            'wisataTop',
            'homestayTop',
            'umkmTop',
            'bencanas'
        ));
    }

    public function profil()
    {
        $profil = Profil::first();

        return view('public.profil', compact('profil'));
    }
}
