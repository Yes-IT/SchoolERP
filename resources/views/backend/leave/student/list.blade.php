<!-- Applied Leaves Table -->
<div class="ds-cmn-tble applied count-row" style="display: {{ $tab != 'extended' ? 'block' : 'none' }};">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Student Name</th>
                <th>Apply Date</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Reason</th>
                <th>
                    <div class="ibtn">
                        <button type="button" class="ibtn-icon">
                            <img src="{{ asset('backend/assets/images/new_images/i-icon.svg') }}" alt="Icon">
                        </button>
                        <div class="ibtn-info lg rt p15">
                            <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                <img src="{{ asset('backend/assets/images/new_images/fa-times.svg') }}" alt="icon">
                            </button>
                            <h3 class="txt-primary mb-2">Note:</h3>
                            <p>Leave Will be reviewed by their Mechaneches.</p>
                        </div>
                    </div>
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appliedLeaves as $index => $leave)
                <tr>
                    <td style="color: #000">{{ $appliedLeaves->firstItem() + $index }}</td>
                    <td>{{ $leave->student ? $leave->student->full_name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->apply_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if ($leave->is_approved)
                            <div class="upcoming cmn-tbl-btn green-bg">
                                Approved ({{ \Carbon\Carbon::parse($leave->approved_date)->format('d/m/Y') }})
                            </div>
                        @else
                            <div class="upcoming cmn-tbl-btn red-bg">Pending</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="color: #000">No applied leaves found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Extended Leaves Table -->
<div class="ds-cmn-tble extended count-row" style="display: {{ $tab == 'extended' ? 'block' : 'none' }};">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Student Name</th>
                <th>Apply Date</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($extendedLeaves as $index => $leave)
                <tr>
                    <td style="color: #000">{{ $extendedLeaves->firstItem() + $index }}</td>
                    <td>{{ $leave->student ? $leave->student->full_name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->apply_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if ($leave->is_approved)
                            <div class="upcoming cmn-tbl-btn green-bg">
                                Approved ({{ \Carbon\Carbon::parse($leave->approved_date)->format('d/m/Y') }})
                            </div>
                        @else
                            <div class="upcoming cmn-tbl-btn red-bg">Pending</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="color: #000">No extended leaves found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>