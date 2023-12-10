@if ($paginator->hasPages())
    <div class="pagination">
        {{-- First Page Link --}}
        @if ($paginator->currentPage() > 2)
            <a href="{{ $paginator->url(1) }}">1</a>
            @if ($paginator->currentPage() > 3)
                <span class="dots">...</span>
            @endif
        @endif

        {{-- Pagination Elements --}}
        @for ($i = max(1, $paginator->currentPage() - 1); $i <= min($paginator->currentPage() + 1, $paginator->lastPage()); $i++)
            {{-- Current Page --}}
            @if ($i == $paginator->currentPage())
                <span class="current">{{ $i }}</span>
            @else
                @if ($i > 1 && $i < $paginator->lastPage()) {{-- Avoid repeating first and last page links --}}
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endif
            @endif
        @endfor

        {{-- Last Page Link --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 1)
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <span class="dots">...</span>
            @endif
            <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        @endif
    </div>
    <div style="color: #4f4b4b; padding: 10px; margin-top: 10px; text-align:center; font-size:1rem;">
        Total Result Found: {{ $paginator->total() }}
    </div>
@endif
