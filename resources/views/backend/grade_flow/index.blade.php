@extends('backend.master')



@section('title')



    {{ @$data['title'] }}



@endsection

<style>

    .upper-row{

        display: flex;

        flex-direction: row;

        position: relative;

        left: -79px;

    }



    .lower-row{

        display: flex

    ;

        flex-direction: row;

        gap: 110px;

        position: relative;

        left: -95px;



    }

    .atndnc-filter-options{

        position: relative;

        left: 330px;

        top: -36px;

        gap: 1px;

    }

    .marks-filter {

        position: absolute;

        top: calc(100% + 4px);

        left: -220px;

        background: var(--white);

        border: 0;

        padding: 10px 0;

        border-radius: 10px;

        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);

        overflow: hidden;

        opacity: 0;

        /* min-width: 100%; */

        visibility: hidden;

        transform: translateY(-10px);

        transition: all 0.2s;

        z-index: 10;

        width: 361px;

        height: 119px;

    }

    .range-filter{

        position: relative;

        left: 10px;

        display: flex;

        flex-direction: column;

    }

    .range-filter label{

    color: var(--primary-clr);

        font-size: 23px;

        font-weight: 700;

    }

    .range-filter input{

    width: 370px;



    }

    /* Base styling for better appearance */

    #marksRange {

        width: 300px;

        -webkit-appearance: none;

        appearance: none;

        height: 8px;

        background: linear-gradient(to right, #660000 100%, #ddd 30%);

        border-radius: 5px;

        outline: none;

        margin-top: 10px;

    }



    /* Hide the default slider track in WebKit browsers */

    #marksRange::-webkit-slider-thumb {

    -webkit-appearance: none;

    appearance: none;

    width: 16px;

    height: 16px;

    border-radius: 50%;

    background: #660000;

    cursor: pointer;

    border: none;

    }



    #marksRange::-moz-range-thumb {

        width: 16px;

        height: 16px;

        border-radius: 50%;

        background: #4caf50;

        cursor: pointer;

        border: none;

    }

    .marks-values {

    display: flex;

    

    font-size: 13px;

    font-weight: 500;

    margin-top: 5px;

    gap: 129px;

    }



    #marksValue {

    color: var(--primary-clr);

    font-weight: 700;

    }







</style>





@section('content')

    <div class="dashboard-body dspr-body-outer">

        <div class="ds-breadcrumb">

            <h1>Grade Reports</h1>

            <ul>

                <li><a href="../dashboard.html">Dashboard</a> /</li>

                <li>Grade Reports</li>

            </ul>

        </div>

 



            <div class="dsbdy-filter-wrp p-0">

    

               

                <select id="gradeFilterId">
                     <option value="{{ route('grade_flow.index') }}" 
                        {{ request()->routeIs('grade_flow.index') ? 'selected' : '' }}>
                        All Grades Records
                    </option>

                    <option class="gradeFilter" value="{{ route('grade_flow.failing_grades') }}" 
                        {{ request()->routeIs('grade_flow.failing_grades') ? 'selected' : '' }}>
                        Students with Failing Grades
                    </option>

                    <option class="gradeFilter" value="{{ route('grade_flow.missing_grades') }}" 
                        {{ request()->routeIs('grade_flow.missing_grades') ? 'selected' : '' }}>
                        Students with Missing Grades
                    </option>
                </select>



            </div>

            

            <div class="ds-pr-body">

                

                <div class="atndnc-filter-wrp w-100">

                    <div class="sec-head">

                        <h2>Select Criteria </h2>

                    </div>

                    <div class="atndnc-filter student-filter">

                        <form action="" method="get" id="marksheed" enctype="multipart/form-data">

                            

                            <div class="atndnc-filter-form">

                                <div class="atndnc-filter-options grp-3 multi-input-grp">

                                <div class="upper-row">

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
                                            <option value="full_year">Full Year</option>
                                        </select>

                                    </div>

                                </div>

                                <div class="lower-row">

                                    <div class="input-grp">

                                        <select name="select-subject" style="min-width: 410px;">

                                            <option value="">Select Subject</option>

                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ request('select-subject') == $subject->id ? 'selected' : '' }}
                                                >{{ $subject->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="input-grp">

                                        <select name="select-class" style="min-width: 390px;">

                                            <option value="">Select class</option>

                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ request('select-class') == $class->id ? 'selected' : '' }}
                                                >{{ $class->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                   

                      

                                </div>

                            

                                <!-- Search Button -->

                                <button type="submit" id="form-submit" class="btn-search">Search</button>

                            </div>

                        </form>

                    </div> 

                </div>



                <div class="ds-cmn-table-wrp">

                    

                    <div class="ds-content-head has-drpdn">

                        <div class="sec-head">

                            <h2>All Grade Records</h2>

                        </div>





                    <div class="ds-cmn-filter-wrp">

                        <div class="dsbdy-filter-wrp p-0">

                            <div class="dropdown-year" data-selected="Marks Filter">

                            <div class="dropdown-trigger" style="display:none;" onclick="toggleDropdown();">

                                <span class="dropdown-label">Marks Filter</span>

                                <i class="dropdown-arrow"></i>

                            </div>

                            <div class="dropdown-options marks-filter"

                                style="width: 392px; margin-left: -259px; height: 120px; border-radius: 8px; border: 1px solid var(--primary-clr);">

                                

                                <div class="range-filter">

                                    <label for="marksRange">Marks</label>

                                    

                                    <input type="range" id="marksRange" min="0" max="100" value="100" />

                                

                                    <div class="marks-values">

                                        <span>0</span>

                                        <span id="marksValue">50</span>

                                        <span>100</span>

                                    </div>

                                </div>

                            </div>

                            </div>

                        </div>

                    </div>







                    </div>



                   <div class="ds-cmn-tble count-row dynamic_container">

                        

                    </div>



                    <!--  pagination start -->

                    <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">

                        <nav aria-label="Page navigation example">

                            <ul class="pagination justify-content-between">

                                {{-- {!! $data['students']->appends(\Request::capture()->except('page'))->links() !!} --}}

                            </ul>

                        </nav>

                    </div>

                    <!--  pagination end -->



                    {{-- <div class="tablepagination">

                        <div class="tbl-pagination-inr">

                            <ul>

                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-left.svg" alt="Icon"></a></li>

                                <li class="active"><a href="#url">1</a></li>

                                <li><a href="#url">2</a></li>

                                <li><a href="#url">3</a></li>

                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-right.svg" alt="Icon"></a></li>

                            </ul>

                        </div>



                        <div class="pages-select">

                            <form>

                                <div class="formfield">

                                    <label>Per page</label>

                                    <select>

                                        <option value="1">1</option>

                                        <option value="2">2</option>

                                        <option value="3">3</option>

                                        <option value="4">4</option>

                                        <option value="5">5</option>

                                        <option value="6">6</option>

                                        <option value="7">7</option>

                                        <option value="8">8</option>

                                        <option value="9">9</option>

                                        <option value="10">10</option>

                                    </select>

                                </div>

                            </form>

                            <p>of 2 results</p>

                        </div>

                    </div> --}}

                    <div>

                       <p><b>KEY: E</b>=Excused;<b> P</b>=Personal; <b> NC</b>=Not Counted; 

                           <b> L</b>=Late, counts as half an absence '=at limit of allowed absences;<b>*</b>=exceeds allowed absences 

                           <b> %</b>=Percentage of absences exceeding allowed absences - over 20% is a failing grade 

                           <b> Points</b>=Points that will be deducted from grade

                        </p>

                    </div>

                </div>



                

                  

            </div>

        </div>



    <!-- End Of Dashboard Body -->

@endsection



@push('script')

<script>
    // Toggle function for dropdown
    function toggleDropdown() {
        // Get the dropdown element
        const dropdown = document.querySelector('.dropdown-options');
        
        // Toggle the 'show' class to toggle visibility
        dropdown.classList.toggle('show');
    }
</script>



<script>

$(document).ready(function() {

    // alert(9);

    $('#gradeFilterId').on('change', function() {

        var url = $(this).val();

        console.log(url);

        

        if (url) {



            window.location.href = url;

        }

    });

});



</script>

<script>
    $(document).ready(function() {

        $("#form-submit").on('click',function(e){

            e.preventDefault();

            let form = $("#marksheed")[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{  route('grade_flow.index') }}",  
                type: "POST",
                data: formData,
                processData: false,  
                contentType: false,
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}" 
                },
                beforeSend: function() {
                    console.log("Sending data...");

                    $('.dynamic_container').html("<p>Loading...</p>");
                },
                success: function(response) {
                    if(response.success)
                    {
                        //if response is for full year then only show the filtering option
                        if(response.full_year)
                        {
                            $('.dropdown-trigger').show();
                        }
                        else{
                            $('.dropdown-trigger').hide();
                        }
                        $('.dynamic_container').html(response.html);
                    }
                    
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function(){

        $("#marksRange").on('input',function(){
            console.log($(this).val());

            
            const selectedMarksFilter =   parseInt($(this).val()) ;
            $(this).css("background", "linear-gradient(to right, #660000 " + selectedMarksFilter + "%, #ddd " + 10 + "%)");
            $(".table-rows").each(function(){
                if(parseInt($(this).find('td').eq(2).text()) > selectedMarksFilter)
                {
                    $(this).hide();
                }
                else{
                    $(this).show();
                }
            });
        });

    });
</script>

@endpush