<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Homestay;

class HomestayController extends Controller
{
    public function index()
    {
        $homestays = Homestay::latest()->paginate(9);

        return view('public.homestay.index', compact('homestays'));
    }

    public function show(string $slug)
    {
        $homestay = Homestay::where('slug', $slug)
            ->with('galleries')
            ->firstOrFail();

        return view('public.homestay.show', compact('homestay'));
    }
}
