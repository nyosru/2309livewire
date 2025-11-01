<div class="p-4 border rounded shadow-sm
{{--            {{ $parent->is_active ? ' bg-white ' : ' bg-gray-300 ' }}--}}
            ">
    <div class="flex justify-between items-center mb-3">
        <div x-data="{ expanded: false }" x-cloak>
            <h3 class="text-xl font-semibold">{{ $parent->title }}</h3>
            <div class="relative">


                @if(strlen(strip_tags($parent->content)) > 200)
                    <div
                        x-show="!expanded"
                        class="h-12 overflow-hidden text-gray-600 border border-gray-300 rounded p-3"
                        style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"
                    >
                        {!! $parent->content !!}
                    </div>

                    <div
                        x-show="expanded"
                        class="text-gray-600 border border-gray-300 rounded p-3"
                    >
                        {!! $parent->content !!}
                    </div>

                    <button
                        type="button"
                        @click="expanded = !expanded"
                        class="mt-2 text-sm text-blue-600 hover:text-blue-800 focus:outline-none"
                        x-text="expanded ? 'Скрыть' : 'Показать полностью'"
                    ></button>
                @else
                    <div class="text-gray-600 border border-gray-300 rounded p-3">
                        {!! $parent->content !!}
                    </div>
                @endif

            </div>
        </div>
        <div class="flex space-x-2">
    <span
        wire:click="toggleStatusParent({{ $parent->id }})"
        class="cursor-pointer inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $parent->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
        {{ $parent->is_active ? 'Активен' : 'Неактивен' }}
    </span>

            {{--            <button--}}
            {{--                wire:click="toggleStatusParent({{ $parent->id }})"--}}
            {{--                class="text-blue-600 hover:text-blue-900"--}}
            {{--                title="{{ $parent->is_active ? 'Деактивировать' : 'Активировать' }}"--}}
            {{--            >--}}
            {{--                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
            {{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
            {{--                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>--}}
            {{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
            {{--                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>--}}
            {{--                </svg>--}}
            {{--            </button>--}}
            <a href="{{ route('tech.datar2.parents.edit', $parent->id) }}"
               class="text-indigo-600 hover:text-indigo-900" title="Редактировать">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>

            <button
                {{--                            wire:click="confirmDelete('child', {{ $parent->id }})"--}}
                wire:confirm="Вы действительно хотите удалить запись?"
                wire:click="confirmDelete({{ $parent->id }})"
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

    <!-- Дочерние элементы -->
    <div class="mt-3 ml-4 border-l-2 border-gray-200 pl-4 space-y-3">
        @forelse($parent->children as $child)
            <livewire:Phpcatcom.Datar2.Admin.Datar-admin-item-item :child="$child" :key="'child'.$child->id"/>
        @empty
            <p class="text-gray-500 text-sm">Дочерних элементов нет</p>
        @endforelse
    </div>


    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                window.scrollTo({ top: 250, behavior: 'smooth' });
            });

            document.addEventListener('livewire:updated', () => {
                window.scrollTo({ top: 250, behavior: 'smooth' });
            });
        </script>
    @endpush

</div>
