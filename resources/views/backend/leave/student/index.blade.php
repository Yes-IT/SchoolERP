@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

    <style>
        .ds-cmn-tble {
            transition: opacity 0.3s ease;
        }
        .ds-cmn-tble.loading {
            opacity: 0.5;
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
            <h1>Leaves</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="dashboard.html">Leaves</a> /</li>
                <li>Student Leaves</li>
            </ul>
        </div>
        <div class="ds-pr-body">
            <div class="atndnc-filter-wrp w-100">
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Filters</h2>
                    </div>

                    <div class="atndnc-filter">
                        <form class="atndnc-filter-form">

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
                                <div class="dropdown subject-dropdown">
                                    <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-subject">
                                        <span class="label">Select Subject</span>
                                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" role="menu" aria-labelledby="toggle-subject">
                                        <label><input type="radio" name="subject_id" value=""> All Subjects</label>
                                        @foreach($subjects as $subject)
                                            <label><input type="radio" name="subject_id" value="{{ $subject->id }}">&nbsp;{{ $subject->name }}</label>
                                        @endforeach
                                    </div>
                                </div>                            

                                <!-- Date Input -->
                                <div>
                                    <input type="date" class="" id="date" name="date"> <!-- Added name="dates" -->
                                </div>
                                
                            </div>

                            <!-- Search Button -->
                            <div class="atndnc-filter-actions">
                                <button type="submit" class="btn-search">Search</button>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>

            <div class="ds-cmn-table-wrp tab-wrapper">
                <div class="ds-content-head">
                    <div class="cmn-tab-head">
                        <ul>
                            <li class="tab-bg" style="left: {{ request('tab') == 'extended' ? '363.86px' : '181.141px' }}; top: 0px; width: 182.719px; height: 35px;"></li>
                            <li class="{{ request('tab') != 'extended' ? 'active' : '' }}" data-tab="applied"><span data-tab="applied">Applied Leaves</span></li>
                            <li class="{{ request('tab') == 'extended' ? 'active' : '' }}" data-tab="extended"><span data-tab="extended">Extended Leaves</span></li>
                        </ul>
                    </div>
                </div>

                <div id="leave-table-content">
                    <!-- Table content will be loaded here via AJAX -->
                </div>

                <!-- Pagination Section -->
                <div class="tablepagination" id="pagination-links">
                    <!-- Pagination links will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                let currentTab = '{{ request('tab', 'applied') }}';
                let perPage = '{{ request('per_page', 2) }}';

                // Function to load leave data
                function loadLeaveData(tab, page = 1, perPage = 2, filters = {}) {
                    $('#leave-table-content').addClass('loading');
                    $.ajax({
                        url: '{{ route('leave.student.data') }}',
                        method: 'GET',
                        data: {
                            tab: tab,
                            page: page,
                            per_page: perPage,
                            school_year: filters.school_year,
                            year_status: filters.year_status,
                            semester: filters.semester,
                            class_id: filters.class_id,
                            subject_id: filters.subject_id,
                            date: filters.date
                        },
                        success: function(response) {
                            $('#leave-table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                            $('#leave-table-content').removeClass('loading');
                            updateTabBackground(tab);
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            alert('Error loading data. Please try again.');
                            $('#leave-table-content').removeClass('loading');
                        }
                    });
                }

                // Function to update tab background position
                function updateTabBackground(tab) {
                    const $tabBg = $('.cmn-tab-head .tab-bg');
                    const $tab = $(`.cmn-tab-head li[data-tab="${tab}"]`);
                    if ($tab.length) {
                        const left = $tab.position().left;
                        const width = $tab.outerWidth();
                        $tabBg.css({ left: left, width: width });
                    }
                }

                // Function to get form filter data
                function getFilterData() {
                    
                    return {
                        school_year: $('input[name="school_year"]:checked').val() || '',
                        year_status: $('input[name="year_status"]:checked').val() || '',
                        semester: $('input[name="semester"]:checked').val() || '',
                        class_id: $('input[name="class_id"]:checked').val() || '',
                        subject_id: $('input[name="subject_id"]:checked').val() || '',
                        date: $('#date').val() || ''
                    };
                }

                // Initial load
                loadLeaveData(currentTab, 1, perPage, getFilterData());

                // Tab click handler
                $('.cmn-tab-head ul li').on('click', function(e) {
                    e.preventDefault();
                    const tab = $(this).data('tab');
                    $('.cmn-tab-head ul li').removeClass('active');
                    $(this).addClass('active');
                    currentTab = tab;
                    loadLeaveData(tab, 1, perPage, getFilterData());
                });

                // Pagination click handler
                $(document).on('click', '#pagination-links .tbl-pagination-inr a', function(e) {
                    e.preventDefault();
                    const url = new URL($(this).attr('href'));
                    const page = url.searchParams.get('page') || 1;
                    loadLeaveData(currentTab, page, perPage, getFilterData());
                });

                // Per page selection handler
                $(document).on('change', '#pagination-links select[name="per_page"]', function(e) {
                    e.preventDefault();
                    perPage = $(this).val();
                    loadLeaveData(currentTab, 1, perPage, getFilterData());
                });

                // Filter form submission
                $('.atndnc-filter-form').on('submit', function(e) {
                    e.preventDefault();
                    loadLeaveData(currentTab, 1, perPage, getFilterData());
                });

                // Dropdown toggle functionality
                $('.dropdown-toggle').on('click', function(e) {
                    e.preventDefault();
                    const $dropdown = $(this).closest('.dropdown');
                    const $menu = $dropdown.find('.dropdown-menu');
                    $('.dropdown-menu').not($menu).removeClass('show');
                    $menu.toggleClass('show');
                });

                // Close dropdown when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $('.dropdown-menu').removeClass('show');
                    }
                });

                // Update dropdown label when selection changes
                $('.dropdown-menu input').on('change', function() {
                    const $dropdown = $(this).closest('.dropdown');
                    const $label = $dropdown.find('.dropdown-toggle .label');
                    const $inputs = $dropdown.find('input:checked');
                    
                    if ($dropdown.hasClass('subject-dropdown')) {
                        // For multi-select subjects
                        if ($inputs.filter('[value="all"]').length > 0) {
                            $label.text('All Subjects');
                        } else {
                            const selected = $inputs.map(function() {
                                return $(this).parent().text().trim();
                            }).get().join(', ');
                            $label.text(selected || 'Select Subject');
                        }
                    } else {
                        // For single-select dropdowns
                        const selectedText = $inputs.parent().text().trim() || 'Select ' + $dropdown.find('.dropdown-toggle').attr('id').replace('toggle-', '');
                        $label.text(selectedText);
                    }
                });

            
            });
        </script>

    @endpush

@endsection