@extends('raal.admin.layout')

@section('title', 'Проекты')

@section('content')
    <div class="admin-title-row">
        <div><p class="admin-kicker">/ Витрина</p><h1>Проекты</h1><p>Карточки выводятся на сайте в указанном порядке.</p></div>
        <a class="admin-button admin-button-primary" href="{{ route('raal.admin.projects.create') }}">＋ Добавить проект</a>
    </div>

    <div class="project-admin-list">
        @forelse($projects as $project)
            <article class="project-admin-card {{ $project->is_active ? '' : 'is-hidden' }}">
                <div class="project-admin-image">
                    @if(collect($project->images)->first())
                        <img src="{{ collect($project->images)->first() }}" alt="">
                    @else
                        <span>Нет фото</span>
                    @endif
                </div>
                <div class="project-admin-main">
                    <div class="project-admin-meta">
                        <span>Порядок: {{ $project->sort_order }}</span>
                        <span class="status-dot status-{{ $project->status_color }}">{{ $project->status }}</span>
                        @unless($project->is_active)<span class="hidden-label">Скрыт</span>@endunless
                    </div>
                    <h2>{{ $project->title }}</h2>
                    <p>{{ $project->category }} · {{ $project->location }}</p>
                </div>
                <div class="project-admin-actions">
                    <a class="admin-button" href="{{ route('raal.admin.projects.edit', $project) }}">Редактировать</a>
                    <form action="{{ route('raal.admin.projects.destroy', $project) }}" method="post" onsubmit="return confirm('Удалить проект «{{ addslashes($project->title) }}»?')">
                        @csrf @method('DELETE')
                        <button class="admin-button admin-button-danger" type="submit">Удалить</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-empty"><h2>Проектов пока нет</h2><p>Добавьте первый проект — он сразу появится на витрине.</p></div>
        @endforelse
    </div>
@endsection
