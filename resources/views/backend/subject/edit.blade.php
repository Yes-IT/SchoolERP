@extends('backend.master')
@section('title')
    {{ @$data['title'] ?? 'Edit Subject' }}
@endsection
@section('content')

<style>
    .error {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
    .alert {
        margin-bottom: 15px;
    }
</style>

<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Subject List</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Subject</a> /</li>
            <li><a href="./dashboard.html">Subject Info</a> /</li>
            <li>Edit Subject</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="ds-cmn-table-wrp">
            <div class="request-leave-form spradmin">
                <form id="subjectForm" action="{{ route('superadmin.subject.update', $subject->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $subject->id }}">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="new-request-form">
                        <h3>Subject Details</h3>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp">
                                <label for="code">Subject ID</label>
                                <input id="code" name="code" type="text" placeholder="Enter Subject ID" value="{{ old('code', $subject->code) }}" readonly disabled>
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="name">Abbreviation</label>
                                <input id="name" name="name" type="text" placeholder="Enter Abbreviation" value="{{ old('name', $subject->name) }}" >
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="new-request-form">
                        <h3>Default Specification for New Classes with this Subject</h3>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp input-full">
                                <label for="credits">Credits</label>
                                <input id="credits" name="credits" type="text" placeholder="Enter Credits" value="{{ old('credits', $subject->credits) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="allowed_absences">Allow Absence</label>
                                <input id="allowed_absences" name="allowed_absences" type="text" placeholder="Enter Allowed Absences" value="{{ old('allowed_absences', $subject->allowed_absences) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="allowed_penalty_amount">Allow Penalty Amount</label>
                                <input id="allowed_penalty_amount" name="allowed_penalty_amount" type="text" placeholder="Enter Penalty Amount" value="{{ old('allowed_penalty_amount', $subject->allowed_penalty_amount) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="number_latenesses_equal_absence">Number of Latenesses Equal to One Absence</label>
                                <input id="number_latenesses_equal_absence" name="number_latenesses_equal_absence" type="text" placeholder="Enter Number" value="{{ old('number_latenesses_equal_absence', $subject->number_latenesses_equal_absence) }}" >
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp checkbox">
                                <label>Attendance % Auto Fail <input id="attendance_percent_auto_fail" name="attendance_percent_auto_fail" type="checkbox" value="1" {{ old('attendance_percent_auto_fail', $subject->attendance_percent_auto_fail) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                            <div class="input-grp checkbox">
                                <label>Hebrew Attendance <input id="hebrew_attendance" name="hebrew_attendance" type="checkbox" value="1" {{ old('hebrew_attendance', $subject->hebrew_attendance) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                            <div class="input-grp checkbox">
                                <label>Report Card <input id="report_card" name="report_card" type="checkbox" value="1" {{ old('report_card', $subject->report_card) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp input-full">
                                <label for="attendance_percent_amount">Attendance % Amount</label>
                                <input id="attendance_percent_amount" name="attendance_percent_amount" type="text" placeholder="Enter Attendance Percentage" value="{{ old('attendance_percent_amount', $subject->attendance_percent_amount) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="attendance_percent_fail_grade">Attendance % Fail Grade</label>
                                <input id="attendance_percent_fail_grade" name="attendance_percent_fail_grade" type="text" placeholder="Enter Fail Grade" value="{{ old('attendance_percent_fail_grade', $subject->attendance_percent_fail_grade) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="gpa_weight">GPA Weight</label>
                                <input id="gpa_weight" name="gpa_weight" type="text" placeholder="Enter GPA Weight" value="{{ old('gpa_weight', $subject->gpa_weight) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="prec_rc">Precedence on Report Card</label>
                                <input id="prec_rc" name="prec_rc" type="text" placeholder="Enter Precedence" value="{{ old('prec_rc', $subject->prec_rc) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="transcript_name">Transcript Name</label>
                                <input id="transcript_name" name="transcript_name" type="text" placeholder="Enter Transcript Name" value="{{ old('transcript_name', $subject->transcript_name) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp">
                                <label for="course_number">Transcript Course Number</label>
                                <input id="course_number" name="course_number" type="text" placeholder="Enter Course Number" value="{{ old('course_number', $subject->course_number) }}" >
                                <span class="error"></span>
                            </div>
                            <div class="input-grp checkbox">
                                <label>College Transcript <input id="college_transcript" name="college_transcript" type="checkbox" value="1" {{ old('college_transcript', $subject->college_transcript) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp">
                                <label for="prec_transcript">Precedence on Transcript</label>
                                <input id="prec_transcript" name="prec_transcript" type="text" placeholder="Enter Precedence" value="{{ old('prec_transcript', $subject->prec_transcript) }}" >
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp checkbox">
                                <label>Chartered Oak Transcript <input id="charter_oak_transcript" name="charter_oak_transcript" type="checkbox" value="1" {{ old('charter_oak_transcript', $subject->charter_oak_transcript) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                            <div class="input-grp checkbox">
                                <label>Chartered Oak Year Long <input id="co_year_long" name="co_year_long" type="checkbox" value="1" {{ old('co_year_long', $subject->co_year_long) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp">
                                <label for="co_department">Chartered Oak Department</label>
                                <input id="co_department" name="co_department" type="text" placeholder="Enter Department" value="{{ old('co_department', $subject->co_department) }}" >
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-3">
                            <div class="input-grp checkbox">
                                <label>Elective <input id="elective" name="elective" type="checkbox" value="1" {{ old('elective', $subject->elective) ? 'checked' : '' }}> </label>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="multi-input-grp grp-1">
                            <div class="input-grp">
                                <label for="comment">Comment</label>
                                <textarea id="comment" name="comment" cols="30" rows="10" placeholder="Enter Comments">{{ old('comment', $subject->comment) }}</textarea>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-submission btn-sm align-right">
                        <input type="submit" value="Update Subject">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Of Dashboard Body -->

@endsection

@push('styles')
<style>
    .error {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
</style>
@endpush

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('subjectForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Clear old error messages
        document.querySelectorAll('.error').forEach(span => span.textContent = '');
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw { status: response.status, data };
            }
            return data;
        })
        .then(data => {
            if (data.status) {
                // Success
                window.location.href = '{{ route('superadmin.subject.index') }}';
            }
        })
        .catch(err => {
            if (err.status === 422 && err.data && err.data.errors) {
                const errors = err.data.errors;
                Object.keys(errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        const errorSpan = input.parentElement.querySelector('.error');
                        if (errorSpan) {
                            errorSpan.textContent = errors[field][0];
                        }
                    }
                });
                // Scroll to the first error field
                const firstErrorField = document.querySelector(`[name="${Object.keys(errors)[0]}"]`);
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }
            } else {
                // Display global error
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger';
                errorDiv.textContent = err.data?.message || 'An unexpected error occurred.';
                form.prepend(errorDiv);
            }
        });
    });
});
</script>
@endpush
