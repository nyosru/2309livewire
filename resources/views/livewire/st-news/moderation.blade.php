<div class="p-6 bg-gray-100 min-h-screen">
    <div class="mb-6">
        <input
            type="password"
            wire:model="secret"
            placeholder="Введите секретный код"
            class="px-4 py-2 border rounded w-full"
        />
    </div>
1111
    @if ($secret === config('app.secret_moderation'))
        @if ($news->isEmpty())
            <p class="text-center text-gray-500">Нет новостей, требующих модерации.</p>
        @else
            <div class="space-y-4">
                @foreach ($news as $newsItem)
                    @livewire('st-news.moderation-item', ['newsItem' => $newsItem], key($newsItem->id))
                @endforeach
            </div>
        @endif
    @else
        <p class="text-center text-red-500">Неверный секретный код.</p>
    @endif
</div>
