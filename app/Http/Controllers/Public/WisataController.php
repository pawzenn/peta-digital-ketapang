<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Wisata;

class WisataController extends Controller
{
    public function index()
    {
        $wisatas = Wisata::latest()->paginate(9);

        return view('public.wisata.index', compact('wisatas'));
    }

    public function show(string $slug)
    {
        $wisata = Wisata::where('slug', $slug)
            ->with('galleries')
            ->firstOrFail();

        return view('public.wisata.show', compact('wisata'));
    }
}
