<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Umkm extends Model
{
    protected $fillable = [
        'kategori_umkm_id',
        'nama', 'slug', 'deskripsi', 'rating', 'cover_foto', 'alamat', 'maps_link'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriUmkm::class, 'kategori_umkm_id');
    }

    public function galleries(): MorphMany
    {
        return $this->morphMany(Gallery::class, 'imageable')->orderBy('sort_order');
    }
}
