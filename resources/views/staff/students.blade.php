@extends('staff.master')
<style>
    .dropdown-menu-subject,
    .dropdown-menu-status {
        display: none;
    }

    .dropdown-menu-subject.show,
    .dropdown-menu-status.show {
        display: block;
    }
</style>

@section('content')
                <div class="dashboard-body dspr-body-outer">
                    <div class="ds-breadcrumb">
                        <h1>My Classes</h1>
                        <ul>
                            <li><a href="{{route('staff.dashboard')}}">Dashboard</a> /</li>
                            <li>My Classes</li>
                        </ul>
                    </div>
                    <div class="ds-pr-body">
                        <div class="table-container">
                            <div class="student-list"><h2>Students List</h2>
                                       <div class="filters">
                                            <div class="studentBtns">
                                                <div class="dropdown-week">
                                                    <button class="subjectbox"  onclick="toggleDropdownSubject()">Select Year Status
                                                        <img src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon">
                                                    </button>
                                                    <ul class="dropdown-menu-subject">
                                                        
                                                        <li class="{{ request('year_status') == 'all' ? 'active-week' : '' }}"
                                                            onclick="applyFilter('year_status', 'all')">
                                                            All
                                                        </li>
                                                        @foreach($yearstatuses as $ys)
                                                            <li class="{{ request('year_status') == $ys->id ? 'active-week' : '' }}" 
                                                                 onclick="applyFilter('year_status', '{{ $ys->id }}')">
                                                                {{ $ys->name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                           <form id="filterForm" method="GET" style="display: none;">
                                                <input type="hidden" name="year_status" id="yearStatusInput" value="">
                                                <input type="hidden" name="subject" id="subjectInput" value="">
                                                <input type="hidden" name="filter" value="true">
                                            </form>
                                            
                                            <div class="studentBtns">
                                                <div class="dropdown-week">
                                                    <button class="subjectbox" onclick="toggleDropdownstatus()">Select Subject <img
                                                        src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon"></button>
                                                    <ul class="dropdown-menu-status">
                                                        <li class="{{ request('subject') == 'all' ? 'active-week' : '' }}"
                                                            onclick="applyFilter('subject', 'all')">
                                                            All
                                                        </li>
                                                        @foreach($subjects as $subject)
                                                            <li class="{{ request('subject') == $subject->id ? 'active-week' : '' }}"
                                                                onclick="applyFilter('subject', '{{ $subject->id }}')">
                                                                {{ $subject->name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                  </div>

                            <div class="responsive-table-wrapper">
                                {{-- <table class="student-table">
                                    <thead>
                                        <tr>
                                        <th>S. No</th>
                                        <th>Year Status</th>
                                        <th>Name</th>
                                        <th>High School</th>
                                        <th>Attendance</th>
                                        <th>Grades</th>
                                        <th>Mobile Number</th>
                                        <th>Email ID</th>
                                        <th>Parent Name</th>
                                        <th>Parent Mobile Number</th>
                                        <th>Current Address</th>
                                        <th>Hebrew Name</th>
                                        <th>Birth Country</th>
                                        <th>D.O.B</th>
                                        <th>Hebrew Birth</th>
                                        </tr>
                                    </thead>
                                   

                                    <tbody>
                                       @foreach($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    @foreach($student->classes as $class)
                                                        {{ $class->yearStatus->name ?? '-' }}
                                                    @endforeach
                                                </td>

                                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>

                                                <td>{{ $student->high_school }}</td>

                                                <td>{{ $student->attendance_percentage }}</td>

                                                <td>—</td>

                                                <td>{{ $student->mobile }}</td>
                                                <td>{{ $student->email }}</td>

                                                <td>{{ $student->parent_full_name }}</td>

                                               <td>{{ $student->parent_mobile_number }}</td>

                                                <td>{{ $student->residance_address }}</td>

                                                <td>{{ $student->hebrew_first_name }} {{ $student->hebrew_last_name }}</td>

                                                <td>{{ $student->place_of_birth }}</td>

                                                <td>{{ $student->dob }}</td>

                                                <td>{{ $student->hebrew_dob }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table> --}}

                                <div id="studentTableContainer">
                                    @include('staff.partials.student_list', ['students' => $students])
                                </div>

                            </div>

                          
                          <div id="paginationContainer">
                                @if($students->hasPages())
                                    <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                                        @include('backend.partials.pagination', [
                                            'paginator' => $students, 
                                            'routeName' => 'staff.students.index',
                                            'queryParams' => request()->except('page')
                                        ])
                                        
                                        <div class="pagination-info" style="text-align: right;">
                                            <p>
                                                {{-- Showing {{ $students->firstItem() ?? 0 }} – {{ $students->lastItem() ?? 0 }}
                                                of {{ $students->total() }} results --}}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                            
                    </div>
                </div>
                    

          


 @endsection

 @push('script')
<script>
    // Toggle dropdown functions
   function toggleDropdownSubject() {
        const dropdown = document.querySelector('.dropdown-menu-subject');
        const otherDropdown = document.querySelector('.dropdown-menu-status');
        
        dropdown.classList.toggle('show');
        otherDropdown.classList.remove('show');
    }

    function toggleDropdownstatus() {
    const dropdown = document.querySelector('.dropdown-menu-status');
    const otherDropdown = document.querySelector('.dropdown-menu-subject');
    
        dropdown.classList.toggle('show');
        otherDropdown.classList.remove('show');
    }

    // Apply filter function
    
    function applyFilter(type, value) {
        let yearStatus = document.getElementById('yearStatusInput').value;
        let subject = document.getElementById('subjectInput').value;

        // Update selected filter
        if (type === 'year_status') yearStatus = value;
        if (type === 'subject') subject = value;

        // Save updated values
        document.getElementById('yearStatusInput').value = yearStatus;
        document.getElementById('subjectInput').value = subject;

        // Update button text immediately
        updateButtonText(type, value);
        
        // Close dropdown
        document.querySelector('.dropdown-menu-subject').classList.remove('show');
        document.querySelector('.dropdown-menu-status').classList.remove('show');

        fetchFilteredResults();
    }

    function updateButtonText(type, value) {
        const buttons = document.querySelectorAll('.subjectbox');
        
        if (type === 'year_status') {
            const button = buttons[0];
            if (value === 'all') {
                button.innerHTML = 'Select Year Status <img src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon">';
            } else {
                const selectedItem = document.querySelector(`[onclick="applyFilter('year_status', '${value}')"]`);
                if (selectedItem) {
                    button.innerHTML = selectedItem.textContent + ' <img src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon">';
                }
            }
        } else if (type === 'subject') {
            const button = buttons[1];
            if (value === 'all') {
                button.innerHTML = 'Select Subject <img src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon">';
            } else {
                const selectedItem = document.querySelector(`[onclick="applyFilter('subject', '${value}')"]`);
                if (selectedItem) {
                    button.innerHTML = selectedItem.textContent + ' <img src="{{global_asset('staff/assets/images/dropdown-arrow.svg')}}" alt="Icon">';
                }
            }
        }
    }


  function fetchFilteredResults(pageUrl = null) {
        const loader = '<div class="loading">Loading...</div>';
        $('#studentTableContainer').html(loader);
        
        let url = pageUrl || "{{ route('staff.students.filter') }}";
        let params = {
            year_status: $('#yearStatusInput').val(),
            subject: $('#subjectInput').val(),
            filter: true
        };

        // Add page parameter if it's a pagination request
        if (pageUrl) {
            const urlParams = new URLSearchParams(new URL(pageUrl).search);
            if (urlParams.has('page')) {
                params.page = urlParams.get('page');
            }
        }

        $.ajax({
            url: url,
            type: 'GET',
            data: params,
            success: function (response) {
                if (response.status) {
                    $('#studentTableContainer').html(response.html);
                    $('#paginationContainer').html(response.paginationHtml || '');
                    
                    // Update results info
                    if (response.from && response.to && response.total) {
                        $('.pagination-info').html(
                            `<p>Showing ${response.from} – ${response.to} of ${response.total} results</p>`
                        );
                    }
                }
            },
            error: function (xhr) {
                $('#studentTableContainer').html('<div class="error">Failed to load data. Please try again.</div>');
                console.error('AJAX Error:', xhr.responseText);
            }
        });
    }

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let pageUrl = $(this).attr('href');
        fetchFilteredResults(pageUrl);
    });

    $(document).on('change', '#perPageSelect', function (e) {
        e.preventDefault();
        fetchFilteredResults();
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.dropdown-week').length) {
            $('.dropdown-menu-subject, .dropdown-menu-status').removeClass('show');
        }
    });

    if (performance.navigation?.type === 1) {
        // Clear any stored filter values
        localStorage.removeItem('studentFilters');
    }
   
</script>

<script>
    // Reset filters on full browser reload
    // if (performance.navigation.type === 1) {
    //     window.location.href = "{{ route('staff.students.index') }}";
    // }
</script>




 @endpush