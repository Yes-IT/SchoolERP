@php
    use Carbon\Carbon;

    // Generate time options dynamically (8:00 AM to 6:00 PM in 30-minute intervals)
    $times = [];
    $start = Carbon::createFromTime(8, 0);
    $end   = Carbon::createFromTime(18, 0);

    while ($start <= $end) {
        $times[] = $start->format('h:i A');
        $start->addMinutes(30);
    }

    // Format DB values (if $schedule exists, otherwise set empty for create)
    $formattedDay   = $schedule->day ?? '';
    $formattedPeriod = $schedule->period ?? '';
    $formattedStart = isset($schedule->start_time) ? Carbon::parse($schedule->start_time)->format('h:i A') : '';
    $formattedEnd   = isset($schedule->end_time) ? Carbon::parse($schedule->end_time)->format('h:i A') : '';
    $formattedRoom  = $schedule->room_id ?? '';
@endphp

<div class="added-element-card schedule-row">
    <span class="sl-count"></span>
    <div class="multi-input-grp input-grp-5">
        {{-- Day Select --}}
        <div class="input-grp">
            <select name="schedules[{{ $index }}][day]" class="day-select">
                <option value="">Select Day</option>
                @foreach(\App\Enums\Days::all() as $day)
                    <option value="{{ $day }}" {{ $formattedDay == $day ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Period Select --}}
        <div class="input-grp">
            <select name="schedules[{{ $index }}][period]" class="period-select">
                <option value="">Select Period</option>
                <option value="1" {{ $formattedPeriod == 1 ? 'selected' : '' }}>Period 1</option>
                <option value="2" {{ $formattedPeriod == 2 ? 'selected' : '' }}>Period 2</option>
                <option value="3" {{ $formattedPeriod == 3 ? 'selected' : '' }}>Period 3</option>
            </select>
        </div>

        {{-- Start Time --}}
        <div class="input-grp">
            <select name="schedules[{{ $index }}][start_time]" class="start-time-select">
                <option value="">Start Time</option>
                @foreach($times as $time)
                    <option value="{{ $time }}" {{ $formattedStart == $time ? 'selected' : '' }}>
                        {{ $time }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- End Time --}}
        <div class="input-grp">
            <select name="schedules[{{ $index }}][end_time]" class="end-time-select">
                <option value="">End Time</option>
                @foreach($times as $time)
                    <option value="{{ $time }}" {{ $formattedEnd == $time ? 'selected' : '' }}>
                        {{ $time }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Room --}}
        <div class="input-grp">
            <select name="schedules[{{ $index }}][room_id]" class="room-select">
                <option value="">Select Room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $formattedRoom == $room->id ? 'selected' : '' }}>
                        {{ $room->room_no }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Actions --}}
    <div class="added-elm-actions btn-grp">
        <button type="button" class="cmn-btn btn-sm delete-row-btn">Delete</button>
    </div>
</div>
