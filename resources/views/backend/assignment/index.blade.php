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
                                    <select>
                                        <option value="select-year">Select Year</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Year Status</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Semester</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Class</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <select>
                                        <option value="select-year">Select Subject</option>
                                        <option value="2024">2024</option>
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
                    <div class="ds-cmn-tble count-row">
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
                                <tr>
                                    <td>1</td>
                                    <td>Lorem</td>
                                    <td>Lorem</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td></td>
                                    <td>
                                        <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal">
                                            <img src="{{ asset('backend') }}/assets/images/new_images/eye-white.svg" alt="Eye Icon">
                                        </button>
                                    </td>
                                    <td>
                                        <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal">
                                            <img src="{{ asset('backend') }}/assets/images/new_images/eye-white.svg" alt="Eye Icon">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Lorem</td>
                                    <td>Lorem</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td>04/01/2025</td>
                                    <td></td>
                                    <td>
                                        <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal">
                                            <img src="{{ asset('backend') }}/assets/images/new_images/eye-white.svg" alt="Eye Icon">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tablepagination">
                    <div class="tbl-pagination-inr">
                        <ul>
                            <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-left.svg" alt="Icon"></a></li>
                            <li class="active"><a href="#url">1</a></li>
                            <li><a href="#url">2</a></li>
                            <li><a href="#url">3</a></li>
                            <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-right.svg" alt="Icon"></a></li>
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
@endsection