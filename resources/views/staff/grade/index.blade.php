@extends('staff.master')

@section('content')

<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Assign Grades</h1>
        <ul>
            <li><a href="dashboard.html">Dashboard</a> /</li>
            <li>Assignments Grades</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>

            <div class="atndnc-filter">
                <form id="assignGradesFilterForm">
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

                    <button type="submit" class="btn-search">Search</button>
                </form>
            </div>
        </div>

        <div class="ds-cmn-table-wrp tab-wrapper grades-table">

            <div class="ds-content-head">
                <div class="cmn-tab-head">
                    <p class="record-heading">Grades</p>
                </div>
            </div>

            <div class="tab-content current-tab active"  id="gradesTableContainer">
                
            </div>

            <div class="tablepagination" id="paginationContainer">
            </div>

        </div>

    </div>
</div>

@endsection

@push('script')

<script>

    $(document).ready(function() {

        // Main function to load grades via AJAX
        const $gradesContainer = $('#gradesTableContainer');
        let currentUrl = null;

        function loadGrades(url = null) {
            
            const baseUrl = url || '{{ route("staff.grade.assign-grades.filter") }}';

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('year_id', $('#year_id').val() || '');
            formData.append('year_status_id', $('#year_status_id').val() || '');
            formData.append('semester_id', $('#semester_id').val() || '');
            formData.append('subject_id', $('#subject_id').val() || '');
            formData.append('class_id', $('#class_id').val() || '');
            formData.append('per_page', $('#perPageSelect').val() || 20);

            // If it's a pagination click, use GET with full URL
            if (url) {
                const pageUrl = new URL(url);
                pageUrl.searchParams.set('per_page', $('#perPageSelect').val() || 20);
                url = pageUrl.toString();

                $.get(url, function(res) {
                    if (res.html) {
                        $gradesContainer.html(res.html);
                    }
                });
            } else {
                // Initial load or filter change → POST
                $.ajax({
                    url: baseUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#gradesTableContainer').html(res.table);
                        $('#paginationContainer').html(res.pagination);
                    },
                    error: function() {
                        $gradesContainer.html('<div class="text-center py-5 text-danger">Failed to load grades.</div>');
                    }
                });
            }
        }


        // Dropdown item selection (delegated - works after AJAX!)
        $(document).on('click', '.dropdown-item', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $item = $(this);
            const $dropdown = $item.closest('.selectisub');
            const label = $item.text().trim();
            const value = $item.data('id');

            // Update label and hidden input
            $dropdown.find('.label').text(label);
            $dropdown.find('input[type="hidden"]').val(value);

            // Close this dropdown
            $dropdown.find('.dropdown-menu').removeClass('show');

            // Auto load grades when any filter changes
            loadGrades();
        });

        // Dropdown toggle (open/close)
        $(document).on('click', '.dropdown-toggle', function(e) {
            e.stopPropagation();
            const $dropdown = $(this).closest('.selectisub');
            const $menu = $dropdown.find('.dropdown-menu');

            // Close all other dropdowns
            $('.dropdown-menu').not($menu).removeClass('show');
            // Toggle current
            $menu.toggleClass('show');
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.selectisub').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // Search button click
        $('#assignGradesFilterForm').on('submit', function(e) {
            e.preventDefault();
            loadGrades();
        });

        // Set default values on page load
        function setDefaultSelections() {
            $('.selectisub').each(function() {
                const $dropdown = $(this);
                const $firstItem = $dropdown.find('.dropdown-item').first();

                if ($firstItem.length > 0) {
                    const label = $firstItem.text().trim();
                    const id = $firstItem.data('id');

                    $dropdown.find('.label').text(label);
                    $dropdown.find('input[type="hidden"]').val(id);
                }
            });
        }

        // Initialize everything
        setDefaultSelections();
        loadGrades(); // Load on page load with defaults

    $(document).on('click', '.save-marks-btn', function() {
        const $btn = $(this);
        const studentId = $btn.data('student-id');
        const $input = $btn.closest('td').find('.marks-input');
        const marks = $input.val().trim();

        // Basic validation
        if (marks === '' || marks < 0 || marks > 100) {
            alert('Please enter valid marks between 0 and 100');
            return;
        }

        // Show spinner, disable button
        $btn.hide();
        $btn.siblings('.saving-spinner').removeClass('d-none');

        // Gather current filter values (needed for saving grade)
        const filters = {
            year_id: $('#year_id').val(),
            year_status_id: $('#year_status_id').val(),
            semester_id: $('#semester_id').val(),
            subject_id: $('#subject_id').val(),
            class_id: $('#class_id').val(),
        };

        // Send AJAX request
        $.ajax({
            url: '{{ route("staff.grade.save-marks") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                student_id: studentId,
                marks_achieved: marks,
                ...filters  // spread all filters
            },
            success: function(response) {
                if (response.success) {
                    // Update grade display
                    $btn.closest('tr').find('.grade-display').text(response.grade);

                    // Optional: add success visual feedback
                    $input.css('border-color', '#28a745');
                    setTimeout(() => $input.css('border-color', ''), 2000);
                } else {
                    alert(response.message || 'Failed to save marks');
                }
            },
            error: function() {
                alert('Error saving marks. Please try again.');
            },
            complete: function() {
                // Hide spinner, show button again
                $btn.siblings('.saving-spinner').addClass('d-none');
                $btn.show();
            }
        });
    });

    // Optional: Allow pressing Enter in input to save
    $(document).on('keypress', '.marks-input', function(e) {
        if (e.which === 13) { // Enter key
            $(this).closest('td').find('.save-marks-btn').click();
        }
    });


    });

</script>
@endpush