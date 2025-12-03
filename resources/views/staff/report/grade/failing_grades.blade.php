@extends('staff.master')

@section('content')

<div class="ds-breadcrumb">
    <h1>Attendance Reports</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Attendance Reports</li>
    </ul>
</div>

<div class="dropdown-grade">
    <button class="cmn-btn print-btn grade-btn" onclick="toggleDropdownWeek()">
        Students with Failing Grades
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
            <form id="failingGradeSearchForm">
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

    <div class="ds-cmn-table-wrp tab-wrapper" id="failing_grade_result">
        
    </div>

</div>

@endsection

@push('script')

<script>

$(function () {
    
    $(document).on('click', '.dropdown-item', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $item = $(this);
        const $dropdown = $item.closest('.selectisub');
        const labelText = $item.text().trim();
        const value = $item.data('id');

        $dropdown.find('.dropdown-toggle .label').text(labelText);
        $dropdown.find('input[type="hidden"]').val(value);
        $dropdown.find('.dropdown-menu').removeClass('show');
    });

    $(document).on('click', '.dropdown-toggle', function (e) {
        e.stopPropagation();
        const $dropdown = $(this).closest('.selectisub');
        const $menu = $dropdown.find('.dropdown-menu');
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
            const $hidden = $dropdown.find('input[type="hidden"]');
            const preVal = $hidden.val();
            let $selected = null;

            if (preVal) {
                $selected = $dropdown.find(`.dropdown-item[data-id="${preVal}"]`);
            }
            if (!$selected || !$selected.length) {
                $selected = $dropdown.find('.dropdown-item').first();
            }

            if ($selected.length) {
                const label = $selected.text().trim();
                const id = $selected.data('id');
                $dropdown.find('.dropdown-toggle .label').text(label);
                $hidden.val(id);
            }
        });
    }

    // === AJAX: Load Failing Grades ===
    function fetchFailingGrades() {
        const year_id        = $('#year_id').val();
        const year_status_id = $('#year_status_id').val();
        const semester_id    = $('#semester_id').val();

        if (!year_id || !semester_id) {
            showWarning('Please select Year and Semester.');
            return;
        }

        $.ajax({
            url: "{{ route('staff.report.grade.failing-grade.search') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                year_id: year_id,
                year_status_id: year_status_id,
                semester_id: semester_id
            },
            success: function (response) {
                $("#btnSearch").text("Search").prop('disabled', false);
                $("#failing_grade_result").html(response);
                showSuccess('Failing grades loaded successfully.');
            },
            error: function (xhr) {
                $("#btnSearch").text("Search").prop('disabled', false);
                const msg = xhr.responseJSON?.message || 'Failed to load failing grades.';
                showError({ responseJSON: { message: msg } });
            }
        });
    }

    // === On Page Load: Set defaults + Auto load ===
    $(document).ready(function () {
        setDefaultSelections();
        fetchFailingGrades();
    });

    // === Search Button Click ===
    $('#failingGradeSearchForm').on('submit', function (e) {
        e.preventDefault();
        fetchFailingGrades();
    });

});

</script>


<script>
    $(document).on('click', '.dropdown-menu-grade a', function(e) {
        e.stopPropagation();
        window.location.href = $(this).attr('href'); 
    });
</script>

@endpush