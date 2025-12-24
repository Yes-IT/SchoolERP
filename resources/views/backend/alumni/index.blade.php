@extends('backend.master')

@section('title')
    {{ __('common.School Management System | Alumni') }}
@endsection

<style>
    .count-row table tbody tr td:first-child {
        color: #000 !important;
    }
</style>

@section('content')
    <div class="ds-breadcrumb">
        <h1>Alumni</h1>
        <ul>
            <li><a href="">Dashboard</a> /</li>
            <li><a href="{{ route('alumni_flow.index') }}">Alumni</a> /</li>
            <li>Alumni List</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <!-- Filter Section -->
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter student-filter">
                <form method="GET" action="{{ route('alumni_flow.index') }}" id="alumniFilterForm">
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options grp-3 multi-input-grp">
                            <div class="input-grp">
                                <select name="school_year" id="school_year">
                                    <option value="">Select Year</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-grp">
                                <select name="year_status" id="year_status">
                                    <option value="">Select Year Status</option>
                                    @foreach ($yearStatuses as $ys)
                                        <option value="{{ $ys->id }}">{{ $ys->name ?? $ys->year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-grp">
                                <select name="semester" id="semester">
                                    <option value="">Select Semester</option>
                                    @foreach ($semesters as $sem)
                                        <option value="{{ $sem->id }}">{{ $sem->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alumni List Table -->
        <div class="ds-cmn-table-wrp">
            <div class="ds-content-head has-drpdn">
                <div class="sec-head">
                    <h2>Alumni List</h2>
                </div>
                <div class="ds-cmn-filter-wrp">
                    <div class="dsbdy-filter-wrp p-0">
                        <div class="dropdown-year" data-selected="Select Student">
                            <div class="dropdown-trigger">
                                <span class="dropdown-label">{{ request('student_name') ?: 'Select Alumni' }}</span>
                                <i class="dropdown-arrow"></i>
                            </div>
                            <div class="dropdown-options">
                                <div class="dropdown-option" data-value="">All Alumni</div>
                                @foreach ($allStudents as $student)
                                    <div class="dropdown-option" data-value="{{ $student->name }}">{{ $student->name }}</div>
                                @endforeach
                            </div>
                            <input type="hidden" name="student_name" id="student_name" value="{{ request('student_name') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="ds-cmn-tble tbl-5_4k" id="alumniTableContainer">
                <!-- Table will be loaded here via AJAX -->
            </div>
        </div>
    </div>
@endsection

@push('script')

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggle = document.querySelector('.dropdown-year .dropdown-trigger');
        const dropdownMenu = document.querySelector('.dropdown-year .dropdown-options');
        const dropdownLabel = document.querySelector('.dropdown-year .dropdown-label');
        const hiddenInput = document.querySelector('#student_name');
        const form = document.querySelector('#alumniFilterForm');
        const tableContainer = document.querySelector('#alumniTableContainer');

        // Function to load table data via AJAX
        function loadTableData(url = '{{ route('alumni_flow.index') }}') {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                tableContainer.innerHTML = data.html;
                attachPaginationListeners();
                attachPerPageListener();
            })
            .catch(error => {
                console.error('Error loading table:', error);
            });
        }

        // Function to attach click listeners to pagination links
        function attachPaginationListeners() {
            document.querySelectorAll('.tablepagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    loadTableData(url);
                });
            });
        }

        // Function to attach change listener to per-page select
        function attachPerPageListener() {
            const perPageSelect = document.querySelector('select[name="per_page"]');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    const perPage = this.value;
                    const url = new URL('{{ route('alumni_flow.index') }}');
                    if (hiddenInput.value) {
                        url.searchParams.set('student_name', hiddenInput.value);
                    }
                    if (form.querySelector('#school_year').value) {
                        url.searchParams.set('school_year', form.querySelector('#school_year').value);
                    }
                    if (form.querySelector('#year_status').value) {
                        url.searchParams.set('year_status', form.querySelector('#year_status').value);
                    }
                    if (form.querySelector('#semester').value) {
                        url.searchParams.set('semester', form.querySelector('#semester').value);
                    }
                    url.searchParams.set('per_page', perPage);
                    loadTableData(url.toString());
                });
            }
        }

        // Handle dropdown option selection
        document.querySelectorAll('.dropdown-year .dropdown-option').forEach(item => {
            item.addEventListener('click', function () {
                const selectedValue = this.getAttribute('data-value');
                dropdownLabel.textContent = selectedValue || 'Select Alumni';
                hiddenInput.value = selectedValue;

                // Construct URL with query parameters
                const url = new URL('{{ route('alumni_flow.index') }}');
                if (selectedValue) {
                    url.searchParams.set('student_name', selectedValue);
                }
                if (form.querySelector('#school_year').value) {
                    url.searchParams.set('school_year', form.querySelector('#school_year').value);
                }
                if (form.querySelector('#year_status').value) {
                    url.searchParams.set('year_status', form.querySelector('#year_status').value);
                }
                if (form.querySelector('#semester').value) {
                    url.searchParams.set('semester', form.querySelector('#semester').value);
                }
                const perPageSelect = document.querySelector('select[name="per_page"]');
                if (perPageSelect) {
                    url.searchParams.set('per_page', perPageSelect.value);
                }
                loadTableData(url.toString());
            });
        });

        // Handle form submission for filters
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const url = new URL('{{ route('alumni_flow.index') }}');
            if (hiddenInput.value) {
                url.searchParams.set('student_name', hiddenInput.value);
            }
            if (form.querySelector('#school_year').value) {
                url.searchParams.set('school_year', form.querySelector('#school_year').value);
            }
            if (form.querySelector('#year_status').value) {
                url.searchParams.set('year_status', form.querySelector('#year_status').value);
            }
            if (form.querySelector('#semester').value) {
                url.searchParams.set('semester', form.querySelector('#semester').value);
            }
            const perPageSelect = document.querySelector('select[name="per_page"]');
            if (perPageSelect) {
                url.searchParams.set('per_page', perPageSelect.value);
            }
            loadTableData(url.toString());
        });

        // Initial table load
        loadTableData();
    });

</script>

@endpush