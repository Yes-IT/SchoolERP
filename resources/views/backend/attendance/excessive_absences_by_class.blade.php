@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
    <style>
        .ds-cmn-tble {
            transition: opacity 0.3s ease;
        }
        .ds-cmn-tble.loading {
            opacity: 0.5;
        }
        .tbl-pagination-inr ul li {
            margin: 0 5px;
        }
        .pages-select {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .pages-select .formfield {
            margin-right: 15px;
        }
        .cmn-tab-head ul li {
            cursor: pointer;
        }
        .cmn-tab-head ul li span {
            display: block;
            text-decoration: none;
            color: inherit;
        }
    </style>

    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">

        <div class="ds-breadcrumb">
            <h1>Attendance</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="dashboard.html">Attendance</a> /</li>
                <li>Attendance Report</li>
            </ul>

            <div class="dropdown-year" data-selected="Subject Grade Report">
                <div class="dropdown-trigger" aria-expanded="false">
                    <span class="dropdown-label">
                        Excessive Absences by Class
                    </span>
                    <i class="dropdown-arrow"></i>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option" data-url="{{ route('student-report.index') }}">
                        Attendance By Student
                    </div>
                    <div class="dropdown-option" data-url="{{ route('class-report.index') }}">
                        Attendance By Class
                    </div>
                    <div class="dropdown-option" data-url="{{ route('student-attendance-summary.index') }}">
                         Student Attendance Summary
                    </div>
                    <div class="dropdown-option" data-url="{{ route('excessive.student.index') }}">
                            Excessive Absences by Student
                    </div>
                    <div class="dropdown-option active" data-url="{{ route('excessive.class.index') }}">
                           Excessive Absences by Class
                    </div>
                </div>
            </div>

        </div>
        

        <div class="ds-pr-body">
            <div class="atndnc-filter-wrp w-100">
                <div class="sec-head">
                    <h2>Filters</h2>
                </div>

                <div class="atndnc-filter">
                    <form id="attendance-filter-form" class="atndnc-filter-form">

                        <div class="atndnc-filter-options">
                            <!-- Select Year -->
                            <div class="dropdown year-dropdown">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-year">
                                    <span class="label">Select Year</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-year">
                                    <label><input type="radio" name="school_year" value=""> All Years</label>
                                    @foreach($schoolYears as $year)
                                        <label><input type="radio" name="school_year" value="{{ $year->id }}">&nbsp;{{ $year->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Select Year Status -->
                            <div class="dropdown year-status-dropdown">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-year-status">
                                    <span class="label">Select Year Status</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-year-status">
                                    <label><input type="radio" name="year_status" value=""> All Year Status</label>
                                    @foreach($yearStatuses as $status)
                                        <label><input type="radio" name="year_status" value="{{ $status->id }}">&nbsp;{{ $status->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Select Semester -->
                            <div class="dropdown semester-dropdown">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-semester">
                                    <span class="label">Select Semester</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-semester">
                                    <label><input type="radio" name="semester" value=""> All Semesters</label>
                                    @foreach($semesters as $semester)
                                        <label><input type="radio" name="semester" value="{{ $semester->id }}">&nbsp;{{ $semester->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="atndnc-filter-options">
                            <div class="dropdown student-dropdown" style="width: 230px;">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-student">
                                    <span class="label">Select Student</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-student">
                                    <label><input type="radio" name="student_id" value=""> All Students</label>
                                    @foreach($students as $student)
                                        <label><input type="radio" name="student_id" value="{{ $student->id }}">&nbsp;{{ $student->first_name }} {{ $student->last_name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-search">Search</button>
                    </form>
                </div>
            </div>

            <div class="ds-cmn-table-wrp tab-wrapper">

                <div id="attendance-table-content">
                    <!-- Attendance Table -->
                    <div class="ds-cmn-tble attendance" style="display: block;">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Student Name</th>
                                    <th>Personal Absences</th>
                                    <th>P* Absences</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Attendance rows will go here -->
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Pagination Section -->
                <div class="tablepagination" id="pagination-links">
                    <!-- Pagination links will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.dropdown-options .dropdown-option').forEach(function (el) {
                el.addEventListener('click', function () {
                    // set active visual state
                    document.querySelectorAll('.dropdown-options .dropdown-option').forEach(function (o) {
                        o.classList.remove('active');
                    });
                    el.classList.add('active');

                    var url = el.getAttribute('data-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
@endpush