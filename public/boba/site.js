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

    const carousel = document.querySelector('[data-promo-carousel]');
    if (carousel) {
        const slides = [...carousel.querySelectorAll('[data-promo-slide]')];
        const dots = [...carousel.querySelectorAll('[data-promo-to]')];
        const pauseButton = carousel.querySelector('[data-promo-toggle]');
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        let activeIndex = 0;
        let timer = null;
        let userPaused = reducedMotion.matches;
        let pointerInside = false;
        let focusInside = false;

        if (userPaused && pauseButton) {
            pauseButton.setAttribute('aria-pressed', 'true');
            pauseButton.setAttribute('aria-label', 'Продолжить смену направлений');
            pauseButton.textContent = '▷';
        }

        const stopRotation = () => {
            if (timer !== null) window.clearInterval(timer);
            timer = null;
        };

        const showSlide = (index) => {
            activeIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                const active = slideIndex === activeIndex;
                slide.classList.toggle('is-active', active);
                slide.setAttribute('aria-hidden', String(!active));
                slide.inert = !active;
            });
            dots.forEach((dot, dotIndex) => {
                const active = dotIndex === activeIndex;
                dot.classList.toggle('is-active', active);
                if (active) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
        };

        const startRotation = () => {
            stopRotation();
            if (!userPaused && !pointerInside && !focusInside && !document.hidden && slides.length > 1) {
                timer = window.setInterval(() => showSlide(activeIndex + 1), 7000);
            }
        };

        carousel.querySelector('[data-promo-prev]')?.addEventListener('click', () => {
            showSlide(activeIndex - 1);
            startRotation();
        });
        carousel.querySelector('[data-promo-next]')?.addEventListener('click', () => {
            showSlide(activeIndex + 1);
            startRotation();
        });
        dots.forEach((dot) => dot.addEventListener('click', () => {
            showSlide(Number(dot.dataset.promoTo));
            startRotation();
        }));
        pauseButton?.addEventListener('click', () => {
            userPaused = !userPaused;
            pauseButton.setAttribute('aria-pressed', String(userPaused));
            pauseButton.setAttribute('aria-label', userPaused ? 'Продолжить смену направлений' : 'Остановить смену направлений');
            pauseButton.textContent = userPaused ? '▷' : 'Ⅱ';
            startRotation();
        });
        carousel.addEventListener('mouseenter', () => {
            pointerInside = true;
            stopRotation();
        });
        carousel.addEventListener('mouseleave', () => {
            pointerInside = false;
            startRotation();
        });
        carousel.addEventListener('focusin', () => {
            focusInside = true;
            stopRotation();
        });
        carousel.addEventListener('focusout', (event) => {
            if (!carousel.contains(event.relatedTarget)) {
                focusInside = false;
                startRotation();
            }
        });
        document.addEventListener('visibilitychange', startRotation);
        reducedMotion.addEventListener?.('change', (event) => {
            if (event.matches) {
                userPaused = true;
                pauseButton?.setAttribute('aria-pressed', 'true');
                pauseButton?.setAttribute('aria-label', 'Продолжить смену направлений');
                if (pauseButton) pauseButton.textContent = '▷';
            }
            startRotation();
        });
        showSlide(0);
        startRotation();
    }
})();
