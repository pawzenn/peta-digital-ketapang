<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Penghargaan extends Model
{
    protected $fillable = [
        'nama', 'tahun', 'pemberi', 'sort_order'
    ];

    public function penghargaanable(): MorphTo
    {
        return $this->morphTo();
    }
}
