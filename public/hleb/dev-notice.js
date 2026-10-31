(() => {
    'use strict';
    const notice = document.getElementById('dev-notice');
    const full = document.getElementById('dev-notice-full');
    const compact = document.getElementById('dev-notice-compact');
    const collapse = document.getElementById('dev-notice-close');
    const expand = document.getElementById('dev-notice-open');

    collapse.addEventListener('click', () => {
        notice.classList.add('is-collapsed');
        full.hidden = true;
        compact.hidden = false;
        collapse.setAttribute('aria-expanded', 'false');
        expand.setAttribute('aria-expanded', 'false');
    });

    expand.addEventListener('click', () => {
        notice.classList.remove('is-collapsed');
        compact.hidden = true;
        full.hidden = false;
        collapse.setAttribute('aria-expanded', 'true');
        expand.setAttribute('aria-expanded', 'true');
    });
})();
