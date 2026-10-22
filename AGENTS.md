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




## Проверка паролей WiFi-хендшейков (bruteforce)

Когда тестируем хендшейк (подбор пароля по .cap) и проверяем пароли — **обязательно записывать результат в БД**:

- Файл БД: `/Users/phpcat/PhpstormProjects/2309livewire/database/passwords.sqlite`

### Схема (2 таблицы)
1. `handshakes` — информация о хендшейке: `ssid`, `bssid`, `cap_file`, `captured_at`.
2. `attacks` — информация о переборе: `handshake_id` (FK → handshakes), `mask` + `mask_desc` (какая маска проверялась), `status` (`cracked` | `not_found` | `stopped`), `password` (найденный пароль или NULL), `keyspace`, `speed_khs`, `started_at`/`finished_at`, `tool` (по умолчанию `hashcat`).

### Правила
- Записывать **все** результаты, включая неудачные (`not_found`) и прерванные (`stopped`).
- Если сеть ещё не в `handshakes` — сначала добавить запись о хендшейке, потом подбор в `attacks`.
- Не дублировать: для уже известного (ssid + bssid) хендшейка переиспользовать существующий `handshake_id`.
- Пример добавления записи о переборе:
  ```sql
  INSERT INTO attacks (handshake_id, mask, mask_desc, status, password, keyspace, speed_khs)
  VALUES (12, '?d?d?d?d?d?d?d?d', '8 цифр', 'not_found', NULL, 100000000, 115.2);
  ```

## MAX — общий сервис для сайтов и серверных проектов

- Использовать `App\Services\Max\MaxService` для прямого API MAX; не копировать HTTP-запросы по контроллерам сайтов. Подробности: [docs/max.md](docs/max.md).
- `sendToUser($maxUserId, $text)` и `sendToChat($chatId, $text)` отправляют текст напрямую на `https://platform-api2.max.ru`. Токен передаётся только в заголовке `Authorization`, TLS-проверка включена.
- Настройки только через `config('max.*')`: `.env` → `MAX_BOT_TOKEN`, `MAX_BOT_USERNAME` (без @), `MAX_WEBHOOK_SECRET`, `MAX_WEBHOOK_URL`, `MAX_CA_BUNDLE`. Для MAX используется отдельный CA-файл; источник и отпечаток — в `resources/certs/README.md`, системное хранилище доверия не меняется. Не выводить токены, коды и тексты авторизационных сообщений в логи.
- MAX Bot API не ищет пользователя по телефону. Для кодов по телефону нужна проверенная привязка в `max_recipients`: нормализованный телефон → MAX user_id. `App\Services\Max\RecipientRegistry::register($phone, $maxUserId)` вызывается из доверенного административного кода или webhook после проверки подписанного контакта через `SignedContact`; сама привязка не выдаёт прав на сайт.
- При запуске бота webhook предлагает `request_contact` («Поделиться телефоном»). `SignedContact` проверяет HMAC-SHA256 vCard токеном бота и совпадение MAX ID контакта с отправителем. Принимаются только подписанные собственные контакты из личного диалога без пересылки; обычные контакты и текст с телефоном не подтверждают владение. Webhook `/api/max/webhook` проверяет `X-Max-Bot-Api-Secret`, отсекает повторы, сохраняет привязку и не выдаёт доступ к сайту. `/id` оставлен для диагностики, пользователю он не нужен.
- Регистрация webhook: `docker exec 2309livewire php artisan max:register-webhook`. Нужен публичный HTTPS на 443 и доверенный сертификат; `.local` не подходит для доставки событий с серверов MAX.
- Коды входа — `App\Services\Max\MaxAuthService`: `begin($phone, $purpose, $browserToken, $ip, true, $siteName)` → локальная проверка; `confirm($id, $purpose, $browserToken, $code)` → подтверждённый телефон либо `null`.
- Для каждого сайта задавать свой постоянный `$purpose`, например `another-site.login`. `$browserToken` — случайная строка от 32 символов, хранящаяся в серверной сессии. Не брать purpose из клиентского запроса. После `confirm` отдельно проверять права на конкретный сайт.
- Коды шестизначные, действуют 5 минут, хранятся только хешами; максимум 5 попыток, повторная отправка не чаще минуты. Новый код отменяет предыдущий в том же purpose; код одноразовый и привязан к сессии. Пользовательский ввод `max_code` не сохраняется через old input.
- `MAX_AUTH_DRIVER=disabled` по умолчанию. Режим `bot` включает прямую доставку кодов созданным ботом при наличии токена и привязок. Авторизационные сообщения через Bot API должны быть предусмотрены договором с MAX (п. 1.5 требований платформы). Отдельный прямой сервис авторизационных сообщений по телефону потребует выданных MAX доступа и документации; не подменять его сторонним провайдером и не выдумывать API.
- Для отдельного приложения на сервере доступны POST `/api/max/service/message`, `/api/max/service/auth/start`, `/api/max/service/auth/check`. Настроить `MAX_AUTH_SERVICE_CLIENTS` как JSON `{"project-name":"random-server-secret-at-least-32-characters"}`. Запросы только с серверов: заголовки `X-Max-Service-Client`, `X-Max-Service-Key`; ключи запрещено передавать в браузер. Контекст и purpose разных клиентов изолированы.
- Доступ кафе без VK хранится в `vkusno_phone_administrators`. Выдаётся суперадминистратором в `/admin/access` (только телефон) или командой `vkusno:max-admin '<phone>' --name='Имя'`. MAX-аккаунт Laravel создаётся только после правильного кода, не связывается с существующими пользователями по email/телефону.
- `VKUSNO_SUPER_ADMIN_PHONE` — телефон MAX-суперадминистратора в `.env`, формат `+79XXXXXXXXX`. Права доступны только после подтверждения кода. Перед первым входом владелец делится телефоном кнопкой в боте; привязка с MAX ID сохраняется автоматически. Первый посетитель с другим номером не получает прав суперадминистратора. Существующий `VKUSNO_SUPER_ADMIN_VK_ID` продолжает работать.
- Отзыв доступа к кафе отменяет его незавершённые проверки и блокирует следующий запрос уже открытой сессии. Общая привязка получателя остаётся для других проектов.
- Миграция: `2026_10_22_000005_create_max_auth_tables.php`. Проверки: `docker exec 2309livewire php artisan test --compact tests/Feature/Vkusno`. Использовать `Http::fake()`; не отправлять реальные коды при тестировании.
