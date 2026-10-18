document.addEventListener('DOMContentLoaded', () => {
    const modal = document.querySelector('#consultationModal');
    const form = document.querySelector('#consultationForm');
    const formStep = modal?.querySelector('.modal-form-step');
    const successStep = modal?.querySelector('.modal-success');
    const projectField = document.querySelector('#projectField');

    document.querySelectorAll('.js-open-modal').forEach((button) => {
        button.addEventListener('click', () => {
            if (projectField) projectField.value = button.dataset.project || '';
            if (formStep) formStep.hidden = false;
            if (successStep) successStep.hidden = true;
            modal?.showModal();
        });
    });

    modal?.querySelector('.modal-close')?.addEventListener('click', () => modal.close());
    modal?.querySelector('.modal-done')?.addEventListener('click', () => modal.close());
    modal?.addEventListener('click', (event) => {
        const rect = modal.getBoundingClientRect();
        const outside = event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom;
        if (outside) modal.close();
    });

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const submit = form.querySelector('[type="submit"]');
        const original = submit.innerHTML;
        submit.disabled = true;
        submit.textContent = 'Отправляем…';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
            });
            if (!response.ok) throw new Error('Request failed');
            form.reset();
            formStep.hidden = true;
            successStep.hidden = false;
        } catch (error) {
            submit.textContent = 'Не получилось. Попробовать ещё раз';
            submit.disabled = false;
            return;
        }

        submit.innerHTML = original;
        submit.disabled = false;
    });

    document.querySelectorAll('.js-project-gallery').forEach((gallery) => {
        const image = gallery.querySelector('img');
        const images = gallery.dataset.images.split('|');
        const bars = gallery.querySelectorAll('.gallery-progress i');
        const show = (index) => {
            if (image.src.endsWith(images[index])) return;
            image.style.opacity = '0';
            window.setTimeout(() => {
                image.src = images[index];
                image.style.opacity = '1';
            }, 120);
            bars.forEach((bar, i) => bar.classList.toggle('active', i === index));
        };
        gallery.querySelectorAll('[data-image]').forEach((zone) => {
            zone.addEventListener('mouseenter', () => show(Number(zone.dataset.image)));
            zone.addEventListener('focus', () => show(Number(zone.dataset.image)));
            zone.addEventListener('click', () => show(Number(zone.dataset.image)));
        });
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {threshold: .08});
    document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
});
