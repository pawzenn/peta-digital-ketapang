<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Bencana extends Model
{
    protected $fillable = [
        'nama', 'slug', 'jenis_bencana', 'tingkat_risiko', 'deskripsi', 'cover_foto', 'alamat', 'maps_link'
    ];

    public function galleries(): MorphMany
    {
        return $this->morphMany(Gallery::class, 'imageable')->orderBy('sort_order');
    }

    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis_bencana) {
            'banjir' => 'Banjir',
            'banjir_bandang' => 'Banjir Bandang',
            'tanah_longsor' => 'Tanah Longsor',
            'cuaca_ekstrem' => 'Cuaca Ekstrem',
            'gelombang_ekstrem_abrasi' => 'Gelombang Ekstrem & Abrasi',
            'gempa_bumi' => 'Gempa Bumi',
            'kegagalan_teknologi' => 'Kegagalan Teknologi',
            'likuifaksi' => 'Likuifaksi',
            'kebakaran' => 'Kebakaran',
            'angin_puting_beliung' => 'Angin Puting Beliung',
            default => 'Lainnya',
        };
    }
}
