# Самые Тюменские Новости (STN)

Документация по сайту новостей «Самые Тюменские Новости» для AI-агентов и разработчиков.

- **Локальный домен:** `stn.local`
- **Продакшн-домен:** punycode (`xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai`)
- **Стек:** Laravel 10 + Livewire 3 + Volt, Docker-контейнер `2309livewire`
- **Подписка:** https://vk.com/tymenskie

## Маршруты

- `routes/web.stn.php` — публичные страницы (группа по домену, префикс `stn.`).
- `routes/api.stn.php` — парсинг и админка (те же closure, доступны на `stn.local`).

Главная (`/`) → `App\Livewire\StNews\Index` → `resources/views/livewire/st-news/index.blade.php`.
Страница собирает виджеты: ссылка на VK, `StNewsList` (лента), `StNews.backword` (форма обратной связи), `StNews.money` (пожертвования).

Модерация: `/moderation`, `/m`. Страница одной новости: `/news/{id}` → `App\Livewire\StNews\Show`.

## Компоненты и модели

| Что | Класс / путь |
|---|---|
| Главная | `App\Livewire\StNews\Index` |
| Лента новостей | `App\Livewire\StNewsList` |
| Карточка новости | `App\Livewire\StNews\StNewsItem` |
| Модерация | `App\Livewire\StNews\StNewsModeration`, `ModerateNews`, `ModerationItem` |
| Модель | `App\Models\StNews` (табл. `st_news`) |
| Фото | `App\Models\StNewsPhoto` (табл. `st_news_photos`) |
| Источник | `App\Models\StNewsParsingSite` |
| Категория | `App\Models\StNewsParsingCategory` |
| Парсинг-контроллер | `App\Http\Controllers\StNews\ParseController` |

### Лента (`StNewsList`)

Пагинирует (по 10) новости с условиями:

```php
StNews::where('moderation', true)
    ->where('moderation_required', true)
    ->where('content', '!=', '')
    ->orderBy('published_at', 'desc')
    ->paginate(10);
```

То есть в ленте видны только **прошедшие модерацию, требующие проверки и с непустым текстом** новости, отсортированные по дате публикации.

### Модель `StNews`

Поля (`$fillable`): `title`, `summary`, `content`, `source`, `published_at`, `promo_code`, `moderation_required`, `told_at`, `cat_id`, `site_id`. Есть soft deletes. `published_at` приведён к `datetime`.

Связи:
- `category()` → `StNewsParsingCategory` (по `cat_id`)
- `site()` → `StNewsParsingSite` (по `site_id`)
- `photos()` / `firstPhoto()` → `StNewsPhoto`

Фото берётся через `firstPhoto()`: сначала `local_photo` (локальная коия), иначе `image_path`. Источник в карточке вычисляется как `parse_url($newsItem->source, PHP_URL_HOST)`.

### Режим админки / дебага

Если в URL есть `?ss=1`:
- в ленте показываются кнопки удаления новости (`StNewsItem::deleteNews`);
- на главной рендерится форма создания `@livewire('st-news-create')`.

## Макет и стили

- Макет: `resources/views/st_news/layouts/app.blade.php` — шрифт Roboto (+ Figtree), подключён Tailwind-билд `public/css/output.css`, Яндекс.Метрика.
- Header/footer: `resources/views/st_news/layouts/header.blade.php`, `.../footer.blade.php`.
- `output.css` — **общий для всех подсайтов** моноклона. Собирается из `resources/css/app.css` по `content`-глобам из `tailwind.config.js` (охватывают все `resources/views/**/*.blade.php`).

### Дизайн блока новостей (обновлён 2026-10-25)

Принципы: **Игорь Манн** (заголовок как главное, польза в подзаголовке, явный CTA, прозрачность источника) + **швейцарская школа Й. Мюллера-Брокмана** (строгая сетка, выравнивание, типографическая иерархия, ограниченная палитра, воздух) + **Бруно Мунари** (функциональность, минимум декора — тонкие границы вместо тяжёлых теней).

Что сделано:
- **Карточка** `resources/views/livewire/st-news/st-news-item.blade.php`: фото с фиксированным соотношением 16:10 (`.stn-photo`), крупный заголовок с лимитом 3 строки (`.stn-headline`), мета-строка «дата + источник (домен)», акцентная ссылка «Читать дальше», hover-подъём с оранжевой рамкой. Кнопка удаления вынесена из `<a>` (валидный HTML).
- **Лента** `resources/views/livewire/st-news-list.blade.php`: секционный заголовок «Новости Тюмени» с подзаголовком, сетка 1/2/3 колонки (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`, `gap-6`), пустое состояние с CTA на VK.
- **Scoped-стили** (`.stn-news .stn-headline/.stn-photo/.stn-card`) лежат в `<style>` внутри макета `st_news/layouts/app.blade.php`.

Палитра: синий (основной), оранжевый (акцент), `neutral` (текст/мета).

> **Правило:** после добавления новых Tailwind-классов в blade **обязательно пересобирать `output.css`**, иначе классы не отрисуются. Билд общий для всех сайтов — **не сужай `content`**:
> ```bash
> docker exec 2309livewire npx tailwindcss -i ./resources/css/app.css -o ./public/css/output.css --mode=list
> ```
> (~2 с, без `--watch`).

> **Русский текст:** неразрывные пробелы (`U+00A0` / `&nbsp;`) после однобуквенных предлогов/союзов (`а, в, и, к, о, с, у, я`) в пользовательском тексте — см. `.cursor/rules/russian-nonbreaking-spaces.mdc`.

## VK-уведомления STN

Отправка сообщений от имени сообщества в ВК (например, отчёт о добавленных новостях администратору):

- `VK_STN_GROUP_ID` — id сообщества (226660164).
- `VK_STN_GROUP_API_TOKEN` — ключ доступа группы (user/group token).
- `VK_STN_ADMIN_ID` — id получателя внутри ВК (адресат сообщения).

Использовать именно эти имена. Старые `VK_GROUP_ID` / `VK_GROUP_API_TOKEN` (рядом с `VK_GROUP_TOKEN`) относятся к формам заявок php-cat.ru и для STN не применяются — не перезаписывать.

## Парсинг и автоматизация

`routes/api.stn.php`:
- `parse` / `parser` — запуск парсинга (`ParseController::parse`).
- `parsing/catalog` — тянуть каталоги источников.
- `parsing/news` — список новостей из каталога.
- `parsing/news_full` — грузить содержимое новостей.
- `auto-moderate` — авто-умерация через `App\Services\StNews\AutoModerationNewsServices`.

Команды: `StNews:news-parse`, `StNews:news-download-photo`, `app:news-auto-moderate`.

## Быстрые команды

```bash
# Открыть главную STN (host из /etc/hosts: 127.0.0.1 stn.local)
curl -H "Host: stn.local" http://127.0.0.1:80/

# Собрать Tailwind (output.css)
docker exec 2309livewire npx tailwindcss -i ./resources/css/app.css -o ./public/css/output.css --mode=list

# Очистить кэш представлений после правки blade
docker exec 2309livewire php artisan view:clear

# Посмотреть, сколько новостей в ленте
docker exec 2309livewire php artisan tinker --execute="echo \App\Models\StNews::where('moderation',1)->where('moderation_required',1)->where('content','!=','')->count();"
```
