# 2309livewire — AGENTS.md

## Overview
Laravel 10 + Livewire 3 + Volt multi-site monolith running in Docker. Routes for different domains are split across `routes/web.*.php` files and loaded from `routes/web.php`. Host-based routing is done via `Route::group(['domain' => ...])` closures.

докер контейнер: `2309livewire`

## Quick commands

```bash
# Lint (Pint)
make linter                    # fix all
make linter-show               # dry-run, show issues
make linter-file-show FILE=X   # dry-run on one file
make linter-file-fix FILE=X    # fix one file

# Docker
make bash                      # docker exec -it 2309livewire bash

# Tailwind (inside container)
make tailwind                  # watches resources/css/app.css → public/css/output.css

# Dev server (via Vite, outside Docker)
npm run dev                    # vite
npm run build                  # vite build

# Tests
php artisan test               # PHPUnit (Feature + Unit)
# DB tests are NOT configured by default — sqlite config is commented out in phpunit.xml

# Artisan
docker exec 2309livewire php artisan <command>
```

## Architecture

- **Livewire components**: `app/Livewire/` — organized by sub-project (Phpcat/, StNews/, Auth/, etc.)
- **Controllers**: `app/Http/Controllers/` — organized by sub-project
- **Models**: `app/Models/` — mostly separate Eloquent models per domain
- **Route files**: Each sub-site has its own `routes/web.{name}.php`, loaded via `require()` in `routes/web.php`
- **Custom Blade directives**: `@permission` and `@anyPermission` defined in `AppServiceProvider` — uses Spatie Permission, with hardcoded email bypasses (`1@php-cat.com`, `nyos@rambler.ru`)
- **SSL verify disabled globally**: `Http::globalOptions(['verify' => false])` in `AppServiceProvider::boot()`

## Key dependencies

- `livewire/livewire` ^3.4 — components in `App\Livewire` namespace
- `livewire/volt` ^1.0 — Volt functional components
- `spatie/laravel-permission` ^6.21 — RBAC
- `laravel/socialite` + `socialiteproviders/vkontakte` — VK OAuth
- `endroid/qr-code` — QR generation
- `vkcom/vk-php-sdk` — VK API
- `nyos/msg` — custom/private package for Telegram messaging

## Console commands

| Signature | File | Scheduled |
|---|---|---|
| `app:send-status` | `SendStatus.php` | Every 15s (with 3s time limit) |
| `StNews:news-parse` | `NewsParse.php` | No |
| `StNews:news-download-photo` | `NewsDownloadPhoto.php` | No |
| `app:news-auto-moderate` | `NewsAutoModerate.php` | No |

## CI/CD

| Branch | Server | Workflow |
|---|---|---|
| `main` | 45.12.72.4 | `deploy-main.yml` — `git fetch --hard reset` + `composer i` + `migrate` |
| `cicd_to_ihc_docker24` | 91.218.230.97 | same via `deploy-cicd_to_ihc_docker24.yml`, uses `composer i --no-dev` + `view:clear`, `cache:clear`, `config:cache` |

Deployment sends Telegram notifications to chat ID `360209578`.

## Config quirks

- `config/custom.php` — loads `REDIRECT_DOMAIN{1..10}` env vars for domain-level redirects
- `config/telegram.php` — loads `TELEGRAM_BOT_TOKEN_FOR_BACKWORD` + `TELEGRAM_ID_{1..10}`
- `config/services.php` — VK OAuth and GigaChat credentials
- Livewire `class_namespace` is `App\Livewire`, `view_path` is `resources/views/livewire`
- `.env.example` shows all expected env vars

## Blog API — создание записей AI-агентами

### Эндпоинт
```
POST https://php-cat.ru/api/blog
Content-Type: application/json
X-Blog-Api-Key: <ключ из .env BLOG_API_KEY>
```

### Параметры (JSON body)
| Поле | Тип | Обязательное | Описание |
|---|---|---|---|
| `title` | string | да | Заголовок записи |
| `content` | string | да | Текст записи (абзацы через \n\n) |
| `tag` | string | нет | Категория (Статья, Обзор, Гайд, Подборка и т.п.) |
| `excerpt` | string | нет | Краткое описание для списка |
| `is_published` | bool | нет | Опубликовать сразу (по умолч. true) |

### Успешный ответ (201)
```json
{
  "message": "Post created successfully",
  "post": {
    "id": 1,
    "title": "Заголовок",
    "slug": "zagolovok",
    "url": "https://php-cat.ru/blog/zagolovok"
  }
}
```

### Ошибка (401)
```json
{ "error": "Invalid API key" }
```

### Пример cURL
```bash
curl -X POST https://php-cat.ru/api/blog \
  -H "Content-Type: application/json" \
  -H "X-Blog-Api-Key: your-key-here" \
  -d '{
    "title": "Новая статья",
    "content": "Первый абзац.\n\nВторой абзац.",
    "tag": "Статья",
    "excerpt": "Краткое описание"
  }'
```

### UI
Форма добавления: `https://php-cat.ru/blog/admin/create`

## Git commit workflow

When the user asks to make a commit:

1. Show current changes with `git diff --staged` and `git diff --stat`
2. If no files are staged, run `git add -A` and show the diff again (новые файлы тоже добавляй)
3. Analyze the changes and write a descriptive commit message in Conventional Commits format (`type(scope): description`) на русском языке
4. Execute `git commit -m "<message>"`
5. Show the commit result

Common types: feat, fix, chore, docs, refactor, test, style, perf

## Testing

- PHPUnit 10, tests in `tests/Feature/` and `tests/Unit/`
- DB tests require uncommenting sqlite in `phpunit.xml` — not set up by default
- `php artisan test` to run all
