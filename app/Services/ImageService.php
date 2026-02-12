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

    public function deleteIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
