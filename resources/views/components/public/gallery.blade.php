@props(['images'])

@if($images && $images->count())
    <div class="mt-10">
        <h2 class="mb-4 text-xl font-semibold text-white">Gallery</h2>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @foreach($images as $foto)
                <div class="aspect-square overflow-hidden rounded-lg">
                    <img
                        src="{{ asset('storage/' . $foto->file_path) }}"
                        class="h-full w-full object-cover"
                        alt="Gallery"
                    >
                </div>
            @endforeach
        </div>
    </div>
@endif
