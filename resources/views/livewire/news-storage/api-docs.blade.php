<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">API для AI-агентов</h1>
    <p class="text-gray-500 mb-8">Документация по добавлению и управлению новостями через API</p>

    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
        <p class="text-sm text-yellow-800">
            <strong>Базовый URL:</strong> <code class="bg-yellow-100 px-1 rounded">https://news.api.php-cat.ru/api/news-storage</code>
        </p>
        <p class="text-sm text-yellow-800 mt-1">
            <strong>Авторизация:</strong> заголовок <code class="bg-yellow-100 px-1 rounded">X-NewsStorage-Api-Key</code>
        </p>
    </div>

    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Добавить новость</h2>

        <div class="bg-gray-50 rounded p-4 mb-4">
            <span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-1 rounded mr-2">POST</span>
            <code class="text-sm">/api/news-storage/news</code>
        </div>

        <h3 class="font-semibold text-gray-700 mb-2">Заголовки</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Заголовок</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Значение</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 font-mono">Content-Type</td>
                        <td class="px-4 py-2 font-mono">application/json</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">X-NewsStorage-Api-Key</td>
                        <td class="px-4 py-2 font-mono">{{ config('custom.NEWSSTORAGE_API_KEY') ? '••••••••' : '<не задан>' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="font-semibold text-gray-700 mb-2">Параметры (JSON body)</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Поле</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Тип</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Обязательное</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Описание</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 font-mono">source_id</td>
                        <td class="px-4 py-2">integer</td>
                        <td class="px-4 py-2"><span class="text-green-600">да</span></td>
                        <td class="px-4 py-2">ID источника новостей</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">url</td>
                        <td class="px-4 py-2">string</td>
                        <td class="px-4 py-2"><span class="text-green-600">да</span></td>
                        <td class="px-4 py-2">Ссылка на оригинальную новость</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">title</td>
                        <td class="px-4 py-2">string</td>
                        <td class="px-4 py-2"><span class="text-green-600">да</span></td>
                        <td class="px-4 py-2">Заголовок новости</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">summary</td>
                        <td class="px-4 py-2">text</td>
                        <td class="px-4 py-2"><span class="text-red-500">нет</span></td>
                        <td class="px-4 py-2">Краткое описание</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">content</td>
                        <td class="px-4 py-2">text</td>
                        <td class="px-4 py-2"><span class="text-red-500">нет</span></td>
                        <td class="px-4 py-2">Полный текст новости</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">media</td>
                        <td class="px-4 py-2">array</td>
                        <td class="px-4 py-2"><span class="text-red-500">нет</span></td>
                        <td class="px-4 py-2">Массив медиа-вложений</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="font-semibold text-gray-700 mb-2">Поля media</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Поле</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Тип</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Описание</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 font-mono">url</td>
                        <td class="px-4 py-2">string</td>
                        <td class="px-4 py-2">Ссылка на изображение, видео или файл</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono">type</td>
                        <td class="px-4 py-2">string</td>
                        <td class="px-4 py-2">Тип: <code class="bg-gray-200 px-1 rounded">image</code>, <code class="bg-gray-200 px-1 rounded">video</code>, <code class="bg-gray-200 px-1 rounded">json</code>, <code class="bg-gray-200 px-1 rounded">other</code></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="font-semibold text-gray-700 mb-2">Пример запроса (cURL)</h3>
        <pre class="bg-gray-900 text-green-400 text-sm rounded-lg p-4 overflow-x-auto mb-4"><code>curl -X POST https://news.api.php-cat.ru/api/news-storage/news \
  -H "Content-Type: application/json" \
  -H "X-NewsStorage-Api-Key: ваш-ключ" \
  -d '{
    "source_id": 1,
    "url": "https://example.com/news/article",
    "title": "Заголовок новости",
    "summary": "Краткое описание новости",
    "content": "Полный текст новости",
    "media": [
      {"url": "https://example.com/photo.jpg", "type": "image"},
      {"url": "https://example.com/video.mp4", "type": "video"}
    ]
  }'</code></pre>

        <h3 class="font-semibold text-gray-700 mb-2">Успешный ответ (201)</h3>
        <pre class="bg-gray-900 text-green-400 text-sm rounded-lg p-4 overflow-x-auto"><code>{
  "message": "News record created successfully",
  "news": {
    "id": 1,
    "source_id": 1,
    "url": "https://example.com/news/article",
    "title": "Заголовок новости",
    "summary": "Краткое описание новости",
    "content": "Полный текст новости",
    "status": "new",
    "media": [
      {"id": 1, "url": "https://example.com/photo.jpg", "type": "image"},
      {"id": 2, "url": "https://example.com/video.mp4", "type": "video"}
    ]
  }
}</code></pre>
    </section>

    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Изменить статус новости</h2>

        <div class="bg-gray-50 rounded p-4 mb-4">
            <span class="inline-block bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded mr-2">PATCH</span>
            <code class="text-sm">/api/news-storage/news/{id}/status</code>
        </div>

        <h3 class="font-semibold text-gray-700 mb-2">Параметры (JSON body)</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Поле</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Тип</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Обязательное</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Описание</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 font-mono">status</td>
                        <td class="px-4 py-2">string</td>
                        <td class="px-4 py-2"><span class="text-green-600">да</span></td>
                        <td class="px-4 py-2">Новый статус: <code class="bg-gray-200 px-1 rounded">new</code>, <code class="bg-gray-200 px-1 rounded">published</code>, <code class="bg-gray-200 px-1 rounded">archived</code></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="font-semibold text-gray-700 mb-2">Пример запроса (cURL)</h3>
        <pre class="bg-gray-900 text-green-400 text-sm rounded-lg p-4 overflow-x-auto mb-4"><code>curl -X PATCH https://news.api.php-cat.ru/api/news-storage/news/1/status \
  -H "Content-Type: application/json" \
  -H "X-NewsStorage-Api-Key: ваш-ключ" \
  -d '{"status": "published"}'</code></pre>

        <h3 class="font-semibold text-gray-700 mb-2">Успешный ответ (200)</h3>
        <pre class="bg-gray-900 text-green-400 text-sm rounded-lg p-4 overflow-x-auto"><code>{
  "message": "Status updated successfully",
  "news": {
    "id": 1,
    "status": "published"
  }
}</code></pre>
    </section>

    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Ошибки</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Код</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-600">Описание</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2"><span class="font-mono text-red-600">401</span></td>
                        <td class="px-4 py-2">Неверный API ключ</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2"><span class="font-mono text-red-600">404</span></td>
                        <td class="px-4 py-2">Новость не найдена (при смене статуса)</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2"><span class="font-mono text-red-600">422</span></td>
                        <td class="px-4 py-2">Ошибка валидации (неверные поля)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
