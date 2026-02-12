<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Gallery extends Model
{
    protected $fillable = [
        'file_path', 'caption', 'sort_order'
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
