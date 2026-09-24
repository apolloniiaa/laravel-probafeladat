@props(['title', 'date', 'image'])

<article>
    <img src="{{ asset($image) }}" alt="{{ $title }}" class="aspect-4/3 w-full object-cover" loading="lazy">

    <time datetime="{{ $date }}" class="mt-4.5 block font-mono text-xs text-neutral-500">
        {{ \Illuminate\Support\Carbon::parse($date)->format('Y.m.d') }}
    </time>

    <h3 class="mt-3 font-display text-lg font-medium">{{ $title }}</h3>
</article>
