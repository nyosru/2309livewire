
function scrollto(selector){
    // ev.stopPropagation();
    // const selector = ev?.detail?.query;

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

};
