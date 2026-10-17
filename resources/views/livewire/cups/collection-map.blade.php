<section class="relative w-full overflow-hidden bg-orange-50" aria-labelledby="cups-map-title">
    <div class="absolute left-0 top-0 m-4 max-w-[calc(100%-2rem)] rounded-2xl bg-white/95 px-5 py-3 shadow-lg backdrop-blur-sm md:m-6"
         style="z-index: 1100;">
        <h2 id="cups-map-title" class="text-lg font-bold text-gray-900 md:text-xl">
            География коллекции
        </h2>
        <p class="text-sm text-gray-600">
            {{ count($points) }} {{ $this->cupWord() }} из разных мест
        </p>
    </div>

    <div
        id="cups-collection-map"
        wire:ignore
        class="w-full bg-orange-100"
        style="height: clamp(360px, 56vh, 620px);"
        role="region"
        aria-label="Карта мест, откуда привезены кружки"
    ></div>

    <noscript>
        <p class="p-5 text-center">Для просмотра карты нужно включить JavaScript.</p>
    </noscript>

    @script
    <script>
        (() => {
            const container = document.getElementById('cups-collection-map');

            if (!container || container.dataset.initialized === 'true') {
                return;
            }

            const points = {{ Illuminate\Support\Js::from($points) }};

            const escapeHtml = (value) => String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const balloonContent = (point) => {
                const photo = point.photo
                    ? `<img src="${escapeHtml(point.photo)}" alt="" style="display:block;width:220px;max-width:100%;max-height:180px;object-fit:cover;border-radius:10px;margin-bottom:10px;">`
                    : '';
                const description = point.description
                    ? `<div style="margin-top:6px;color:#4b5563;">${escapeHtml(point.description)}</div>`
                    : '';
                const address = point.address
                    ? `<div style="margin-top:6px;color:#6b7280;">${escapeHtml(point.address)}</div>`
                    : '';

                return `${photo}<strong>${escapeHtml(point.name)}</strong>${address}${description}`;
            };

            const initialize = () => {
                if (container.dataset.initialized === 'true') {
                    return;
                }

                container.dataset.initialized = 'true';

                const map = window.L.map(container, {
                    center: [57.5, 65.5],
                    zoom: 3,
                    zoomControl: false,
                });

                window.L.control.zoom({ position: 'bottomright' }).addTo(map);
                window.L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                }).addTo(map);

                const bounds = [];

                points.forEach((point) => {
                    if (point.latitude === null || point.longitude === null) {
                        return;
                    }

                    const coordinates = [point.latitude, point.longitude];

                    window.L.marker(coordinates, { title: point.name })
                        .addTo(map)
                        .bindPopup(balloonContent(point), { maxWidth: 240 });

                    bounds.push(coordinates);
                });

                if (bounds.length > 0) {
                    map.fitBounds(bounds, {
                        paddingTopLeft: [40, 120],
                        paddingBottomRight: [40, 40],
                        maxZoom: 11,
                    });
                }

                if (window.matchMedia('(max-width: 767px)').matches) {
                    map.dragging.disable();
                }

                const resizeObserver = new ResizeObserver(() => {
                    map.invalidateSize({ pan: false });
                });

                resizeObserver.observe(container);
                window.setTimeout(() => map.invalidateSize({ pan: false }), 500);
            };

            const loadStylesheet = () => new Promise((resolve) => {
                let stylesheet = document.querySelector('link[data-cups-leaflet]');

                if (stylesheet?.sheet) {
                    resolve();
                    return;
                }

                if (!stylesheet) {
                    stylesheet = document.createElement('link');
                    stylesheet.rel = 'stylesheet';
                    stylesheet.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css';
                    stylesheet.dataset.cupsLeaflet = 'true';
                    document.head.appendChild(stylesheet);
                }

                stylesheet.addEventListener('load', resolve, { once: true });
                stylesheet.addEventListener('error', resolve, { once: true });
            });

            const loadScript = () => new Promise((resolve) => {
                if (window.L) {
                    resolve();
                    return;
                }

                let script = document.querySelector('script[data-cups-leaflet]');

                if (!script) {
                    script = document.createElement('script');
                    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
                    script.crossOrigin = '';
                    script.async = true;
                    script.dataset.cupsLeaflet = 'true';
                    document.head.appendChild(script);
                }

                script.addEventListener('load', resolve, { once: true });
            });

            Promise.all([loadStylesheet(), loadScript()]).then(() => {
                if (window.L) {
                    initialize();
                }
            });
        })();
    </script>
    @endscript
</section>
