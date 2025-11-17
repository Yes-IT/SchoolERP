<div class="tablepagination" id="class-pagination">
    <div class="tbl-pagination-inr">
        <ul>
            {{-- Previous Page Link --}}
            @if ($classes->onFirstPage())
                <li class="disabled">
                    <span><img src="{{ global_asset('backend/assets/images/arrow-left.svg') }}" alt="Icon"></span>
                </li>
            @else
                <li>
                    <a href="#" data-page="{{ $classes->currentPage() - 1 }}">
                        <img src="{{ global_asset('backend/assets/images/arrow-left.svg') }}" alt="Icon">
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($classes->getUrlRange(1, $classes->lastPage()) as $page => $url)
                <li class="{{ $page == $classes->currentPage() ? 'active' : '' }}">
                    <a href="#" data-page="{{ $page }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            @if ($classes->hasMorePages())
                <li>
                    <a href="#" data-page="{{ $classes->currentPage() + 1 }}">
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
        <div class="formfield">
            <label>Per page</label>
            <select name="per_page" id="class-per-page">
                @foreach([5,10,15,20] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>
        <p>of {{ $classes->total() }} results</p>
    </div>
</div>