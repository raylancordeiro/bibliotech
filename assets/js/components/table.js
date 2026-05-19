document.querySelectorAll('.js-confirm-delete')
    .forEach(el => {
        el.addEventListener('click', function (e) {
            const message = this.dataset.message;

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
});
