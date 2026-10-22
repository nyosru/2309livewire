@extends('vkusno.admin.layout')
@section('title', 'Категории')
@section('content')
<h1>Категории товаров</h1><p class="admin-muted">Например, «Супы», «Выпечка» или «Напитки». Категорию можно перенести в другой раздел. Скрытие категории скрывает все её товары.</p>
@if($sections->isEmpty())<p class="admin-card">Сначала <a href="/admin/sections">добавьте раздел меню</a>.</p>@else
<details class="admin-card" @if(old('form_key') === 'new-category') open @endif><summary>+ Добавить категорию</summary>@include('vkusno.admin.category-fields', ['category' => null])</details>
@foreach($categories as $category)
<details class="admin-card" @if(old('form_key') === 'category-'.$category->id) open @endif><summary>{{ $category->section->title }} · {{ $category->name }} <span class="admin-muted">· Товаров: {{ $category->products_count }} · {{ $category->is_active ? 'Включена' : 'Скрыта' }}</span></summary>
    @include('vkusno.admin.category-fields', ['category' => $category])
    <div class="admin-actions"><a href="/admin/products?category={{ $category->id }}">Товары категории →</a><form method="post" action="/admin/categories/{{ $category->id }}" onsubmit="return confirm('Удалить пустую категорию?')">@csrf @method('DELETE')<button class="admin-button admin-button-danger" type="submit">Удалить пустую категорию</button></form></div>
</details>
@endforeach
@endif
@endsection
