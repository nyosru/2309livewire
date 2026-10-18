<section class="hero">
    <div class="hero__photo" aria-hidden="true"></div>
    <div class="hero__shade" aria-hidden="true"></div>
    <div class="ttt-shell hero__inner">
        <div class="hero__copy">
            <p class="eyebrow">Школа бильярда · Тюмень</p>
            <h1>Удар,<br><em>которому</em><br>веришь.</h1>
            <p class="hero__lead">Поставим стойку, прицел и технику. Научим читать стол и спокойно выигрывать — с нуля или с вашего текущего уровня.</p>
            <div class="hero__facts" aria-label="Ключевые преимущества">
                <span><b>2 часа</b> одно занятие</span>
                <span><b>1 на 1</b> с тренером</span>
                <span><b>с 2006</b> тренерская практика</span>
            </div>
        </div>

        <div class="lead-card" id="signup">
            <p class="lead-card__label">Первый ход — ваш</p>
            <h2>Запишитесь<br>на тренировку</h2>
            @if(session('message_ok'))
                <div class="form-success" role="alert">{{ session('message_ok') }}</div>
            @else
                <form wire:submit.prevent="sendMsg" class="lead-form">
                    <label for="hero-phone">Телефон</label>
                    <div class="lead-form__row">
                        <input id="hero-phone" type="text" wire:model="phone" placeholder="+7 900 000-00-00" autocomplete="tel">
                        <button type="submit">Обсудить занятие <span aria-hidden="true">→</span></button>
                    </div>
                    @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                    <small>Перезвоним, узнаем ваш уровень и подберём время.</small>
                </form>
            @endif
        </div>
    </div>
</section>
