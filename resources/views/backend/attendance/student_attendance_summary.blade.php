@extends('backend.master')
@section('title') Student Attendance Summary @endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Attendance</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="dashboard.html">Attendance</a> /</li>
            <li>Student Attendance Summary</li>
        </ul>

        <div class="dropdown-year" data-selected="Student Attendance Summary">
            <div class="dropdown-trigger" aria-expanded="false">
                <span class="dropdown-label">Student Attendance Summary</span>
                <i class="dropdown-arrow"></i>
            </div>
            <div class="dropdown-options">
                <div class="dropdown-option" data-url="{{ route('student-report.index') }}">Attendance By Student</div>
                <div class="dropdown-option" data-url="{{ route('class-report.index') }}">Attendance By Class</div>
                <div class="dropdown-option active" data-url="{{ route('student-attendance-summary.index') }}">Student Attendance Summary</div>
                <div class="dropdown-option" data-url="{{ route('excessive.student.index') }}">Excessive Absences by Student</div>
                <div class="dropdown-option" data-url="{{ route('excessive.class.index') }}">Excessive Absences by Class</div>
            </div>
        </div>
    </div>

    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head"><h2>Select Criteria</h2></div>

            <div class="atndnc-filter">
                <form class="atndnc-filter-form" id="attendance-filter-form">
                    @csrf

                    <div class="atndnc-filter-options">
                        <!-- Year -->
                        <div class="dropdown year-dropdown">
                            <button type="button" class="dropdown-toggle" id="toggle-year">
                                <span class="label">Select Year</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <label><input type="radio" name="school_year" value="" checked> All Years</label>
                                @foreach($schoolYears as $year)
                                    <label><input type="radio" name="school_year" value="{{ $year->id }}" {{ request('school_year')==$year->id?'checked':'' }}>&nbsp;{{ $year->name }}</label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Year Status -->
                        <div class="dropdown year-status-dropdown">
                            <button type="button" class="dropdown-toggle" id="toggle-year-status">
                                <span class="label">Select Year Status</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <label><input type="radio" name="year_status" value="" checked> All Statuses</label>
                                @foreach($yearStatuses as $status)
                                    <label><input type="radio" name="year_status" value="{{ $status->id }}" {{ request('year_status')==$status->id?'checked':'' }}>&nbsp;{{ $status->name }}</label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Semester -->
                        <div class="dropdown semester-dropdown">
                            <button type="button" class="dropdown-toggle" id="toggle-semester">
                                <span class="label">Select Semester</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <label><input type="radio" name="semester" value="" checked> All Semesters</label>
                                @foreach($semesters as $semester)
                                    <label><input type="radio" name="semester" value="{{ $semester->id }}" {{ request('semester')==$semester->id?'checked':'' }}>&nbsp;{{ $semester->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="atndnc-filter-options">
                        <div class="dropdown student-dropdown" style="width: 230px;">
                            <button type="button" class="dropdown-toggle" id="toggle-student">
                                <span class="label">Select Student</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <label><input type="radio" name="student_id" value="" checked> All Students</label>
                                @foreach($students as $student)
                                    <label><input type="radio" name="student_id" value="{{ $student->id }}" {{ request('student_id')==$student->id?'checked':'' }}>
                                        &nbsp;{{ $student->first_name }} {{ $student->last_name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="atndnc-filter-actions">
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- RESULT TABLE -->
        <div class="ds-cmn-table-wrp" id="attendance-table">
            <!-- Content + Table + Title loaded via AJAX -->
        </div>

        <!-- PAGINATION + PER PAGE BELOW TABLE -->
            <div class="tablepagination" id="pagination-links" style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                
            <div>
            <!-- Pagination links will appear here --></div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
jQuery(function($) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    const searchUrl = "{{ route('student-attendance-summary.search') }}";

    function getFilters() {
        const f = {};
        $('#attendance-filter-form input[type=radio]:checked').each(function() {
            if (this.value) f[this.name] = this.value;
        });
        f.per_page = $('#pagination-links select[name="per_page"]').val() || 10;
        return f;
    }

    function loadData(href = null) {
        let payload = getFilters();

        if (href) {
            try {
                const url = new URL(href);
                payload.page = url.searchParams.get('page') || 1;
                url.searchParams.forEach((v, k) => {
                    if (k !== 'page' && k !== 'per_page') payload[k] = v;
                });
            } catch (e) { console.warn(e); }
        } else {
            payload.page = 1;
        }

        $.post(searchUrl, payload)
            .done(function(resp) {
                $('#attendance-table').html(resp.data);           // Table + Title
                $('#pagination-links > div:last-child').html(resp.pagination); // Only pagination links

                // Sync per_page dropdown
                $('#pagination-links select[name="per_page"]').val(payload.per_page || 10);

                attachEvents();
            })
            .fail(function() {
                alert('Error loading data');
            });
    }

    function attachEvents() {
        // Pagination links
        $(document).off('click', '#pagination-links a');
        $(document).on('click', '#pagination-links a', function(e) {
            e.preventDefault();
            loadData(this.href);
        });

        // Per Page change
        $('#pagination-links select[name="per_page"]').off('change').on('change', function() {
            loadData();
        });
    }

    // Form submit & radio change
    $('#attendance-filter-form').on('submit', function(e) {
        e.preventDefault();
        loadData();
    });

    $('#attendance-filter-form').on('change', 'input[type=radio]', function() {
        loadData();
    });

    // Initial load
    loadData();
    attachEvents();

    // Dropdown Navigation
        $('.dropdown-option').on('click', function() {
            $('.dropdown-option').removeClass('active');
            $(this).addClass('active');
            const url = $(this).data('url');
            if (url) window.location = url;
        });
});
</script>
@endpush