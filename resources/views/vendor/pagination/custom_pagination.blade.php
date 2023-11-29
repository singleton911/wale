@if ($paginator->hasPages())
    <div class="pagination">

        {{-- First Page Link --}}
        @if ($paginator->currentPage() > 1)
            <a href="{{ $paginator->url(1) }}">1</a>
            @if ($paginator->currentPage() > 3)
                <span class="dots">...</span>
            @endif
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="dots">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    {{-- Display only 1 left --}}
                    @if ($page == $paginator->currentPage() - 1)
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif

                    {{-- Current Page --}}
                    @if ($page == $paginator->currentPage())
                        <span class="current">{{ $page }}</span>
                    @endif

                    {{-- Display only 1 right --}}
                    @if ($page == $paginator->currentPage() + 1)
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Last Page Link --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 1)
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <span class="dots">...</span>
            @endif
            <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        @endif
    </div>
    <div style="color: #4f4b4b; padding: 10px; margin-top: 10px; text-align:center; font-size:1rem;">
        Total Active Listings: {{ $paginator->total() }}
    </div>
@endif
