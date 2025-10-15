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
            @forelse ($data['attendance'] as $key => $attendance)
                <tr>
                    <td>{{ $data['attendance'] instanceof \Illuminate\Pagination\LengthAwarePaginator ? $data['attendance']->firstItem() + $key : $key + 1 }}</td>
                    <td>{{ $attendance->student_id }}</td>
                    <td>{{ $attendance->first_name }} {{ $attendance->last_name }}</td>
                    <td>{{ date('h:i A', strtotime($attendance->start_time)) }}</td>
                    <td>
                        @if ($attendance->attendance == 1)
                            <p class="green-bg cmn-tbl-btn">Present</p>
                        @elseif($attendance->attendance == 2)
                            <p class="cmn-tbl-btn yellow-bg">Late</p>
                        @else
                            <p class="red-bg cmn-tbl-btn">Absent</p>
                        @endif
                    </td>
                    <td>
                        @if (is_null($attendance->is_approved))
                            --
                        @elseif ($attendance->is_approved == 1)
                            <p class="green-bg cmn-tbl-btn">
                                Approved {{ $attendance->approved_date ? date('d-m-Y', strtotime($attendance->approved_date)) : '' }}
                            </p>
                        @elseif ($attendance->is_approved == 0)
                            <p class="red-bg cmn-tbl-btn">Rejected</p>
                        @endif
                    </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="tablepagination">
    @if ($data['attendance'] instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $data['attendance']->links('backend.partials.pagination', ['routeName' => 'daily.index']) }}
    @endif
</div>
