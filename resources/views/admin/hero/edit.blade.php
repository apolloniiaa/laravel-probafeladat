<x-layout title="Hero szekció – Admin">
    <main class="mx-auto max-w-2xl px-6 py-16">
        @include('admin.nav')

        <h1 class="mt-10 font-display text-3xl font-bold tracking-tight">Hero szekció</h1>

        @session('status')
            <p role="status" class="mt-8 border border-neutral-300 px-4 py-3 text-sm">{{ $value }}</p>
        @endsession

        <form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data" class="mt-8 flex flex-col gap-6">
            @csrf
            @method('PUT')

            <div>
                <label for="hero-title" class="font-mono text-xs tracking-widest text-neutral-500">Főcím</label>
                <input id="hero-title" name="title" type="text" value="{{ old('title', $hero->title) }}" required
                       class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hero-description" class="font-mono text-xs tracking-widest text-neutral-500">Leírás</label>
                <textarea id="hero-description" name="description" rows="3" required
                          class="mt-2 block w-full resize-none border border-neutral-300 px-4 py-3 outline-none focus:border-ink">{{ old('description', $hero->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hero-image" class="font-mono text-xs tracking-widest text-neutral-500">Háttérkép</label>
                <img src="{{ $hero->image_url }}" alt="Jelenlegi háttérkép" class="mt-2 aspect-[1920/780] w-full object-cover">
                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">
                    <input id="hero-image" name="image" type="file" accept="image/jpeg,image/png,image/webp" data-file-input class="peer sr-only">
                    <label for="hero-image" class="inline-flex h-10.5 cursor-pointer items-center justify-center bg-ink px-5 font-mono text-sm tracking-tight text-white transition-colors peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-ink hover:bg-neutral-800">
                        Kép kiválasztása
                    </label>
                    <span data-file-name="hero-image" class="min-w-0 truncate text-sm text-neutral-500">Nincs kiválasztott fájl</span>
                </div>
                <p class="mt-2 text-sm text-neutral-500">JPG, PNG vagy WebP, legalább 1280×520 px, legfeljebb 5 MB.</p>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <x-button type="submit" class="self-start">Mentés</x-button>
        </form>
    </main>
</x-layout>
