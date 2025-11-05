

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
            
        ];

        $daysToShow = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sunday'];
       $allDays = collect(CarbonPeriod::create($startOfWeek, $endOfWeek))
            ->filter(fn($date) => in_array($date->format('l'), $daysToShow));

        $groupedSlots = $slots->groupBy(fn($slot) => Carbon::parse($slot->interview_date)->format('Y-m-d'));
        // dd($groupedSlots);
    @endphp

    @foreach($allDays as $date)
        @php
            $daySlots = $groupedSlots[$date->format('Y-m-d')] ?? collect();
        @endphp

        <tr>
            <th>{{ $date->format('l, F d') }}</th>
            @foreach($timeColumns as $start => $end)
                @php
                    $booked = $daySlots->first(function ($slot) use ($start, $end, $date) {
                        $slotStart = Carbon::parse($slot->start_time);
                        $dayStart = Carbon::parse($date->format('Y-m-d') . ' ' . $start);
                        $dayEnd   = Carbon::parse($date->format('Y-m-d') . ' ' . $end);
                        return $slotStart->between($dayStart, $dayEnd);
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


