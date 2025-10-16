@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
        <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">
            
            <div class="ds-breadcrumb">
                <h1>Exam Schedule</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="dashboard.html">Exam Schedule</a> /</li>
                    <li>Exam Schedule</li>
                
                </ul>
            </div>
            <div class="ds-pr-body">

                <div class="ds-cmn-table-wrp tab-wrapper">
                    <div class="ds-content-head">
                        <div class="cmn-tab-head">
                            <ul>
                                <li class="tab-bg" style="left: 181.141px; top: 0px; width: 182.719px; height: 35px;"></li>
                                <li class="active" data-filter=".pending">Pending Exam Schedule </li>
                                <li data-filter=".final" class="">Final Exam Schedule </li>
                            </ul>
                        </div>

                        {{-- <a href="#" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Create New Type</a> --}}

                    </div>

                    <div class="ds-cmn-tble pending count-row active" style="">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Exam Type</th>
                                    <th>Class Name</th>
                                    <th>Room No.</th>
                                    <th>Time Slot</th>
                                    <th>Duration</th>
                                    <th>Teacher</th>
                                    <th>Allotment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td>1</td>
                                    <td>
                                       <h6>Exam Type</h6>
                                       <p>05/02/2025</p> 
                                    </td>
                                    <td>Class Name</td>
                                    <td>
                                        <h6>Requested:</h6>
                                        <p>Room 101</p>
                                    </td>
                                    <td>
                                        <h6>Requested:</h6>
                                        <p>10:00 AM - 12:00 AM</p>
                                    </td>
                                    <td>2 Hours</td>
                                    <td>
                                        Lorem Ipsum
                                    </td>
                                    <td>
                                        <a href="{{route('exam-schedule.checkAvailablity')}}" class="cmn-tbl-btn gap-10"><img src="{{ asset('backend/assets/images/calender-icon.svg') }}" alt="Icon"> Check Availability</a>
                                    </td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn green-bg"><img src="{{ asset('backend/assets/images/qlementine-icons_check-tick-16.svg') }}" alt="Icon">Approved</div>
                                        <div class="upcoming cmn-tbl-btn red-bg"><img src="{{ asset('backend/assets/images/maki_cross.svg') }}" alt="Icon">Reject</div>
                                    </td>
                                </tr> --}}
                               
                                @forelse ($data['exam_request'] as $index => $request)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <h6>{{ $request->examType->name ?? 'N/A' }}</h6>
                                            <p>{{ $request->exam_date?->format('d/m/Y') }}</p>
                                        </td>
                                        <td>{{ $request->class->name ?? 'N/A' }}</td>
                                        <td>
                                            <h6>Status:</h6>
                                            <p>{{ $request->room->room_no ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <h6>Requested:</h6>
                                            <p>{{ $request->start_time?->format('h:i A') }} - {{ $request->end_time?->format('h:i A') }}</p>
                                        </td>
                                        <td>{{ $request->duration }} Hours</td>
                                        <td>{{ $request->teacher->first_name }} {{ $request->teacher->last_name }}</td>
                                        <td>
                                            {{-- <a href="{{ route('exam-schedule.checkAvailablity') }}" class="cmn-tbl-btn gap-10">
                                                <img src="{{ asset('backend/assets/images/calender-icon.svg') }}" alt="Icon">
                                                Check Availability
                                            </a> --}}

                                            <a href="{{ route('exam-schedule.checkAvailablity', $request->id) }}" class="cmn-tbl-btn gap-10">
                                                <img src="{{ asset('backend/assets/images/calender-icon.svg') }}" alt="Icon">
                                                Check Availability
                                            </a>

                                        </td>
                                        <td>
                                            
                                            @if($request->status === \App\Enums\ExamRequestStatus::APPROVED)
                                                <div class="upcoming cmn-tbl-btn green-bg">
                                                    <img src="{{ asset('backend/assets/images/qlementine-icons_check-tick-16.svg') }}" alt="Icon">
                                                    Approved
                                                </div>
                                            @elseif($request->status === \App\Enums\ExamRequestStatus::REJECTED)
                                                <div class="upcoming cmn-tbl-btn red-bg">
                                                    <img src="{{ asset('backend/assets/images/maki_cross.svg') }}" alt="Icon">
                                                    Reject
                                                </div>
                                            @else
                                                <div class="upcoming cmn-tbl-btn yellow-bg">
                                                    Pending
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No exam requests found.</td>
                                    </tr>
                                @endforelse


                                
                            </tbody>
                        </table>
                    </div>

                    <div class="ds-cmn-tble final count-row" style="display: none;">
                        <table>
                            <thead>
                                <tr>
                                   <th>S. No</th>
                                    <th>Exam Type</th>
                                    <th>Class Name</th>
                                    <th>Room No.</th>
                                    <th>Time Slot</th>
                                    <th>Duration</th>
                                    <th>Teacher</th>
                                    
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                       <h6>Exam Type</h6>
                                       <p>05/02/2025</p> 
                                    </td>
                                    <td>Class Name</td>
                                    <td>
                                        <h6>Requested:</h6>
                                        <p>Room 101</p>
                                        <p>Alloted:Room 206, 207</p>
                                    </td>
                                    <td>
                                        <h6>Requested:</h6>
                                        <p>10:00 AM - 12:00 AM</p>
                                        <p>Alloted:10:00 AM - 12:00 AM</p>
                                    </td>
                                    <td>2 Hours</td>
                                    <td>
                                        Lorem Ipsum
                                    </td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn green-bg">Approved (04/01/2025)</div>
                                        {{-- <div class="upcoming cmn-tbl-btn red-bg">Reject</div> --}}
                                    </td>
                                    
                                </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>
                                       <h6>Exam Type</h6>
                                       <p>05/02/2025</p> 
                                    </td>
                                    <td>Class Name</td>
                                    <td>
                                        <h6>Requested:</h6>
                                        <p>Room 101</p>
                                        <p>Alloted:Room 206, 207</p>
                                    </td>
                                    <td>
                                        <h6>Requested:</h6>
                                        <p>10:00 AM - 12:00 AM</p>
                                        <p>Alloted:10:00 AM - 12:00 AM</p>
                                    </td>
                                    <td>2 Hours</td>
                                    <td>
                                        Lorem Ipsum
                                    </td>
                                    <td>
                                        
                                        <div class="upcoming cmn-tbl-btn red-bg">Reject</div>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tablepagination">
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
                                    </select>
                                </div>
                            </form>
                            <p>of 2 results</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    <!-- End Of Dashboard Body -->
    
@endsection