<div class="card">
  <div class="card-body">
    <h6 class="mb-3"><i class="bi bi-plus-circle me-1"></i>Новое объявление (куплю / продам)</h6>

    @if(session()->has('success'))
      <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save" enctype="multipart/form-data">
      @csrf
      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label">Тип объявления</label>
          <select name="type_id" class="form-select" wire:model="type_id">
            <option value="">Выберите тип</option>
            @foreach($types as $type)
              <option value="{{ $type->id }}" {{ $type->id == $type_id ? 'selected' : '' }}>
                {{ $type->title_ru }} ({{ $type->slug }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Категория</label>
          <select name="category_id" class="form-select" wire:model="category_id">
            <option value="">Выберите категорию</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ $category->id == $category_id ? 'selected' : '' }}>
                {{ $category->fullPath() }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Название</label>
          <input name="title" class="form-control" placeholder="Название товара / услуги" wire:model="title">
        </div>

        <div class="col-md-6">
          <label class="form-label">Цена (₽)</label>
          <input name="price" type="number" step="0.01" min="0" class="form-control" placeholder="0" wire:model="price">
        </div>

        <div class="col-md-6">
          <label class="form-label">Адрес</label>
          <input name="address" class="form-control" placeholder="Улица, дом, кв." wire:model="address">
        </div>

        <div class="col-md-6">
          <label class="form-label">Город</label>
          <input name="city" class="form-control" placeholder="Город" wire:model="city">
        </div>

        <div class="col-md-6">
          <label class="form-label">Контакт (телефон / ВК / почта)</label>
          <input name="contact_value" class="form-control" placeholder="+7 (XXX) XXX XX XX" wire:model="contact_value">
          <div class="form-text">
            Вид контакта:
            <select wire:model="contact_kind" style="width:auto" class="form-select-sm align-bottom">
              <option value="">—</option>
              <option value="phone">телефон</option>
              <option value="vk">ВКонтакте</option>
              <option value="email">email</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Описание</label>
          <textarea name="description" class="form-control" rows="3" wire:model="description"></textarea>
        </div>

        <div class="col-md-6">
          <label class="form-label">Фото (необязательно)</label>
          <input name="images[]" type="file" accept="image/*" class="form-control" multiple wire:model="images">
        </div>

        <div class="col-md-12">
          <button class="btn btn-success" type="submit">
            <i class="bi bi-check-lg me-1"></i>Опубликовать
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
