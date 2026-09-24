<x-layout title="Üzenetek – Admin">
    <main class="mx-auto max-w-4xl px-6 py-16">
        @include('admin.nav')

        <h1 class="mt-10 font-display text-3xl font-bold tracking-tight">Üzenetek</h1>

        @if ($messages->isEmpty())
            <p class="mt-8 text-sm text-neutral-500">Még nem érkezett üzenet.</p>
        @else
            <ul class="mt-8 divide-y divide-neutral-200 border-y border-neutral-200">
                @foreach ($messages as $message)
                    <li class="py-6">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-6 gap-y-1">
                            <p class="font-display text-lg font-medium">
                                {{ $message->name }}
                                <a href="mailto:{{ $message->email }}" class="ml-2 font-sans text-sm font-normal text-neutral-500 hover:text-ink">{{ $message->email }}</a>
                            </p>
                            <time datetime="{{ $message->created_at->toIso8601String() }}" class="font-mono text-xs text-neutral-500">
                                {{ $message->created_at->format('Y.m.d H:i') }}
                            </time>
                        </div>

                        <p class="mt-3 text-sm leading-relaxed break-words whitespace-pre-line text-neutral-700">{{ $message->message }}</p>
                    </li>
                @endforeach
            </ul>

            @if ($messages->hasPages())
                <nav aria-label="Lapozás" class="mt-8 flex justify-between font-mono text-sm">
                    @if ($messages->previousPageUrl())
                        <a href="{{ $messages->previousPageUrl() }}" class="hover:underline">← Újabbak</a>
                    @else
                        <span></span>
                    @endif

                    @if ($messages->nextPageUrl())
                        <a href="{{ $messages->nextPageUrl() }}" class="hover:underline">Régebbiek →</a>
                    @endif
                </nav>
            @endif
        @endif
    </main>
</x-layout>
