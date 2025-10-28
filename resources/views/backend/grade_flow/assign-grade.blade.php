@extends('backend.master')

@section('title')

    {{ @$data['title'] }}

@endsection

@section('content')
    <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">
           
            
            <div class="ds-breadcrumb">
                <h1>Assign Grades</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li>Assign Grades </li>
                </ul>
            </div>

           
            
            <div class="ds-pr-body">
                
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Select Criteria </h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                        <form action="{{ route('grade_flow.assign_grade') }}" method="GET" id="marksheed" enctype="multipart/form-data">
                           
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options grp-3 multi-input-grp">
                                    <div class="input-grp">
                                        {{-- <span><img src="{{global_asset('backend/assets/images/parent-panel/semdropdown.svg')}}" /></span> --}}
                                        <select name="select-session">
                                            <option value="">Select Year</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}"
                                                    {{ request('select-session') == $session->id ? 'selected' : '' }}
                                                >{{ $session->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="select-year-status">
                                            <option value="">Select Year Status</option>
                                            @foreach ($yearStatus as $yearstatus)
                                                <option value="{{ $yearstatus->id }}"
                                                    {{ request('select-year-status') == $yearstatus->id ? 'selected' : '' }}
                                                >{{ $yearstatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="select-semester">
                                            <option value="">Select Semester</option>
                                            @foreach ($semesters as $semester)
                                                <option value="{{ $semester->id }}"
                                                    {{ request('select-semester') == $semester->id ? 'selected' : '' }}
                                                >{{ $semester->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="input-grp">
                                        <select name="select-subject">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ request('select-subject') == $subject->id ? 'selected' : '' }}
                                                >{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="select-class">
                                            <option value="">Select class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ request('select-class') == $class->id ? 'selected' : '' }}
                                                >{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="select-exam-type">
                                            <option value="">Select Exam Type</option>
                                            @foreach ($examTypes as $examType)
                                                <option value="{{ $examType->id }}"
                                                    {{ request('select-exam-type') == $examType->id ? 'selected' : '' }}
                                                >{{ $examType->name }}</option>
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

                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2> Grades </h2>
                        </div>


                        <button id="saveChangesBtn" class="cmn-btn" style="display:none;">
                            Save Changes
                        </button>


                    </div>

                    <div class="ds-cmn-tble count-row">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Student Name</th>
                                    <th>Total Marks</th>
                                    
                                    <th>
                                        Marks Achieved 
                                        <img src="{{ global_asset('backend/assets/images/new_images/Vector.png') }}" 
                                            alt="Edit" 
                                            class="edit-icon" 
                                            style="width:15px; height:15px; margin-left:5px; cursor:pointer;">
                                    </th>

                                    <th>Grade</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                    <tr data-id="{{ $result->id }}" >
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result->student->full_name }}</td>
                                        <td>{{ $result->total_marks }}</td>
                                        <td class="marks-cell">
                                            <span class="marks-text">{{ $result->marks_achieved }}</span>
                                            <input type="number" class="marks-input form-control" 
                                                value="{{ $result->marks_achieved }}" 
                                                style="display:none; width:80px;">
                                        </td>
                                        <td>{{ $result->grade_name }}</td>
                                        
                                    </tr>
                                @endforeach
                                
                                
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="tablepagination">
                       <div class="tbl-pagination-inr">
                            <ul>
                                <!-- Previous Page -->
                                <li>
                                    <a href="{{ $results->previousPageUrl() }}">
                                        <img src="{{ global_asset('backend/assets/images/new_images/arrow-left.svg') }}" alt="Icon">
                                    </a>
                                </li>

                                <!-- Current Page -->
                                @foreach(range(1, $results->lastPage()) as $page)
                                    <li class="{{ $results->currentPage() == $page ? 'active' : '' }}">
                                        <a href="{{ $results->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page -->
                                <li>
                                    <a href="{{ $results->nextPageUrl() }}">
                                        <img src="{{ global_asset('backend/assets/images/new_images/arrow-right.svg') }}" alt="Icon">
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="pages-select">
                            <form method="GET" action="{{ url()->current() }}">
                                @foreach(request()->except(['per_page', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <div class="formfield">
                                    <label>Per page</label>
                                    <select name="per_page" onchange="this.form.submit()">
                                        <option value="1" {{ request('per_page') == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ request('per_page') == 2 ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ request('per_page') == 3 ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ request('per_page') == 4 ? 'selected' : '' }}>4</option>
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="6" {{ request('per_page') == 6 ? 'selected' : '' }}>6</option>
                                        <option value="7" {{ request('per_page') == 7 ? 'selected' : '' }}>7</option>
                                        <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                                        <option value="9" {{ request('per_page') == 9 ? 'selected' : '' }}>9</option>
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    </select>
                                </div>
                            </form>
                            <p>of {{ $results->total() }} results</p>
                        </div>
                    </div>
                  
                </div>

                
                  
            </div>
        </div>

    <!-- End Of Dashboard Body -->
@endsection

@push('script')
<script>

$(document).ready(function() {

    console.log("asdsadasdsd");

    $(document).on('click', '.edit-icon', function() {
        console.log("sdsdsd");
        $(this).hide();
        $('#saveChangesBtn').show();

        $('.marks-text').hide();
        $('.marks-input').show();
    });

    
    $(document).on('click', '#saveChangesBtn', function() {
        $(this).hide();
        $('.edit-icon').show();

        // Gather all updated marks
        let updatedData = [];

        $('tr[data-id]').each(function() {
            let id = $(this).data('id');
            let newMarks = $(this).find('.marks-input').val();

            updatedData.push({ id: id, marks_achieved: newMarks });
        });

        console.log(updatedData); // Debugging

        // Send data to backend via AJAX
        $.ajax({
            url: "{{ route('grade_flow.assign_grade') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                results: updatedData
            },
            success: function(response) {
                // alert('Marks updated successfully!');
                location.reload();
            },
            error: function(xhr) {
                alert('Something went wrong!');
                $('#saveChangesBtn').hide();

                $('.marks-text').show();
                $('.marks-input').hide();
                console.log(xhr.responseText);
            }
        });
    });

    
});


</script>

@endpush