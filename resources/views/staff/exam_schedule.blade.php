@extends('staff.master')
<style>
    .time-select-group {
    display: flex;
    gap: 5px;
}

.req-time {
    width: 80px !important;
}

#room-loading {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.req-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

@section('content')
    <div class="ds-breadcrumb">
        <h1>Exam Schedule</h1>
        <ul>
          <li><a href="{{ route('staff.dashboard') }}">Dashboard</a> /</li>
          <li>Exam Schedule</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="atndnc-filter-wrp w-100 dn-for-non-active">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter">
                <form>
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options flex-row">
                            <!-- Subject Multi‑Select Dropdown -->
                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">Select Year</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att" />
                                </button>
                                <div class="dropdown-menu">
                                    <label>
                                        <input type="checkbox" value="all" checked /> All Subjects
                                    </label>
                                    <label>
                                        <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                    </label>
                                    <label>
                                        <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                    </label>
                                    <label>
                                        <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                    </label>
                                </div>
                            </div>

                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">Select Year Status</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att" />

                                </button>
                                <div class="dropdown-menu">
                                    <label>
                                        <input type="checkbox" value="all" checked /> All Subjects
                                    </label>
                                    <label>
                                        <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                    </label>
                                    <label>
                                        <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                    </label>
                                    <label>
                                        <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                    </label>
                                </div>
                            </div>

                            <!-- Year/Month Picker Dropdown -->
                            <div class="dropdown subject-dropdown selectisub">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">Select Semester</span>
                                    <img src="{{ asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att" />

                                </button>
                                <div class="dropdown-menu">
                                    <label>
                                        <input type="checkbox" value="all" checked /> All Subjects
                                    </label>
                                    <label>
                                        <input type="checkbox" value="1" /> Lorem ipsum dolor sit amet
                                    </label>
                                    <label>
                                        <input type="checkbox" value="2" /> Lorem ipsum dolor sit amet
                                    </label>
                                    <label>
                                        <input type="checkbox" value="3" /> Lorem ipsum dolor sit amet
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="ds-cmn-table-wrp table-width tab-wrapper">

            <div class="exam-type-div">
                <!-- <div class="examtype-text-btn"><span class="upcoming">Upcoming Examination</span> <span class="requested">Requested Examination</span></div> -->
                <div class="cmn-tab-head">
                    <ul>
                        <li class="tab-bg"></li>
                        <li class="tab-switch active" data-tab="current-tab">Upcoming Examination</li>
                        <li class="tab-switch chng-fltr" data-tab="closed-tab">Requested Examination</li>
                    </ul>
                </div>
                <div class="exam-last-div">
                    <p class="exm-req addExamRequest">+ Add Exam Request</p>
                    <div class="dropdown-container-sub dn-for-non-active">
                        <p class="allsub" id="dropdownToggle">
                            All Subjects
                            <span><img src="{{ asset('staff/assets/images/arrow-white-up.svg')}}" id="dropdownArrow-sub" /></span>
                        </p>
                        <ul class="dropdown-menu-sub" id="dropdownMenu-sub">
                            <li>All Subjects</li>
                            <li>My Subjects</li>
                        </ul>
                    </div>

                    <p class="download-list">Download List</p>
                </div>
            </div>
            <div class="input-grp exm-type-dropdown dn-for-non-active">
                <select>
                    <option value="select">Exam Type</option>
                    {{-- <option value="all">All Subjects</option>
                    <option value="my-subjects">My Subjects</option> --}}
                    @foreach ($examTypes as $examType) 
                        <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                        
                    @endforeach
                </select>
            </div>

           
            <table class="ds-cmn-tble">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                        <th>Room No.</th>
                        <th>Marks(Max..)</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- <tr>
                        <td>1</td>
                        <td>Lorem ipsum dolor sit amet</td>
                        <td>04/02/2025</td>
                        <td>09:30:30</td>
                        <td>10:30:30</td>
                        <td>90</td>
                        <td>12</td>
                        <td>100</td>

                    </tr> --}}

                    
                    @forelse($upcomingExams as $index => $upcoming_exam)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $upcoming_exam->subject->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($upcoming_exam->exam_date)->format('d/m/Y') }}</td>
                            <td>{{ $upcoming_exam->start_time }}</td>
                            <td>{{ $upcoming_exam->end_time }}</td>
                            <td>{{ $upcoming_exam->duration }} mins</td>
                            <td>{{ $upcoming_exam->room->room_no ?? '-' }}</td>
                            <td>{{ $upcoming_exam->marks ?? '100' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">No upcoming exams.</td>
                        </tr>
                    @endforelse
                  
                </tbody>
            </table>

            <table class="ds-cmn-tble">
                <thead>
                    <tr>
                        <th>S. No </th>
                        <th>Exam Type</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Room No.</th>
                        <th>Duration</th>
                        <th>Marks(Max.)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                  

                   
                    @forelse($requestedExams as $index => $requested_exam)
                    
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $requested_exam->examType->name ?? 'N/A' }}</td>
                            <td>{{ $requested_exam->subject->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($requested_exam->exam_date)->format('m/d/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($requested_exam->start_time)->format('H:i') }} </td>
                            <td>{{ \Carbon\Carbon::parse($requested_exam->end_time)->format('H:i') }}</td>
                            <td>{{ $requested_exam->room->room_no ?? '-' }}</td>
                            <td>{{ $requested_exam->duration }} mins</td>
                            <td>{{ $requested_exam->marks ?? '100' }}</td>
                           <td>
                                @if($requested_exam->status == \App\Enums\ExamRequestStatus::PENDING)
                                    <span style="color:orange;">Pending</span>
                                @elseif($requested_exam->status == \App\Enums\ExamRequestStatus::UPDATED)
                                    <span style="color:green;">Updated</span>
                                @elseif($requested_exam->status == \App\Enums\ExamRequestStatus::REJECTED)
                                    <span style="color:red;">Rejected</span>
                                @else
                                    <span style="color:gray;">{{ $requested_exam->status->value ?? 'Unknown' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center;">No requested exams.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

           
        </div>
    </div>

    
<!-- popup request exam-->
    <div class="request-overlay" style="display: none;">
        <div class="request-modal">
            <form id="exam-request-form">
                @csrf

                
                <p class="request-heading">Request Exam <span><img src="{{asset('staff/assets/images/reqCross.svg')}}" class="requestClose" /></span></p>

                <div class="req-type">
                    <p class="req-exam">Exam Type</p>
                    <p>
                        {{-- <input type="text" class="req-box" placeholder="Select Exam Type"/> --}}

                        <select class="req-box exam-type-select"  name="exam_type_id" required>
                            <option value="">Select Exam Type</option>
                            @foreach($examTypes as $examType)
                                <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                            @endforeach
                        </select>

                        <span>
                            <img src="{{asset('staff/assets/images/dropdown-arrowpopup.svg')}}" class="req-arrow"/>
                        </span>
                    </p>
                </div>

                <div class="req-align">
                    <div class="req-type">
                        <p class="req-exam">Subject</p>
                        <p>
                            {{-- <input type="text" class="req-box" placeholder="Select Subject"/> --}}
                            <select class="req-box subject-select" name="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <span>
                                <img src="{{asset('staff/assets/images/dropdown-arrowpopup.svg')}}" class="req-arrow"/>
                            </span>
                        </p>
                    </div>

                    <div class="req-type">
                        <p class="req-exam">Exam Date *</p>
                        <p>
                            <input type="text" class="req-box" id="exam-date" name="exam_date" placeholder="mm-dd-yyyy"  required/>
                            <span><img src="{{asset('staff/assets/images/reqCal.svg')}}" class="req-arrow"/></span>
                        </p>
                    </div>
                </div>

                <div class="req-align-date">
                    <!-- START TIME -->
                    <div class="req-type">
                        <p class="req-exam">Start Time *</p>
                        <div class="time-select-group">
                            <select class="req-box req-time hour-dropdown start-hour"  name="start_hour" required>
                            {{-- <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option> --}}
                            </select>
                            <select class="req-box req-time minute-dropdown start-minute" name="start_minute" required>
                            {{-- <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option> --}}
                            </select>
                            <select class="req-box req-time ampm-dropdown start-ampm" name="start_ampm" required>
                            {{-- <option>AM</option>
                            <option>PM</option> --}}
                            </select>
                        </div>
                        
                    </div>

                    <!-- END TIME -->
                    <div class="req-type">
                        <p class="req-exam">End Time *</p>
                        <div class="time-select-group">
                            <select class="req-box req-time hour-dropdown end-hour" name="end_hour" required>
                            {{-- <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option> --}}
                            </select>
                            <select class="req-box req-time minute-dropdown end-minute" name="end_minute" required>
                            {{-- <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option> --}}
                            </select>
                            <select class="req-box req-time ampm-dropdown end-ampm" name="end_ampm" required>
                            {{-- <option>AM</option>
                            <option>PM</option> --}}
                            </select>
                        </div>

                        
                    </div>
                </div>

                <div class="req-type">
                    <p class="req-exam">Room *</p>
                    <p>
                        {{-- <input type="text" class="req-box" class="datepick" placeholder="Select Room"/> --}}
                        <select class="req-box room-select" id="room-select" name="room_id" required disabled>
                            <option value="">Select Date and Time first</option>
                            
                        </select>
                        <span>
                            <img src="{{asset('staff/assets/images/dropdown-arrowpopup.svg')}}" class="req-arrow"/>
                        </span>
                    </p>
                    <div id="room-loading" style="display: none;">Checking available rooms...</div>

                </div>

                <button  type="submit" class="req-btn">Request</button>

            </form>    
        </div>
    </div>
<!-- popup request exam-->
@endsection

@push('script')
 <script>
    $(document).ready(function () {
        $("#exam-date").datepicker({
        dateFormat: "mm-dd-yy", // Matches your placeholder
        changeMonth: true,
        changeYear: true,
        
        });
    });
</script>
<script>

//    document.addEventListener('DOMContentLoaded', function () {
//        document.querySelector('.upcoming').classList.add('active');

//         document.querySelector('.upcoming').addEventListener('click', function () {
//             document.querySelector('.upcoming').classList.add('active');
//             document.querySelector('.requested').classList.remove('active');

//             document.getElementById('upcomingContainer').style.display = 'block';
//             document.getElementById('requestedContainer').style.display = 'none';
//         });

//         document.querySelector('.requested').addEventListener('click', function () {
//             document.querySelector('.requested').classList.add('active');
//             document.querySelector('.upcoming').classList.remove('active');

//             document.getElementById('upcomingContainer').style.display = 'none';
//             document.getElementById('requestedContainer').style.display = 'block';
//         });

//     });


</script>
<script>
   function populateHours(selector) {
        let select = document.querySelector(selector);
        select.innerHTML = "";
        // Add empty option first
        let emptyOpt = new Option("HH", "");
        select.add(emptyOpt);
        for (let i = 1; i <= 12; i++) {
            let value = i.toString().padStart(2, "0");
            let opt = new Option(value, value);
            select.add(opt);
        }
    }

   function populateMinutes(selector) {
        let select = document.querySelector(selector);
        select.innerHTML = "";
        // Add empty option first
        let emptyOpt = new Option("MM", "");
        select.add(emptyOpt);
        for (let i = 0; i < 60; i++) {
            let value = i.toString().padStart(2, "0");
            let opt = new Option(value, value);
            select.add(opt);
        }
    }

    // Populate AM/PM
    function populateAmpm(selector) {
        let select = document.querySelector(selector);
        select.innerHTML = "";
        // Add empty option first
        let emptyOpt = new Option("AM/PM", "");
        select.add(emptyOpt);
        ["AM", "PM"].forEach(val => {
            let opt = new Option(val, val);
            select.add(opt);    
        });
    }

    // Call for all dropdowns
    document.addEventListener("DOMContentLoaded", function () {
        populateHours(".start-hour");
        populateHours(".end-hour");

        populateMinutes(".start-minute");
        populateMinutes(".end-minute");

        populateAmpm(".start-ampm");
        populateAmpm(".end-ampm");
    });
</script>


<script>
    class ExamScheduler {
        constructor() {
            this.debounceTimer = null;
            this.bindEvents();
        }

        bindEvents() {
            $('#exam-date, .start-hour, .start-minute, .start-ampm, .end-hour, .end-minute, .end-ampm').on('change', () => {
                this.debouncedCheckRoomAvailability();
            });

            $('#exam-request-form').on('submit', (e) => {
                e.preventDefault();
                this.submitExamRequest();
            });
        }

        debouncedCheckRoomAvailability() {
            if (this.debounceTimer) {
                clearTimeout(this.debounceTimer);
            }
            this.debounceTimer = setTimeout(() => {
                this.checkRoomAvailability();
            }, 500);
        }

        areTimeFieldsFilled() {
            const startHour = $('.start-hour').val();
            const startMinute = $('.start-minute').val();
            const startAmPm = $('.start-ampm').val();
            const endHour = $('.end-hour').val();
            const endMinute = $('.end-minute').val();
            const endAmPm = $('.end-ampm').val();
            return startHour && startMinute && startAmPm && endHour && endMinute && endAmPm;
        }

        getFormattedTime() {
            const startTime = this.formatTime(
                $('.start-hour').val(),
                $('.start-minute').val(),
                $('.start-ampm').val()
            );
            
            const endTime = this.formatTime(
                $('.end-hour').val(),
                $('.end-minute').val(),
                $('.end-ampm').val()
            );

            return { startTime, endTime };
        }

        formatTime(hour, minute, ampm) {
            let hourInt = parseInt(hour);
            if (ampm === 'PM' && hourInt !== 12) {
                hourInt += 12;
            } else if (ampm === 'AM' && hourInt === 12) {
                hourInt = 0;
            }
            return `${String(hourInt).padStart(2, '0')}:${minute}:00`;
        }

        async checkRoomAvailability() {
            const examDateInput = $('#exam-date').val();
            const examDate = this.formatDateForBackend(examDateInput);
            
            if (!examDate || !this.areTimeFieldsFilled()) {
                $('#room-select').html('<option value="">Select Date and complete all Time fields</option>');
                $('#room-select').prop('disabled', true);
                return;
            }

            const { startTime, endTime } = this.getFormattedTime();

            if (startTime >= endTime) {
                $('#room-select').html('<option value="">End time must be after start time</option>');
                $('#room-select').prop('disabled', true);
                return;
            }

            // Show loading
            $('#room-loading').show();
            $('#room-select').prop('disabled', true);

            try {
                const response = await $.ajax({
                    url: '{{route("staff.my-classes.available-rooms")}}',
                    method: 'GET',
                    data: {
                        exam_date: examDate,
                        start_time: startTime,
                        end_time: endTime
                    }
                });

                if (response.success) {
                    this.populateRooms(response.rooms);
                } else {
                    showError('Failed to fetch available rooms');
                    $('#room-select').html('<option value="">Error loading rooms</option>');
                }
            } catch (error) {
                console.error('Error fetching rooms:', error);
                showError('Error checking room availability');
                $('#room-select').html('<option value="">Error loading rooms</option>');
            } finally {
                $('#room-loading').hide();
            }
        }

        formatDateForBackend(dateString) {
            if (!dateString) return '';
            const parts = dateString.split('-');
            if (parts.length === 3) {
                const [month, day, year] = parts;
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            }
            
            return dateString;
        }

        populateRooms(rooms) {
            const roomSelect = $('#room-select');
            roomSelect.empty();

            if (rooms.length === 0) {
                roomSelect.append('<option value="">No rooms available for selected time</option>');
                roomSelect.prop('disabled', true);
            } else {
                roomSelect.append('<option value="">Select a room</option>');
                rooms.forEach(room => {
                    roomSelect.append(
                       $('<option>', {
                            value: room.id,
                            text: `Room ${room.room_no}`
                        })
                    );
                });
                roomSelect.prop('disabled', false);
            }
        }

        closeModal() {
            $('.request-modal').hide();
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('body').css('padding-right', '0');
        }

      async submitExamRequest()
      {
            const data = {
                exam_type_id: $('.exam-type-select').val(),
                subject_id: $('.subject-select').val(),
                class_id: $('.class-select').val(),
                room_id: $('#room-select').val(),
                exam_date: this.formatDateForBackend($('#exam-date').val()),
                _token: $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            };

            const { startTime, endTime } = this.getFormattedTime();
            data.start_time = startTime;
            data.end_time = endTime;

            if (!this.validateForm(data)) {
                return;
            }

            $('.req-btn').prop('disabled', true).text('Submitting...');

            try {
                const response = await $.ajax({
                    url: '{{route("staff.my-classes.store_exam_request")}}',
                    method: 'POST',
                    data: data,
                    
                });

                 if (response.success) {
                    showSuccess(response.message);
                    this.resetForm();
                    this.closeModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showError(response.message);
                }
            } catch (error) {
                console.error('Error submitting request:', error);
                const errorMessage = error.responseJSON?.message || 'Failed to submit exam request';
                showError(errorMessage);
            } finally {
                $('.req-btn').prop('disabled', false).text('Request');
            }
        }

        validateForm(data)
        {
            if (!data.exam_type_id || !data.subject_id  || 
                !data.exam_date || !data.room_id) {
                showError('Please fill all required fields');
                return false;
            }

            if (!this.areTimeFieldsFilled()) {
                showError('Please complete all time fields');
                return false;
            }

            const { startTime, endTime } = this.getFormattedTime();
            if (startTime >= endTime) {
                showError('End time must be after start time');
                return false;
            }

            return true;
        }
        

        resetForm() {
            document.getElementById('exam-request-form').reset();
            $('#room-select').html('<option value="">Select Date and Time first</option>');
            $('#room-select').prop('disabled', true);
        }
    }

    $(document).ready(function() {
        setTimeout(() => {
            window.examScheduler = new ExamScheduler();
        }, 100);
        
        $('.requestClose').on('click', function() {
            $('.request-modal').hide();
        });
    });
</script>



@endpush