<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWisataRequest;
use App\Http\Requests\Admin\UpdateWisataRequest;
use App\Models\Wisata;
use App\Services\ImageService;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    public function index()
    {
        $wisatas = Wisata::latest()->paginate(10);

        return view('admin.wisata.index', compact('wisatas'));
    }

    public function create()
    {
        return view('admin.wisata.create');
    }

    public function store(StoreWisataRequest $request, ImageService $imageService)
    {
        $data = $request->validated();

        $slugBase = Str::slug($data['nama']);
        $slug = $this->uniqueSlug($slugBase);

        $wisata = Wisata::create([
            'nama' => $data['nama'],
            'slug' => $slug,
            'deskripsi' => $data['deskripsi'],
            'rating' => $data['rating'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'maps_link' => $data['maps_link'] ?? null,
            'cover_foto' => null,
        ]);

        $coverPath = $imageService->saveCroppedJpg(
            $request->file('cover'),
            'wisata/cover'
        );

        $wisata->update(['cover_foto' => $coverPath]);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'wisata/gallery');

                $wisata->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.wisata.index')
            ->with('success', 'Wisata berhasil ditambahkan.');
    }

    /**
     * PENTING: karena route param kamu adalah {wisatum},
     * maka gunakan $wisatum agar route-model binding aman.
     */
    public function edit(Wisata $wisatum)
    {
        $wisatum->load('galleries');

        // view pakai variable $wisata (biar konsisten dengan blade kamu)
        $wisata = $wisatum;

        return view('admin.wisata.edit', compact('wisata'));
    }

    public function update(UpdateWisataRequest $request, Wisata $wisatum, ImageService $imageService)
    {
        $data = $request->validated();

        if (!empty($data['nama']) && $data['nama'] !== $wisatum->nama) {
            $slugBase = Str::slug($data['nama']);
            $wisatum->slug = $this->uniqueSlug($slugBase, $wisatum->id);
        }

        $wisatum->nama = $data['nama'];
        $wisatum->deskripsi = $data['deskripsi'];
        $wisatum->rating = $data['rating'] ?? null;
        $wisatum->alamat = $data['alamat'] ?? null;
        $wisatum->maps_link = $data['maps_link'] ?? null;

        if ($request->hasFile('cover')) {
            $imageService->deleteIfExists($wisatum->cover_foto);

            $newCoverPath = $imageService->saveCroppedJpg(
                $request->file('cover'),
                'wisata/cover'
            );

            $wisatum->cover_foto = $newCoverPath;
        }

        $wisatum->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'wisata/gallery');

                $wisatum->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.wisata.edit', $wisatum)
            ->with('success', 'Wisata berhasil diupdate.');
    }

    public function destroy(Wisata $wisatum, ImageService $imageService)
    {
        $imageService->deleteIfExists($wisatum->cover_foto);

        $wisatum->load('galleries');
        foreach ($wisatum->galleries as $foto) {
            $imageService->deleteIfExists($foto->file_path);
        }
        $wisatum->galleries()->delete();

        $wisatum->delete();

        return redirect()
            ->route('admin.wisata.index')
            ->with('success', 'Wisata berhasil dihapus.');
    }

    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i = 2;

        $query = Wisata::query()->where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $base . '-' . $i;
            $i++;

            $query = Wisata::query()->where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
