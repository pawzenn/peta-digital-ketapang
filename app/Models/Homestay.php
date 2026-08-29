<?php

namespace App\Models;

use App\Models\Concerns\HasMapsEmbed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Homestay extends Model
{
    use HasMapsEmbed;

    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'rating', 'cover_foto', 'alamat', 'maps_link', 'foto_rute'
    ];

    public function galleries(): MorphMany
    {
        return $this->morphMany(Gallery::class, 'imageable')->orderBy('sort_order');
    }
}
