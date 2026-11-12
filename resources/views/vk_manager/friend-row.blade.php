<article class="person friend-row" data-favorite="{{ $person['manager_favorite'] ? '1' : '0' }}">
    <div class="friend-row-select">
        <label class="friend-select">
            <input class="check" type="checkbox" name="friends[]" value="{{ $person['id'] }}" aria-label="Выбрать {{ $person['first_name'] }}">
        </label>
    </div>
    <div class="friend-row-account">
        @if(!empty($person['photo_100']))
            <img src="{{ $person['photo_100'] }}" alt="">
        @endif
        <div>
            <div class="name">
                @if(!empty($person['domain']))
                    <a href="https://vk.com/{{ $person['domain'] }}" target="_blank" rel="noopener">{{ $person['first_name'] }} {{ $person['last_name'] }}</a>
                @else
                    {{ $person['first_name'] }} {{ $person['last_name'] }}
                @endif
            </div>
            <div class="muted tiny">VK ID {{ $person['id'] }}</div>
        </div>
    </div>
    <div class="friend-row-favorite">
        <form class="favorite-form" method="post" action="/friends/{{ $person['id'] }}/favorite">
            @csrf
            <input type="hidden" name="is_favorite" value="{{ $person['manager_favorite'] ? 0 : 1 }}">
            <button class="favorite">{{ $person['manager_favorite'] ? '★ Убрать' : '☆ В избранное' }}</button>
            <span class="favorite-error tiny" role="status"></span>
        </form>
    </div>
    <div class="friend-row-comment">
        @if(filled($person['manager_comment']))
            <div class="comment">{{ $person['manager_comment'] }}</div>
        @endif
        <form class="comment-form" method="post" action="/friends/{{ $person['id'] }}/comment">
            @csrf
            <input name="comment" maxlength="2000" value="{{ $person['manager_comment'] }}" placeholder="Комментарий">
            <button class="button secondary tiny">Сохранить</button>
        </form>
    </div>
</article>
