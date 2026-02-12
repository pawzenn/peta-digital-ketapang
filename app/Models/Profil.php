<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'peta_wilayah'
    ];
}
