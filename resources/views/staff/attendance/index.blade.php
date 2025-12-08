@extends('staff.master')

@section('title')
    {{ @$data['title'] }}
@endsection


@section('content')

<!-- Dashboard Body Begin -->

<div class="dashboard-body dspr-body-outer">

    <div class="ds-breadcrumb">
        <h1>Attendance</h1>
        <ul>
            <li><a href="{{ route('staff.dashboard') }}">Dashboard</a> /</li>
            <li>Attendance </li>
        </ul>
    </div>

    <div class="ds-pr-body">

        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>

            <div class="atndnc-filter">
                <form id="attendanceFilterForm">
                    @csrf
                    <div class="atndnc-filter-form">

                        <div class="atndnc-filter-options">

                            <div class="header-filter">
                                
                                <!-- Class Dropdown -->
                                <div class="dropdown subject-dropdown selectisub">
                                    <button type="button" class="dropdown-toggle">
                                        <span class="label">Select Class</span>
                                        <img src="{{ asset('staff') }}/assets/images/down-arrow-5.svg" class="arrow-att"/>
                                    </button>
                                    <div class="dropdown-menu">
                                        @forelse($classes as $class)
                                            <label class="dropdown-item" data-id="{{ $class->id }}">
                                                {{ $class->name }}
                                            </label>
                                        @empty
                                            <label class="dropdown-item">No classes available</label>
                                        @endforelse
                                    </div>
                                    <input type="hidden" name="class_id" id="class_id" value="">
                                </div>

                                <!-- Subject Dropdown -->
                                <div class="dropdown subject-dropdown selectisub">
                                    <button type="button" class="dropdown-toggle">
                                        <span class="label">Select Subject</span>
                                        <img src="{{ asset('staff') }}/assets/images/down-arrow-5.svg" class="arrow-att"/>
                                    </button>
                                    <div class="dropdown-menu">
                                        @forelse($subjects as $subject)
                                            <label class="dropdown-item" data-id="{{ $subject->id }}">
                                                {{ $subject->name }}
                                            </label>
                                        @empty
                                            <label class="dropdown-item">No subjects available</label>
                                        @endforelse
                                    </div>
                                    <input type="hidden" name="subject_id" id="subject_id" value="">
                                </div>
                            
                                <!-- Year/Month Picker Dropdown -->
                                <p class="calender-open">
                                    <input type="text" id="datepicker" name="attendance_date" class="calenderDate" value="{{ \Carbon\Carbon::now()->format('F d, Y') }}" style="width: 200px !important">
                                    <img class="calimage" src="{{ asset('staff') }}/assets/images/cal.svg" />
                                </p>

                            </div>
                                                      
                            </div>
                        </div>
                    
                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div> 

        </div>

        <div class="ds-pr-body" style=" padding-top: 0;">
            <div class="ds-cmn-table-wrp">
                <h2 class="att-text">Attendance</h2>
                    <div class="submit-align" id="attendanceTableContainer">
                        
                    </div>
            </div>
        </div>

    </div>

</div>


<div class="modal fade cmn-popwrp pop600" id="addCommentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <img src="{{ asset('staff') }}/assets/images/cross-icon.svg" alt="Icon">
                </span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Add Comment</h2>
                    <div class="request-leave-form-wrp">
                        <form>
                            <div class="request-leave-form">
                                <div class="input-grp">
                                    <textarea id="commentTextarea" placeholder="Write your comment..."></textarea>
                                </div>
                                <input type="submit" value="Save" class="btn-sm" id="saveCommentBtn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- End Of Dashboard Body -->

@endsection

@push('script')

<script>

    $(document).ready(function() {

        // Track which students teacher actually clicked TODAY
        let clickedStudents = new Set();

        // Initialize datepicker
        $("#datepicker").datepicker({
            dateFormat: "MM d, yy",
            onSelect: function(dateText) {
                clickedStudents.clear(); // Reset when date changes
                loadAttendance();
            }
        });

        // Auto-select first class and subject
        function setDefaultSelections() {
            if ($('.selectisub').first().find('.dropdown-item').length > 0) {
                $('.selectisub').each(function() {
                    let firstItem = $(this).find('.dropdown-item').first();
                    let labelText = firstItem.text().trim();
                    let itemId = firstItem.data('id');
                    $(this).find('.label').text(labelText);
                    $(this).find('input[type="hidden"]').val(itemId);
                });
            }
        }

        // Dropdown handlers
        $('.dropdown-item').on('click', function() {
            let text = $(this).text().trim();
            let id = $(this).data('id');
            let dropdown = $(this).closest('.dropdown');
            dropdown.find('.label').text(text);
            dropdown.find('input[type="hidden"]').val(id);
            dropdown.find('.dropdown-menu').removeClass('show');
            if ($('#class_id').val() && $('#subject_id').val()) {
                clickedStudents.clear(); // Reset clicks when filters change
                loadAttendance();
            }
        });

        $('.dropdown-toggle').on('click', function(e) {
            e.stopPropagation();
            $(this).next('.dropdown-menu').toggleClass('show');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // Load attendance
        function loadAttendance() {
            let classId = $('#class_id').val();
            let subjectId = $('#subject_id').val();
            let date = $('#datepicker').val();

            if (!classId || !subjectId || !date) {
                $('#attendanceTableContainer').html('<p>Please select class, subject, and date.</p>');
                return;
            }

            $.ajax({
                url: '{{ route("staff.attendance.load") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    class_id: classId,
                    subject_id: subjectId,
                    attendance_date: date
                },
                beforeSend: function() {
                    $('#attendanceTableContainer').html('<p>Loading attendance...</p>');
                },
                success: function(response) {
                    $('#attendanceTableContainer').html(response);
                    clickedStudents.clear(); // Reset after loading new data
                },
                error: function() {
                    $('#attendanceTableContainer').html('<p>Error loading attendance.</p>');
                }
            });
        }

        $('#attendanceFilterForm').on('submit', function(e) {
            e.preventDefault();
            loadAttendance();
        });

        // Auto-load on page load
        setDefaultSelections();
        loadAttendance();

        // TRACK REAL CLICKS ONLY
        $(document).on('change', '.attendance-radio', function() {
            // If it's locked (rejected leave) or disabled (approved leave) → ignore
            if ($(this).is(':disabled') || $(this).closest('.att-label').css('pointer-events') === 'none') {
                return;
            }
            let studentId = $(this).data('student');
            clickedStudents.add(studentId);
        });

        // SUBMIT ONLY REAL CHANGES
        $(document).on('click', '#submitAttendanceBtn', function() {
            const classId = $('#current_class_id')?.val() || $('#class_id').val();
            const selectedDate = $('#datepicker').val();

            if (!classId || !selectedDate) {
                showWarning('Please select class and date.');
                return;
            }

            if (clickedStudents.size === 0) {
                showWarning('No changes made. Nothing to submit.');
                return;
            }

            let attendanceData = [];

            $('.attendance-radio:checked').each(function() {
                let studentId = $(this).data('student');
                if (clickedStudents.has(studentId)) {
                    attendanceData.push({
                        student_id: studentId,
                        attendance: $(this).val()
                    });
                }
            });

            $('#submitAttendanceBtn').prop('disabled', true).text('Saving...');

            $.ajax({
                url: '{{ route("staff.attendance.save") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    class_id: classId,
                    attendance_date: selectedDate,
                    attendance: attendanceData
                },
                success: function() {
                    showSuccess('Attendance saved successfully!');
                    clickedStudents.clear();
                    loadAttendance();
                },
                error: function(xhr) {
                    showError('Error: ' + (xhr.responseJSON?.message || 'Failed to save'));
                },
                complete: function() {
                    $('#submitAttendanceBtn').prop('disabled', false).text('Submit');
                }
            });
        });

    });


    let currentStudentId = null;
    let isSavingComment = false;   // ← This flag stops double execution

    $(document).on('click', '.comment-pencil', function() {
        currentStudentId = $(this).data('student');
        $('#commentTextarea').val($(this).data('comment') || '');
    });

    // Keep your form submit handler exactly as you want
    $('#addCommentModal form').on('submit', function(e) {
        e.preventDefault();     
        $('#saveCommentBtn').click();   // ← You wanted this line – it stays!
    });

    // Main save handler – with protection against double call
    $(document).on('click', '#saveCommentBtn', function() {
        if (isSavingComment) return;        // ← Blocks double execution
        isSavingComment = true;

        const comment = $('#commentTextarea').val().trim();
        const classId = $('#current_class_id').val();
        const date    = $('#current_date_formatted').val();

        $.ajax({
            url: '{{ route("staff.report.attendance.save-comment") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                class_id: classId,
                student_id: currentStudentId,
                date: date,
                comment: comment
            },
            success: function() {
                showSuccess('Comment saved!');
                $('#addCommentModal').modal('hide');
                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function() {
                showError('Failed to save comment');
            },
            complete: function() {
                isSavingComment = false;    // ← Re-allow next save
            }
        });
    });

</script>


@endpush
