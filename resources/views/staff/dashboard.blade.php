@extends('staff.master')

@section('content')

<div class="ds-bdy-content-wrp">

    <div class="dsbdy-filter-wrp">
        <select name="subject_id" id="">
            <option value="">Select Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>

        <select name="room" id="room">
            <option value="">Select Room</option>
            {{-- <option value="first-semester">Room No</option>
            <option value="second-semester">319</option> --}}
            @foreach ($rooms as $room )
                <option value="{{ $room->room_id }}">{{ $room->room_number }}</option>   
            @endforeach
        </select>
    </div>

    <div class="ds-bdy-content">

        <div class="dsbdy-cmn-card w55">
            <div class="dsbdy-student-card">
              <p class="students-dash-text">Students</p>
              <p class="students-54-text">{{ $totalStudent }}</p>
            </div>
        </div>

        <div class="attendance-card">

            <div class="attendance-header">
                <a href="{{ route('staff.report.attendance.index') }}" class="view-report">View Reports</a>
                <h2>Student Attendance Today</h2>
            </div>

            <div class="bar-row">
                <div class="bar-label">
                    <span>{{ $todayAttendance['present'] }} Present</span>
                    <span>{{ $todayAttendance['present_percent'] }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="bar-fill present" style="width: {{ $todayAttendance['present_percent'] }}%;"></div>
                </div>
            </div>

            <div class="bar-row">
                <div class="bar-label">
                    <span>{{ $todayAttendance['absent'] }} Absent</span>
                    <span>{{ $todayAttendance['absent_percent'] }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="bar-fill absent" style="width: {{ $todayAttendance['absent_percent'] }}%;"></div>
                </div>
            </div>

            <div class="bar-row">
                <div class="bar-label">
                    <span>{{ $todayAttendance['late'] }} Late</span>
                    <span>{{ $todayAttendance['late_percent'] }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="bar-fill late" style="width: {{ $todayAttendance['late_percent'] }}%;"></div>
                </div>
            </div>

            <div class="bar-row">
                <div class="bar-label">
                    <span>{{ $todayAttendance['leave'] }} Approved Leaves</span>
                    <span>{{ $todayAttendance['leave_percent'] }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="bar-fill leave" style="width: {{ $todayAttendance['leave_percent'] }}%;"></div>
                </div>
            </div>
            
        </div>

        {{-- <div class="dsbdy-bottom w65">
            <div class="calendar-container">
                <div class="calendar-header">
                <div>
                    <div class="dropdown header-select">
                    <input type="checkbox" id="toggle" hidden>
                    <label for="toggle" class="select-label">
                        24 October
                        <img src="{{ asset('staff/assets/images/chevrondown.svg') }}" alt="">
                    </label>
                    <ul class="options">
                        <li data-value="24">24 October</li>
                        <li data-value="25">25 October</li>
                        <li data-value="26">26 October</li>
                        <li data-value="27">27 October</li>
                    </ul>
                    </div>

                </div>
                <div class="att-right-header">
                    <div class="dropdown-day header-select-day">
                    <input type="checkbox" id="toggle-day" hidden>
                    <label for="toggle-day" class="select-label-day">
                        Day
                        <img src="{{ asset('staff/assets/images/chevrondowngrey.svg') }}" alt="">
                    </label>
                    <ul class="options-day">
                        <li>Monday</li>
                        <li>Tuesday</li>
                        <li>Wednesday</li>
                        <li>Thursday</li>
                        <li>Friday</li>
                        <li>Saturday</li>
                        <li>Sunday</li>
                    </ul>
                    </div>

                    <div>
                    <img src="{{ asset('staff/assets/images/leftarrow.svg') }}" class="arrow-attendance" alt="leftarrow" />
                    <img src="{{ asset('staff/assets/images/rightarrow.svg') }}" class="arrow-attendance" alt="leftarrow" />
                    </div>

                    <button class="viewall">View All</button>
                </div>
                </div>

                <hr class="cander-hr" />

                <div class="calendar-grid">
                    <!-- Time slots -->
                    <div class="time-row">
                        <div class="time-cell">8:00</div>
                        <div class="time-cell">9:00</div>
                        <div class="time-cell">10:00</div>
                        <div class="time-cell">11:00</div>
                        <div class="time-cell">12:00</div>
                        <div class="time-cell">13:00</div>
                        <div class="time-cell">14:00</div>
                        <div class="time-cell">15:00</div>
                        <div class="time-cell">16:00</div>
                        <div class="time-cell">17:00</div>
                    </div>

                     <!-- Events -->

                    <div class="events-blocks">

                        <div class="div1-blocks">
                        <div class="block-yellow">
                            <div class="block-title">Lorem ipsum dolor sit amet, consectetur</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        <div class="block-green">
                            <div class="block-title">Lorem ipsum dolor sit </div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        <div class="block-blue tooltip-wrapper">
                            <div class="block-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, </div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>

                            <div class="custom-tooltip">
                            <div class="tooltip-content">
                                Lorem ipsum dolor sit amet,<br>
                                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                aliqua.
                                <div class="tooltip-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                            </div>
                            <div class="tooltip-arrow"></div>
                            </div>
                        </div>

                        </div>

                        <div class="div2-blocks">

                        <div class="block-pink">
                            <div class="block-title">Lorem ipsum dolor sit amet</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        <div class="block-grey">
                            <div class="block-title">Lorem ipsum dolor</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        </div>

                        <div class="div3-blocks">

                        <div class="block-green2">
                            <div class="block-title">Lorem ipsum</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        <div class="block-blue2">
                            <div class="block-title">Lorem ipsum dolor sit amet, consectetur</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        </div>

                        <div class="div4-blocks">

                        <div class="block-pink2">
                            <div class="block-title">Lorem ipsum dolor sit amet, consectetua.</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        <div class="block-grey2">
                            <div class="block-title">Lorem ipsum dolor sit amet</div>
                            <div class="block-sub">Room no. - 25 <span>|</span> 10:00 - 12:00</div>
                        </div>

                        </div>

                    </div>

                </div>
            </div>
        </div> --}}

<!-- DAY VIEW SECTION -->
<div class="dsbdy-bottom w65">
    <div class="calendar-container">
        <div class="calendar-header">
            <div>
                <div class="dropdown header-select">
                    <input type="checkbox" id="toggle" hidden>
                    <p class="calender-open">
                        <input type="text" 
                               value="{{ date('F d, Y', strtotime($selectedDate)) }}" 
                               id="datepick-dashboard" 
                               class="calenderDate"
                               readonly>
                        <img class="calimage" src="{{ asset('staff/assets/images/cal.svg') }}"/>
                    </p>
                    <ul class="options">
                        @for($i = -2; $i <= 2; $i++)
                            @php
                                $dateOption = date('Y-m-d', strtotime($selectedDate . " {$i} days"));
                            @endphp
                            <li data-value="{{ $dateOption }}">
                                <a href="{{ route('staff.dashboard') }}?date={{ $dateOption }}">
                                    {{ date('F d', strtotime($dateOption)) }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <div class="att-right-header">
                <div class="dropdown-day header-select-day">
                    <input type="checkbox" id="toggle-day" hidden>
                    <label for="toggle-day" class="select-label-day">
                        Day
                        <img src="{{ asset('staff/assets/images/chevrondowngrey.svg') }}" alt="">
                    </label>
                    <ul class="options-day">
                        <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Day </a></li>
                        <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Week </a></li>
                        <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Month</a></li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('staff.dashboard') }}?date={{ date('Y-m-d', strtotime($selectedDate . ' -1 day')) }}">
                        <img src="{{ asset('staff/assets/images/leftarrow.svg') }}" class="arrow-attendance" alt="leftarrow" />
                    </a>
                    <a href="{{ route('staff.dashboard') }}?date={{ date('Y-m-d', strtotime($selectedDate . ' +1 day')) }}">
                        <img src="{{ asset('staff/assets/images/rightarrow.svg') }}" class="arrow-attendance" alt="leftarrow" />
                    </a>
                </div>
                <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => $selectedDate]) }}" class="viewall">View Full </a>
            </div>
        </div>

        <hr class="cander-hr" />

        <div class="calendar-grid">
            <!-- Time slots -->
            <div class="time-row">
                @for($hour = 8; $hour <= 17; $hour++)
                    <div class="time-cell">{{ sprintf('%02d:00', $hour) }}</div>
                @endfor
            </div>

            <!-- Events -->
            <div class="events-blocks">
                @php
                    $classSchedules = $daySchedule['class_schedules'] ?? collect([]);
                    $examSchedules = $daySchedule['exam_schedules'] ?? collect([]);
                    $allSchedules = $classSchedules->merge($examSchedules);
                    
                    // Create events by hour
                    $eventsByHour = [];
                    for($hour = 8; $hour <= 17; $hour++) {
                        $eventsByHour[$hour] = [];
                    }
                    
                    foreach($allSchedules as $event) {
                        $eventStart = strtotime($event->start_time);
                        $eventEnd = strtotime($event->end_time);
                        
                        for($hour = 8; $hour <= 17; $hour++) {
                            $slotStart = strtotime(sprintf('%02d:00:00', $hour));
                            $slotEnd = strtotime(sprintf('%02d:00:00', $hour + 1));
                            
                            if ($eventStart < $slotEnd && $eventEnd > $slotStart) {
                                if (!isset($eventsByHour[$hour]) || count($eventsByHour[$hour]) < 1) {
                                    $eventsByHour[$hour][] = $event;
                                }
                            }
                        }
                    }
                    
                    $classColors = ['block-yellow', 'block-green', 'block-blue', 'block-pink', 'block-grey'];
                    $colorIndex = 0;
                    $colorMap = [];
                @endphp
                
                @for($hour = 8; $hour <= 17; $hour++)
                    @php
                        $slotEvents = $eventsByHour[$hour] ?? [];
                        $hasEvent = !empty($slotEvents);
                        $currentEvent = $hasEvent ? $slotEvents[0] : null;
                        
                        if ($currentEvent) {
                            $eventId = $currentEvent->id ?? null;
                            $eventType = $currentEvent->type ?? 'class';
                            
                            if ($eventType == 'class') {
                                $title = $currentEvent->class_name ?? 'Class';
                                if(isset($currentEvent->subject_name)) {
                                    $title .= ' - ' . $currentEvent->subject_name;
                                }
                                
                                if (!isset($colorMap[$eventId])) {
                                    $colorMap[$eventId] = $classColors[$colorIndex % count($classColors)];
                                    $colorIndex++;
                                }
                                $eventClass = $colorMap[$eventId];
                            } else {
                                $title = $currentEvent->exam_type_name ?? 'Exam';
                                if(isset($currentEvent->subject_name)) {
                                    $title .= ' - ' . $currentEvent->subject_name;
                                }
                                $eventClass = 'block-red';
                            }
                            
                            $hourStart = sprintf('%02d:00', $hour);
                            $hourEnd = sprintf('%02d:00', $hour + 1);
                            $displayStart = max($currentEvent->start_time, $hourStart);
                            $displayEnd = min($currentEvent->end_time, $hourEnd);
                            
                            // Format times
                            $displayStart = date('H:i', strtotime($displayStart));
                            $displayEnd = date('H:i', strtotime($displayEnd));
                        }
                    @endphp
                    
                    <div class="div{{ $hour-7 }}-blocks">
                        @if($hasEvent && $currentEvent)
                            <div class="{{ $eventClass }}">
                                <div class="block-title">{{ $title }}</div>
                                <div class="block-sub">
                                    Room no. - {{ $currentEvent->room_id ?? 'N/A' }} 
                                    <span>|</span> 
                                    {{ $displayStart }}-{{ $displayEnd }}
                                </div>
                            </div>
                        @else
                            <div class="block-grey">
                                <div class="block-title">Free Time</div>
                                <div class="block-sub">No scheduled activities</div>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

        {{-- <div class="classes-schedule-container">

            <div class="classes-schedule-filter">

                <div class="datepicker">
                <div class="datepicker__header">
                    <span>Oct 04- Oct 09 </span>
                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" />
                </div>
                <div class="datepicker-body-wrp">
                    <div class="datepicker__body">
                    Oct 04- Oct 09
                    </div>
                    <div class="datepicker__body">
                    Oct 11- Oct 16
                    </div>
                    <div class="datepicker__body">
                    Oct 18- Oct 23
                    </div>
                    <div class="datepicker__body">
                    Oct 25- Oct 30
                    </div>
                </div>
                </div>

                <div class="studentBtns">
                <div class="dropdown-week">
                    <button class="cmn-btn print-btn" onclick="toggleDropdownWeek()">Week <img
                        src="{{ asset('staff/assets/images/greyarrow.svg') }}" alt="Icon"></button>
                    <ul class="dropdown-menu-grade">
                    <li>Day</li>
                    <li class="active-week">Week</li>
                    <li>Month</li>
                    </ul>
                </div>

                <button><img src="{{ asset('staff/assets/images/leftstudent.svg') }}" /></button>
                <button><img src="{{ asset('staff/assets/images/rightstudent.svg') }}" /></button>

                <button class="viewall">View All</button>
                </div>

            </div>

            <div class="boxtbl-outer">
                <div class="box-table-container">
                <table>
                    <thead>
                    <tr>
                        <th>04 Oct</th>
                        <th>05 Oct</th>
                        <th>06 Oct</th>
                        <th>07 Oct</th>
                        <th>08 Oct</th>
                        <th>09 Oct</th>
                        <th>10 Oct</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Friday -->
                    <tr>
                        <td>
                        <div class="item-blue">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-green">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-blue">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-blue">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-green">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        
                    </tr>

                    <!-- Monday -->
                    <tr>
                        <!-- <th>Monday</th> -->
                        <td>
                        <div class="item-grey">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <!-- repeat the same cell 11 more times -->
                        <td>
                        <div class="item-purple">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-pinkblack">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-grey">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-purple">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>

                        </td>
                        <td> </td>
                        
                    </tr>

                    
                    <tr>
                    
                        <td>
                        <div class="item-yellow">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>
                        <div class="item-pinkblack">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td>

                        </td>
                        <td>
                        <div class="item-green">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td> </td>
                        <td>

                        </td>
                        <td> </td>
                        
                    </tr>

                    
                    <tr>
                        
                        <td></td>
                        <td>
                        <div class="item-blue">
                            <p class="lorem-text">Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="lorem-grey">Room no. - 25</p>
                            <p class="lorem-grey">10:00 - 12:00</p>
                        </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        
                    </tr>

                    
                    <tr>
                    
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    
                    </tr>

                    
                    <tr>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    
                    </tr>

                    
                    </tbody>
                </table>
                </div>
            </div>

        </div> --}}

<!-- WEEK VIEW SECTION -->
<div class="classes-schedule-container">
    <div class="classes-schedule-filter">
        <div class="datepicker">
            <div class="datepicker__header">
                <span>{{ date('M d', strtotime($weekSchedule['week_start'])) }} - {{ date('M d', strtotime($weekSchedule['week_end'])) }}</span>
                <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" />
            </div>
            <div class="datepicker-body-wrp">
                @for($i = -1; $i <= 1; $i++)
                    @php
                        $weekDate = date('Y-m-d', strtotime($selectedDate . " {$i} weeks"));
                        $weekStart = date('Y-m-d', strtotime('monday this week', strtotime($weekDate)));
                        $weekEnd = date('Y-m-d', strtotime('sunday this week', strtotime($weekDate)));
                    @endphp
                    <div class="datepicker__body">
                        <a href="{{ route('staff.dashboard') }}?date={{ $weekStart }}">
                            {{ date('M d', strtotime($weekStart)) }} - {{ date('M d', strtotime($weekEnd)) }}
                        </a>
                    </div>
                @endfor
            </div>
        </div>

       <div class="studentBtns">
            <div class="dropdown-week">
                <button class="cmn-btn print-btn">Week <img src="{{ asset('staff/assets/images/greyarrow.svg') }}" alt="Icon"></button>
                <ul class="dropdown-menu-grade">
                    <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Day </a></li>
                    <li class="active-week"><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Week </a></li>
                    <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Month </a></li>
                </ul>
            </div>

            <a href="{{ route('staff.dashboard') }}?date={{ date('Y-m-d', strtotime($selectedDate . ' -1 week')) }}">
                <button><img src="{{ asset('staff/assets/images/leftstudent.svg') }}" /></button>
            </a>
            <a href="{{ route('staff.dashboard') }}?date={{ date('Y-m-d', strtotime($selectedDate . ' +1 week')) }}">
                <button><img src="{{ asset('staff/assets/images/rightstudent.svg') }}" /></button>
            </a>

            <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'week', 'date' => $selectedDate]) }}" class="viewall">View Full </a>
        </div>
    </div>

    <div class="boxtbl-outer">
        <div class="box-table-container">
            <table>
                <thead>
                    <tr>
                        @php
                            $currentDate = $weekSchedule['week_start'];
                            $weekDates = [];
                            for($i = 0; $i < 7; $i++) {
                                $weekDates[] = $currentDate;
                                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                            }
                        @endphp
                        @foreach($weekDates as $date)
                            <th>{{ date('d M', strtotime($date)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- We'll show up to 6 time slots (rows) -->
                    @for($row = 0; $row < 6; $row++)
                        <tr>
                            @foreach($weekDates as $date)
                                @php
                                    $dailySchedule = $weekSchedule['daily_schedules'][$date] ?? [];
                                    $dailyEvents = $dailySchedule['all_schedules'] ?? collect([]);
                                    $event = $dailyEvents->skip($row)->first() ?? null;
                                    
                                    $colors = ['item-blue', 'item-green', 'item-yellow', 'item-purple', 'item-pinkblack', 'item-grey'];
                                    $colorIndex = $row % count($colors);
                                @endphp
                                <td>
                                    @if($event)
                                        <div class="{{ $colors[$colorIndex] }}">
                                            <p class="lorem-text">
                                                @if($event->type == 'class')
                                                    {{ $event->class_name ?? 'Class' }}
                                                    @if(isset($event->subject_name))
                                                        - {{ $event->subject_name }}
                                                    @endif
                                                @else
                                                    {{ $event->exam_type_name ?? 'Exam' }}: {{ $event->subject_name ?? 'Subject' }}
                                                @endif
                                            </p>
                                            <p class="lorem-grey">Room no. - {{ $event->room_id ?? 'N/A' }}</p>
                                            <p class="lorem-grey">{{ date('H:i', strtotime($event->start_time)) }} - {{ date('H:i', strtotime($event->end_time)) }}</p>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>


        {{-- <div class="classes-schedule-container">

            <div class="classes-schedule-filter">
                <div class="datepicker">
                    <div class="datepicker__header">
                        <span>Octuber 2025 </span>
                        <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" />
                    </div>
                    <div class="datepicker-body-wrp">
                        <div class="datepicker__body">
                        November 2025
                        </div>
                        <div class="datepicker__body">
                        December 2025
                        </div>
                        <div class="datepicker__body">
                        January 2026
                        </div>
                        <div class="datepicker__body">
                        February 2026
                        </div>
                    </div>
                </div>

                <div class="studentBtns">
                    <div class="dropdown-week">
                        <button class="cmn-btn print-btn" onclick="toggleDropdownWeek()">Month <img src="{{ asset('staff') }}/assets/images/greyarrow.svg"
                            alt="Icon"></button>
                        <ul class="dropdown-menu-week">
                        <li>Day</li>
                        <li class="active-week">Week</li>
                        <li>Month</li>
                        </ul>
                    </div>

                    <button><img src="{{ asset('staff/assets/images/leftstudent.svg') }}" /></button>
                    <button><img src="{{ asset('staff/assets/images/rightstudent.svg') }}" /></button>
                </div>
            </div>

            <div class="calendar-wrapper">
                <table class="calendar-table">
                    <thead>
                        <tr>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                        <th>Sun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                        <td class="empty">
                            <div class="date-number">28</div>
                        </td>
                        <td class="empty">
                            <div class="date-number">29</div>
                        </td>
                        <td class="empty">
                            <div class="date-number">30</div>
                        </td>
                        <td class="empty">
                            <div class="date-number">31</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">1</div>
                        </td>
                        <td>
                            <div class="date-number">2</div>
                        </td>
                        <td>
                            <div class="date-number">3</div>
                        </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                        <td>
                            <div class="date-number">4</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event cyan">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="date-number">5</div>
                        </td>
                        <td class="contain-colors">

                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event green">Lorem ipsum dolor</div>
                            <div class="date-number">6</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">7</div>
                        </td>
                        <td>
                            <div class="date-number">8</div>
                        </td>
                        <td>
                            <div class="date-number">9</div>
                        </td>
                        <td>
                            <div class="date-number">10</div>
                        </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr>
                        <td class="contain-colors">
                            <div class="event grey">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">11</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">12</div>
                        </td>
                        <td>
                            <div class="date-number">13</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event green">Lorem ipsum dolor</div>
                            <div class="date-number">14</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">15</div>
                        </td>
                        <td>
                            <div class="date-number">16</div>
                        </td>
                        <td>
                            <div class="date-number">17</div>
                        </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">18</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event cyan">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="date-number">19</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event green">Lorem ipsum dolor</div>
                            <div class="date-number">20</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event grey">Lorem ipsum dolor</div>
                            <div class="event green">Lorem ipsum dolor</div>
                            <div class="date-number">21</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">22</div>
                        </td>
                        <td>
                            <div class="date-number">23</div>
                        </td>
                        <td>
                            <div class="date-number">24</div>
                        </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr>
                        <td>
                            <div class="date-number">25</div>
                        </td>
                        <td>
                            <div class="date-number">26</div>
                        </td>
                        <td class="contain-colors">
                            <div class="event orange">Lorem ipsum dolor</div>
                            <div class="event pink">Lorem ipsum dolor</div>
                            <div class="event blue">Lorem ipsum dolor</div>
                            <div class="date-number">27</div>
                        </td>
                        <td>
                            <div class="date-number">28</div>
                        </td>
                        <td>
                            <div class="date-number">29</div>
                        </td>
                        <td>
                            <div class="date-number">30</div>
                        </td>
                        <td>
                            <div class="date-number">1</div>
                        </td>
                        </tr>
                        <!-- Row 6 -->

                    </tbody>
                </table>
            </div>

        </div> --}}

 <!-- MONTH VIEW SECTION -->
<div class="classes-schedule-container">
    <div class="classes-schedule-filter">
        <div class="datepicker">
            <div class="datepicker__header">
                <span>{{ $monthSchedule['month_name'] }} {{ $monthSchedule['year'] }}</span>
                <img src="{{ asset('staff/assets/images/down-arrow-5.svg') }}" />
            </div>
            <div class="datepicker-body-wrp">
                @for($i = -2; $i <= 2; $i++)
                    @php
                        $monthDate = date('Y-m-d', strtotime($selectedDate . " {$i} months"));
                    @endphp
                    <div class="datepicker__body">
                        <a href="{{ route('staff.dashboard') }}?date={{ $monthDate }}">
                            {{ date('F Y', strtotime($monthDate)) }}
                        </a>
                    </div>
                @endfor
            </div>
        </div>

        <div class="studentBtns">
            <div class="dropdown-week">
                <button class="cmn-btn print-btn">Month <img src="{{ asset('staff/assets/images/greyarrow.svg') }}" alt="Icon"></button>
                <ul class="dropdown-menu-week">
                    <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Day </a></li>
                    <li><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Week </a></li>
                    <li class="active-week"><a href="{{ route('staff.dashboard') }}?date={{ $selectedDate }}">Month </a></li>
                </ul>
            </div>

            <a href="{{ route('staff.dashboard') }}?date={{ date('Y-m-d', strtotime($selectedDate . ' -1 month')) }}">
                <button><img src="{{ asset('staff/assets/images/leftstudent.svg') }}" /></button>
            </a>
            <a href="{{ route('staff.dashboard') }}?date={{ date('Y-m-d', strtotime($selectedDate . ' +1 month')) }}">
                <button><img src="{{ asset('staff/assets/images/rightstudent.svg') }}" /></button>
            </a>
            
            <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => $selectedDate]) }}" class="viewall">View Full </a>
        </div>
    </div>

    <div class="calendar-wrapper">
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                    <th>Sun</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $year = $monthSchedule['year'];
                    $month = $monthSchedule['month'];
                    $firstDayOfMonth = date('N', strtotime("{$year}-{$month}-01"));
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $totalCells = ceil(($daysInMonth + $firstDayOfMonth - 1) / 7) * 7;
                @endphp
                
                @for($cell = 1; $cell <= $totalCells; $cell++)
                    @if(($cell - 1) % 7 == 0)
                        <tr>
                    @endif
                    
                    @php
                        $dayNumber = $cell - $firstDayOfMonth + 1;
                        $isCurrentMonth = $dayNumber >= 1 && $dayNumber <= $daysInMonth;
                        $currentDate = $isCurrentMonth ? date('Y-m-d', strtotime("{$year}-{$month}-{$dayNumber}")) : null;
                        
                        if($isCurrentMonth) {
                            $dailySchedules = $monthSchedule['daily_schedules'][$currentDate] ?? [];
                            $dailyEvents = $dailySchedules['all_schedules'] ?? collect([]);
                            $eventCount = $dailyEvents->count();
                        }
                    @endphp
                    
                    <td class="{{ !$isCurrentMonth ? 'empty' : '' }} {{ $isCurrentMonth && $eventCount > 0 ? 'contain-colors' : '' }}">
                        @if($isCurrentMonth)
                            <div class="date-number">{{ $dayNumber }}</div>
                            
                            @foreach($dailyEvents->take(3) as $index => $event)
                                @php
                                    $eventColors = ['orange', 'green', 'blue', 'pink', 'cyan', 'grey'];
                                    $colorIndex = $index % count($eventColors);
                                    $eventClass = 'event ' . $eventColors[$colorIndex];
                                    
                                    if($event->type == 'class') {
                                        $eventTitle = $event->class_name ?? 'Class';
                                        if(isset($event->subject_name)) {
                                            $eventTitle .= ' - ' . $event->subject_name;
                                        }
                                    } else {
                                        $eventTitle = $event->exam_type_name ?? 'Exam';
                                    }
                                @endphp
                                <div class="{{ $eventClass }}">
                                    <div class="event-title">{{ $eventTitle }}</div>
                                </div>
                            @endforeach
                            
                            @if($eventCount > 3)
                                <div class="event blue">
                                    <div class="event-title">+{{ $eventCount - 3 }} more</div>
                                </div>
                            @endif
                            
                            @if($eventCount == 0)
                                <div class="event grey">
                                    <div class="event-title">No schedules</div>
                                </div>
                            @endif
                        @else
                            <div class="date-number">
                                {{ $dayNumber <= 0 ? 
                                    date('d', strtotime("last day of previous month", strtotime("{$year}-{$month}-01"))) + $dayNumber : 
                                    $dayNumber - $daysInMonth 
                                }}
                            </div>
                        @endif
                    </td>
                    
                    @if($cell % 7 == 0)
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>
</div>       


    </div>

</div>
    
@endsection

@push('script')
    <script>
        $(function() {
    // Initialize datepicker for dashboard
    $('#datepick-dashboard').datepicker({
        dateFormat: 'MM d, yy',
        onSelect: function(dateText) {
            // Parse the selected date
            var selectedDate = new Date(dateText);
            var formattedDate = selectedDate.getFullYear() + '-' + 
                ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + 
                ('0' + selectedDate.getDate()).slice(-2);
            
            // Redirect within dashboard with selected date
            var baseUrl = "{{ route('staff.dashboard') }}";
            var redirectUrl = baseUrl + '?date=' + formattedDate;
            
            window.location.href = redirectUrl;
        },
        beforeShow: function(input, inst) {
            // Close any other open dropdowns
            $('#toggle').prop('checked', false);
        }
    });
    
    // Also make the calendar icon trigger the datepicker
    $('.calimage').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#datepick-dashboard').datepicker('show');
        return false;
    });
    
    // Handle dropdown date clicks
    $('.options li a').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = $(this).attr('href');
        return false;
    });
    
    // Close datepicker when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#datepick-dashboard, .ui-datepicker').length) {
            $('#datepick-dashboard').datepicker('hide');
        }
    });
    
    // Make sure datepicker input is clickable
    $('#datepick-dashboard').on('click', function(e) {
        e.stopPropagation();
        $(this).datepicker('show');
    });
});
    </script>
@endpush
