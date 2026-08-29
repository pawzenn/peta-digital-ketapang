<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'deskripsi_singkat',
        'peta_wilayah',
        'peta_bencana',
        'alamat',
        'email',
        'whatsapp',
        'instagram',
        'instagram_nama',
        'facebook',
        'facebook_nama',
        'tiktok',
        'tiktok_nama',
        'youtube',
        'youtube_nama',
        'kepala_desa_foto',
        'kepala_desa_nama',
        'kepala_desa_jabatan',
        'visi',
        'misi',
    ];

    public function getMisiListAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->misi))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    public function getDeskripsiParagraphsAttribute(): array
    {
        return collect(preg_split('/(\r\n|\r|\n){2,}/', trim((string) $this->deskripsi)))
            ->map(fn ($p) => trim($p))
            ->filter()
            ->values()
            ->all();
    }
}
