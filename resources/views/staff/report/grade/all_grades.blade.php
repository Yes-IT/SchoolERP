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
        All Grades Records
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
            <form id="gradeSearchForm">
                <div class="atndnc-filter-form">
                    <div class="atndnc-filter-options">

                        <div class="header-filter">
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
                                        <label class="dropdown-item" data-id="all">
                                        Full Year
                                        </label>
                                </div>
                                <input type="hidden" name="semester_id" id="semester_id" value="">
                            </div>
                        </div>

                        <div class="header-filter">
                            <!-- Subject -->
                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">Select Subject</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($subjects as $subject)
                                        <label class="dropdown-item" data-id="{{ $subject->id }}">
                                            {{ $subject->name }}
                                        </label>
                                    @endforeach
                                </div>
                                <input type="hidden" name="subject_id" id="subject_id" value="">
                            </div>

                            <!-- Class -->
                            <div class="dropdown class-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">Select Class</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($classes as $class)
                                        <label class="dropdown-item" data-id="{{ $class->id }}">
                                            {{ $class->name }}
                                        </label>
                                    @endforeach
                                </div>
                                <input type="hidden" name="class_id" id="class_id" value="">
                            </div>
                        </div>

                    </div>
                    <button type="submit" id="btnSearch" class="btn-search">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="ds-cmn-table-wrp tab-wrapper" id="grade_result">
        
    </div>
    
</div>

@endsection

@push('script')
<script>
$(function () {
    // Dropdown selection logic (unchanged)
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

    // Set default selections and store the first valid item
    function setDefaultSelections() {
        let hasSelection = false;

        $('.selectisub').each(function () {
            const $dropdown = $(this);
            const $hidden = $dropdown.find('input[type="hidden"]');
            const preVal = $hidden.val();
            let $selectedItem = null;

            if (preVal) {
                $selectedItem = $dropdown.find(`.dropdown-item[data-id="${preVal}"]`);
            }
            if (!$selectedItem || !$selectedItem.length) {
                $selectedItem = $dropdown.find('.dropdown-item').first();
            }

            if ($selectedItem.length) {
                const label = $selectedItem.text().trim();
                const id = $selectedItem.data('id');
                $dropdown.find('.dropdown-toggle .label').text(label);
                $hidden.val(id);
                hasSelection = true;
            }
        });

        return hasSelection;
    }

    // Function to fetch grade records via AJAX
    function fetchGradeRecords() {
        const year_id        = $('#year_id').val();
        const year_status_id = $('#year_status_id').val();
        const semester_id    = $('#semester_id').val();
        const subject_id     = $('#subject_id').val();
        const class_id       = $('#class_id').val();

        // Optional: Prevent request if critical filters are missing
        if (!year_id || !semester_id) {
            showWarning('Please select Year and Semester at minimum.');
            return;
        }

        $.ajax({
            url: "{{ route('staff.report.grade.all-grade.search') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                year_id: year_id,
                year_status_id: year_status_id,
                semester_id: semester_id,
                subject_id: subject_id,
                class_id: class_id,
            },
            success: function (response) {
                $("#btnSearch").text("Search");
                $("#btnSearch").prop('disabled', false);

                $("#grade_result").html(response);
                showSuccess('Grade records loaded successfully.');
            },
            error: function (xhr) {
                $("#btnSearch").text("Search");
                $("#btnSearch").prop('disabled', false);

                let message = 'Something went wrong while fetching records.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    message = 'Please check your selected filters.';
                }

                showError({ responseJSON: { message: message } });
                console.error(xhr);
            }
        });
    }

    // Initialize defaults and load data on page load
    $(document).ready(function () {
        setDefaultSelections();
        fetchGradeRecords(); // Auto-load on page load
    });

    // Search button click
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        fetchGradeRecords();
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