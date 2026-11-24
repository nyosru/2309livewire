@if($items->lastPage() > 1)
    @php
        $startPage = max(1, $items->currentPage() - 2);
        $endPage = min($items->lastPage(), $items->currentPage() + 2);
    @endphp
    <nav class="pagination" aria-label="Страницы записей">
        <a class="btn {{ $items->onFirstPage() ? 'pagination-disabled' : '' }}" href="{{ $items->url(1) }}#inbox" @if($items->onFirstPage()) aria-disabled="true" @endif>Первая</a>
        @if($startPage > 1)<span class="pagination-gap" aria-hidden="true">…</span>@endif
        @foreach(range($startPage, $endPage) as $page)
            <a class="btn {{ $page === $items->currentPage() ? 'pagination-current' : '' }}" href="{{ $items->url($page) }}#inbox" @if($page === $items->currentPage()) aria-current="page" @endif>{{ $page }}</a>
        @endforeach
        @if($endPage < $items->lastPage())<span class="pagination-gap" aria-hidden="true">…</span>@endif
        <a class="btn {{ $items->currentPage() === $items->lastPage() ? 'pagination-disabled' : '' }}" href="{{ $items->url($items->lastPage()) }}#inbox" @if($items->currentPage() === $items->lastPage()) aria-disabled="true" @endif>Последняя</a>
    </nav>
@endif
