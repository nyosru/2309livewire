@extends('bu.layouts.app')
@section('title', 'Мои объявления | BU')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <h1 class="h4 mb-0">Мои объявления</h1>
  @auth
    <button wire:click="toggleForm" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i>Новое
    </button>
  @else
    <a href="{{ route('bu.auth.master.start') }}" class="btn btn-outline-primary"><i class="bi bi-box-arrow-in-right me-1"></i>Войти</a>
  @endauth
</div>

@if($showForm)
  <div class="card mb-3">
    <div class="card-body">
      <h6 class="mb-3"><i class="bi bi-plus-circle me-1"></i>Новое объявление (куплю / продам)</h6>
      <livewire:bu.ad.post />
    </div>
  </div>
@endif

@if($ads->isNotEmpty())
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th class="col-5">Название</th>
              <th class="col-2">Тип</th>
              <th class="col-2">Цена</th>
              <th class="col-1"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($ads as $ad)
              <tr>
                <td>
                  @if(filled($ad->slug))
                    <a href="{{ route('ads.show', $ad) }}">{{ $ad->title }}</a>
                  @else
                    {{ $ad->title }}
                  @endif
                </td>
                <td>
                  <span class="badge bg-{{ $ad->type->slug === 'buy' ? 'success' : 'danger' }}">
                    {{ $ad->type->title_ru }}
                  </span>
                </td>
                <td>{{ rtrim(rtrim(number_format((float) $ad->price, 2, ',', ' '), '0'), ',') }} ₽</td>
                <td>
                  <form method="POST" action="{{ route('cabinet.ads.destroy', $ad) }}" class="d-inline" onsubmit="return confirm('Удалить объявление?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Удалить</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@else
  <div class="alert alert-info">У вас пока нет объявлений.</div>
@endif

<div class="mt-2">
  <a href="{{ route('board.index') }}" class="btn btn-outline-secondary btn-sm">← назад</a>
</div>
@endsection
