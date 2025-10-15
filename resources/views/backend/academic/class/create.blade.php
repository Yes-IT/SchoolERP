@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
                     <div class="ds-breadcrumb">
                        <h1>Classes</h1>
                        <ul>
                            <li><a href="../dashboard.html">Dashboard</a> /</li>
                            <li><a href="{{route('classes.index')}}">Classes</a> /</li>
                            <li><a href="./profile.html">Classes Info</a> /</li>
                            <li>Add Class</li>
                        </ul>
                        <button  class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                    <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                <form  action="{{ route('classes.store') }}" method="POST">
                                    @csrf
                                    <div class="new-request-form">
                                        <h3>Class Details</h3>
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input type="text" id="identification_number" name="identification_number"  placeholder="ID"  value="{{ $nextClassId }}"  readonly >
                                            </div>
                                            <div class="input-grp">
                                              <label for="class_name">Class Name</label>
                                              <input type="text" id="class_name" name="class_name"  placeholder="Class Name">
                                            </div>
                                            <div class="input-grp">
                                              <label for="abbreviation">Abbreviation</label>
                                              <input  type="text" id="abbreviation" name="abbreviation"  placeholder="Abbreviation">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="subject">Subject</label>
                                              <select id="subject" name="subject_id" required>
                                                <option>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                            <div class="input-grp">
                                              <label for="diploma_name">Teacher</label>
                                               <select id="teacher" name="teacher_id" required>
                                                    <option>Select Teacher</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">
                                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                              <label for="school_year">School Year</label>
                                              <select id="school_year" name="school_year_id" required>
                                                    <option>School Year</option>
                                                    @foreach($sessions as $year)
                                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                                    @endforeach
                                              </select>
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="semester">Semster</label>
                                                <select id="semester" name="semester_id" required>
                                                    <option value="">Semester</option>
                                                    @foreach($semesters as $semester)
                                                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                                <label for="year_status">Year Status</label>
                                                <select id="year_status" name="year_status_id" required>
                                                    <option value="">Year Status</option>
                                                    @foreach($yearStatuses as $status)
                                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                        <h3>Class Times and Location</h3>

                                        <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>
                                        <div class="add-form-element" id="schedule-wrapper">

                                            <div class="added-element-card schedule-row">
                                                <span class="sl-count"></span>
                                                <div class="multi-input-grp input-grp-5">
                                                    <div class="input-grp">
                                                       <select name="schedules[0][day]" class="day-select">
                                                            <option value="">Select Day</option>
                                                            @foreach(\App\Enums\Days::all() as $day)
                                                                <option value="{{ $day }}">{{ $day }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                       <select name="schedules[0][period]" class="period-select">
                                                            <option value="">Select Period</option>
                                                            <option value="1">Period 1</option>
                                                            <option value="2">Period 2</option>
                                                            <option value="3">Period 3</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <select name="schedules[0][start_time]" class="start-time-select">
                                                            <option value="">Start Time</option>
                                                            <option value="09:00 AM">09:00 AM</option>
                                                            <option value="10:00 AM">10:00 AM</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <select name="schedules[0][end_time]" class="end-time-select">
                                                            <option value="">End Time</option>
                                                            <option value="09:00 AM">09:00 AM</option>
                                                            <option value="10:00 AM">10:00 AM</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <select name="schedules[0][room_id]" class="room-select">
                                                            <option value="">Select Room</option>
                                                            @foreach($rooms as $room)
                                                                <option value="{{ $room->id }}">{{ $room->room_no }}</option>
                                                            @endforeach
                                                        </select>


                                                        
                                                    </div>

                                                </div>
                                                <div class="added-elm-actions btn-grp">
                                                    <button type="submit" class="cmn-btn btn-sm"><img
                                                                src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon"> Edit</button>
                                                    <button type="submit" class="cmn-btn btn-sm delete-row-btn">Delete</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                              <input id="is_class_for_scheduling" name="is_class_for_scheduling" type="checkbox"><label>Class is for scheduling purpose only (no grades or attendance) </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="class-specifications">
                                        <h3>Class Specifications</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="credits">Credits</label>
                                                <input id="credits" name="credits" type="text" placeholder="Enter Credits">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="allowed_absences">Allow Absence</label>
                                                <input id="allowed_absences" name="allowed_absences" type="text" placeholder="Enter Allowed Absences">
                                            </div>

                                            <div class="input-grp">
                                                <label for="allowed_penalty_amount">Allow Penalty Amount</label>
                                                <input id="allowed_penalty_amount" name="allowed_penalty_amount" type="text" placeholder="Enter Penalty Amount"  > 
                                            </div>

                                            <div class="input-grp">
                                                <label for="number_latenesses_equal_absence">Number of Latenesses Equal to One Absence</label>
                                                <input id="number_latenesses_equal_absence" name="number_latenesses_equal_absence" type="text" placeholder="Enter Number" >
                                            </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Attendance % Auto Fail <input id="attendance_percent_auto_fail" name="attendance_percent_auto_fail" type="checkbox" > </label>
                                            </div>

                                            <div class="input-grp checkbox">
                                                <label>Hebrew Attendance <input id="hebrew_attendance" name="hebrew_attendance" type="checkbox"> </label>
                                            </div>
                                            
                                            <div class="input-grp checkbox">
                                                <label>Report Card <input id="report_card" name="report_card" type="checkbox" > </label>
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="attendance_percent_amount">Attendance % Amount</label>
                                                <input id="attendance_percent_amount" name="attendance_percent_amount" type="text" placeholder="Enter Attendance Percentage"  > 
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="attendance_percent_fail_grade">Attendance % Fail Grade</label>
                                                <input id="attendance_percent_fail_grade" name="attendance_percent_fail_grade" type="text" placeholder="Enter Fail Grade" >
                                            </div>

                                            <div class="input-grp">
                                                <label for="gpa_weight">GPA Weight</label>
                                                <input id="gpa_weight" name="gpa_weight" type="text" placeholder="Enter GPA Weight" >  
                                            </div>

                                            <div class="input-grp">
                                                <label for="prec_rc">Precedence on Report Card</label>
                                                <input id="prec_rc" name="prec_rc" type="text" placeholder="Enter Precedence" >
                                            </div>

                                            <div class="input-grp">
                                                <label for="transcript_name">Transcript Name</label>
                                                <input id="transcript_name" name="transcript_name" type="text" placeholder="Enter Transcript Name"  >
                                            </div>

                                            <div class="input-grp">
                                                <label for="course_number">Transcript Course Number</label>
                                                <input id="course_number" name="course_number" type="text" placeholder="Enter Course Number"  >
                                            </div>

                                            <div class="input-grp checkbox">
                                                <label>College Transcript <input id="college_transcript" name="college_transcript" type="checkbox" > </label>
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="prec_transcript">Precedence on Transcript</label>
                                                <input id="prec_transcript" name="prec_transcript" type="text" placeholder="Enter Precedence" >
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Chartered Oak Transcript <input id="charter_oak_transcript" name="charter_oak_transcript" type="checkbox" > </label>
                                            </div>

                                            <div class="input-grp checkbox">
                                                <label>Chartered Oak Year Long <input id="co_year_long" name="co_year_long" type="checkbox" > </label>
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="co_department">Chartered Oak Department</label>
                                                <input id="co_department" name="co_department" type="text" placeholder="Enter Department" >
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Elective <input id="elective" name="elective" type="checkbox" ></label> 
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label> Composite Average <input id="composite_average" name="composite_average" type="checkbox" > </label>
                                            </div>
                                        </div>

                                         <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="composite_class_1">Composite Class 1</label>
                                                <input id="composite_class_1" name="composite_class_1" type="text" placeholder="Composite Class 1"  >
                                               
                                            </div>
                                            <div class="input-grp">
                                                <label for="composite_class_2">Composite Class 2</label>
                                                <input id="composite_class_2" name="composite_class_2" type="text" placeholder="Composite Class 2"  >
                                               
                                            </div>
                                            <div class="input-grp">
                                                <label for="composite_class_1_weight">Composite Class 1 Weight</label>
                                                <input id="composite_class_1_weight" name="composite_class_1" type="text" placeholder="Composite Class 1"  >
                                               
                                            </div>
                                            <div class="input-grp">
                                                <label for="composite_class_2_weight">Composite Class 2 Weight</label>
                                                <input id="composite_class_2_weight" name="composite_class_2" type="text" placeholder="Composite Class 1"  >
                                               
                                            </div>
                                           
                                        </div>

                                        <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Comment</label>
                                                <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Enter Comments"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                       
                                         <div class="sec-head">
                                           <h3>Students in this class</h3>
                                           <a href="#" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Assign Students</a>
                                        </div>
                                        
                                       <div class="multi-input-grp">
                                            <div class="input-grp">
                                                  <select id="student-select" name="student_id">
                                                        <option value="">Select Student</option>
                                                        @foreach($students as $student)
                                                            <option value="{{ $student->id }}"
                                                                data-first_name="{{ $student->first_name }}"
                                                                data-last_name="{{ $student->last_name }}"
                                                                data-homeroom="{{ $student->homeroom_class }}"
                                                                data-division="{{ $student->division }}"
                                                                data-group="{{ $student->group }}"
                                                                data-studentid="{{ $student->student_id }}"
                                                            >
                                                                {{ $student->first_name }} {{ $student->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>  
                                            </div>
                                           <button type="button" id="add-student-btn" class="cmn-btn btn-sm">Add <img src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon"></button>
                                       </div>

                                        {{-- <div class="add-form-element">

                                            <div class="added-element-card">
                                                <span class="sl-count"></span>
                                                <div class="multi-input-grp">
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <input id="" name="" type="text" placeholder="Student Name"  >
                                                        </div>
                                                        <div class="input-grp">
                                                            <input id="" name="" type="text" placeholder="Homeroom Class"  >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="multi-input-grp">
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <input id="" name="" type="text" placeholder="Division"  >
                                                        </div>
                                                        <div class="input-grp">
                                                            <input id="" name="" type="text" placeholder="Group"  >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="multi-input-grp">
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <input id="" name="" type="text" placeholder="ID"  >
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="added-elm-actions btn-grp">
                                                   
                                                    <button type="submit" class="cmn-btn btn-sm">Delete</button>
                                                </div>
                                            </div>
                                           
                                        </div> --}}

                                        <div id="students-wrapper">
                                        </div>

                                    </div>

                                    <div class="form-submission btn-sm align-right">
                                        <button type="submit" class="cmn-btn btn-sm">Save Class</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let scheduleIndex = 0;
        const scheduleWrapper = document.getElementById('schedule-wrapper');
        const addBtn = document.getElementById('add-row-btn');

        addBtn.addEventListener('click', function (e) {
            e.preventDefault();
            scheduleIndex++;

            let newRow = scheduleWrapper.querySelector('.schedule-row').cloneNode(true);
            
            // Reset values in cloned row
            newRow.querySelectorAll('select').forEach(select => select.value = '');

            // Update name attributes to use new index
            newRow.querySelectorAll('select').forEach(select => {
                select.name = select.name.replace(/\[\d+\]/, `[${scheduleIndex}]`);
            });

            scheduleWrapper.appendChild(newRow);
        });

        // Event delegation for delete buttons
        scheduleWrapper.addEventListener('click', function (e) {
            if (e.target.closest('.delete-row-btn')) {
                e.preventDefault();
                const row = e.target.closest('.schedule-row');
                if (scheduleWrapper.querySelectorAll('.schedule-row').length > 1) {
                    row.remove();
                }
            }
        });
    });
</script>


<script>

    document.getElementById('add-student-btn').addEventListener('click', function () {
        const select = document.getElementById('student-select');
        const selected = select.options[select.selectedIndex];

        if (!selected.value) return;

        // console.log(selected);
        console.log(selected.dataset);
        // Create a new row
        let wrapper = document.getElementById('students-wrapper');

        let row = document.createElement('div');
        row.classList.add('added-element-card');
        row.innerHTML = `
            <input type="hidden" name="student_ids[]" value="${selected.value}">
            <div class="multi-input-grp">
                <div class="input-grp">
                <input type="text" value="${selected.dataset.first_name} ${selected.dataset.last_name}" readonly>
                </div>
                <div class="input-grp">
                <input type="text" value="${selected.dataset.homeroom}" placeholder="Homeroom Class" readonly>
                </div>
            </div>
            <div class="multi-input-grp">
                <div class="input-grp">
                <input type="text" value="${selected.dataset.division}" placeholder="Division" readonly>
                </div>
                <div class="input-grp">
                <input type="text" value="${selected.dataset.group}" placeholder="Group" readonly>
                </div>
            </div>
            <div class="multi-input-grp">
                <div class="input-grp">
                <input type="text" value="${selected.dataset.studentid}" readonly>
                </div>
            </div>
            <div class="added-elm-actions btn-grp">
                <button type="button" class="cmn-btn btn-sm remove-student-btn">Delete</button>
            </div>
        `;
        wrapper.appendChild(row);

        // Remove from dropdown so we don't add twice
        select.remove(select.selectedIndex);
    });

</script>


<script>

    $(document).ready(function() {
        // Define the URL for fetching subject data
        const getSubjectJsonUrl = "{{ route('classes.getSubjectJson', ['id' => '__ID__']) }}"; // Adjust route name as needed

        const $checkbox = $('#is_class_for_scheduling');
        const $subjectInput = $('#subject'); // Note: ID is 'subject' not 'subject_id'
        const $specWrapper = $('#class-specifications');
        const $specInputs = $specWrapper.find('input, textarea, select');

        // Function to enable/disable Class Specifications
        function toggleClassSpecs() {
            const isSchedulingOnly = $checkbox.is(':checked');
            
            // If checkbox IS checked (scheduling only), DISABLE specs
            // If checkbox is NOT checked (regular class), ENABLE specs
            $specInputs.prop('disabled', isSchedulingOnly);
            
            // Visual feedback
            if (isSchedulingOnly) {
                $specWrapper.addClass('disabled-section');
            } else {
                $specWrapper.removeClass('disabled-section');
            }
        }

        // Function to prepopulate Class Specifications from subject
        function populateClassSpecs(subjectId) {
            if (!subjectId || subjectId === '') return;

            const url = getSubjectJsonUrl.replace('__ID__', subjectId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('data in populate class specs:', data);
                    $specInputs.each(function() {
                        const $input = $(this);
                        const name = $input.attr('name');
                        
                        if (data.hasOwnProperty(name)) {
                            if ($input.attr('type') === 'checkbox') {
                                $input.prop('checked', Boolean(data[name]));
                            } else {
                                $input.val(data[name] ?? '');
                            }
                        }
                    });
                },
                error: function(err) {
                    console.error('Error fetching subject data:', err);
                }
            });
        }

        // Initial setup on page load
        toggleClassSpecs();

        // Prepopulate on page load if checkbox NOT checked (regular class)
        if (!$checkbox.is(':checked') && $subjectInput.val()) {
            populateClassSpecs($subjectInput.val());
        }

        // Event: When checkbox changes
        $checkbox.on('change', function() {
            toggleClassSpecs();
            
            // If checkbox is being UNchecked (switching to regular class), prepopulate
            if (!$checkbox.is(':checked') && $subjectInput.val()) {
                populateClassSpecs($subjectInput.val());
            }
        });

        // Event: When subject changes
        $subjectInput.on('change', function() {
            // Only prepopulate if checkbox is NOT checked (regular class)
            if (!$checkbox.is(':checked')) {
                populateClassSpecs($(this).val());
            }
        });
    });
</script>

@endpush
