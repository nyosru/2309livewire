(() => {
    'use strict';
    const notice = document.getElementById('dev-notice');
    document.getElementById('dev-notice-close').addEventListener('click', () => {
        notice.hidden = true;
    });
})();
