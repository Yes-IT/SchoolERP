
@php
    use Carbon\Carbon;
    use Carbon\CarbonPeriod;

    $timeSlots = $timeSlots ?? [
        ['start' => '10:00:00', 'end' => '10:59:59'],
        ['start' => '11:00:00', 'end' => '11:59:59'],
        ['start' => '12:00:00', 'end' => '12:59:59'],
        ['start' => '13:00:00', 'end' => '13:59:59'],
        ['start' => '14:00:00', 'end' => '14:59:59'],
        ['start' => '15:00:00', 'end' => '15:59:59'],
        ['start' => '16:00:00', 'end' => '16:59:59'],
        ['start' => '17:00:00', 'end' => '17:59:59'],
    ];

    // Create period and filter days
    $allDays = collect(CarbonPeriod::create($startOfWeek, $endOfWeek))
        ->filter(function ($date) {
            return in_array($date->dayOfWeek, [1, 2, 3, 4, 5, 0]); // Mon-Fri + Sun
        });

    // Group slots by date
    $groupedSlots = $slots->groupBy(function($slot) {
        return Carbon::parse($slot->interview_date)->format('Y-m-d');
    });
@endphp

{{-- @foreach($allDays as $date)
    @php
        $dateKey = $date->format('Y-m-d');
        $daySlots = $groupedSlots->get($dateKey, collect());
        
        Log::info('Rendering day', [
            'date' => $dateKey,
            'slots_count' => $daySlots->count(),
            'slots' => $daySlots->pluck('id')->toArray()
        ]);
    @endphp

    <tr>
        <th>{{ $date->format('l, F d') }}</th>

        @foreach($timeSlots as $timeSlot)
            @php
                $booked = null;
                
                foreach ($daySlots as $slot) {
                    $slotStart = $slot->start_time;
                    $colStart = $timeSlot['start'];
                    $colEnd = $timeSlot['end'];
                
                    if ($slotStart >= $colStart && $slotStart <= $colEnd) {
                        $booked = $slot;
                        break;
                    }
                }
            @endphp

            <td>
                @if($booked)
                    <div class="scheduled">
                        <div class="tag">Scheduled </div>
                         <div class="title">
                          
                            {{ optional($booked->applicant)->first_name ?? 'Applicant' }} {{ optional($booked->applicant)->last_name ?? '' }}

                        </div>
                        <div class="meta">
                            @if($booked->interview_mode === 'offline' && $booked->interview_location)
                                {{ $booked->interview_location }}
                            @elseif($booked->interview_mode === 'online')
                                Online Interview
                            @else
                                Location not specified
                            @endif
                            <br>
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
@endforeach --}}

@foreach($allDays as $date)
    @php
        $dateKey = $date->format('Y-m-d');
        $daySlots = $groupedSlots->get($dateKey, collect());
        
        Log::info('Rendering day', [
            'date' => $dateKey,
            'slots_count' => $daySlots->count(),
            'slots' => $daySlots->pluck('id')->toArray()
        ]);
    @endphp

    <tr>
        <th>{{ $date->format('l, F d') }}</th>

        @foreach($timeSlots as $timeSlot)
            @php
                $bookedSlots = $daySlots->filter(function ($slot) use ($timeSlot) {
                    $slotStart = $slot->start_time;
                    $colStart = $timeSlot['start'];
                    $colEnd = $timeSlot['end'];
                    
                    return $slotStart >= $colStart && $slotStart <= $colEnd;
                });
            @endphp

            <td>
                @if($bookedSlots->count() > 0)
                    @foreach($bookedSlots as $booked)
                        <div class="scheduled" style="margin-bottom: 8px; padding: 8px; border-radius: 4px;" >
                            <div class="tag" style="font-size: 10px;  padding: 2px 6px; border-radius: 3px; display: inline-block; margin-bottom: 4px;">Scheduled</div>
                            <div class="title">
                                {{ optional($booked->applicant)->first_name ?? 'Applicant' }} {{ optional($booked->applicant)->last_name ?? '' }}
                            </div>
                            <div class="meta" >
                                @if($booked->interview_mode === 'offline' && $booked->interview_location)
                                    {{ $booked->interview_location }}
                                @elseif($booked->interview_mode === 'online')
                                    Online Interview
                                @else
                                    Location not specified
                                @endif
                                <br>
                                {{ date('h:i A', strtotime($booked->start_time)) }} - {{ date('h:i A', strtotime($booked->end_time)) }}
                            </div>
                        </div>
                    @endforeach
                    
                    
                    @if($bookedSlots->count() < 3)
                        <div class="cell-center" style="margin-top: 5px;">
                            <div class="available" style="font-size: 11px; padding: 4px; background: #e8f5e8; color: #2d5016; border-radius: 3px;">
                                {{ 3 - $bookedSlots->count() }} slot(s) available
                            </div>
                        </div>
                    @endif
                @else
                   
                    <div class="cell-center">
                        <div class="available">3 slots available</div>
                    </div>
                @endif
            </td>
        @endforeach
    </tr>
@endforeach