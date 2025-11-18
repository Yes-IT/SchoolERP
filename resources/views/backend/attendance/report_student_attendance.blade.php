@extends('backend.master')

@section('title')
    {{ @$data['title'] ?? 'Student Attendance Report' }}
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .ds-cmn-tble {
            transition: opacity 0.3s ease;
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
                    <span class="dropdown-label">Attendance By Student</span>
                    <i class="dropdown-arrow"></i>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option active" data-url="{{ route('student-report.index') }}">Attendance By Student</div>
                    <div class="dropdown-option" data-url="{{ route('class-report.index') }}">Attendance By Class</div>
                    <div class="dropdown-option" data-url="{{ route('student-attendance-summary.index') }}">Student Attendance Summary</div>
                    <div class="dropdown-option" data-url="{{ route('excessive.student.index') }}">Excessive Absences by Student</div>
                    <div class="dropdown-option" data-url="{{ route('excessive.class.index') }}">Excessive Absences by Class</div>
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
                                        <label><input type="radio" name="school_year" value="{{ $year->id }}" {{ request('school_year') == $year->id ? 'checked' : '' }}>&nbsp;{{ $year->name }}</label>
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
                                        <label><input type="radio" name="year_status" value="{{ $status->id }}" {{ request('year_status') == $status->id ? 'checked' : '' }}>&nbsp;{{ $status->name }}</label>
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
                                        <label><input type="radio" name="semester" value="{{ $semester->id }}" {{ request('semester') == $semester->id ? 'checked' : '' }}>&nbsp;{{ $semester->name }}</label>
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
                                        <label><input type="radio" name="student_id" value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'checked' : '' }}>&nbsp;{{ $student->first_name }} {{ $student->last_name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-search">Search</button>
                    </form>
                </div>
            </div>

            <div class="ds-cmn-table-wrp tab-wrapper">
                <div class="ds-content-head">
                    <div class="cmn-tab-head">
                        <ul>
                            <li class="tab-bg" style="left: {{ request('tab') == 'summary' ? '363.86px' : '181.141px' }}; top: 0px; width: 182.719px; height: 35px;"></li>
                            <li class="{{ request('tab') != 'summary' ? 'active' : '' }}" data-tab="attendance"><span data-tab="attendance">Attendance</span></li>
                            <li class="{{ request('tab') == 'summary' ? 'active' : '' }}" data-tab="summary"><span data-tab="summary">Summary</span></li>
                        </ul>
                    </div>
                </div>

                <div id="attendance-table-content">
                    <!-- Attendance Table -->
                    <div class="ds-cmn-tble attendance" style="display: {{ request('tab') != 'summary' ? 'block' : 'none' }};">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Class</th>
                                    <th>Date</th>
                                    <th>Comment</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Late Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Table -->
                    <div class="ds-cmn-tble summary" style="display: {{ request('tab') == 'summary' ? 'block' : 'none' }};">
                        <table>
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Excused</th>
                                    <th>Late</th>
                                    <th>Personal</th>
                                    <th>Not Counted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Pagination Section -->
                <div class="tablepagination" id="pagination-links">
                    <!-- Loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')

    <script>
        jQuery(function($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const searchUrl = "{{ route('student-report.search') }}";
            let activeTab = "{{ request('tab', 'attendance') }}";

            // Get current filters from form
            function getFilters() {
                const filters = {};
                $('#attendance-filter-form input[type=radio]:checked').each(function() {
                    if (this.value) filters[this.name] = this.value;
                });
                return filters;
            }

            // Main AJAX loader
            function loadAttendanceData(href = null, overridePayload = null) {
                let payload = overridePayload || getFilters();
                payload.tab = activeTab;
                payload.per_page = payload.per_page || $('select[name="per_page"]').val() || 10;

                if (href) {
                    try {
                        const url = new URL(href);
                        const page = url.searchParams.get('page');
                        if (page) payload.page = page;
                        url.searchParams.forEach((val, key) => {
                            if (key !== 'page' && !payload[key]) payload[key] = val;
                        });
                    } catch (e) {
                        console.warn('Invalid URL:', href);
                    }
                } else {
                    payload.page = payload.page || 1;
                }

                $.ajax({
                    url: searchUrl,
                    method: 'POST',
                    data: payload,
                    dataType: 'json'
                })
                .done(function(resp) {
                    if (activeTab === 'attendance') {
                        $('#attendance-table-content .attendance tbody').html(resp.data);
                        $('#attendance-table-content .attendance').show();
                        $('#attendance-table-content .summary').hide();
                    } else {
                        $('#attendance-table-content .summary tbody').html(resp.data);
                        $('#attendance-table-content .attendance').hide();
                        $('#attendance-table-content .summary').show();
                    }

                    $('#pagination-links').html(resp.pagination);

                    // Re-attach listeners
                    attachPaginationListeners();
                    attachPerPageListener();

                    // Update URL
                    const url = new URL(window.location);
                    Object.keys(payload).forEach(k => {
                        if (payload[k] && payload[k] !== '') {
                            url.searchParams.set(k, payload[k]);
                        } else {
                            url.searchParams.delete(k);
                        }
                    });
                    history.replaceState(null, '', url);
                })
                .fail(function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to load data'));
                })
            }

            // Attach Pagination Listeners
            function attachPaginationListeners() {
                $(document).off('click', '#pagination-links a');
                $(document).on('click', '#pagination-links a', function(e) {
                    e.preventDefault();
                    const href = $(this).attr('href');
                    if (href && href !== '#') {
                        loadAttendanceData(href);
                        $('html, body').animate({ scrollTop: $('.ds-cmn-table-wrp').offset().top - 100 }, 300);
                    }
                });
            }

            // Attach Per-Page Listener
            function attachPerPageListener() {
                const $select = $('select[name="per_page"]');
                $select.off('change.perpage');
                $select.on('change.perpage', function() {
                    const payload = getFilters();
                    payload.per_page = $(this).val();
                    payload.page = 1;
                    payload.tab = activeTab;
                    loadAttendanceData(null, payload);
                });
            }

            // Initial Load
            loadAttendanceData();
            attachPerPageListener();

            // Filter Form Submit
            $('#attendance-filter-form').on('submit', function(e) {
                e.preventDefault();
                loadAttendanceData();
            });

            // Auto Reload on Filter Change
            let timer;
            $('#attendance-filter-form').on('change', 'input[type=radio]', function() {
                clearTimeout(timer);
                timer = setTimeout(() => loadAttendanceData(), 300);
            });

            // Tab Switching
            $('.cmn-tab-head ul li[data-tab]').on('click', function() {
                const tab = $(this).data('tab');
                $('.cmn-tab-head ul li').removeClass('active');
                $(this).addClass('active');

                const bg = $('.tab-bg');
                if (bg.length) {
                    bg.css({
                        left: $(this).position().left + 'px',
                        width: $(this).outerWidth() + 'px'
                    });
                }

                activeTab = tab;
                loadAttendanceData();
            });

            // Dropdown Navigation
            $('.dropdown-option').on('click', function() {
                $('.dropdown-option').removeClass('active');
                $(this).addClass('active');
                const url = $(this).data('url');
                if (url) window.location = url;
            });

            // Fix Tab BG on Load
            $(document).ready(function() {
                const $active = $('.cmn-tab-head ul li.active');
                if ($active.length && $('.tab-bg').length) {
                    $('.tab-bg').css({
                        left: $active.position().left + 'px',
                        width: $active.outerWidth() + 'px'
                    });
                }
            });
        });
    </script>
    
@endpush