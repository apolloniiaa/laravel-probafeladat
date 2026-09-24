<x-layout title="Referenciák – Admin">
    <main class="mx-auto max-w-4xl px-6 py-16">
        @include('admin.nav')

        <div class="mt-10 flex items-center justify-between gap-6">
            <h1 class="font-display text-3xl font-bold tracking-tight">Referenciák</h1>
            <x-button :href="route('admin.references.create')">Új referencia</x-button>
        </div>

        @session('status')
            <p role="status" class="mt-8 border border-neutral-300 px-4 py-3 text-sm">{{ $value }}</p>
        @endsession

        @if ($references->isEmpty())
            <p class="mt-8 text-sm text-neutral-500">Még nincs referencia. Amíg nem hoz létre egyet, a weboldalon a minta referenciák jelennek meg.</p>
        @else
            <ul class="mt-8 divide-y divide-neutral-200 border-y border-neutral-200">
                @foreach ($references as $reference)
                    <li class="flex items-center gap-6 py-4">
                        <img src="{{ $reference->image_url }}" alt="" class="aspect-4/3 w-24 shrink-0 object-cover">

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-display text-lg font-medium">{{ $reference->title }}</p>
                            <time datetime="{{ $reference->reference_date->toDateString() }}" class="font-mono text-xs text-neutral-500">
                                {{ $reference->reference_date->format('Y.m.d') }}
                            </time>
                        </div>

                        <a href="{{ route('admin.references.edit', $reference) }}" class="font-mono text-sm hover:underline">Szerkesztés</a>

                        <form action="{{ route('admin.references.destroy', $reference) }}" method="POST"
                              onsubmit="return confirm('Biztosan törli ezt a referenciát?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer font-mono text-sm text-red-600 hover:underline">Törlés</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </main>
</x-layout>
