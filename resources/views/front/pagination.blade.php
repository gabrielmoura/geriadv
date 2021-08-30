@if ($paginator->hasPages())
    <div class="pagination-area">
        <nav>
            <ul class="page-numbers">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-number disabled prev" aria-disabled="true">
                        <span class="page-number"><i class="icofont-long-arrow-left"></i></span>
                    </li>
                @else
                    <li class="page-number">
                        <a class="page-number active prev" href="{{ $paginator->previousPageUrl() }}"
                           rel="prev"><i class="icofont-long-arrow-left"></i></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-number disabled" aria-disabled="true"><span
                                class="page-number">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element) && count($element)>2)
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-number active" aria-current="page"><span
                                        class="page-number active">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-number"><a class="page-number" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-number">
                        <a class="page-number next active" href="{{ $paginator->nextPageUrl() }}"
                           rel="next"><i class="icofont-long-arrow-right"></i></a>
                    </li>
                @else
                    <li class="page-number disabled next" aria-disabled="true">
                        <span class="page-number"><i class="icofont-long-arrow-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
