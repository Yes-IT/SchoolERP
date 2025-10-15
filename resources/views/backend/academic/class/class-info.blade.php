@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
                   <div class="ds-breadcrumb">
                        <h1>Classes</h1>
                        <ul>
                            <li><a href="dashboard.html">Dashboard</a> /</li>
                            <li><a href="{{route('classes.index')}}">Classes</a> /</li>

                            <li>Class Info</li>
                        </ul>
                        <button onclick="window.location.href='{{ route('classes.index') }}'" class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                    <div class="ds-pr-body">
                       <div class="atndnc-filter-wrp w-100">
                            <div class="sec-head">
                                <h2>Classes Info</h2>
                            </div>
                            <div class="atndnc-filter student-filter">
                              
                              <a  class="cmn-btn" href="{{route('classes.edit', $class->id)}}"><img src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon">Edit Class</a>
                            </div> 
                        </div>

                        <div class="dspr-bdy-content">
                            <div class="dspr-bdy-content-sec border-0">
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <table>
                                        <tbody>
                                          <tr>
                                            <td>ID</td>
                                            <td>{{ $class->identification_number}}</td>
                                          </tr>
                                          <tr>
                                            <td>Class Name</td>
                                            <td>{{$class->name}}</td>
                                          </tr>
                                          <tr>
                                            <td>Abbreviation</td>
                                            <td>{{$class->abbreviation}}</td>
                                          </tr>
                                          <tr>
                                            <td>Subject</td>
                                            <td>{{ $class->subject->name ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Teacher</td>
                                            <td>{{ $class->teacher->full_name ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>School Year</td>
                                            <td>{{ $class->schoolYear->name ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Year Status</td>
                                            <td>{{ $class->yearStatus->name ?? 'N/A' }}</td>
                                          </tr>
                                          <tr>
                                            <td>Semester</td>
                                            <td>{{ $class->semester->name ?? 'N/A' }}</td>
                                          </tr>
                                          
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                            <div class="dspr-bdy-content-sec">
                                <h2>Class times and Location</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                     <table style="width:100%; border-collapse:collapse; font-family:sans-serif; font-size:14px;">
                                        <thead>
                                            <tr style="background-color:#f9f9f9; text-align:left;">
                                                <th>Day</th>
                                                <th>Period</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Room</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td>Sunday</td>
                                                <td>2</td>
                                                <td>09:10 AM</td>
                                                <td>--</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Monday</td>
                                                <td>2</td>
                                                <td>11:10 AM</td>
                                                <td>--</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Tuesday</td>
                                                <td>2</td>
                                                <td>10:10 AM</td>
                                                <td>--</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Wednesday</td>
                                                <td>2</td>
                                                <td>09:10 AM</td>
                                                <td>--</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Thursday</td>
                                                <td>2</td>
                                                <td>11:10 AM</td>
                                                <td>--</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Friday</td>
                                                <td>2</td>
                                                <td>11:10 AM</td>
                                                <td>--</td>
                                                <td>X</td>
                                            </tr> --}}
                                            @forelse($class->schedules as $schedule)
                                                <tr>
                                                    <td>{{ $schedule->day }}</td>
                                                    <td>{{ $schedule->period }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                                    <td>
                                                        {{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') : '--' }}
                                                    </td>
                                                    <td>{{ $schedule->room->room_no ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" style="text-align:center;">No schedule found for this class.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                      </table>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec">
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                    <div class="input-grp checkbox">
                                       <input 
                                        type="checkbox" 
                                        disabled 
                                        {{ $class->is_class_scheduling ? 'checked' : '' }}>
                                        <label>Class is for scheduling purpose only (no grades or attendance) </label>
                                    </div>
                                </div>
                            </div>

                            <div class="dspr-bdy-content-sec">
                                <h2>Students in this class</h2>
                                <div class="dsbdy-cmn-table table-full-height pr-pg-tbl-wrp">
                                     <table style="width:100%; border-collapse:collapse; font-family:sans-serif; font-size:14px;">
                                        <thead>
                                            <tr style="background-color:#f9f9f9; text-align:left;">
                                                <th>Student Name</th>
                                                <th>Homeroom Class</th>
                                                <th>Division</th>
                                                <th>Group</th>
                                                <th>ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>1564564</td>
                                            </tr>
                                            <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>1564564</td>
                                            </tr>
                                            <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>1564564</td>
                                            </tr>
                                            <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>1564564</td>
                                            </tr>
                                            <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>1564564</td>
                                            </tr>
                                            <tr>
                                                <td>Lorem ipsum</td>
                                                <td>λ</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>1564564</td>
                                            </tr> --}}

                                            @if($class->students->count() > 0)
                                                @foreach($class->students as $student)
                                                    <tr>
                                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                        <td>{{ $student->homeroom_class ?? '--' }}</td>
                                                        <td>{{ $student->division ?? '--' }}</td>
                                                        <td>{{ $student->group ?? '--' }}</td>
                                                        <td>{{ $student->student_code ?? '--' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" style="text-align: center; padding: 20px;">
                                                        No students assigned to this class yet.
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                           

                        </div>
                    </div>
@endsection