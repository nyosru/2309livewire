@extends('raal.admin.layout')

@php($editing = $project->exists)
@section('title', $editing ? 'Редактирование проекта' : 'Новый проект')

@section('content')
    <div class="admin-title-row compact">
        <div><a class="back-link" href="{{ route('raal.admin.projects.index') }}">← Все проекты</a><h1>{{ $editing ? 'Редактировать проект' : 'Новый проект' }}</h1></div>
    </div>

    <form class="project-form" action="{{ $editing ? route('raal.admin.projects.update', $project) : route('raal.admin.projects.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if($editing) @method('PUT') @endif

        <section class="form-section">
            <div class="form-section-title"><span>01</span><div><h2>Основное</h2><p>То, что посетитель увидит в&nbsp;карточке проекта.</p></div></div>
            <div class="form-fields">
                <label class="wide"><span>Название *</span><input name="title" value="{{ old('title', $project->title) }}" required maxlength="160"></label>
                <label><span>Категория</span><input name="category" value="{{ old('category', $project->category) }}" placeholder="Например, IT-сервис"></label>
                <label><span>Город / формат</span><input name="location" value="{{ old('location', $project->location) }}" placeholder="Тюмень · Онлайн"></label>
                <label><span>Статус *</span><input name="status" value="{{ old('status', $project->status ?: 'Планируем') }}" required placeholder="Работает"></label>
                <label><span>Цвет статуса</span><select name="status_color"><option value="lime" @selected(old('status_color', $project->status_color) === 'lime')>Лаймовый</option><option value="orange" @selected(old('status_color', $project->status_color) === 'orange')>Оранжевый</option><option value="blue" @selected(old('status_color', $project->status_color) === 'blue')>Голубой</option></select></label>
                <label class="wide"><span>Краткое описание *</span><textarea name="description" rows="5" required maxlength="3000">{{ old('description', $project->description) }}</textarea></label>
                <label class="wide"><span>Предложение инвестору *</span><textarea name="investment_offer" rows="5" required maxlength="3000">{{ old('investment_offer', $project->investment_offer) }}</textarea></label>
            </div>
        </section>

        <section class="form-section">
            <div class="form-section-title"><span>02</span><div><h2>Фотографии</h2><p>Первая фотография будет обложкой. Остальные показываются при наведении.</p></div></div>
            <div class="form-fields">
                <div class="image-manager wide" data-image-manager>
                    <div class="current-images" data-current-images>
                        @foreach(old('existing_images', $project->images ?? []) as $image)
                            <div class="current-image-item" data-current-image>
                                <img src="{{ $image }}" alt="Фото {{ $loop->iteration }}">
                                <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                <span class="cover-label" data-cover-label @if(! $loop->first) hidden @endif>Обложка</span>
                                <button class="image-remove" type="button" data-remove-image aria-label="Удалить фотографию">×</button>
                            </div>
                        @endforeach
                    </div>

                    <label class="drop-zone" data-drop-zone>
                        <input class="drop-zone-input" type="file" name="images_upload[]" accept="image/jpeg,image/png,image/webp" multiple data-file-input>
                        <span class="drop-zone-icon">＋</span>
                        <strong>Перетащите фотографии сюда</strong>
                        <span>или нажмите, чтобы выбрать</span>
                        <small>JPG, PNG или WebP, до 6 МБ. После загрузки файл преобразуется в JPG, а ширина уменьшится до 700 px. Оригинал не сохраняется.</small>
                    </label>

                    <div class="upload-previews" data-upload-previews></div>
                    <p class="image-manager-note">Крестик убирает фотографию из проекта после сохранения формы. Всего можно добавить до 12 фотографий.</p>
                </div>
            </div>
        </section>

        <section class="form-section">
            <div class="form-section-title"><span>03</span><div><h2>Публикация</h2><p>Управляйте порядком и&nbsp;видимостью.</p></div></div>
            <div class="form-fields">
                <label><span>Порядок</span><input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" max="100000" required></label>
                <label class="checkbox-label"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $project->exists ? $project->is_active : true))><span>Показывать проект на сайте</span></label>
            </div>
        </section>

        <div class="form-actions">
            <a class="admin-button" href="{{ route('raal.admin.projects.index') }}">Отмена</a>
            <button class="admin-button admin-button-primary" type="submit">{{ $editing ? 'Сохранить изменения' : 'Добавить проект' }}</button>
        </div>
    </form>
@endsection
