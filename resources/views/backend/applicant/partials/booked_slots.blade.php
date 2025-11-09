@if($slots->isEmpty())
    <p class="text-center text-muted py-3">No booked slots found for this date.</p>
@else
    <div class="cmn-tab-content-head mb-3">
        <h3>Booked Slots</h3>
        <button type="button" class="view-details-btn">View Details</button>
    </div>

    <div class="avaiable-slots-cd-wrp">
        <form>
            <div class="available-slots-form">
                <fieldset class="avaiable-slots-cd-form" aria-labelledby="available-slots-heading">
                    <legend id="available-slots-heading" class="sr-only">Booked Slots</legend>

                    <div class="avaiable-slots-cd-grid">
                        @foreach($slots as $index => $slot)
                            @php
                                $formattedDate = \Carbon\Carbon::parse($slot->interview_date)->format('l, F d, Y');
                                $formattedTime = date('h:i A', strtotime($slot->start_time)) . ' - ' . date('h:i A', strtotime($slot->end_time));
                            @endphp

                            <div class="avaiable-slots-cd" data-slot="{{ $slot->interview_date }}T{{ $slot->start_time }}">
                                <label for="avaiable-slot-{{ $index + 1 }}" tabindex="0">
                                    <span class="avlble-slot-date">{{ $formattedDate }}</span>
                                    <span class="avlble-slot-time">{{ $formattedTime }}</span>
                                </label>
                                {{-- <input id="avaiable-slot-{{ $index + 1 }}" type="radio" name="avaiable-slot" value="{{ $slot->id }}" /> --}}
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </form>
    </div>
@endif
