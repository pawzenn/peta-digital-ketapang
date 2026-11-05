<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait HasVideoEmbed
{
    /**
     * URL embed untuk video rute (kolom video_rute_link), null bila link kosong atau tidak bisa dibaca.
     */
    public function getVideoRuteEmbedUrlAttribute(): ?string
    {
        return $this->video_rute_link ? static::tiktokEmbedUrl($this->video_rute_link) : null;
    }

    /**
     * Ubah link TikTok (penuh maupun pendek vm./vt.tiktok.com) menjadi URL embed v2.
     * Link pendek di-resolve dulu dengan mengikuti redirect-nya, hasilnya di-cache 30 hari.
     */
    public static function tiktokEmbedUrl(?string $link): ?string
    {
        $link = trim((string) $link);

        if ($link === '') {
            return null;
        }

        $id = static::resolveTiktokVideoId($link);

        return $id ? "https://www.tiktok.com/embed/v2/{$id}" : null;
    }

    protected static function resolveTiktokVideoId(string $link): ?string
    {
        if (! preg_match('~^https?://([a-z0-9-]+\.)*tiktok\.com(/|$)~i', $link)) {
            return null;
        }

        $id = static::extractTiktokVideoId($link);

        if ($id) {
            return $id;
        }

        // Link pendek (vm.tiktok.com / vt.tiktok.com): ikuti redirect untuk mendapat id video.
        $key = 'tiktok_video_id_' . md5($link);
        $cached = Cache::get($key);

        if ($cached !== null) {
            return $cached === '' ? null : $cached;
        }

        try {
            $id = static::extractTiktokVideoId((string) Http::timeout(4)->get($link)->effectiveUri());
        } catch (\Throwable $e) {
            $id = null;
        }

        // Berhasil: cache 30 hari. Gagal: cache singkat supaya halaman tidak menunggu timeout di tiap kunjungan.
        Cache::put($key, $id ?? '', $id ? now()->addDays(30) : now()->addMinutes(10));

        return $id;
    }

    protected static function extractTiktokVideoId(string $url): ?string
    {
        return preg_match('~/(?:video|embed/v2|player/v1)/(\d{8,})~', $url, $m) ? $m[1] : null;
    }
}
