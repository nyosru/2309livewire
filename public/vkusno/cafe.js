(() => {
    'use strict';
    const config = JSON.parse(document.getElementById('cafe-data').textContent);
    const catalog = new Map(config.products.map(p => [p.id, p]));
    const cartDialog = document.getElementById('cart-dialog');
    const cakeDialog = document.getElementById('cake-dialog');
    const orderForm = document.getElementById('order-form');
    const cakeForm = document.getElementById('cake-form');
    const productCards = [...document.querySelectorAll('[data-product-id]')];
    const header = document.querySelector('.header');
    const menuToggle = header.querySelector('.menu-toggle');
    const navigation = header.querySelector('nav');
    const compactHeader = window.matchMedia('(max-width: 1100px)');
    function setMenuOpen(open) {
        header.classList.toggle('is-menu-open', open);
        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'Закрыть меню' : 'Открыть меню');
    }
    menuToggle.addEventListener('click', () => setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true'));
    navigation.addEventListener('click', event => {
        if (event.target.closest('a')) setMenuOpen(false);
    });
    document.addEventListener('click', event => {
        if (!header.contains(event.target) || event.target.closest('[data-cart-open]')) setMenuOpen(false);
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
            setMenuOpen(false);
            menuToggle.focus();
        }
    });
    compactHeader.addEventListener('change', () => setMenuOpen(false));
    const money = amount => new Intl.NumberFormat('ru-RU').format(amount) + ' ₽';
    let cart = {};
    let cake = null;
    let submitting = false;
    try {
        const saved = JSON.parse(localStorage.getItem('vkusno-cart') || '{}');
        for (const [id, quantity] of Object.entries(saved.items || {})) {
            if (catalog.has(id) && Number.isInteger(quantity) && quantity >= 1 && quantity <= 30) cart[id] = quantity;
        }
        if (saved.cake && config.fillings.includes(saved.cake.filling) && Number.isFinite(saved.cake.weight) && saved.cake.weight >= 1 && saved.cake.weight <= 15) {
            cake = { filling: saved.cake.filling, weight: saved.cake.weight, design: String(saved.cake.design || '').slice(0, 2000) };
        }
    } catch (_) { /* A private browser or stale cart must not prevent ordering. */ }
    function save() {
        try { localStorage.setItem('vkusno-cart', JSON.stringify({items: cart, cake})); } catch (_) {}
    }
    function toast(message) {
        const el = document.getElementById('toast');
        el.textContent = message;
        el.classList.remove('is-leaving');
        el.hidden = false;
        positionToast();
        clearTimeout(toast.timer);
        toast.timer = setTimeout(() => { el.classList.add('is-leaving'); }, 2600);
    }
    document.getElementById('toast').addEventListener('animationend', event => {
        if (event.animationName === 'toast-slide-out' && event.currentTarget.classList.contains('is-leaving')) {
            event.currentTarget.hidden = true;
            event.currentTarget.classList.remove('is-leaving');
        }
    });
    function positionToast() {
        const el = document.getElementById('toast');
        if (el.hidden) return;
        const cartButton = header.querySelector('[data-cart-open]').getBoundingClientRect();
        const right = Math.max(12, window.innerWidth - cartButton.right);
        el.style.top = `${header.getBoundingClientRect().bottom + 12}px`;
        el.style.right = `${right}px`;
        el.style.setProperty('--toast-offset', `${right + 24}px`);
        el.style.maxWidth = `${Math.min(360, window.innerWidth - right - 12)}px`;
    }
    window.addEventListener('resize', positionToast);
    function element(tag, text, className) {
        const el = document.createElement(tag);
        if (text !== undefined) el.textContent = text;
        if (className) el.className = className;
        return el;
    }
    function render() {
        let subtotal = 0;
        let count = cake ? 1 : 0;
        const list = document.getElementById('cart-items');
        list.replaceChildren();
        for (const [id, quantity] of Object.entries(cart)) {
            const product = catalog.get(id);
            count += quantity;
            subtotal += product.price * quantity;
            const row = element('div', undefined, 'cart-row');
            const img = element('img'); img.src = '/vkusno/' + product.image; img.alt = product.name;
            const main = element('div', undefined, 'cart-row-main');
            main.append(element('h3', product.name), element('p', product.weight + ' × ' + quantity), element('p', money(product.price * quantity)));
            if (product.price_is_estimate) main.append(element('p', 'Цена предварительная'));
            const remove = element('button', 'Удалить', 'remove'); remove.type = 'button'; remove.setAttribute('aria-label', 'Удалить ' + product.name);
            remove.onclick = () => { delete cart[id]; save(); render(); };
            main.append(remove);
            const control = element('div', undefined, 'quantity');
            for (const [text, change] of [['−', -1], ['+', 1]]) {
                const button = element('button', text); button.type = 'button';
                button.setAttribute('aria-label', `${change === 1 ? 'Увеличить' : 'Уменьшить'} количество: ${product.name}`);
                button.disabled = change === 1 && quantity >= 30;
                button.onclick = () => { cart[id] += change; if (!cart[id]) delete cart[id]; save(); render(); };
                control.append(button);
                if (change === -1) control.append(element('span', String(quantity)));
            }
            row.append(img, main, control); list.append(row);
        }
        document.querySelectorAll('[data-cart-count]').forEach(el => { el.textContent = count; });
        productCards.forEach(card => {
            const quantity = cart[card.dataset.productId] || 0;
            card.querySelector('[data-product-cart-status]').hidden = quantity === 0;
            const counter = card.querySelector('[data-product-quantity]');
            counter.hidden = quantity === 0;
            counter.textContent = `${quantity} шт.`;
            card.querySelector('[data-subtract]').hidden = quantity === 0;
            card.querySelector('[data-add]').disabled = quantity >= 30;
        });
        document.getElementById('cart-empty').hidden = count !== 0;
        document.getElementById('cart-subtotal').textContent = money(subtotal);
        document.getElementById('submit-order').disabled = !count || submitting;
        const summary = document.getElementById('cake-summary'); summary.replaceChildren(); summary.hidden = !cake;
        if (cake) {
            summary.append(element('h3', 'Торт на заказ'), element('p', `${cake.filling} · ${cake.weight} кг\n${cake.design || 'Декор обсудим лично'}\nСтоимость уточняется`));
            const edit = element('button', 'Изменить', 'remove'); edit.type = 'button'; edit.onclick = openCake;
            const remove = element('button', 'Удалить торт', 'remove'); remove.type = 'button'; remove.style.marginLeft = '20px';
            remove.onclick = () => { cake = null; save(); render(); };
            summary.append(edit, remove);
        }
        orderForm.elements.requested_date.min = cake ? config.cakeDate : config.today;
        orderForm.elements.requested_date.required = !!cake;
        const delivery = orderForm.elements.fulfillment.value === 'delivery';
        document.getElementById('address-field').hidden = !delivery;
        orderForm.elements.address.required = delivery;
    }
    function openCart() {
        document.getElementById('order-success').hidden = true;
        orderForm.hidden = false;
        render();
        if (!cartDialog.open) cartDialog.showModal();
    }
    function openCake() {
        if (cartDialog.open) cartDialog.close();
        if (cake) {
            for (const key of ['filling', 'weight', 'design']) cakeForm.elements[key].value = cake[key];
        }
        cakeDialog.showModal();
    }
    document.querySelectorAll('[data-cart-open]').forEach(el => el.onclick = openCart);
    document.querySelectorAll('[data-cake-open]').forEach(el => el.onclick = openCake);
    document.querySelectorAll('[data-close]').forEach(el => el.onclick = () => el.closest('dialog').close());
    document.querySelectorAll('dialog').forEach(dialog => dialog.addEventListener('click', event => {
        if (event.target !== dialog) return;
        const bounds = dialog.getBoundingClientRect();
        if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
    }));
    document.querySelectorAll('[data-add]').forEach(button => button.onclick = () => {
        const id = button.dataset.add;
        if ((cart[id] || 0) >= 30) return toast('В корзине уже 30 порций этого блюда');
        cart[id] = (cart[id] || 0) + 1;
        save(); render(); toast(`${catalog.get(id).name} — добавлено в корзину`);
    });
    document.querySelectorAll('[data-subtract]').forEach(button => button.onclick = () => {
        const id = button.dataset.subtract;
        if (!cart[id]) return;
        cart[id] -= 1;
        if (!cart[id]) delete cart[id];
        save(); render();
        if (!cart[id]) button.closest('.product-quantity').querySelector('[data-add]').focus();
    });
    document.querySelectorAll('[data-menu-block]').forEach(block => {
        let category = 'all';
        let limit = 12;
        const cards = [...block.querySelectorAll('[data-product-category]')];
        const more = block.querySelector('[data-menu-show-more]');
        function updateMenu() {
            const matching = cards.filter(card => category === 'all' || card.dataset.productCategory === category);
            cards.forEach(card => { card.hidden = true; });
            matching.slice(0, limit).forEach(card => { card.hidden = false; });
            block.querySelector('[data-menu-count]').textContent = `Позиций: ${matching.length}`;
            if (more) {
                more.hidden = matching.length <= limit;
                more.textContent = `Показать ещё (${matching.length - limit})`;
            }
        }
        block.querySelectorAll('[data-category]').forEach(button => button.onclick = () => {
            category = button.dataset.category;
            limit = 12;
            block.querySelectorAll('[data-category]').forEach(el => {
                const active = el === button;
                el.classList.toggle('active', active); el.setAttribute('aria-pressed', active);
            });
            updateMenu();
        });
        if (more) more.onclick = () => { limit += 12; updateMenu(); };
        updateMenu();
    });
    orderForm.addEventListener('change', event => {
        if (event.target.name !== 'fulfillment') return;
        const delivery = orderForm.elements.fulfillment.value === 'delivery';
        document.getElementById('address-field').hidden = !delivery;
        orderForm.elements.address.required = delivery;
    });
    cakeForm.onsubmit = event => {
        event.preventDefault();
        cake = {filling: cakeForm.elements.filling.value, weight: Number(cakeForm.elements.weight.value), design: cakeForm.elements.design.value};
        save(); cakeDialog.close(); openCart();
    };
    orderForm.onsubmit = async event => {
        event.preventDefault();
        if (submitting) return;
        const error = document.getElementById('order-error'); error.hidden = true;
        const data = Object.fromEntries(new FormData(orderForm));
        data.items = Object.entries(cart).map(([id, quantity]) => ({id, quantity}));
        data.consent = orderForm.elements.consent.checked;
        if (cake) data.cake = cake;
        if (!data.requested_date) delete data.requested_date;
        submitting = true; render();
        const submit = document.getElementById('submit-order'); submit.textContent = 'Отправляем…';
        try {
            const response = await fetch('/orders', {method: 'POST', headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}, body: JSON.stringify(data)});
            const result = await response.json().catch(() => ({}));
            if (!response.ok) {
                if (response.status === 419) throw new Error('Сессия истекла. Обновите страницу — корзина сохранится.');
                if (response.status === 429) throw new Error('Слишком много заявок. Подождите минуту и попробуйте снова.');
                throw new Error(result.errors ? Object.values(result.errors).flat().join(' ') : 'Не удалось отправить заявку. Попробуйте позже.');
            }
            cart = {}; cake = null; save(); render(); orderForm.reset(); orderForm.hidden = true;
            const success = document.getElementById('order-success'); success.replaceChildren(element('h3', 'Спасибо за заявку!'), element('p', result.message), element('p', 'Номер: ' + result.reference)); success.hidden = false;
        } catch (problem) {
            error.textContent = problem.message || 'Проверьте подключение к интернету и попробуйте снова.'; error.hidden = false;
        } finally {
            submitting = false; render(); submit.replaceChildren(document.createTextNode('Отправить заявку '), element('span', '↗'));
        }
    };
    render();
})();
