<div class="flex justify-between items-center p-2 rounded">
    <div x-data="{ expanded: false }" x-cloak>
        <h4 class="font-semibold">{{ $child->title }}</h4>

        @if(strlen(strip_tags($child->content)) > 200)
            <div
                x-show="!expanded"
                class="h-12 overflow-hidden text-gray-600 border border-gray-300 rounded p-3"
                style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"
            >
                {!! $child->content !!}
            </div>

            <div
                x-show="expanded"
                class="text-gray-600 border border-gray-300 rounded p-3"
            >
                {!! $child->content !!}
            </div>

            <button
                type="button"
                @click="expanded = !expanded"
                class="mt-2 text-sm text-blue-600 hover:text-blue-800 focus:outline-none"
                x-text="expanded ? 'Скрыть' : 'Показать полностью'"
            ></button>
        @else
            <div class="text-gray-600 border border-gray-300 rounded p-3">
                {!! $child->content !!}
            </div>
        @endif
    </div>

    <div class="flex space-x-2">
        <span
            wire:click="toggleStatusChild({{ $child->id }})"
            class="cursor-pointer inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}"
        >
            {{ $child->is_active ? 'Активен' : 'Неактивен' }}
        </span>

        <a href="{{ route('tech.datar2.children.edit', $child->id) }}"
           class="text-indigo-600 hover:text-indigo-900" title="Редактировать">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </a>

        <button
            wire:confirm="Вы действительно хотите удалить запись?"
            wire:click="confirmDelete('children', {{ $child->id }})"
            class="text-red-600 hover:text-red-900"
            title="Удалить"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    </div>
</div>

