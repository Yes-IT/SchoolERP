@extends('backend.master')
@section('title')

    {{ @$data['title'] }}
@endsection

<style>
    #searchSlotsForm .multi-input-grp-list .action-wrp .cmn-btn {
    width: auto;
    color: var(--white);
    padding: 15px 30px;
    background: var(--primary-clr);
    align-items: center;
    justify-content: center;
    display: inline-flex;
    gap: 10px;
    border-radius: 5px;
    border: 1px solid var(--primary-clr);
    height: 48px;
}
</style>
@section('content')
           <div class="ds-breadcrumb">
                {{-- <h1>Schedule Interview</h1> --}}
                <h1>{{ $isReschedule ? 'Reschedule' : 'Schedule' }} Interview</h1>

                <ul>
                    <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                    <li><a href="{{route('applicant.student_application_form')}}">Student Application Forms</a> /</li>
                    {{-- <li>Schedule Interview</li> --}}
                    <li>{{ $isReschedule ? 'Reschedule' : 'Schedule' }} Interview</li>

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


                        @if($isReschedule && $existingInterview)
                            <div class="ds-cmn-details-cd-outer mt-3" style="border-top: 1px solid #ddd; padding-top: 15px;">
                                <div class="ds-cmn-details-cd">
                                    <h3>Current Interview:</h3>
                                    <p>
                                        {{ \Carbon\Carbon::parse($existingInterview->interview_date)->format('d/m/Y') }} 
                                        at {{ $existingInterview->interview_time }}
                                        ({{ ucfirst($existingInterview->interview_mode) }})
                                    </p>
                                </div>
                                @if($existingInterview->interview_location)
                                <div class="ds-cmn-details-cd">
                                    <h3>Current Location:</h3>
                                    <p>{{ $existingInterview->interview_location }}</p>
                                </div>
                                @endif
                                @if($existingInterview->interview_link)
                                <div class="ds-cmn-details-cd">
                                    <h3>Current Meeting Link:</h3>
                                    <p>{{ $existingInterview->interview_link }}</p>
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>

                   <form id="searchSlotsForm">
                       @csrf
                        <div class="mb-4 align-items-end">
                            <div class="multi-input-grp-list">
                                <div class="multi-input-grp grp-3">
                                    <div class="input-grp">
                                        <label for="examDate">Select Date</label>
                                        <input type="date" name="interview_date" id="interview_date" 
                                           value="{{ $isReschedule && $existingInterview ? \Carbon\Carbon::parse($existingInterview->interview_date)->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="input-grp">
                                        <label for="examTime">Start Time</label>
                                        <input type="time" name="start_time" id="interview_start_time"
                                          value="{{ $isReschedule && $existingInterview ? $existingInterview->start_time : '' }}">
                                    </div>

                                    <div class="input-grp">
                                        <label for="endTime">End Time</label>
                                        <input type="time" name="end_time" id="interview_end_time"
                                        value="{{ $isReschedule && $existingInterview ? $existingInterview->end_time : '' }}">
                                    </div>
                                </div>
                                <div class="action-wrp">
                                    {{-- <input type="submit" value="Search"> --}}
                                  
                                   <button type="submit" class="cmn-btn ">Search</button>
                                </div>
                            </div>
                        
                        </div>
                   </form>

                    <form id="assignSlotForm">
                      @csrf
                      
                        <input type="hidden" name="applicant_id" id="applicant_id" value="{{ $applicant->id }}">
                        <input type="hidden" name="interview_date" id="assign_interview_date">
                        <input type="hidden" name="start_time" id="assign_start_time">
                        <input type="hidden" name="end_time" id="assign_end_time">
                        <input type="hidden" name="is_reschedule" id="is_reschedule" value="{{ $isReschedule ? '1' : '0' }}">

                        <input type="hidden" name="interview_mode" id="interview_mode" 
                             value="{{ $isReschedule && $existingInterview ? $existingInterview->interview_mode : 'online' }}">

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
                            
                            <div id="onlineBookedSlotsContainer">
                                <!-- Online booked Slots Section -->
                            </div>

                            <div class="interview-location-row">
                                <label class="interview-location-label" for="interview_link">Meeting Link</label>
                                <input type="text" id="interview_link" class="interview-location-input" name="interview_link" placeholder="Meeting Link" />
                            
                            </div>
                            <div class="avaiable-slots-actions">
                                <button type="button" class="cmn-btn cancel-btn" onclick="window.location.href='{{ route('applicant.student_application_form') }}'">Cancel</button>
                                {{-- <button type="submit" class="cmn-btn primary-assign-btn">Assign Slot</button> --}}
                                <button type="submit" class="cmn-btn primary-assign-btn">
                                    {{ $isReschedule ? 'Reschedule Interview' : 'Assign Slot' }}
                                </button>
                            </div>
                        </div>

                        <div class="cmn-tab-content offline-mode" id="offline-mode">
                        
                            <div id="offlineBookedSlotsContainer">
                                 <!-- Offline Mode Booked Slots Container -->
                            </div>

                            <div class="interview-location-row">
                                <label class="interview-location-label" for="interview-location">Interview Location</label>
                                <input  type="text" id="interview_location" class="interview-location-input" name="interview_location" placeholder="Location Name" />
                            
                            </div>
                            <div class="avaiable-slots-actions">
                                <button type="button" class="cmn-btn cancel-btn" onclick="window.location.href='{{ route('applicant.student_application_form') }}'">Cancel</button>
                                {{-- <button type="submit" class="cmn-btn primary-assign-btn">Assign Slot</button> --}}
                                <button type="submit" class="cmn-btn primary-assign-btn">
                                    {{ $isReschedule ? 'Reschedule Interview' : 'Assign Slot' }}
                                </button>
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
        
        // Set initial mode based on existing interview (for reschedule)
        const initialMode = "{{ $isReschedule && $existingInterview ? $existingInterview->interview_mode : 'online' }}";
        
        // Function to switch tabs
        function switchToOnlineMode() {
            onlineTab.classList.add('active');
            offlineTab.classList.remove('active');
            interviewModeInput.value = 'online';
            onlineModeDiv.style.display = 'block';
            offlineModeDiv.style.display = 'none';
        }

        function switchToOfflineMode() {
            offlineTab.classList.add('active');
            onlineTab.classList.remove('active');
            interviewModeInput.value = 'offline';
            offlineModeDiv.style.display = 'block';
            onlineModeDiv.style.display = 'none';
        }

        // Set initial mode
        if (initialMode === 'offline') {
            switchToOfflineMode();
        } else {
            switchToOnlineMode();
        }

        // Online tab click
        onlineTab.addEventListener('click', () => {
            switchToOnlineMode();
            
            // Only trigger search if form has values
            if (document.getElementById('interview_date').value) {
                searchForm.dispatchEvent(new Event('submit'));
            }
        });

        // Offline tab click
        offlineTab.addEventListener('click', () => {
            switchToOfflineMode();
            
            // Only trigger search if form has values
            if (document.getElementById('interview_date').value) {
                searchForm.dispatchEvent(new Event('submit'));
            }
        });

        // Auto-populate search form for reschedule
       @if($isReschedule && $existingInterview)
            // Set the hidden assign form fields
            document.getElementById('assign_interview_date').value = "{{ \Carbon\Carbon::parse($existingInterview->interview_date)->format('Y-m-d') }}";
            document.getElementById('assign_start_time').value = "{{ $existingInterview->start_time }}";
            document.getElementById('assign_end_time').value = "{{ $existingInterview->end_time }}";
            
            // Pre-fill meeting link or location based on current mode
            @if($existingInterview->interview_mode === 'online' && $existingInterview->interview_link)
                document.getElementById('interview_link').value = "{{ $existingInterview->interview_link }}";
            @endif
            
            @if($existingInterview->interview_mode === 'offline' && $existingInterview->interview_location)
                document.getElementById('interview_location').value = "{{ $existingInterview->interview_location }}";
            @endif
            
            // Trigger search automatically for reschedule after a short delay
            setTimeout(() => {
                if (document.getElementById('interview_date').value) {
                    document.getElementById('searchSlotsForm').dispatchEvent(new Event('submit'));
                }
            }, 500);
        @endif
    });
</script>

<script>
document.getElementById('searchSlotsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    
    // Add the current interview mode to the form data
    const interviewMode = document.getElementById('interview_mode').value;
    formData.append('interview_mode', interviewMode);

    // Determine which container to update based on current mode
    const targetContainerId = interviewMode === 'online' ? 'onlineBookedSlotsContainer' : 'offlineBookedSlotsContainer';
    const container = document.getElementById(targetContainerId);

    fetch("{{ route('applicant.fetch_interview_slots') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);
        if (data.success) {
            container.innerHTML = data.html;
            
             // Only copy values if they exist
            const interviewDate = document.getElementById('interview_date').value;
            const startTime = document.getElementById('interview_start_time').value;
            const endTime = document.getElementById('interview_end_time').value;
            
            if (interviewDate) {
                document.getElementById('assign_interview_date').value = interviewDate;
            }
            if (startTime) {
                document.getElementById('assign_start_time').value = startTime;
            }
            if (endTime) {
                document.getElementById('assign_end_time').value = endTime;
            }
            
        } else {
            container.innerHTML = `<p style="color:red;">${data.message}</p>`;
        }
    })
    .catch(error => {
        console.error('Error fetching slots:', error);
        container.innerHTML = `<p style="color:red;">Error fetching slots. Please try again.</p>`;
    });
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('assignSlotForm');
    
    //  Toast Notification Function
     function showNotification(message, type = 'success') { // Changed default to success
        // Create container if it doesn't exist
        let toastContainer = document.getElementById('notification-toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'notification-toast-container';
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }

        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        // Fixed: Only use danger for errors, success for everything else
        toast.className = `toast align-items-center text-bg-${type === 'error' ? 'danger' : 'success'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toast);
        
        // Initialize and show the toast
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 5000
        });
        bsToast.show();
        
        // Remove from DOM after hide
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    // Function to validate time range is exactly 1 hour
    function validateTimeRange(startTime, endTime) {
        if (!startTime || !endTime) return false;
        
        const start = new Date(`2000-01-01T${startTime}`);
        const end = new Date(`2000-01-01T${endTime}`);
        const diffMs = end - start;
        const diffHours = diffMs / (1000 * 60 * 60);
        
        return diffHours === 1;
    }

    // Auto-set end time when start time changes (1 hour later)
    document.getElementById('interview_start_time').addEventListener('change', function() {
        if (this.value) {
            const startTime = new Date(`2000-01-01T${this.value}`);
            const endTime = new Date(startTime.getTime() + (60 * 60 * 1000)); 
            
            // Format to HH:MM
            const endTimeString = endTime.toTimeString().slice(0, 5);
            document.getElementById('interview_end_time').value = endTimeString;
            
            // Also update the hidden fields for assign form
            document.getElementById('assign_start_time').value = this.value;
            document.getElementById('assign_end_time').value = endTimeString;
        }
    });

    // Validate end time when manually changed
    document.getElementById('interview_end_time').addEventListener('change', function() {
        const startTime = document.getElementById('interview_start_time').value;
        const endTime = this.value;
        
        if (startTime && endTime) {
            if (!validateTimeRange(startTime, endTime)) {
                showNotification('Time range must be exactly 1 hour. End time has been auto-adjusted.');
                
                // Auto-correct to 1 hour
                const start = new Date(`2000-01-01T${startTime}`);
                const correctEnd = new Date(start.getTime() + (60 * 60 * 1000));
                const correctEndString = correctEnd.toTimeString().slice(0, 5);
                
                this.value = correctEndString;
                document.getElementById('assign_end_time').value = correctEndString;
            }
        }
    });

    // Validate search form submission
    document.getElementById('searchSlotsForm').addEventListener('submit', function(e) {
        const startTime = document.getElementById('interview_start_time').value;
        const endTime = document.getElementById('interview_end_time').value;
        
        console.log("Start Time:", startTime);
        console.log("End Time:", endTime);

        if (startTime && endTime && !validateTimeRange(startTime, endTime)) {
            e.preventDefault();
            showNotification('Please select a time range of exactly 1 hour.');
            return;
        }
        
        // If validation passes, copy values to assign form
        document.getElementById('assign_interview_date').value = document.getElementById('interview_date').value;
        document.getElementById('assign_start_time').value = startTime;
        document.getElementById('assign_end_time').value = endTime;
    });

    
   // In your assignSlotForm submit handler
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate time range before submitting
        const startTime = document.getElementById('assign_start_time').value;
        const endTime = document.getElementById('assign_end_time').value;
        
        if (!validateTimeRange(startTime, endTime)) {
            showNotification('Time range must be exactly 1 hour. Please adjust your time selection.', 'error');
            return;
        }

        const formData = new FormData(this);

        const isReschedule = document.getElementById('is_reschedule').value === '1';
        const endpoint = isReschedule 
            ? "{{ route('applicant.update_interview_slot') }}"
            : "{{ route('applicant.assign_interview_slot') }}";

        console.log('Submitting to:', endpoint, 'isReschedule:', isReschedule);
        
        // Show loading state
        const submitBtn = form.querySelector('.primary-assign-btn');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = isReschedule ? 'Rescheduling...' : 'Assigning Slot...';
        submitBtn.disabled = true;

        // Use proper AJAX with better error handling
        $.ajax({
            url: endpoint,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log('Response:', data);
                    if (data.status) {
                    const successMessage = isReschedule 
                        ? 'Interview slot rescheduled successfully!' 
                        : 'Interview slot assigned successfully!';
                    
                    showNotification(data.message || successMessage, 'success');
                    
                    setTimeout(() => {
                        window.location.href = "{{ route('applicant.student_application_form') }}";
                    }, 1500);
                } else {
                    showNotification(data.message || 'Operation failed. Please try again.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
                
                let errorMessage = 'Error while assigning slot. Please try again.';
                
                // Try to parse error response
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.log("Failed to parse error response:", e);
                }
                
                showNotification(errorMessage, 'error');
            },
            complete: function() {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
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