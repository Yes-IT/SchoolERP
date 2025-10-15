@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        
        <div class="ds-breadcrumb">
            <h1>Assignment</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li>Assignment</li>
            </ul>
        </div>

        <div class="ds-pr-body">
            <div class="dsbdy-filter-wrp p-0">
                <div class="dropdown-year" data-selected="Select Student">
                    <div class="dropdown-trigger" aria-expanded="false" data-selected="">
                        <span class="dropdown-label">View Assignments</span>
                        <i class="dropdown-arrow"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option selected" data-value="assignmentsOverview">View Assignments</div>
                        <div class="dropdown-option" data-value="pendingAssignments">Assignments Request</div>
                    </div>
                </div>
            </div>
            
            <div class="atndnc-filter-wrp w-100">
                <div class="sec-head">
                    <h2>Select Criteria</h2>
                </div>
                <div class="atndnc-filter student-filter">
                    <form>
                        <div class="atndnc-filter-form">
                            <div class="atndnc-filter-options grp-3 multi-input-grp">
                                <div class="input-grp">
                                    <select name="year_id" id="year_id">
                                        <option value="">Select Year</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select name="year_status_id" id="year_status_id">
                                            <option value="">Select Year Status</option>
                                            @foreach($yearStatuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select name="semester_id" id="semester_id">
                                        <option value="">Select Semester</option>
                                        @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select name="class_id" id="class_id">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select name="subject_id" id="subject_id">
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <input type="text" name="dates" value="">
                                </div>
                            </div>
                            <!-- Search Button -->
                            <button type="submit" class="btn-search">Search</button>
                        </div>
                    </form>
                </div> 
            </div>

            <div class="ds-cmn-table-wrp">
                <!-- Assignments Overview Table -->
                <div id="assignmentsOverview" class="table-container">
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Assignments Overview</h2>
                        </div>
                    </div>
                    <div class="ds-cmn-tble count-row" id="ViewAssignmentTableContainer">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Subject</th>
                                    <th>Assignment Title</th>
                                    <th>Assigned Date</th>
                                    <th>Due Date</th>
                                    <th>Created by</th>
                                    <th>Submission</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                    <th>Evaluation Details</th>
                                </tr>
                            </thead>
                            <tbody>
                              

                                 @forelse($assignments as $index => $assignment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assignment->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $assignment->creator->name ?? 'N/A' }}</td>
                                    <td>
                                        {{ $assignment->submitted_count }} / {{ $assignment->total_students }}
                                    </td>
                                    <td>{{ $assignment->grade ?? '-' }}</td>
                                    <td>
                                        <button class="view-attachment-btn view-assignment" 
                                                data-bs-target="#assignmentActions" 
                                                data-bs-toggle="modal"
                                                data-id="{{ $assignment->id }}">
                                            <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="View">
                                        </button>
                                    </td>
                                    <td>
                                        <button class="view-attachment-btn evaluation-details" 
                                                data-bs-target="#evaluationDetails" 
                                                data-bs-toggle="modal"
                                                data-id="{{ $assignment->id }}">
                                            <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="Details">
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No assignments found.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                        <!-- Table will be loaded here via AJAX -->

                    </div>
                </div>

                <!-- Pending Assignments Request Table -->
                <div id="pendingAssignments" class="table-container" style="display: none;">
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Pending Assignments Request</h2>
                        </div>
                    </div>
                    <div class="ds-cmn-tble count-row">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Requested Date</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Assignment Title</th>
                                    <th>Due Date</th>
                                    <th>Created by</th>
                                    <th>Assignment Details</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Lorem</td>
                                    <td>Lorem</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td>50</td>
                                    <td>
                                        <button class="view-attachment-btn" data-bs-target="#PendingAssignmentAttachments" data-bs-toggle="modal">
                                            <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                        </button>
                                    </td>
                                </tr>
                            </tbody> --}}

                            <tbody>
                                @forelse($pendingAssignments as $index => $assignment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $assignment->created_at ? $assignment->created_at->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $assignment->class->name ?? '-' }}</td>
                                        <td>{{ $assignment->subject->name ?? '-' }}</td>
                                        <td>{{ $assignment->title ?? '-' }}</td>
                                        <td>{{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $assignment->creator->name ?? '-' }}</td>
                                        <td>
                                            <button class="view-attachment-btn"
                                                    data-id="{{ $assignment->id }}"
                                                    data-bs-target="#PendingAssignmentAttachments"
                                                    data-bs-toggle="modal">
                                                <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="View">
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No pending assignments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="tablepagination">
                    <div class="tbl-pagination-inr">
                        <ul>
                            <li><a href="#url"><img src="{{ asset('backend/assets/images/arrow-left.svg') }}" alt="Icon"></a></li>
                            <li class="active"><a href="#url">1</a></li>
                            <li><a href="#url">2</a></li>
                            <li><a href="#url">3</a></li>
                            <li><a href="#url"><img src="{{ asset('backend/assets/images/arrow-right.svg') }}" alt="Icon"></a></li>
                        </ul>
                    </div>
                    <div class="pages-select">
                        <form>
                            <div class="formfield">
                                <label>Per page</label>
                                <select>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </form>
                        <p>of 2 results</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- viewAttachedDocs Modal Begin -->

        <div class="modal fade cmn-popwrp pop800 links" id="assignmentActions" tabindex="-1" role="dialog" aria-labelledby="assignmentActions" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('backend/assets/images/cross-icon.svg') }}" alt="Icon"></span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2>Assignment Title</h2>
                            </div>

                            <div class="cmn-pop-inr-content-wrp">
                                <div class="assigment-dtls-cd-inner">
                                    <div class="assigment-meta-grid">
                                    <div class="meta-item">
                                        <div class="meta-label">Class</div>
                                        <div class="meta-value">Lorem Ipsum</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Subject</div>
                                        <div class="meta-value">Lorem Ipsum</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Due Date</div>
                                        <div class="meta-value">2024-01-22</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Created By</div>
                                        <div class="meta-value">Lorem Ipsum</div>
                                    </div>
                                    </div>
                                
                                    <div class="assignment-description">
                                        <div class="meta-label">Description</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                
                                    <div class="assignment-attachments">
                                        <div class="meta-label">Attachments</div>
                                        <div class="attachments-list">
                                            <a href="/path/to/Doc_0481.jpg" class="attachment-btn cmn-btn btn-sm" download>
                                                <span class="attachment-icon"><i class="fa-regular fa-file-image"></i></span>
                                                <span class="attachment-name">Doc_0481.jpg</span>
                                                <span class="attachment-action"><i class="fa-solid fa-download"></i></span>
                                            </a>
                                            <a href="/path/to/Doc_0481.pdf" class="attachment-btn cmn-btn btn-sm" download>
                                                <span class="attachment-icon"><i class="fa-regular fa-file-pdf"></i></span>
                                                <span class="attachment-name">Doc_0481.pdf</span>
                                                <span class="attachment-action"><i class="fa-solid fa-download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="submission-stats-section">
                                        <div class="meta-label">Submission Statistics</div>
                                        <div class="submission-stats-grid">
                                            <div class="stat-card stat-success">
                                                <div class="stat-number">28</div>
                                                <div class="stat-text">Submitted</div>
                                            </div>
                                            <div class="stat-card stat-warning">
                                                <div class="stat-number">2</div>
                                                <div class="stat-text">Pending</div>
                                            </div>
                                            <div class="stat-card stat-neutral">
                                                <div class="stat-number">30</div>
                                                <div class="stat-text">Total Students</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    <!-- End Of viewAttachedDocs Modal -->

    <!-- start Of viewAttachedDocs Modal -->
    
    <div class="modal fade cmn-popwrp pop800 links" id="evaluationDetails" tabindex="-1" role="dialog" aria-labelledby="assignmentActions" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('backend/assets/images/cross-icon.svg') }}" alt="Icon"></span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Assignment Title</h2>
                        </div>

                        <div class="cmn-pop-inr-content-wrp">
                            <div class="assigment-dtls-cd-inner">
                                <div class="assigment-meta-grid">
                                    <div class="meta-item">
                                        <div class="meta-label">Class</div>
                                        <div class="meta-value">Lorem Ipsum</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Subject</div>
                                        <div class="meta-value">Lorem Ipsum</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Due Date</div>
                                        <div class="meta-value">2024-01-22</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label">Evaluated By</div>
                                        <div class="meta-value">Lorem Ipsum</div>
                                    </div>
                                </div>

                                <div class="assignment-description">
                                    <div class="meta-label">Description</div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>
                                </div>

                             

                                <div class="submission-stats-section">
                                    <div class="meta-label">Submission Statistics</div>
                                    <div class="submission-stats-grid">
                                        <div class="stat-card stat-neutral">
                                            <div class="stat-number total">30</div>
                                            <div class="stat-text">Total Students</div>
                                        </div>

                                        <div class="stat-card stat-success">
                                            <div class="stat-number evaluated">28</div>
                                            <div class="stat-text">Evaluated</div>
                                        </div>

                                        <div class="stat-card stat-warning">
                                            <div class="stat-number pending">2</div>
                                            <div class="stat-text">Pending</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="scores-table-wrap">
                                    <div class="meta-label">Student Scores</div>

                                    <div class="ds-cmn-tble count-row tbl-100">
                                        <table class="scores-table" role="table" aria-label="Student Scores">
                                            <thead>
                                                <tr>
                                                    <th class="col-sno">S. No</th>
                                                    <th class="col-subject">Student Name</th>
                                                    <th class="col-subject">Subject</th>
                                                    <th class="col-grade">Grade</th>
                                                    <th class="col-note">Note</th>
                                                    <th class="col-action">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-sno">1</td>
                                                    <td class="col-subject">Lorem ipsum dolor sit amet</td>
                                                    <td class="col-subject">Mathematics</td>
                                                    <td class="col-grade">A+</td>
                                                    <td class="col-note">Well done</td>
                                                    <td class="col-action">
                                                        <button class="cmn-btn btn-sm" data-bs-dismiss="modal">Close</button>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col-sno">2</td>
                                                    <td class="col-subject">Lorem ipsum dolor sit amet</td>
                                                    <td class="col-subject">English</td>
                                                    <td class="col-grade">A</td>
                                                    <td class="col-note">Good</td>
                                                    <td class="col-action">
                                                        <button class="cmn-btn btn-sm" data-bs-dismiss="modal">Close</button>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col-sno">3</td>
                                                    <td class="col-subject">Lorem ipsum dolor sit amet</td>
                                                    <td class="col-subject">History</td>
                                                    <td class="col-grade">B+</td>
                                                    <td class="col-note">Needs improvement</td>
                                                    <td class="col-action">
                                                        <button class="cmn-btn btn-sm" data-bs-dismiss="modal">Close</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- End Of viewAttachedDocs Modal -->


    <!-- PendingAssignmentAttachments Modal Begin -->

        <div class="modal fade cmn-popwrp pop800 links" id="PendingAssignmentAttachments" tabindex="-1" role="dialog" aria-labelledby="PendingAssignmentAttachments" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('backend/assets/images/cross-icon.svg') }}" alt="Icon"></span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2>Assignment Request Details</h2>
                            </div>

                            <div class="cmn-pop-inr-content-wrp">
                                <div class="assigment-dtls-cd-inner">
                                    <div class="assigment-meta-grid">
                                        <div class="meta-item">
                                            <div class="meta-label">Assignment Title</div>
                                            <div class="meta-value">Lorem Ipsum</div>
                                        </div>
                                       
                                    </div>
                                    <div class="assigment-meta-grid">
                                        <div class="meta-item">
                                            <div class="meta-label">Class</div>
                                            <div class="meta-value">Lorem Ipsum</div>
                                        </div>
                                        <div class="meta-item">
                                            <div class="meta-label">Subject</div>
                                            <div class="meta-value">Lorem Ipsum</div>
                                        </div>
                                        <div class="meta-item">
                                            <div class="meta-label">Due Date</div>
                                            <div class="meta-value">2024-01-22</div>
                                        </div>
                                        <div class="meta-item">
                                            <div class="meta-label">Created By</div>
                                            <div class="meta-value">Lorem Ipsum</div>
                                        </div>
                                    </div>
                                
                                    <div class="assignment-description">
                                        <div class="meta-label">Description</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                
                                    <div class="assignment-attachments">
                                        <div class="meta-label">Attachments</div>
                                        <div class="attachments-list">
                                            <a href="/path/to/Doc_0481.jpg" class="attachment-btn cmn-btn btn-sm" download>
                                                <span class="attachment-icon"><i class="fa-regular fa-file-image"></i></span>
                                                <span class="attachment-name">Doc_0481.jpg</span>
                                                <span class="attachment-action"><i class="fa-solid fa-download"></i></span>
                                            </a>
                                            <a href="/path/to/Doc_0481.pdf" class="attachment-btn cmn-btn btn-sm" download>
                                                <span class="attachment-icon"><i class="fa-regular fa-file-pdf"></i></span>
                                                <span class="attachment-name">Doc_0481.pdf</span>
                                                <span class="attachment-action"><i class="fa-solid fa-download"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                

                                    <div class="assignment-options">
                                       
                                        <div class="assignment-options">
                                             <div class="upcoming cmn-tbl-btn green-bg"><img src="{{ asset('backend/assets/images/qlementine-icons_check-tick-16.svg') }}" alt="Icon">Accept Request </div>
                                             <div class="upcoming cmn-tbl-btn red-bg"><img src="{{ asset('backend/assets/images/maki_cross.svg') }}" alt="Icon">Reject Request</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    <!-- End Of PendingAssignmentAttachments Modal -->

    <!-- confirmation Modal Begin -->
    <div class="modal fade cmn-popwrp popwrp w400" id="success" tabindex="-1" role="dialog" aria-labelledby="success" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('backend/assets/images/cross-icon.svg') }}" alt="Icon"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <div class="modal-icon">
                            <img src="{{ asset('backend/assets/images/check-circle-primary.svg') }}" alt="Bin Icon">
                        </div>
                        <div class="sec-head head-center">
                            <p>Are you sure you want accept this assessment request?</p>
                            <div class="btn-wrp">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="cmn-btn btn-sm">Accept</button>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="cmn-btn btn-sm">Cancel</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of confirmation Modal -->

 
@endsection


@push('script')
    <!-- JavaScript to Toggle Tables and Handle Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownTrigger = document.querySelector('.dropdown-trigger');
            const dropdownOptions = document.querySelector('.dropdown-options');
            const dropdownLabel = document.querySelector('.dropdown-label');
            const dropdownOptionElements = document.querySelectorAll('.dropdown-option');
            const assignmentsOverview = document.getElementById('assignmentsOverview');
            const pendingAssignments = document.getElementById('pendingAssignments');

            // Toggle dropdown visibility on trigger click
            dropdownTrigger.addEventListener('click', function () {
                dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
            });

            // Handle dropdown option selection
            dropdownOptionElements.forEach(option => {
                option.addEventListener('click', function () {
                    // Update dropdown label
                    dropdownLabel.textContent = this.textContent;
                    dropdownOptions.style.display = 'none';

                    // Remove 'selected' class from all options and add to clicked option
                    dropdownOptionElements.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');

                    // Toggle tables based on data-value
                    const tableId = this.getAttribute('data-value');
                    if (tableId === 'assignmentsOverview') {
                        assignmentsOverview.style.display = 'block';
                        pendingAssignments.style.display = 'none';
                    } else if (tableId === 'pendingAssignments') {
                        assignmentsOverview.style.display = 'none';
                        pendingAssignments.style.display = 'block';
                    }
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!dropdownTrigger.contains(e.target) && !dropdownOptions.contains(e.target)) {
                    dropdownOptions.style.display = 'none';
                }
            });

            // Initialize table visibility based on selected option
            const selectedOption = document.querySelector('.dropdown-option.selected');
            const initialTableId = selectedOption.getAttribute('data-value');
            if (initialTableId === 'assignmentsOverview') {
                assignmentsOverview.style.display = 'block';
                pendingAssignments.style.display = 'none';
            } else if (initialTableId === 'pendingAssignments') {
                assignmentsOverview.style.display = 'none';
                pendingAssignments.style.display = 'block';
            }
        });
    </script>

    <script>
 
        $(document).on('click', '.view-assignment', function ()
        {
            let assignmentId = $(this).data('id');
            console.log('assigned id ', assignmentId);

            let url = "{{ route('assignment.details', ':id') }}";
            url = url.replace(':id', assignmentId);

            // Open modal first
            $('#assignmentActions').modal('show');

            // Clear / set loading content
            $('#assignmentActions .cmn-pop-head h2').text('Loading...');
            $('#assignmentActions .meta-value').text('Loading...');
            $('#assignmentActions .assignment-description p').text('Loading...');
            $('#assignmentActions .attachments-list').empty().append('<p>Loading attachments...</p>');
            $('#assignmentActions .submission-stats-grid .stat-number').text('...');

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    console.log('assignment data', data);

                    let title = data.title ? data.title.toLowerCase().replace(/\b\w/g, function(char) {
                                    return char.toUpperCase();
                                }): 'Untitled';

                    $('#assignmentActions .cmn-pop-head h2').text(title);
                    $('#assignmentActions .meta-value').eq(0).text(data.class ? data.class.name : 'N/A');
                    $('#assignmentActions .meta-value').eq(1).text(data.subject ? data.subject.name : 'N/A');
                    $('#assignmentActions .meta-value').eq(2).text(data.due_date);
                    $('#assignmentActions .meta-value').eq(3).text(data.creator ? data.creator.name : 'N/A');
                    $('#assignmentActions .assignment-description p').text(data.description ?? 'No description');

                    // Attachments
                    let attachmentsContainer = $('#assignmentActions .attachments-list');
                    attachmentsContainer.empty();
                    if (data.media_files && data.media_files.length > 0) {
                        $.each(data.media_files, function (index, file) {
                            let ext = file.type;
                            let displayName = file.name.includes('.') ? file.name : `${file.name}.${ext}`;
                            let icon = ext === 'pdf'
                                ? '<i class="fa-regular fa-file-pdf"></i>'
                                : '<i class="fa-regular fa-file-image"></i>';

                            attachmentsContainer.append(`
                                <a href="${file.url}" class="attachment-btn" target="_blank">
                                    <span class="attachment-icon">${icon}</span>
                                    <span class="attachment-name">${displayName}</span>
                                    <span class="attachment-action"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                                </a>
                            `);
                        });
                    } else {
                        attachmentsContainer.append('<p>No attachments available.</p>');
                    }

                    // Submission stats
                    $('#assignmentActions .submission-stats-grid .stat-number').eq(0).text(data.submitted_count ?? 0);
                    $('#assignmentActions .submission-stats-grid .stat-number').eq(1).text(data.pending_count ?? 0);
                    $('#assignmentActions .submission-stats-grid .stat-number').eq(2).text(data.total_students ?? 0);
                },
                error: function () {
                    alert('Failed to load assignment details.');
                }
            });
        });

    </script>

    <script>
        $(document).on('click', '.view-attachment-btn', function () {
            let assignmentId = $(this).data('id');
            let url = "{{ route('assignment.details', ':id') }}";
            url = url.replace(':id', assignmentId);

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $('#PendingAssignmentAttachments .meta-value').text('Loading...');
                },
                success: function(data) {
                    // console.log('assignment data', data);
                   
                    $('#PendingAssignmentAttachments .meta-value:contains("Lorem Ipsum")').text(''); // clear placeholders
                    $('#PendingAssignmentAttachments .meta-label:contains("Assignment Title")').next().text(data.title ?? '-');
                    $('#PendingAssignmentAttachments .meta-label:contains("Class")').next().text(data.class?.name ?? '-');
                    $('#PendingAssignmentAttachments .meta-label:contains("Subject")').next().text(data.subject?.name ?? '-');
                    $('#PendingAssignmentAttachments .meta-label:contains("Due Date")').next().text(data.due_date ?? '-');
                    $('#PendingAssignmentAttachments .meta-label:contains("Created By")').next().text(data.creator?.name ?? '-');
                    $('#PendingAssignmentAttachments .assignment-description p').text(data.description ?? '-');

                    let attachmentsContainer = $('#PendingAssignmentAttachments  .attachments-list');
                    attachmentsContainer.empty();
                    if (data.media_files && data.media_files.length > 0) {
                        $.each(data.media_files, function (index, file) {
                            let ext = file.type;
                            let displayName = file.name.includes('.') ? file.name : `${file.name}.${ext}`;
                            let icon = ext === 'pdf'
                                ? '<i class="fa-regular fa-file-pdf"></i>'
                                : '<i class="fa-regular fa-file-image"></i>';

                            attachmentsContainer.append(`
                                <a href="${file.url}" class="attachment-btn" target="_blank">
                                    <span class="attachment-icon">${icon}</span>
                                    <span class="attachment-name">${displayName}</span>
                                    <span class="attachment-action"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                                </a>
                            `);
                        });
                    } else {
                        attachmentsContainer.append('<p>No attachments available.</p>');
                    }

                }
            });
        });

        // When "Accept Request" button is clicked
        $(document).on('click', '.green-bg', function () {
            let assignmentId = $('#PendingAssignmentAttachments').data('id');
            $('#success').data('id', assignmentId); 
            $('#success').modal('show'); 
        });

        // When "Accept" button inside confirmation modal is clicked
        $(document).on('click', '#success .cmn-btn:contains("Accept")', function () {
            let assignmentId = $('#success').data('id');
            let url = "{{ route('assignment.approve_assignment', ':id') }}";
            url = url.replace(':id', assignmentId);

            $.ajax({
                url: url,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                beforeSend: function() {
                    $('#success .cmn-btn:contains("Accept")').prop('disabled', true);
                },
                success: function (res) {
                    console.log('approve result', res);
                    $('#success').modal('hide');
                    $('#PendingAssignmentAttachments').modal('hide');
                    location.reload();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $('#success .cmn-btn:contains("Accept")').prop('disabled', false);
                }
            });
        });

        // When "Cancel" button inside confirmation modal is clicked
        $(document).on('click', '#success .cmn-btn:contains("Cancel")', function () {
            $('#success').modal('hide');
            $('#PendingAssignmentAttachments').modal('show'); 
        });


        // Reject request
        $(document).on('click', '.red-bg', function () {
            let assignmentId = $('#PendingAssignmentAttachments').data('id');
            let url = "{{ route('assignment.reject_assignment', ':id') }}";
            url = url.replace(':id', assignmentId);

            $.ajax({
                url: url,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                     console.log('reject result', res);
                    $('#PendingAssignmentAttachments').modal('hide');
                    location.reload();
                }
            });
        });

    </script>

    <script>
        $(document).on('click', '.evaluation-details', function () {
            // console.log('evaluation details');
            let assignmentId = $(this).data('id');
            console.log('assignment id in eval details', assignmentId);

            let url = "{{ route('assignment.evalulation_details', ':id') }}";
            url = url.replace(':id', assignmentId);

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $('#evaluationDetails .cmn-pop-head h2').text('Loading...');
                },
                success: function(data) {
                    // console.log('evaluation details', data);
                    if (data) {
                        // Assignment info
                        $('#evaluationDetails .cmn-pop-head h2').text(data.title ?? 'N/A');
                        $('#evaluationDetails .meta-value').eq(0).text(data.class.name ?? 'N/A');
                        $('#evaluationDetails .meta-value').eq(1).text(data.subject.name ?? 'N/A');
                        $('#evaluationDetails .meta-value').eq(2).text(data.due_date ?? 'N/A');
                        $('#evaluationDetails .meta-value').eq(3).text(data.creator?.name ?? 'N/A');
                        $('#evaluationDetails .assignment-description p').text(data.description ?? '');

                        // Stats
                        $('#evaluationDetails .stat-number.total').text(data.total_students ?? 0);
                        $('#evaluationDetails .stat-number.evaluated').text(data.submitted_count ?? 0);
                        $('#evaluationDetails .stat-number.pending').text(data.pending_count ?? 0);

                        // Student Scores
                        let tbody = $('#evaluationDetails .scores-table tbody');
                        tbody.empty();

                        if (data.submissions && data.submissions.length > 0) {
                            $.each(data.submissions, function (index, submission) {
                                let student = submission.student ?? {};
                                let evaluator = submission.evaluator ?? {};
                                let grade = submission.grade ?? '-';
                                let note = submission.note ?? '-';
                              

                                tbody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${student.first_name ?? 'N/A'} ${student.last_name ?? ''}</td>
                                        <td>${data.subject?.name ?? 'N/A'}</td>
                                        <td>${grade}</td>
                                        <td>${note}</td>
                                        <td class="col-action">
                                          <button class="cmn-btn btn-sm" data-bs-dismiss="modal">Close</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            tbody.append(`<tr><td colspan="6" class="text-center">No submissions found</td></tr>`);
                        }

                        $('#evaluationDetails').modal('show');
                    }
                },
                error: function() {
                    alert('Unable to fetch evaluation details.');
                }
            });
        });
    </script>

    <script>
        // $(document).on('submit', '#filterForm', function (e) {
        //     e.preventDefault();

        //     $.ajax({
        //         url: "{{ route('assignments.filter') }}",
        //         type: 'GET',
        //         data: $(this).serialize(),
        //         beforeSend: function() {
        //             $('#ViewAssignmentTableContainer tbody').html('<tr><td colspan="10" class="text-center">Loading...</td></tr>');
        //             $('#pendingAssignments tbody').html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');
        //         },
        //         success: function(response) {

        //             // === Assignments Overview ===
        //             let htmlAccepted = '';
        //             if (response.assignments.length > 0) {
        //                 $.each(response.assignments, function(index, assignment) {
        //                     htmlAccepted += `
        //                         <tr>
        //                             <td>${index + 1}</td>
        //                             <td>${assignment.subject?.name ?? 'N/A'}</td>
        //                             <td>${assignment.title}</td>
        //                             <td>${assignment.created_at ? moment(assignment.created_at).format('DD/MM/YYYY') : '-'}</td>
        //                             <td>${assignment.due_date ? moment(assignment.due_date).format('DD/MM/YYYY') : 'N/A'}</td>
        //                             <td>${assignment.creator?.name ?? 'N/A'}</td>
        //                             <td>${assignment.submitted_count ?? 0} / ${assignment.total_students ?? 0}</td>
        //                             <td>${assignment.grade ?? '-'}</td>
        //                             <td>
        //                                 <button class="view-attachment-btn view-assignment"
        //                                     data-bs-target="#assignmentActions"
        //                                     data-bs-toggle="modal"
        //                                     data-id="${assignment.id}">
        //                                     <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="View">
        //                                 </button>
        //                             </td>
        //                             <td>
        //                                 <button class="view-attachment-btn evaluation-details"
        //                                     data-bs-target="#evaluationDetails"
        //                                     data-bs-toggle="modal"
        //                                     data-id="${assignment.id}">
        //                                     <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="Details">
        //                                 </button>
        //                             </td>
        //                         </tr>
        //                     `;
        //                 });
        //             } else {
        //                 htmlAccepted = `<tr><td colspan="10" class="text-center">No assignments found.</td></tr>`;
        //             }
        //             $('#ViewAssignmentTableContainer tbody').html(htmlAccepted);


        //             // === Pending Assignments ===
        //             let htmlPending = '';
        //             if (response.pendingAssignments.length > 0) {
        //                 $.each(response.pendingAssignments, function(index, assignment) {
        //                     htmlPending += `
        //                         <tr>
        //                             <td>${index + 1}</td>
        //                             <td>${assignment.created_at ? moment(assignment.created_at).format('DD/MM/YYYY') : '-'}</td>
        //                             <td>${assignment.class?.name ?? '-'}</td>
        //                             <td>${assignment.subject?.name ?? '-'}</td>
        //                             <td>${assignment.title ?? '-'}</td>
        //                             <td>${assignment.due_date ? moment(assignment.due_date).format('DD/MM/YYYY') : '-'}</td>
        //                             <td>${assignment.creator?.name ?? '-'}</td>
        //                             <td>
        //                                 <button class="view-attachment-btn"
        //                                     data-id="${assignment.id}"
        //                                     data-bs-target="#PendingAssignmentAttachments"
        //                                     data-bs-toggle="modal">
        //                                     <img src="{{ asset('backend/assets/images/eye-white.svg') }}" alt="View">
        //                                 </button>
        //                             </td>
        //                         </tr>
        //                     `;
        //                 });
        //             } else {
        //                 htmlPending = `<tr><td colspan="8" class="text-center">No pending assignments found.</td></tr>`;
        //             }
        //             $('#pendingAssignments tbody').html(htmlPending);
        //         },
        //         error: function() {
        //             $('#ViewAssignmentTableContainer tbody').html('<tr><td colspan="10" class="text-center text-danger">Error loading data</td></tr>');
        //             $('#pendingAssignments tbody').html('<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>');
        //         }
        //     });
        // });


    </script>

    
@endpush