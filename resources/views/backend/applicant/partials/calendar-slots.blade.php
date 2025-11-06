
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

    $allDays = collect(CarbonPeriod::create($startOfWeek, $endOfWeek));
    
    // Filter days to show (Monday to Friday + Sunday)
    $filteredDays = $allDays->filter(function ($date) {
        return in_array($date->dayOfWeek, [1, 2, 3, 4, 5, 0]); // Mon, Tue, Wed, Thu, Fri, Sun
    });

    // Group slots by date for easy lookup
    $groupedSlots = $slots->groupBy(function($slot) {
        return Carbon::parse($slot->interview_date)->format('Y-m-d');
    });
@endphp

@foreach($filteredDays as $date)
    @php
        $dateKey = $date->format('Y-m-d');
        $daySlots = $groupedSlots[$dateKey] ?? collect();
        
        Log::info('Rendering day', [
            'date' => $dateKey,
            'slots_count' => $daySlots->count(),
            'slots' => $daySlots->toArray()
        ]);
    @endphp

    <tr>
        <th>{{ $date->format('l, F d') }}</th>

        @foreach($timeSlots as $timeSlot)
            @php
                $booked = $daySlots->first(function ($slot) use ($timeSlot) {
                    $slotStart = $slot->start_time;
                    $slotEnd = $slot->end_time;
                    $colStart = $timeSlot['start'];
                    $colEnd = $timeSlot['end'];
                    
                    // Check if slot overlaps with this time column
                    return ($slotStart >= $colStart && $slotStart <= $colEnd) || 
                           ($slotEnd >= $colStart && $slotEnd <= $colEnd) ||
                           ($slotStart <= $colStart && $slotEnd >= $colEnd);
                });
            @endphp

            <td>
                @if($booked)
                    <div class="scheduled">
                        <div class="tag">Scheduled</div>
                        <div class="title">{{ $booked->interview_mode ?? 'Interview' }}</div>
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
