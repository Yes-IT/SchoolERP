<div class="ds-cmn-tble">
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
                                <img src="{{ asset('staff/assets/images/i-icon.svg') }}" alt="Icon">
                            </button>
                            <div class="ibtn-info lg rt p15">
                                <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                    <img src="{{ asset('staff/assets/images/fa-times.svg') }}" alt="icon">
                                </button>
                                <h3 class="txt-primary mb-2">Note:</h3>
                                <p>Your leave will be reviewed by your Mechaneches.</p>
                            </div>
                        </div>
                    </div>
                </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['leaves'] as $leave)
                <tr>
                    <td>{{ $data['leaves']->firstItem() + $loop->index }}</td>
                    <td>{{ $leave->apply_date ? \Carbon\Carbon::parse($leave->apply_date)->format('d/m/Y') : '' }}</td>
                    <td>{{ $leave->from_date ? \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') : '' }}</td>
                    <td>{{ $leave->to_date ? \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') : '' }}</td>
                    <td>
                        <div class="linecamped line-count-1">
                            {{ $leave->reason ?? '' }}
                        </div>
                    </td>
                    <td>
                        @if ($leave->is_approved == 0)
                            <p class="red-bg cmn-tbl-btn">Pending</p>
                        @else
                            <p class="green-bg cmn-tbl-btn">
                                Approved ({{ $leave->approved_date ? \Carbon\Carbon::parse($leave->approved_date)->format('d/m/Y') : '' }})
                            </p>
                        @endif
                    </td>
                    <td>
                        @if ($leave->is_approved == 0)
                            <div class="actions-wrp">
                                <button type="button" class="edit-btn" data-leave={{ $leave->id }}>
                                    <img src="{{ asset('staff/assets/images/edit-icon-primary.svg') }}" alt="Icon">
                                </button>
                                <button type="button" class="delete-btn" data-leave={{ $leave->id }}>
                                    <img src="{{ asset('staff/assets/images/bin-icon.svg') }}" alt="Icon">
                                </button>
                            </div>
                        @else
                            --
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="tablepagination">
    @include('backend.partials.pagination', ['paginator' => $data['leaves'], 'routeName' => 'staff.apply-leave.index'])
</div>