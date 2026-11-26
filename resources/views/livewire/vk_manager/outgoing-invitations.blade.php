<section>
    <form class="panel" wire:submit="prepareList">
        <h2 style="margin:0 0 12px">Фильтры поиска</h2>
        <div class="filters">
            <div class="field"><label for="city">Город</label><input id="city" type="text" wire:model="city" placeholder="Например, Тюмень"></div>
            <div class="field"><label for="sex">Пол</label><select id="sex" wire:model="sex"><option value="">Любой</option><option value="2">Женский</option><option value="1">Мужской</option></select></div>
            <div class="field"><label for="age-from">Минимальный возраст</label><input id="age-from" type="number" min="14" max="100" wire:model="ageFrom" placeholder="Не задан"></div>
            <div class="field"><label for="age-to">Максимальный возраст</label><input id="age-to" type="number" min="14" max="100" wire:model="ageTo" placeholder="Не задан"></div>
        </div>
        @error('city')<div class="status error">{{ $message }}</div>@enderror
        @error('sex')<div class="status error">{{ $message }}</div>@enderror
        @error('ageFrom')<div class="status error">{{ $message }}</div>@enderror
        @error('ageTo')<div class="status error">{{ $message }}</div>@enderror
        <div class="actions" style="margin-top:14px"><button class="button" type="submit" wire:loading.attr="disabled" wire:target="prepareList"><span wire:loading.remove wire:target="prepareList">Подготовить список</span><span wire:loading wire:target="prepareList">Ищу аккаунты…</span></button></div>
    </form>

    @if($message)<div class="message {{ $isError ? 'error' : '' }}" role="status">{{ $message }}</div>@endif

    @if(count($people))
        <section class="panel">
            <h2 style="margin:0 0 12px">Найденные аккаунты ({{ count($people) }})</h2>
            <div class="people">
                @foreach($people as $person)
                    @php($vkId = (string) ($person['id'] ?? ''))
                    @php($status = $statuses[$vkId] ?? null)
                    <article class="person" wire:key="invitation-{{ $vkId }}">
                        @if(!empty($person['photo_100']))<img src="{{ $person['photo_100'] }}" alt="">@else<div></div>@endif
                        <div>
                            <div class="name">{{ trim(($person['first_name'] ?? '').' '.($person['last_name'] ?? '')) ?: 'Пользователь VK' }}</div>
                            <div class="muted tiny">VK ID: <a href="https://m.vk.com/id{{ rawurlencode($vkId) }}" target="_blank" rel="noopener noreferrer" wire:click="startInvitation('{{ $vkId }}')">{{ $vkId }}</a>@if(!empty($person['city']['title'])) · {{ $person['city']['title'] }}@endif</div>
                            @if($status)<div class="status {{ str_starts_with($status, 'Ошибка:') ? 'error' : (str_contains($status, 'отправлена') ? 'success' : '') }}" role="status">{{ $status }}</div>@endif
                        </div>
                        <div class="actions">
                            @if(!$status || str_starts_with($status, 'Ошибка:'))
                                <button class="button" type="button" wire:click="sendInvitation('{{ $vkId }}')" wire:loading.attr="disabled" wire:target="sendInvitation('{{ $vkId }}')"><span wire:loading.remove wire:target="sendInvitation('{{ $vkId }}')">Отправить заявку</span><span wire:loading wire:target="sendInvitation('{{ $vkId }}')">Отправляю…</span></button>
                            @else
                                <button class="button secondary" type="button" disabled>{{ str_contains($status, 'отправлена') ? 'Отправлено' : (str_contains($status, 'добавлен') ? 'Уже в друзьях' : 'Обработка…') }}</button>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @elseif($message && !$isError)
        <section class="panel empty">По заданным фильтрам подходящих аккаунтов не найдено.</section>
    @endif
</section>
