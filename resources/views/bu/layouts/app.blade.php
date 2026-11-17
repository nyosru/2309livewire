<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'BU — доска объявлений')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body { background-color: #f8fafc; min-height: 80vh; display: flex; flex-direction: column; }
    .site-wrapper { max-width: 1000px; }
    main.site-wrapper { flex: 1 0 auto; }
    footer.site-wrapper { margin-top: auto; }
  </style>
</head>
<body>
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <nav class="navbar navbar-expand navbar-light bg-white border-bottom">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ url('/') }}">
        <i class="bi bi-clipboard2-pulse me-2"></i>{{ request()->getHost() === 'бу72.рф' ? 'БУ72.рф' : 'BU72.ru' }}
      </a>
      <div class="navbar-nav ms-auto align-items-center">
{{--        <a class="nav-link" href="{{ route('board.index') }}">Главная</a>--}}
        @auth
          <div class="dropdown">
            <button class="btn btn-link nav-link dropdown-toggle text-decoration-none" type="button"
                    id="buUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth()->user()->name ?: auth()->user()->email }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="buUserMenu">
              <li><a class="dropdown-item" href="{{ route('cabinet.index') }}">Личный кабинет</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit">Выйти</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a class="nav-link" href="{{ route('bu.auth.master.start') }}">Войти через VK</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="container site-wrapper py-3">
    @yield('content')
  </main>

  <footer class="container site-wrapper py-3 text-center">
    <a href="https://php-cat.com">Создание сайта — php-cat.com</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
