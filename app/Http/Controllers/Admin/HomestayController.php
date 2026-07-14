<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHomestayRequest;
use App\Http\Requests\Admin\UpdateHomestayRequest;
use App\Models\Homestay;
use App\Services\ImageService;
use Illuminate\Support\Str;

class HomestayController extends Controller
{
    public function index()
    {
        $homestays = Homestay::latest()->paginate(10);

        return view('admin.homestay.index', compact('homestays'));
    }

    public function create()
    {
        return view('admin.homestay.create');
    }

    public function store(StoreHomestayRequest $request, ImageService $imageService)
    {
        $data = $request->validated();

        $slugBase = Str::slug($data['nama']);
        $slug = $this->uniqueSlug($slugBase);

        // simpan record dulu
        $homestay = Homestay::create([
            'nama' => $data['nama'],
            'slug' => $slug,
            'deskripsi' => $data['deskripsi'],
            'rating' => $data['rating'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'maps_link' => $data['maps_link'] ?? null,
            'cover_foto' => null,
        ]);

        // simpan cover
        $coverPath = $imageService->saveCroppedJpg(
            $request->file('cover'),
            'homestay/cover'
        );

        $homestay->update(['cover_foto' => $coverPath]);

        if ($request->hasFile('foto_rute')) {
            $rutePath = $imageService->saveCroppedJpg(
                $request->file('foto_rute'),
                'homestay/rute'
            );

            $homestay->update(['foto_rute' => $rutePath]);
        }

        // simpan gallery
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'homestay/gallery');

                $homestay->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.homestay.index')
            ->with('success', 'Homestay berhasil ditambahkan.');
    }

    public function edit(Homestay $homestay)
    {
        $homestay->load('galleries');

        return view('admin.homestay.edit', compact('homestay'));
    }

    public function update(UpdateHomestayRequest $request, Homestay $homestay, ImageService $imageService)
    {
        $data = $request->validated();

        // update slug jika nama berubah
        if (!empty($data['nama']) && $data['nama'] !== $homestay->nama) {
            $slugBase = Str::slug($data['nama']);
            $homestay->slug = $this->uniqueSlug($slugBase, $homestay->id);
        }

        $homestay->nama = $data['nama'];
        $homestay->deskripsi = $data['deskripsi'];
        $homestay->rating = $data['rating'] ?? null;
        $homestay->alamat = $data['alamat'] ?? null;
        $homestay->maps_link = $data['maps_link'] ?? null;

        // ganti cover kalau ada upload baru
        if ($request->hasFile('cover')) {
            $imageService->deleteIfExists($homestay->cover_foto);

            $newCoverPath = $imageService->saveCroppedJpg(
                $request->file('cover'),
                'homestay/cover'
            );

            $homestay->cover_foto = $newCoverPath;
        }

        if ($request->hasFile('foto_rute')) {
            $imageService->deleteIfExists($homestay->foto_rute);

            $homestay->foto_rute = $imageService->saveCroppedJpg(
                $request->file('foto_rute'),
                'homestay/rute'
            );
        }

        $homestay->save();

        // tambah gallery baru (tidak hapus yang lama)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'homestay/gallery');

                $homestay->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.homestay.edit', $homestay)
            ->with('success', 'Homestay berhasil diupdate.');
    }

    public function destroy(Homestay $homestay, ImageService $imageService)
    {
        // hapus cover
        $imageService->deleteIfExists($homestay->cover_foto);
        $imageService->deleteIfExists($homestay->foto_rute);

        // hapus semua gallery files + records
        $homestay->load('galleries');
        foreach ($homestay->galleries as $foto) {
            $imageService->deleteIfExists($foto->file_path);
        }
        $homestay->galleries()->delete();

        $homestay->delete();

        return redirect()
            ->route('admin.homestay.index')
            ->with('success', 'Homestay berhasil dihapus.');
    }

    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i = 2;

        $query = Homestay::query()->where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $base . '-' . $i;
            $i++;

            $query = Homestay::query()->where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
