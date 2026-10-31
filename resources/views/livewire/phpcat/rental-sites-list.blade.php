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
        </article>
    @endforeach
</div>
