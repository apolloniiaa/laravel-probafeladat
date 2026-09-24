{{-- UI only for now: method="dialog" just closes the modal on submit.
     Later: method="POST" to a contact route, plus @csrf. --}}
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

        <form method="dialog" class="mt-8 flex flex-col gap-5">
            <div>
                <label for="contact-name" class="font-mono text-xs tracking-widest text-neutral-500">Név</label>
                <input id="contact-name" name="name" type="text" autocomplete="name" required
                       class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink">
            </div>

            <div>
                <label for="contact-email" class="font-mono text-xs tracking-widest text-neutral-500">E-mail</label>
                <input id="contact-email" name="email" type="email" autocomplete="email" required
                       class="mt-2 block h-11 w-full border border-neutral-300 px-4 outline-none focus:border-ink">
            </div>

            <div>
                <label for="contact-message" class="font-mono text-xs tracking-widest text-neutral-500">Üzenet</label>
                <textarea id="contact-message" name="message" rows="5" required
                          class="mt-2 block w-full resize-none border border-neutral-300 px-4 py-3 outline-none focus:border-ink"></textarea>
            </div>

            <x-button type="submit" class="w-full">Üzenet küldése</x-button>
        </form>
    </div>
</dialog>
