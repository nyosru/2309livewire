<div class="flex justify-between items-center p-2
{{--                        bg-gray-50--}}
{{--                                     {{ $parent->is_active ? ' bg-white ' : ' bg-gray-300 ' }}--}}
                         rounded">
    <div>
        <h4 class="font-semibold">{{ $child->title }}</h4>
        {{--        <p class="text-gray-600">{{ Str::limit($child->content, 120) }}</p>--}}
        <div
            :class="{ 'line-clamp-4 h-auto': expanded }"
            class="h-24 overflow-hidden text-gray-600 border border-gray-300 rounded p-3 line-clamp-4"
            style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;"
        >
            {!! $child->content !!}
            @if(strlen($child->content) > 100)
                <button
                    type="button"
                    @click="expanded = !expanded"
                    class="mt-2 text-sm text-blue-600 hover:text-blue-800 focus:outline-none"
                    x-text="expanded ? 'Скрыть' : 'Показать полностью'"
                ></button>
            @endif
        </div>
    </div>

    <div class="flex space-x-2">

                 <span
                     wire:click="toggleStatusChild({{ $child->id }})"
                     class="cursor-pointer inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}"
                 >{{ $child->is_active ? 'Активен' : 'Неактивен' }}</span>
{{--        <button--}}
{{--            wire:click="toggleStatusChild({{ $child->id }})"--}}
{{--            class="text-blue-600 hover:text-blue-900 text-nowrap"--}}
{{--            title="{{ $child->is_active ? 'Деактивировать' : 'Активировать' }}"--}}
{{--        >--}}

{{--            <svg--}}
{{--                class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>--}}
{{--            </svg>--}}
{{--        </button>--}}

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
            {{--                                    wire:click="confirmDelete('parent', {{ $parent->id }})"--}}
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
