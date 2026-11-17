@extends('bu.layouts.app')

@section('title', 'Вход | BU')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card">
      <div class="card-body p-4">
        <div class="text-center mb-3">
          <i class="bi bi-vk text-primary fs-1"></i>
          <h1 class="h4 mt-2">Вход</h1>
          <p class="text-muted mb-0">Через ВКонтакте</p>
        </div>
        @if($error || session('error'))
          <div class="alert alert-danger mb-3" role="alert">{{ $error ?: session('error') }}</div>
        @endif
        <a href="{{ route('bu.auth.master.start') }}" class="btn btn-outline-primary w-100">Войти через ВКонтакте</a>
      </div>
    </div>
  </div>
</div>
@endsection
