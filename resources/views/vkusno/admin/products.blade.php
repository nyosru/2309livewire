@extends('vkusno.admin.layout')
@section('title', 'Товары')
@section('content')
<div class="admin-heading"><div><h1>Товары</h1><p class="admin-muted">Всего найдено: {{ $products->total() }}. Изменения сразу появятся в меню.</p></div><a class="admin-button" href="/admin/products/create">+ Добавить товар</a></div>
<form class="admin-filters" method="get" action="/admin/products">
    <label>Название<input name="q" value="{{ request('q') }}" placeholder="Поиск товара" maxlength="100"></label>
    <label>Категория<select name="category"><option value="">Все категории</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>{{ $category->section->title }} · {{ $category->name }}</option>@endforeach</select></label>
    <button class="admin-button" type="submit">Найти</button><a href="/admin/products">Сбросить</a>
</form>
<div class="admin-products">
@forelse($products as $product)
    <article class="admin-card admin-product">
        <img src="/vkusno/{{ $product->image }}?date={{ config('vkusno.image_cache_version') }}" alt="{{ $product->name }}" loading="lazy">
        <div><p class="admin-muted">{{ $product->menuCategory?->section?->title }} · {{ $product->menuCategory?->name }}</p><h2>{{ $product->name }}</h2><p>{{ $product->price }} ₽ / {{ $product->weight }} @if($product->price_is_estimate)· предварительно@endif</p><span class="admin-pill {{ $product->is_active && $product->menuCategory?->is_active && $product->menuCategory?->section?->is_active ? '' : 'is-hidden' }}">{{ $product->is_active && $product->menuCategory?->is_active && $product->menuCategory?->section?->is_active ? 'На витрине' : 'Скрыт' }}</span></div>
        <a class="admin-button admin-button-secondary" href="/admin/products/{{ $product->id }}/edit">Изменить</a>
    </article>
@empty
    <p class="admin-card">Товаров не найдено. Добавьте первый товар или измените фильтры.</p>
@endforelse
</div>
<div class="pagination">@if($products->previousPageUrl())<a href="{{ $products->previousPageUrl() }}">← Предыдущая</a>@endif<span>Страница {{ $products->currentPage() }} из {{ $products->lastPage() }}</span>@if($products->nextPageUrl())<a href="{{ $products->nextPageUrl() }}">Следующая →</a>@endif</div>
@endsection
