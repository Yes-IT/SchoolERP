@extends('backend.master')
@section('title')
    Attendance Management
@endsection

@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Attendance</h1>
            <ul>
                <li><a href="../dashboard">Dashboard</a> /</li>
                <li><a href="./dashboard">Attendance</a> /</li>
                <li>Attendance View</li>
            </ul>

            <div class="dropdown-year" data-selected="Subject Grade Report">
                <div class="dropdown-trigger" aria-expanded="false">
                    <span class="dropdown-label">Daily Attendance</span>
                    <i class="dropdown-arrow"></i>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option {{ request()->routeIs('daily.index') ? 'active' : '' }}"
                         data-url="{{ route('daily.index') }}">Daily Attendance</div>
                    <div class="dropdown-option {{ request()->routeIs('monthly.index') ? 'active' : '' }}"
                         data-url="{{ route('monthly.index') }}">Monthly Attendance</div>
                    <div class="dropdown-option {{ request()->routeIs('total.index') ? 'active' : '' }}"
                         data-url="{{ route('total.index') }}">Semester Total Attendance</div>
                </div>
            </div>
        </div>

        <div class="ds-pr-body">
            <div class="atndnc-filter-wrp w-100">
                <div class="sec-head"><h2>Select Criteria</h2></div>

                <div class="atndnc-filter">
                    <form class="atndnc-filter-form" id="attendance-filter-form">
                        @csrf

                        {{-- ====================== FIRST ROW ====================== --}}
                        <div class="atndnc-filter-options">
                            {{-- Year (radio) --}}
                            <div class="dropdown year-dropdown">
                                <button type="button" class="dropdown-toggle" id="toggle-year">
                                    <span class="label">Select Year</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-year">
                                    <label><input type="radio" name="school_year" value=""> All Years</label>
                                    @foreach($schoolYears as $year)
                                        <label><input type="radio" name="school_year" value="{{ $year->id }}">
                                            &nbsp;{{ $year->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Year Status (radio) --}}
                            <div class="dropdown year-status-dropdown">
                                <button type="button" class="dropdown-toggle" id="toggle-year-status">
                                    <span class="label">Select Year Status</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-year-status">
                                    <label><input type="radio" name="year_status" value=""> All Statuses</label>
                                    @foreach($yearStatuses as $status)
                                        <label><input type="radio" name="year_status" value="{{ $status->id }}">
                                            &nbsp;{{ $status->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Semester (radio) --}}
                            <div class="dropdown semester-dropdown">
                                <button type="button" class="dropdown-toggle" id="toggle-semester">
                                    <span class="label">Select Semester</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-semester">
                                    <label><input type="radio" name="semester" value=""> All Semesters</label>
                                    @foreach($semesters as $semester)
                                        <label><input type="radio" name="semester" value="{{ $semester->id }}">
                                            &nbsp;{{ $semester->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- ====================== SECOND ROW ====================== --}}
                        <div class="atndnc-filter-options">
                            {{-- Class (radio) --}}
                            <div class="dropdown class-dropdown">
                                <button type="button" class="dropdown-toggle" id="toggle-class">
                                    <span class="label">Select Class</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-class">
                                    <label><input type="radio" name="class_id" value=""> All Classes</label>
                                    @foreach($classes as $class)
                                        <label><input type="radio" name="class_id" value="{{ $class->id }}">
                                            &nbsp;{{ $class->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Subject (radio) --}}
                            <div class="dropdown subject-dropdown">
                                <button type="button" class="dropdown-toggle" id="toggle-subject">
                                    <span class="label">Select Subject</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" role="menu" aria-labelledby="toggle-subject">
                                    <label><input type="radio" name="subject_id" value=""> All Subjects</label>
                                    @foreach($subjects as $subject)
                                        <label><input type="radio" name="subject_id" value="{{ $subject->id }}">
                                            &nbsp;{{ $subject->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Single Date Picker --}}
                            <div>
                                <input type="date" id="date" name="date" class="form-control">
                            </div>
                        </div>

                        {{-- Search Button --}}
                        <div class="atndnc-filter-actions">
                            <button type="submit" class="btn-search">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ds-cmn-table-wrp" id="attendance-table">
                {{-- Initial empty table will be filled by AJAX --}}
            </div>
        </div>
    </div>
    <!-- Dashboard Body End -->
@endsection

@push('script')
<script>
    $(document).ready(function () {
        /* --------------------------------------------------------------
           1. INITIAL LOAD
        -------------------------------------------------------------- */
        loadAttendanceData();

        /* --------------------------------------------------------------
           2. ATTENDANCE TYPE DROPDOWN (Daily / Monthly / Total)
        -------------------------------------------------------------- */
        $('.dropdown-options .dropdown-option').on('click', function () {
            const url = $(this).data('url');
            if (url) window.location.href = url;
        });

        /* --------------------------------------------------------------
           3. FILTER FORM SUBMIT
        -------------------------------------------------------------- */
        $('#attendance-filter-form').on('submit', function (e) {
            e.preventDefault();
            loadAttendanceData();               // <-- AJAX call
        });

        /* --------------------------------------------------------------
           4. MAIN AJAX FUNCTION
        -------------------------------------------------------------- */
        function loadAttendanceData(url = '{{ route("daily.search") }}') {
            // Serialize ONLY the checked radios + other inputs
            let formData = $('#attendance-filter-form').serialize();

            // Preserve pagination / per_page from URL (if any)
            if (url.includes('?')) {
                const query = url.split('?')[1];
                formData += (formData ? '&' : '') + query;
            }

            $.ajax({
                url: '{{ route("daily.search") }}',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#attendance-table').html(response.data);
                    attachPaginationListeners();
                    attachPerPageListener();
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr);
                    alert('Failed to load attendance data. Check console.');
                }
            });
        }

        /* --------------------------------------------------------------
           5. PAGINATION LINKS
        -------------------------------------------------------------- */
        function attachPaginationListeners() {
            $('.tbl-pagination-inr a').off('click').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');
                loadAttendanceData(href);
            });
        }

        /* --------------------------------------------------------------
           6. PER-PAGE SELECT (if you have one inside the table)
        -------------------------------------------------------------- */
        function attachPerPageListener() {
            const $perPage = $('select[name="per_page"]');
            if ($perPage.length) {
                $perPage.off('change').on('change', function () {
                    loadAttendanceData();   // reload with new per_page
                });
            }
        }

        /* --------------------------------------------------------------
           7. OPTIONAL: Keep dropdown label in sync with selected radio
        -------------------------------------------------------------- */
        $('.dropdown').each(function () {
            const $dd = $(this);
            const $toggle = $dd.find('.dropdown-toggle .label');
            const $menu   = $dd.find('.dropdown-menu');

            // open/close
            $dd.find('.dropdown-toggle').on('click', function () {
                $menu.toggleClass('show');
            });

            // select radio → update button text
            $menu.find('input[type="radio"]').on('change', function () {
                const text = $(this).parent().text().trim();
                $toggle.text(text || $toggle.data('default') || 'Select');
                $menu.removeClass('show');
            });

            // set default text
            const checked = $menu.find('input[type="radio"]:checked').parent().text().trim();
            if (checked) $toggle.text(checked);
        });

        // close dropdowns when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu.show').removeClass('show');
            }
        });
    });
</script>

@endpush