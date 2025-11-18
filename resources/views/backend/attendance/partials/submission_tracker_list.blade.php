<div class="ds-content-head has-drpdn">
    <div class="sec-head">
        <h2>Attendance Submission Tracker</h2>
    </div>
</div>

<div class="ds-cmn-tble">
    <table style="min-width:auto !important;">
        <thead class="thead">
            <tr>
                <th class="serial">S.NO</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Staff Name</th>
                <th>Class Time</th>
                <th>Room No</th>
                <th>Submission Status</th>
                <th>Submission Time</th>
                <th>Attendance View</th>
            </tr>
        </thead>
        <tbody class="tbody">
            @forelse($classes as $key => $class)
                <tr>
                    <td>{{ $classes instanceof \Illuminate\Pagination\LengthAwarePaginator ? $classes->firstItem() + $key : $key + 1 }}</td>
                    <td>{{ $class->name ?? '-' }}</td>
                    <td>{{ $class->subject->name ?? '-' }}</td>
                    <td>{{ $class->staff->name ?? '-' }}</td>
                    <td>{{ $class->class_time ?? '-' }}</td>
                    <td>{{ $class->room_no ?? '-' }}</td>
                    <td>
                        @if($class->attendance_status === 'Submitted')
                            <div class="cmn-tbl-btn green-bg">Submitted</div>
                        @else
                            <div class="cmn-tbl-btn red-bg">Pending</div>
                        @endif
                    </td>
                    <td>{{ $class->attendance_time ?? '-' }}</td>
                    <td>
                        @if($class->attendance_status === 'Submitted')
                            <a class="view-attachment-btn" href="{{ url('attendance/view/' . $class->id) }}">
                                <img src="http://saserp.tgastaging.com/images/parent/eye-white.svg" alt="Eye Icon">
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($classes instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="pagination-wrap mt-3">
        {{ $classes->links('pagination::bootstrap-5') }}
    </div>
@endif
