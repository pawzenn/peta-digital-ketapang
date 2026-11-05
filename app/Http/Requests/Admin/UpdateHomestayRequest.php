<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomestayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        // dukung input "4,5" juga saat update
        if ($this->has('rating') && is_string($this->rating)) {
            $this->merge([
                'rating' => str_replace(',', '.', $this->rating),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'rating' => ['nullable', 'numeric', 'between:1,5'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'maps_link' => ['nullable', 'url'],

            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg', 'max:4096'],
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
