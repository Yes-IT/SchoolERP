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
                <li>Monthly Attendance View</li>
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
                            <div class="dropdown class-dropdown">
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
                            <div class="dropdown subject-dropdown" style="width:180px;">
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
                            <div class="dr-input-wrap">
                                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-date">
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

            <div class="ds-cmn-table-wrp" id="attendance-table">
                @include('backend.attendance.partials.monthly_attendance_list', [
                    'data' => ['students' => $data['students']],
                    'daysInMonth' => $daysInMonth,
                    'month' => $month,
                    'year' => $year
                ])
            </div>
            
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Load initial data
            loadAttendanceData();

            // Handle attendance type dropdown page change
            $('.dropdown-options .dropdown-option').on('click', function() {
                const url = $(this).data('url');
                if (url) {
                    window.location.href = url;
                }
            });

            // Form submission
            $('#attendance-filter-form').on('submit', function(e) {
                e.preventDefault();
                loadAttendanceData();
            });

            // Function to load attendance data
            function loadAttendanceData(url = '{{ route("monthly.search") }}') {
                let formData = $('#attendance-filter-form').serialize();
                let perPage = $('select[name="per_page"]').val() || '{{ request("per_page", 10) }}';
                formData += '&per_page=' + perPage;

                if (url.includes('?')) {
                    let queryString = url.split('?')[1];
                    formData += '&' + queryString;
                }

                $.ajax({
                    url: '{{ route("monthly.search") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#attendance-table').html(response.data);
                        attachPaginationListeners();
                        attachPerPageListener();
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                        alert('An error occurred while loading data. Please try again.');
                    }
                });
            }

            // Function to attach click listeners to pagination links
            function attachPaginationListeners() {
                $('.tbl-pagination-inr a').off('click').on('click', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    loadAttendanceData(url);
                });
            }

            // Function to attach change listener to per-page select
            function attachPerPageListener() {
                const perPageSelect = $('select[name="per_page"]');
                if (perPageSelect.length) {
                    perPageSelect.off('change').on('change', function() {
                        loadAttendanceData();
                    });
                }
            }

            // Populate datepicker
            function populateDatepicker() {
                const yearSelect = $('#year-select');
                const monthSelect = $('#month-select');
                const currentYear = new Date().getFullYear();
                const months = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];

                // Populate years
                for (let i = 2020; i <= currentYear + 5; i++) {
                    yearSelect.append(`<option value="${i}">${i}</option>`);
                }
                yearSelect.val(currentYear);

                // Populate months
                months.forEach((month, index) => {
                    monthSelect.append(`<option value="${index + 1}">${month}</option>`);
                });
                monthSelect.val(new Date().getMonth() + 1);

                // Update range display
                $('#range-display').text(`${months[monthSelect.val() - 1]}, ${yearSelect.val()}`);

                // Update display on change
                yearSelect.on('change', updateRangeDisplay);
                monthSelect.on('change', updateRangeDisplay);

                function updateRangeDisplay() {
                    $('#range-display').text(`${months[monthSelect.val() - 1]}, ${yearSelect.val()}`);
                }

                // Apply button
                $('#btn-apply').on('click', function() {
                    $('.datepicker-body-wrp').hide();
                    loadAttendanceData();
                });

                // Cancel button
                $('#btn-cancel').on('click', function() {
                    $('.datepicker-body-wrp').hide();
                });
            }

            // Initialize
            populateDatepicker();
            attachPaginationListeners();
            attachPerPageListener();
        });
    </script>
@endpush