    <details class="panel tag-manager">
        <summary>Управление тегами</summary>
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
                        <form class="inline-form" method="POST" action="{{ route('calls.tags.destroy', $tag) }}" onsubmit="return confirm('Удалить тег? Он будет убран у всех записей.');">name) }}»? Он будет убран у всех записей.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </details>

