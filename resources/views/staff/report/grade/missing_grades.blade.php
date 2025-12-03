@extends('staff.master')

@section('content')

<div class="ds-breadcrumb">
    <h1>Attendance Reports</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Attendance Reports</li>
    </ul>
</div>

<!-- Working Top Dropdown Menu -->
<div class="dropdown-grade">
    <button class="cmn-btn print-btn grade-btn" onclick="toggleDropdownWeek()">
        Students with Missing Grades
        <img src="{{ asset('staff') }}/assets/images/upwhite.svg" alt="Icon">
    </button>
    <ul class="dropdown-menu-grade">
        <li><a href="{{ route('staff.report.grade.all-grade') }}">All Grades Records</a></li>
        <li><a href="{{ route('staff.report.grade.failing-grade') }}">Students with Failing Grades</a></li>
        <li><a href="{{ route('staff.report.grade.missing-grade') }}">Students with Missing Grades</a></li>
    </ul>
</div>

<div class="ds-pr-body">

    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head">
            <h2>Select Criteria</h2>
        </div>
        <div class="atndnc-filter">
            <form id="missingGradeSearchForm">
                @csrf
                <div class="atndnc-filter-form">
                    <div class="atndnc-filter-options">

                        <!-- Year -->
                        <div class="dropdown year-dropdown selectisub">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">Select Year</span>
                                <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                            </button>
                            <div class="dropdown-menu">
                                @foreach($years as $year)
                                    <label class="dropdown-item" data-id="{{ $year->id }}">
                                        {{ $year->name ?? $year->year }}
                                    </label>
                                @endforeach
                            </div>
                            <input type="hidden" name="year_id" id="year_id" value="">
                        </div>

                        <!-- Year Status -->
                        <div class="dropdown year-status-dropdown selectisub">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">Select Year Status</span>
                                <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                            </button>
                            <div class="dropdown-menu">
                                @foreach($yearStatuses as $status)
                                    <label class="dropdown-item" data-id="{{ $status->id }}">
                                        {{ $status->name }}
                                    </label>
                                @endforeach
                            </div>
                            <input type="hidden" name="year_status_id" id="year_status_id" value="">
                        </div>

                        <!-- Semester -->
                        <div class="dropdown semester-dropdown selectisub">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">Select Semester</span>
                                <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                            </button>
                            <div class="dropdown-menu">
                                @foreach($semesters as $semester)
                                    <label class="dropdown-item" data-id="{{ $semester->id }}">
                                        {{ $semester->name }}
                                    </label>
                                @endforeach
                            </div>
                            <input type="hidden" name="semester_id" id="semester_id" value="">
                        </div>

                    </div>
                    <button type="submit" id="btnSearch" class="btn-search">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="ds-cmn-table-wrp tab-wrapper" id="missing_grade_result">
        
    </div>
</div>

@endsection

@push('script')

<script>

$(function () {
    
    // === Top Menu Dropdown (Working) ===
    $('#gradeMenuBtn').on('click', function (e) {
        e.stopPropagation();
        $('#gradeDropdownMenu').toggleClass('show');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.dropdown-grade').length) {
            $('#gradeDropdownMenu').removeClass('show');
        }
    });

    // === Single-Select Dropdown Logic (Same as All Grades & Failing Grades) ===
    $(document).on('click', '.dropdown-item', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $item = $(this);
        const $dropdown = $item.closest('.selectisub');
        const label = $item.text().trim();
        const value = $item.data('id');

        $dropdown.find('.dropdown-toggle .label').text(label);
        $dropdown.find('input[type="hidden"]').val(value);
        $dropdown.find('.dropdown-menu').removeClass('show');
    });

    $(document).on('click', '.dropdown-toggle', function (e) {
        e.stopPropagation();
        const $menu = $(this).next('.dropdown-menu');
        $('.dropdown-menu').not($menu).removeClass('show');
        $menu.toggleClass('show');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.selectisub').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });

    function setDefaultSelections() {
        $('.selectisub').each(function () {
            const $dropdown = $(this);
            const $first = $dropdown.find('.dropdown-item').first();
            if ($first.length) {
                const label = $first.text().trim();
                const id = $first.data('id');
                $dropdown.find('.dropdown-toggle .label').text(label);
                $dropdown.find('input[type="hidden"]').val(id);
            }
        });
    }

    // === AJAX: Fetch Missing Grades ===
    function fetchMissingGrades() {
        const year_id        = $('#year_id').val();
        const year_status_id = $('#year_status_id').val();
        const semester_id    = $('#semester_id').val();

        if (!year_id || !semester_id) {
            showWarning('Please select Year and Semester.');
            return;
        }

        $.ajax({
            url: "{{ route('staff.report.grade.missing-grade.search') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                year_id: year_id,
                year_status_id: year_status_id,
                semester_id: semester_id
            },
            success: function (response) {
                $("#btnSearch").text("Search").prop('disabled', false);
                $("#missing_grade_result").html(response);
                showSuccess('Missing grades loaded successfully.');
            },
            error: function (xhr) {
                $("#btnSearch").text("Search").prop('disabled', false);
                const msg = xhr.responseJSON?.message || 'Failed to load missing grades.';
                showError({ responseJSON: { message: msg } });
            }
        });
    }

    // === On Load ===
    $(document).ready(function () {
        setDefaultSelections();
        fetchMissingGrades(); // Auto load
    });

    // === Search Button ===
    $('#missingGradeSearchForm').on('submit', function (e) {
        e.preventDefault();
        fetchMissingGrades();
    });

});

</script>
@endpush
