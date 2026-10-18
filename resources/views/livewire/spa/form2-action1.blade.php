<section class="final-cta" id="contact">
    <div class="ttt-shell final-cta__grid">
        <div>
            <p class="eyebrow">Хватит смотреть со стороны</p>
            <h2>Пора<br><em>к столу.</em></h2>
            <p>Оставьте номер — Александр Борисович уточнит цель, расскажет о формате и предложит удобное время.</p>
        </div>

        <form wire:submit.prevent="sendMsg" class="final-form">
            @if(session('message_ok'))
                <div class="form-success" role="alert">{{ session('message_ok') }}</div>
            @else
                <label for="footer-phone">Ваш телефон</label>
                <input id="footer-phone" type="text" wire:model="phone" placeholder="+7 900 000-00-00" autocomplete="tel">
                @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                <button type="submit">Записаться на занятие <span aria-hidden="true">→</span></button>
                <small>Или позвоните: <a href="tel:89222630618">8 922 263-06-18</a></small>
            @endif
        </form>
    </div>
</section>
