(() => {
    'use strict';
    // Window state survives wire:navigate, but resets on a full document load.
    if (window.vkusnoDevelopmentRibbon) return;
    const state = window.vkusnoDevelopmentRibbon = { dismissed: false };
    function sync() {
        const ribbon = document.querySelector('[data-development-ribbon]');
        if (ribbon && state.dismissed) ribbon.hidden = true;
    }
    document.addEventListener('click', event => {
        const close = event.target.closest('[data-development-ribbon-close]');
        if (!close || state.dismissed) return;
        const ribbon = close.closest('[data-development-ribbon]');
        state.dismissed = true;
        close.disabled = true;
        ribbon.classList.add('is-dismissing');
        if (document.activeElement === close) close.blur();
        const finish = () => { ribbon.hidden = true; };
        ribbon.addEventListener('animationend', finish, { once: true });
        // Also finishes with reduced motion, or when animation is unavailable.
        window.setTimeout(finish, 400);
    });
    document.addEventListener('livewire:navigated', sync);
    sync();
})();
