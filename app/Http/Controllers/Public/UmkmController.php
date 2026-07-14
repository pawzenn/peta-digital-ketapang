<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KategoriUmkm;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = KategoriUmkm::orderBy('nama')->get();

        $query = Umkm::with('kategori')->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori_umkm_id', $request->kategori);
        }

        $umkms = $query->paginate(9)->withQueryString();

        return view('public.umkm.index', compact('umkms', 'kategoris'));
    }

    public function show(string $slug)
    {
        $umkm = Umkm::where('slug', $slug)
            ->with(['kategori', 'galleries'])
            ->firstOrFail();

        return view('public.umkm.show', compact('umkm'));
    }
}
