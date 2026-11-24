<article class="record-entry space-y-2 rounded-xl border border-slate-200 bg-white p-3 shadow-sm"
         id="rec-{{ $item['key'] }}">

    <span class="float-right inline-block">
        <form class="inline" method="POST" action="{{ route('calls.recordings.status', $item['key']) }}" data-record-status
              data-status="hidden" data-list-mode="ordinary">
            @csrf @method('PUT')<input type="hidden" name="status" value="hidden">
            <button type="submit"
                    class="btn {{ $item['status'] === 'hidden' ? 'status-active' : '' }}">{{ $item['status'] === 'hidden' ? 'Скрыт' : 'Скрыть' }}</button>
        </form>
        <form class="inline" method="POST" action="{{ route('calls.recordings.status', $item['key']) }}" data-record-status
              data-status="spam" data-list-mode="ordinary">
            @csrf @method('PUT')<input type="hidden" name="status" value="spam">
            <button type="submit"
                    class="btn {{ $item['status'] === 'spam' ? 'status-active' : '' }}">{{ $item['status'] === 'spam' ? 'В спаме' : 'В спам' }}</button>
        </form>
    </span>

    @if($item['tag_key'] !== $item['key'])
        <span id="rec-{{ $item['tag_key'] }}"></span>
    @endif

    @if($item['phone'])
        <div class="contact-line flex flex-wrap items-center gap-2 text-sm text-slate-600">
            <span title="{{ $item['name'] }}">
                <span
                    class="record-date">{{ $item['source'] === 'call' ? 'Звонок' : 'Диктофон' }} / {{ \Illuminate\Support\Carbon::createFromTimestamp($item['recorded_at'])->format('d.m.Y H:i') }}</span>
                Тел: {{ $item['phone'] }}
            </span>
            @if($item['contact'])
                <span class="contact-owner">{{ $item['contact']->name }}</span>
            @else
                <button class="btn contact-add" type="button" data-contact-phone="{{ $item['phone'] }}">+ контакт
                </button>
            @endif
        </div>
    @endif


    <details class="record-node overflow-hidden rounded-lg border border-slate-200 bg-white">

        <div class="recording-details space-y-4 border-t border-slate-200 p-4">
            <div class="top flex flex-wrap items-start justify-between gap-3">

                <span>{{ number_format($item['size'] / 1024 / 1024, 2, ',', ' ') }} МБ</span>
                {{--                        <span>{{ $item['date_estimated'] ? 'Дата определена по файлу' : 'Дата из данных звонка' }}</span>--}}

                <div class="w-30%">
                    <audio controls preload="none" class="w-full"
                           src="{{ route('calls.audio', ['source' => $item['source'], 'filename' => $item['path']]) }}"></audio>

                </div>
                <a href="{{ route('calls.audio', ['source' => $item['source'], 'filename' => $item['path']]) }}"
                   class="muted">{{ $item['path'] }}</a>
            </div>
        </div>

        <section class="quick-picker" aria-label="Последние ветки">
            <strong>{{ $item['branch_id'] ? 'Перенести в ветку' : 'Быстро прикрепить к ветке' }}</strong>
            <div class="quick-buttons">
                @foreach($recentBranches as $branch)
                    <form method="POST" action="{{ route('calls.recordings.branch', $item['key']) }}"
                          data-quick-branch>
                        @csrf @method('PUT')<input type="hidden" name="branch_id" value="{{ $branch->id }}">
                        <button class="btn {{ $item['branch_id'] == $branch->id ? 'picker-selected' : '' }}"
                                type="submit">{{ $branch->name }}</button>
                    </form>
                @endforeach
            </div>
        </section>

        @if($branches->count() > $recentBranches->count())
            <form class="assignment assignment-other" method="POST"
                  action="{{ route('calls.recordings.branch', $item['key']) }}">
                @csrf @method('PUT')
                <label>Остальные ветки
                    <select name="branch_id">
                        <option value="" @selected(!$item['branch_id'])>Без ветки</option>
                        @foreach($branches as $option)
                            @if(!$recentBranches->contains('id', $option->id) || $item['branch_id'] == $option->id)
                                <option
                                    value="{{ $option->id }}" @selected($item['branch_id'] == $option->id)>{{ $option->name }}
                                    · {{ $option->type }} · {{ $option->project }} (#{{ $option->id }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </label>
                <button class="btn btn-primary" type="submit">Применить</button>
            </form>
        @endif

        <div class="tags-row flex flex-wrap items-center gap-2">
            @foreach($item['tags'] as $tag)
                <span class="tag inline">{{ $tag->name }}
                        <form method="POST" class="inline-block""
                              action="{{ route('calls.recordings.tags.detach', ['basename' => $item['tag_key'], 'tag' => $tag->id]) }}">
                            @csrf @method('DELETE')<button type="submit" class="tag-remove"
                                                           aria-label="Убрать тег {{ $tag->name }}">×</button>
                        </form>
                    </span>
            @endforeach
        </div>

        @if($recentTags->isNotEmpty())
            <section class="quick-picker" aria-label="Последние использованные теги">
                <strong>Последние теги:</strong>
                <div class="quick-buttons">
                    @foreach($recentTags as $tag)
                        <form method="POST"
                              class="inline"
                              action="{{ route('calls.recordings.tags.attach', ['basename' => $item['tag_key']]) }}"
                              data-quick-tag data-tag-id="{{ $tag->id }}" data-tag-name="{{ $tag->name }}"
                              data-detach-url="{{ route('calls.recordings.tags.detach', ['basename' => $item['tag_key'], 'tag' => $tag->id]) }}">
                            @csrf<input type="hidden" name="tag_id" value="{{ $tag->id }}">
                            <button
                                class="btn {{ $item['tags']->contains('id', $tag->id) ? 'picker-selected' : '' }}"
                                type="submit">{{ $tag->name }}</button>
                        </form>
                    @endforeach
                </div>
            </section>
        @endif
        @if($allTags->count() > $recentTags->count())
            <form class="inline-form" method="POST"
                  action="{{ route('calls.recordings.tags.attach', ['basename' => $item['tag_key']]) }}">
                @csrf
                <select name="tag_id" aria-label="Добавить другой тег" required>
                    <option value="">Остальные теги…</option>
                    @foreach($allTags as $tag)
                        @if(!$recentTags->contains('id', $tag->id))
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endif
                    @endforeach
                </select>
                <button class="btn" type="submit">Добавить тег</button>
            </form>
        @endif
        @if($item['txt_path'])
            <p class="transcript-preview">
                <strong>Транскрипция:</strong>
                {{ $item['transcript_preview'] }}{{ mb_strlen($item['transcript_preview'] ?? '') >= 150 ? '…' : '' }}
                <a href="{{ route('calls.audio', ['source' => $item['source'], 'filename' => $item['txt_path']]) }}"
                   data-transcript-url="{{ route('calls.audio', ['source' => $item['source'], 'filename' => $item['txt_path']]) }}">Читать
                    полностью</a>
            </p>
        @endif
        @if($item['summary_path'])
            <details class="text-preview"
                     data-text-url="{{ route('calls.audio', ['source' => $item['source'], 'filename' => $item['summary_path']]) }}">
                <summary>Краткое описание</summary>
                <div class="scroll-block"></div>
                <a href="{{ route('calls.audio', ['source' => $item['source'], 'filename' => $item['summary_path']]) }}"
                   target="_blank" rel="noopener">Открыть отдельно</a>
            </details>
            @endif

    </details>
    <div class="record-summary-meta flex flex-wrap items-center gap-2 pl-9">
        @if($item['branch'])
            <span class="summary-tag record-branch-summary" data-record-branch-meta>{{ $item['branch']->name }}
                <form method="POST" action="{{ route('calls.recordings.branch', $item['key']) }}"
                      aria-label="Отвязать запись от ветки {{ $item['branch']->name }}" data-async-branch-detach>
                    @csrf @method('PUT')<input type="hidden" name="branch_id" value="">
                    <button type="submit" class="summary-tag-remove" title="Отвязать ветку" aria-label="Отвязать ветку">×</button>
                </form>
            </span>
        @else
{{--            <span class="record-no-tags" data-record-branch-meta>Без ветки</span>--}}
        @endif
        @forelse($item['tags'] as $tag)
            <span class="summary-tag" data-record-tag-id="{{ $tag->id }}">{{ $tag->name }}
                <form method="POST"
                      action="{{ route('calls.recordings.tags.detach', ['basename' => $item['tag_key'], 'tag' => $tag->id]) }}"
                      aria-label="Убрать тег {{ $tag->name }}" data-async-tag-detach data-tag-id="{{ $tag->id }}">
                    @csrf @method('DELETE')<button type="submit" class="summary-tag-remove" title="Убрать тег"
                                                   aria-label="Убрать тег">×</button>
                </form>
            </span>
        @empty
{{--            <span class="record-no-tags">Без тегов</span>--}}
        @endforelse
    </div>
    <div class="record-status-actions flex flex-wrap gap-2 pl-9">
        @if($listMode !== 'ordinary')
            <form method="POST" action="{{ route('calls.recordings.status', $item['key']) }}" data-record-status
                  data-status="" data-list-mode="{{ $listMode }}">
                @csrf @method('PUT')<input type="hidden" name="status" value="">
                <button type="submit" class="btn">Вернуть в обычные</button>
            </form>
        @else
            {{--            <form method="POST" action="{{ route('calls.recordings.status', $item['key']) }}" data-record-status data-status="hidden" data-list-mode="ordinary">--}}
            {{--                @csrf @method('PUT')<input type="hidden" name="status" value="hidden">--}}
            {{--                <button type="submit" class="btn {{ $item['status'] === 'hidden' ? 'status-active' : '' }}">{{ $item['status'] === 'hidden' ? 'Скрыт' : 'Скрыть' }}</button>--}}
            {{--            </form>--}}
            {{--            <form method="POST" action="{{ route('calls.recordings.status', $item['key']) }}" data-record-status data-status="spam" data-list-mode="ordinary">--}}
            {{--                @csrf @method('PUT')<input type="hidden" name="status" value="spam">--}}
            {{--                <button type="submit" class="btn {{ $item['status'] === 'spam' ? 'status-active' : '' }}">{{ $item['status'] === 'spam' ? 'В спаме' : 'В спам' }}</button>--}}
            {{--            </form>--}}
        @endif
    </div>
</article>
