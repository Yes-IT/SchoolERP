@extends('staff.master')
<style>
.block-red {
    background: #FFE5E5;
    border-left: 3px solid #FF6B6B;
    border-radius: 4px;
    padding: 8px;
    margin-bottom: 2px;
    overflow: hidden;
    position: relative;
}





</style>
@section('content')
<div class="ds-breadcrumb">
        <h1>My Classes</h1>
        <ul>
          <li><a href="{{ route('staff.dashboard') }}">Dashboard</a> /</li>
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
                                @php
                                    $hours = range(8, 17); // 8 AM to 5 PM 
                                    $classColors = ['item-blue', 'item-green', 'item-purple', 'item-pink', 'item-grey'];
                                    $globalColorIndex = 0; // Global counter
                                    $classColorMap = [];
                                @endphp

                                @foreach($hours as $hour)
                                    <tr>
                                        @foreach($weekDays as $dayInfo)
                                            @php
                                                $date = $dayInfo['date'];
                                                $dailySchedules = $schedules['daily_schedules'][$date] ?? [];
                                                $schedulesThisHour = [];
                                                
                                                // Check exams first
                                                if(!empty($dailySchedules['exam_schedules'])) {
                                                    foreach($dailySchedules['exam_schedules'] as $exam) {
                                                        $examHour = (int)date('H', strtotime($exam->start_time));
                                                        if($examHour == $hour) {
                                                            $schedulesThisHour[] = ['type' => 'exam', 'data' => $exam];
                                                        }
                                                    }
                                                }
                                                
                                                // Then check classes
                                                if(!empty($dailySchedules['class_schedules'])) {
                                                    foreach($dailySchedules['class_schedules'] as $class) {
                                                        $classHour = (int)date('H', strtotime($class->start_time));
                                                        if($classHour == $hour) {
                                                            // Assign color based on class ID
                                                            if(!isset($classColorMap[$class->class_id])) {
                                                                $classColorMap[$class->class_id] = $classColors[$globalColorIndex % count($classColors)];
                                                                $globalColorIndex++;
                                                            }
                                                            
                                                            $schedulesThisHour[] = [
                                                                'type' => 'class', 
                                                                'data' => $class,
                                                                'color' => $classColorMap[$class->class_id]
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            
                                            <td>
                                                @forelse($schedulesThisHour as $schedule)
                                                    @if($schedule['type'] === 'class')
                                                        <div class="{{ $schedule['color'] }} mb-2">
                                                            <p class="lorem-text">{{ $schedule['data']->class_name }}</p>
                                                            <p class="lorem-grey">Room: {{ $schedule['data']->room_id }}</p>
                                                            <p class="lorem-grey">
                                                                {{ date('H:i', strtotime($schedule['data']->start_time)) }} - 
                                                                {{ date('H:i', strtotime($schedule['data']->end_time)) }}
                                                            </p>
                                                        </div>
                                                    @else
                                                        <div class="item-red mb-2">
                                                            <p class="exam-btn-red">Exam</p>
                                                            <div class="red-text">
                                                                <p>{{ $schedule['data']->subject_name }}</p>
                                                                <div>
                                                                    <p>Room: {{ $schedule['data']->room_id }}</p>
                                                                    <p>
                                                                        {{ date('H:i', strtotime($schedule['data']->start_time)) }} - 
                                                                        {{ date('H:i', strtotime($schedule['data']->end_time)) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @empty
                                                    <div class="item-black">
                                                        <p>Not Scheduled</p>
                                                    </div>
                                                @endforelse
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
          </div>

      </div>
  </div>    

@endif

@if($viewType == 'date')

<div class="ds-pr-body">
    <div class="dsbdy-bottom w65">
        <div class="calendar-container">
            <div class="calendar-header">
                <div>
                    <div class="dropdown header-select">
                        <input type="checkbox" id="toggle" hidden>
                        <p class="calender-open">
                            <!-- Use a readonly input for datepicker -->
                            <input type="text" 
                                value="{{ date('F d, Y', strtotime($selectedDate)) }}" 
                                id="datepick" 
                                class="calenderDate" 
                                readonly>
                            <img class="calimage" src="{{ asset('staff/assets/images/cal.svg') }}"/>
                        </p>
                       <ul class="options">
                            <!-- Keep your quick date options -->
                            @for($i = -3; $i <= 3; $i++)
                                @php
                                    $dateOption = date('Y-m-d', strtotime($selectedDate . " {$i} days"));
                                @endphp
                                <li data-value="{{ $dateOption }}">
                                    <a href="{{ route('staff.my-classes.class-schedule', ['view' => 'date', 'date' => $dateOption]) }}">
                                        {{ date('F d, Y', strtotime($dateOption)) }}
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
                <!-- Time slots using periods -->
                {{-- <div class="time-row">
                    @foreach($periods as $period)
                        <div class="time-cell">{{ date('H:i', strtotime($period->start_time)) }}</div>
                    @endforeach
                </div> --}}

                <div class="time-row">
                    @for($hour = 8; $hour <= 17; $hour++)
                        <div class="time-cell">{{ sprintf('%02d:00', $hour) }}</div>
                    @endfor
                </div>

                <!-- Events -->

               <div class="events-blocks">
                    @php
                        $classSchedules = $schedules['class_schedules'] ?? collect([]);
                        $examSchedules = $schedules['exam_schedules'] ?? collect([]);
                        
                        // Combine all schedules
                        $allSchedules = $classSchedules->merge($examSchedules);
                        
                        // Create array to track which events are in which hour slots
                        $eventsByHour = [];
                        for($hour = 8; $hour <= 17; $hour++) {
                            $eventsByHour[$hour] = null; // Start with null (no event)
                        }
                        
                        // Assign events to hour slots
                        foreach($allSchedules as $event) {
                            $eventStart = $event->start_time; // Keep as string
                            $eventEnd = $event->end_time; // Keep as string
                            
                            // Convert to timestamps for comparison
                            $eventStartTs = strtotime($eventStart);
                            $eventEndTs = strtotime($eventEnd);
                            
                            // Check each hour slot from 8:00 to 17:00
                            for($hour = 8; $hour <= 17; $hour++) {
                                $slotStartTs = strtotime(sprintf('%02d:00', $hour));
                                $slotEndTs = strtotime(sprintf('%02d:00', $hour + 1));
                                
                                // If event overlaps with this hour slot
                                if ($eventStartTs < $slotEndTs && $eventEndTs > $slotStartTs) {
                                    // Only assign if not already assigned (first event wins)
                                    if ($eventsByHour[$hour] === null) {
                                        $eventsByHour[$hour] = $event;
                                    }
                                }
                            }
                        }
                        
                        // Color arrays
                        $classColors = ['block-yellow', 'block-green', 'block-blue', 'block-pink'];
                        $colorAssignments = []; // To track which color each event gets
                        $colorIndex = 0;
                    @endphp
                    
                    @for($hour = 8; $hour <= 17; $hour++)
                        @php
                            $currentEvent = $eventsByHour[$hour];
                            $hasEvent = !empty($currentEvent);
                            
                            // Get or assign color for this event
                            $eventColor = 'block-grey'; // Default for free time
                            
                            if ($hasEvent) {
                                $eventId = $currentEvent->id ?? null;
                                $eventType = $currentEvent->type ?? 'class';
                                
                                if ($eventType == 'exam') {
                                    $eventColor = 'block-red';
                                } else {
                                    // Assign consistent color for the same class event
                                    if (!isset($colorAssignments[$eventId])) {
                                        $colorAssignments[$eventId] = $classColors[$colorIndex % count($classColors)];
                                        $colorIndex++;
                                    }
                                    $eventColor = $colorAssignments[$eventId];
                                }
                                
                                // Get display info
                                if ($eventType == 'class') {
                                    $title = $currentEvent->class_name ?? 'Class';
                                    if(isset($currentEvent->subject_name)) {
                                        $title .= ' - ' . $currentEvent->subject_name;
                                    }
                                } else {
                                    $title = $currentEvent->exam_type_name ?? 'Exam';
                                    if(isset($currentEvent->subject_name)) {
                                        $title .= ' - ' . $currentEvent->subject_name;
                                    }
                                    if(isset($currentEvent->class_name)) {
                                        $title .= ' (' . $currentEvent->class_name . ')';
                                    }
                                }
                                
                                // Time display for this specific hour
                                $hourStart = sprintf('%02d:00', $hour);
                                $hourEnd = sprintf('%02d:00', $hour + 1);
                                
                                // Determine what portion of the event is in this hour
                                $displayStart = max($currentEvent->start_time, $hourStart);
                                $displayEnd = min($currentEvent->end_time, $hourEnd);
                                
                                // Format times properly
                                $displayStart = date('H:i', strtotime($displayStart));
                                $displayEnd = date('H:i', strtotime($displayEnd));
                            }
                        @endphp
                        
                        <div class="div{{ $hour-7 }}-blocks" style="height: 50px;">
                            @if($hasEvent)
                                <div class="{{ $eventColor }}" style="height: 100%;">
                                    <div class="block-title">{{ $title }}</div>
                                    <div class="block-sub">
                                        Room: {{ $currentEvent->room_id ?? 'N/A' }} 
                                        <span>|</span> 
                                        {{ $displayStart }}-{{ $displayEnd }}
                                    </div>
                                </div>
                            @else
                                <div class="block-grey" style="height: 100%;">
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
    // $(function() {
    //     // Initialize datepicker
    //     $("#datepick").datepicker({
    //         dateFormat: "MM d, yy",
    //         onSelect: function(dateText) {
    //             var selectedDate = new Date(dateText);
    //             var formattedDate = selectedDate.getFullYear() + '-' + 
    //                 ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + 
    //                 ('0' + selectedDate.getDate()).slice(-2);
                
    //             // window.location.href = "{{ route('staff.my-classes.class-schedule', ['view' => 'date']) }}?date=" + formattedDate;

    //             var baseUrl = "{{ route('staff.my-classes.class-schedule', ['view' => 'date']) }}";
    //             window.location.href = baseUrl + '?date=' + formattedDate;
    //         }
    //     });
        
    //     // Add click handlers for dropdowns
    //     $('.dropdown-menu li a').click(function(e) {
    //         e.preventDefault();
    //         window.location.href = $(this).attr('href');
    //     });
        
    //     $('.options li a').click(function(e) {
    //         e.preventDefault();
    //         window.location.href = $(this).attr('href');
    //     });
        
    //     $('.options-day li a').click(function(e) {
    //         e.preventDefault();
    //         window.location.href = $(this).attr('href');
    //     });
    // });

   
</script>
<script>
    $(function() {
    // Initialize datepicker
    $('#datepick').datepicker({
        dateFormat: 'MM d, yy',
        showOn: 'both',
        buttonImageOnly: true,
        buttonImage: '{{ asset("staff/assets/images/cal.svg") }}',
        buttonText: 'Select date',
        onSelect: function(dateText) {
            // Parse the date properly
            var dateObj = $(this).datepicker('getDate');
            
            if (dateObj) {
                var year = dateObj.getFullYear();
                var month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                var day = ('0' + dateObj.getDate()).slice(-2);
                var formattedDate = year + '-' + month + '-' + day;
                
                console.log('Selected date:', formattedDate);
                
                // Redirect to selected date
                var baseUrl = "{{ route('staff.my-classes.class-schedule', ['view' => 'date']) }}";
                var redirectUrl = baseUrl + '&date=' + formattedDate;
                
                window.location.href = redirectUrl;
            }
        },
        beforeShow: function(input, inst) {
            // Close any other open dropdowns
            $('#toggle').prop('checked', false);
            
            // Set current date
            var currentDate = "{{ $selectedDate }}";
            if (currentDate) {
                $(this).datepicker('setDate', new Date(currentDate));
            }
        }
    });
    
    // Handle manual input changes (if user types)
    $('#datepick').on('change', function() {
        var dateText = $(this).val();
        if (dateText) {
            var dateObj = new Date(dateText);
            if (dateObj instanceof Date && !isNaN(dateObj)) {
                var year = dateObj.getFullYear();
                var month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                var day = ('0' + dateObj.getDate()).slice(-2);
                var formattedDate = year + '-' + month + '-' + day;
                
                var baseUrl = "{{ route('staff.my-classes.class-schedule', ['view' => 'date']) }}";
                var redirectUrl = baseUrl + '&date=' + formattedDate;
                
                window.location.href = redirectUrl;
            }
        }
    });
    
    // Handle dropdown date clicks
    $('.options li a').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = $(this).attr('href');
        return false;
    });
    
    // Handle view type changes
    $('.options-day li a').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = $(this).attr('href');
        return false;
    });
    
    // Close datepicker when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#datepick, .ui-datepicker, .ui-datepicker-header, .ui-datepicker-calendar').length) {
            $('#datepick').datepicker('hide');
        }
    });
    
    // Also make the calendar icon trigger the datepicker
    $('.calimage').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#datepick').datepicker('show');
        return false;
    });
});
</script>
@endpush