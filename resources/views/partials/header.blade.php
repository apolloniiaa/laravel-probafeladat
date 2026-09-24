<header class="border-b border-neutral-200 bg-white">
    <x-container>
        <div class="grid h-16 grid-cols-[1fr_auto] items-center md:h-18 md:grid-cols-[1fr_auto_1fr] lg:px-10">
            <x-logo class="justify-self-start" />

            <nav aria-label="Főmenü" class="hidden md:block">
                <ul class="flex gap-11 font-mono text-sm tracking-tight text-neutral-700">
                    @foreach (config('site.navigation') as $item)
                        <li><a href="{{ $item['href'] }}" class="transition-colors hover:text-ink">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            <x-button data-open-modal="contact-modal" class="justify-self-end">Kapcsolat</x-button>
        </div>
    </x-container>
</header>
