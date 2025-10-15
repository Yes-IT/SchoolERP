@extends('backend.master')

@section('title')
    Subject Details
@endsection

@section('content')

<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">
    <div class="ds-pr-body">
        <div class="dsbdy-filter-wrp">
            Subject Info
            <a href="{{ route('superadmin.subject.edit', $subjectDetails->id) }}"><input type="button" name="" id="" value="Edit"></a>
        </div>
        
        <div class="dspr-bdy-content w-100">
            <div class="dspr-bdy-content-sec border-0">
                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl">
                    <table>
                        <tbody>

                            <tr>
                                <td>ID</td>
                                <td>{{ $subjectDetails->code }}</td>
                            </tr>

                            <tr>
                                <td>Subject</td>
                                <td>{{ $subjectDetails->name }}</td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            
                            {{-- <tr>
                                <td>Course Number</td>
                                <td>{{ $subjectDetails->course_number }}</td>
                            </tr>
                            <tr>
                                <td>Transcript Name</td>
                                <td>{{ $subjectDetails->transcript_name }}</td>
                            </tr>
                            <tr>
                                <td>CO Department</td>
                                <td>{{ $subjectDetails->co_department }}</td>
                            </tr> --}}

                            <tr>
                                <td>Credits</td>
                                <td>{{ $subjectDetails->credits }}</td>
                            </tr>

                            <tr>
                                <td>Allowed Absences</td>
                                <td>{{ $subjectDetails->allowed_absences }}</td>
                            </tr>

                            <tr>
                                <td>Absences Penalty Amount</td>
                                <td>{{ $subjectDetails->allowed_penalty_amount }}</td>
                            </tr>

                            <tr>
                                <td>Number of Latenesses Equal Absence</td>
                                <td>{{ $subjectDetails->number_latenesses_equal_absence }}</td>
                            </tr>

                            <tr>
                                <td>Attendance Percent Auto Fail</td>
                                <td>
                                    <input type="checkbox"  {{ $subjectDetails->attendance_percent_auto_fail ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <tr>
                                <td>Attendance Percent Amount</td>
                                <td>{{ $subjectDetails->attendance_percent_amount }}%</td>
                            </tr>

                            <tr>
                                <td>Attendance Percent Fail Grade</td>
                                <td>{{ $subjectDetails->attendance_percent_fail_grade }}</td>
                            </tr>

                            <tr>
                                <td>Hebrew Attendance</td>
                                <td>
                                    <input type="checkbox"  {{ $subjectDetails->hebrew_attendance ? 'checked' : '' }}>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>GPA Weight</td>
                                <td>{{ $subjectDetails->gpa_weight }}</td>
                            </tr>
                            
                            <tr>
                                <td>Report Card</td>
                                <td>
                                    <input type="checkbox"  {{ $subjectDetails->report_card ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <tr>
                                <td>Precedence on RC</td>
                                <td>{{ $subjectDetails->prec_rc }}</td>
                            </tr>

                            <tr>
                                <td>College Transcript</td>
                                <td>
                                    <input type="checkbox"  {{ $subjectDetails->college_transcript ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <tr>
                                <td>Transcript Name</td>
                                <td>{{ $subjectDetails->transcript_name }}</td>
                            </tr>

                            <tr>
                                <td>Transcript Course</td>
                                <td>{{ $subjectDetails->course_number }}</td>
                            </tr>
                            
                            <tr>
                                <td>Precedence of Transcript</td>
                                <td>{{ $subjectDetails->prec_transcript }}</td>
                            </tr>

                            <tr>
                                <td>Charter Oak Transcript</td>
                                <td>
                                    <input type="checkbox" {{ $subjectDetails->charter_oak_transcript ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <tr>
                                <td>Charter Oak Year Long</td>
                                <td>
                                    <input type="checkbox" {{ $subjectDetails->co_year_long ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <tr>
                                <td>Charter Oak Department</td>
                                <td>{{ $subjectDetails->co_department }}</td>
                            </tr>

                            <tr>
                                <td>Elective</td>
                                <td>
                                    <input type="checkbox"  {{ $subjectDetails->elective ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <tr>
                                <td>Comment</td>
                                <td>{{ $subjectDetails->comment ?? '—' }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Dashboard Body -->

@endsection