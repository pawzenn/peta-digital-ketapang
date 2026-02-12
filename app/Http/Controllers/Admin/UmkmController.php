<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUmkmRequest;
use App\Http\Requests\Admin\UpdateUmkmRequest;
use App\Models\KategoriUmkm;
use App\Models\Umkm;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    /**
     * Display list + FILTER kategori
     */
    public function index(Request $request)
    {
        $kategoris = KategoriUmkm::orderBy('nama')->get();

        $query = Umkm::with('kategori')->latest();

        // FILTER berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_umkm_id', $request->kategori);
        }

        $umkms = $query->paginate(10)->withQueryString();

        return view('admin.umkm.index', compact('umkms', 'kategoris'));
    }

    /**
     * Show form create
     */
    public function create()
    {
        $kategoris = KategoriUmkm::orderBy('nama')->get();

        return view('admin.umkm.create', compact('kategoris'));
    }

    /**
     * Store new UMKM
     */
    public function store(StoreUmkmRequest $request, ImageService $imageService)
    {
        $data = $request->validated();

        $slugBase = Str::slug($data['nama']);
        $slug = $this->uniqueSlug($slugBase);

        $umkm = Umkm::create([
            'kategori_umkm_id' => $data['kategori_umkm_id'],
            'nama' => $data['nama'],
            'slug' => $slug,
            'deskripsi' => $data['deskripsi'],
            'rating' => $data['rating'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'maps_link' => $data['maps_link'] ?? null,
            'cover_foto' => null,
        ]);

        // Simpan cover
        $coverPath = $imageService->saveCroppedJpg(
            $request->file('cover'),
            'umkm/cover'
        );

        $umkm->update(['cover_foto' => $coverPath]);

        // Simpan gallery
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'umkm/gallery');

                $umkm->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan.');
    }

    /**
     * Edit form
     */
    public function edit(Umkm $umkm)
    {
        $umkm->load('galleries');
        $kategoris = KategoriUmkm::orderBy('nama')->get();

        return view('admin.umkm.edit', compact('umkm', 'kategoris'));
    }

    /**
     * Update UMKM
     */
    public function update(UpdateUmkmRequest $request, Umkm $umkm, ImageService $imageService)
    {
        $data = $request->validated();

        // update slug jika nama berubah
        if ($data['nama'] !== $umkm->nama) {
            $slugBase = Str::slug($data['nama']);
            $umkm->slug = $this->uniqueSlug($slugBase, $umkm->id);
        }

        $umkm->kategori_umkm_id = $data['kategori_umkm_id'];
        $umkm->nama = $data['nama'];
        $umkm->deskripsi = $data['deskripsi'];
        $umkm->rating = $data['rating'] ?? null;
        $umkm->alamat = $data['alamat'] ?? null;
        $umkm->maps_link = $data['maps_link'] ?? null;

        // ganti cover jika ada
        if ($request->hasFile('cover')) {
            $imageService->deleteIfExists($umkm->cover_foto);

            $newCover = $imageService->saveCroppedJpg(
                $request->file('cover'),
                'umkm/cover'
            );

            $umkm->cover_foto = $newCover;
        }

        $umkm->save();

        // tambah gallery baru
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $imageService->saveCroppedJpg($img, 'umkm/gallery');

                $umkm->galleries()->create([
                    'file_path' => $path,
                    'caption' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.umkm.edit', $umkm)
            ->with('success', 'UMKM berhasil diupdate.');
    }

    /**
     * Delete UMKM
     */
    public function destroy(Umkm $umkm, ImageService $imageService)
    {
        // hapus cover
        $imageService->deleteIfExists($umkm->cover_foto);

        // hapus gallery
        $umkm->load('galleries');
        foreach ($umkm->galleries as $foto) {
            $imageService->deleteIfExists($foto->file_path);
        }

        $umkm->galleries()->delete();
        $umkm->delete();

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus.');
    }

    /**
     * Helper slug unique
     */
    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i = 2;

        $query = Umkm::query()->where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $base . '-' . $i;
            $i++;

            $query = Umkm::query()->where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
