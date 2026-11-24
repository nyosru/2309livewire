# Calls: дерево проектов

Локальный сайт: https://calls.local/. Слева — вложенные ветки от «Базовой», справа — непривязанные записи. У ветки есть название, тип и проект. На карточке записи можно выбрать ветку либо «Без ветки»; перенос заменяет предыдущую привязку. Привязки хранятся в БД, оригинальные файлы не изменяются и не перемещаются.

Каталог читает MP3 (включая `.MP3`) из корня и каталогов `YYYY-MM-DD` обоих источников. Идентификатор записи — SHA-256 от источника и относительного пути: одинаковые имена в разные даты не конфликтуют. Сохраняются старые теги диктофона. Дата берётся из метаданных `.txt.summary.json`, затем из папки даты, затем из времени файла (пометка «по файлу»). Новые записи расположены выше старых. Расшифровки и сводки загружаются при раскрытии; поддерживаются `_summary.md` и `-summary.md`.

## Настройка

- `config/calls.php`: `CALLS_AUDIO_PATH` и `CALLS_RECORDER_PATH` при необходимости меняют стандартные пути `/Volumes/sam1kk/00 звонки` и `/Volumes/sam1kk/00 запись диктофон`.
- Миграция: `docker exec 2309livewire php artisan migrate --path=database/migrations/2026_11_19_000001_create_calls_branches_tables.php --force`.
- Проверки: `docker exec 2309livewire php artisan test --compact tests/Feature/Calls` (отдельная SQLite-база в памяти, временные аудиофайлы).

## Локальный Docker

PHP-контейнеру необходим прямой доступ к обеим папкам: подключения только в Caddy недостаточно. Дополнительный файл `docker.calls.override.yml` подключает звонки только для чтения, сохраняя остальные подключения PHP-контейнера. При пересоздании PHP-контейнера использовать оба файла:

```sh
docker compose \
  -f /Users/phpcat/PhpstormProjects/2304bu_serv-docker/docker-compose.yml \
  -f /Users/phpcat/PhpstormProjects/2309livewire/docker.calls.override.yml \
  up -d --no-deps --no-build 2309livewire
```

В `/Users/phpcat/PhpstormProjects/2508caddy_local/docker-compose.local.yml` обе папки также подключены к Caddy только для чтения. `make dev` из этого каталога обновляет Caddy; контейнер PHP управляется отдельным Compose-проектом выше. В `Makefile` исправлены вызов вложенного make и обращение к Caddy по имени сервиса.
