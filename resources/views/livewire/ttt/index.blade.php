<div>
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

            <livewire:ttt.hero-lead-form/>
        </div>
    </section>

    <section class="method" aria-labelledby="method-title">
        <div class="ttt-shell method__grid">
            <div class="section-heading">
                <p class="eyebrow">Метод Коновалова</p>
                <h2 id="method-title">Не бейте<br>наугад.</h2>
                <p class="section-lead">Хорошая игра начинается не с силы. Она начинается с понятной системы движений и решений.</p>
            </div>
            <ol class="method-list">
                <li><span>01</span><div><b>Ставим технику</b><p>Стойка, хват, мост, ровный вынос кия и стабильный удар.</p></div></li>
                <li><span>02</span><div><b>Учимся видеть стол</b><p>Прицеливание, резка, выходы и выбор правильного продолжения.</p></div></li>
                <li><span>03</span><div><b>Собираем свою игру</b><p>Практика, разбор ошибок и спокойствие в каждой партии.</p></div></li>
            </ol>
        </div>
    </section>

    <livewire:ttt.smi-list/>
    <livewire:ttt.where-to-play/>

    <section class="final-cta" id="contact">
        <div class="ttt-shell final-cta__grid">
            <div>
                <p class="eyebrow">Хватит смотреть со стороны</p>
                <h2>Пора<br><em>к столу.</em></h2>
                <p>Оставьте номер — Александр Борисович уточнит цель, расскажет о формате и предложит удобное время.</p>
            </div>

            <livewire:ttt.bottom-lead-form/>
        </div>
    </section>

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Service",
          "name": "Обучение бильярду",
          "description": "Индивидуальные занятия по бильярду в Тюмени с Александром Коноваловым.",
          "provider": {
            "@type": "LocalBusiness",
            "name": "Школа бильярда Александра Коновалова — TTT72",
            "url": "https://ttt72.ru",
            "telephone": "+7-922-263-06-18",
            "address": {"@type": "PostalAddress", "addressLocality": "Тюмень", "addressCountry": "RU"}
          },
          "areaServed": "Тюмень"
        }
    </script>
</div>
