<div class="lead-card" id="signup">
    <p class="lead-card__label">Первый ход — ваш</p>
    <h2>Запишитесь<br>на тренировку</h2>

    @if($sent)
        <div class="form-success" role="status" aria-live="polite">
            <h3>Заявка отправлена</h3>
            <p>Спасибо! Александр Борисович свяжется с вами и подберёт время.</p>
            <button type="button" wire:click="$set('sent', false)">Отправить ещё одну</button>
        </div>
    @else
        <form wire:submit="submit" class="lead-form" novalidate>
            <label for="hero-phone">Телефон</label>
            <div class="lead-form__row">
                <input id="hero-phone" type="tel" wire:model="phone" placeholder="+7 900 000-00-00" inputmode="tel" autocomplete="tel">
                <button type="submit" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Обсудить занятие</span>
                    <span wire:loading wire:target="submit">Отправляем…</span>
                    <span aria-hidden="true">→</span>
                </button>
            </div>
            @error('phone') <span class="form-error">{{ $message }}</span> @enderror

            <div class="ttt-honeypot" aria-hidden="true">
                <label for="hero-website">Сайт</label>
                <input id="hero-website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            @error('form') <p class="form-submit-error" role="alert">{{ $message }}</p> @enderror
            <small>Перезвоним, узнаем ваш уровень и подберём время.</small>
        </form>
    @endif
</div>
