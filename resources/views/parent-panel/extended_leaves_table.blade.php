@php
    use Carbon\Carbon;
@endphp


<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Apply Date</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Reason</th>
            <th>
                <div class="status-wrp">
                    Status
                    <div class="ibtn">
                        <button type="button" class="ibtn-icon">
                            <img src="{{ asset('parent/images/i-icon.svg') }}" alt="Icon">
                        </button>
                        <div class="ibtn-info lg rt p15">
                            <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                <img src="{{ asset('parent/images/fa-times.svg') }}" alt="icon">
                            </button>
                            <h3 class="txt-primary mb-2">Note:</h3>
                            <p>Your child’s leave request will </p>
                            <p>be approved by their Mechaneches.</p>
                        </div>
                    </div>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($leaves as $index => $leave)
            <tr>
                <td>{{ $leaves->firstItem() + $index }}</td>
                <td>{{ Carbon::parse($leave->created_at)->format('d/m/Y') }}</td>
                <td>{{ Carbon::parse($leave->from_date)->format('d/m/Y') }}</td>
                <td>{{ Carbon::parse($leave->to_date)->format('d/m/Y') }}</td>
                <td>
                    <div class="linecamped line-count-2">
                        {{ Str::limit($leave->reason, 80) }}
                    </div>
                </td>
                <td>
                    @switch($leave->is_approved)
                        @case(0)
                            <span class="cmn-tbl-btn red-bg">Pending</span>
                            @break
                        @case(1)
                            <span class="cmn-tbl-btn green-bg">
                                Approved 
                                @if($leave->approved_date)
                                    ({{ Carbon::parse($leave->approved_date)->format('d/m/Y') }})
                                @endif
                            </span>
                            @break
                        @case(2)
                            <span class="cmn-tbl-btn" style="background:#ff4444;color:white;">Rejected</span>
                            @break
                        @default
                            <span class="cmn-tbl-btn gray-bg">Unknown</span>
                    @endswitch
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-4">
                    No extended leaves found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="tablepagination">
    <div class="tbl-pagination-inr">
        {{ $leaves->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>

    <div class="pages-select">
        <form method="GET" id="perPageForm">
            <div class="formfield">
                <label>Per page</label>
                <select name="perPage" onchange="filterLeaves()">
                    @foreach([5, 10, 15, 25, 50] as $size)
                        <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <p>
            Showing {{ $leaves->firstItem() ?? 0 }} - {{ $leaves->lastItem() ?? 0 }}
            of {{ $leaves->total() }} results
        </p>
    </div>
</div>