function formatMoneyInput(el) {

    let value = el.value;
    value = value.replace(/\D/g, '');
    value = value.padStart(3, '0');

    const cents = value.slice(-2);
    const integer = value.slice(0, -2);

    const formattedInt = integer
        .replace(/^0+/, '')
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    el.value = `${formattedInt || '0'},${cents}`;
}

function normalizeMoneyValue(value) {

    return value
        .replace(/\./g, '')
        .replace(',', '.');
}

document.addEventListener('DOMContentLoaded', () => {

    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const input = form.querySelector('.js-money-mask');
        if (!input) return;

        input.addEventListener('input', () => {
            formatMoneyInput(input);
        });

        form.addEventListener('submit', () => {
            input.value = normalizeMoneyValue(input.value);
        });

    });

    const modals = document.querySelectorAll('.js-form-modal');

    modals.forEach(modalElement => {

        const form = modalElement.querySelector('form');

        if (!form) return;

        const shouldOpen = modalElement.dataset.autoOpen === 'true';

        if (shouldOpen) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

            modal.show();
        }

        function resetForm() {

            form.reset();

            form.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

        }

        const closeButtons = modalElement.querySelectorAll('.js-modal-close');

        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                resetForm();
            });
        });
    });

    const editButtons = document.querySelectorAll('[data-modal-target]');

    editButtons.forEach(button => {

        button.addEventListener('click', (e) => {

            e.preventDefault();

            const modalSelector = button.dataset.modalTarget;

            const modalElement = document.querySelector(modalSelector);

            if (!modalElement) return;

            const form = modalElement.querySelector('form');

            if (!form) return;

            if (button.dataset.action) {

                form.action = button.dataset.action;

            }

            const modalTitle = modalElement.querySelector('.js-modal-title');

            if (modalTitle && button.dataset.modalTitle) {

                modalTitle.innerText = button.dataset.modalTitle;

            }

            Object.keys(button.dataset).forEach(key => {

                if (
                    [
                        'modalTarget',
                        'modalTitle',
                        'action'
                    ].includes(key)
                ) {
                    return;
                }

                const input = form.querySelector(`[name$="[${key}]"]`);

                if (!input) return;

                let value = button.dataset[key];

                if (input.classList.contains('js-money-mask')) {

                    value = Number(value).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                }

                if (input.multiple) {

                    input.querySelectorAll('option').forEach(option => {
                        option.selected = false;
                    });

                    value.split(',').forEach(selectedValue => {

                        const option = input.querySelector(`option[value="${selectedValue}"]`);

                        if (option) {
                            option.selected = true;
                        }

                    });

                } else {
                    input.value = value;
                }
            });

            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

            modal.show();
        });
    });

    document.querySelectorAll('.js-tom-select').forEach(select => {

        if (select.tomselect) return;

        new TomSelect(select, {
            plugins: ['remove_button'],
            create: false,
            persist: false,
            maxOptions: null,
            hideSelected: true,
            closeAfterSelect: false,
        });

    });
});
