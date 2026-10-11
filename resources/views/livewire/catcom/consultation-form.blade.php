<div class="cat-consult-card">
    @if ($sent)
        <div class="cat-consult-success" role="status">
            <span class="cat-success-icon">✓</span>
            <p class="cat-eyebrow">Вопрос отправлен</p>
            <h3>Спасибо! Скоро свяжемся.</h3>
            <p>Ответим тем способом, который вы выбрали.</p>
            <button class="cat-text-button" type="button" wire:click="$set('sent', false)">Задать ещё вопрос</button>
        </div>
    @else
        <form wire:submit="submit" novalidate>
            <div class="cat-field">
                <label for="consult-phone">Номер телефона</label>
                <input
                    id="consult-phone"
                    type="tel"
                    wire:model="phone"
                    inputmode="tel"
                    autocomplete="tel"
                    placeholder="+7 999 000-00-00"
                    aria-describedby="consult-phone-error"
                >
                @error('phone') <span class="cat-field-error" id="consult-phone-error">{{ $message }}</span> @enderror
            </div>

            <fieldset class="cat-field">
                <legend>Как лучше ответить?</legend>
                <div class="cat-contact-options">
                    <label class="cat-contact-option">
                        <input type="radio" wire:model="contactMethod" value="call">
                        <span class="cat-radio-mark"></span>
                        <span><b>Позвонить</b><small>Обсудим голосом</small></span>
                    </label>
                    <label class="cat-contact-option">
                        <input type="radio" wire:model="contactMethod" value="max">
                        <span class="cat-radio-mark"></span>
                        <span><b>Написать в MAX</b><small>Ответим сообщением</small></span>
                    </label>
                </div>
                @error('contactMethod') <span class="cat-field-error">{{ $message }}</span> @enderror
            </fieldset>

            <div class="cat-field">
                <label for="consult-question">Ваш первый вопрос</label>
                <textarea
                    id="consult-question"
                    wire:model="question"
                    rows="5"
                    maxlength="2000"
                    placeholder="Например: как перенести наши задачи в одну систему?"
                    aria-describedby="consult-question-error"
                ></textarea>
                @error('question') <span class="cat-field-error" id="consult-question-error">{{ $message }}</span> @enderror
            </div>

            <div class="cat-honeypot" aria-hidden="true">
                <label for="consult-website">Ваш сайт</label>
                <input id="consult-website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <button class="cat-button cat-submit" type="submit" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Получить бесплатную консультацию →</span>
                <span wire:loading wire:target="submit">Отправляем…</span>
            </button>
            @error('form') <p class="cat-form-error" role="alert">{{ $message }}</p> @enderror
            <p class="cat-form-note">Нажимая кнопку, вы разрешаете обработать данные для ответа на вопрос.</p>
        </form>
    @endif
</div>
