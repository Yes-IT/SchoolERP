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
                <div class="sec-head">
                    <h2>Filters</h2>
                </div>
                <div class="atndnc-filter student-filter">
                    <form>
                        <div class="atndnc-filter-form">
                            <div class="atndnc-filter-options grp-3 multi-input-grp">
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Year</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Year Status</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Semester</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                            </div>
                        
                            <!-- Search Button -->
                            <button type="submit" class="btn-search">Search</button>
                        </div>
                    </form>
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
                            ...filters
                        },
                        success: function(response) {
                            $('#leave-table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                            $('#leave-table-content').removeClass('loading');

                            // Update tab background position
                            updateTabBackground(tab);
                        },
                        error: function() {
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

                // Initial load
                loadLeaveData(currentTab, 1, perPage);

                // Tab click handler
                $('.cmn-tab-head ul li').on('click', function(e) {
                    e.preventDefault();
                    const tab = $(this).data('tab');
                    $('.cmn-tab-head ul li').removeClass('active');
                    $(this).addClass('active');
                    currentTab = tab;
                    loadLeaveData(tab, 1, perPage);
                });

                // Pagination click handler
                $(document).on('click', '#pagination-links .tbl-pagination-inr a', function(e) {
                    e.preventDefault();
                    const url = new URL($(this).attr('href'));
                    const page = url.searchParams.get('page') || 1;
                    const filters = $('#leave-filter-form').serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadLeaveData(currentTab, page, perPage, filters);
                });

                // Per page selection handler
                $(document).on('change', '#pagination-links select[name="per_page"]', function(e) {
                    e.preventDefault();
                    perPage = $(this).val();
                    const filters = $('#leave-filter-form').serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadLeaveData(currentTab, 1, perPage, filters);
                });

                // Filter form submission
                $('#leave-filter-form').on('submit', function(e) {
                    e.preventDefault();
                    const filters = $(this).serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadLeaveData(currentTab, 1, perPage, filters);
                });
            });
        </script>
        
    @endpush

    
@endsection