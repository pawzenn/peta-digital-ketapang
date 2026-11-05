<?php

namespace App\Models;

use App\Models\Concerns\HasMapsEmbed;
use App\Models\Concerns\HasVideoEmbed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Umkm extends Model
{
    use HasMapsEmbed, HasVideoEmbed;

    protected $fillable = [
        'kategori_umkm_id',
        'nama', 'slug', 'deskripsi', 'rating', 'cover_foto', 'alamat', 'maps_link', 'video_rute_link', 'foto_rute'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriUmkm::class, 'kategori_umkm_id');
    }

    public function galleries(): MorphMany
    {
        return $this->morphMany(Gallery::class, 'imageable')->orderBy('sort_order');
    }

    public function videoReviews(): MorphMany
    {
        return $this->morphMany(VideoReview::class, 'videoable')->orderBy('sort_order');
    }

    public function penghargaans(): MorphMany
    {
        return $this->morphMany(Penghargaan::class, 'penghargaanable')->orderBy('sort_order');
    }
}
