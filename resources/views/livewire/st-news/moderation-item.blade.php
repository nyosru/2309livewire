<div class="p-4 mb-4 bg-white shadow rounded">
    <h3 class="text-lg font-semibold">{{ $newsItem->title }}</h3>
    <p class="text-gray-600">{{ $newsItem->summary }}</p>
    <p class="text-sm text-gray-500">Источник: {{ $newsItem->source }}</p>

    <div class="mt-4">
        <button
            wire:click="moderate('approve')"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 mr-2"
        >
            Одобрить
        </button>
        <button
            wire:click="moderate('reject')"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
        >
            Отклонить
        </button>
    </div>

    @if($decision)
        <p class="mt-2 text-sm text-gray-700">
            Новость была {{ $decision === 'approve' ? 'одобрена' : 'отклонена' }}.
        </p>
    @endif
</div>
