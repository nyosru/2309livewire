# История друзей и подписчиков VK

## Модели и правила хранения

- `VkManagerAccount` (`vk_manager_accounts`) — VK-аккаунт, которым управляет сайт. Связан с авторизованной Laravel-записью `User`; владельца определяем только по текущей сессии.
- `VkManagerPerson` (`vk_manager_people`) — единая карточка профиля по уникальному VK ID: имя, домен и аватар.
- `VkManagerMembership` (`vk_manager_memberships`) — интервал состояния профиля в конкретном аккаунте: `friend`, `follower` или `outgoing_request` (исходящая заявка владельца), дата начала, дата окончания, источник и флаг текущей записи.
- `VkManagerProfileData`, `VkManagerEducationData`, `VkManagerContactData` — отдельные истории расширенных данных профиля, учёбы/работы/службы и контактов/ссылок. Каждая запись связана с аккаунтом-владельцем и `VkManagerPerson`; полученные поля лежат в `data` (JSON), источник — в `source`, дата устаревания — в `obsolete_at`.
- `VkManagerContact` остаётся для личных заметок и отметки «избранное»; это не история отношений.

Текущая запись отношения имеет `is_current = true`, `ended_at = null`. При смене статуса старая запись получает `is_current = false` и `ended_at`, затем создаётся новая запись. Для трёх моделей расширенных данных текущая запись имеет `obsolete_at = null`. При получении нового отличающегося значения старая запись получает `obsolete_at`, а новая сохраняет обновлённый JSON; если значение не менялось — новая строка не создаётся. Поля, которых нет в ответе VK, не затирают сохранённые значения. Повторная фиксация того же статуса — no-op. Статус `none` закрывает текущую запись без создания записи `none`.

Загрузка страницы списков фиксирует увиденные записи текущей страницы. Так как это частичное наблюдение, отсутствие профиля на этой странице никогда не закрывает его статус. Полная сверка загружает друзей, подписчиков и исходящие заявки через `friends.getRequests` с `out=1`, затем атомарно меняет статусы. Подтверждение заявки переводит `outgoing_request` в `friend`: период заявки закрывается, создаётся новый период дружбы. Если заявка исчезла без перехода в друзья, период заявки просто закрывается. Вызывайте `reconcileSnapshot()` только с полными, не обрезанными снимками всех трёх списков.

Полная сверка фиксирует время первого обнаружения заявки. Сам VK API не предоставляет надёжную дату отправки исходящей заявки, поэтому для точного времени агент, который отправляет заявку, должен записать `outgoing_request` сразу после подтверждения отправки.

Для первоначальной загрузки текущих полных списков используйте `php artisan vk-manager:sync-history <user_id>`. Команда читает все страницы VK с интервалом в одну секунду между запросами и только после успешной загрузки трёх списков применяет полную сверку. Она не выводит токен. Не запускайте её для другого Laravel user ID.

## Для агентов, выполняющих действия с друзьями

Записывайте результат только после того, как VK подтвердил действие. Не записывайте намерение или неудачную попытку.

В коде приложения вызывайте `App\Services\VkManagerHistoryService::recordChange()`. `User` — авторизованный владелец аккаунта, `vkId` — ID изменённого контакта, `status` — `friend`, `follower`, `outgoing_request` или `null` (контакт больше не в наблюдаемых списках):

```php
$history = app(\App\Services\VkManagerHistoryService::class);

// VK подтвердил, что удалённый из друзей контакт остался подписчиком.
$history->recordChange(
    owner: $request->user(),
    vkId: '313393866',
    status: 'follower',
    profile: [
        'first_name' => 'Злата',
        'last_name' => 'Максимова',
    ],
    source: 'friend_removal_agent',
);

// VK подтвердил отправку исходящей заявки. Время вызова записывается как начало периода заявки.
$history->recordChange(
    owner: $request->user(),
    vkId: '313393866',
    status: 'outgoing_request',
    profile: ['first_name' => 'Злата', 'last_name' => 'Максимова'],
    source: 'friend_request_agent',
);

// VK подтвердил, что владелец заявки теперь дружит с контактом.
$history->recordChange(
    owner: $request->user(),
    vkId: '313393866',
    status: 'friend',
    source: 'friend_request_accepted',
);

// VK подтвердил удаление из подписчиков: закрыть текущую запись, новую не создавать.
$history->recordChange($request->user(), '313393866', null, [], 'follower_removal_agent');
```

Для пакетного наблюдения частичного списка:

```php
$history->observeLists($request->user(), $friendsPage, $followersPage, 'vk_api_page');
```

Для полной сверки передайте все страницы друзей и подписчиков:

```php
$history->reconcileSnapshot(
    $request->user(),
    $allFriends,
    $allFollowers,
    'vk_api_full_snapshot',
    $allOutgoingRequests,
);
```

Не передавайте `account_id` или владельца из пользовательского ввода. Сервис получает аккаунт из `User`, сериализует изменения по аккаунту в транзакции и сам закрывает прежний статус.

## HTTP-запрос из авторизованной страницы

Для browser-агентов и скриптов, работающих в странице `vk.php-cat.ru`, доступен same-origin маршрут:

```http
POST https://vk.php-cat.ru/history/status
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: <значение meta[name="csrf-token"]>
X-Requested-With: XMLHttpRequest
```

Пример тела:

```json
{
  "vk_id": "313393866",
  "status": "follower",
  "first_name": "Злата",
  "last_name": "Максимова",
  "domain": "example",
  "photo_url": "https://example.com/avatar.jpg",
  "source": "browser_agent"
}
```

Допустимые значения `status`: `friend`, `follower`, `outgoing_request`, `none`. `none` завершает текущую запись без новой. Для точной даты заявки отправьте запрос сразу после подтверждения VK. Маршрут требует авторизованную сессию и CSRF-токен; аккаунт-владелец берётся из сессии. Не передавайте cookies, VK access token, пароль или коды входа агентам и внешним сервисам. Для серверного кода внутри приложения предпочтителен прямой вызов `VkManagerHistoryService`.

Ответ содержит `changed`, `previous_status`, `status` и ID созданной записи `membership_id` (для закрытия состояния он равен `null`).

### HTTP API для нейросетевого агента

Публичная инструкция: <https://vk.php-cat.ru/instructions>. Она открывается без авторизации. API со списками и записью заметок требует отдельный Laravel Sanctum токен владельца аккаунта; не публикуйте этот токен и не добавляйте его в общий текст инструкции.

Создайте токен под тем Laravel-пользователем, чей VK-аккаунт подключён к `vk.php-cat.ru`:

```bash
docker exec 2309livewire php artisan tinker --execute='$user = \App\Models\User::findOrFail(123); echo $user->createToken("vk-manager-neural-agent")->plainTextToken;'
```

Замените `123` на ID этого пользователя. Сохраните выведенный токен в закрытых настройках агента. Не передавайте агенту VK access token, cookie браузера или пароль от аккаунта.

Для всех запросов используйте заголовки:

```http
Authorization: Bearer <SANCTUM_TOKEN>
Accept: application/json
Content-Type: application/json
```

1. Сначала запросите полную сверку VK. Она загружает все три списка и обновляет историю только после успешного получения полного снимка:

```http
POST https://vk.php-cat.ru/api/vk-manager/agent/sync
```

2. Получите друзей, подписчиков и исходящие заявки. По умолчанию возвращается до 200 записей каждого списка; `limit` можно задать от 1 до 500, `offset` — с нуля:

```http
GET https://vk.php-cat.ru/api/vk-manager/agent/lists?limit=200&offset=0
```

Ответ содержит `lists.friends`, `lists.followers` и `lists.outgoing_requests`. В каждом списке указаны `total`, `has_more` и `items`. Для следующей страницы увеличьте `offset` на `limit`, пока `has_more` равно `true`. Записи включают VK ID, имя, домен, ссылку на аватар, текущий статус, дату начала периода, заметку и отметку избранного. Поле `account.last_full_sync_at` показывает время последней успешной полной сверки.

3. Добавьте или обновите собственную информацию агента к профилю и/или отметку избранного. Информация агента хранится отдельно от личного комментария владельца. Профиль должен присутствовать в истории этого аккаунта:

```http
PUT https://vk.php-cat.ru/api/vk-manager/agent/people/313393866/notes
```

```json
{
  "agent_comment": "Заметка агента о контакте",
  "is_favorite": true
}
```

Передавайте одно или оба поля. `agent_comment: null` очищает заметку агента. Поле `comment` в ответе остаётся заметкой владельца аккаунта. Запись заметки не меняет историю отношений.

4. После подтверждённого VK действия можно записать новый статус контакта:

```http
POST https://vk.php-cat.ru/api/vk-manager/agent/history/status
```

```json
{
  "vk_id": "313393866",
  "status": "outgoing_request",
  "first_name": "Злата",
  "last_name": "Максимова",
  "profile": {
    "bdate": "12.05.1995",
    "city": {"id": 1, "title": "Москва"},
    "education": {"university": 1, "university_name": "МГУ"},
    "mobile_phone": "+7…"
  },
  "source": "neural_agent"
}
```

`profile` необязателен. Сервис сохраняет только известные поля трёх категорий и игнорирует остальные. Не передавайте токены, пароли или cookies. VK может не вернуть закрытые профилем сведения.

Допустимые статусы: `friend`, `follower`, `outgoing_request`, `none`. Передавайте новый статус только после того, как VK подтвердил действие. Для удаления текущего статуса используйте `none`.

Все API-маршруты ограничены авторизованным Sanctum токеном и лимитом запросов. Если агент получает `401`, проверьте токен. Если список отвечает `409`, сначала выполните полную сверку через `/sync`.

## Выборки

```php
// Все профили, которые когда-либо были друзьями или подписчиками аккаунта.
$people = \App\Models\VkManagerPerson::query()
    ->whereHas('memberships', fn ($query) => $query->where('account_id', $accountId))
    ->get();

// Текущие друзья.
$currentFriends = \App\Models\VkManagerMembership::query()
    ->with('person')
    ->where('account_id', $accountId)
    ->where('status', 'friend')
    ->where('is_current', true)
    ->get();

// Все завершённые периоды, когда контакт был подписчиком.
$formerFollowerPeriods = \App\Models\VkManagerMembership::query()
    ->with('person')
    ->where('account_id', $accountId)
    ->where('status', 'follower')
    ->where('is_current', false)
    ->get();
```
