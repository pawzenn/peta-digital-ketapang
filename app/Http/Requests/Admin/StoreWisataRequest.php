<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreWisataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        // Biar user bisa input "4,5" (format Indonesia) dan tetap dianggap numeric
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

            // rating desimal 1.0 - 5.0
            'rating' => ['nullable', 'numeric', 'between:1,5'],

            'alamat' => ['nullable', 'string', 'max:255'],
            'maps_link' => ['nullable', 'url'],

            // FOTO: JPG/JPEG only
            'cover' => ['required', 'image', 'mimes:jpg,jpeg', 'max:2048'],
            'foto_rute' => ['nullable', 'image', 'mimes:jpg,jpeg', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg', 'max:2048'],
        ];
    }
}
