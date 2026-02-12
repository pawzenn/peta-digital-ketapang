<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomestayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        // dukung input "4,5" (format Indonesia)
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

            'cover' => ['required', 'image', 'mimes:jpg,jpeg', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg', 'max:2048'],
        ];
    }
}
