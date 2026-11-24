<form class="branch-form" method="POST" action="{{ $editing ? route('calls.branches.update', $branch) : route('calls.branches.store') }}">
    @csrf
    @if($editing) @method('PUT') @else <input type="hidden" name="parent_id" value="{{ $branch->id }}"> @endif
    <label>Название<input name="name" maxlength="150" required value="{{ $editing ? $branch->name : '' }}" placeholder="Название ветки"></label>
    <label>Тип<input name="type" maxlength="100" required value="{{ $editing ? $branch->type : '' }}" placeholder="Например, разработка"></label>
    <label>Проект<input name="project" maxlength="150" required value="{{ $branch->project }}" placeholder="Название проекта"></label>
    <button class="btn btn-primary" type="submit">{{ $editing ? 'Сохранить' : 'Создать ветку' }}</button>
</form>
