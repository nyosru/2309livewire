@php($formKey = $section?->id ?? 'new-section')
@php($restore = old('form_key') === $formKey)
<form class="admin-form" method="post" action="/admin/sections{{ $section ? '/'.$section->id : '' }}">
    @csrf @if($section) @method('PUT') @endif
    <input type="hidden" name="form_key" value="{{ $formKey }}">
    <div class="admin-grid"><label>Название<input name="title" value="{{ $restore ? old('title') : $section?->title }}" required maxlength="255"></label><label>Короткая надпись над заголовком<input name="eyebrow" value="{{ $restore ? old('eyebrow') : $section?->eyebrow }}" maxlength="255"></label></div>
    <label>Описание<textarea name="description" rows="3" maxlength="3000">{{ $restore ? old('description') : $section?->description }}</textarea></label>
    <label>Порядок показа<input type="number" name="sort_order" min="0" max="1000000" value="{{ $restore ? old('sort_order') : ($section?->sort_order ?? 0) }}" required></label>
    <input type="hidden" name="is_active" value="0"><label class="admin-check"><input type="checkbox" name="is_active" value="1" @checked($restore ? old('is_active') : ($section?->is_active ?? true))> Показывать раздел</label>
    <button class="admin-button" type="submit">Сохранить раздел</button>
</form>
