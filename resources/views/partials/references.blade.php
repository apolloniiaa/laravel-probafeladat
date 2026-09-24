<section id="munkaink" class="pt-20 pb-24 md:pt-26 md:pb-32">
    <x-container>
        <h2 class="border-b border-neutral-200 pb-6 font-display text-4xl leading-[1.1] font-bold tracking-tight md:pb-8 md:text-[44px]">
            Munkáink
        </h2>

        <div class="mt-10 grid gap-x-8 gap-y-12 sm:grid-cols-2 md:mt-11 lg:grid-cols-4">
            @forelse ($references as $reference)
                <x-reference-card
                    :title="$reference->title"
                    :date="$reference->reference_date"
                    :image="$reference->image_url"
                />
            @empty
                @foreach (config('site.references') as $reference)
                    <x-reference-card
                        :title="$reference['title']"
                        :date="$reference['date']"
                        :image="asset($reference['image'])"
                    />
                @endforeach
            @endforelse
        </div>
    </x-container>
</section>
