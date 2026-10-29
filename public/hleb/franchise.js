(() => {
    'use strict';
    const privacy = document.getElementById('fr-privacy');
    document.querySelectorAll('[data-fr-privacy], [data-privacy-open]').forEach(button => button.addEventListener('click', () => privacy.showModal()));
    document.querySelector('[data-fr-close]').addEventListener('click', () => privacy.close());
    privacy.addEventListener('click', event => { if (event.target === privacy) { const rect = privacy.getBoundingClientRect(); if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) privacy.close(); } });
    const form = document.querySelector('[data-franchise-form]');
    form.addEventListener('submit', async event => {
        event.preventDefault();
        const button = form.querySelector('[type="submit"]');
        if (button.disabled) return;
        const status = form.querySelector('.form-status');
        const data = Object.fromEntries(new FormData(form));
        data.type = 'franchise'; data.consent = form.elements.consent.checked;
        button.disabled = true; status.classList.remove('error'); status.textContent = 'Сохраняем заявку…';
        const abort = new AbortController(), timeout = setTimeout(() => abort.abort(), 20000);
        try {
            const response = await fetch('/requests', {method: 'POST', credentials: 'same-origin', signal: abort.signal, headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, body: JSON.stringify(data)});
            if (!response.ok) throw new Error(response.status === 422 ? 'Проверьте имя, телефон, город и согласие.' : response.status === 429 ? 'Слишком много заявок. Попробуйте через минуту.' : response.status === 419 ? 'Обновите страницу и повторите отправку.' : 'Не удалось сохранить заявку. Попробуйте позже или позвоните нам.');
            form.reset(); status.textContent = 'Спасибо! Заявка сохранена.';
        } catch (error) {
            status.classList.add('error'); status.textContent = error.name === 'AbortError' || error instanceof TypeError ? 'Нет ответа от сервера. Уточните заявку по телефону.' : error.message;
        } finally { clearTimeout(timeout); button.disabled = false; }
    });
})();
