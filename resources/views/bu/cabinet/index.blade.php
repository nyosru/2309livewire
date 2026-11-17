@extends('bu.layouts.app')

@section('title', 'Личный кабинет | BU')

@section('content')
<div class="d-flex flex-column gap-2">
  <div class="card bg-light rounded">
    <div class="card-body">
      <div class="d-flex align-items-center gap-3">
        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
          {{ strtoupper(mb_substr(auth()->user()->name ?? '', 0, 1)) }}
        </div>
        <div>
          <h5 class="mb-0">{{ auth()->user()->name ?? auth()->user()->email }}</h5>
          <small class="text-muted">{{ auth()->user()->email }}</small>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-tags text-primary fs-5"></i>
            <div>
              <h6 class="mb-0">Категории</h6>
              <small class="text-muted">Управление категориями</small>
            </div>
          </div>
        </div>
        <div class="card-footer bg-white">
          <a href="{{ route('cabinet.categories.index') }}" class="btn btn-success w-100">
            <i class="bi bi-pen me-1"></i>Редактировать
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-text text-success fs-5"></i>
            <div>
              <h6 class="mb-0">Мои объявления</h6>
              <small class="text-muted">Ваши размещённые объявления</small>
            </div>
          </div>
        </div>
        <div class="card-footer bg-white">
          <a href="{{ route('cabinet.ads.index') }}" class="btn btn-success w-100">
            <i class="bi bi-plus-lg me-1"></i>Мои
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-info-circle text-warning fs-5"></i>
            <div>
              <h6 class="mb-0">Инструкции</h6>
              <small class="text-muted">Краткая справка</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
