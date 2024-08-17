@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex-1 flex items-center justify-between">
            <div class="
            pr-2">Страницы:</div>
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500
                bg-white border border-gray-300 rounded-l-md
                leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring
                ring-gray-300
                focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">

{{--                    <svg class="w-5 h-5" fill="white" viewBox="0 0 20 20">--}}
{{--                        <path fill="gray" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-10.707a1 1 0 011.414-1.414L8.414 10h5.586a1 1 0 010 2H8.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3z" clip-rule="evenodd" />--}}
{{--                    </svg>--}}

{{--                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.707a1 1 0 00-1.414 1.414L11.586 10H6a1 1 0 000 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3z" clip-rule="evenodd" />--}}
{{--                    </svg>--}}

{{--                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />--}}
{{--                    </svg>--}}

                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>

                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true">
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 cursor-default leading-5">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
{{--                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.707a1 1 0 00-1.414 1.414L11.586 10H6a1 1 0 000 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3z" clip-rule="evenodd" />--}}
{{--                    </svg>--}}
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            @endif
        </div>
    </nav>
@endif
