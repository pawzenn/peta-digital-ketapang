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
            'deskripsi_singkat' => ['nullable','string','max:500'],
            'peta_wilayah' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'alamat' => ['nullable','string','max:255'],
            'email' => ['nullable','email','max:150'],
            'whatsapp' => ['nullable','string','max:20'],
            'instagram' => ['nullable','url','max:255'],
            'instagram_nama' => ['nullable','string','max:100'],
            'facebook' => ['nullable','url','max:255'],
            'facebook_nama' => ['nullable','string','max:100'],
            'tiktok' => ['nullable','url','max:255'],
            'tiktok_nama' => ['nullable','string','max:100'],
            'youtube' => ['nullable','url','max:255'],
            'youtube_nama' => ['nullable','string','max:100'],
            'kepala_desa_foto' => ['nullable','image','mimes:jpg,jpeg,png','max:10240'],
            'kepala_desa_nama' => ['nullable','string','max:150'],
            'kepala_desa_jabatan' => ['nullable','string','max:100'],
            'visi' => ['nullable','string'],
            'misi' => ['nullable','string'],
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
        $profil->deskripsi_singkat = $data['deskripsi_singkat'] ?? null;
        $profil->alamat = $data['alamat'] ?? null;
        $profil->email = $data['email'] ?? null;
        $profil->whatsapp = $data['whatsapp'] ?? null;
        $profil->instagram = $data['instagram'] ?? null;
        $profil->instagram_nama = $data['instagram_nama'] ?? null;
        $profil->facebook = $data['facebook'] ?? null;
        $profil->facebook_nama = $data['facebook_nama'] ?? null;
        $profil->tiktok = $data['tiktok'] ?? null;
        $profil->tiktok_nama = $data['tiktok_nama'] ?? null;
        $profil->youtube = $data['youtube'] ?? null;
        $profil->youtube_nama = $data['youtube_nama'] ?? null;
        $profil->kepala_desa_nama = $data['kepala_desa_nama'] ?? null;
        $profil->kepala_desa_jabatan = $data['kepala_desa_jabatan'] ?? null;
        $profil->visi = $data['visi'] ?? null;
        $profil->misi = $data['misi'] ?? null;

        if ($request->hasFile('peta_wilayah')) {

            $imageService->deleteIfExists($profil->peta_wilayah);

            $path = $imageService->savePng(
                $request->file('peta_wilayah'),
                'profil'
            );

            $profil->peta_wilayah = $path;
        }

        if ($request->hasFile('kepala_desa_foto')) {

            $imageService->deleteIfExists($profil->kepala_desa_foto);

            $path = $imageService->saveCroppedJpg(
                $request->file('kepala_desa_foto'),
                'profil/kepala-desa',
                800,
                800
            );

            $profil->kepala_desa_foto = $path;
        }

        $profil->save();

        return redirect()
            ->route('admin.profil.edit')
            ->with('success','Profil berhasil diupdate.');
    }
}
