<article class="person friend-row contact-row" data-favorite="{{ $favorite ? '1' : '0' }}">
    @if($activeTab === 'friends')
        <label class="friend-select">
        <div class="friend-row-select">
                <input class="check" type="checkbox" name="friends[]" value="{{ $person['id'] }}" @checked($selected) wire:change="toggleSelection($event.target.checked)" aria-label="Выбрать {{ $person['first_name'] }}">
        </div>
        </label>
    @endif
    <div class="friend-row-account">
        @if($person['photo_100'])<img src="{{ $person['photo_100'] }}" alt="">@endif
        <div class="friend-row-identity">
            <div class="name">@if($person['domain'])<a href="https://vk.com/{{ $person['domain'] }}" target="_blank" rel="noopener">{{ $person['first_name'] }} {{ $person['last_name'] }}</a>@else{{ $person['first_name'] }} {{ $person['last_name'] }}@endif</div>
            @if(filled($person['phone'] ?? null))
                @php
                    $digits = preg_replace('/[^0-9]/', '', $person['phone']);
                    $telHref = $digits;
                    $telDisplay = strlen($digits) === 11 && preg_match('/^[78]/', $digits)
                        ? '8-' . substr($digits, 1, 3) . '-' . substr($digits, 4, 3) . '-' . substr($digits, 7, 2) . '-' . substr($digits, 9, 2)
                        : $person['phone'];
                @endphp
                <div class="friend-row-phone muted tiny">Телефон: <a href="tel:{{ $telHref }}">{{ $telDisplay }}</a></div>
            @endif
        </div>
    </div>
    <a class="friend-row-vk-id muted tiny" href="/history?vk_id={{ urlencode($person['id']) }}" target="_blank" rel="noopener" title="VK ID {{ $person['id'] }}">{{ $person['id'] }}</a>
    <div class="friend-row-favorite">
        <button type="button" class="favorite" wire:click="toggleFavorite" wire:loading.attr="disabled" wire:target="toggleFavorite">{{ $favorite ? '★ Убрать' : '☆ В избранное' }}</button>
        @if($favorite)<span class="star" title="Избранный">★</span>@endif
    </div>
    <div class="friend-row-comment">
        @if(filled($person['manager_comment']))<div class="comment">{{ $person['manager_comment'] }}</div>@endif
        <form class="comment-form" wire:submit="saveComment">
            <input type="text" maxlength="2000" wire:model.blur="commentDraft" placeholder="Комментарий">
            <button type="submit" class="button secondary tiny" wire:loading.attr="disabled" wire:target="saveComment">Сохранить</button>
        </form>
        @error('commentDraft')<span class="favorite-error tiny">{{ $message }}</span>@enderror
        @if($commentSaved)<span class="muted tiny">Сохранено</span>@endif
    </div>
    @if($activeTab === 'friends')<div class="friend-row-days" title="Друг с {{ $person['friend_since'] }}">{{ $person['friend_days'] }}</div>@endif
</article>
