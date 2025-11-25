@extends('staff.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')


<div class="ds-breadcrumb">
    <h1>Assignments</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Assignments</li>
    </ul>
</div>

<div class="ds-pr-body">

    <div class="atndnc-filter-wrp w-100">
        <div class="sec-head">
            <h2>Select Criteria</h2>
        </div>
        <div class="atndnc-filter">
            <form>
                <div class="atndnc-filter-form">

                    <div class="atndnc-filter-options">

                        <div class="dropdown subject-dropdown selectisub">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">Select Subject</span>
                                <img src="./images/down-arrow-5.svg" class="arrow-att"/>
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
                                <span class="label">Select Room No.</span>
                                <img src="./images/down-arrow-5.svg" class="arrow-att"/>
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
    
    <div class="ds-cmn-table-wrp tab-wrapper">

        <div class="ds-content-head">
            <div class="cmn-tab-head">
                <ul>
                    <li class="tab-bg"></li>
                    <li class="tab-switch active" data-tab="current-tab">Current Assignments</li>
                    <li class="tab-switch" data-tab="closed-tab">Closed Assignments</li>
                    <li class="tab-switch" data-tab="requested-tab">Requested Assignments</li>
                </ul>
            </div>
            <div class="assignments" onclick="openAssignmentPopup()">
                <p>+</p>
                <p>Assignments</p>
            </div>
        </div>

        <div class="tab-content current-tab active">
            <div class="ds-cmn-tble pending count-row">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>Subject</th>
                            <th>Assignment Title</th>
                            <th>Assignment Description</th>
                            <th>Attachment</th>
                            <th>Assigned Date</th>
                            <th>Due Date</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/02/2025</td>
                            <td>04/22/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" onclick="openEditPopup()"/></p>
                                    <p class="delete-btn"><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-content requested-tab">
            <div class="ds-cmn-tble completed count-row">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>Subject</th>
                            <th>Assignment Title</th>
                            <th>Assignment Description</th>
                            <th>Attachment</th>
                            <th>Assigned Date</th>
                            <th>Due Date</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/02/2025</td>
                            <td>04/22/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" onclick="openEditPopup()"/></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <div class="file-action">
                                    <p><img src="./images/lines.svg" /></p>
                                    <p><img src="./images/pen.svg" /></p>
                                    <p><img src="./images/dust.svg" /></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-content closed-tab">
            <div class="ds-cmn-tble closed count-row">
                <table>
                    <thead>
                        <tr>
                            <th>S. No</th>
                            <th>Subject</th>
                            <th>Assignment Title</th>
                            <th>Assignment Description</th>
                            <th>Attachment</th>
                            <th>Assigned Date</th>
                            <th>Due Date</th>
                            <th>Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/02/2025</td>
                            <td>04/22/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>Lorem ipsum dolor sit amet </td>
                            <td>
                                <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </div>
                                    </div>
                                    
                            </td>
                            <td><button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal"><img src="./images/eye-white.svg" alt="Eye Icon"></button></td>
                            <td>04/15/2025</td>
                            <td>04/15/2025</td>
                            <td>50</td>
                            <td>
                                <p class="statusBtn">Pending</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>


<!-- Attachments Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="viewAttachments" tabindex="-1" role="dialog" aria-labelledby="viewAttachments" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="tab-wrapper">
                    <div class="cmn-pop-head">
                        <div class="cmn-tab-head dif">
                            <ul>
                                <li class="tab-bg"></li>
                                <li class="active">New Upload</li>
                                <li>Attached Files</li>
                            </ul>
                        </div>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="cmn-tab-content new-upload">
                            <form>
                                <div class="file-upload-lg">
                                    <input type="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                    <div class="file-upld-lg-design">
                                        <div class="fupld-lg-icon">
                                            <img src="./images/upload-file-icon.svg" alt="Icon">
                                        </div>
                                        <p class="drag-p">Click to browse or </p><p>drag and drop your files</p>
                                    </div>
                                </div>
                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls, .xlsx files.</p>
                                    <div class="ibtn">
                                        <button type="button" class="ibtn-icon">
                                            <img src="./images/i-icon.svg" alt="Icon">
                                        </button>
                                        <div class="ibtn-info">
                                            <button type="button" class="ibtn-close">
                                                <img src="./images/fa-times.svg" alt="icon">
                                            </button>
                                            <h3>Upload Guidelines</h3>
                                            <ul>
                                                <li>Images larger than 5 MB are not accepted.</li>
                                                <li>Videos must be under 10 MB in size.</li>
                                                <li>If your files are larger, please upload them to your Google Drive and share the link here. This helps ensure smooth uploads and better convenience for you.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>

                        <div class="cmn-tab-content recent">
                            <!-- Upload List Component -->
                            <div class="upload-list">
                                <ul class="uploads">
                                    <li class="assignment-column">
                                    <p>Assignment No.- 24</p>
                                    <p>Grade: 50</p>
                                    <p>Title: Lorem Ipsum</p>
                                    <p>File Format: PDF File</p>
                                    </li> 
                                    <li  class="assignment-column">
                                    <p>Assignment No.- 24</p>
                                    <p>Grade: 50</p>
                                    <p>Title: Lorem Ipsum</p>
                                    <p>File Format: PDF File</p>
                                    </li>  
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Attachments Modal -->

<!-- Edit File Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="editFile" tabindex="-1" role="dialog" aria-labelledby="editFile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Uploaded Files</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="cmn-tab-content mb-4">
                            <form>
                                <div class="file-upload-lg">
                                    <input type="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                    <div class="file-upld-lg-design">
                                        <div class="fupld-lg-icon">
                                            <img src="./images/upload-file-icon.svg" alt="Icon">
                                        </div>
                                        <p>Click to browse or drag and drop your files</p>
                                    </div>
                                </div>
                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls, .xlsx files.</p>
                                    <div class="ibtn">
                                        <button type="button" class="ibtn-icon">
                                            <img src="./images/i-icon.svg" alt="Icon">
                                        </button>
                                        <div class="ibtn-info">
                                            <button type="button" class="ibtn-close">
                                                <img src="./images/fa-times.svg" alt="icon">
                                            </button>
                                            <h3>Upload Guidelines</h3>
                                            <ul>
                                                <li>Images larger than 5 MB are not accepted.</li>
                                                <li>Videos must be under 10 MB in size.</li>
                                                <li>If your files are larger, please upload them to your Google Drive and share the link here. This helps ensure smooth uploads and better convenience for you.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>

                        <div class="cmn-tab-content">
                            <div class="upload-list">
                                <ul class="uploads">
                                    <li class="upload-item">
                                        <span class="icon pdf-icon"><img src="./images/pdf-icon.svg" alt="icon"></span>
                                        <div class="details">
                                            <span class="filename">Sheet-01.pdf</span>
                                            <span class="timestamp">2m ago</span>
                                        </div>
                                        <span class="size">604KB</span>
                                        <button class="remove-btn"><img src="./images/cross-circle.svg" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item">
                                        <span class="icon folder-icon"><img src="./images/folder-icon.svg" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">Stock Photos</span>
                                            <span class="timestamp">3m ago</span>
                                        </div>
                                        <span class="size">2.20GB</span>
                                        <button class="remove-btn"><img src="./images/cross-circle.svg" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item">
                                        <span class="icon video-icon"><img src="./images/video-reel-icon.svg" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">Assignment.mp4</span>
                                            <span class="timestamp">5m ago</span>
                                        </div>
                                        <span class="size">1.46MB</span>
                                        <button class="remove-btn"><img src="./images/cross-circle.svg" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item error">
                                        <span class="icon doc-icon"><img src="./images/document-icon.svg" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">Strategy-Pitch-Final.docx</span>
                                            <span class="timestamp">10m ago</span>
                                        </div>
                                        <div class="status">
                                            <button class="retry-btn">⟳</button>
                                            <span class="error-text">Error</span>
                                        </div>
                                        <button class="remove-btn"><img src="./images/cross-circle.svg" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item">
                                        <span class="icon image-icon"><img src="./images/gallery-icon.svg" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">man-holding-mobile-phone-while.jpg</span>
                                            <span class="timestamp">10m ago</span>
                                        </div>
                                        <span class="size">929KB</span>
                                        <button class="remove-btn"><img src="./images/cross-circle.svg" alt="Icon"></button>
                                    </li>
                                </ul>
                                <div class="btn-wrp justify-content-end">
                                    <button class="btn-sm cmn-btn"  data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="btn-sm cmn-btn">Save Changes</button>
                                </div>
                                <div class="last-updated"><img src="./images/check-circle.svg" alt="Icon"> Last updated: 3 mins ago</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Edit File Modal -->

<!-- viewAttachedDocs Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="viewAttachedDocs" tabindex="-1" role="dialog" aria-labelledby="viewAttachedDocs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Attached Files</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="viewAttachedDocs">
                            <div class="attached-doc-card">
                                <div class="attached-doc-info">
                                    <p>Assignment No.- 24</p>
                                    <p>Title: Lorem Ipsum</p>
                                    <p>File Format: PDF File</p>
                                </div>
                                <div class="btn-wrp">
                                    <a href="./images/document-icon.svg" download="./images/download-icon.svg" class="cmn-btn">Download</a>
                                </div>
                            </div>
                            <div class="attached-doc-card">
                                <div class="attached-doc-info">
                                    <p>Assignment No.- 24</p>
                                    <p>Title: Lorem Ipsum</p>
                                    <p>File Format: PDF File</p>
                                </div>
                                <div class="btn-wrp">
                                    <a href="./images/document-icon.svg" download="./images/download-icon.svg" class="cmn-btn">Download</a>
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

<!-- Assignement Popup-->
<div id="assignmentPopup" class="popup-overlay-assignment">
    <div class="popup-box-assignment">
       
        <h2 class="add-heading">Add Assignments</h2>
        
        <div class="desc-rows">
             <img src="./images/reqCross.svg" class="close-btn-assignment" onclick="closePopup()">
        <div class="assign-align">
        <div class="assign-column">
            <p class="assign-heading">Subject</p>
            <input type="text" placeholder="Select Subject" />
            <img src="./images/greyarrow.svg" />
        </div>

        <div class="assign-columndate">
            <p class="assign-heading">Date</p>
            <input type="text" placeholder="mm-dd-yyyy" />
            <img src="./images/calender_s.svg" />
        </div>
        </div>

        <div class="assign-align">
        <div class="assign-column">
            <p class="assign-heading">Assignment Title</p>
            <input type="text" placeholder="Title" />
        </div>

        <div class="assign-columndate">
            <p class="assign-heading">Grade</p>
            <input type="text" placeholder="30" />
        </div>
        </div>

        <div class="assign-column">
            <p class="assign-heading">Attachment</p>
           
            <div class="attachment"> <img src="./images/calender_s.svg" class="specialimg"/> Drag and drop a file here or click</div>
        </div>

        <div class="assign-desc">
            <p class="assign-heading">Description</p>
           
            <textarea class="desc-column" placeholder="Submit homework before last date." ></textarea>
            
        </div>
        </div>

        <button class="req-btn">Send Request</button>
    </div>
</div>

<!-- Edit Popup-->
<div id="EditPopup" class="popup-overlay-edit">
    <div class="popup-box-edit">
       
        <h2 class="add-heading-edit">Edit Assignment</h2>
        
        <div class="desc-rows-edit">
             <img src="./images/reqCross.svg" class="close-btn-edit" onclick="closeEditPopup()">
        <div class="assign-align-edit">
        <div class="assign-column-edit">
            <p class="assign-heading-edit">Subject</p>
            <input type="text" placeholder="Select Subject" />
            <img src="./images/greyarrow.svg" />
        </div>

        <div class="assign-columndate-edit">
            <p class="assign-heading-edit">Date</p>
            <input type="text" placeholder="05/10/2025" />
            <img src="./images/calender_s.svg" />
        </div>
        </div>

        <div class="assign-align-edit">
        <div class="assign-column-edit">
            <p class="assign-heading-edit">Assignment Title</p>
            <input type="text" placeholder="Title" value="Lorem ipsum dolor sit amet, consectetur adipiscing elit" />
        </div>

        <div class="assign-columndate-edit">
            <p class="assign-heading-edit">Grade</p>
            <input type="text" placeholder="30" />
        </div>
        </div>

        <div class="assign-column-edit">
            <p class="assign-heading-edit">Attachment</p>
           
            <div class="attachment-edit"> <img src="./images/upload.svg" class="specialimg"/> Drag and drop a file here or click</div>
        </div>

        <div class="assign-desc-edit">
            <p class="assign-heading-edit">Description</p>
           
            <textarea class="desc-column-edit" placeholder="Submit homework before last date." ></textarea>
            
        </div>
        </div>

        <button class="req-btn-edit">Save</button>
    </div>
</div>
<!-- delete popup-->

@endsection

@push('script')
    
@endpush