import './bootstrap';

window.addEventListener('your-prefix:scroll-to', (ev) => {
    ev.stopPropagation();

    const selector = ev?.detail?.query;

    if (!selector) {
        return;
    }

    const el = window.document.querySelector(selector);

    if (!el) {
        return;
    }

    try {
        el.scrollIntoView({
            behavior: 'smooth',
        });
    } catch {}

}, false);
