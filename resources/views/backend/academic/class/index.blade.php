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

    $(document).on("click", ".dropdown-option", function () {
        let teacherId = $(this).data("id");
        console.log('clicked teacherId:', teacherId);

        $(".dropdown-option").removeClass("selected");
        $(this).addClass("selected");

        $(".dropdown-label").text($(this).text());

        let perPage = $('#class-per-page').val() || 10;
        filterClasses(teacherId, perPage, 1);
    });

  

    $(document).on('change', '#class-per-page', function () {
        let perPage = $(this).val();
       
        let teacherId = $('.dropdown-option.selected').data('id') || 'all';
        console.log('per-page changed, teacherId:', teacherId);
        filterClasses(teacherId, perPage, 1);
    });

    $(document).on('click', '#class-pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let teacherId = $('.dropdown-option.selected').data('id') || 'all';
        let perPage = $('#class-per-page').val() || 10;
        let page = new URL(url, window.location.origin).searchParams.get('page') || 1;

        console.log('pagination click:', { teacherId, perPage, page, url });
        filterClasses(teacherId, perPage, page);
    });

    function filterClasses(teacherId, perPage, page) {
        $.ajax({
            url: "{{ route('classes.filter') }}",
            type: "GET",
            data: {
                teacher_id: teacherId,  
                per_page: perPage,
                page: page
            },
            beforeSend: function () {
                $('#class-table-body').html('<tr><td colspan="38" class="text-center">Loading...</td></tr>');
            },
            success: function (response) {
                console.log('filter success', response);
                $("#class-table-body").html(response.html);
                $("#class-pagination").html(response.pagination);

                $('.dropdown-option').removeClass('selected');
                $(`.dropdown-option[data-id="${teacherId}"]`).addClass('selected');
            },
            error: function (xhr) {
                console.error("Error fetching class data", xhr);
                $('#class-table-body').html('<tr><td colspan="38" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }
  });
</script>

@endpush

