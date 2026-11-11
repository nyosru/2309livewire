(() => {
    const dialog = document.querySelector('#consult-dialog');
    const serviceInput = document.querySelector('#service-input');
    const discountCheck = document.querySelector('#discount-check');
    const videoConsent = document.querySelector('#video-consent');
    const videoConsentRow = document.querySelector('.video-consent');

    document.querySelectorAll('[data-consult]').forEach((button) => {
        button.addEventListener('click', () => {
            serviceInput.value = button.dataset.consult || 'Бесплатная консультация';
            const wantsDiscount = button.dataset.discount === '1';
            discountCheck.checked = wantsDiscount;
            videoConsent.checked = false;
            videoConsentRow.hidden = !wantsDiscount;
            dialog.showModal();
        });
    });

    discountCheck.addEventListener('change', () => {
        videoConsentRow.hidden = !discountCheck.checked;
        if (!discountCheck.checked) videoConsent.checked = false;
    });

    dialog.querySelectorAll('[data-close]').forEach((button) => button.addEventListener('click', () => dialog.close()));
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) dialog.close();
    });

    const phone = dialog.querySelector('[name="phone"]');
    phone.addEventListener('input', () => {
        phone.setCustomValidity('');
        const digits = phone.value.replace(/\D/g, '');
        if (digits.length < 10 || digits.length > 15) phone.setCustomValidity('Введите номер телефона из 10–15 цифр.');
    });
})();
