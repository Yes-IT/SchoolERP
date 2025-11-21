@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')

           <div class="ds-breadcrumb">
                <h1>Classes</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="{{route('classes.index')}}">Classes</a> /</li>
                    <li>Classes List</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Filters</h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                        <form  id="class-filter-form">
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options grp-3 multi-input-grp">
                                    <div class="input-grp">
                                        <select id="session_id" name="session_id" >
                                            <option>School Year</option>
                                            @foreach($sessions as $year)
                                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select id="year_status" name="year_status_id" >
                                            <option value="">Year Status</option>
                                            @foreach($yearStatuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select id="semester" name="semester_id" >
                                            <option value="">Semester</option>
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" id="teacher_id" name="teacher_id" value="all">

                            
                                <!-- Search Button -->
                                <button type="submit" class="btn-search">Search</button>
                            </div>
                        </form>
                    </div> 
                </div>

                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Classes List</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                        
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Select Teacher">
                                    <div class="dropdown-trigger">
                                        <span class="dropdown-label">Select Teacher</span>
                                        <i class="dropdown-arrow"></i>
                                    </div>
                                    <div class="dropdown-options">
                                        <div class="dropdown-search">
                                            <input type="text" id="teacher-search" placeholder="Search teachers..." class="form-control">
                                        </div>
                                        <div class="dropdown-option" data-id="all">All Teachers</div>
                                        @foreach($data['teachers'] as $teacher)
                                            <div class="dropdown-option" data-id="{{ $teacher->id }}">
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <a href="{{ route('classes.create') }}" class="cmn-btn btn-sm">
                                    <i class="fa-solid fa-plus"></i> Add Class
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="ds-cmn-tble count-row tbl-5_4k">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>View Details</th>
                                    <th>Class</th>
                                    <th>Abbreviation</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>School Year</th>
                                    <th>Year Status</th>
                                    <th>Semester</th>
                                    <th>Scheduling</th>
                                    <th>Credits</th>
                                    <th>Allowed Absences</th>
                                    <th>Allowed Penalty Amount</th>
                                    <th>Number Latenesses Equal to Absences</th>
                                    <th>Hebrew Attendance</th>
                                    <th>GPA Weight</th>
                                    <th>Report Card</th>
                                    <th>Prec. RC</th>
                                    <th>College Transcript</th>
                                    <th>Transcript Name</th>
                                    <th>Course #</th>
                                    <th>Prec. Transcript</th>
                                    <th>Charter Oak Transcript</th>
                                    <th>CO Year-Long</th>
                                    <th>CO Department</th>
                                    <th>Elective</th>
                                    <th>Composite Average</th>
                                    <th>Comp. Class 1</th>
                                    <th>Comp. Class 2</th>
                                    <th>Comp. Class 1 Weight</th>
                                    <th>Comp. Class 2 Weight</th>
                                    <th>Comment</th>
                                    <th>Atten. % Auto Fail</th>
                                    <th>Atten. % Amount</th>
                                    <th>Atten. % Fail Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                           
                            <tbody id="class-table-body">
                                @include('backend.academic.class.partials.class-rows', ['classes' => $data['classes']])
                            </tbody>

                        </table>
                    </div>

                

                     <div id="class-pagination">
                        @include('backend.academic.class.partials.class-pagination', ['classes' => $data['classes']])
                    </div>
                </div>
                  
            </div>
@endsection


@push('script')

<script>
$(document).ready(function () {

    function initializeTeacherDropdown() {
        $('.dropdown-year .dropdown-trigger').on('click', function() {
            $(this).closest('.dropdown-year').toggleClass('active');
            $('#teacher-search').focus();
        });

        $('#teacher-search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.dropdown-year .dropdown-option').each(function() {
                const text = $(this).text().toLowerCase();
                if (text.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown-year').length) {
                $('.dropdown-year').removeClass('active');
            }
        });
    }

    initializeTeacherDropdown();

    function getFilterValues() {
        const selectedTeacher = $('.dropdown-year .dropdown-option.selected');
        const teacherId = selectedTeacher.length ? selectedTeacher.data('id') : 'all';
        
        console.log('Selected teacher ID:', teacherId); 
        
        const filters = {
            session_id: $("#session_id").val(),
            year_status_id: $("#year_status").val(),
            semester_id: $("#semester").val(),
            teacher_id: teacherId,
            per_page: $("#class-per-page").val() || 10,
            page: 1
        };

        console.log('Current filters:', filters);
        return filters;
    }

    function filterClasses(page = 1) {
        let filters = getFilterValues();
        filters.page = page;

        Object.keys(filters).forEach(key => {
            if (filters[key] === "" || 
                filters[key] === null || 
                filters[key] === undefined || 
                filters[key] === "School Year" || 
                filters[key] === "Year Status" || 
                filters[key] === "Semester") {
                delete filters[key];
            }
        });

        console.log('Sending AJAX with filters:', filters);

        $.ajax({
            url: "{{ route('classes.filter') }}",
            type: "GET",
            data: filters,
            beforeSend: function () {
                $('#class-table-body').html('<tr><td colspan="38" class="text-center">Loading...</td></tr>');
            },
            success: function (response) {
                $("#class-table-body").html(response.html);
                $("#class-pagination").html(response.pagination);
                initializeTeacherDropdown();
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#class-table-body').html('<tr><td colspan="38" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    $(document).on("click", ".dropdown-year .dropdown-option", function (e) {
        e.stopPropagation();
        
        const $this = $(this);
        const teacherId = $this.data('id');
        const teacherName = $this.text();
        
        $(".dropdown-year .dropdown-option").removeClass("selected");
        $this.addClass("selected");
        $(".dropdown-year .dropdown-label").text(teacherName);
        $('.dropdown-year').removeClass('active');
        $("#teacher_id").val(teacherId);
        
        console.log('Teacher selected:', teacherName, 'ID:', teacherId);
        
        filterClasses(1);
    });

    initializeTeacherDropdown();

    $("#class-filter-form").on("submit", function (e) {
        e.preventDefault();
        // console.log('Search button clicked');
        filterClasses(1);
    });
   
    $('#class-per-page').on('change', function () {
        // console.log('Per page changed to:', $(this).val());
        filterClasses(1);
    });

    $(document).on("click", "#class-pagination a", function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        // console.log('Pagination clicked, page:', page);
        filterClasses(page);
    });

});

</script>

@endpush

