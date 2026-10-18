<div class="final-form">
    @if($sent)
        <div class="form-success" role="status" aria-live="polite">
            <h3>Заявка отправлена</h3>
            <p>Спасибо! Александр Борисович скоро свяжется с вами.</p>
            <button type="button" wire:click="$set('sent', false)">Отправить ещё одну</button>
        </div>
    @else
        <form wire:submit="submit" novalidate>
            <label for="footer-phone">Ваш телефон</label>
            <input id="footer-phone" type="tel" wire:model="phone" placeholder="+7 900 000-00-00" inputmode="tel" autocomplete="tel">
            @error('phone') <span class="form-error">{{ $message }}</span> @enderror

            <div class="ttt-honeypot" aria-hidden="true">
                <label for="footer-website">Сайт</label>
                <input id="footer-website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            @error('form') <p class="form-submit-error" role="alert">{{ $message }}</p> @enderror
            <button type="submit" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Записаться на занятие</span>
                <span wire:loading wire:target="submit">Отправляем…</span>
                <span aria-hidden="true">→</span>
            </button>
            <small>Или позвоните: <a href="tel:89222630618">8 922 263-06-18</a></small>
        </form>
    @endif
</div>
