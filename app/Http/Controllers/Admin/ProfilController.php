<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        // ambil profil pertama
        $profil = Profil::first();

        // kalau belum ada, buat default kosong
        if (!$profil) {
            $profil = Profil::create([
                'nama' => '',
                'deskripsi' => '',
                'peta_wilayah' => null,
            ]);
        }

        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request, ImageService $imageService)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:150'],
            'deskripsi' => ['nullable','string'],
            'peta_wilayah' => ['nullable','image','mimes:jpg,jpeg','max:2048'],
        ]);

        $profil = Profil::first();

        if (!$profil) {
            $profil = Profil::create([
                'nama' => '',
                'deskripsi' => '',
                'peta_wilayah' => null,
            ]);
        }

        $profil->nama = $data['nama'];
        $profil->deskripsi = $data['deskripsi'] ?? null;

        if ($request->hasFile('peta_wilayah')) {

            $imageService->deleteIfExists($profil->peta_wilayah);

            $path = $imageService->saveCroppedJpg(
                $request->file('peta_wilayah'),
                'profil'
            );

            $profil->peta_wilayah = $path;
        }

        $profil->save();

        return redirect()
            ->route('admin.profil.edit')
            ->with('success','Profil berhasil diupdate.');
    }
}
