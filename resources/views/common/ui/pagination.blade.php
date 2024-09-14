@if ($paginator->hasPages())
    <nav class="pagination">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="pagination_item disabled">
                <span class="pagination_arrow-left"></span>
            </div>
        @else
            <div class="pagination_item">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination_link">
                    <span class="pagination_arrow-left"></span>
                </a>
            </div>
        @endif

        @if($paginator->currentPage() > 3)
            <div class="pagination_item">
                <a href="{{ $paginator->url(1) }}" class="pagination_link">1</a>
            </div>
        @endif

        @if($paginator->currentPage() > 4)
            <div class="pagination_item">
                <span class="pagination_link">...</span>
            </div>
        @endif

        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <div class="pagination_item active"><span class="pagination_link">{{ $i }}</span></div>
                @else
                    <div class="pagination_item"><a href="{{ $paginator->url($i) }}" class="pagination_link">{{ $i }}</a></div>
                @endif
            @endif
        @endforeach

        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <div class="pagination_item">
                <span class="pagination_link">...</span>
            </div>
        @endif

        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <div class="pagination_item">
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination_link">
                    {{ $paginator->lastPage() }}
                </a>
            </div>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <div class="pagination_item">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination_link">
                    <span class="pagination_arrow-right"></span>
                </a>
            </div>
        @else
            <div class="pagination_item disabled">
                <span class="pagination_arrow-right"></span>
            </div>
        @endif
    </nav>
@endif
