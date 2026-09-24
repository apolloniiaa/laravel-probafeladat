@props([
    'variant' => 'dark',
    'href' => null,
])

@php
    $variants = [
        'dark' => 'bg-ink text-white hover:bg-neutral-800',
        'light' => 'bg-white text-ink hover:bg-neutral-200',
        'outline' => 'border border-white/30 text-white hover:bg-white/10',
    ];

    $classes = 'inline-flex h-10.5 cursor-pointer items-center justify-center px-5 font-mono text-sm tracking-tight transition-colors '.$variants[$variant];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
