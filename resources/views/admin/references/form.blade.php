<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="mt-8 flex flex-col gap-6">
    @csrf
    @method($method)

    <div>
        <label for="reference-title" class="font-mono text-xs tracking-widest text-neutral-500">Cím</label>
        <input id="reference-title" name="title" type="text" value="{{ old('title', $reference->title) }}" required
               class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink">
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="reference-date" class="font-mono text-xs tracking-widest text-neutral-500">Dátum</label>
        <input id="reference-date" name="reference_date" type="date" value="{{ old('reference_date', $reference->reference_date?->toDateString()) }}" required
               class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink">
        @error('reference_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="reference-image" class="font-mono text-xs tracking-widest text-neutral-500">Borítókép</label>
        @if ($reference->exists)
            <img src="{{ $reference->image_url }}" alt="Jelenlegi borítókép" class="mt-2 aspect-4/3 w-60 object-cover">
        @endif
        <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">
            <input id="reference-image" name="image" type="file" accept="image/jpeg,image/png,image/webp" data-file-input class="peer sr-only">
            <label for="reference-image" class="inline-flex h-10.5 cursor-pointer items-center justify-center bg-ink px-5 font-mono text-sm tracking-tight text-white transition-colors peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-ink hover:bg-neutral-800">
                Kép kiválasztása
            </label>
            <span data-file-name="reference-image" class="min-w-0 truncate text-sm text-neutral-500">Nincs kiválasztott fájl</span>
        </div>
        <p class="mt-2 text-sm text-neutral-500">JPG, PNG vagy WebP, legalább 360×270 px, legfeljebb 5 MB.</p>
        @error('image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-6">
        <x-button type="submit">Mentés</x-button>
        <a href="{{ route('admin.references.index') }}" class="font-mono text-sm text-neutral-500 hover:text-ink">Mégse</a>
    </div>
</form>
