<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUmkmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'kategori_umkm_id' => ['required', 'integer', 'exists:kategori_umkms,id'],
            'nama' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'rating' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'maps_link' => ['nullable', 'url'],

            'cover' => ['required', 'image', 'mimes:jpg,jpeg', 'max:4096'],
            'foto_rute' => ['nullable', 'image', 'mimes:jpg,jpeg', 'max:4096'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg', 'max:4096'],

            'video_rute_link' => ['nullable', 'url', 'max:255'],

            'video_reviews' => ['nullable', 'array'],
            'video_reviews.*.url' => ['required', 'url', 'max:255'],
            'video_reviews.*.caption' => ['nullable', 'string', 'max:150'],

            'penghargaan' => ['nullable', 'array'],
            'penghargaan.*.nama' => ['required', 'string', 'max:150'],
            'penghargaan.*.tahun' => ['nullable', 'digits:4'],
            'penghargaan.*.pemberi' => ['nullable', 'string', 'max:150'],
        ];
    }
}
