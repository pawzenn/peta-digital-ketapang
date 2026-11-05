<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBencanaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'jenis_bencana' => ['required', 'string', 'in:banjir,banjir_bandang,tanah_longsor,cuaca_ekstrem,gelombang_ekstrem_abrasi,gempa_bumi,kegagalan_teknologi,likuifaksi,kebakaran,angin_puting_beliung,lainnya'],
            'tingkat_risiko' => ['required', 'string', 'in:rendah,sedang,tinggi'],
            'deskripsi' => ['required', 'string'],

            'alamat' => ['nullable', 'string', 'max:255'],
            'maps_link' => ['nullable', 'url'],

            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg', 'max:4096'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg', 'max:4096'],

            'kejadian' => ['nullable', 'array'],
            'kejadian.*.judul' => ['required', 'string', 'max:150'],
            'kejadian.*.tanggal_kejadian' => ['required', 'date', 'before_or_equal:today'],
            'kejadian.*.lokasi' => ['nullable', 'string', 'max:255'],
            'kejadian.*.uraian' => ['nullable', 'string', 'max:5000'],
            'kejadian.*.korban_meninggal' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'kejadian.*.korban_luka' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'kejadian.*.warga_mengungsi' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'kejadian.*.rumah_rusak' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'kejadian.*.kerugian' => ['nullable', 'string', 'max:100'],
            'kejadian.*.sumber' => ['nullable', 'string', 'max:150'],
        ];
    }
}
