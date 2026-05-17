function formatMoneyInput(el) {

    let value = el.value;

    // remove tudo que não for número
    value = value.replace(/\D/g, '');

    // garante no mínimo 3 dígitos
    value = value.padStart(3, '0');

    const cents = value.slice(-2);
    const integer = value.slice(0, -2);

    // formata milhares
    const formattedInt = integer
        .replace(/^0+/, '')
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    el.value = `${formattedInt || '0'},${cents}`;
}

function normalizeMoneyValue(value) {

    return value
        .replace(/\./g, '') // remove milhares
        .replace(',', '.'); // troca vírgula por ponto
}

document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('createBookModal');

    if (!modal) return;

    const form = document.getElementById('createBookForm');

    let initialized = false;

    modal.addEventListener('shown.bs.modal', () => {

        if (initialized) return;

        const input = modal.querySelector('.js-money-mask');

        if (!input) return;

        input.addEventListener('input', () => {
            formatMoneyInput(input);
        });

        initialized = true;

    });

    form.addEventListener('submit', () => {

        const input = form.querySelector('.js-money-mask');

        if (!input) return;

        input.value = normalizeMoneyValue(input.value);

    });

});
