@php($formKey = $category ? 'category-'.$category->id : 'new-category')
@php($restore = old('form_key') === $formKey)
<form class="admin-form" method="post" action="/admin/categories{{ $category ? '/'.$category->id : '' }}">
    @csrf @if($category) @method('PUT') @endif
    <input type="hidden" name="form_key" value="{{ $formKey }}">
    <div class="admin-grid"><label>Название<input name="name" value="{{ $restore ? old('name') : $category?->name }}" required maxlength="255"></label><label>Раздел<select name="section_id" required>@foreach($sections as $section)<option value="{{ $section->id }}" @selected(($restore ? old('section_id') : $category?->section_id) === $section->id)>{{ $section->title }}{{ !$section->is_active ? ' (скрыт)' : '' }}</option>@endforeach</select></label></div>
    <label>Порядок показа<input type="number" name="sort_order" min="0" max="1000000" value="{{ $restore ? old('sort_order') : ($category?->sort_order ?? 0) }}" required></label>
    <input type="hidden" name="is_active" value="0"><label class="admin-check"><input type="checkbox" name="is_active" value="1" @checked($restore ? old('is_active') : ($category?->is_active ?? true))> Показывать категорию</label>
    <button class="admin-button" type="submit">Сохранить категорию</button>
</form>
