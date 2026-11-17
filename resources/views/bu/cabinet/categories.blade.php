@extends('bu.layouts.app')

@section('title', 'Категории | BU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <h1 class="h4 mb-0">Карта категорий (3 уровня)</h1>
  <a href="{{ route('cabinet.ads.index') }}" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-plus-lg me-1"></i>Новое объявление
  </a>
</div>

<div class="card mb-3">
  <div class="card-body">
    <h6 class="mb-2">Добавить категорию</h6>
    <form method="POST" action="{{ route('cabinet.categories.store') }}">
      @csrf
      <div class="row g-2">
        <div class="col-md-3">
          <label class="form-label">Родитель</label>
          <select name="parent_id" class="form-select">
            <option value="">— корень (уровень 1) —</option>
            @foreach($tree as $c)
              <option value="{{ $c->id }}" {{ request('parent_id')==$c->id ? 'selected' : '' }}>
                {{ $c->level === 1 ? '▪ ' : '– ' . $c->title }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Название</label>
          <input name="title" class="form-control" placeholder="Название категории">
        </div>
        <div class="col-md-2">
          <label class="form-label">Slug</label>
          <input name="slug" class="form-control" placeholder="ru/furniture/sofa">
        </div>
        <div class="col-md-2">
          <label class="form-label">Иконка (BI)</label>
          <input name="icon" class="form-control" placeholder="bi-cart">
        </div>
        <div class="col-md-2">
          <label class="form-label">Сортировка</label>
          <input name="sort" type="number" class="form-control">
        </div>
        <div class="col-md-12">
          <button class="btn btn-success">Добавить категорию</button>
        </div>
      </div>
    </form>
  </div>
</div>

<h6 class="mb-2">Структура (заполнение / редактирование)</h6>
<div class="card">
  <div class="card-body">
    @foreach($tree as $root)
      <ul class="list-group mb-3">
        <li class="list-group-item bg-light fw-bold">
          <span class="badge bg-secondary me-2">1</span>{{ $root->title }} &nbsp;<small class="text-muted">{{ $root->fullPath() }}</small>
        </li>
        @foreach($root->children as $child)
          <li class="list-group-item">
            <span class="badge bg-primary me-2">2</span>{{ $child->title }} &nbsp;<small class="text-muted">{{ $child->fullPath() }}</small>
            <div class="d-block mt-1">
              <form method="POST" action="{{ route('cabinet.categories.update', $child) }}" class="d-inline me-1">
                @csrf @method('PUT')
                <input name="title" class="form-control form-control-sm d-inline w-auto" placeholder="площадка" value="{{ $child->title }}">
                <input name="slug" class="form-control form-control-sm d-inline w-auto" placeholder="slug" value="{{ $child->slug }}">
                <select name="icon" class="form-select form-select-sm d-inline w-auto">
                  <option value="{{ $child->icon }}">{{ $child->icon }}</option>
                </select>
                <button class="btn btn-sm btn-outline-primary">сохранить</button>
              </form>
              <form method="POST" action="{{ route('cabinet.categories.destroy', $child) }}" class="d-inline" onsubmit="return confirm('Удалить категорию?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">удалить</button>
              </form>
            </div>
          </li>
          @foreach($child->children as $sub)
            <li class="list-group-item">
              <span class="badge bg-info me-2">3</span>{{ $sub->title }} &nbsp;<small class="text-muted">{{ $sub->fullPath() }}</small>
              <div class="d-block mt-1">
                <form method="POST" action="{{ route('cabinet.categories.update', $sub) }}" class="d-inline me-1">
                  @csrf @method('PUT')
                  <input name="title" class="form-control form-control-sm d-inline w-auto" placeholder="площадка" value="{{ $sub->title }}">
                  <input name="slug" class="form-control form-control-sm d-inline w-auto" placeholder="slug" value="{{ $sub->slug }}">
                  <select name="icon" class="form-select form-select-sm d-inline w-auto">
                    <option value="{{ $sub->icon }}">{{ $sub->icon }}</option>
                  </select>
                  <button class="btn btn-sm btn-outline-primary">сохранить</button>
                </form>
                <form method="POST" action="{{ route('cabinet.categories.destroy', $sub) }}" class="d-inline" onsubmit="return confirm('Удалить категорию?');">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">удалить</button>
                </form>
              </div>
            </li>
          @endforeach
        @endforeach
      </ul>
    @endforeach
  </div>
</div>

<div class="mt-3">
  <a href="{{ route('cabinet.index') }}" class="btn btn-outline-secondary btn-sm">← назад</a>
</div>
@endsection
