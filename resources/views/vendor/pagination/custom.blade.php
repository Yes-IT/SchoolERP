{{-- resources/views/vendor/pagination/custom.blade.php --}}
@if ($paginator->hasPages())
    <div class="tbl-pagination-inr">
        <ul>
            @php
                // current query params
                $currentQuery = request()->query();
                // the page param name used by this paginator (e.g. requested_page / final_page)
                $pageName = $paginator->getPageName();
            @endphp

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span><img src="{{ asset('student/images/arrow-left.svg') }}" alt="Left"></span>
                </li>
            @else
                @php
                    $prevQuery = array_merge($currentQuery, [$pageName => $paginator->currentPage() - 1]);
                    $qs = http_build_query($prevQuery);
                    $prevUrl = url()->current() . ($qs ? '?' . $qs : '');
                @endphp
                <li>
                    <a href="{{ $prevUrl }}" rel="prev">
                        <img src="{{ asset('student/images/arrow-left.svg') }}" alt="Left">
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @php
                            // build link preserving all current query params, but set this paginator's page param
                            $pageQuery = array_merge($currentQuery, [$pageName => $page]);
                            $pageQs = http_build_query($pageQuery);
                            $pageUrl = url()->current() . ($pageQs ? '?' . $pageQs : '');
                        @endphp

                        @if ($page == $paginator->currentPage())
                            <li class="active"><a href="#">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $pageUrl }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                @php
                    $nextQuery = array_merge($currentQuery, [$pageName => $paginator->currentPage() + 1]);
                    $nextQs = http_build_query($nextQuery);
                    $nextUrl = url()->current() . ($nextQs ? '?' . $nextQs : '');
                @endphp
                <li>
                    <a href="{{ $nextUrl }}" rel="next">
                        <img src="{{ asset('student/images/arrow-right.svg') }}" alt="Right">
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span><img src="{{ asset('student/images/arrow-right.svg') }}" alt="Right"></span>
                </li>
            @endif
        </ul>
    </div>
@endif
