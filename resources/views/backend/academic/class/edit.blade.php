@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
  

        {{-- bradecrumb Area S t a r t --}}
        
                <div class="ds-breadcrumb">
                    <h1 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('common.dashboard') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item"><a href="#">Classes Info</a></li>
                        <li class="breadcrumb-item">{{ ___('common.Edit class') }}</li>

                    </ul>
                </div>
          
        {{-- bradecrumb Area E n d --}}

          <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                
                                <form action="{{ route('classes.update', $classes->id) }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="new-request-form">
                                        <h3>Class Details</h3>
                                       
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="identification_number">ID</label>
                                              <input id="identification_number" name="identification_number" type="text" value="{{ old('identification_number', $classes->identification_number) }}">
                                            </div>
                                            <div class="input-grp">
                                              <label for="class_name">Class Name</label>
                                              <input id="class_name" name="class_name" type="text" value="{{ old('class_name', $classes->name) }}">
                                            </div>
                                            <div class="input-grp">
                                              <label for="abbreviation">Abbreviation</label>
                                              <input id="abbreviation" name="abbreviation" type="text" value="{{ old('abbreviation', $classes->abbreviation) }}">
                                            </div>
                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="subject_id">Subject</label>
                                             <select id="subject_id" name="subject_id" required>
                                                    <option value="">Select Subject</option>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}" {{ old('subject_id', $classes->subject_id) == $subject->id ? 'selected' : '' }}>
                                                            {{ $subject->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                              <label for="teacher_id">Teacher</label>
                                              <select id="teacher_id" name="teacher_id" required>
                                                    <option value="">Select Teacher</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $classes->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                              <label for="school_year">School Year</label>
                                              <select id="school_year_id" name="school_year_id" required>
                                                    <option value="">Select School Year</option>
                                                    @foreach($schoolYears as $year)
                                                        <option value="{{ $year->id }}" {{ old('school_year_id', $classes->school_year_id) == $year->id ? 'selected' : '' }}>
                                                            {{ $year->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                            
                                            <div class="input-grp">
                                              <label for="semester">Semster</label>
                                             <select id="semester_id" name="semester_id" required>
                                                    <option value="">Select Semester</option>
                                                    @foreach($semesters as $semester)
                                                        <option value="{{ $semester->id }}" {{ old('semester_id', $classes->semester_id) == $semester->id ? 'selected' : '' }}>
                                                            {{ $semester->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                              <label for="year_status">Year Status</label>
                                              <select id="year_status_id" name="year_status_id" required>
                                                    <option value="">Select Year Status</option>
                                                    @foreach($yearStatuses as $status)
                                                        <option value="{{ $status->id }}" {{ old('year_status_id', $classes->year_status_id) == $status->id ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          </div>
                                      
                                         
                                    </div>

                                    <div class="new-request-form">
                                        <h3>Class Times and Location</h3>

                                        <button id="add-row-btn" class="cmn-btn btn-sm">Add<img src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon"></button>
                                        <div class="add-form-element" id="schedule-wrapper">
                                           @foreach($classes->schedules as $index => $schedule)
                                                <div class="added-element-card  schedule-row" >
                                                        <span class="sl-count"></span>
                                                        <div class="multi-input-grp">
                                                            <div class="multi-input-grp">
                                                                <div class="input-grp">
                                                                    <select name="schedules[{{ $index }}][day]" class="day-select">
                                                                        <option value="">Select Day</option>
                                                                        @foreach(\App\Enums\Days::all() as $day)
                                                                            <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>
                                                                                {{ $day }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="input-grp">
                                                                    <select name="schedules[{{ $index }}][period]" class="period-select">
                                                                        <option value="">Select Period</option>
                                                                        <option value="1" {{ $schedule->period == 1 ? 'selected' : '' }}>Period 1</option>
                                                                        <option value="2" {{ $schedule->period == 2 ? 'selected' : '' }}>Period 2</option>
                                                                        <option value="3" {{ $schedule->period == 3 ? 'selected' : '' }}>Period 3</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="multi-input-grp">
                                                            <div class="multi-input-grp">
                                                                <div class="input-grp">
                                                                    @php
                                                                            
                                                                            $times = [];
                                                                            $start = Carbon\Carbon::createFromTime(8, 0); // 8:00 AM
                                                                            $end   = Carbon\Carbon::createFromTime(18, 0); // 6:00 PM
                                                                            while ($start <= $end) {
                                                                                $times[] = $start->format('h:i A');
                                                                                $start->addMinutes(30);
                                                                            }

                                                                            $formattedStart = $schedule->start_time ? Carbon\Carbon::parse($schedule->start_time)->format('h:i A') : '';
                                                                            $formattedEnd   = $schedule->end_time ? Carbon\Carbon::parse($schedule->end_time)->format('h:i A') : '';
                                                                    @endphp   

                                                                    <select name="schedules[{{ $index }}][start_time]" class="start-time-select">
                                                                        <option value="">Start Time</option>
                                                                        @foreach($times as $time)
                                                                            <option value="{{ $time }}" {{ $formattedStart == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="input-grp">
                                                                    <select name="schedules[{{ $index }}][end_time]" class="end-time-select">
                                                                        <option value="">End Time</option>
                                                                        @foreach($times as $time)
                                                                            <option value="{{ $time }}" {{ $formattedEnd == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="multi-input-grp">
                                                            <div class="multi-input-grp">
                                                                <div class="input-grp">
                                                                    <select name="schedules[{{ $index }}][room_id]" class="room-select">
                                                                            <option value="">Select Room</option>
                                                                            @foreach($rooms as $room)
                                                                                <option value="{{ $room->id }}" {{ $schedule->room_id == $room->id ? 'selected' : '' }}>
                                                                                    {{ $room->room_no }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="added-elm-actions btn-grp">
                                                            <button type="submit" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon"> Edit</button>
                                                            <button type="submit" class="cmn-btn btn-sm delete-row-btn">Delete</button>
                                                        </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                        <div class="multi-input-grp grp-3">
                                           <div class="input-grp checkbox">
                                                <input id="is_class_for_scheduling"
                                                    name="is_class_for_scheduling"
                                                    type="checkbox"
                                                    value="1"
                                                    {{ old('is_class_for_scheduling', $class->is_class_for_scheduling ?? 0) ? 'checked' : '' }}>
                                                <label>Class is for scheduling purpose only (no grades or attendance)</label>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="new-request-form" id="class-specifications">
                                        <h3>Class Specifications</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="credits">Credits</label>
                                                <input id="credits" name="credits" type="text"   value="{{ old('credits', $classes->subject->credits ?? '') }}" readonly>
                                                
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="allowed_absences">Allow Absence</label>
                                                <input id="allowed_absences" name="allowed_absences" type="text" value="{{ old('allowed_absences', $classes->subject->allowed_absences ?? '') }}" readonly>
                                               
                                            </div>

                                            <div class="input-grp">
                                                <label for="allowed_penalty_amount">Allow Penalty Amount</label>
                                                <input id="allowed_penalty_amount" name="allowed_penalty_amount" type="text"  value="{{ old('allowed_penalty_amount', $classes->subject->allowed_penalty_amount ?? '') }}" readonly>
                                              
                                            </div>

                                            <div class="input-grp">
                                                <label for="number_latenesses_equal_absence">Number of Latenesses Equal to One Absence</label>
                                                <input id="number_latenesses_equal_absence" name="number_latenesses_equal_absence" type="text" value="{{ old('number_latenesses_equal_absence', $classes->subject->number_latenesses_equal_absence ?? '') }}" readonly>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Attendance % Auto Fail <input id="attendance_percent_auto_fail" name="attendance_percent_auto_fail" type="checkbox"  value="1" 
                                                    {{ old('attendance_percent_auto_fail', $classes->subject->attendance_percent_auto_fail ?? 0) ? 'checked' : '' }} > </label>
                                               
                                            </div>

                                            <div class="input-grp checkbox">
                                                <label>Hebrew Attendance <input id="hebrew_attendance" name="hebrew_attendance" type="checkbox" value="1" 
                                                  {{ old('hebrew_attendance', $classes->subject->hebrew_attendance ?? 0) ? 'checked' : '' }}   > </label>
                                               
                                            </div>
                                            
                                            <div class="input-grp checkbox">
                                                <label>Report Card <input id="report_card" name="report_card" type="checkbox" value="1"
                                                    {{ old('report_card', $classes->subject->report_card ?? 0) ? 'checked' : '' }} > </label>
                                               
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="attendance_percent_amount">Attendance % Amount</label>
                                                <input id="attendance_percent_amount" name="attendance_percent_amount" type="text"  value="{{ old('attendance_percent_amount', $classes->subject->attendance_percent_amount ?? '') }}" readonly>
                                                
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="attendance_percent_fail_grade">Attendance % Fail Grade</label>
                                                <input id="attendance_percent_fail_grade" name="attendance_percent_fail_grade" type="text"  value="{{ old('attendance_percent_fail_grade', $classes->subject->attendance_percent_fail_grade ?? '') }}"  readonly>
                                               
                                            </div>

                                            <div class="input-grp">
                                                <label for="gpa_weight">GPA Weight</label>
                                                <input id="gpa_weight" name="gpa_weight" type="text" value="{{ old('gpa_weight', $classes->subject->gpa_weight ?? '') }}" readonly>
                                               
                                            </div>

                                            <div class="input-grp">
                                                <label for="prec_rc">Precedence on Report Card</label>
                                                <input id="prec_rc" name="prec_rc" type="text" placeholder="Enter Precedence"  value="{{ old('prec_rc', $classes->subject->prec_rc ?? '') }}" readonly>
                                               
                                            </div>

                                            <div class="input-grp">
                                                <label for="transcript_name">Transcript Name</label>
                                                <input id="transcript_name" name="transcript_name" type="text" placeholder="Enter Transcript Name" value="{{ old('transcript_name', $classes->subject->transcript_name ?? '') }}" >
                                                
                                            </div>

                                            <div class="input-grp">
                                                <label for="course_number">Transcript Course Number</label>
                                                <input id="course_number" name="course_number" type="text" placeholder="Enter Course Number"  value="{{ old('course_number', $classes->subject->course_number ?? '') }}">
                                                
                                            </div>

                                            <div class="input-grp checkbox">
                                                <label>College Transcript <input id="college_transcript" name="college_transcript" type="checkbox" value="1" 
                                                     {{ old('college_transcript', $classes->subject->college_transcript ?? 0) ? 'checked' : '' }}> </label>
                                                
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="prec_transcript">Precedence on Transcript</label>
                                                <input id="prec_transcript" name="prec_transcript" type="text" placeholder="Enter Precedence"  value="{{ old('prec_transcript', $classes->subject->prec_transcript ?? '') }}" readonly>
                                               
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Chartered Oak Transcript <input id="charter_oak_transcript" name="charter_oak_transcript" type="checkbox" value="1"
                                                  {{ old('charter_oak_transcript', $classes->subject->charter_oak_transcript ?? 0) ? 'checked' : '' }}  > </label>
                                               
                                            </div>

                                            <div class="input-grp checkbox">
                                                <label>Chartered Oak Year Long <input id="co_year_long" name="co_year_long" type="checkbox" value="1"
                                                     {{ old('co_year_long', $classes->subject->co_year_long ?? 0) ? 'checked' : '' }} > </label>
                                               
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="co_department">Chartered Oak Department</label>
                                                <input id="co_department" name="co_department" type="text" placeholder="Enter Department" value="{{ old('co_department', $classes->subject->co_department ?? '') }}">
                                                
                                            </div>
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Elective <input id="elective" name="elective" type="checkbox"  value="1" 
                                                     {{ old('elective', $classes->subject->elective ?? 0) ? 'checked' : '' }}> </label>
                                                
                                            </div>
                                          
                                        </div>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label> Composite Average <input id="composite_average" name="composite_average" type="checkbox"  value="1" 
                                                    {{ old('composite_average', $classes->composite_average ?? 0) ? 'checked' : '' }}> </label>
                                            </div>
                                           
                                        </div>

                                         <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="">Composite Class 1</label>
                                                <input id="composite_class_1" name="composite_class_1" type="text"  value="{{ old('composite_class_1', $classes->subject->composite_class_1 ?? '') }}" >
                                               
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Composite Class 2</label>
                                                <input id="composite_class_2" name="composite_class_2" type="text" value="{{ old('composite_class_2', $classes->subject->composite_class_2 ?? '') }}"  >
                                               
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Composite Class 1 Weight</label>
                                                <input id="composite_class_1_weight" name="composite_class_1_weight" type="text" value="{{ old('composite_class_1_weight', $classes->subject->composite_class_1_weight ?? '') }}"  >
                                               
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Composite Class 2 Weight</label>
                                                <input id="composite_class_2_weight" name="composite_class_2_weight" type="text" value="{{ old('composite_class_2_weight', $classes->subject->composite_class_2_weight ?? '') }}"  >
                                               
                                            </div>
                                           
                                        </div>

                                        <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Comment</label>
                                                <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Enter Comments">{{ old('comment', $classes->subject->comment ?? '') }}</textarea>
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
                                                        @foreach($availableStudents as $student)
                                                            <option value="{{ $student->id }}"
                                                                data-first_name="{{ $student->first_name }}"
                                                                data-last_name="{{ $student->last_name }}"
                                                                data-homeroom="{{ $student->homeroom_class }}"
                                                                data-division="{{ $student->division }}"
                                                                data-group="{{ $student->group }}"
                                                                data-studentid="{{ $student->student_identifier }}">
                                                                {{ $student->first_name }} {{ $student->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                            </div>
                                         <button type="button" id="add-student-btn" class="cmn-btn btn-sm">Add <img src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon"></button>

                                       </div>
                                        <div class="add-form-element">
                                          @foreach($classes->students as $index => $student)
                                            <div class="added-element-card"   data-student-id="{{ $student->id }}">
                                                <input type="hidden" name="student_ids[]" value="{{ $student->id }}">

                                                <span class="sl-count"></span>
                                                <div class="multi-input-grp">
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <input id="" name="" type="text"  value="{{ $student->first_name }} {{ $student->last_name }}"  readonly>
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
                                                            <input id="" name="" type="text" value="{{ $student->student_code }}" readonly>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="added-elm-actions btn-grp">
                                                    {{-- <button type="submit" class="cmn-btn btn-sm"><img src="../../images/edit-icon.svg" alt="Icon"> Edit</button> --}}
                                                    <button type="submit" class="cmn-btn btn-sm remove-student-btn">Delete</button>
                                                </div>
                                            </div>
                                          @endforeach
                                           
                                        </div>
                                    </div>

                                    <div class="form-submission btn-sm align-right">
                                        {{-- <input type="submit" value="Save Class"> --}}
                                        <button type="submit" class="cmn-btn btn-sm">Save Class</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

          </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scheduleWrapper = document.getElementById('schedule-wrapper');
            const addBtn = document.getElementById('add-row-btn');

            // Find highest existing index in edit mode
            let scheduleIndex = scheduleWrapper.querySelectorAll('.schedule-row').length - 1;

            addBtn.addEventListener('click', function (e) {
                e.preventDefault();
                scheduleIndex++;

                // Clone first row as template
                let templateRow = scheduleWrapper.querySelector('.schedule-row');
                let newRow = templateRow.cloneNode(true);

                // Reset values in cloned row
                newRow.querySelectorAll('select').forEach(select => select.value = '');

                // Update name attributes with new index
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
      $(document).ready(function() {
            const getSubjectJsonUrl = "{{ route('classes.getSubjectJson', ['id' => '__ID__']) }}";

            const $checkbox = $('#is_class_for_scheduling');
            const $subjectInput = $('#subject_id');
            const $specWrapper = $('#class-specifications');
            const $specInputs = $specWrapper.find('input, textarea, select');

            function toggleClassSpecs() {
                const isSchedulingOnly = $checkbox.is(':checked');
                
                // Toggle readonly for text inputs and disabled for other inputs
                $specInputs.each(function() {
                    const $input = $(this);
                    if ($input.attr('type') === 'text' || $input.is('textarea')) {
                        $input.prop('readonly', isSchedulingOnly);
                    } else if ($input.attr('type') === 'checkbox') {
                        $input.prop('disabled', isSchedulingOnly);
                    } else if ($input.is('select')) {
                        $input.prop('disabled', isSchedulingOnly);
                    }
                });
                
                // Visual indication
                if (isSchedulingOnly) {
                    $specWrapper.addClass('disabled-section');
                } else {
                    $specWrapper.removeClass('disabled-section');
                }
            }

            function populateClassSpecs(subjectId) {
                if (!subjectId || $checkbox.is(':checked')) return;

                const url = getSubjectJsonUrl.replace('__ID__', subjectId);
                $.get(url, function(data) {
                    console.log('Subject Data:', data);
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
                }).fail(function(err) {
                    console.error('Error fetching subject data:', err);
                });
            }

            // === INITIAL LOAD FOR EDIT MODE ===
            toggleClassSpecs();
            
            // For edit mode: when subject changes, populate from new subject
            // But preserve existing data if already loaded
            $subjectInput.on('change', function() {
                if (!$checkbox.is(':checked')) {
                    populateClassSpecs($(this).val());
                }
            });

            // Checkbox change
            $checkbox.on('change', function() {
                toggleClassSpecs();
                
                // If unchecking and subject is selected, populate from subject
                if (!$(this).is(':checked') && $subjectInput.val()) {
                    populateClassSpecs($subjectInput.val());
                }
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student-select');
    const addStudentBtn = document.getElementById('add-student-btn');
    const studentsWrapper = document.getElementById('students-wrapper');

    // Add new student
    addStudentBtn.addEventListener('click', function() {
        const selectedOption = studentSelect.options[studentSelect.selectedIndex];
        
        if (!selectedOption.value) {
            alert('Please select a student');
            return;
        }

        // Check if student is already added
        const existingStudents = studentsWrapper.querySelectorAll('[data-student-id]');
        const isAlreadyAdded = Array.from(existingStudents).some(el => 
            el.getAttribute('data-student-id') === selectedOption.value
        );

        if (isAlreadyAdded) {
            alert('This student is already in the class');
            return;
        }

        // Create new student row
        const row = document.createElement('div');
        row.classList.add('added-element-card');
        row.setAttribute('data-student-id', selectedOption.value);
        
        row.innerHTML = `
            <input type="hidden" name="student_ids[]" value="${selectedOption.value}">
            <div class="multi-input-grp">
                <div class="input-grp">
                    <input type="text" value="${selectedOption.dataset.first_name} ${selectedOption.dataset.last_name}" readonly>
                </div>
                <div class="input-grp">
                    <input type="text" value="${selectedOption.dataset.homeroom}" readonly>
                </div>
            </div>
            <div class="multi-input-grp">
                <div class="input-grp">
                    <input type="text" value="${selectedOption.dataset.division}" readonly>
                </div>
                <div class="input-grp">
                    <input type="text" value="${selectedOption.dataset.group}" readonly>
                </div>
            </div>
            <div class="multi-input-grp">
                <div class="input-grp">
                    <input type="text" value="${selectedOption.dataset.studentid}" readonly>
                </div>
            </div>
            <div class="added-elm-actions btn-grp">
                <button type="button" class="cmn-btn btn-sm remove-student-btn">Delete</button>
            </div>
        `;

        studentsWrapper.appendChild(row);
        
        // Remove from dropdown
        selectedOption.remove();
        
        // Reset select to first option
        studentSelect.selectedIndex = 0;
    });

    // Remove student (event delegation for dynamically added elements)
    studentsWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-student-btn')) {
            const row = e.target.closest('.added-element-card');
            const studentId = row.getAttribute('data-student-id');
            
            // Add back to dropdown (you might want to implement this)
            // addBackToDropdown(studentId, row);
            
            row.remove();
        }
    });

    // Optional: Function to add student back to dropdown
    function addBackToDropdown(studentId, row) {
        // You would need to store the original option data
        // This is a simplified version - you might want to implement
        // a more robust solution that stores the original option data
    }
});
    </script>
@endpush
