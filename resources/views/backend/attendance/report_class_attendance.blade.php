@extends('backend.master')

@section('title')
    Attendance By Class
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .ds-cmn-tble { transition: opacity 0.3s ease; }
    .ds-cmn-tble.loading { opacity: 0.5; }
    .cmn-tab-head ul li { cursor: pointer; }
    .cmn-tab-head ul li span { display: block; text-decoration: none; color: inherit; }
    .dropdown-menu label { display: block; padding: 5px 10px; cursor: pointer; }
</style>

<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Attendance</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="dashboard.html">Attendance</a> /</li>
            <li>Attendance By Class</li>
        </ul>

        <div class="dropdown-year" data-selected="Subject Grade Report">
                <div class="dropdown-trigger" aria-expanded="false">
                    <span class="dropdown-label">Attendance By Class</span>
                    <i class="dropdown-arrow"></i>
                </div>
            <div class="dropdown-options">
                <div class="dropdown-option" data-url="{{ route('student-report.index') }}">Attendance By Student</div>
                <div class="dropdown-option active" data-url="{{ route('class-report.index') }}">Attendance By Class</div>
                <div class="dropdown-option" data-url="{{ route('student-attendance-summary.index') }}">Student Attendance Summary</div>
                <div class="dropdown-option" data-url="{{ route('excessive.student.index') }}">Excessive Absences by Student</div>
                <div class="dropdown-option" data-url="{{ route('excessive.class.index') }}">Excessive Absences by Class</div>
            </div>
        </div>
    </div>

    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head"><h2>Filters</h2></div>

            <form id="attendance-filter-form" class="atndnc-filter-form">
                <div class="atndnc-filter-options">
                    <!-- Year -->
                    <div class="dropdown year-dropdown">
                        <button type="button" class="dropdown-toggle" id="toggle-year">
                            <span class="label">Select Year</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <label><input type="radio" name="school_year" value="" {{ !request('school_year') ? 'checked' : '' }}> All Years</label>
                            @foreach($schoolYears as $year)
                                <label><input type="radio" name="school_year" value="{{ $year->id }}" {{ request('school_year') == $year->id ? 'checked' : '' }}>&nbsp;{{ $year->name }}</label>
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
                            <label><input type="radio" name="year_status" value="" {{ !request('year_status') ? 'checked' : '' }}> All</label>
                            @foreach($yearStatuses as $status)
                                <label><input type="radio" name="year_status" value="{{ $status->id }}" {{ request('year_status') == $status->id ? 'checked' : '' }}>&nbsp;{{ $status->name }}</label>
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
                            <label><input type="radio" name="semester" value="" {{ !request('semester') ? 'checked' : '' }}> All</label>
                            @foreach($semesters as $semester)
                                <label><input type="radio" name="semester" value="{{ $semester->id }}" {{ request('semester') == $semester->id ? 'checked' : '' }}>&nbsp;{{ $semester->name }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="atndnc-filter-options">
                    <!-- Class Dropdown (FIXED) -->
                    <div class="dropdown class-dropdown" style="width: 230px;">
                        <button type="button" class="dropdown-toggle" id="toggle-class">
                            <span class="label">Select Class</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <label>
                                <input type="radio" name="class_id" value="" {{ !request('class_id') ? 'checked' : '' }}>
                                All Classes
                            </label>
                            @foreach($classes as $class)
                                <label>
                                    <input type="radio"
                                           name="class_id"
                                           value="{{ $class->id }}"
                                           {{ request('class_id') == $class->id ? 'checked' : '' }}>
                                    {{ $class->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

        <!-- Tabs -->
        <div class="ds-cmn-table-wrp tab-wrapper">
            <div class="ds-content-head">
                <div class="cmn-tab-head">
                    <ul>
                        <li class="tab-bg" style="left: {{ request('tab') == 'summary' ? '363.86px' : '181.141px' }}; width: 182.719px; height: 35px;"></li>
                        <li class="{{ request('tab') != 'summary' ? 'active' : '' }}" data-tab="attendance"><span>Attendance</span></li>
                        <li class="{{ request('tab') == 'summary' ? 'active' : '' }}" data-tab="summary"><span>Summary</span></li>
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
                                <th>Student Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Late Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Summary Table -->
                <div class="ds-cmn-tble summary" style="display: {{ request('tab') == 'summary' ? 'block' : 'none' }};">
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Excused</th>
                                <th>Late</th>
                                <th>Personal</th>
                                <th>Not Counted</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="tablepagination" id="pagination-links"></div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script>

    jQuery(function($) {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        const searchUrl = "{{ route('class-report.search') }}";
        let activeTab = "{{ request('tab', 'attendance') }}";

        function getFilters() {
            const f = {};
            $('#attendance-filter-form input[type=radio]:checked').each(function() {
                if (this.value) f[this.name] = this.value;
            });
            return f;
        }

        function loadData(href = null, payloadOverride = null) {
            let payload = payloadOverride || getFilters();
            payload.tab = activeTab;
            payload.per_page = payload.per_page || 10;

            if (href) {
                try {
                    const url = new URL(href);
                    const page = url.searchParams.get('page');
                    if (page) payload.page = page;
                    url.searchParams.forEach((v, k) => {
                        if (k !== 'page' && !payload[k]) payload[k] = v;
                    });
                } catch (e) { console.warn('Invalid href', href); }
            } else {
                payload.page = payload.page || 1;
            }

            $.post(searchUrl, payload)
                .done(resp => {
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
                    attachPaginationListeners();
                    attachPerPageListener();
                    updateURL(payload);
                })
                .fail(xhr => alert('Error: ' + (xhr.responseJSON?.message || 'Failed')));
        }

        function attachPaginationListeners() {
            $(document).off('click', '#pagination-links a');
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                const href = $(this).attr('href');
                if (href && href !== '#') {
                    loadData(href);
                }
            });
        }

        // Attach Per-Page Listener
        function attachPerPageListener() {
            const $select = $('select[name="per_page"]');
            $select.off('change.perpage');
            $select.on('change.perpage', function () {
                const payload = getFilters();
                payload.per_page = $(this).val();
                payload.page = 1;           // Reset to page 1
                payload.tab = activeTab;
                loadData(null, payload);    // Trigger AJAX
            });
        }

        function updateURL(payload) {
            const url = new URL(location);
            Object.entries(payload).forEach(([k, v]) => {
                if (v) url.searchParams.set(k, v);
                else url.searchParams.delete(k);
            });
            history.replaceState(null, '', url);
        }

        // Initial load
        loadData();
        attachPaginationListeners();
        attachPerPageListener();

        $('#attendance-filter-form').on('submit', e => { e.preventDefault(); loadData(); });

        let timer;
        $('#attendance-filter-form').on('change', 'input[type=radio]', function() {
            clearTimeout(timer);
            timer = setTimeout(() => loadData(), 300);
        });

        $('.cmn-tab-head ul li[data-tab]').on('click', function() {
            const tab = $(this).data('tab');
            $('.cmn-tab-head ul li').removeClass('active');
            $(this).addClass('active');
            const $bg = $('.tab-bg');
            if ($bg.length) {
                $bg.css({ left: $(this).position().left + 'px', width: $(this).outerWidth() + 'px' });
            }
            activeTab = tab;
            loadData();
        });

        $(function() {
            const $active = $('.cmn-tab-head ul li.active');
            if ($active.length && $('.tab-bg').length) {
                $('.tab-bg').css({ left: $active.position().left + 'px', width: $active.outerWidth() + 'px' });
            }
        });

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