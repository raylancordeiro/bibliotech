document.addEventListener('DOMContentLoaded', () => {

    const closeButtons = document.querySelectorAll('.custom-toast-close');

    closeButtons.forEach(button => {

        button.addEventListener('click', function (e) {
console.log("clique");
            e.preventDefault();
            e.stopPropagation();

            const toast = this.closest('.custom-toast');

            if (!toast) return;

            toast.classList.add('custom-toast-hide');

            setTimeout(() => {
                toast.remove();
            }, 300);

        });

    });

    const toasts = document.querySelectorAll('.custom-toast');

    toasts.forEach(toast => {

        setTimeout(() => {

            if (!toast.isConnected) return;

            toast.classList.add('custom-toast-hide');

            setTimeout(() => {
                toast.remove();
            }, 300);

        }, 20000);

    });

});
