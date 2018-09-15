@if ($paginator->hasPages())
    <ul class="pagination flex-wrap">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link" style="color: #dc3545;">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" style="color: #dc3545;" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link" style="color: #dc3545;">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link" style="color: #ffffff; background-color: #dc3545;border-color: #dc3545;">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" style="color: #dc3545;" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" style="color: #dc3545;" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link" style="color: #dc3545;">&raquo;</span></li>
        @endif
    </ul>
@endif
