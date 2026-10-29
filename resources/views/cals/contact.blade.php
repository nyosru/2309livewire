@extends('cals.layout')

@section('title', $contact->display_name)

@section('content')
    <p class="muted" style="margin-bottom:14px"><a href="{{ route('cals.index') }}">← Все звонки</a></p>
    <div class="intro"><h1>{{ $contact->display_name }}</h1><p class="muted">{{ $contact->phone ?: 'Телефон не добавлен' }}@if($contact->company_name) · {{ $contact->company_name }}@endif @if($contact->start_date) · с {{ $contact->start_date->format('d.m.Y') }}@endif · {{ $contact->calls->count() }} звонков</p></div>
    <div class="panels">
        <section>
            <div class="panel" style="margin-bottom:18px">
                <h2>Звонки по времени</h2>
                @forelse($contact->calls as $call)
                    <div class="timeline" style="margin-bottom:16px">
                        @include('cals.call-entry', ['call' => $call, 'unassigned' => false])
                    </div>
                @empty
                    <div class="empty">Для этого контакта пока нет звонков.</div>
                @endforelse
            </div>
            <div class="panel">
                <h2>Заметки о контакте</h2>
                @if($contact->notes)<p style="white-space:pre-wrap">{{ $contact->notes }}</p>@else<p class="muted">Общих заметок пока нет.</p>@endif
                @forelse($contact->comments as $comment)
                    <div class="comment"><time>{{ $comment->created_at->format('d.m.Y · H:i') }}</time><p style="white-space:pre-wrap;margin:5px 0 0">{{ $comment->body }}</p></div>
                @empty
                    <p class="muted">Отдельных комментариев пока нет.</p>
                @endforelse
                <form method="post" action="{{ route('cals.contacts.comments.store', $contact) }}" style="margin-top:14px">@csrf
                    <div class="field"><label for="body">Добавить комментарий</label><textarea id="body" name="body" required rows="3" placeholder="Новая заметка о человеке"></textarea></div>
                    <button type="submit">Сохранить комментарий</button>
                </form>
            </div>
        </section>
        <aside class="side-sticky">
            <div class="panel">
                <h2>Данные контакта</h2>
                <form method="post" action="{{ route('cals.contacts.update', $contact) }}">@csrf @method('PUT')
                    <div class="field"><label for="name">Имя или название</label><input id="name" name="name" value="{{ old('name', $contact->name) }}" placeholder="Неизвестный контакт"></div>
                    <div class="field"><label for="phone">Телефон</label><input id="phone" name="phone" value="{{ old('phone', $contact->phone) }}" placeholder="+7 …"></div>
                    <div class="field"><label for="company_name">Компания</label><input id="company_name" name="company_name" value="{{ old('company_name', $contact->company_name) }}" placeholder="Название компании"></div>
                    <div class="field"><label for="start_date">Дата начала</label><input id="start_date" name="start_date" type="date" value="{{ old('start_date', $contact->start_date?->format('Y-m-d')) }}"></div>
                    <div class="field"><label for="notes">Общая заметка</label><textarea id="notes" name="notes" rows="5" placeholder="Кто это, чем занимается, важные детали">{{ old('notes', $contact->notes) }}</textarea></div>
                    <button type="submit">Сохранить данные</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
