<div>
    {{-- Меню --}}
    <div class="flex space-x-4 mb-4">
        <button
            wire:click="setActiveSection('sites')"
            class="px-4 py-2 {{ $activeSection === 'sites' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
            Сайты
        </button>
        <button
            wire:click="setActiveSection('catalog')"
            class="px-4 py-2 {{ $activeSection === 'catalog' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
            Каталоги
        </button>
        <button
            wire:click="setActiveSection('news')"
            class="px-4 py-2 {{ $activeSection === 'news' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
            Новости
        </button>
    </div>

    {{-- Динамическое отображение разделов --}}
    <div>
        @if ($activeSection === 'sites')
            <livewire:StNews.a.st-news-a-m-site />
        @elseif ($activeSection === 'catalog')
            <livewire:StNews.a.catalog />
        @elseif ($activeSection === 'news')
            <livewire:StNews.a.st-a-news />
        @endif
    </div>
</div>
