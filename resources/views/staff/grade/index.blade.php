@extends('staff.master')

@section('content')

<style>
.save-changes-top-btn {
    display: none;
}

.editing-mode .save-changes-top-btn {
    display: inline-block !important;
}

.editing-mode .marks-display {
    display: none !important;
}

.editing-mode .marks-input {
    display: inline-block !important;
}

.marks-input {
    display: none;
}

.marks-display {
    display: inline-block;
    min-width: 50px;
}

.pencil-header-img {
    cursor: pointer;
    width: 16px;
    height: 16px;
    opacity: 0.7;
}

.pencil-header-img:hover {
    opacity: 1;
}
</style>

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

                <button type="button" class="cmn-btn save-changes-top-btn" id="saveAllMarksBtn"> Save Changes </button>

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

        const $gradesContainer = $('#gradesTableContainer');
        const $paginationContainer = $('#paginationContainer');

        // Main function to load grades via AJAX
        function loadGrades(url = null) {
            let requestUrl = url || '{{ route("staff.grade.assign-grades.filter") }}';

            // If it's a pagination URL, use GET; otherwise POST with filters
            if (url) {
                // Ensure per_page is preserved in pagination URLs
                const pageUrl = new URL(url);
                const currentPerPage = $('#perPageSelect').val() || 20;
                pageUrl.searchParams.set('per_page', currentPerPage);

                $.get(pageUrl.toString(), function(res) {
                    $gradesContainer.html(res.table);
                    $paginationContainer.html(res.pagination);
                }).fail(function() {
                    $gradesContainer.html('<div class="text-center py-5 text-danger">Failed to load grades.</div>');
                });
            } else {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('year_id', $('#year_id').val() || '');
                formData.append('year_status_id', $('#year_status_id').val() || '');
                formData.append('semester_id', $('#semester_id').val() || '');
                formData.append('class_id', $('#class_id').val() || '');
                formData.append('per_page', $('#perPageSelect').val() || 20);

                $.ajax({
                    url: requestUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $gradesContainer.html(res.table);
                        $paginationContainer.html(res.pagination);
                    },
                    error: function() {
                        $gradesContainer.html('<div class="text-center py-5 text-danger">Failed to load grades.</div>');
                    }
                });
            }
        }

        // Dropdown selection (Year, Semester, Class, etc.)
        $(document).on('click', '.dropdown-item', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $item = $(this);
            const $dropdown = $item.closest('.selectisub');
            const label = $item.text().trim();
            const value = $item.data('id');

            $dropdown.find('.label').text(label);
            $dropdown.find('input[type="hidden"]').val(value);
            $dropdown.find('.dropdown-menu').removeClass('show');

            loadGrades(); // Reload on any filter change
        });

        // Toggle dropdown
        $(document).on('click', '.dropdown-toggle', function(e) {
            e.stopPropagation();
            const $dropdown = $(this).closest('.selectisub');
            const $menu = $dropdown.find('.dropdown-menu');
            $('.dropdown-menu').not($menu).removeClass('show');
            $menu.toggleClass('show');
        });

        // Close dropdowns when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.selectisub').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // Form submit (Search button)
        $('#assignGradesFilterForm').on('submit', function(e) {
            e.preventDefault();
            loadGrades();
        });

        // === PAGINATION CLICK HANDLING ===
        $(document).on('click', '#paginationContainer a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            if (url && url !== '#') {
                const pageUrl = new URL(url);
                
                // Preserve all current filter values
                pageUrl.searchParams.set('year_id', $('#year_id').val() || '');
                pageUrl.searchParams.set('year_status_id', $('#year_status_id').val() || '');
                pageUrl.searchParams.set('semester_id', $('#semester_id').val() || '');
                pageUrl.searchParams.set('class_id', $('#class_id').val() || '');
                
                // Also preserve per_page if exists
                const currentPerPage = $('#perPageSelect').val() || 20;
                pageUrl.searchParams.set('per_page', currentPerPage);

                loadGrades(pageUrl.toString());
            }
        });

        // === PER PAGE CHANGE HANDLING ===
        $(document).on('change', '#perPageSelect', function() {
            loadGrades(); // Reload first page with new per_page
        });

        // Set default dropdown selections
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

        // Initialize
        setDefaultSelections();
        loadGrades();

        // === EDITING MODE LOGIC (unchanged, only minor fix for robustness) ===
        let isEditing = false;

        $(document).on('click', '.pencil-header-img', function() {
            const $table = $(this).closest('table');
            const $tbody = $table.find('tbody');

            if (isEditing) {
                $tbody.removeClass('editing-mode');
                $('#saveAllMarksBtn').hide();
                isEditing = false;
            } else {
                $tbody.addClass('editing-mode');
                $('#saveAllMarksBtn').show();
                $table.find('.marks-input:visible').first().focus();
                isEditing = true;
            }
        });

        $(document).on('click', '#saveAllMarksBtn', function() {
            const $btn = $(this);
            const $table = $btn.closest('.tab-wrapper').find('table');
            const changedMarks = [];

            $table.find('tr').each(function() {
                const $row = $(this);
                const $input = $row.find('.marks-input');
                const $display = $row.find('.marks-display');

                if ($input.length === 0) return;

                const studentId = $input.data('student-id');
                const newMarks = $input.val().trim();
                const oldMarks = $display.text().trim().replace('--', '');

                if (newMarks !== '' && !isNaN(newMarks) && newMarks >= 0 && newMarks <= 100 && newMarks !== oldMarks) {
                    changedMarks.push({
                        student_id: studentId,
                        marks_achieved: parseFloat(newMarks)
                    });
                }
            });

            if (changedMarks.length === 0) {
                alert('No valid changes to save.');
                return;
            }

            $btn.prop('disabled', true).text('Saving...');

            const filters = {
                year_id: $('#year_id').val(),
                year_status_id: $('#year_status_id').val(),
                semester_id: $('#semester_id').val(),
                class_id: $('#class_id').val(),
            };

            $.ajax({
                url: '{{ route("staff.grade.save-marks-batch") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    marks: changedMarks,
                    ...filters
                },
                success: function(response) {
                    if (response.success) {
                        alert('All marks saved successfully!');

                        changedMarks.forEach(item => {
                            const studentId = item.student_id;
                            const newMarks = item.marks_achieved;
                            const newGrade = response.grades?.[studentId] || '-';

                            const $row = $table.find(`.marks-input[data-student-id="${studentId}"]`).closest('tr');
                            $row.find('.marks-display').text(newMarks || '--');
                            $row.find('.marks-input').val(newMarks);
                            $row.find('.grade-display').text(newGrade);
                        });

                        $table.find('tbody').removeClass('editing-mode');
                        $('#saveAllMarksBtn').hide();
                        isEditing = false;
                    }
                },
                error: function(xhr) {
                    alert('Error saving marks: ' + (xhr.responseJSON?.message || 'Unknown error'));
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Save Changes');
                }
            });
        });

        // Optional: Enter key to save all
        $(document).on('keypress', '.marks-input', function(e) {
            if (e.which === 13) {
                $('#saveAllMarksBtn').click();
            }
        });

    });
</script>
@endpush