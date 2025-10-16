@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

     <div class="ds-breadcrumb">
                <h1>Check Availability</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="{{route('exam-schedule.createExamScheduleType')}}">Exam Schedule</a> /</li>
                    <li>Check Availability</li>
                </ul>
            </div>
            <div class="ds-pr-body tab-wrapper">
                
                <div class="ds-cmn-table-wrp">
                    <div class="ds-cmn-upr-wrp gr-bg">
                        <h2>Exam Request Details</h2>
                        <div class="ds-cmn-details-cd-outer justify-content-between mb-3">
                            <div class="ds-cmn-details-cd">
                                <h3>Exam Type:</h3>
                                {{-- <p>Mid-Term</p> --}}
                               <p>{{ $examRequest->examType->name ?? 'N/A' }}</p>

                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Class:</h3>
                                {{-- <p>Class Name</p> --}}
                                <p>{{ $examRequest->class->name ?? 'N/A' }}</p>

                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Subject:</h3>
                                <p>{{ $examRequest->subject->name ?? 'N/A' }}</p>
                            </div>
                            <div class="ds-cmn-details-cd">
                                <h3>Teacher:</h3>
                                <p>{{ $examRequest->teacherName ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="ds-cmn-white-label-txt">
                            <i class="fa-solid fa-location-dot"></i>
                            Requested: Room
                             {{ $examRequest->room->room_no ?? 'N/A' }} 
                            at {{ $examRequest->start_time?->format('h:i A') }} 
                            - {{ $examRequest->end_time?->format('h:i A') }}
                        </div>
                    </div>

                    <form class="availability-form-container"
                       method="POST"
                       action="{{ route('exam-schedule.assignExam', $examRequest->id) }}">
                       @csrf

                        <div class="mb-4 align-items-end">
                            <div class="multi-input-grp">
                                <div class="input-grp">
                                    <label for="examDate">Date</label>
                                    <input type="date" name="exam_date" id="examDate"  value="{{ $examRequest->exam_date->format('Y-m-d') }}">
                                </div>
                                <div class="input-grp">
                                    <label for="examTime">Start Time</label>
                                    <input type="time" name="start_time" id="examTime" value="{{ $examRequest->start_time->format('H:i') }}">
                                </div>

                                <div class="input-grp">
                                    <label for="endTime">End Time</label>
                                    <input type="time" name="end_time" id="endTime" 
                                        value="{{ $examRequest->end_time->format('H:i') }}">
                                </div>
                            </div>
                            <div class="input-grp has-btn">
                                <label for="studentCount">Total Number of Students</label>
                                <input type="number"  name="total_students" id="studentCount" value="50">
                                <button type="button" class="cmn-btn btn-sm">Auto Distribute</button>
                            </div>
                        </div>

                        <div class="cmn-tab-content online-mode">
                            <div class="cmn-tab-content-head">
                                <h3>Available Slots</h3>
                                {{-- <button type="button">View Details</button> --}}
                                <a href="{{route('exam-schedule.roomAvailability')}}">View Details</a>
                            </div>
                        
                            {{-- <div class="avaiable-slots-cd-wrp">
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
                            </div> --}}

                             <div class="avaiable-slots-cd-wrp">
                                    @if($availableRooms->count() > 0)
                                        <div class="available-slots-form">
                                            <div class="avaiable-slots-cd-grid" id="roomSelectionGrid">
                                                @foreach($availableRooms as $room)
                                                <div class="avaiable-slots-cd" data-room="{{ $room->id }}">
                                                    <label for="room-{{ $room->id }}" tabindex="0">
                                                        <span class="avlble-slot-date">Room {{ $room->room_no }}</span>
                                                        <span class="avlble-slot-time">Capacity: {{ $room->capacity }} students</span>
                                                        <span class="avlble-slot-location">{{ $room->location ?? 'Main Building' }}</span>
                                                    </label>
                                                    <input id="room-{{ $room->id }}" type="checkbox" 
                                                        name="selected_rooms[]" value="{{ $room->id }}"
                                                        data-capacity="{{ $room->capacity }}"
                                                        onchange="toggleRoomDistribution(this)">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            No available rooms found for the selected date and time.
                                        </div>
                                    @endif
                                </div>
                        </div>

                        {{-- <div >
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="section-heading mb-3">Student Distribution</h4>
                                <div class="distribution-summary">
                                    <span class="me-3" ><strong>Allocated:</strong> 0 / 34</span>
                                    <span><strong>Capacity:</strong> 50</span>
                                </div>
                            </div>

                            <div class="distribution-item">
                                <div class="room-name">Room 101</div>
                                <div class="student-input-wrapper">
                                    <input type="number" class="form-control text-center" value="25">
                                    <i class="fas fa-sync-alt reset-icon"></i>
                                </div>
                                <div class="utilization-label">Utilization</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="capacity-info">Capacity: 50 <span class="percent ms-2">50%</span></div>
                            </div>

                            <div class="distribution-item">
                                <div class="room-name">Room 202</div>
                                <div class="student-input-wrapper">
                                    <input type="number" class="form-control text-center" value="25">
                                    <i class="fas fa-sync-alt reset-icon"></i>
                                </div>
                                <div class="utilization-label">Utilization</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="capacity-info">Capacity: 50 <span class="percent ms-2">50%</span></div>
                            </div>
                            
                        </div> --}}


                          <!-- Student Distribution Section -->
                        <div id="distributionSection" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="section-heading">Student Distribution</h4>
                                <div class="distribution-summary">
                                    <span class="me-3">
                                        <strong>Required:</strong> 
                                        <span id="requiredStudents">{{ $examRequest->class->student_count ?? 'N/A' }}</span>
                                    </span>
                                    <span>
                                        <strong>Allocated:</strong> 
                                        <span id="totalAllocated">0</span>
                                    </span>
                                </div>
                            </div>

                            <div id="roomDistributionContainer">
                                <!-- Dynamic room distribution inputs will appear here -->
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cmn-btn btn-sm" onclick="window.history.back()">Cancel</button>
                            <button type="submit" class="cmn-btn btn-sm"  id="submitBtn" disabled>Submit</button>
                        </div>
                    </form>
  
                </div>
                  
            </div>

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    window.toggleRoomDistribution = function(checkbox) {
        const distributionSection = document.getElementById('distributionSection');
        const roomDistributionContainer = document.getElementById('roomDistributionContainer');
        
        if (checkbox.checked) {
            addRoomDistribution(checkbox);
            distributionSection.style.display = 'block';
        } else {
            removeRoomDistribution(checkbox.value);
        }
        
        updateSubmitButton();
        updateAllocationSummary();
    };

    function addRoomDistribution(checkbox) {
        const roomId = checkbox.value;
        const roomNo = checkbox.closest('.avaiable-slots-cd').querySelector('.avlble-slot-date').textContent;
        const capacity = parseInt(checkbox.dataset.capacity);
        
        // Check if already added
        if (document.querySelector(`[name="rooms[${roomId}][room_id]"]`)) {
            return;
        }

        const distributionItem = document.createElement('div');
        distributionItem.className = 'distribution-item';
        distributionItem.id = `room-dist-${roomId}`;
        distributionItem.innerHTML = `
            <div class="room-name">${roomNo}</div>
            <div class="student-input-wrapper">
                <input type="number" 
                       name="rooms[${roomId}][allocated_students]" 
                       class="form-control text-center room-student-input" 
                       min="1" max="${capacity}" 
                       value="0"
                       oninput="updateAllocationSummary()"
                       required>
                <i class="fas fa-sync-alt reset-icon" onclick="resetRoomInput('${roomId}')"></i>
            </div>
            <input type="hidden" name="rooms[${roomId}][room_id]" value="${roomId}">
            <div class="utilization-label">Utilization</div>
            <div class="progress">
                <div class="progress-bar" id="progress-${roomId}" role="progressbar" 
                     style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="capacity-info">
                Capacity: ${capacity} 
                <span class="percent ms-2" id="percent-${roomId}">0%</span>
            </div>
        `;
        
        roomDistributionContainer.appendChild(distributionItem);
        
        // Add input event listener for utilization
        const input = distributionItem.querySelector('.room-student-input');
        input.addEventListener('input', function() {
            updateRoomUtilization(this, roomId, capacity);
        });
    }

    function removeRoomDistribution(roomId) {
        const element = document.getElementById(`room-dist-${roomId}`);
        if (element) {
            element.remove();
        }
        
        // Hide distribution section if no rooms selected
        const selectedRooms = document.querySelectorAll('input[name="selected_rooms[]"]:checked');
        if (selectedRooms.length === 0) {
            document.getElementById('distributionSection').style.display = 'none';
        }
    }

    window.updateRoomUtilization = function(input, roomId, capacity) {
        const studentCount = parseInt(input.value) || 0;
        const percentage = Math.min((studentCount / capacity) * 100, 100);
        
        document.getElementById(`progress-${roomId}`).style.width = `${percentage}%`;
        document.getElementById(`percent-${roomId}`).textContent = `${Math.round(percentage)}%`;
    };

    window.updateAllocationSummary = function() {
        const inputs = document.querySelectorAll('.room-student-input');
        const totalAllocated = Array.from(inputs).reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);
        const requiredStudents = parseInt(document.getElementById('requiredStudents').textContent) || totalAllocated;
        
        document.getElementById('totalAllocated').textContent = totalAllocated;
        
        // Update color based on allocation status
        const summaryElement = document.getElementById('totalAllocated');
        if (totalAllocated >= requiredStudents) {
            summaryElement.style.color = 'green';
        } else {
            summaryElement.style.color = 'orange';
        }
    };

    window.resetRoomInput = function(roomId) {
        const input = document.querySelector(`[name="rooms[${roomId}][allocated_students]"]`);
        if (input) {
            input.value = 0;
            window.updateRoomUtilization(input, roomId, parseInt(input.max));
            updateAllocationSummary();
        }
    };

    function updateSubmitButton() {
        const selectedRooms = document.querySelectorAll('input[name="selected_rooms[]"]:checked').length;
        const submitBtn = document.getElementById('submitBtn');
        
        submitBtn.disabled = selectedRooms === 0;
    }

    // Initialize if there are pre-selected rooms (for edit scenarios)
    document.querySelectorAll('input[name="selected_rooms[]"]:checked').forEach(checkbox => {
        toggleRoomDistribution(checkbox);
    });
});
</script>
    
@endpush