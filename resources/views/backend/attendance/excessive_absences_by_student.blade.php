@extends('backend.master')
@section('title') Excessive Absences by Student @endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Attendance</h1>
        <ul>
            <li><a href="{{ url('dashboard') }}">Dashboard</a> /</li>
            <li><a href="#">Attendance</a> /</li>
            <li>Excessive Absences by Student</li>
        </ul>

        <div class="dropdown-year" data-selected="Excessive Absences by Student">
            <div class="dropdown-trigger" aria-expanded="false">
                <span class="dropdown-label">Excessive Absences by Student</span>
                <i class="dropdown-arrow"></i>
            </div>
            <div class="dropdown-options">
                <div class="dropdown-option" data-url="{{ route('student-report.index') }}">Attendance By Student</div>
                <div class="dropdown-option" data-url="{{ route('class-report.index') }}">Attendance By Class</div>
                <div class="dropdown-option" data-url="{{ route('student-attendance-summary.index') }}">Student Attendance Summary</div>
                <div class="dropdown-option active" data-url="{{ route('excessive.student.index') }}">Excessive Absences by Student</div>
                <div class="dropdown-option" data-url="{{ route('excessive.class.index') }}">Excessive Absences by Class</div>
            </div>
        </div>
    </div>

    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head"><h2>Select Criteria</h2></div>

            <div class="atndnc-filter">
                <form id="attendance-filter-form" class="atndnc-filter-form">
                    @csrf

                    <div class="atndnc-filter-options">
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
                        <div class="dropdown student-dropdown" style="width: 250px;">
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

        <div class="ds-cmn-table-wrp" id="excessive-absences-student-table">
            <!-- Everything (table + pagination + per-page) will be loaded here -->
        </div>

    </div>
</div>

@endsection

@push('script')

<script>

    jQuery(function($) {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        const searchUrl = "{{ route('excessive.student.search') }}";

        function getFilters() {
            const f = {};
            $('#attendance-filter-form input[type=radio]:checked').each(function() {
                if (this.value) f[this.name] = this.value;
            });
            // Always take current per_page value
            f.per_page = $('#pagination-links select[name="per_page"]').val() || 10;
            return f;
        }

        function loadData(href = null) {
            let payload = getFilters();

            // If we are coming from a pagination link → keep its page number
            if (href) {
                try {
                    const u = new URL(href);
                    const pageFromLink = u.searchParams.get('page');
                    if (pageFromLink) payload.page = pageFromLink;
                } catch (e) {}
            } else {
                // Important: when changing filters or per_page → always start from page 1
                payload.page = 1;
            }

            $.post(searchUrl, payload)
                .done(resp => {
                    $('#excessive-absences-student-table').html(resp.html); // ← ONE LINE
                    attachEvents();
                })
                .fail(() => alert('Error loading data'));
            }

        $('#pagination-links select[name="per_page"]').off('change').on('change', function() {
        loadData(); // This resets to page 1 and reloads → works 100%
    });

    function attachEvents() {
        // Pagination links
        $(document).off('click', '#pagination-links a');
        $(document).on('click', '#pagination-links a', function(e) {
            e.preventDefault();
            loadData(this.href);   // this.href already contains correct page & per_page
        });

        // Per Page change → reset to page 1
        $('#pagination-links select[name="per_page"]').off('change').on('change', function() {
            loadData();   // href = null → payload.page will be set to 1
        });
    }

    // Dropdown Navigation
    $('.dropdown-option').on('click', function() {
        $('.dropdown-option').removeClass('active');
        $(this).addClass('active');
        const url = $(this).data('url');
        if (url) window.location = url;
    });

    $('#attendance-filter-form').on('submit', e => { e.preventDefault(); loadData(); });
    $('#attendance-filter-form').on('change', 'input[type=radio]', () => loadData());

    // Initial load
    loadData();
    attachEvents();
});
</script>
@endpush