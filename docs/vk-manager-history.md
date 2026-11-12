# История друзей и подписчиков VK

## Модели и правила хранения

- `VkManagerAccount` (`vk_manager_accounts`) — VK-аккаунт, которым управляет сайт. Связан с авторизованной Laravel-записью `User`; владельца определяем только по текущей сессии.
- `VkManagerPerson` (`vk_manager_people`) — единая карточка профиля по уникальному VK ID: имя, домен и аватар.
- `VkManagerMembership` (`vk_manager_memberships`) — интервал состояния профиля в конкретном аккаунте: `friend` или `follower`, дата начала, дата окончания, источник и флаг текущей записи.
- `VkManagerContact` остаётся для личных заметок и отметки «избранное»; это не история отношений.

Текущая запись имеет `is_current = true`, `ended_at = null`. При смене статуса старая запись получает `is_current = false` и `ended_at`, затем создаётся новая запись. Повторная фиксация того же статуса — no-op. Статус `none` закрывает текущую запись без создания записи `none`.

Загрузка страницы списков фиксирует увиденные записи текущей страницы. Так как это частичное наблюдение, отсутствие профиля на этой странице никогда не закрывает его статус. Для полной сверки передавайте все страницы обоих списков в `reconcileSnapshot()`; вызывайте его только с полным, не обрезанным снимком.

Для первоначальной загрузки текущих полных списков используйте `php artisan vk-manager:sync-history <user_id>`. Команда читает все страницы VK с интервалом в одну секунду между запросами и только после успешной загрузки обоих списков применяет полную сверку. Она не выводит токен. Не запускайте её для другого Laravel user ID.

## Для агентов, выполняющих действия с друзьями

Записывайте результат только после того, как VK подтвердил действие. Не записывайте намерение или неудачную попытку.

В коде приложения вызывайте `App\Services\VkManagerHistoryService::recordChange()`. `User` — авторизованный владелец аккаунта, `vkId` — ID изменённого контакта, `status` — `friend`, `follower` или `null` (контакт больше не в обоих списках):

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

// VK подтвердил удаление из подписчиков: закрыть текущую запись, новую не создавать.
$history->recordChange($request->user(), '313393866', null, [], 'follower_removal_agent');
```

Для пакетного наблюдения частичного списка:

```php
$history->observeLists($request->user(), $friendsPage, $followersPage, 'vk_api_page');
```

Для полной сверки передайте все страницы друзей и подписчиков:

```php
$history->reconcileSnapshot($request->user(), $allFriends, $allFollowers, 'vk_api_full_snapshot');
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

Допустимые значения `status`: `friend`, `follower`, `none`. `none` завершает текущую запись без новой. Маршрут требует авторизованную сессию и CSRF-токен; аккаунт-владелец берётся из сессии. Не передавайте cookies, VK access token, пароль или коды входа агентам и внешним сервисам. Для серверного кода внутри приложения предпочтителен прямой вызов `VkManagerHistoryService`.

Ответ содержит `changed`, `previous_status`, `status` и ID созданной записи `membership_id` (для закрытия состояния он равен `null`).

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
