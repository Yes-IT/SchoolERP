<div class="ds-content-head has-drpdn">
    <div class="sec-head">
        <h2>Daily Attendance</h2>
    </div>
</div>

<div class="ds-cmn-tble">
    <table style="min-width:auto !important;">
        <thead class="thead">
            <tr>
                <th class="serial">S.No</th>
                <th class="purchase">Student ID</th>
                <th class="purchase">Student Name</th>
                <th class="purchase">Class Time</th>
                <th class="purchase">Attendance</th>
                <th class="purchase">Approved Leaves</th>
            </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($attendance as $key => $row)
                <tr>
                    <td>{{ $attendance->firstItem() + $key }}</td>
                    <td>{{ $row->student_code }}</td>
                    <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                    <td>
                        {{ $row->start_time ? \Carbon\Carbon::parse($row->start_time)->format('h:i A') : '--' }}
                    </td>

                    <td>
                        @if ($row->attendance == 1)
                            <p class="green-bg cmn-tbl-btn">Present</p>
                        @elseif ($row->attendance == 2)
                            <p class="yellow-bg cmn-tbl-btn">Late</p>
                        @else
                            <p class="red-bg cmn-tbl-btn">Absent</p>
                        @endif
                    </td>

                    <td>
                        @if (is_null($row->leave_status))
                            <span>--</span>
                        @elseif ($row->leave_status == 1)
                            <p class="green-bg cmn-tbl-btn">
                                Approved
                                {{ $row->leave_approved_date ? \Carbon\Carbon::parse($row->leave_approved_date)->format('d-m-Y') : '' }}
                            </p>
                        @elseif ($row->leave_status == 0)
                            <p class="red-bg cmn-tbl-btn">Rejected</p>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="tablepagination">
    {{ $attendance->links('backend.partials.pagination', ['routeName' => 'daily.index']) }}
</div>