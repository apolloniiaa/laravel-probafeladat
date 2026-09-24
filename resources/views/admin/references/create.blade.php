<x-layout title="Új referencia – Admin">
    <main class="mx-auto max-w-2xl px-6 py-16">
        @include('admin.nav')

        <h1 class="mt-10 font-display text-3xl font-bold tracking-tight">Új referencia</h1>

        @include('admin.references.form', ['action' => route('admin.references.store'), 'method' => 'POST'])
    </main>
</x-layout>
