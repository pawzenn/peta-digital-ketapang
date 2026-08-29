<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Simpan image sebagai JPG dan auto-crop 16:9 (1200x675).
     * Return: path relatif di disk public (contoh: wisata/cover/abc.jpg)
     */
    public function saveCroppedJpg(
        UploadedFile $file,
        string $dir,
        int $width = 1200,
        int $height = 675,
        int $quality = 85
    ): string {
        // pastikan folder tujuan ada
        Storage::disk('public')->makeDirectory($dir);

        $filename = uniqid('', true) . '.jpg';
        $path = trim($dir, '/') . '/' . $filename;

        // crop center + resize
        $img = Image::read($file)
            ->cover($width, $height)   // auto-crop center ke ukuran target
            ->toJpeg($quality);

        Storage::disk('public')->put($path, (string) $img);

        return $path;
    }

    /**
     * Simpan image sebagai PNG apa adanya (tanpa crop, transparansi tetap dipertahankan),
     * hanya diperkecil kalau lebih lebar dari $maxWidth.
     * Return: path relatif di disk public (contoh: profil/abc.png)
     */
    public function savePng(UploadedFile $file, string $dir, int $maxWidth = 1600): string
    {
        Storage::disk('public')->makeDirectory($dir);

        $filename = uniqid('', true) . '.png';
        $path = trim($dir, '/') . '/' . $filename;

        $img = Image::read($file)
            ->scaleDown(width: $maxWidth)
            ->toPng();

        Storage::disk('public')->put($path, (string) $img);

        return $path;
    }

    public function deleteIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
