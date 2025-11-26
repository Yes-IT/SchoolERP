<!-- OR -->
@php
    use Carbon\Carbon;
@endphp

<table>
    <input type="hidden" id="current_class_id" value="{{ $classId }}">
    <input type="hidden" id="current_subject_id" value="{{ $subjectId }}">
    <input type="hidden" id="current_date_formatted" value="{{ $date }}">

    <thead>
        <tr>
            <th>S. No</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Attendance</th>
            <th>Comment</th>
            <th>Approved Leaves</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $index => $student)
            @php
                $sid = $student->id;
                $record = $attendanceRecords->get($sid); // ← This is your array now

                // Safely extract attendance and comment
                $attendanceStatus = $record['attendance'] ?? null;
                $comment = $record['comment'] ?? '';

                $leave = $leaves->get($sid);
                $isApprovedLeave = $leave && $leave->is_approved == 1;
                $isRejectedLeave = $leave && $leave->is_approved == 2;
            @endphp

            <tr data-student="{{ $sid }}" class="attendance-row">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->student_id }}</td>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>

                <td class="att-label"
                    style="{{ $isRejectedLeave ? 'pointer-events: none; opacity: 0.8;' : '' }}
                           {{ $isApprovedLeave ? 'opacity: 0.5;' : '' }}">

                    <label>
                        <input type="radio" class="attendance-radio" name="attendance[{{ $sid }}]" value="1"
                               data-student="{{ $sid }}"
                               {{ $attendanceStatus == 1 ? 'checked' : '' }}
                               {{ $isApprovedLeave ? 'disabled' : '' }}> Present
                    </label>

                    <label>
                        <input type="radio" class="attendance-radio" name="attendance[{{ $sid }}]" value="3"
                               data-student="{{ $sid }}"
                               {{ $attendanceStatus == 3 ? 'checked' : '' }}
                               {{ $isApprovedLeave ? 'disabled' : '' }}> Absent
                    </label>

                    <label>
                        <input type="radio" class="attendance-radio" name="attendance[{{ $sid }}]" value="2"
                               data-student="{{ $sid }}"
                               {{ $attendanceStatus == 2 ? 'checked' : '' }}
                               {{ $isApprovedLeave ? 'disabled' : '' }}> Late
                    </label>
                </td>

                <td class="comment-cell">
                    @if(!$isApprovedLeave)
                        <img src="{{ asset('staff') }}/assets/images/newpencil.svg"
                             class="pencil comment-pencil"
                             data-student="{{ $sid }}"
                             data-comment="{{ $comment }}"
                             data-bs-toggle="modal"
                             data-bs-target="#addCommentModal"
                             style="cursor:pointer;">
                    @endif
                </td>

                <!-- Leave Column -->
                <td>
                    @if($leave)
                        @if($leave->is_approved == 1)
                            <span class="badge approved">Approved ({{ Carbon::parse($leave->from_date)->format('d/m/Y') }})</span>
                        @elseif($leave->is_approved == 2)
                            <span class="badge rejected">Rejected</span>
                        @elseif($leave->is_approved == 0)
                            <span class="badge" style="background:#ffc107;color:black;">Pending</span>
                        @endif
                    @else
                        --
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No students found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="text-center mt-4">
    <button type="button" class="submit-btn" id="submitAttendanceBtn">Submit</button>
</div>