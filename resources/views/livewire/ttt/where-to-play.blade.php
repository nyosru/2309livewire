<section class="places" id="where-to-play" aria-labelledby="places-title">
    <div class="ttt-shell">
        <div class="section-heading section-heading--light">
            <p class="eyebrow">Куда после тренировки</p>
            <h2 id="places-title">Где поиграть<br>в Тюмени</h2>
            <p class="section-lead">Подборка клубов в разных районах города — от спортивных залов до мест с кухней и VIP-комнатами.</p>
        </div>

        <div class="places-grid">
            @foreach($clubs as $index => $club)
                <article class="place-card">
                    <div class="place-card__photo">
                        <img src="{{ $club->image_url }}" alt="{{ $club->name }} — бильярдный клуб в Тюмени" loading="lazy">
                        <span class="place-card__number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="place-card__body">
                        <p class="place-card__type">{{ $club->type }}</p>
                        <h3>{{ $club->name }}</h3>
                        <dl class="place-card__facts">
                            <div><dt>Адрес</dt><dd>{{ $club->address }}</dd></div>
                            <div><dt>Часы</dt><dd>{{ $club->hours }}</dd></div>
                        </dl>
                        <a class="place-card__link" href="{{ $club->map_url }}" target="_blank" rel="noopener noreferrer">
                            Открыть в 2ГИС <span aria-hidden="true">↗</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="places-note">Режим работы собран по открытым данным в октябре 2026 года. Перед поездкой лучше проверить часы работы в карточке клуба.</p>
    </div>
</section>
