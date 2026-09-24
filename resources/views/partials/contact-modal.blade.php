<dialog
    id="contact-modal"
    aria-labelledby="contact-modal-title"
    class="m-auto w-[calc(100%-2rem)] max-w-lg bg-white p-0 text-ink backdrop:bg-black/60"
>
    <div class="p-6 sm:p-10">
        <div class="flex items-start justify-between gap-6">
            <h2 id="contact-modal-title" class="font-display text-3xl font-bold tracking-tight">Kapcsolat</h2>

            <form method="dialog">
                <button class="-mt-1 -mr-2 cursor-pointer p-2 text-2xl leading-none text-neutral-500 hover:text-ink" aria-label="Bezárás">&times;</button>
            </form>
        </div>

        <form action="{{ route('contact.store') }}" method="POST" novalidate data-contact-form class="mt-8 flex flex-col gap-5">
            @csrf

            <div>
                <label for="contact-name" class="font-mono text-xs tracking-widest text-neutral-500">Név</label>
                <input id="contact-name" name="name" type="text" autocomplete="name" required aria-describedby="contact-name-error"
                       class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink aria-invalid:border-red-600">
                <p id="contact-name-error" data-error-for="name" class="mt-2 text-sm text-red-600" hidden></p>
            </div>

            <div>
                <label for="contact-email" class="font-mono text-xs tracking-widest text-neutral-500">E-mail cím</label>
                <input id="contact-email" name="email" type="email" autocomplete="email" required aria-describedby="contact-email-error"
                       class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink aria-invalid:border-red-600">
                <p id="contact-email-error" data-error-for="email" class="mt-2 text-sm text-red-600" hidden></p>
            </div>

            <div>
                <label for="contact-message" class="font-mono text-xs tracking-widest text-neutral-500">Üzenet</label>
                <textarea id="contact-message" name="message" rows="5" required aria-describedby="contact-message-error"
                          class="mt-2 block w-full resize-none border border-neutral-300 px-4 py-3 outline-none focus:border-ink aria-invalid:border-red-600"></textarea>
                <p id="contact-message-error" data-error-for="message" class="mt-2 text-sm text-red-600" hidden></p>
            </div>

            <p data-form-error role="alert" class="text-sm text-red-600" hidden></p>

            <x-button type="submit" class="w-full disabled:cursor-wait disabled:opacity-60">Üzenet küldése</x-button>
        </form>

        <div data-contact-success role="status" tabindex="-1" class="mt-8 outline-none" hidden>
            <p data-contact-success-message class="text-base leading-relaxed text-neutral-700"></p>

            <form method="dialog" class="mt-8">
                <x-button type="submit" class="w-full">Bezárás</x-button>
            </form>
        </div>
    </div>
</dialog>
