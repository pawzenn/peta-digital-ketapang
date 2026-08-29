@extends('layouts.admin')

@section('page_title', 'Profil Desa')
@section('page_subtitle', 'Kelola informasi umum dan peta wilayah desa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <h1 class="text-xl font-semibold text-neutral-900">Profil Desa</h1>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>
                    <x-input-label for="nama" value="Nama" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1.5 block w-full"
                        value="{{ old('nama',$profil->nama) }}" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="deskripsi" value="Deskripsi" />
                    <textarea id="deskripsi" name="deskripsi"
                              class="mt-1.5 w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
                              rows="5">{{ old('deskripsi',$profil->deskripsi) }}</textarea>
                    <p class="mt-1 text-xs text-neutral-400">Ditampilkan di halaman Profil (/profil).</p>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="deskripsi_singkat" value="Deskripsi Singkat (Beranda)" />
                    <textarea id="deskripsi_singkat" name="deskripsi_singkat"
                              class="mt-1.5 w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
                              rows="3" placeholder="Kalimat singkat perkenalan desa yang tampil di beranda">{{ old('deskripsi_singkat',$profil->deskripsi_singkat) }}</textarea>
                    <p class="mt-1 text-xs text-neutral-400">Khusus ditampilkan di section Profil pada halaman beranda, terpisah dari Deskripsi di atas.</p>
                    <x-input-error :messages="$errors->get('deskripsi_singkat')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="peta_wilayah" value="Peta Wilayah (JPG/PNG)" />
                    <input id="peta_wilayah" type="file" name="peta_wilayah" accept=".jpg,.jpeg,.png"
                           class="mt-1.5 block w-full text-sm text-neutral-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-emerald-800 hover:file:bg-emerald-100">
                    <x-input-error :messages="$errors->get('peta_wilayah')" class="mt-1.5" />

                    @if($profil->peta_wilayah)
                        <img src="{{ asset('storage/'.$profil->peta_wilayah) }}"
                             class="mt-3 w-full max-w-md rounded-lg border border-neutral-200">
                    @endif
                </div>

            </div>

            <div class="my-6 border-t border-neutral-200"></div>

            <div class="space-y-1">
                <h2 class="text-sm font-semibold text-neutral-900">Kontak & Media Sosial</h2>
                <p class="text-sm text-neutral-500">Ditampilkan di footer halaman publik. Ikon hanya muncul jika diisi.</p>
            </div>

            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-input-label for="alamat" value="Alamat" />
                    <x-text-input id="alamat" name="alamat" type="text" class="mt-1.5 block w-full"
                        value="{{ old('alamat',$profil->alamat) }}" placeholder="Contoh: Dusun Krajan, Desa Ketapang, Kalipuro, Banyuwangi" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full"
                        value="{{ old('email',$profil->email) }}" placeholder="desa.ketapang@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="whatsapp" value="WhatsApp" />
                    <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1.5 block w-full"
                        value="{{ old('whatsapp',$profil->whatsapp) }}" placeholder="6281234567890" />
                    <p class="mt-1 text-xs text-neutral-400">Diawali kode negara, tanpa spasi atau tanda +. Contoh: 6281234567890</p>
                    <x-input-error :messages="$errors->get('whatsapp')" class="mt-1.5" />
                </div>

                @php
                    $socialFields = [
                        ['key' => 'instagram', 'label' => 'Instagram', 'placeholder' => 'https://instagram.com/desaketapang'],
                        ['key' => 'facebook', 'label' => 'Facebook', 'placeholder' => 'https://facebook.com/desaketapang'],
                        ['key' => 'tiktok', 'label' => 'TikTok', 'placeholder' => 'https://tiktok.com/@desaketapang'],
                        ['key' => 'youtube', 'label' => 'YouTube', 'placeholder' => 'https://youtube.com/@desaketapang'],
                    ];
                @endphp

                @foreach($socialFields as $social)
                    <div class="rounded-lg border border-neutral-200 p-4">
                        <p class="mb-3 text-sm font-semibold text-neutral-700">{{ $social['label'] }}</p>

                        <div class="space-y-3">
                            <div>
                                <x-input-label :for="$social['key'].'_nama'" value="Nama Tampilan" />
                                <x-text-input :id="$social['key'].'_nama'" :name="$social['key'].'_nama'" type="text" class="mt-1.5 block w-full"
                                    :value="old($social['key'].'_nama', $profil->{$social['key'].'_nama'})" :placeholder="$social['label']" />
                                <x-input-error :messages="$errors->get($social['key'].'_nama')" class="mt-1.5" />
                            </div>

                            <div>
                                <x-input-label :for="$social['key']" value="Link" />
                                <x-text-input :id="$social['key']" :name="$social['key']" type="url" class="mt-1.5 block w-full"
                                    :value="old($social['key'], $profil->{$social['key']})" :placeholder="$social['placeholder']" />
                                <x-input-error :messages="$errors->get($social['key'])" class="mt-1.5" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="my-6 border-t border-neutral-200"></div>

            <div class="space-y-1">
                <h2 class="text-sm font-semibold text-neutral-900">Kepala Desa</h2>
                <p class="text-sm text-neutral-500">Ditampilkan di halaman Profil publik.</p>
            </div>

            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-input-label for="kepala_desa_foto" value="Foto Kepala Desa" />
                    <input id="kepala_desa_foto" type="file" name="kepala_desa_foto" accept=".jpg,.jpeg,.png"
                           class="mt-1.5 block w-full text-sm text-neutral-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-emerald-800 hover:file:bg-emerald-100">
                    <x-input-error :messages="$errors->get('kepala_desa_foto')" class="mt-1.5" />

                    @if($profil->kepala_desa_foto)
                        <img src="{{ asset('storage/'.$profil->kepala_desa_foto) }}"
                             class="mt-3 h-28 w-28 rounded-full border border-neutral-200 object-cover">
                    @endif
                </div>

                <div>
                    <x-input-label for="kepala_desa_nama" value="Nama Kepala Desa" />
                    <x-text-input id="kepala_desa_nama" name="kepala_desa_nama" type="text" class="mt-1.5 block w-full"
                        value="{{ old('kepala_desa_nama',$profil->kepala_desa_nama) }}" placeholder="Contoh: Slamet Utomo, S.H" />
                    <x-input-error :messages="$errors->get('kepala_desa_nama')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="kepala_desa_jabatan" value="Jabatan" />
                    <x-text-input id="kepala_desa_jabatan" name="kepala_desa_jabatan" type="text" class="mt-1.5 block w-full"
                        value="{{ old('kepala_desa_jabatan',$profil->kepala_desa_jabatan) }}" placeholder="Kepala Desa" />
                    <x-input-error :messages="$errors->get('kepala_desa_jabatan')" class="mt-1.5" />
                </div>
            </div>

            <div class="my-6 border-t border-neutral-200"></div>

            <div class="space-y-1">
                <h2 class="text-sm font-semibold text-neutral-900">Visi & Misi Desa</h2>
                <p class="text-sm text-neutral-500">Ditampilkan di halaman Profil publik.</p>
            </div>

            <div class="mt-4 space-y-5">
                <div>
                    <x-input-label for="visi" value="Visi" />
                    <textarea id="visi" name="visi"
                              class="mt-1.5 w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
                              rows="4" placeholder="Tuliskan visi desa">{{ old('visi',$profil->visi) }}</textarea>
                    <x-input-error :messages="$errors->get('visi')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="misi" value="Misi" />
                    <textarea id="misi" name="misi"
                              class="mt-1.5 w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
                              rows="5" placeholder="Satu poin per baris, contoh:&#10;Pengembangan pariwisata untuk meningkatkan perekonomian masyarakat&#10;Peningkatan pelayanan kepada masyarakat secara menyeluruh">{{ old('misi',$profil->misi) }}</textarea>
                    <p class="mt-1 text-xs text-neutral-400">Satu poin misi per baris. Akan ditampilkan sebagai daftar bernomor huruf (a, b, c, ...).</p>
                    <x-input-error :messages="$errors->get('misi')" class="mt-1.5" />
                </div>
            </div>

            <button class="mt-6 inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
                Simpan
            </button>

        </form>
    </div>

</div>
@endsection
