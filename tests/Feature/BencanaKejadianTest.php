<?php

use App\Models\Bencana;
use App\Models\BencanaKejadian;
use App\Models\User;

function buatBencana(array $override = []): Bencana
{
    return Bencana::create(array_merge([
        'nama' => 'Peta Bahaya Banjir',
        'slug' => 'peta-bahaya-banjir',
        'jenis_bencana' => 'banjir',
        'tingkat_risiko' => 'sedang',
        'deskripsi' => 'Wilayah rawan genangan air.',
    ], $override));
}

function payloadBencana(array $kejadian = []): array
{
    return [
        'nama' => 'Peta Bahaya Banjir',
        'jenis_bencana' => 'banjir',
        'tingkat_risiko' => 'sedang',
        'deskripsi' => 'Wilayah rawan genangan air.',
        'kejadian' => $kejadian,
    ];
}

function kejadianRow(array $override = []): array
{
    return array_merge([
        'judul' => 'Banjir Dusun Krajan',
        'tanggal_kejadian' => '2025-01-10',
    ], $override);
}

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->create());
});

it('menyimpan kejadian lewat update dan mengurutkan terbaru dulu', function () {
    $bencana = buatBencana();

    $this->put(route('admin.bencana.update', $bencana), payloadBencana([
        kejadianRow(['judul' => 'Kejadian lama', 'tanggal_kejadian' => '2022-03-01']),
        kejadianRow(['judul' => 'Kejadian baru', 'tanggal_kejadian' => '2025-02-15', 'korban_meninggal' => 0]),
    ]))->assertSessionHasNoErrors();

    $judul = $bencana->fresh()->kejadians->pluck('judul')->all();

    expect($judul)->toBe(['Kejadian baru', 'Kejadian lama']);
    expect($bencana->kejadians()->first()->korban_meninggal)->toBe(0);
});

it('mengganti daftar lama saat update dan mengosongkannya bila daftar kosong', function () {
    $bencana = buatBencana();
    $bencana->kejadians()->create(kejadianRow(['judul' => 'Kejadian lama']));

    $this->put(route('admin.bencana.update', $bencana), payloadBencana([
        kejadianRow(['judul' => 'Kejadian pengganti']),
    ]))->assertSessionHasNoErrors();

    expect($bencana->fresh()->kejadians->pluck('judul')->all())->toBe(['Kejadian pengganti']);

    $this->put(route('admin.bencana.update', $bencana), payloadBencana([]))
        ->assertSessionHasNoErrors();

    expect(BencanaKejadian::count())->toBe(0);
});

it('menolak judul kosong, tanggal masa depan, dan angka negatif', function () {
    $bencana = buatBencana();

    $this->put(route('admin.bencana.update', $bencana), payloadBencana([
        kejadianRow([
            'judul' => '',
            'tanggal_kejadian' => now()->addDay()->toDateString(),
            'korban_luka' => -1,
        ]),
    ]))->assertSessionHasErrors([
        'kejadian.0.judul',
        'kejadian.0.tanggal_kejadian',
        'kejadian.0.korban_luka',
    ]);

    expect(BencanaKejadian::count())->toBe(0);
});

it('menampilkan riwayat kejadian di halaman publik', function () {
    $bencana = buatBencana();
    $bencana->kejadians()->create(kejadianRow([
        'judul' => 'Banjir Dusun Krajan',
        'tanggal_kejadian' => '2025-01-10',
        'lokasi' => 'Dusun Krajan',
        'uraian' => 'Air naik setinggi lutut.',
        'warga_mengungsi' => 40,
        'rumah_rusak' => 12,
        'sumber' => 'BPBD Banyuwangi',
    ]));

    $this->get('/bencana/' . $bencana->slug)
        ->assertOk()
        ->assertSee('Riwayat Kejadian')
        ->assertSee('Banjir Dusun Krajan')
        ->assertSee('10 Januari 2025')
        ->assertSee('Air naik setinggi lutut.')
        ->assertSee('Mengungsi: 40 jiwa')
        ->assertSee('Rumah rusak: 12 unit')
        ->assertSee('Sumber: BPBD Banyuwangi');
});

it('menyembunyikan riwayat kejadian di halaman publik bila kosong', function () {
    $bencana = buatBencana();

    $this->get('/bencana/' . $bencana->slug)
        ->assertOk()
        ->assertDontSee('Riwayat Kejadian');
});

it('menampilkan kejadian yang sudah ada di form edit admin', function () {
    $bencana = buatBencana();
    $bencana->kejadians()->create(kejadianRow(['judul' => 'Banjir Dusun Krajan']));

    $this->get(route('admin.bencana.edit', $bencana))
        ->assertOk()
        ->assertSee('Riwayat Kejadian')
        ->assertSee('Banjir Dusun Krajan');
});

it('ikut menghapus kejadian saat bencana dihapus', function () {
    $bencana = buatBencana();
    $bencana->kejadians()->create(kejadianRow());

    $this->delete(route('admin.bencana.destroy', $bencana))->assertRedirect();

    expect(Bencana::count())->toBe(0);
    expect(BencanaKejadian::count())->toBe(0);
});

it('menghitung dampak: angka 0 tetap tampil, null disembunyikan', function () {
    $bencana = buatBencana();
    $kejadian = $bencana->kejadians()->create(kejadianRow([
        'korban_meninggal' => 0,
        'korban_luka' => 2,
        'warga_mengungsi' => 1500,
        'kerugian' => 'Rp 50 juta',
    ]));

    expect($kejadian->dampak)->toBe([
        'Meninggal' => '0 jiwa',
        'Luka-luka' => '2 jiwa',
        'Mengungsi' => '1.500 jiwa',
        'Kerugian' => 'Rp 50 juta',
    ]);
});
