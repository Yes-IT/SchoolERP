<!-- Pending Leaves Table -->
<div class="ds-cmn-tble pending count-row" style="display: {{ $tab != 'applied' ? 'block' : 'none' }};">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Teacher Name</th>
                <th>Apply Date</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendingLeaves as $index => $leave)
                <tr>
                    <td style="color: #000">{{ $pendingLeaves->firstItem() + $index }}</td>
                    <td>{{ $leave->teacher ? $leave->teacher->full_name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->apply_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if ($leave->is_approved === 0)
                            <button class="upcoming cmn-tbl-btn green-bg" onclick="updateLeaveStatus({{ $leave->id }}, 'approve')">Approve</button>
                            <button class="upcoming cmn-tbl-btn red-bg" onclick="updateLeaveStatus({{ $leave->id }}, 'reject')">Reject</button>
                        @else
                            <div class="upcoming cmn-tbl-btn {{ $leave->is_approved == 1 ? 'green-bg' : 'red-bg' }}">
                                {{ $leave->is_approved == 1 ? 'Approved' : 'Rejected' }}
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="color: #000">No pending leaves found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Applied Leaves Table -->
<div class="ds-cmn-tble applied count-row" style="display: {{ $tab == 'applied' ? 'block' : 'none' }};">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Teacher Name</th>
                <th>Apply Date</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appliedLeaves as $index => $leave)
                <tr>
                    <td style="color: #000">{{ $appliedLeaves->firstItem() + $index }}</td>
                    <td>{{ $leave->teacher ? $leave->teacher->full_name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->apply_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        <div class="upcoming cmn-tbl-btn {{ $leave->is_approved == 1 ? 'green-bg' : 'red-bg' }}">
                            {{ $leave->is_approved == 1 ? 'Approved (' . \Carbon\Carbon::parse($leave->approved_date)->format('d/m/Y') . ')' : 'Rejected' }}
                        </div>
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