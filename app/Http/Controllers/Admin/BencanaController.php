<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBencanaRequest;
use App\Http\Requests\Admin\UpdateBencanaRequest;
use App\Models\Bencana;
use App\Models\Profil;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BencanaController extends Controller
{
    public function index()
    {
        $bencanas = Bencana::latest()->paginate(10);
        $profil = Profil::first();

        return view('admin.bencana.index', compact('bencanas', 'profil'));
    }

    public function updatePetaBencana(Request $request, ImageService $imageService)
    {
        $request->validate([
            'peta_bencana' => ['required', 'image', 'mimes:jpg,jpeg', 'max:2048'],
        ]);

        $profil = Profil::first() ?? Profil::create(['nama' => '', 'deskripsi' => '']);

        $imageService->deleteIfExists($profil->peta_bencana);

        $profil->peta_bencana = $imageService->saveCroppedJpg(
            $request->file('peta_bencana'),
            'profil'
        );

        $profil->save();

        return redirect()
            ->route('admin.bencana.index')
            ->with('success', 'Peta bencana berhasil diupdate.');
    }

    public function create()
    {
        return view('admin.bencana.create');
    }

    public function store(StoreBencanaRequest $request, ImageService $imageService)
    {
        $data = $request->validated();

        $slugBase = Str::slug($data['nama']);
        $slug = $this->uniqueSlug($slugBase);

        $bencana = Bencana::create([
            'nama' => $data['nama'],
            'slug' => $slug,
            'jenis_bencana' => $data['jenis_bencana'],
            'tingkat_risiko' => $data['tingkat_risiko'],
            'deskripsi' => $data['deskripsi'],
            'alamat' => $data['alamat'] ?? null,
            'maps_link' => $data['maps_link'] ?? null,
            'cover_foto' => null,
        ]);

        $coverPath = $imageService->saveCroppedJpg(
            $request->file('cover'),
            'bencana/cover'
        );

        $bencana->update(['cover_foto' => $coverPath]);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'bencana/gallery');

                $bencana->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.bencana.index')
            ->with('success', 'Data bencana berhasil ditambahkan.');
    }

    public function edit(Bencana $bencana)
    {
        $bencana->load('galleries');

        return view('admin.bencana.edit', compact('bencana'));
    }

    public function update(UpdateBencanaRequest $request, Bencana $bencana, ImageService $imageService)
    {
        $data = $request->validated();

        if ($data['nama'] !== $bencana->nama) {
            $slugBase = Str::slug($data['nama']);
            $bencana->slug = $this->uniqueSlug($slugBase, $bencana->id);
        }

        $bencana->nama = $data['nama'];
        $bencana->jenis_bencana = $data['jenis_bencana'];
        $bencana->tingkat_risiko = $data['tingkat_risiko'];
        $bencana->deskripsi = $data['deskripsi'];
        $bencana->alamat = $data['alamat'] ?? null;
        $bencana->maps_link = $data['maps_link'] ?? null;

        if ($request->hasFile('cover')) {
            $imageService->deleteIfExists($bencana->cover_foto);

            $newCover = $imageService->saveCroppedJpg(
                $request->file('cover'),
                'bencana/cover'
            );

            $bencana->cover_foto = $newCover;
        }

        $bencana->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'bencana/gallery');

                $bencana->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.bencana.edit', $bencana)
            ->with('success', 'Data bencana berhasil diupdate.');
    }

    public function destroy(Bencana $bencana, ImageService $imageService)
    {
        $imageService->deleteIfExists($bencana->cover_foto);

        $bencana->load('galleries');
        foreach ($bencana->galleries as $foto) {
            $imageService->deleteIfExists($foto->file_path);
        }
        $bencana->galleries()->delete();

        $bencana->delete();

        return redirect()
            ->route('admin.bencana.index')
            ->with('success', 'Data bencana berhasil dihapus.');
    }

    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i = 2;

        $query = Bencana::query()->where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $base . '-' . $i;
            $i++;

            $query = Bencana::query()->where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
