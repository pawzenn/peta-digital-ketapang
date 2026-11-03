<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BencanaKejadian extends Model
{
    protected $fillable = [
        'judul', 'tanggal_kejadian', 'lokasi', 'uraian',
        'korban_meninggal', 'korban_luka', 'warga_mengungsi', 'rumah_rusak',
        'kerugian', 'sumber',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

    public function bencana(): BelongsTo
    {
        return $this->belongsTo(Bencana::class);
    }

    public function getDampakAttribute(): array
    {
        $angka = [
            'Meninggal' => [$this->korban_meninggal, 'jiwa'],
            'Luka-luka' => [$this->korban_luka, 'jiwa'],
            'Mengungsi' => [$this->warga_mengungsi, 'jiwa'],
            'Rumah rusak' => [$this->rumah_rusak, 'unit'],
        ];

        $dampak = [];

        foreach ($angka as $label => [$nilai, $satuan]) {
            if ($nilai !== null) {
                $dampak[$label] = number_format($nilai, 0, ',', '.') . ' ' . $satuan;
            }
        }

        if ($this->kerugian !== null && $this->kerugian !== '') {
            $dampak['Kerugian'] = $this->kerugian;
        }

        return $dampak;
    }
}
