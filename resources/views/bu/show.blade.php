@extends('bu.layouts.app')

@section('title', $ad->title . ' | BU')

@section('content')
<div class="bg-white rounded shadow-sm p-3">
  <h1 class="h3 mb-1">{{ $ad->title }}</h1>
  <div class="d-flex flex-wrap gap-2 small text-muted">
    <span class="badge bg-{{ $ad->type->slug === 'buy' ? 'success' : 'danger' }}">
      <i class="bi {{ $ad->type->icon }}"></i> {{ $ad->type->title_ru }}
    </span>
    <span>{{ $ad->category->fullPath() }}</span>
    @if($ad->price)
      <span class="text-success"><i class="bi bi-currency-rub"></i> {{ rtrim(rtrim(number_format((float) $ad->price, 2, ',', ' '), '0'), ',') }} ₽</span>
    @endif
  </div>

  @if($ad->description)
    <div class="mt-3">
      <h6 class="mb-1"><i class="bi bi-card-text me-1"></i>Описание</h6>
      <div class="card"><div class="card-body">{!! nl2br(e($ad->description)) !!}</div></div>
    </div>
  @endif

  @if($ad->contact_kind || $ad->contact_value)
    <div class="mt-3">
      <h6 class="mb-1"><i class="bi bi-person-badge me-1"></i>Контакт продавца</h6>
      @if($ad->contact_kind == 'vk')
        <a href="https://vk.com/{{ $ad->contact_value }}" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-vk"></i> ВКонтакте
        </a>
      @elseif($ad->contact_kind == 'phone')
        <a href="tel:{{ preg_replace('/\D/','',$ad->contact_value) }}" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-telephone"></i> {{ $ad->contact_value }}
        </a>
      @else
        <a href="mailto:{{ $ad->contact_value }}" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-envelope"></i> {{ $ad->contact_value }}
        </a>
      @endif
    </div>
  @endif

  <div class="mt-3 small text-muted">
    <i class="bi bi-eye"></i> просмотров: {{ $ad->views }}
  </div>
</div>

<div class="mt-3">
  <a href="{{ route('board.index') }}" class="btn btn-outline-secondary">← назад</a>
</div>
@endsection
