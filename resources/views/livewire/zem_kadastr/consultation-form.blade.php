<div class="zem-form-card">
    @if ($sent)
        <div class="zem-form-success" role="status">
            <span>✓</span>
            <p class="zem-kicker"><i></i> Заявка отправлена</p>
            <h3>Спасибо! Заявка принята.</h3>
            <p>Свяжемся выбранным способом, уточним детали и предложим понятный следующий шаг.</p>
            <button type="button" wire:click="$set('sent', false)">Отправить ещё одну заявку</button>
        </div>
    @else
        <form wire:submit="submit" novalidate>
            <div class="zem-form-title"><span>Заявка на консультацию</span><small>Ответим в рабочее время</small></div>

            <div class="zem-form-row">
                <div class="zem-field">
                    <label for="zem-name">Как к вам обращаться</label>
                    <input id="zem-name" type="text" wire:model="name" autocomplete="name" placeholder="Имя">
                    @error('name') <span class="zem-field-error">{{ $message }}</span> @enderror
                </div>
                <div class="zem-field">
                    <label for="zem-phone">Номер телефона</label>
                    <input id="zem-phone" type="tel" wire:model="phone" inputmode="tel" autocomplete="tel" placeholder="+7 999 000-00-00">
                    @error('phone') <span class="zem-field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="zem-field">
                <label for="zem-service">Что нужно сделать</label>
                <select id="zem-service" wire:model="service">
                    <option>Не знаю, нужна консультация</option>
                    <option>Межевание участка</option>
                    <option>Уточнение или вынос границ</option>
                    <option>Раздел или объединение участка</option>
                    <option>Оформление права собственности</option>
                    <option>Земельный спор / помощь юриста</option>
                    <option>Другое</option>
                </select>
                @error('service') <span class="zem-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="zem-field">
                <label for="zem-question">Коротко о ситуации <small>необязательно</small></label>
                <textarea id="zem-question" wire:model="question" rows="4" maxlength="2000" placeholder="Например: в выписке ЕГРН нет координат границ"></textarea>
                @error('question') <span class="zem-field-error">{{ $message }}</span> @enderror
            </div>

            <fieldset class="zem-field zem-contact-field">
                <legend>Как удобнее ответить?</legend>
                <div class="zem-contact-options">
                    <label><input type="radio" wire:model="contactMethod" value="call"><span>Звонок</span></label>
                    <label><input type="radio" wire:model="contactMethod" value="telegram"><span>Telegram</span></label>
                    <label><input type="radio" wire:model="contactMethod" value="whatsapp"><span>WhatsApp</span></label>
                </div>
                @error('contactMethod') <span class="zem-field-error">{{ $message }}</span> @enderror
            </fieldset>

            <div class="zem-honeypot" aria-hidden="true"><label for="zem-website">Ваш сайт</label><input id="zem-website" type="text" wire:model="website" tabindex="-1" autocomplete="off"></div>

            <button class="zem-button zem-submit" type="submit" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Получить план действий <b>→</b></span>
                <span wire:loading wire:target="submit">Отправляем…</span>
            </button>
            @error('form') <p class="zem-form-error" role="alert">{{ $message }}</p> @enderror
            <p class="zem-form-note">Нажимая кнопку, вы соглашаетесь на обработку данных для ответа на заявку.</p>
        </form>
    @endif
</div>
