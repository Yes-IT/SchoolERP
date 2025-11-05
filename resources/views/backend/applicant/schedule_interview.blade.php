@extends('backend.master')
@section('title')

    {{ @$data['title'] }}
@endsection

@section('content')
           <div class="ds-breadcrumb">
                <h1>Schedule Interview</h1>
                <ul>
                    <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                    <li><a href="{{route('applicant.student_application_form')}}">Student Application Forms</a> /</li>
                    <li>Schedule Interview</li>
                </ul>
            </div>
            <div class="ds-pr-body tab-wrapper">
                
                <div class="ds-cmn-table-wrp">
                    <div class="ds-cmn-upr-wrp gr-bg">
                        <h2>Student Details</h2>
                        <div class="ds-cmn-details-cd-outer">
                            <div class="ds-cmn-details-cd">
                                <h3>Full Name:</h3>
                                <p>{{$applicant->first_name}} {{$applicant->last_name}}</p>
                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Address:</h3>
                                <p>{{$applicant->address}}</p>
                            </div>
                        </div>
                    </div>

                   <form id="searchSlotsForm">
                       @csrf
                        <div class="mb-4 align-items-end">
                            <div class="multi-input-grp-list">
                                <div class="multi-input-grp grp-3">
                                    <div class="input-grp">
                                        <label for="examDate">Select Date</label>
                                        <input type="date" name="interview_date" id="interview_date" >
                                    </div>
                                    <div class="input-grp">
                                        <label for="examTime">Start Time</label>
                                        <input type="time" name="start_time" id="interview_start_time"  >
                                    </div>

                                    <div class="input-grp">
                                        <label for="endTime">End Time</label>
                                        <input type="time" name="end_time" id="interview_end_time">
                                    </div>
                                </div>
                                <div class="action-wrp">
                                    {{-- <input type="submit" value="Search"> --}}
                                   <button type="submit" class="cmn-btn">Search</button>
                                </div>
                            </div>
                        
                        </div>
                   </form>

                    <form id="assignSlotForm" >
                      @csrf
                      
                        <input type="hidden" name="applicant_id" id="applicant_id" value="{{ $applicant->id }}">
                        <input type="hidden" name="interview_date" id="assign_interview_date">
                        <input type="hidden" name="start_time" id="assign_start_time">
                        <input type="hidden" name="end_time" id="assign_end_time">

                         <!-- ✅ This changes when tab (Online/Offline) is clicked -->
                         <input type="hidden" name="interview_mode" id="interview_mode" value="online">

                            <div class="ds-content-head">
                                <div class="cmn-tab-head">
                                    <ul>
                                        <li class="tab-bg"></li>
                                        <li class="active" id="online-tab">Online Mode</li>
                                        <li id="offline-tab">Offline Mode</li>
                                    </ul>
                                </div>
                            </div>

                        <div class="cmn-tab-content online-mode" id="online-mode">
                            {{-- <div class="cmn-tab-content-head">
                                <h3>Booked Slots</h3>
                                <button type="button">View Details</button>
                            </div> --}}
                        
                            {{-- <div class="avaiable-slots-cd-wrp">
                                <form>
                                    <div class="available-slots-form">
                                        <fieldset class="avaiable-slots-cd-form" aria-labelledby="available-slots-heading">
                                        <legend id="available-slots-heading" class="sr-only">Available Slots</legend>
                                
                                        <div class="avaiable-slots-cd-grid">
                                            <div class="avaiable-slots-cd" data-slot="2024-09-14T10:00">
                                                <label for="avaiable-slot-1" tabindex="0">
                                                    <span class="avlble-slot-date">Thursday, September 14, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-1" type="radio" name="avaiable-slot" value="2024-09-14T10:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-14T14:00">
                                                <label for="avaiable-slot-2" tabindex="0">
                                                    <span class="avlble-slot-date">Thursday, September 14, 2024</span>
                                                    <span class="avlble-slot-time">02:00 PM - 03:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-2" type="radio" name="avaiable-slot" value="2024-09-14T14:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-15T10:00">
                                                <label for="avaiable-slot-3" tabindex="0">
                                                    <span class="avlble-slot-date">Friday, September 15, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-3" type="radio" name="avaiable-slot" value="2024-09-15T10:00" />
                                            </div>
                                            <div class="avaiable-slots-cd" data-slot="2024-09-15T12:00">
                                                <label for="avaiable-slot-4" tabindex="0">
                                                    <span class="avlble-slot-date">Friday, September 15, 2024</span>
                                                    <span class="avlble-slot-time">12:00 PM - 01:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-4" type="radio" name="avaiable-slot" value="2024-09-15T12:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-17T10:00">
                                                <label for="avaiable-slot-5" tabindex="0">
                                                    <span class="avlble-slot-date">Sunday, September 17, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-5" type="radio" name="avaiable-slot" value="2024-09-17T10:00" />
                                            </div>
                                            <div class="avaiable-slots-cd" data-slot="2024-09-17T14:00">
                                                <label for="avaiable-slot-6" tabindex="0">
                                                    <span class="avlble-slot-date">Sunday, September 17, 2024</span>
                                                    <span class="avlble-slot-time">02:00 PM - 03:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-6" type="radio" name="avaiable-slot" value="2024-09-17T14:00" />
                                            </div>
                                        </div>
                                
                                        </fieldset>
                                    </div>
                                </form>
                            </div> --}}

                            <!-- booked Slots Section -->
                            <div id="bookedSlotsContainer">
                                {{-- Slots will be loaded here --}}
                            </div>

                            <div class="interview-location-row">
                                <label class="interview-location-label" for="interview_link">Meeting Link</label>
                                <input type="text" id="interview_link" class="interview-location-input" name="interview_link" placeholder="Meeting Link" />
                            
                            </div>
                            <div class="avaiable-slots-actions">
                                <button type="button" class="cmn-btn cancel-btn">Cancel</button>
                                <button type="submit" class="cmn-btn primary-assign-btn">Assign Slot</button>
                            </div>
                        </div>

                        <div class="cmn-tab-content offline-mode" id="offline-mode">
                            {{-- <div class="cmn-tab-content-head">
                                <h3>Booked Slots</h3>
                                <button type="button">View Details</button>
                            </div> --}}
                        
                            {{-- <div class="avaiable-slots-cd-wrp">
                                <form>
                                    <div class="available-slots-form">
                                        <fieldset class="avaiable-slots-cd-form" aria-labelledby="available-slots-heading">
                                        <legend id="available-slots-heading" class="sr-only">Available Slots</legend>
                                
                                        <div class="avaiable-slots-cd-grid">
                                            <div class="avaiable-slots-cd" data-slot="2024-09-14T10:00">
                                                <label for="avaiable-slot-1" tabindex="0">
                                                    <span class="avlble-slot-date">Thursday, September 14, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-1" type="radio" name="avaiable-slot" value="2024-09-14T10:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-14T14:00">
                                                <label for="avaiable-slot-2" tabindex="0">
                                                    <span class="avlble-slot-date">Thursday, September 14, 2024</span>
                                                    <span class="avlble-slot-time">02:00 PM - 03:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-2" type="radio" name="avaiable-slot" value="2024-09-14T14:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-15T10:00">
                                                <label for="avaiable-slot-3" tabindex="0">
                                                    <span class="avlble-slot-date">Friday, September 15, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-3" type="radio" name="avaiable-slot" value="2024-09-15T10:00" />
                                            </div>
                                            <div class="avaiable-slots-cd" data-slot="2024-09-15T12:00">
                                                <label for="avaiable-slot-4" tabindex="0">
                                                    <span class="avlble-slot-date">Friday, September 15, 2024</span>
                                                    <span class="avlble-slot-time">12:00 PM - 01:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-4" type="radio" name="avaiable-slot" value="2024-09-15T12:00" />
                                            </div>
                                
                                            <div class="avaiable-slots-cd" data-slot="2024-09-17T10:00">
                                                <label for="avaiable-slot-5" tabindex="0">
                                                    <span class="avlble-slot-date">Sunday, September 17, 2024</span>
                                                    <span class="avlble-slot-time">10:00 AM - 11:00 AM</span>
                                                </label>
                                                <input id="avaiable-slot-5" type="radio" name="avaiable-slot" value="2024-09-17T10:00" />
                                            </div>
                                            <div class="avaiable-slots-cd" data-slot="2024-09-17T14:00">
                                                <label for="avaiable-slot-6" tabindex="0">
                                                    <span class="avlble-slot-date">Sunday, September 17, 2024</span>
                                                    <span class="avlble-slot-time">02:00 PM - 03:00 PM</span>
                                                </label>
                                                <input id="avaiable-slot-6" type="radio" name="avaiable-slot" value="2024-09-17T14:00" />
                                            </div>
                                        </div>
                                
                                        </fieldset>
                                    </div>
                                </form>
                            </div> --}}

                            <div id="bookedSlotsContainer"></div>

                            <div class="interview-location-row">
                                <label class="interview-location-label" for="interview-location">Interview Location</label>
                                <input  type="text" id="interview_location" class="interview-location-input" name="interview_location" placeholder="Location Name" />
                            
                            </div>
                            <div class="avaiable-slots-actions">
                                <button type="button" class="cmn-btn cancel-btn">Cancel</button>
                                <button type="submit" class="cmn-btn primary-assign-btn">Assign Slot</button>
                            </div>
                        </div>
                  
                    </form> 
                </div>
                  
            </div>


@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const onlineTab = document.getElementById('online-tab');
    const offlineTab = document.getElementById('offline-tab');
    const interviewModeInput = document.getElementById('interview_mode');
    const onlineModeDiv = document.getElementById('online-mode');
    const offlineModeDiv = document.getElementById('offline-mode');
    const searchForm = document.getElementById('searchSlotsForm');

    // Default to online mode
    if (interviewModeInput.value === '' || interviewModeInput.value === 'online') {
        interviewModeInput.value = 'online';
        onlineTab.classList.add('active');
        offlineTab.classList.remove('active');
        onlineModeDiv.style.display = 'block';
        offlineModeDiv.style.display = 'none';
    }

    //  Online tab click
    onlineTab.addEventListener('click', () => {
        onlineTab.classList.add('active');
        offlineTab.classList.remove('active');
        interviewModeInput.value = 'online';
        onlineModeDiv.style.display = 'block';
        offlineModeDiv.style.display = 'none';

        // Trigger re-fetch for booked slots (Online mode)
        searchForm.dispatchEvent(new Event('submit'));
    });

    // 🔁 Offline tab click
    offlineTab.addEventListener('click', () => {
        offlineTab.classList.add('active');
        onlineTab.classList.remove('active');
        interviewModeInput.value = 'offline';
        offlineModeDiv.style.display = 'block';
        onlineModeDiv.style.display = 'none';

        // Trigger re-fetch for booked slots (Offline mode)
        searchForm.dispatchEvent(new Event('submit'));
    });
});
</script>

<script>
document.getElementById('searchSlotsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('applicant.fetch_interview_slots') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('bookedSlotsContainer');
        console.log(data);
        if (data.success) {
            container.innerHTML = data.html;
            // console.log('HTML:', data.html);

            // Copy date/time values from search form to assign form
            document.getElementById('assign_interview_date').value = document.getElementById('interview_date').value;
            document.getElementById('assign_start_time').value = document.getElementById('interview_start_time').value;
            document.getElementById('assign_end_time').value = document.getElementById('interview_end_time').value;
        } else {
            container.innerHTML = `<p style="color:red;">${data.message}</p>`;
        }
    })
    .catch(error => console.error('Error fetching slots:', error));
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('assignSlotForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log("Assign Slot form submitted "); 

        const formData = new FormData(this);
        console.log("Form Data:", formData);

        fetch("{{ route('applicant.assign_interview_slot') }}", {  
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Server Response:", data);
            if (data.success) {
                alert(data.message);
                window.location.href = "{{ route('applicant.student_application_form') }}";
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error("Error:", err);
            alert('Error while assigning slot.');
        });
    });
});

</script>
<script>
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('view-details-btn')) {
        window.location.href = "{{ route('applicant.calender') }}";
    }
});

</script>

@endpush