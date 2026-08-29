<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait HasMapsEmbed
{
    public function getMapsEmbedUrlAttribute(): ?string
    {
        if ($this->maps_link) {
            $coords = static::resolveMapsCoords($this->maps_link);

            if ($coords) {
                return "https://www.google.com/maps?q={$coords['lat']},{$coords['lng']}&z=17&output=embed";
            }
        }

        $query = trim((string) ($this->alamat ?: $this->nama));

        if ($query === '') {
            return null;
        }

        return 'https://www.google.com/maps?q=' . urlencode($query) . '&output=embed';
    }

    /**
     * Cari koordinat lat/lng dari sebuah link Google Maps.
     * Menangani link penuh (mengandung @lat,lng) maupun link pendek (maps.app.goo.gl)
     * dengan mengikuti redirect-nya terlebih dahulu.
     */
    protected static function resolveMapsCoords(string $link): ?array
    {
        return Cache::remember('maps_coords_' . md5($link), now()->addDays(30), function () use ($link) {
            $resolved = $link;

            if (str_contains($link, 'goo.gl')) {
                try {
                    $resolved = (string) Http::timeout(4)->get($link)->effectiveUri();
                } catch (\Throwable $e) {
                    $resolved = $link;
                }
            }

            $patterns = [
                '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
                '/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/',
                '/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/',
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $resolved, $m)) {
                    return ['lat' => $m[1], 'lng' => $m[2]];
                }
            }

            return null;
        });
    }
}
