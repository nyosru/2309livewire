<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Модерация новостей</h1>

    @if($newsToModerate->isEmpty())
        <p>Нет новостей, требующих модерации.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Заголовок</th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Дата публикации</th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Источник</th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($newsToModerate as $news)
                <tr>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $news->title }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $news->published_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a href="{{ $news->source }}" target="_blank" >
                        {{ $news->source }}</a>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" wire:click="approve({{ $news->id }})">
                            Одобрить
                        </button>
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="reject({{ $news->id }})">
                            Отклонить
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
