<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Wisata extends Model
{
    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'rating', 'cover_foto', 'alamat', 'maps_link'
    ];

    public function galleries(): MorphMany
    {
        return $this->morphMany(Gallery::class, 'imageable')->orderBy('sort_order');
    }
}
