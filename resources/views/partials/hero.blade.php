<section class="relative isolate flex min-h-[560px] items-center overflow-hidden bg-ink pt-9 text-white md:min-h-[780px]">
    <img src="{{ $hero->image_url }}" alt="" class="absolute inset-0 -z-10 size-full object-cover">
    <div class="absolute inset-0 -z-10 bg-linear-to-r from-black/80 via-black/40 via-50% to-black/25" aria-hidden="true"></div>
    <div class="absolute inset-0 -z-10 bg-linear-to-b from-transparent from-65% to-black/55" aria-hidden="true"></div>

    <x-container class="py-16">
        <h1 class="max-w-200 font-display text-4xl leading-[1.05] font-bold sm:text-5xl lg:text-[64px] lg:leading-[1.02]">
            {{ $hero->title }}
        </h1>

        <p class="mt-6 max-w-128 text-base leading-relaxed text-white/75 md:text-lg md:leading-[1.65]">
            {{ $hero->description }}
        </p>

        <div class="mt-9 flex flex-wrap gap-3.5">
            <x-button variant="light" data-open-modal="contact-modal">Kezdjük a tervezést</x-button>
            <x-button variant="outline" href="#">A stúdióról</x-button>
        </div>
    </x-container>
</section>
