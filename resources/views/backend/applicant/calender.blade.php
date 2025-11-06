@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
 <div class="ds-breadcrumb">
                <h1>Calendar</h1>
                <ul>
                    <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                    <li>Calendar</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                
                <div class="classes-schedule-container ds-calendar-pg">
                    <div class="classes-schedule-filter">
                        <div class="sec-head">
                            <h2>Calendar</h2>
                        </div>
                        <div class="datepicker">
                            <div class="datepicker__header">
                                <img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Icon">
                                <span id="range-display"> Jan, 2025</span>
                            </div>
                            <div class="datepicker-body-wrp">
                                <div class="datepicker__body">
                                    <select id="year-select"></select>
                                    <select id="month-select"></select>
                                    <select id="week-select"></select>
                                </div>
                                <div class="datepicker__footer">
                                    <button class="datepicker__btn datepicker__btn--cancel cmn-btn" id="btn-cancel">Cancel</button>
                                    <button class="datepicker__btn datepicker__btn--apply cmn-btn" id="btn-apply">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="boxtbl-outer">
                        <div class="box-table-container">
                            <table class="calendar-table" role="grid" aria-label="Weekly timetable">
                                <thead>
                                    {{-- <tr>
                                        <th>Day/Time</th>
                                        <th>10:00 AM - 10:59 AM</th>
                                        <th>11:00 AM - 11:59 AM</th>
                                        <th>12:00 PM - 12:59 PM</th>
                                        <th>01:00 PM - 01:59 PM</th>
                                        <th>02:00 PM - 02:59 PM</th>
                                        <th>03:00 PM - 03:59 PM</th>
                                        <th>04:00 PM - 04:59 PM</th>
                                        <th>05:00 PM - 05:59 PM</th>
                                        <th>06:00 PM - 06:59 PM</th>
                                        <th>07:00 PM - 07:59 PM</th>
                                    </tr> --}}

                                    <tr>
                                    <th>Day/Time</th>
                                       @foreach($timeSlots as $slot)
                                            <th>
                                                {{ date('h:i A', strtotime($slot['start'])) }} - {{ date('h:i A', strtotime($slot['end'])) }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                            
                                {{-- <tbody>
                                    <tr>
                                        <th>Thursday, September 01</th>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Location: Lorem ipsum dolor sit amet, Texas, United States, 75001</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                 <div class="meta">Location: Lorem ipsum dolor sit amet, Texas, United States, 75001</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <th>Friday, September 02</th>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Interview
                                                    12:00 - 12:40</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                 <div class="meta">Location: Lorem ipsum dolor sit amet, Texas, United States, 75001</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <th>Sunday, September 04</th>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                 <div class="meta">Location: Lorem ipsum dolor sit amet, Texas, United States, 75001</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Location: Lorem ipsum dolor sit amet, Texas, United States, 75001</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <th>Monday, September 05</th>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Lesson
                                                    10:00 - 10:40</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <th>Tuesday, September 06</th>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Lesson
                                                    10:00 - 10:40</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Lesson
                                                    10:40 - 11:20</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <th>Wednesday, September 07</th>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Lesson
                                                    10:00 - 10:40</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="scheduled">
                                                <div class="tag">Scheduled</div>
                                                <div class="title">Applicant Name</div>
                                                <div class="meta">Lesson
                                                    10:40 - 11:20</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-center">
                                                <div class="available">Available</div>
                                            </div>
                                        </td>
                                    </tr>
                            
                                </tbody> --}}

 
                                {{-- <tbody>
                                    @php
                                        use Carbon\Carbon;
                                        use Carbon\CarbonPeriod;

                                      
                                        $timeColumns = [
                                            '10:00:00' => '10:59:59',
                                            '11:00:00' => '11:59:59',
                                            '12:00:00' => '12:59:59',
                                            '13:00:00' => '13:59:59',
                                            '14:00:00' => '14:59:59',
                                            '15:00:00' => '15:59:59',
                                            '16:00:00' => '16:59:59',
                                            '17:00:00' => '17:59:59',
                                            '18:00:00' => '18:59:59',
                                            '19:00:00' => '19:59:59'
                                        ];

                                        
                                        $startOfWeek = Carbon::parse($startDate ?? now())->startOfWeek(Carbon::MONDAY);
                                        $endOfWeek   = Carbon::parse($endDate ?? now())->endOfWeek(Carbon::SUNDAY);

                                        $allDays = collect(CarbonPeriod::create($startOfWeek, $endOfWeek));

                                        $filteredDays = $allDays->filter(function ($date) {
                                          
                                            return in_array($date->dayOfWeek, [0, 1, 2, 3, 4, 5]) && $date->dayOfWeek !== 6; 
                                            
                                        });

                                        
                                        $groupedSlots = $slots->groupBy(fn($slot) => Carbon::parse($slot->interview_date)->format('Y-m-d'));
                                    @endphp

                                  
                                    @foreach($filteredDays as $date)
                                        @php
                                            $daySlots = $groupedSlots[$date->format('Y-m-d')] ?? collect();
                                        @endphp

                                        <tr>
                                            <th>{{ $date->format('l, F d') }}</th>

                                            @foreach($timeColumns as $start => $end)
                                                @php
                                                    $booked = $daySlots->first(function ($slot) use ($start, $end) {
                                                        return $slot->start_time >= $start && $slot->start_time <= $end;
                                                    });
                                                @endphp

                                                <td>
                                                    @if($booked)
                                                        <div class="scheduled">
                                                            <div class="tag">Scheduled</div>
                                                            <div class="title">{{ ucfirst($booked->interview_mode ?? 'N/A') }}</div>
                                                            <div class="meta">
                                                                {{ $booked->interview_location ?? 'N/A' }}<br>
                                                                {{ date('h:i A', strtotime($booked->start_time)) }} - {{ date('h:i A', strtotime($booked->end_time)) }}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="cell-center">
                                                            <div class="available">Available</div>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody> --}}

                                <tbody id="calendar-table-body">
                                    @include('backend.applicant.partials.calendar-slots', [
                                        'slots' => $slots,
                                        'startOfWeek' => $startOfWeek,
                                        'endOfWeek' => $endOfWeek,
                                    ])
                                </tbody>


                            </table>
                        </div>
                    </div>
                      
                </div>
                  
            </div>


@endsection

@push('script')
<script>

$(document).ready(function() {
    $('#btn-apply').on('click', function() {
        const year  = $('#year-select').val();
        const month = $('#month-select').val(); 
        const week  = $('#week-select').val();

        console.log('Filter parameters:', { year, month, week });

        if (!year || !month || !week) {
            alert('Please select year, month, and week.');
            return;
        }

        $.ajax({
            url: "{{ route('calendar.calendar_filter_slots') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                year: year,
                month: month, 
                week: week
            },
            success: function(response) {
                console.log('AJAX response:', response);
                if (response.html && $.trim(response.html) !== '') {
                    $('#calendar-table-body').html(response.html);
                } else {
                    $('#calendar-table-body').html('<tr><td colspan="8" class="text-center text-muted">No slots found for this week.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching slots:', error);
                console.error('Response text:', xhr.responseText);
                alert('Failed to load slots. Please try again.');
            }
        });
    });
});
</script>

@endpush
