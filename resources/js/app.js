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
