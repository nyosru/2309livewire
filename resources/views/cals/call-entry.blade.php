<div class="call"
     x-data="{ removed: {{ $call->is_deleted ? 'true' : 'false' }} }"
     x-on:cals-call-status-changed.window="if ($event.detail.callId === {{ (int) $call->id }}) removed = $event.detail.removed">
    <span class="dot"></span>
    <div class="call-time-row">
        <div class="call-time">{{ $call->call_at->format('d.m.Y · H:i') }}</div>
        <button type="button" class="call-action" x-cloak x-show="removed"
                x-on:click="$dispatch('cals-set-call-removed', { callId: {{ (int) $call->id }}, removed: false })">Восстановить</button>
    </div>
    <div class="call-card" x-cloak x-show="!removed">
        @if($unassigned ?? false)
            <label class="call-select">
                <input type="checkbox" name="call_ids[]" value="{{ $call->id }}" x-bind:disabled="removed">
                <span><strong>{{ $call->phone ?: 'Номер не указан' }}</strong> · {{ $call->summary ?: 'Без описания' }}</span>
            </label>
        @else
            @if($call->summary)<p class="call-summary">{{ $call->summary }}</p>@else<p class="muted call-summary">Сводки пока нет</p>@endif
            @php($topics = $call->metadata['topics'] ?? $call->metadata['keywords'] ?? [])
            @if(is_array($topics) && count($topics))<div class="chips">@foreach(array_slice($topics, 0, 6) as $topic)<span class="chip">{{ is_string($topic) ? $topic : '' }}</span>@endforeach</div>@endif
        @endif
        @if($call->transcript)<details><summary>Расшифровка</summary><div class="transcript">{{ $call->transcript }}</div></details>@endif
        <div class="call-card-actions">
            <button type="button" class="call-action call-action-remove"
                    x-on:click="$dispatch('cals-set-call-removed', { callId: {{ (int) $call->id }}, removed: true })">Удалить</button>
        </div>
    </div>
</div>
