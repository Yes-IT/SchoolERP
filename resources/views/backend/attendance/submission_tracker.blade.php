@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
        <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">
            <div class="ds-breadcrumb">
                <h1>Attendance</h1>
                <ul>
                    <li><a href="../dashboard">Dashboard</a> /</li>
                    <li><a href="./dashboard">Attendance</a> /</li>
                    <li>Attendance Submission Tracker</li>
                </ul>
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
                                <!-- Month and Year Selector -->
                                <div class="dr-input-wrap">
                                    <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-date" style="width: 40%;">
                                        <span class="label" id="range-display">{{ now()->format('F, Y') }}</span>
                                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu datepicker-body-wrp" role="menu" aria-labelledby="toggle-date">
                                        <div class="month-year-picker">
                                            <select id="month-select" name="month">
                                                <!-- Populated by JavaScript -->
                                            </select>
                                            <select id="year-select" name="year">
                                                <!-- Populated by JavaScript -->
                                            </select>
                                            <div class="picker-actions">
                                                <button type="button" id="btn-apply">Apply</button>
                                                <button type="button" id="btn-cancel">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div class="atndnc-filter-actions">
                                <button type="submit" class="btn-search">Search</button>
                            </div>
                        </form>
                    </div>
                
                </div>

                <div class="ds-cmn-table-wrp">
                    
                    @include('backend.attendance.partials.submission_tracker_list')

                </div>
            </div>
        </div>
        <!-- Dashboard Body End -->
@endsection