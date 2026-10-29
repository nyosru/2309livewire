(() => {
    'use strict';
    const devNotice = document.getElementById('dev-notice');
    try { if (sessionStorage.getItem('hleb-dev-notice-dismissed') === '1') devNotice.hidden = true; } catch (_) {}
    document.getElementById('dev-notice-close').addEventListener('click', () => {
        devNotice.hidden = true;
        try { sessionStorage.setItem('hleb-dev-notice-dismissed', '1'); } catch (_) {}
    });
    const products = JSON.parse(document.querySelector('#catalog-data').textContent);
    const catalog = new Map(products.map(p => [p.id, p]));
    const money = value => new Intl.NumberFormat('ru-RU').format(value) + ' ₽';
    let cart = {};
    try {
        const saved = JSON.parse(localStorage.getItem('hleb-cart-v1') || '{}');
        for (const [id, quantity] of Object.entries(saved || {})) {
            if (catalog.has(id) && Number.isInteger(quantity) && quantity > 0 && quantity <= 99) cart[id] = quantity;
        }
    } catch (_) { /* Storage can be unavailable in private mode. */ }
    function persist() { try { localStorage.setItem('hleb-cart-v1', JSON.stringify(cart)); } catch (_) {} }
    function element(tag, className, content) {
        const node = document.createElement(tag); node.className = className; node.textContent = content; return node;
    }
    function renderCart() {
        const rows = document.querySelector('#cart-items'); rows.replaceChildren();
        let total = 0, count = 0;
        for (const [id, quantity] of Object.entries(cart)) {
            const p = catalog.get(id); total += p.price * quantity; count += quantity;
            const row = element('div', 'cart-row', '');
            const info = element('div', '', '');
            info.append(element('h3', '', p.name), element('small', '', `${p.weight} · ${money(p.price * quantity)}`));
            const controls = element('div', 'quantity', '');
            for (const [label, delta] of [['−', -1], ['+', 1]]) {
                const button = element('button', '', label);
                button.type = 'button'; button.setAttribute('aria-label', `${delta < 0 ? 'Уменьшить' : 'Увеличить'} количество: ${p.name}`);
                button.disabled = delta > 0 && quantity >= 99;
                button.addEventListener('click', () => { cart[id] += delta; if (!cart[id]) delete cart[id]; persist(); renderCart(); });
                controls.append(button);
                if (delta < 0) controls.append(element('span', '', quantity));
            }
            row.append(info, controls); rows.append(row);
        }
        document.querySelectorAll('[data-product-controls]').forEach(controls => {
            const quantity = cart[controls.dataset.productControls] || 0;
            const minus = controls.querySelector('[data-decrease]');
            const number = controls.querySelector('[data-product-count]');
            const plus = controls.querySelector('[data-add]');
            minus.hidden = number.hidden = quantity === 0;
            number.textContent = quantity;
            plus.disabled = quantity >= 99;
            plus.setAttribute('aria-label', `${quantity ? 'Увеличить количество' : 'Добавить'}: ${catalog.get(controls.dataset.productControls).name}`);
        });
        document.querySelectorAll('[data-cart-count]').forEach(node => node.textContent = count);
        document.querySelector('#cart-total').textContent = money(total);
        document.querySelector('#cart-summary').hidden = !count;
        document.querySelector('#cart-empty').hidden = !!count;
    }
    function openDialog(id) { document.getElementById(id).showModal(); document.body.classList.add('modal-open'); }
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('close', () => { if (!document.querySelector('dialog[open]')) document.body.classList.remove('modal-open'); });
        dialog.addEventListener('click', event => { if (event.target === dialog) { const r = dialog.getBoundingClientRect(); if (event.clientX < r.left || event.clientX > r.right || event.clientY < r.top || event.clientY > r.bottom) dialog.close(); } });
    });
    document.querySelectorAll('[data-close]').forEach(button => button.addEventListener('click', () => button.closest('dialog').close()));
    document.querySelectorAll('[data-cart-open]').forEach(button => button.addEventListener('click', () => openDialog('cart-dialog')));
    document.querySelectorAll('[data-franchise-open]').forEach(button => button.addEventListener('click', () => openDialog('franchise-dialog')));
    document.querySelectorAll('[data-privacy-open]').forEach(button => button.addEventListener('click', () => openDialog('privacy-dialog')));
    let toastTimer;
    document.querySelectorAll('[data-add]').forEach(button => button.addEventListener('click', () => {
        const id = button.dataset.add;
        if ((cart[id] || 0) >= 99) return;
        cart[id] = (cart[id] || 0) + 1; persist(); renderCart();
        const toast = document.querySelector('#toast');
        const link = element('a', 'toast-cart-link', 'в корзине');
        link.href = '#cart-dialog';
        link.addEventListener('click', event => {
            event.preventDefault();
            clearTimeout(toastTimer); toast.classList.remove('visible');
            openDialog('cart-dialog');
        });
        toast.replaceChildren(document.createTextNode('Товар '), link);
        toast.classList.add('visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { if (!toast.matches(':hover') && !toast.contains(document.activeElement)) toast.classList.remove('visible'); }, 7000);
    }));
    document.querySelectorAll('[data-decrease]').forEach(button => button.addEventListener('click', () => {
        const id = button.dataset.decrease;
        if (!cart[id]) return;
        cart[id] -= 1;
        if (!cart[id]) delete cart[id];
        persist(); renderCart();
        if (!cart[id]) document.querySelector(`[data-add="${id}"]`).focus();
    }));
    const toast = document.querySelector('#toast');
    toast.addEventListener('mouseleave', () => { if (!toast.contains(document.activeElement)) toast.classList.remove('visible'); });
    toast.addEventListener('focusout', event => { if (!toast.contains(event.relatedTarget)) toast.classList.remove('visible'); });
    let category = 'all', expanded = false;
    function filter() {
        const query = document.querySelector('#product-search').value.trim().toLocaleLowerCase('ru');
        let count = 0;
        document.querySelectorAll('.product').forEach(card => {
            const matches = (category === 'all' || card.dataset.category === category) && card.dataset.name.includes(query);
            card.hidden = !matches || (!expanded && count >= 8);
            if (matches) count++;
        });
        document.querySelector('#no-products').hidden = count > 0;
        document.querySelector('#show-more').hidden = expanded || count <= 8;
    }
    document.querySelectorAll('button[data-category]').forEach(button => button.addEventListener('click', () => {
        category = button.dataset.category; expanded = false;
        document.querySelectorAll('button[data-category]').forEach(node => { const active = node === button; node.classList.toggle('active', active); node.setAttribute('aria-pressed', String(active)); });
        filter();
    }));
    document.querySelector('#product-search').addEventListener('input', () => { expanded = false; filter(); });
    document.querySelector('#show-more').addEventListener('click', () => { expanded = true; filter(); });
    document.querySelectorAll('[data-request-form]').forEach(form => form.addEventListener('submit', async event => {
        event.preventDefault();
        const status = form.querySelector('.form-status'), button = form.querySelector('[type="submit"]');
        if (button.disabled) return;
        const data = Object.fromEntries(new FormData(form)); data.type = form.dataset.requestForm; data.consent = form.elements.consent.checked;
        if (data.type === 'order') { data.items = Object.entries(cart).map(([id, quantity]) => ({id, quantity})); if (!data.items.length) return; }
        button.disabled = true; status.classList.remove('error'); status.textContent = 'Сохраняем заявку…';
        const abort = new AbortController(), timeout = setTimeout(() => abort.abort(), 20000);
        try {
            const response = await fetch('/requests', {method: 'POST', credentials: 'same-origin', signal: abort.signal, headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, body: JSON.stringify(data)});
            const result = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(response.status === 422 ? 'Проверьте заполнение имени, телефона, города и согласия.' : response.status === 429 ? 'Слишком много заявок. Попробуйте через минуту.' : response.status === 419 ? 'Обновите страницу и повторите отправку. Корзина сохранится.' : 'Не удалось сохранить заявку. Попробуйте позже или позвоните нам.');
            form.reset();
            if (data.type === 'order') {
                cart = {}; persist(); renderCart();
                document.getElementById('cart-dialog').close();
                const toast = document.querySelector('#toast');
                toast.textContent = 'Спасибо! Заявка сохранена.'; toast.classList.add('visible');
                clearTimeout(toastTimer); toastTimer = setTimeout(() => toast.classList.remove('visible'), 6000);
            }
            status.textContent = `Спасибо! ${result.message}`;
        } catch (error) {
            status.classList.add('error'); status.textContent = error.name === 'AbortError' || error instanceof TypeError ? 'Нет ответа от сервера. Проверьте соединение; при сомнениях уточните заявку по телефону.' : error.message;
        } finally { clearTimeout(timeout); button.disabled = false; }
    }));
    renderCart(); filter();
})();
