@extends('backend.master')

@section('title')

    {{ @$data['title'] }}

@endsection

@section('content')
    <!-- Dashboard Body Begin -->
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

                    <option value="{{ route('grade_flow.failing_grades') }}" 
                        {{ request()->routeIs('grade_flow.failing_grades') ? 'selected' : '' }}>
                        Students with Failing Grades
                    </option>

                    <option value="{{ route('grade_flow.missing_grades') }}" 
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
                        <form action="" method="post" id="marksheed" enctype="multipart/form-data">
                            @csrf
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options grp-3 multi-input-grp">
                                    <div class="input-grp">
                                        {{-- <span><img src="{{global_asset('backend/assets/images/parent-panel/semdropdown.svg')}}" /></span> --}}
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
                                     <div class="input-grp">
                                        <select>
                                            <option value="select-subject">Select Subject</option>
                                            <option value="2024">2024</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select>
                                            <option value="select-class">Select class</option>
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
                            <h2>All Grade Records</h2>
                        </div>


                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Marks Filter">
                                    <div class="dropdown-trigger">
                                        <span class="dropdown-label">Marks Filter</span>
                                        <i class="dropdown-arrow"></i>
                                    </div>
                                    <div class="dropdown-options marks-filter">
                                        <label for="marksRange">Marks</label>
                                        <input type="range" id="marksRange" min="0" max="100" value="30" />
                                        <div class="marks-values">
                                            <span>0</span>
                                            <span id="marksValue">30</span>
                                            <span>100</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                   <div class="ds-cmn-tble count-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Student Name</th>
                                            <th>Average</th>
                                            <th>Personal Absences</th>
                                            <th>Excused Absences</th>
                                            <th>P* Absences</th>
                                            <th>Reduced</th>
                                            <th>Percentage</th>
                                            <th>Report Card</th>
                                            <th>Transcript</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Child Development</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>11.03%</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                    </tbody>
                                </table>
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

@endpush