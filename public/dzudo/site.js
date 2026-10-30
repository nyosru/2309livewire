(() => {
    const notice = document.getElementById('dev-notice');
    const close = document.getElementById('dev-notice-close');

    close?.addEventListener('click', () => {
        const collapsed = notice.classList.toggle('is-collapsed');
        close.setAttribute('aria-expanded', String(!collapsed));
        close.setAttribute('aria-label', collapsed ? 'Развернуть объявление' : 'Свернуть объявление');
    });
})();
