<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Sinkronisasi video review dan penghargaan untuk model yang punya relasi
 * videoReviews() dan penghargaans() (Wisata, Homestay, Umkm).
 */
trait SyncsDetailExtras
{
    /**
     * Ganti seluruh video review dan penghargaan dengan daftar baru dari form.
     * Urutan baris di form disimpan sebagai sort_order.
     */
    private function syncDetailExtras(Model $model, array $videos, array $awards): void
    {
        DB::transaction(function () use ($model, $videos, $awards) {
            $model->videoReviews()->delete();
            $model->penghargaans()->delete();

            foreach (array_values($videos) as $i => $row) {
                $model->videoReviews()->create([
                    'url' => $row['url'],
                    'caption' => $row['caption'] ?? null,
                    'sort_order' => $i,
                ]);
            }

            foreach (array_values($awards) as $i => $row) {
                $model->penghargaans()->create([
                    'nama' => $row['nama'],
                    'tahun' => $row['tahun'] ?? null,
                    'pemberi' => $row['pemberi'] ?? null,
                    'sort_order' => $i,
                ]);
            }
        });
    }

    private function deleteDetailExtras(Model $model): void
    {
        $model->videoReviews()->delete();
        $model->penghargaans()->delete();
    }
}
