<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriUmkmController extends Controller
{
    public function index()
    {
        $kategoris = KategoriUmkm::latest()->paginate(10);
        return view('admin.kategori-umkm.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-umkm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:120'],
        ]);

        KategoriUmkm::create([
            'nama' => $data['nama'],
            'slug' => Str::slug($data['nama']),
        ]);

        return redirect()->route('admin.kategori-umkm.index')
            ->with('success','Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriUmkm $kategori_umkm)
    {
        return view('admin.kategori-umkm.edit', [
            'kategori' => $kategori_umkm
        ]);
    }

    public function update(Request $request, KategoriUmkm $kategori_umkm)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:120'],
        ]);

        $kategori_umkm->update([
            'nama' => $data['nama'],
            'slug' => Str::slug($data['nama']),
        ]);

        return redirect()->route('admin.kategori-umkm.index')
            ->with('success','Kategori berhasil diupdate.');
    }

    public function destroy(KategoriUmkm $kategori_umkm)
    {
        $kategori_umkm->delete();

        return redirect()->route('admin.kategori-umkm.index')
            ->with('success','Kategori berhasil dihapus.');
    }
}
