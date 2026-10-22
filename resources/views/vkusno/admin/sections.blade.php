@extends('vkusno.admin.layout')
@section('title', 'Разделы меню')
@section('content')
<h1>Разделы меню</h1><p class="admin-muted">Крупные блоки меню, например «Кафе» и «Столовая». Скрытый раздел скрывает все свои категории и товары.</p>
<details class="admin-card" @if(old('form_key') === 'new-section') open @endif><summary>+ Добавить раздел</summary>@include('vkusno.admin.section-fields', ['section' => null])</details>
@foreach($sections as $section)
<details class="admin-card" @if(old('form_key') === $section->id) open @endif><summary>{{ $section->title }} <span class="admin-muted">· Категорий: {{ $section->categories_count }} · {{ $section->is_active ? 'На витрине' : 'Скрыт' }}</span></summary>
    @include('vkusno.admin.section-fields', ['section' => $section])
    <form method="post" action="/admin/sections/{{ $section->id }}" onsubmit="return confirm('Удалить пустой раздел меню?')">@csrf @method('DELETE')<button class="admin-button admin-button-danger" type="submit">Удалить пустой раздел</button></form>
</details>
@endforeach
@endsection
