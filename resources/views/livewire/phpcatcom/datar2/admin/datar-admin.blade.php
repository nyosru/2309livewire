<div class="container mx-auto px-4 py-8">

    <livewire:app.breadcrumb :menu="[
        [ 'name' => 'Тех. отдел',
         'link'=>'no' ],
        [ 'name' => 'База знаний',
        'route' => 'tech.datar2',
         'link'=>'no'
         ],
    ]" />
    {{--        [ 'name' => '', 'route' => '',  'route-var' => [], 'link'=>'no' ],--}}




    <!-- Заголовок -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Управление Datar</h1>
            <p class="text-gray-600">Список родителей с вложенными дочерними элементами</p>
        </div>
        <div>
            <a
                href="{{ route('tech.datar2.parents.create',['']) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
            >
                Добавить группу
            </a>
            <a
                href="{{ route('tech.datar2.children.create') }}"
                class="inline-flex items-center px-4 py-2 ml-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors"
            >
                Добавить запись (в группу)
            </a>
        </div>
    </div>

{{--    <!-- Поиск -->--}}
{{--    <div class="mb-6">--}}
{{--        <input--}}
{{--            type="text"--}}
{{--            wire:model.live="search"--}}
{{--            placeholder="Поиск по заголовку или содержанию..."--}}
{{--            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"--}}
{{--        >--}}
{{--    </div>--}}



    @if (session()->has('parent_success'))
        <div class="bg-green-300 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            {{ session('parent_success') }}
        </div>
    @endif

    @if (session()->has('children_success'))
        <div class="bg-green-300 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            {{ session('children_success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-300 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            {{ session('error') }}
        </div>
    @endif


    <!-- Список родителей и детей -->
    <div class="space-y-6">
        @foreach($parents as $parent)
            <div class="p-4 border rounded shadow-sm

{{--            {{ $parent->is_active ? ' bg-white ' : ' bg-gray-300 ' }}--}}

            ">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $parent->title }}</h3>
                        <p class="text-gray-600">{{ Str::limit($parent->content, 150) }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $parent->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $parent->is_active ? 'Активен' : 'Неактивен' }}
                        </span>

                        <button
                            wire:click="toggleStatusParent({{ $parent->id }})"
                            class="text-blue-600 hover:text-blue-900"
                            title="{{ $parent->is_active ? 'Деактивировать' : 'Активировать' }}"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
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
                            wire:click="confirmDelete('parent', {{ $parent->id }})"
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
                        <div class="flex justify-between items-center p-2
{{--                        bg-gray-50--}}
{{--                                     {{ $parent->is_active ? ' bg-white ' : ' bg-gray-300 ' }}--}}
                         rounded">
                            <div>
                                <h4 class="font-semibold">{{ $child->title }}</h4>
                                <p class="text-gray-600">{{ Str::limit($child->content, 120) }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $child->is_active ? 'Активен' : 'Неактивен' }}
                                </span>
                                <button
                                    wire:click="toggleStatusChild({{ $child->id }})"
                                    class="text-blue-600 hover:text-blue-900"
                                    title="{{ $child->is_active ? 'Деактивировать' : 'Активировать' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
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
                    @empty
                        <p class="text-gray-500 text-sm">Дочерних элементов нет</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <!-- Пагинация -->
    @if($parents->hasPages())
        <div class="mt-6">
            {{ $parents->links() }}
        </div>
    @endif
</div>
