document.addEventListener('DOMContentLoaded', () => {

    const modalElement = document.getElementById('createBookModal');

    if (!modalElement) return;

    const modal = new bootstrap.Modal(modalElement);

    const form = document.getElementById('createBookForm');

    const createBtn = document.getElementById('createBookBtn');

    const modalTitle = document.getElementById('bookModalTitle');

    const title = document.getElementById('book_title');
    const publisher = document.getElementById('book_publisher');
    const edition = document.getElementById('book_edition');
    const publicationYear = document.getElementById('book_publicationYear');
    const price = document.getElementById('book_price');

    const editTitle = modalTitle.dataset.editTitle;
    const createTitle = modalTitle.dataset.createTitle;

    function resetFormToCreateMode() {

        form.action = '/books';

        modalTitle.innerText = modalTitle.dataset.createTitle;

        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    createBtn.addEventListener('click', () => {
        resetFormToCreateMode();
    });

    const editButtons = document.querySelectorAll('.js-edit-book');

    editButtons.forEach(button => {

        button.addEventListener('click', (e) => {

            e.preventDefault();

            const id = e.currentTarget.dataset.id;

            form.action = `/books/${id}/update`;

            modalTitle.innerText = modalTitle.dataset.editTitle;

            const rawPrice = button.dataset.price;

            title.value = button.dataset.title;
            publisher.value = button.dataset.publisher;
            edition.value = button.dataset.edition;
            publicationYear.value = button.dataset.publicationYear;
            price.value = Number(rawPrice).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            modal.show();
        });
    });
});
