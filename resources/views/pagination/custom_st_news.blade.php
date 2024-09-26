@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-500">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @php
                    $currentPage = $paginator->currentPage();
                    $totalPages = $paginator->lastPage();
                    $firstPages = range(1, 3);
                    $lastPages = range($totalPages - 2, $totalPages);
                    $range = range($currentPage - 3, $currentPage + 3);
                @endphp

                @foreach ($element as $page => $url)
                    @if (in_array($page, $firstPages) || in_array($page, $lastPages) || in_array($page, $range))
                        @if ($page == $currentPage)
                            <span class="px-4 py-2 bg-blue-500 text-white border border-blue-500">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500">
                                {{ $page }}
                            </a>
                        @endif
                    @elseif ($page == 4 || $page == $totalPages - 3)
                        <span class="px-4 py-2 text-gray-500">...</span>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500">
                &raquo;
            </a>
        @else
            <span class="px-4 py-2 text-gray-500">&raquo;</span>
        @endif
    </nav>
@endif
