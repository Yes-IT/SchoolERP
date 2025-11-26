@extends('staff.master')

@section('content')

<div class="ds-breadcrumb">
    <h1>Attendance Reports</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Attendance Reports</li>
    </ul>
</div>

<div class="ds-pr-body">

    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head"><h2>Select Criteria</h2></div>
            <div class="atndnc-filter">
                <form id="attendanceFilterForm" method="GET">
                    
                    <div class="atndnc-filter-options">

                        <!-- Row 1 -->
                        <div class="header-filter">
                            <!-- Year (Radio) -->
                            <div class="dropdown year-dropdown selectisub">
                                <button type="button" class="dropdown-toggle" aria-expanded="false">
                                    <span class="label">Select Year</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($years as $index => $year)
                                        <label>
                                            <input type="radio" name="year_id" value="{{ $year->id }}"
                                                {{ $index == 0 ? 'checked' : '' }}>
                                            {{ $year->name ?? $year->year }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Year Status (Radio) -->
                            <div class="dropdown year-status-dropdown selectisub">
                                <button type="button" class="dropdown-toggle" aria-expanded="false">
                                    <span class="label">Select Year Status</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($yearStatuses as $index => $status)
                                        <label>
                                            <input type="radio" name="year_status_id" value="{{ $status->id }}"
                                                {{ $index == 0 ? 'checked' : '' }}>
                                            {{ $status->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Semester (Radio) -->
                            <div class="dropdown semester-dropdown selectisub">
                                <button type="button" class="dropdown-toggle" aria-expanded="false">
                                    <span class="label">Select Semester</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($semesters as $index => $semester)
                                        <label>
                                            <input type="radio" name="semester_id" value="{{ $semester->id }}"
                                                {{ $index == 0 ? 'checked' : '' }}>
                                            {{ $semester->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Row 2 -->
                        <div class="d-flex gap-3 mt-3">
                            <!-- Subject (Radio) -->
                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle" aria-expanded="false">
                                    <span class="label">Select Subject</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($subjects as $index => $subject)
                                        <label>
                                            <input type="radio" name="subject_id" value="{{ $subject->id }}"
                                                {{ $index == 0 ? 'checked' : '' }}>
                                            {{ $subject->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Class (Radio) -->
                            <div class="dropdown class-dropdown selectisub">
                                <button type="button" class="dropdown-toggle" aria-expanded="false">
                                    <span class="label">Select Class</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($classes as $index => $class)
                                        <label>
                                            <input type="radio" name="class_id" value="{{ $class->id }}"
                                                {{ $index == 0 ? 'checked' : '' }}>
                                            {{ $class->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                    </div>

                    <button type="submit" class="btn-search mt-3">Search</button>
                </form>
            </div>
        </div>
    </div>

        <!-- Tabs & Month Selector -->
    <div class="ds-cmn-table-wrp tab-wrapper">

        <div class="ds-content-head">
            <div class="cmn-tab-head">
                <ul>
                    <li class="tab-bg"></li>
                    <li class="tab-switch active" data-tab="month">Month Wise</li>
                    <li class="tab-switch" data-tab="semester">Semester Total</li>
                </ul>
            </div>

            <!-- Month Dropdown (Radio - kept as is, single month selection) -->
            <div class="dropdown selectisub" id="monthDropdown">
                <button type="button" class="dropdown-toggle month-dropdown">
                    <span class="label">Select Month</span>
                    <img src="{{ asset('staff/assets/images/dropdown-arrow.svg') }}" class="arrow-att" />
                </button>
                <div class="dropdown-menu">
                    @php
                        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                        $currentMonth = date('n');
                    @endphp
                    @foreach($months as $index => $month)
                        <label>
                            <input type="radio" name="selected_month" value="{{ $index + 1 }}"
                                {{ ($index + 1) == $currentMonth ? 'checked' : '' }}>
                            {{ $month }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Result Container -->
        <div id="attendanceResult">
            <p class="mt-3">Loading attendance data...</p>
        </div>

    </div>

</div>

@endsection

@push('script')

<script>

    $(document).ready(function() {
        let currentTab = 'month';

        // Update dropdown label for radio selection
        function updateRadioDropdownLabel(menu) {
            const checked = menu.find('input[type="radio"]:checked');
            const labelSpan = menu.closest('.dropdown').find('.label');
            if (checked.length) {
                labelSpan.text(checked.parent().text().trim());
            } else {
                labelSpan.text(menu.find('label').first().text().trim());
            }
        }

        // Load attendance via AJAX
        function loadAttendance() {
            $('#attendanceResult').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-3">Loading...</p></div>');

            const formData = $('#attendanceFilterForm').serializeArray();
            const month = $('#monthDropdown input[name="selected_month"]:checked').val() || new Date().getMonth() + 1;

            formData.push({ name: 'tab', value: currentTab });
            formData.push({ name: 'month', value: month });
            formData.push({ name: '_token', value: '{{ csrf_token() }}' });

            $.ajax({
                url: '{{ route("staff.report.attendance.search") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#attendanceResult').html(response.html || '<p class="text-danger text-center">No data found</p>');
                },
                error: function() {
                    $('#attendanceResult').html('<p class="text-danger text-center">Error loading data. Please try again.</p>');
                }
            });
        }

        // Tab Switch
        $('.tab-switch').on('click', function() {
            $('.tab-switch').removeClass('active');
            $(this).addClass('active');
            currentTab = $(this).data('tab');
            loadAttendance();
        });

        // Month Selection
        $('#monthDropdown').on('change', 'input[name="selected_month"]', function() {
            const selectedText = $(this).parent().text().trim();
            $('#monthDropdown .label').text(selectedText);
            loadAttendance();
        });

        // Radio change inside any filter dropdown
        $('.atndnc-filter-options').on('change', 'input[type="radio"]', function() {
            const menu = $(this).closest('.dropdown-menu');
            updateRadioDropdownLabel(menu);
            loadAttendance();
        });

        // Search button
        $('#attendanceFilterForm').on('submit', function(e) {
            e.preventDefault();
            loadAttendance();
        });

        // Dropdown open/close
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu.show').removeClass('show');
            }
        });

        $('.dropdown-toggle').on('click', function(e) {
            e.stopPropagation();
            const menu = $(this).next('.dropdown-menu');
            $('.dropdown-menu.show').not(menu).removeClass('show');
            menu.toggleClass('show');
        });

        // Initialize all radio dropdown labels on page load
        $('.selectisub .dropdown-menu').each(function() {
            updateRadioDropdownLabel($(this));
        });

        // Set current month label
        const currentMonthText = $('#monthDropdown input[name="selected_month"]:checked').parent().text().trim();
        $('#monthDropdown .label').text(currentMonthText);

        // Initial load
        loadAttendance();
    });

</script>

@endpush