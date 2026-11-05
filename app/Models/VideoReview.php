<?php

namespace App\Models;

use App\Models\Concerns\HasVideoEmbed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VideoReview extends Model
{
    use HasVideoEmbed;

    protected $fillable = [
        'url', 'caption', 'sort_order'
    ];

    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return static::tiktokEmbedUrl($this->url);
    }
}
