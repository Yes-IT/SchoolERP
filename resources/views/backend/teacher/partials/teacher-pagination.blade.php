<div class="tablepagination">
    <div class="tbl-pagination-inr">
        <ul>
            {{-- Previous Page Link --}}
            @if ($teachers->onFirstPage())
                <li class="disabled">
                    <span><img src="{{ global_asset('backend/assets/images/arrow-left.svg') }}" alt="Icon"></span>
                </li>
            @else
                <li>
                    <a href="{{ $teachers->previousPageUrl() }}">
                        <img src="{{ global_asset('backend/assets/images/arrow-left.svg') }}" alt="Icon">
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
                <li class="{{ $page == $teachers->currentPage() ? 'active' : '' }}">
                    <a href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            @if ($teachers->hasMorePages())
                <li>
                    <a href="{{ $teachers->nextPageUrl() }}">
                        <img src="{{ global_asset('backend/assets/images/arrow-right.svg') }}" alt="Icon">
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span><img src="{{ global_asset('backend/assets/images/arrow-right.svg') }}" alt="Icon"></span>
                </li>
            @endif
        </ul>
    </div>

    <div class="pages-select">
        <form id="perPageForm">
            <div class="formfield">
                <label>Per page</label>
                <select name="per_page">
                    @foreach([5,10,15,20] as $size)
                        <option value="{{ $size }}" {{ request('per_page', \App\Enums\Settings::PAGINATE) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
        <p>of {{ $teachers->total() }} results</p>
    </div>
</div>
