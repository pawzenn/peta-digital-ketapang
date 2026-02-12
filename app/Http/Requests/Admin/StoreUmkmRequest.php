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
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'maps_link' => ['nullable', 'url'],

            'cover' => ['required', 'image', 'mimes:jpg,jpeg', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg', 'max:2048'],
        ];
    }
}
