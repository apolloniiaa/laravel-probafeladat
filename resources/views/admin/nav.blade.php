<nav aria-label="Admin" class="flex flex-wrap gap-6 font-mono text-sm text-neutral-500">
    <a href="{{ route('admin.hero.edit') }}" @class(['hover:text-ink', 'text-ink' => request()->routeIs('admin.hero.*')])>Hero szekció</a>
    <a href="{{ route('admin.references.index') }}" @class(['hover:text-ink', 'text-ink' => request()->routeIs('admin.references.*')])>Referenciák</a>
    <a href="{{ route('admin.messages.index') }}" @class(['hover:text-ink', 'text-ink' => request()->routeIs('admin.messages.*')])>Üzenetek</a>
    <a href="{{ route('home') }}" class="hover:text-ink">Weboldal megtekintése</a>
</nav>
