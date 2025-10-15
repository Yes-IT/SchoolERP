<div class="ds-cmn-tble count-row tbl-5_4k">
    <table id="subjectTable">
        <thead>
            <tr>
                <th>S. No</th>
                <th>View Details</th>
                <th>Subject</th>
                <th>Credits</th>
                <th>Allowed Absences</th>
                <th>Allowed Penalty Amount</th>
                <th>Number of Latenesses Equal to Absence</th>
                <th>Atten. % Auto Fail</th>
                <th>Atten. % Amount</th>
                <th>Atten. % Fail Grade</th>
                <th>Hebrew Attendance</th>
                <th>GPA Weight</th>
                <th>Report Card</th>
                <th>Prec. RC</th>
                <th>College Transcript</th>
                <th>Transcript Name</th>
                <th>Course</th>
                <th>Prec. Transcript</th>
                <th>Charter Oak Transcript</th>
                <th>CO Year-Long</th>
                <th>CO Department</th>
                <th>Elective</th>
                <th>Comment</th>
                <th>Inactive</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="subjectTableBody">
            @foreach($subjects as $index => $subject)
                <tr>
                    <td>{{ $subjects->firstItem() + $index }}</td>
                    <td>
                        <a href="{{ route('admin.subject.viewSubjectDetails', $subject->id) }}">
                            <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal">
                                <img src="{{ asset('backend/assets/images/new_images/eye-white.svg') }}" alt="Eye Icon">
                            </button>
                        </a>
                    </td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->credits }}</td>
                    <td>{{ $subject->allowed_absences }}</td>
                    <td>{{ $subject->allowed_penalty_amount }}</td>
                    <td>{{ $subject->number_latenesses_equal_absence }}</td>
                    <td><input type="checkbox" {{ $subject->attendance_percent_auto_fail ? 'checked' : '' }} ></td>
                    <td>{{ $subject->attendance_percent_amount }}</td>
                    <td>{{ $subject->attendance_percent_fail_grade }}</td>
                    <td><input type="checkbox" {{ $subject->hebrew_attendance ? 'checked' : '' }} ></td>
                    <td>{{ $subject->gpa_weight }}</td>
                    <td><input type="checkbox" {{ $subject->report_card ? 'checked' : '' }} ></td>
                    <td>{{ $subject->prec_rc }}</td>
                    <td><input type="checkbox" {{ $subject->college_transcript ? 'checked' : '' }} ></td>
                    <td>{{ $subject->transcript_name }}</td>
                    <td>{{ $subject->course_number }}</td>
                    <td>{{ $subject->prec_transcript }}</td>
                    <td><input type="checkbox" {{ $subject->charter_oak_transcript ? 'checked' : '' }} ></td>
                    <td><input type="checkbox" {{ $subject->co_year_long ? 'checked' : '' }} ></td>
                    <td>{{ $subject->co_department }}</td>
                    <td><input type="checkbox" {{ $subject->elective ? 'checked' : '' }} ></td>
                    <td>{{ $subject->comment }}</td>
                    <td><input type="checkbox" {{ $subject->inactive ? 'checked' : '' }} ></td>
                    <td>
                        <div class="actions-wrp">
                            <a href="{{ route('superadmin.subject.edit', $subject->id) }}">
                                <button type="submit">
                                    <img src="{{ asset('backend/assets/images/new_images/edit-icon-primary.svg') }}" alt="Icon">
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <div class="tablepagination">
        @include('backend.partials.pagination', ['paginator' => $subjects, 'routeName' => 'superadmin.subject.index'])
    </div>
