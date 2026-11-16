@extends('calls.layout')

@section('title', 'Записи диктофона')

@section('content')
    <header>
        <h1>Записи диктофона</h1>
        <p class="sub">{{ $dir }}</p>
        <div class="stats">
            <span class="pill">Всего записей: {{ $total }}</span>
            <span class="pill">Тегов: {{ $allTags->count() }}</span>
        </div>
    </header>

    <section class="panel">
        <h2>Теги</h2>
        <form class="inline-form" method="POST" action="{{ route('calls.tags.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Новый тег" required maxlength="100">
            <button type="submit" class="btn btn-primary">Добавить тег</button>
        </form>

        @if($allTags->isEmpty())
            <p class="muted" style="margin-top:12px;">Тегов пока нет.</p>
        @else
            <div class="tag-admin-list">
                @foreach($allTags as $tag)
                    <div class="tag-admin-item">
                        <form class="inline-form" method="POST" action="{{ route('calls.tags.update', $tag) }}">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $tag->name }}" required maxlength="100">
                            <button type="submit" class="btn">Сохранить</button>
                        </form>
                        <form class="inline-form" method="POST" action="{{ route('calls.tags.destroy', $tag) }}" onsubmit="return confirm('Удалить тег «{{ e($tag->name) }}»? Он будет убран у всех записей.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    @if($error)
        <div class="alert">{{ $error }}</div>
    @elseif(empty($items))
        <div class="alert">В папке не найдено MP3-записей.</div>
    @else
        <div class="list">
            @foreach($items as $item)
                <article class="card" id="rec-{{ $item['basename'] }}">
                    <div class="top">
                        <div>
                            <p class="name">{{ $item['name'] }}</p>
                            <div class="meta">
                                <span>{{ $item['size'] ? number_format($item['size'] / 1024 / 1024, 2, ',', ' ') . ' МБ' : '—' }}</span>
                                <span>{{ $item['mtime'] ? \Illuminate\Support\Carbon::createFromTimestamp($item['mtime'])->format('d.m.Y H:i') : '—' }}</span>
                            </div>
                        </div>
                        <div class="links">
                            <a class="btn" href="{{ route('calls.file', ['filename' => $item['name']]) }}" download>Скачать MP3</a>
                            @if($item['has_txt'])
                                <a class="btn" href="{{ route('calls.file', ['filename' => $item['basename'] . '.txt']) }}" target="_blank" rel="noopener">Текст</a>
                            @endif
                            @if($item['has_summary'])
                                <a class="btn" href="{{ route('calls.file', ['filename' => $item['basename'] . '_summary.md']) }}" target="_blank" rel="noopener">Саммари</a>
                            @endif
                        </div>
                    </div>

                    <audio controls preload="none" src="{{ route('calls.file', ['filename' => $item['name']]) }}"></audio>

                    <div class="tags-row">
                        @forelse($item['tags'] as $tag)
                            <span class="tag">
                                {{ $tag->name }}
                                <form method="POST" action="{{ route('calls.recordings.tags.detach', ['basename' => $item['basename'], 'tag' => $tag->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="tag-remove" title="Убрать тег">×</button>
                                </form>
                            </span>
                        @empty
                            <span class="muted">Теги не назначены</span>
                        @endforelse

                        @if($allTags->isNotEmpty())
                            <form class="inline-form" method="POST" action="{{ route('calls.recordings.tags.attach', ['basename' => $item['basename']]) }}">
                                @csrf
                                <select name="tag_id" required>
                                    <option value="">Добавить тег…</option>
                                    @foreach($allTags as $tag)
                                        @if(!$item['tags']->contains('id', $tag->id))
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="btn">Добавить</button>
                            </form>
                        @endif
                    </div>

                    @if(!empty($item['text']) || !empty($item['summary']))
                        <hr class="sep">
                    @endif

                    @if(!empty($item['text']))
                        <div class="content-block">
                            <div class="block-label">Текст</div>
                            <div class="scroll-block">{{ $item['text'] }}</div>
                        </div>
                    @endif

                    @if(!empty($item['summary']))
                        <div class="content-block">
                            <div class="block-label">Краткое описание</div>
                            <div class="scroll-block">{{ $item['summary'] }}</div>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
@endsection
