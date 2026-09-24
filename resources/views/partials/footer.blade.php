<footer class="bg-ink text-white">
    <x-container class="lg:px-18">
        <div class="grid gap-12 pt-16 md:grid-cols-3 md:pt-20 lg:grid-cols-[1fr_26rem_22.5rem] lg:gap-0">
            <div>
                <x-logo />
                <p class="mt-4 text-sm text-neutral-400">{{ config('site.tagline') }}</p>
            </div>

            <nav aria-labelledby="footer-menu-title">
                <h2 id="footer-menu-title" class="font-mono text-xs tracking-widest text-neutral-500">Menü</h2>

                <ul class="mt-5 flex flex-col items-start gap-3.5 text-sm leading-6 text-neutral-300">
                    @foreach (config('site.navigation') as $item)
                        <li><a href="{{ $item['href'] }}" class="transition-colors hover:text-white">{{ $item['label'] }}</a></li>
                    @endforeach
                    <li><button type="button" data-open-modal="contact-modal" class="cursor-pointer transition-colors hover:text-white">Kapcsolat</button></li>
                </ul>
            </nav>

            <div>
                <h2 class="font-mono text-xs tracking-widest text-neutral-500">Kapcsolat</h2>

                <address class="mt-5 text-sm leading-6 text-neutral-300 not-italic">
                    {{ config('site.contact.address') }}<br>
                    <a href="mailto:{{ config('site.contact.email') }}" class="transition-colors hover:text-white">{{ config('site.contact.email') }}</a><br>
                    <a href="tel:{{ str_replace(' ', '', config('site.contact.phone')) }}" class="transition-colors hover:text-white">{{ config('site.contact.phone') }}</a>
                </address>
            </div>
        </div>

        <div class="mt-14 flex flex-col gap-4 border-t border-white/10 py-8 font-mono text-xs tracking-widest text-neutral-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} {{ config('site.name') }} — Minden jog fenntartva</p>

            <ul class="flex gap-6">
                @foreach (config('site.legal') as $item)
                    <li><a href="{{ $item['href'] }}" class="transition-colors hover:text-white">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </x-container>
</footer>
