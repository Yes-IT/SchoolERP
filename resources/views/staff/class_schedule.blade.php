@extends('staff.master')
<style>
  
</style>
@section('content')
<div class="ds-breadcrumb">
        <h1>My Classes</h1>
        <ul>
          <li><a href="dashboard.html">Dashboard</a> /</li>
          <li>My Classes</li>
        </ul>
</div>
@if($viewType == 'week')   
<div class="ds-pr-body">
    <div class="classes-schedule-container">
        <div class="classes-schedule-filter">
            <div class="datepicker">
                <div class="datepicker__header">
                    <span>{{ date('M d', strtotime($schedules['week_start'])) }} - {{ date('M d', strtotime($schedules['week_end'])) }}</span>
                    <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" />
                </div>
                <div class="datepicker-body-wrp">
                    <!-- Add week options dynamically if needed -->
                    <div class="datepicker__body">
                        {{ date('M d', strtotime($schedules['week_start'] . ' -7 days')) }} - {{ date('M d', strtotime($schedules['week_end'] . ' -7 days')) }}
                    </div>
                    <div class="datepicker__body active">
                        {{ date('M d', strtotime($schedules['week_start'])) }} - {{ date('M d', strtotime($schedules['week_end'])) }}
                    </div>
                    <div class="datepicker__body">
                        {{ date('M d', strtotime($schedules['week_start'] . ' +7 days')) }} - {{ date('M d', strtotime($schedules['week_end'] . ' +7 days')) }}
                    </div>
                </div>
            </div>

            <div class="studentBtns">
                <div class="dropdown-week cmn-dropdn">
                    <button class="cmn-btn print-btn">Week <img src="{{asset('staff/assets/images/greyarrow.svg')}}" alt="Icon"></button>
                    <ul class="dropdown-menu-week dropdown-menu">
                        <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => $selectedDate]) }}">Day</a></li>
                        <li class="active-week"><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'week', 'date' => $selectedDate]) }}">Week</a></li>
                        <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => $selectedDate]) }}">Month</a></li>
                    </ul>
                </div>

                <button onclick="window.location.href='{{ route('staff.my-classes.class-schedule', ['view' => 'week', 'date' => date('Y-m-d', strtotime($selectedDate . ' -7 days'))]) }}'">
                    <img src="{{asset('staff/assets/images/leftstudent.svg')}}" />
                </button>
                <button onclick="window.location.href='{{ route('staff.my-classes.class-schedule', ['view' => 'week', 'date' => date('Y-m-d', strtotime($selectedDate . ' +7 days'))]) }}'">
                    <img src="{{asset('staff/assets/images/rightstudent.svg')}}" />
                </button>
            </div>
        </div>

        {{-- <div class="boxtbl-outer">
            <div class="box-table-container">
                <table>
                    <thead>
                        <tr>
                            @php
                                $currentDate = $schedules['week_start'];
                                $weekDays = [];
                                for($i = 0; $i < 7; $i++) {
                                    $weekDays[] = date('D d M', strtotime($currentDate));
                                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                                }
                            @endphp
                            @foreach($weekDays as $day)
                                <th>{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Group schedules by time slots
                            $timeSlots = [];
                            $currentDate = $schedules['week_start'];
                            for($i = 0; $i < 7; $i++) {
                                $date = date('Y-m-d', strtotime($currentDate));
                                $dailySchedules = $schedules['daily_schedules'][$date];
                                
                                // Combine class schedules, exam schedules, and exam requests
                                $allSchedules = collect($dailySchedules['class_schedules'])
                                    ->merge($dailySchedules['exam_schedules'])
                                    ->merge($dailySchedules['exam_requests']);
                                
                                foreach($allSchedules as $schedule) {
                                    $startHour = date('H', strtotime($schedule->start_time));
                                    if(!in_array($startHour, $timeSlots)) {
                                        $timeSlots[] = $startHour;
                                    }
                                }
                                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                            }
                            sort($timeSlots);
                        @endphp
                        
                        @foreach($timeSlots as $hour)
                        <tr>
                            @php
                                $currentDate = $schedules['week_start'];
                            @endphp
                            @for($i = 0; $i < 7; $i++)
                                @php
                                    $date = date('Y-m-d', strtotime($currentDate));
                                    $dailySchedules = $schedules['daily_schedules'][$date];
                                    
                                    // Filter schedules for this hour and day
                                    $hourStart = sprintf('%02d:00:00', $hour);
                                    $hourEnd = sprintf('%02d:59:59', $hour);
                                    
                                    $schedulesForHour = collect($dailySchedules['class_schedules'])
                                        ->merge($dailySchedules['exam_schedules'])
                                        ->merge($dailySchedules['exam_requests'])
                                        ->filter(function($schedule) use ($hourStart, $hourEnd) {
                                            $scheduleStart = date('H', strtotime($schedule->start_time));
                                            return $scheduleStart == date('H', strtotime($hourStart));
                                        });
                                @endphp
                                <td>
                                    @foreach($schedulesForHour as $schedule)
                                        @php
                                            // Determine schedule type and color
                                            $isExam = isset($schedule->exam_request_id) || isset($schedule->allocated_students);
                                            $isClass = isset($schedule->day);
                                            $isRequest = isset($schedule->teacher_id) && !isset($schedule->exam_request_id);
                                            
                                            if($isExam) {
                                                $colorClass = 'item-red';
                                            } elseif($isClass) {
                                                $colorClass = 'item-green';
                                            } elseif($isRequest) {
                                                $colorClass = 'item-pink';
                                            } elseif($isRequest) {
                                                $colorClass = 'item-grey';
                                            } elseif($isRequest) {
                                                $colorClass = 'item-purple';
                                            }else {
                                                $colorClass = 'item-blue';
                                            }
                                        @endphp
                                        <div class="{{ $colorClass }}">
                                            @if($isExam)
                                                <p class="exam-btn-red">Exam</p>
                                                <div class="red-text">
                                                    <p>{{ $schedule->subject_name ?? 'Subject' }}</p>
                                                    <div>
                                                        <p>Room no. - {{ $schedule->room_id }}</p>
                                                        <p>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="lorem-text">{{ $schedule->subject_name ?? 'Schedule' }}</p>
                                                <p class="lorem-grey">Room no. - {{ $schedule->room_id }}</p>
                                                <p class="lorem-grey">{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($schedulesForHour->isEmpty())
                                        <div class="item-black">
                                            <p>Not Scheduled</p>
                                        </div>
                                    @endif
                                </td>
                                @php
                                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                                @endphp
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
        <div class="boxtbl-outer">
              <div class="box-table-container">
                  <table>
                      <thead>
                          <tr>
                              @php
                                  $currentDate = $schedules['week_start'];
                                  $weekDays = [];
                                  for($i = 0; $i < 7; $i++) {
                                      $weekDays[] = [
                                          'date' => $currentDate,
                                          'display' => date('D d M', strtotime($currentDate)),
                                          'day_name' => date('l', strtotime($currentDate))
                                      ];
                                      $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                                  }
                              @endphp
                              @foreach($weekDays as $dayInfo)
                                  <th>{{ $dayInfo['display'] }}</th>
                              @endforeach
                          </tr>
                      </thead>
                    <tbody>
                        <!-- Class Schedules Row -->
                        <tr>
                            @foreach($weekDays as $dayInfo)
                                @php
                                    $date = $dayInfo['date'];
                                    $dailySchedules = $schedules['daily_schedules'][$date] ?? [];
                                    $classSchedules = $dailySchedules['class_schedules'] ?? collect([]);
                                @endphp
                                <td>
                                    @foreach($classSchedules as $schedule)
                                        <div class="item-blue">
                                            <p class="lorem-text">{{ $schedule->class_name ?? 'Class' }}</p>
                                            <p class="lorem-grey">Room no. - {{ $schedule->room_id }}</p>
                                            <p class="lorem-grey">{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</p>
                                        </div>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                        
                        <!-- Exam Schedules Row -->
                        <tr>
                            @foreach($weekDays as $dayInfo)
                                @php
                                    $date = $dayInfo['date'];
                                    $dailySchedules = $schedules['daily_schedules'][$date] ?? [];
                                    $examSchedules = $dailySchedules['exam_schedules'] ?? collect([]);
                                @endphp
                                <td>
                                    @foreach($examSchedules as $schedule)
                                        <div class="item-red">
                                            <p class="exam-btn-red">Exam</p>
                                            <div class="red-text">
                                                <p>Subject:{{ $schedule->subject_name ?? 'Subject' }}</p>
                                                <div>
                                                    <p>Room no. - {{ $schedule->room_id }}</p>
                                                    <p>{{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>


                    <!-- Time Slots Row -->
                    {{-- <tbody>
                      @php
                          // Group by time slots
                          $timeGroups = [];
                          for($hour = 8; $hour <= 20; $hour++) {
                              $timeGroups[sprintf('%02d:00', $hour)] = [];
                          }
                      @endphp
                      
                      @foreach($timeGroups as $time => $dummy)
                      <tr>
                          <th class="time-header">{{ $time }}</th>
                          @foreach($weekDays as $dayInfo)
                              @php
                                  $date = $dayInfo['date'];
                                  $dailySchedules = $schedules['daily_schedules'][$date] ?? [];
                                  $allSchedules = $dailySchedules['all_schedules'] ?? collect([]);
                                  
                                  // Filter for this time slot
                                  $schedulesForTime = $allSchedules->filter(function($schedule) use ($time) {
                                      $scheduleHour = date('H', strtotime($schedule->start_time));
                                      return $scheduleHour == date('H', strtotime($time));
                                  });
                                  
                                  $hasConflict = $schedulesForTime->count() > 1;
                              @endphp
                              <td>
                                  @if($schedulesForTime->isEmpty())
                                      <div class="item-black">
                                          <p>Not Scheduled</p>
                                      </div>
                                  @else
                                      @foreach($schedulesForTime as $schedule)
                                          @php
                                              $colorClass = $schedule->type == 'class' ? 'item-blue' : 'item-red';
                                              if($hasConflict) {
                                                  $colorClass .= ' conflict-highlight';
                                              }
                                          @endphp
                                          <div class="{{ $colorClass }}">
                                              @if($hasConflict)
                                                  <span class="conflict-badge">⚠️</span>
                                              @endif
                                              
                                              @if($schedule->type == 'class')
                                                  <p class="lorem-text">{{ $schedule->class_name ?? 'Class' }}</p>
                                                  <p class="lorem-grey">Class</p>
                                              @else
                                                  <p class="lorem-text">{{ $schedule->subject_name ?? 'Exam' }}</p>
                                                  <p class="lorem-grey">Exam</p>
                                              @endif
                                              
                                              <p class="lorem-grey">Room: {{ $schedule->room_id }}</p>
                                              <p class="lorem-grey">
                                                  {{ date('H:i', strtotime($schedule->start_time)) }} - 
                                                  {{ date('H:i', strtotime($schedule->end_time)) }}
                                              </p>
                                          </div>
                                      @endforeach
                                  @endif
                              </td>
                          @endforeach
                      </tr>
                      @endforeach
                  </tbody> --}}
                  </table>
              </div>
        </div>

    </div>
</div>    
@endif

@if($viewType == 'date')
{{-- <div class="ds-pr-body">

  <div class="dsbdy-bottom w65">
    <div class="calendar-container">
      <div class="calendar-header">
        <div>
          <div class="dropdown header-select">
            <input type="checkbox" id="toggle" hidden>
            
            <p class="calender-open"><input type="text" value="January 25, 2025"
                                              id="datepick" class="calenderDate"> <img class="calimage"
                                              src="{{{asset('staff/assets/images/cal.svg')}}}" />
            
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
                      Date
                      <img src="{{asset('staff/assets/images/chevrondowngrey.svg')}}" alt="">
                  </label>
                  <ul class="options-day">
                      <li>Day</li>
                      <li>Week</li>
                      <li>Month</li>

                  </ul>
              </div>

              <div>
                  <img src="{{asset('staff/assets/images/leftarrow.svg')}}" class="arrow-attendance" alt="leftarrow" />
                  <img src="{{asset('staff/assets/images/rightarrow.svg')}}" class="arrow-attendance" alt="leftarrow" />
              </div>
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
                  consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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
  </div>
</div> --}}
<div class="ds-pr-body">
    <div class="dsbdy-bottom w65">
        <div class="calendar-container">
            <div class="calendar-header">
                <div>
                    <div class="dropdown header-select">
                        <input type="checkbox" id="toggle" hidden>
                        <p class="calender-open">
                            <input type="text" value="{{ date('F d, Y', strtotime($selectedDate)) }}" id="datepick" class="calenderDate">
                            <img class="calimage" src="{{ asset('staff/assets/images/cal.svg') }}" />
                        </p>
                        <ul class="options">
                            @for($i = -3; $i <= 3; $i++)
                                @php
                                    $dateOption = date('Y-m-d', strtotime($selectedDate . " {$i} days"));
                                @endphp
                                <li data-value="{{ $dateOption }}">
                                    <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => $dateOption]) }}">
                                        {{ date('MM d, yy', strtotime($dateOption)) }}
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
                            Date
                            <img src="{{asset('staff/assets/images/chevrondowngrey.svg')}}" alt="">
                        </label>
                        <ul class="options-day">
                            <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => $selectedDate]) }}">Day</a></li>
                            <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'week', 'date' => $selectedDate]) }}">Week</a></li>
                            <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => $selectedDate]) }}">Month</a></li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => date('Y-m-d', strtotime($selectedDate . ' -1 day'))]) }}">
                            <img src="{{asset('staff/assets/images/leftarrow.svg')}}" class="arrow-attendance" alt="leftarrow" />
                        </a>
                        <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => date('Y-m-d', strtotime($selectedDate . ' +1 day'))]) }}">
                            <img src="{{asset('staff/assets/images/rightarrow.svg')}}" class="arrow-attendance" alt="leftarrow" />
                        </a>
                    </div>
                </div>
            </div>

            <hr class="cander-hr" />

           

        <div class="calendar-grid">
            <!-- Time slots (extended to show 19:00) -->
            <div class="time-row">
                @for($hour = 8; $hour <=17 ; $hour++)  
                    <div class="time-cell">{{ sprintf('%02d:00', $hour) }}</div>
                @endfor
            </div>

            <!-- Events -->
            <div class="events-blocks">
                @php
                    $classSchedules = $schedules['class_schedules'] ?? collect([]);
                    $examSchedules = $schedules['exam_schedules'] ?? collect([]);
                    
                    // Group by hour for positioning
                    $classByHour = [];
                    $examByHour = [];
                    
                    foreach($classSchedules as $schedule) {
                        $hour = (int)date('H', strtotime($schedule->start_time));
                        if($hour >= 8 && $hour <= 20) {  
                            if(!isset($classByHour[$hour])) $classByHour[$hour] = [];
                            $classByHour[$hour][] = $schedule;
                        }
                    }
                    
                    foreach($examSchedules as $exam) {
                        $hour = (int)date('H', strtotime($exam->start_time));
                        if($hour >= 8 && $hour <= 20) { 
                            if(!isset($examByHour[$hour])) $examByHour[$hour] = [];
                            $examByHour[$hour][] = $exam;
                        }
                    }
                @endphp
                
                <!-- We need 13 divs (8:00 to 20:00 = 13 hours) -->
                <!-- Your original HTML has div1-blocks to div13-blocks -->
                @for($hour = 8; $hour <= 20; $hour++)
                    <div class="div{{ $hour-7 }}-blocks">
                        <!-- Classes for this hour -->
                        @if(isset($classByHour[$hour]))
                            @foreach($classByHour[$hour] as $schedule)
                                @php
                                    // Calculate duration in minutes for height
                                    $durationMinutes = (strtotime($schedule->end_time) - strtotime($schedule->start_time)) / 60;
                                    $title = $schedule->class_name ?? 'Class';
                                    if(isset($schedule->subject_name) && $schedule->subject_name) {
                                        $title .= ' - ' . $schedule->subject_name;
                                    }
                                @endphp
                                <div class="block-green" style="height: {{ $durationMinutes }}px;">
                                    <div class="block-title">{{ $title }}</div>
                                    <div class="block-sub">
                                        Room no. - {{ $schedule->room_id }} 
                                        <span>|</span> 
                                        {{ date('H:i', strtotime($schedule->start_time)) }} - {{ date('H:i', strtotime($schedule->end_time)) }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                        <!-- Exams for this hour -->
                        @if(isset($examByHour[$hour]))
                            @foreach($examByHour[$hour] as $exam)
                                @php
                                    $durationMinutes = (strtotime($exam->end_time) - strtotime($exam->start_time)) / 60;
                                    $title = ($exam->exam_type_name ?? 'Exam');
                                    if(isset($exam->subject_name) && $exam->subject_name) {
                                        $title .= ' - ' . $exam->subject_name;
                                    }
                                    if(isset($exam->class_name) && $exam->class_name) {
                                        $title .= ' (' . $exam->class_name . ')';
                                    }
                                @endphp
                                <div class="block-red" style="height: {{ $durationMinutes }}px;">
                                    <div class="block-title">{{ $title }}</div>
                                    <div class="block-sub">
                                        Room no. - {{ $exam->room_id }} 
                                        <span>|</span> 
                                        {{ date('H:i', strtotime($exam->start_time)) }} - {{ date('H:i', strtotime($exam->end_time)) }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                        <!-- If nothing scheduled -->
                        @if(!isset($classByHour[$hour]) && !isset($examByHour[$hour]))
                            <div class="block-grey" style="height: 20px;"> <!-- 60px = 1 hour -->
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

@endif

@if($viewType == 'month')

      {{-- <div class="ds-pr-body">

        <div class="classes-schedule-container">
          <div class="classes-schedule-filter">
            <div class="datepicker">
              <div class="datepicker__header">
                <span>Octuber 2025 </span>
                <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" />
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
                  <div class="dropdown-week cmn-dropdn">
                      <button class="cmn-btn print-btn">Month <img
                                  src="{{asset('staff/assets/images/greyarrow.svg')}}" alt="Icon"></button>
                      <ul class="dropdown-menu-week dropdown-menu">
                          <li>Day</li>
                          <li class="active-week">Week</li>
                          <li>Month</li>
                      </ul>
                  </div>

                  <button><img src="{{asset('staff/assets/images/leftstudent.svg')}}" /></button>
                  <button><img src="{{asset('staff/assets/images/rightstudent.svg')}}" /></button>
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


        </div>

      </div> --}}
 <div class="ds-pr-body">
    <div class="classes-schedule-container">
        <div class="classes-schedule-filter">
            <div class="datepicker">
                <div class="datepicker__header">
                    <span>{{ $schedules['month_name'] }} {{ $schedules['year'] }}</span>
                    <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" />
                </div>
                <div class="datepicker-body-wrp">
                    @for($i = -2; $i <= 2; $i++)
                        @php
                            $monthDate = date('Y-m-d', strtotime($selectedDate . " {$i} months"));
                        @endphp
                        <div class="datepicker__body">
                            <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => $monthDate]) }}">
                                {{ date('F Y', strtotime($monthDate)) }}
                            </a>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="studentBtns">
                <div class="dropdown-week cmn-dropdn">
                    <button class="cmn-btn print-btn">Month <img src="{{asset('staff/assets/images/greyarrow.svg')}}" alt="Icon"></button>
                    <ul class="dropdown-menu-week dropdown-menu">
                        <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => $selectedDate]) }}">Day</a></li>
                        <li><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'week', 'date' => $selectedDate]) }}">Week</a></li>
                        <li class="active-week"><a href="{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => $selectedDate]) }}">Month</a></li>
                    </ul>
                </div>

                <button onclick="window.location.href='{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => date('Y-m-d', strtotime($selectedDate . ' -1 month'))]) }}'">
                    <img src="{{asset('staff/assets/images/leftstudent.svg')}}" />
                </button>
                <button onclick="window.location.href='{{ route('staff.my-classes.class-schedule', ['view' => 'month', 'date' => date('Y-m-d', strtotime($selectedDate . ' +1 month'))]) }}'">
                    <img src="{{asset('staff/assets/images/rightstudent.svg')}}" />
                </button>
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
                        $year = $schedules['year'];
                        $month = $schedules['month'];
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
                                $dailySchedules = $schedules['daily_schedules'][$currentDate] ?? [];
                                $classSchedules = $dailySchedules['class_schedules'] ?? collect([]);
                                $examSchedules = $dailySchedules['exam_schedules'] ?? collect([]);
                                
                                $totalClassCount = $classSchedules->count();
                                $totalExamCount = $examSchedules->count();
                                $totalEvents = $totalClassCount + $totalExamCount;
                            }
                        @endphp
                        
                        <td class="{{ !$isCurrentMonth ? 'empty' : '' }} {{ $isCurrentMonth && $totalEvents > 0 ? 'contain-colors' : '' }}">
                            @if($isCurrentMonth)
                                <!-- Date Number -->
                                <div class="date-number">{{ $dayNumber }}</div>
                                
                                <!-- CLASS SCHEDULES -->
                                @foreach($classSchedules->take(3) as $index => $schedule)
                                    {{-- dd($schedule); --}}
                                    @php

                                    //  dd($schedule);
                                        // Determine class color
                                        $classColors = ['orange', 'green', 'blue'];
                                        $colorIndex = $index % count($classColors);
                                        $eventClass = 'event ' . $classColors[$colorIndex];
                                        
                                        // Get all details
                                        $classDisplay = [
                                            'name' => $schedule->class_name ?? 'Class',
                                            'subject' => $schedule->subject_name ?? null,
                                            'room' => $schedule->room_id ?? 'N/A',
                                            'time' => date('H:i', strtotime($schedule->start_time)) . ' - ' . date('H:i', strtotime($schedule->end_time))
                                        ];
                                    @endphp
                                    <div class="{{ $eventClass }}">
                                        <div class="event-title">
                                            <strong>{{ $classDisplay['name'] }}</strong>
                                            
                                            {{-- Subject (if exists) --}}
                                            @if(!empty($classDisplay['subject']))
                                                <br><small>{{ $classDisplay['subject'] }}</small>
                                            @endif
                                        </div>   
                                        <div class="event-details">
                                            {{-- Always show room and time --}}
                                            <br>Room: {{ $classDisplay['room'] }} | Time: {{ $classDisplay['time'] }}
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- EXAM SCHEDULES -->
                                @foreach($examSchedules->take(3) as $index => $exam)
                                    @php
                                        // Determine exam color
                                        $examColors = ['pink', 'cyan', 'grey'];
                                        $colorIndex = $index % count($examColors);
                                        $eventClass = 'event ' . $examColors[$colorIndex];
                                        
                                        // Get all details
                                        $examDisplay = [
                                            'type' => $exam->exam_type_name ?? 'Exam',
                                            'subject' => $exam->subject_name ?? 'Subject',
                                            'class' => $exam->class_name ?? null,
                                            'room' => $exam->room_id ?? 'N/A',
                                            'time' => date('H:i', strtotime($exam->start_time)) . ' - ' . date('H:i', strtotime($exam->end_time))
                                        ];
                                    @endphp
                                    <div class="{{ $eventClass }}">
                                        <div class="event-title">
                                            <strong>{{ $examDisplay['type'] }}: {{ $examDisplay['subject'] }}</strong>
                                            @if($examDisplay['class'])
                                                <br><small>Class: {{ $examDisplay['class'] }}</small>
                                            @endif
                                        </div>
                                        <div class="event-details">
                                            Room: {{ $examDisplay['room'] }} | {{ $examDisplay['time'] }}
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- Show "more" indicator if more than 3 events total -->
                                @php
                                    $shownEvents = min($classSchedules->count(), 3) + min($examSchedules->count(), 3);
                                    $remainingEvents = $totalEvents - $shownEvents;
                                @endphp
                                
                                @if($remainingEvents > 0)
                                    <div class="event blue">
                                        <div class="event-title">
                                            <strong>+{{ $remainingEvents }} more events</strong>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- If no events at all -->
                                @if($totalEvents == 0)
                                    <div class="event grey">
                                        <div class="event-title">No schedules</div>
                                    </div>
                                @endif
                            @else
                                <!-- Previous/Next month days -->
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

@endif
@endsection
@push('script')
<script>
    $(function() {
        // Initialize datepicker
        $("#datepick").datepicker({
            dateFormat: "MM d, yy",
            onSelect: function(dateText) {
                var selectedDate = new Date(dateText);
                var formattedDate = selectedDate.getFullYear() + '-' + 
                    ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + 
                    ('0' + selectedDate.getDate()).slice(-2);
                
                window.location.href = "{{ route('staff.my-classes.class-schedule', ['view' => 'date']) }}&date=" + formattedDate;
            }
        });
        
        // Add click handlers for dropdowns
        $('.dropdown-menu li a').click(function(e) {
            e.preventDefault();
            window.location.href = $(this).attr('href');
        });
        
        $('.options li a').click(function(e) {
            e.preventDefault();
            window.location.href = $(this).attr('href');
        });
        
        $('.options-day li a').click(function(e) {
            e.preventDefault();
            window.location.href = $(this).attr('href');
        });
    });
</script>
@endpush