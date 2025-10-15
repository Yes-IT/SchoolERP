@php
    // Extract paginator properties
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $perPage = $paginator->perPage();
    $total = $paginator->total();

    // Query parameters to append
    $queryParams = request()->query();
    unset($queryParams['page']); // Remove page parameter to avoid conflicts

    // Calculate pagination range
    $range = 2; // Number of pages to show before/after current page
    $startPage = max(1, $currentPage - $range);
    $endPage = min($lastPage, $currentPage + $range);

    if ($endPage - $startPage < $range * 2) {
        if ($currentPage < $lastPage / 2) {
            $endPage = min($lastPage, $startPage + $range * 2);
        } else {
            $startPage = max(1, $endPage - $range * 2);
        }
    }
@endphp

<div class="tbl-pagination-inr">
    <ul>
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li><span><img src="{{ asset('backend/assets/images/new_images/arrow-left.svg') }}" alt="Icon"></span></li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}{{ count($queryParams) ? '&'.http_build_query($queryParams) : '' }}">
                    <img src="{{ asset('backend/assets/images/new_images/arrow-left.svg') }}" alt="Icon">
                </a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @for ($i = $startPage; $i <= $endPage; $i++)
            <li class="{{ $i == $currentPage ? 'active' : '' }}">
                <a href="{{ $paginator->url($i) }}{{ count($queryParams) ? '&'.http_build_query($queryParams) : '' }}">
                    {{ $i }}
                </a>
            </li>
        @endfor

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}{{ count($queryParams) ? '&'.http_build_query($queryParams) : '' }}">
                    <img src="{{ asset('backend/assets/images/new_images/arrow-right.svg') }}" alt="Icon">
                </a>
            </li>
        @else
            <li><span><img src="{{ asset('backend/assets/images/new_images/arrow-right.svg') }}" alt="Icon"></span></li>
        @endif
    </ul>
</div>

<div class="pages-select">
    <form action="{{ route($routeName) }}" method="GET" id="perPageForm">
        <div class="formfield">
            <label>Per page</label>
            <select name="per_page">
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ request('per_page', 2) == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            {{-- Preserve filters --}}
            @foreach ($queryParams as $key => $value)
                @if (!in_array($key, ['per_page', 'page']))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
        </div>
    </form>
    <p>
        Showing {{ $paginator->firstItem() }} – {{ $paginator->lastItem() }}
        of {{ $total }} results
    </p>
</div>