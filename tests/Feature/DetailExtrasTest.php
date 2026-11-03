<?php

use App\Models\Homestay;
use App\Models\KategoriUmkm;
use App\Models\Penghargaan;
use App\Models\Umkm;
use App\Models\User;
use App\Models\VideoReview;
use App\Models\Wisata;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

const TIKTOK_A = 'https://www.tiktok.com/@akun/video/7497920605774155013';
const TIKTOK_B = 'https://www.tiktok.com/@akun/video/7441864055150775608';

function buatItem(string $jenis, array $override = []): object
{
    $base = [
        'nama' => 'Tempat Contoh',
        'slug' => 'tempat-contoh',
        'deskripsi' => 'Deskripsi tempat contoh.',
    ];

    return match ($jenis) {
        'wisata' => Wisata::create($base + $override),
        'homestay' => Homestay::create($base + $override),
        'umkm' => Umkm::create($base + $override + [
            'kategori_umkm_id' => KategoriUmkm::firstOrCreate(['slug' => 'kuliner'], ['nama' => 'Kuliner'])->id,
        ]),
    };
}

function payloadItem(object $item, array $extra = []): array
{
    return array_merge([
        'nama' => $item->nama,
        'deskripsi' => $item->deskripsi,
        'kategori_umkm_id' => $item->kategori_umkm_id ?? null,
    ], $extra);
}

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->create());
});

it('menyimpan link video rute, video review, dan penghargaan sesuai urutan', function (string $jenis) {
    $item = buatItem($jenis);

    $this->put(route("admin.$jenis.update", $item), payloadItem($item, [
        'video_rute_link' => TIKTOK_A,
        'video_reviews' => [
            ['url' => TIKTOK_A, 'caption' => 'Video pertama'],
            ['url' => TIKTOK_B, 'caption' => null],
        ],
        'penghargaan' => [
            ['nama' => 'Juara 1', 'tahun' => '2025', 'pemberi' => 'Dinas Pariwisata'],
            ['nama' => 'Favorit Pengunjung', 'tahun' => '', 'pemberi' => ''],
        ],
    ]))->assertSessionHasNoErrors();

    $item->refresh();

    expect($item->video_rute_link)->toBe(TIKTOK_A);
    expect($item->videoReviews->pluck('url')->all())->toBe([TIKTOK_A, TIKTOK_B]);
    expect($item->videoReviews->pluck('sort_order')->all())->toBe([0, 1]);
    expect($item->penghargaans->pluck('nama')->all())->toBe(['Juara 1', 'Favorit Pengunjung']);
    expect($item->penghargaans->first()->tahun)->toBe('2025');
    expect($item->penghargaans->last()->tahun)->toBeNull();
})->with(['wisata', 'homestay', 'umkm']);

it('mengganti daftar lama saat update dan mengosongkannya bila kosong', function (string $jenis) {
    $item = buatItem($jenis, ['video_rute_link' => TIKTOK_A]);
    $item->videoReviews()->create(['url' => TIKTOK_A, 'sort_order' => 0]);
    $item->penghargaans()->create(['nama' => 'Lama', 'sort_order' => 0]);

    $this->put(route("admin.$jenis.update", $item), payloadItem($item, [
        'video_reviews' => [['url' => TIKTOK_B]],
        'penghargaan' => [['nama' => 'Baru']],
    ]))->assertSessionHasNoErrors();

    $item->refresh();
    expect($item->videoReviews->pluck('url')->all())->toBe([TIKTOK_B]);
    expect($item->penghargaans->pluck('nama')->all())->toBe(['Baru']);
    expect($item->video_rute_link)->toBeNull();

    $this->put(route("admin.$jenis.update", $item), payloadItem($item))->assertSessionHasNoErrors();

    expect(VideoReview::count())->toBe(0);
    expect(Penghargaan::count())->toBe(0);
})->with(['wisata', 'homestay', 'umkm']);

it('menolak link bukan url, video tanpa url, penghargaan tanpa nama, dan tahun bukan 4 digit', function (string $jenis) {
    $item = buatItem($jenis);

    $this->put(route("admin.$jenis.update", $item), payloadItem($item, [
        'video_rute_link' => 'bukan-url',
        'video_reviews' => [['url' => '', 'caption' => 'tanpa url']],
        'penghargaan' => [['nama' => '', 'tahun' => '20a5']],
    ]))->assertSessionHasErrors([
        'video_rute_link',
        'video_reviews.0.url',
        'penghargaan.0.nama',
        'penghargaan.0.tahun',
    ]);

    expect(VideoReview::count())->toBe(0);
    expect(Penghargaan::count())->toBe(0);
})->with(['wisata', 'homestay', 'umkm']);

it('menampilkan badge penghargaan, video review, dan tombol rute video di halaman publik', function (string $jenis) {
    $item = buatItem($jenis, ['video_rute_link' => TIKTOK_A, 'alamat' => 'Desa Ketapang']);
    $item->penghargaans()->create(['nama' => 'Juara 1 Lomba', 'tahun' => '2025', 'pemberi' => 'Dinas Pariwisata', 'sort_order' => 0]);
    $item->videoReviews()->create(['url' => TIKTOK_B, 'caption' => 'Review seru', 'sort_order' => 0]);

    $this->get("/$jenis/{$item->slug}")
        ->assertOk()
        ->assertSee('Penghargaan')
        ->assertSee('Juara 1 Lomba')
        ->assertSee('Dinas Pariwisata · 2025', false)
        ->assertSee('Video Review')
        ->assertSee('Review seru')
        ->assertSee('https://www.tiktok.com/embed/v2/7441864055150775608', false)
        ->assertSee('Lihat Rute (Video)')
        ->assertSee('https://www.tiktok.com/embed/v2/7497920605774155013', false);
})->with(['wisata', 'homestay', 'umkm']);

it('menyembunyikan bagian video dan penghargaan di halaman publik bila kosong', function (string $jenis) {
    $item = buatItem($jenis);

    $this->get("/$jenis/{$item->slug}")
        ->assertOk()
        ->assertDontSee('Penghargaan')
        ->assertDontSee('Video Review')
        ->assertDontSee('Lihat Rute (Video)');
})->with(['wisata', 'homestay', 'umkm']);

it('menampilkan kartu tautan bila link TikTok tidak bisa dijadikan embed', function () {
    $item = buatItem('wisata');
    $item->videoReviews()->create(['url' => 'https://www.tiktok.com/@akun', 'caption' => 'Profil', 'sort_order' => 0]);

    $this->get("/wisata/{$item->slug}")
        ->assertOk()
        ->assertSee('Tonton di TikTok')
        ->assertDontSee('tiktok.com/embed/v2/');
});

it('menampilkan data video dan penghargaan yang sudah ada di form edit admin', function (string $jenis) {
    $item = buatItem($jenis, ['video_rute_link' => TIKTOK_A]);
    $item->videoReviews()->create(['url' => TIKTOK_B, 'caption' => 'Keterangan video', 'sort_order' => 0]);
    $item->penghargaans()->create(['nama' => 'Penghargaan Tersimpan', 'sort_order' => 0]);

    $this->get(route("admin.$jenis.edit", $item))
        ->assertOk()
        ->assertSee(TIKTOK_A, false)
        ->assertSee('Keterangan video')
        ->assertSee('Penghargaan Tersimpan');
})->with(['wisata', 'homestay', 'umkm']);

it('ikut menghapus video dan penghargaan saat data dihapus', function (string $jenis) {
    $item = buatItem($jenis);
    $item->videoReviews()->create(['url' => TIKTOK_A, 'sort_order' => 0]);
    $item->penghargaans()->create(['nama' => 'Juara', 'sort_order' => 0]);

    $this->delete(route("admin.$jenis.destroy", $item))->assertRedirect();

    expect(VideoReview::count())->toBe(0);
    expect(Penghargaan::count())->toBe(0);
})->with(['wisata', 'homestay', 'umkm']);

it('mengubah link TikTok penuh menjadi URL embed dan menolak link lain', function () {
    Http::fake(['*' => Http::response('', 500)]);

    expect(Wisata::tiktokEmbedUrl(TIKTOK_A))->toBe('https://www.tiktok.com/embed/v2/7497920605774155013');
    expect(Wisata::tiktokEmbedUrl('https://contoh.com/video/7497920605774155013'))->toBeNull();
    expect(Wisata::tiktokEmbedUrl(''))->toBeNull();
    expect(Wisata::tiktokEmbedUrl(null))->toBeNull();

    // Link penuh tidak perlu request HTTP; host selain tiktok.com ditolak tanpa request.
    Http::assertNothingSent();
});

it('tidak error dan menyimpan cache singkat bila link pendek TikTok gagal di-resolve', function () {
    Cache::flush();
    Http::fake(['*' => Http::response('', 500)]);

    $link = 'https://vt.tiktok.com/ZSabc123/';

    expect(Wisata::tiktokEmbedUrl($link))->toBeNull();
    expect(Wisata::tiktokEmbedUrl($link))->toBeNull();

    Http::assertSentCount(1);
});

it('UMKM punya bagian Rute dengan preview peta, seperti wisata dan homestay', function () {
    $umkm = buatItem('umkm', ['alamat' => 'Desa Ketapang, Kalipuro, Banyuwangi']);

    $this->get("/umkm/{$umkm->slug}")
        ->assertOk()
        ->assertSee('Rute')
        ->assertSee('google.com/maps?q=', false);
});

it('UMKM menyimpan dan menampilkan foto rute', function () {
    Storage::fake('public');
    $umkm = buatItem('umkm', ['alamat' => 'Desa Ketapang']);

    $this->put(route('admin.umkm.update', $umkm), payloadItem($umkm, [
        'foto_rute' => UploadedFile::fake()->image('rute.jpg', 800, 600),
    ]))->assertSessionHasNoErrors();

    $umkm->refresh();

    expect($umkm->foto_rute)->not->toBeNull();
    Storage::disk('public')->assertExists($umkm->foto_rute);

    $this->get("/umkm/{$umkm->slug}")
        ->assertOk()
        ->assertSee('storage/' . $umkm->foto_rute, false)
        ->assertDontSee('google.com/maps?q=', false);
});
