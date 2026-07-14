<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBencanaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'jenis_bencana' => ['required', 'string', 'in:banjir,longsor,kebakaran,gempa_bumi,angin_puting_beliung,lainnya'],
            'tingkat_risiko' => ['required', 'string', 'in:rendah,sedang,tinggi'],
            'deskripsi' => ['required', 'string'],

            'alamat' => ['nullable', 'string', 'max:255'],
            'maps_link' => ['nullable', 'url'],

            'cover' => ['required', 'image', 'mimes:jpg,jpeg', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg', 'max:2048'],
        ];
    }
}
