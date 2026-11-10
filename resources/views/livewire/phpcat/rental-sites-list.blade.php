<div class="rental-site-cards">
    @foreach ($sites as $index => $site)
        <article class="rental-site-card" wire:key="rental-site-{{ $site->id }}">
            <div class="rental-site-card-meta">
                <span class="rental-site-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}{{ $site->category ? ' / '.$site->category : '' }}</span>
                @if ($site->is_rented)
                    <span class="rental-site-rented"><span class="rental-site-rented-label">СДАН В АРЕНДУ</span></span>
                @endif
            </div>
            <div class="rental-site-content" style="--domain-chars: {{ \Illuminate\Support\Str::length($site->domain) }}">
                <h3><a class="rental-site-domain" href="{{ $site->url() }}" target="_blank" rel="noopener noreferrer">{{ $site->domain }}</a></h3>
                <p>{{ $site->description }}</p>
            </div>
            @unless ($site->is_rented)
                <button type="button" class="rental-request-button" wire:click="openRental({{ $site->id }})" wire:loading.attr="disabled" wire:target="openRental">Взять в&nbsp;аренду</button>
            @endunless
        </article>
    @endforeach
    <style>
        .rental-request-button{margin-top:22px;padding:12px 18px;border:1px solid rgba(255,255,255,.9);border-radius:10px;background:linear-gradient(110deg,#ffe600,#ffab24,#c08aff,#ffe600);background-size:300% 300%;color:#271336;font:inherit;font-size:16px;font-weight:800;cursor:pointer;box-shadow:0 6px 18px rgba(199,103,35,.3),inset 0 1px 0 #fff;animation:rental-button-colors 7s ease-in-out infinite alternate;transition:box-shadow .2s ease,filter .2s ease}
        .rental-request-button:hover{filter:brightness(1.06);box-shadow:0 8px 24px rgba(155,77,218,.4),inset 0 1px 0 #fff}.rental-request-button:disabled{opacity:.6;cursor:wait}
        @keyframes rental-button-colors{from{background-position:0% 50%}to{background-position:100% 50%}}
        @media(prefers-reduced-motion:reduce){.rental-request-button{animation:none;transition:none}}
        .rental-request-dialog{position:fixed;inset:0;width:min(520px,calc(100% - 32px));max-height:calc(100dvh - 32px);margin:auto;padding:28px;border:0;border-radius:20px;background:#f4f6f2;color:#172c3b;overflow:auto;font-size:16px;box-shadow:0 24px 80px #0004}
        .rental-request-dialog::backdrop{background:rgba(13,30,35,.65)}
        .rental-request-dialog h3{margin:0 36px 12px 0;font-size:26px;font-weight:800;line-height:1.2}
        .rental-request-dialog p{margin:0 0 20px;overflow-wrap:anywhere}
        .rental-request-close{position:absolute;top:14px;right:16px;border:0;background:transparent;font-size:28px;cursor:pointer;color:#294e44}
        .rental-request-dialog label{display:block;margin-top:18px;font-size:16px;font-weight:600}
        .rental-request-dialog input,.rental-request-dialog textarea{display:block;box-sizing:border-box;width:100%;margin-top:8px;padding:12px;border:1px solid #9bac9f;border-radius:8px;background:white;font:inherit;font-size:16px}
        .rental-request-dialog textarea{resize:vertical}.rental-request-error{margin-top:8px;color:#a12121;font-size:14px}
        .rental-request-dialog :focus-visible{outline:3px solid #43816f;outline-offset:3px}
    </style>
    <dialog class="rental-request-dialog" wire:ignore.self x-data
            x-on:rental-open.window="$el.showModal()"
            x-on:click="if ($event.target === $el) $el.close()"
            aria-labelledby="rental-request-title">
        <button type="button" class="rental-request-close" aria-label="Закрыть" x-on:click="$el.closest('dialog').close()">×</button>
        <h3 id="rental-request-title">Взять сайт в&nbsp;аренду</h3>
        <p>{{ $selectedSite?->domain }}</p>
        @if ($sent)
            <div role="status">Заявка отправлена! Мы&nbsp;свяжемся с&nbsp;вами по&nbsp;указанному телефону.</div>
            <button type="button" class="rental-request-button" x-on:click="$el.closest('dialog').close()">Закрыть</button>
        @else
            <form wire:submit="submit">
                <label for="rental-phone">Номер телефона</label>
                <input id="rental-phone" type="tel" wire:model="phone" autocomplete="tel" placeholder="+7 (999) 123-45-67" maxlength="25" required>
                @error('phone') <div class="rental-request-error" role="alert">{{ $message }}</div> @enderror
                <label for="rental-message">Сообщение</label>
                <textarea id="rental-message" wire:model="message" rows="4" maxlength="2000" placeholder="Расскажите о вашей задаче" required></textarea>
                @error('message') <div class="rental-request-error" role="alert">{{ $message }}</div> @enderror
                <div hidden aria-hidden="true"><input type="text" wire:model="website" tabindex="-1" autocomplete="off"></div>
                @error('form') <div class="rental-request-error" role="alert">{{ $message }}</div> @enderror
                <button type="submit" class="rental-request-button" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Отправить заявку</span>
                    <span wire:loading wire:target="submit">Отправляем…</span>
                </button>
            </form>
        @endif
    </dialog>
</div>
