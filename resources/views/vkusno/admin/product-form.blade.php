@extends('vkusno.admin.layout')
@section('title', $product->exists ? 'Изменить товар' : 'Новый товар')
@section('content')
<a href="/admin/products">← К товарам</a>
<h1>{{ $product->exists ? 'Изменить товар' : 'Новый товар' }}</h1>
@if($categories->isEmpty())
    <p class="admin-card">Сначала <a href="/admin/sections">создайте раздел меню</a> и <a href="/admin/categories">добавьте категорию</a>.</p>
@else
<form class="admin-card admin-form" method="post" action="/admin/products{{ $product->exists ? '/'.$product->id : '' }}" enctype="multipart/form-data">
    @csrf @if($product->exists) @method('PUT') @endif
    <div class="admin-grid">
        <label>Название<input name="name" value="{{ old('name', $product->name) }}" required maxlength="255"></label>
        <label>Категория<select name="menu_category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string) old('menu_category_id', $product->menu_category_id) === (string) $category->id)>{{ $category->section->title }} · {{ $category->name }}{{ !$category->is_active || !$category->section->is_active ? ' (скрыта)' : '' }}</option>@endforeach</select></label>
        <label>Цена, ₽<input type="number" name="price" min="0" max="10000000" step="1" value="{{ old('price', $product->price) }}" required></label>
        <label>Вес или единица продажи<input name="weight" value="{{ old('weight', $product->weight) }}" placeholder="100 г, 200 мл или 1 шт." required maxlength="100"></label>
        <label>Метка на фото<input name="badge" value="{{ old('badge', $product->badge) }}" placeholder="Например: Новинка" maxlength="100"></label>
        <label>Порядок показа<input type="number" name="sort_order" min="0" max="1000000" value="{{ old('sort_order', $product->sort_order) }}" required><small class="admin-muted">Меньшее число — выше в меню.</small></label>
    </div>
    <label>Описание<textarea name="description" rows="4" maxlength="5000" required>{{ old('description', $product->description) }}</textarea></label>
    <div class="admin-photo-field">@if($product->exists)<img class="admin-preview" src="/vkusno/{{ $product->image }}?date={{ config('vkusno.image_cache_version') }}" alt="{{ $product->name }}">@endif<label>{{ $product->exists ? 'Заменить фотографию' : 'Фотография товара' }}<input type="file" name="photo" accept="image/jpeg,image/png,image/webp" @required(!$product->exists)><small class="admin-muted">JPG, PNG или WebP, до 5 МБ и 6000 × 6000 пикселей.</small></label></div>
    <input type="hidden" name="is_active" value="0"><label class="admin-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))> Показывать в меню</label>
    <input type="hidden" name="price_is_estimate" value="0"><label class="admin-check"><input type="checkbox" name="price_is_estimate" value="1" @checked(old('price_is_estimate', $product->price_is_estimate))> Цена предварительная, требует подтверждения</label>
    <div class="admin-actions"><button class="admin-button" type="submit">Сохранить товар</button><a href="/admin/products">Отмена</a></div>
</form>
@if($product->exists)<form method="post" action="/admin/products/{{ $product->id }}" onsubmit="return confirm('Удалить товар из каталога? Полученные заказы сохранятся.')">@csrf @method('DELETE')<button class="admin-button admin-button-danger" type="submit">Удалить товар</button></form>@endif
@endif
@endsection
