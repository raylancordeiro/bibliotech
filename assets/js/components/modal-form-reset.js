document.addEventListener('DOMContentLoaded', () => {
    const closeBtn = document.getElementById('closeBookBtn');
    const form = document.getElementById('createBookForm');

    if (!closeBtn || !form) return;

    closeBtn.addEventListener('click', () => {
        form.reset();

        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {

    const modalElement = document.getElementById('createBookModal');

    if (!modalElement) return;

    const shouldOpen = modalElement.dataset.autoOpen === 'true';

    if (!shouldOpen) return;

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    modal.show();

});
