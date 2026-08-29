<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bencana;

class BencanaController extends Controller
{
    public function index()
    {
        $first = Bencana::orderBy('nama')->first();

        if ($first) {
            return redirect('/bencana/' . $first->slug);
        }

        return view('public.bencana.show', [
            'bencana' => null,
            'bencanas' => collect(),
        ]);
    }

    public function show(string $slug)
    {
        $bencana = Bencana::where('slug', $slug)->firstOrFail();
        $bencanas = Bencana::orderBy('nama')->get();

        return view('public.bencana.show', compact('bencana', 'bencanas'));
    }
}
