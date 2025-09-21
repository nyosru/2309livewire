<div>
    @if($parent->active_children_count > 0)
        <div class="p-6 hover:bg-gray-50 transition-colors cursor-pointer"
             wire:click="selectParent({{ $parent->id }})"
             wire:key="parent-{{ $parent->id }}"
        >
            <div class="flex justify-between items-start">
                <div class="flex-1">


                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $parent->title }}</h3>

                    {{--            @if( !empty($parent->active_children_count)  )--}}

                    <p class="text-gray-600 line-clamp-2 pl-3 mb-3">{{ \Illuminate\Support\Str::limit($parent->content, 150) }}</p>

                    {{--                @if($parent->active_children_count > 0)--}}
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $parent->active_children_count }} подразделов
                        </span>
                    {{--                @endif--}}

                    {{--            @else--}}
                    {{--                <p class="text-gray-600 line-clamp-2 mb-3">{!! $parent->content  !!}</p>--}}
                    {{--            @endif--}}

                </div>
                <div class="ml-4 flex-shrink-0">

                    {{--                    @if( $parent->active_children_count != 0 )--}}
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"></path>
                    </svg>
                    {{--                    @endif--}}

                </div>

            </div>
        </div>
        @else
        <div class="p-6
{{--        hover:bg-gray-50 --}}
{{--        transition-colors --}}
{{--        cursor-pointer--}}
        "
{{--             wire:click="selectParent({{ $parent->id }})"--}}
             wire:key="parent-{{ $parent->id }}"
        >
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div
                        class="mx-auto w-full max-w-[300px] float-right
{{--                        bg-blue-900 --}}
{{--bg-[#2442a4]--}}
{{--hover:bg-[#042274]--}}
hover:bg-blue-200
                        border border-blue-900

                        p-2 rounded shadow-lg
{{--                        hover:bg-blue-800 --}}
                        transition duration-200">
                        <livewire:phpcatcom.backword.link1-modal-form class="
{{--                        text-white --}}
                        text-[#042274]
                        cursor-pointer rounded text-xl"/>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $parent->title }}</h3>
                    <p class="text-gray-600
{{--                    line-clamp-2--}}
                    pl-3 mb-3">{!! str_replace('<br />','</p><p class="text-gray-600 pl-3 mb-3">',$parent->content)  !!}</p>
{{--                    {{ $parent->content  }}--}}
{{--                    <br/>--}}

                    {{--            @if( !empty($parent->active_children_count)  )--}}

{{--                    <p class="text-gray-600 line-clamp-2 mb-3">{{ \Illuminate\Support\Str::limit($parent->content, 150) }}</p>--}}

                    {{--                @if($parent->active_children_count > 0)--}}
{{--                    <span--}}
{{--                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">--}}
{{--                            {{ $parent->active_children_count }} подразделов--}}
{{--                        </span>--}}
                    {{--                @endif--}}

                    {{--            @else--}}
                    {{--            @endif--}}

                </div>
                <div class="ml-4 flex-shrink-0">

                    {{--                    @if( $parent->active_children_count != 0 )--}}
{{--                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"--}}
{{--                         viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M9 5l7 7-7 7"></path>--}}
{{--                    </svg>--}}
                    {{--                    @endif--}}

                </div>

            </div>
        </div>
    @endif
</div>
