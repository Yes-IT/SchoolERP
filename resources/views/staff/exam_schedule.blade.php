@extends('staff.master')

@section('content')
    <div class="ds-breadcrumb">
        <h1>Exam Schedule</h1>
        <ul>
          <li><a href="dashboard.html">Dashboard</a> /</li>
          <li>Exam Schedule</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter">
                <form>
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options">
                            <!-- Subject Multi‑Select Dropdown -->
                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                <span class="label">Select Year</span>
                                    <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att"/>
                                </button>
                                <div class="dropdown-menu">
                                <label>
                                    <input type="checkbox" value="all" checked /> All Subjects
                                </label>
                                <label>
                                    <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                </label>
                                </div>
                            </div>

                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                <span class="label">Select Year Status</span>
                                <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att"/>

                                </button>
                                <div class="dropdown-menu">
                                <label>
                                    <input type="checkbox" value="all" checked /> All Subjects
                                </label>
                                <label>
                                    <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                </label>
                                </div>
                            </div>
                        
                            <!-- Year/Month Picker Dropdown -->
                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                <span class="label">Select Semester</span>
                                <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att"/>

                                </button>
                                <div class="dropdown-menu">
                                <label>
                                    <input type="checkbox" value="all" checked /> All Subjects
                                </label>
                                <label>
                                    <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                </label>
                                <label>
                                    <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                </label>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div> 
        </div>
        <div class="ds-cmn-table-wrp table-width">

            <div class="exam-type-div">
                <div class="examtype-text-btn">
                    <span class="upcoming">Upcoming Examination</span> 
                    <span class="requested">Requested Examination</span>
                   
                </div>
                    <div class="exam-last-div">
                        <p class="exm-req">+ Add Exam Request</p>
                        <div class="dropdown-container-sub">
                        <p class="allsub" id="dropdownToggle">
                            All Subjects
                            <span><img src="{{asset('staff/assets/images/arrow-white-up.svg')}}" id="dropdownArrow-sub" /></span>
                        </p>
                        <ul class="dropdown-menu-sub" id="dropdownMenu-sub">
                            <li>All Subjects</li>
                            <li>My Subjects</li>
                        </ul>
                        </div>
                        <p class="download-list">Download List</p>
                    </div>
                </div>
                <button class="exam-btn">Exam Type <img src="{{asset('staff/assets/images/uparrow.svg')}}" class="examarrow" /></button>

                <!-- <div class="submit-align"> -->
                <table>
                    <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                        <th>Room No.</th>
                        <th>Marks(Max..)</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>12</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Lorem ipsum dolor sit amet, conse</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Lorem ipsum dolor sit amet, conse</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Lorem ipsum dolor sit amet, conse</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Lorem ipsum dolor sit amet, conse</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>
                            
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>04/02/2025</td>
                            <td>09:30:30</td>
                            <td>10:30:30</td>
                            <td>90</td>
                            <td>11</td>
                            <td>100</td>

                        </tr>
                    </tbody>
                </table>

                <button class="exam-btn">Exam Type <img src="{{asset('staff/assets/images/uparrow.svg')}}" class="examarrow" /></button>
                <!-- </div> -->
            </div>   
        </div>
    </div>   
    
    
    <!-- popup request exam-->
        <div class="request-overlay" style="display: none;">
            <div class="request-modal">
                    <p class="request-heading">Request Modal <span><img src="{{asset('staff/assets/images/reqCross.svg')}}" class="requestClose" /></span></p>

                    <div class="req-type">
                        <p class="req-exam">Exam Type</p>
                        <p>
                            {{-- <input type="text" class="req-box" placeholder="Select Exam Type"/> --}}

                            <select class="req-box exam-type-select">
                                <option value="">Select Exam Type</option>
                                @foreach($examTypes as $examType)
                                    <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                                @endforeach
                            </select>

                            <span>
                                <img src="{{asset('staff/assets/images/dropdown-arrowpopup.svg')}}" class="req-arrow"/>
                            </span>
                        </p>
                    </div>

                    <div class="req-align">
                        <div class="req-type">
                            <p class="req-exam">Subject</p>
                            <p>
                                {{-- <input type="text" class="req-box" placeholder="Select Subject"/> --}}
                                <select class="req-box subject-select">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <span>
                                    <img src="{{asset('staff/assets/images/dropdown-arrowpopup.svg')}}" class="req-arrow"/>
                                </span>
                            </p>
                        </div>

                        <div class="req-type">
                            <p class="req-exam">Exam Date *</p>
                            <p>
                                <input type="text" class="req-box" id="exam-date" placeholder="mm-dd-yyyy" />
                                <span><img src="{{asset('staff/assets/images/reqCal.svg')}}" class="req-arrow"/></span>
                            </p>
                        </div>
                    </div>

                    <div class="req-align-date">
                        <!-- START TIME -->
                        <div class="req-type">
                            <p class="req-exam">Start Time *</p>
                            <div class="time-select-group">
                                <select class="req-box req-time">
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                </select>
                                <select class="req-box req-time">
                                <option>00</option>
                                <option>15</option>
                                <option>30</option>
                                <option>45</option>
                                </select>
                                <select class="req-box req-time">
                                <option>AM</option>
                                <option>PM</option>
                                </select>
                            </div>
                        </div>

                        <!-- END TIME -->
                        <div class="req-type">
                            <p class="req-exam">End Time *</p>
                            <div class="time-select-group">
                                <select class="req-box req-time">
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                </select>
                                <select class="req-box req-time">
                                <option>00</option>
                                <option>15</option>
                                <option>30</option>
                                <option>45</option>
                                </select>
                                <select class="req-box req-time">
                                <option>AM</option>
                                <option>PM</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="req-type">
                        <p class="req-exam">Room *</p>
                        <p>
                            {{-- <input type="text" class="req-box" class="datepick" placeholder="Select Room"/> --}}
                            <select class="req-box room-select" id="room-select">
                                <option value="">Select Room</option>
                                <!-- Rooms will be populated dynamically -->
                            </select>
                            <span>
                                <img src="{{asset('staff/assets/images/dropdown-arrowpopup.svg')}}" class="req-arrow"/>
                            </span>
                        </p>
                    </div>

                    <button class="req-btn">Request</button>
            </div>
        </div>
    <!-- popup request exam-->
@endsection

@push('script')
 <script>
    $(document).ready(function () {
        $("#exam-date").datepicker({
        dateFormat: "mm-dd-yy", // Matches your placeholder
        changeMonth: true,
        changeYear: true
        });
    });
</script>

@endpush