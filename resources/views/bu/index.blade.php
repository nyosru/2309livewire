@extends('bu.layouts.app')

@section('title', 'Главная | BU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <div>
    <h1 class="h4 mb-0"><i class="bi bi-grid-3x3-gap me-2"></i>Объявления (купить / продать)</h1>
    <p class="text-muted small mb-0">Свежие объявления от пользователей</p>
  </div>
  @auth
    <a href="{{ route('cabinet.ads.index') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i>Новое объявление
    </a>
  @else
{{--      <i class="bi bi-box-arrow-in-right me-1"></i>Войти--}}
{{--    </a>--}}
  @endauth
</div>

<form method="GET" action="{{ route('board.index') }}" class="row g-2 mb-4">
  <div class="col-md-4">
    <label class="visually-hidden">Поиск</label>
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Поиск по названию...">
  </div>
  <div class="col-md-2">
    <label class="visually-hidden">Тип</label>
    <select name="type" class="form-select">
      <option value="">Все типы</option>
      @foreach($types as $type)
        <option value="{{ $type->slug }}" {{ request('type')==$type->slug ? 'selected' : '' }}>
          {{ $type->title_ru }} ({{ $type->slug }})
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="visually-hidden">Категория</label>
    <select name="category" class="form-select">
      <option value="">Все категории</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->slug }}" {{ request('category')==$cat->slug ? 'selected' : '' }}>
          {{ $cat->fullPath() }}
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button class="btn btn-outline-primary w-100">Фильтровать</button>
  </div>
</form>

@if($ads->isNotEmpty())
  <div class="row g-4">
    @foreach($ads as $ad)
      <div class="col-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100 border">
          @if($ad->mainImage)
            <img src="{{ asset('storage/'.$ad->mainImage->url) }}" class="card-img-top" alt="{{ $ad->title }}" style="height:180px; object-fit:cover;">
          @endif
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center gap-2 mb-1">
              <span class="badge bg-{{ $ad->type->slug === 'buy' ? 'success' : 'danger' }}">
                <i class="bi {{ $ad->type->icon }}"></i> {{ $ad->type->title_ru }}
              </span>
            </div>
            <h5 class="card-title">
              @if(filled($ad->slug))
                <a href="{{ route('ads.show', $ad) }}" class="text-dark text-decoration-none">{{ $ad->title }}</a>
              @else
                {{ $ad->title }}
              @endif
            </h5>
            @if($ad->price)
              <p class="card-text text-success mb-1"><i class="bi bi-currency-rub"></i> {{ rtrim(rtrim(number_format((float) $ad->price, 2, ',', ' '), '0'), ',') }} ₽</p>
            @endif
            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($ad->description), 100) }}</p>
            <div class="d-flex justify-content-between small text-muted mt-auto">
              <span><i class="bi bi-person-lines-fill"></i> {{ $ad->user->name }}</span>
              <span><i class="bi bi-eye"></i> {{ $ad->views }}</span>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mt-3">{!! $ads->links() !!}</div>
@else
  <div class="alert alert-info">Нет объявлений, удовлетворяющих фильтру.</div>
@endif
@endsection
