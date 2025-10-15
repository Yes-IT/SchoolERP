@extends('backend.master')
@section('title')
    Monthly Attendance Management
@endsection
@section('content')
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Attendance</h1>
            <ul>
                <li><a href="../dashboard">Dashboard</a> /</li>
                <li><a href="./dashboard">Attendance</a> /</li>
                <li>Attendance View</li>
            </ul>

            <div class="dropdown-year" data-selected="Monthly Attendance">
                <div class="dropdown-trigger" aria-expanded="false">
                    <span class="dropdown-label">Monthly Attendance</span>
                    <i class="dropdown-arrow"></i>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option {{ request()->routeIs('daily.index') ? 'active' : '' }}" 
                        data-url="{{ route('daily.index') }}">
                        Daily Attendance
                    </div>
                    <div class="dropdown-option {{ request()->routeIs('monthly.index') ? 'active' : '' }}" 
                        data-url="{{ route('monthly.index') }}">
                        Monthly Attendance
                    </div>
                    <div class="dropdown-option {{ request()->routeIs('total.index') ? 'active' : '' }}" 
                        data-url="{{ route('total.index') }}">
                        Semester Total Attendance
                    </div>
                </div>
            </div>
        </div>
        <div class="ds-pr-body">
            <div class="atndnc-filter-wrp w-100">
                <div class="sec-head">
                    <h2>Select Criteria</h2>
                </div>
                
                <div class="atndnc-filter">
                    <form class="atndnc-filter-form" id="attendance-filter-form">
                        @csrf
                        <div class="atndnc-filter-options">
                            <!-- Select Year -->
                            <div class="dropdown year-dropdown" style="width: 160px;">
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
                                    <label><input type="radio" name="year_status" value=""> All Statuses</label>
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
                            <!-- Select Class -->
                            <div class="dropdown class-dropdown" style="width: 230px;">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-class">
                                    <span class="label">Select Class</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-class">
                                    <label><input type="radio" name="class_id" value=""> All Classes</label>
                                    @foreach($classes as $class)
                                        <label><input type="radio" name="class_id" value="{{ $class->id }}">&nbsp;{{ $class->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Select Subject -->
                            <div class="dropdown subject-dropdown" style="width:280px;">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-subject">
                                    <span class="label">Select Subject</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-subject">
                                    <label><input type="checkbox" name="subject_id[]" value="all" checked> All Subjects</label>
                                    @foreach($subjects as $subject)
                                        <label><input type="checkbox" name="subject_id[]" value="{{ $subject->id }}">&nbsp;{{ $subject->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Month and Year Selector -->
                            
                        </div>

                        <!-- Search Button -->
                        <div class="atndnc-filter-actions">
                            <button type="submit" class="btn-search">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ds-cmn-table-wrp" id="attendance-table">
                 @include('backend.attendance.partials.total_attendance_list')
            </div>
            
        </div>
    </div>
@endsection
