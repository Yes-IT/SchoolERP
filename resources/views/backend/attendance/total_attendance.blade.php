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
                <li>Attendance View</li>
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
                            <div class="dropdown class-dropdown" style="width: 230px;">
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
                            <div class="dropdown subject-dropdown" style="width:280px;">
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

                        </div>

                        <!-- Search Button -->
                        <div class="atndnc-filter-actions">
                            <button type="submit" class="btn-search">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ds-cmn-table-wrp" id="attendance-table">
                 @include('backend.attendance.partials.total_attendance_list')
            </div>
            
        </div>
    </div>

@endsection


@push('script')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('attendance-filter-form');
        const tableContainer = document.getElementById('attendance-table');

        // Handle form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            searchAttendance();
        });

        // Handle pagination clicks
        document.addEventListener('click', function (e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = e.target.closest('a').getAttribute('href');
                searchAttendance(url);
            }
        });

        // Handle student dropdown change in the partial
        tableContainer.addEventListener('change', function (e) {
            if (e.target.closest('.student-dropdown input[name="student_id"]')) {
                searchAttendance(); // Trigger search when student filter changes
            }
        });

        function searchAttendance(url = '{{ route('total.search') }}') {
            const formData = new FormData(form);
            
            // Append student_id from the partial if selected
            const studentInput = document.querySelector('input[name="student_id"]:checked');
            if (studentInput) {
                formData.append('student_id', studentInput.value);
            }

            // Show loading state
            // tableContainer.innerHTML = '<div>Loading...</div>';

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || 
                        document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update table content
                tableContainer.innerHTML = data.data;
                // Update pagination links
                const paginationContainer = tableContainer.querySelector('.pagination');
                if (paginationContainer) {
                    paginationContainer.outerHTML = data.pagination;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableContainer.innerHTML = '<div>Error loading data. Please try again.</div>';
            });
        }

        // Handle dropdown label updates (for better UX)
        document.querySelectorAll('.dropdown-menu input').forEach(input => {
            input.addEventListener('change', function () {
                const dropdown = this.closest('.dropdown');
                const label = dropdown.querySelector('.dropdown-toggle .label');
                const checkedInputs = dropdown.querySelectorAll('input:checked');
                let selectedText = 'Select Option';

                if (this.type === 'checkbox') {
                    // For subjects (checkboxes)
                    if (checkedInputs.length === 0 || (checkedInputs.length === 1 && checkedInputs[0].value === 'all')) {
                        selectedText = 'All Subjects';
                    } else {
                        const labels = Array.from(checkedInputs)
                            .filter(input => input.value !== 'all')
                            .map(input => input.parentElement.textContent.trim());
                        selectedText = labels.length > 0 ? labels.join(', ') : 'Select Subject';
                    }
                } else {
                    // For radio inputs
                    selectedText = checkedInputs.length > 0 
                        ? checkedInputs[0].parentElement.textContent.trim() 
                        : dropdown.querySelector('.label').textContent;
                }

                label.textContent = selectedText.length > 20 ? selectedText.substring(0, 17) + '...' : selectedText;
            });
        });
    });
</script>

@endpush