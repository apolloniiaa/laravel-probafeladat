// Open a <dialog> from any element with data-open-modal="dialog-id".
document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-open-modal]');

    if (trigger) {
        event.preventDefault();
        document.getElementById(trigger.dataset.openModal)?.showModal();
    }
});

// Close a modal when its backdrop is clicked.
document.querySelectorAll('dialog').forEach((dialog) => {
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });
});

const contactForm = document.querySelector('[data-contact-form]');

if (contactForm) {
    const dialog = contactForm.closest('dialog');
    const submitButton = contactForm.querySelector('[type="submit"]');
    const submitLabel = submitButton.textContent;
    const formError = contactForm.querySelector('[data-form-error]');
    const success = dialog.querySelector('[data-contact-success]');
    const successMessage = success.querySelector('[data-contact-success-message]');
    let isSubmitting = false;

    const clearErrors = () => {
        contactForm.querySelectorAll('[data-error-for], [data-form-error]').forEach((element) => {
            element.textContent = '';
            element.hidden = true;
        });
        contactForm.querySelectorAll('[aria-invalid]').forEach((field) => field.removeAttribute('aria-invalid'));
    };

    const showFieldErrors = (errors) => {
        Object.entries(errors).forEach(([name, messages]) => {
            const error = contactForm.querySelector(`[data-error-for="${name}"]`);

            if (error) {
                error.textContent = messages[0];
                error.hidden = false;
            }

            contactForm.elements[name]?.setAttribute('aria-invalid', 'true');
        });

        contactForm.querySelector('[aria-invalid="true"]')?.focus();
    };

    const setSubmitting = (submitting) => {
        isSubmitting = submitting;
        submitButton.disabled = submitting;
        submitButton.textContent = submitting ? 'Küldés…' : submitLabel;
    };

    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (isSubmitting) {
            return;
        }

        setSubmitting(true);
        clearErrors();

        try {
            const response = await fetch(contactForm.action, {
                method: 'POST',
                headers: { Accept: 'application/json' },
                body: new FormData(contactForm),
            });
            const data = await response.json().catch(() => ({}));

            if (response.ok) {
                successMessage.textContent = data.message;
                contactForm.reset();
                contactForm.hidden = true;
                success.hidden = false;
                success.focus();
            } else if (response.status === 422 && data.errors) {
                showFieldErrors(data.errors);
            } else {
                throw new Error(data.message);
            }
        } catch {
            formError.textContent = 'Az üzenetet most nem sikerült elküldeni. Kérjük, próbálja újra később.';
            formError.hidden = false;
        } finally {
            setSubmitting(false);
        }
    });

    dialog.addEventListener('close', () => {
        clearErrors();
        contactForm.reset();
        contactForm.hidden = false;
        success.hidden = true;
    });
}
