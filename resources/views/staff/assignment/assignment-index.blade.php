@extends('staff.master')

<style>
    /* .popup-overlay-assignment {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.popup-box-assignment {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
} */

/* Remove editor shadow */
.ck-editor__main {
    border-top: none !important;
}

.ck-editor__editable {
    min-height: 320px !important;
    border: 1px solid #660000 !important; 
    border-radius: 5px !important;
    padding: 14px !important;
}

/* Toolbar styling */
.ck-toolbar {
    border: 1px solid #660000 !important;
    border-bottom: none !important;
    border-radius: 8px 8px 0 0 !important;
    padding: 8px !important;
}

.ck-toolbar .ck-button {
    background: none !important;
    border-radius: 4px !important;
    padding: 4px !important;
    width: 32px !important;
    height: 32px !important;
}

.ck-toolbar .ck-button:hover {
    background: #f4f4f4 !important;
}


.ck-toolbar .ck-dropdown {
    margin-right: 6px;
}


.ck.ck-editor__editable:not(.ck-editor__nested-editable):focus {
    box-shadow: none !important;
}



</style>
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
                    <div class="atndnc-filter-options flex-row">
                        <!-- Subject Multi‑Select Dropdown -->

                        <div class="dropdown subject-dropdown selectisub">
                            <button type="button" class="dropdown-toggle">
                                <span class="label">Select Subject</span>
                                <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att" />

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
                                <img src="{{asset('staff/assets/images/down-arrow-5.svg')}}" class="arrow-att" />

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
                    <li class="tab-switch " data-tab="current-tab">Current Assignments</li>
                    <li class="tab-switch" data-tab="closed-tab">Closed Assignments</li>
                    <li class="tab-switch active" data-tab="requested-tab">Requested Assignments</li>
                </ul>
            </div>
            {{-- <div class="assignments">
                <p>+</p>
                <p>Assignments</p>
            </div> --}}

            <div class="assignments" onclick="openAssignmentPopup()">
                <p>+</p>
                <p>Assignments</p>
            </div>

            <div class="tab-content current-tab">
                <div class="ds-cmn-tble pending count-row current-assignments">
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

                            @forelse($data['current_assignments'] as $index => $assignment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assignment->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $assignment->title }}</td>
                                    <td>
                                        <div class="toggle-text-wrapper">
                                            <div class="toggle-text-content">
                                                {{ $assignment->description ?? 'No description' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($assignment->media->count())
                                            <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal" data-assignment-id="{{ $assignment->id }}">
                                                <img src="{{ asset('staff/assets/images/eye-white.svg') }}">
                                            </button>
                                        @else
                                            <span>No files</span>
                                        @endif
                                    </td>
                                    <td>{{ $assignment->assigned_date->format('m/d/Y') }}</td>
                                    <td>{{ $assignment->due_date->format('m/d/Y') }}</td>
                                    <td>{{ $assignment->grade }}</td>
                                    <td>
                                        <div class="file-action">
                                            <p>
                                                <a href="{{ route('staff.assignment.evaluateAssignment', $assignment->id) }}">
                                                    <img src="{{ asset('staff/assets/images/lines.svg') }}" />
                                                </a>
                                            </p>
                                            <p>
                                                <img src="{{asset('staff/assets/images/pen.svg')}}" 
                                                   class="edit-icon" data-id="{{ $assignment->id }}" />
                                            </p>
                                            
                                            <button type="button" data-bs-target="#deleteAssignmentModal" data-bs-toggle="modal"
                                                class="delete-exam-btn deleteAssignmentBtn"
                                                data-id="{{ $assignment->id }}">
                                                    <img src="{{ global_asset('staff/assets/images/dust.svg') }}" alt="Icon">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No active assignments</td>
                                </tr>
                            @endforelse

                        
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-content requested-tab">
                <div class="ds-cmn-tble completed count-row requested-assignments" >
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
                           
                            @forelse($data['requested_assignments'] as $index => $assignment)
                            @php
                                $assignment_status= $assignment->status === 0 ? 'Pending' : '';
                            @endphp

                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assignment->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $assignment->title }}</td>
                                    <td>
                                        <div class="toggle-text-wrapper"
                                            data-description="{{ $assignment->description ?? 'No description' }}"
                                            data-title="{{ $assignment->title }}" >
                                            <div class="toggle-text-content">
                                                {{ $assignment->description ?? 'No description' }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if($assignment->media->count() > 0)
                                            <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal" data-assignment-id="{{ $assignment->id }}">
                                                <img src="{{ asset('staff/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                            </button>
                                        @else
                                            <span class="no-attachment">No files</span>
                                        @endif
                                    </td>
                                    <td>{{ $assignment->assigned_date->format('m/d/Y') }}</td>
                                    <td>{{ $assignment->due_date->format('m/d/Y') }}</td>
                                    <td>{{ $assignment->grade }}</td>
                                    <td>
                                        <p class="statusBtn">{{ $assignment_status }}</p>
                                    </td>
                                
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No requested assignments pending approval</td>
                                </tr>
                            @endforelse
                        
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-content closed-tab" >
                <div class="ds-cmn-tble closed count-row closed-assignments" >
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
                        
                        
                            @forelse($data['closed_assignments'] as $index => $assignment)

                            @php
                                $assignment_status= $assignment->status === 2 ? 'Closed' : '';
                            @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assignment->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $assignment->title }}</td>

                                    <!-- Description -->
                                    {{-- <td>{{ Str::limit($assignment->description, 50) }}</td> --}}
                                    <td>
                                        <div class="toggle-text-wrapper"
                                            data-description="{{ $assignment->description ?? 'No description' }}"
                                            data-title="{{ $assignment->title }}" >
                                            <div class="toggle-text-content">
                                                {{ $assignment->description ?? 'No description' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($assignment->media->count() > 0)
                                            <button class="view-attachment-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal" data-assignment-id="{{ $assignment->id }}">
                                                <img src="{{ asset('staff/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                            </button>
                                        @else
                                            <span class="no-attachment">No files</span>
                                        @endif
                                    </td>

                                    <td>{{ $assignment->assigned_date->format('m/d/Y') }}</td>
                                    <td>{{ $assignment->due_date->format('m/d/Y') }}</td>
                                    <td>{{ $assignment->grade }}</td>
                                    

                                    <!-- Status -->
                                    <td>
                                        <span class="status-badge closed" style="background-color: #f36969">{{ $assignment_status }}</span>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No closed assignments</td>
                                </tr>
                            @endforelse



                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- Attachments Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="viewAttachments" tabindex="-1" role="dialog" aria-labelledby="viewAttachments" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('staff/assets/images/cross-icon.svg')}}" alt="Icon"></span>
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
                                <div class="file-upload-lg" id="dropZone">
                                    <input type="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx"  id="uploadFile">
                                    <div class="file-upld-lg-design">
                                        <div class="fupld-lg-icon">
                                            <img src="{{asset('staff/assets/images/upload-file-icon.svg')}}" alt="Icon">
                                        </div>
                                        <p class="drag-p">Click to browse or </p><p>drag and drop your files</p>
                                    </div>
                                </div>
                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls, .xlsx files.</p>
                                    <div class="ibtn">
                                        <button type="button" class="ibtn-icon">
                                            <img src="{{asset('staff/assets/images/i-icon.svg')}}" alt="Icon">
                                        </button>
                                        <div class="ibtn-info">
                                            <button type="button" class="ibtn-close">
                                                <img src="{{asset('staff/assets/images/fa-times.svg')}}" alt="icon">
                                            </button>
                                            <h3>Upload Guidelines</h3>
                                            <ul>
                                                <li>Images larger than 5 MB are not accepted.</li>
                                                <li>Videos must be under 10 MB in size.</li>
                                                <li>If your files are larger, please upload them to your Google Drive and share the link here. This helps ensure smooth uploads and better convenience for you.</li>
                                            </ul>
                                        </div>
                                    </div>

                                   <input type="hidden" id="uploadAssignmentId">

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
                                     <div class="btn-wrp">
                                        <a href="./images/A.svg" download="./images/A.svg" class="cmn-btn btn-sm ms-auto">Download</a>
                                    </div>
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
                <span aria-hidden="true"><img src="{{asset('staff/assets/images/cross-icon.svg')}}" alt="Icon"></span>
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
                                            <img src="{{asset('staff/assets/images/upload-file-icon.svg')}}" alt="Icon">
                                        </div>
                                        <p>Click to browse or drag and drop your files</p>
                                    </div>
                                </div>
                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls, .xlsx files.</p>
                                    <div class="ibtn">
                                        <button type="button" class="ibtn-icon">
                                            <img src="{{asset('staff/assets/images/i-icon.svg')}}" alt="Icon">
                                        </button>
                                        <div class="ibtn-info">
                                            <button type="button" class="ibtn-close">
                                                <img src="{{asset('staff/assets/images/fa-times.svg')}}" alt="icon">
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
                                        <span class="icon pdf-icon"><img src="{{asset('staff/assets/images/pdf-icon.svg')}}" alt="icon"></span>
                                        <div class="details">
                                            <span class="filename">Sheet-01.pdf</span>
                                            <span class="timestamp">2m ago</span>
                                        </div>
                                        <span class="size">604KB</span>
                                        <button class="remove-btn"><img src="{{asset('staff/assets/images/cross-circle.svg')}}" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item">
                                        <span class="icon folder-icon"><img src="{{asset('staff/assets/images/folder-icon.svg')}}" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">Stock Photos</span>
                                            <span class="timestamp">3m ago</span>
                                        </div>
                                        <span class="size">2.20GB</span>
                                        <button class="remove-btn"><img src="{{asset('staff/assets/images/cross-circle.svg')}}" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item">
                                        <span class="icon video-icon"><img src="{{asset('staff/assets/images/video-reel-icon.svg')}}" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">Assignment.mp4</span>
                                            <span class="timestamp">5m ago</span>
                                        </div>
                                        <span class="size">1.46MB</span>
                                        <button class="remove-btn"><img src="{{asset('staff/assets/images/cross-circle.svg')}}" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item error">
                                        <span class="icon doc-icon"><img src="{{asset('staff/assets/images/document-icon.svg')}}" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">Strategy-Pitch-Final.docx</span>
                                            <span class="timestamp">10m ago</span>
                                        </div>
                                        <div class="status">
                                            <button class="retry-btn">⟳</button>
                                            <span class="error-text">Error</span>
                                        </div>
                                        <button class="remove-btn"><img src="{{asset('staff/assets/images/cross-circle.svg')}}" alt="Icon"></button>
                                    </li>
                                    <li class="upload-item">
                                        <span class="icon image-icon"><img src="{{asset('staff/assets/images/gallery-icon.svg')}}" alt="Icon"></span>
                                        <div class="details">
                                            <span class="filename">man-holding-mobile-phone-while.jpg</span>
                                            <span class="timestamp">10m ago</span>
                                        </div>
                                        <span class="size">929KB</span>
                                        <button class="remove-btn"><img src="{{asset('staff/assets/images/cross-circle.svg')}}" alt="Icon"></button>
                                    </li>
                                </ul>
                                <div class="btn-wrp justify-content-end">
                                    <button class="btn-sm cmn-btn"  data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="btn-sm cmn-btn">Save Changes</button>
                                </div>
                                <div class="last-updated"><img src="{{asset('staff/assets/images/check-circle.svg')}}" alt="Icon"> Last updated: 3 mins ago</div>
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
                <span aria-hidden="true"><img src="{{asset('staff/assets/images/cross-icon.svg')}}" alt="Icon"></span>
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
                                    <a href="{{asset('staff/assets/images/document-icon.svg')}}" download="{{asset('staff/assets/images/download-icon.svg')}}" class="cmn-btn">Download</a>
                                </div>
                            </div>
                            <div class="attached-doc-card">
                                <div class="attached-doc-info">
                                    <p>Assignment No.- 24</p>
                                    <p>Title: Lorem Ipsum</p>
                                    <p>File Format: PDF File</p>
                                </div>
                                <div class="btn-wrp">
                                    <a href="{{asset('staff/assets/images/document-icon.svg')}}" download="{{asset('staff/assets/images/download-icon.svg')}}" class="cmn-btn">Download</a>
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

<!-- add Assignement Popup-->
{{-- <div id="assignmentPopup" class="popup-overlay-assignment">
    <form id="assignmentForm" enctype="multipart/form-data">
       @csrf
        <div class="popup-box-assignment">
            <h2 class="add-heading">Add Assignment</h2>
            
            <div class="desc-rows">
                <img src="{{asset('staff/assets/images/reqCross.svg')}}" class="close-btn-assignment" >
                <div class="assign-align">

                    <div class="assign-column">
                        <p class="assign-heading">Subject</p>
                        
                        <select name="subject_id" required>
                            <option value="">Select Subject</option>
                            @foreach($data['subjects'] as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                       </select>
                        <img src="{{asset('staff/assets/images/greyarrow.svg')}}" />
                    </div>

                    <div class="assign-column">
                        <p class="assign-heading">Class</p>
                       
                        <select name="class_id" required>
                            <option value="">Select Class</option>
                       </select>
                        <img src="{{asset('staff/assets/images/greyarrow.svg')}}" />
                    </div>
                   
                </div>

                <div class="assign-align">
                    <div class="assign-column">
                        <p class="assign-heading">Assignment Title</p>
                        <input type="text" name="title" placeholder="Title"  required />
                    </div>

                    <div class="assign-columndate">
                        <p class="assign-heading">Grade</p>
                        <input type="number"  name="grade" placeholder="30"  min="0" max="100" required />
                    </div>
                </div>

                <div class="assign-column">
                    <p class="assign-heading">Attachment</p> 
                    <div class="attachment">
                       <input type="file" name="file[]" multiple style="margin-top: 10px;">
                    </div>

                     <div class="assign-columndate">
                        <p class="assign-heading"> Due Date</p>
                        <input type="date" name="due_date" class="assign-date" required>
                        <img src="{{asset('staff/assets/images/calender_s.svg')}}" />
                    </div>
                </div>

                <div class="assign-desc">
                    <p class="assign-heading">Description</p> 
                    <textarea class="desc-column" name="description" placeholder="Submit homework before last date" ></textarea>  
                </div>
          </div>

            <button type="submit" class="req-btn">Send Request</button>
        </div>
    </form>

</div> --}}


    <div id="assignmentPopup" class="popup-overlay-assignment">    
        <div class="assignPopup-inr-wrp">
            <img src="{{asset('staff/assets/images/reqCross.svg')}}" class="close-btn-assignment" onclick="closePopup()">
          <form id="assignmentForm" enctype="multipart/form-data">
           @csrf
                <div class="popup-box-assignment">

                    <h2 class="add-heading">Add Assignments</h2>

                    <div class="desc-rows">
                        <div class="assign-align">
                            <div class="assign-column">
                                <p class="assign-heading">Subject</p>
                                {{-- <input type="text" placeholder="Select Subject" /> --}}
                                <select name="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach($data['subjects'] as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <img src="{{asset('staff/assets/images/greyarrow.svg')}}" />
                            </div>

                            <div class="assign-column">
                                <p class="assign-heading">Class</p>
                                <select name="class_id" required>
                                    <option value="">Select Class</option>
                                    @foreach ($data['classes'] as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <img src="{{asset('staff/assets/images/greyarrow.svg')}}" />
                        </div>
                        
                        </div>

                        <div class="assign-align">
                            <div class="assign-column">
                                <p class="assign-heading">Assignment Title</p>
                                <input type="text" name="title" placeholder="Title" />
                            </div>

                            <div class="assign-columndate">
                                <p class="assign-heading">Grade</p>
                                <input type="text" name="grade" placeholder="30"  min="0" max="100" required />
                            </div>
                        </div>

                        <div class="assign-align">
                            <div class="assign-column">
                                <p class="assign-heading">Attachment</p>
                                <div class="attachment file-upload">
                                    <img src="{{asset('staff/assets/images/calender_s.svg')}}" class="specialimg" /> Drag and drop a file here or click
                                    <input type="file" name="file[]" multiple >
                                </div>

                            </div>
                            <div class="assign-columndate">
                                {{-- <p class="assign-heading">Due Date</p> --}}
                                <p class="req-exam">Due Date</p>

                                <input type="text"  id="datepick" class="req-box" name="due_date" placeholder="mm-dd-yyyy" required/>
                                <img src="{{asset('staff/assets/images/calender_s.svg')}}" />
                            </div>
                        </div>

                        <div class="assign-desc">
                            <p class="assign-heading">Description</p>
                            <textarea id="assignment_description"  class="desc-column" name="description" placeholder="Submit homework before last date."></textarea>

                        </div>
                    </div>

                    <button class="req-btn">Send Request</button>
                </div>
          </form>    
        </div>
    </div>


<!-- end Assignement Popup-->


<!-- Edit Popup-->
<div id="EditPopup" class="popup-overlay-edit">
    <div class="popup-box-edit">
        <h2 class="add-heading-edit">Edit Assignment</h2>
        
        <div class="desc-rows-edit">
             <img src="{{asset('staff/assets/images/reqCross.svg')}}" class="close-btn-edit" onclick="closeEditPopup()">

               <!-- Add hidden field for assignment ID -->
            <input type="hidden" id="edit_assignment_id" name="id">

            <div class="assign-align-edit">
                <div class="assign-column-edit">
                    <p class="assign-heading-edit">Subject</p>
                    {{-- <input type="text" placeholder="Select Subject" /> --}}
                    <select name="subject_id" id="edit_subject" required></select>
                    <img src="{{asset('staff/assets/images/greyarrow.svg')}}" />
                </div>

                <div class="assign-column">
                        <p class="assign-heading">Class</p>
                        {{-- <input type="text" placeholder="Select Subject" /> --}}
                        <select name="class_id" id="edit_class"></select>
                        <img src="{{asset('staff/assets/images/greyarrow.svg')}}" />
                </div>

                <div class="assign-columndate-edit">
                    <p class="assign-heading-edit">Due Date</p>
                    <input type="date" id="edit_date" name="due_date" class="assign-date" required>
                    <img src="{{asset('staff/assets/images/calender_s.svg')}}" />
                </div>
            </div>

            <div class="assign-align-edit">
                <div class="assign-column-edit">
                    <p class="assign-heading-edit">Assignment Title</p>
                    <input type="text"  id="edit_title" name="title" placeholder="Title" value="Lorem ipsum dolor sit amet, consectetur adipiscing elit" />
                </div>

                <div class="assign-columndate-edit">
                    <p class="assign-heading-edit">Grade</p>
                    <input type="number" id="edit_grade" name="grade" placeholder="30"  min="0" max="100" required />
                </div>
            </div>

            <div class="assign-column-edit">
                <p class="assign-heading-edit">Attachment</p>
                <div id="existing-attachments" class="existing-attachments">
                    <p>Current Attachments:</p>
                    <div id="attachments-list"></div>
                </div>
    
                <div class="attachment-edit file-upload">
                    <img src="{{asset('staff/assets/images/upload.svg')}}" class="specialimg"/> Drag and drop a file here or click
                    <input type="file" name="file[]" multiple >
                </div>  
            </div>

            <div class="assign-desc-edit">
                <p class="assign-heading-edit">Description</p>
                <textarea id="edit_description" class="desc-column-edit" name="description" placeholder="Submit homework before last date." ></textarea>
                
            </div>
        </div>

        <button type="submit" class="req-btn-edit">Save</button>
    </div>
</div>
<!-- Edit popup-->


 <!-- Delete Room Modal Begin -->
            <div class="modal fade cmn-popwrp popwrp w400" id="deleteAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteAssignmentModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon">
                            </span>
                        </button>

                        <div class="modal-body">
                            <div class="cmn-pop-inr-content-wrp">
                                <div class="modal-icon">
                                    <img src="{{ global_asset('backend/assets/images/bin-primary.svg') }}" alt="Bin Icon">
                                </div>
                                <div class="sec-head head-center">
                                    <h2>Delete!</h2>
                                    <p>Are you sure you want to delete exam type?</p>
                                    <form id="deleteAssignmentForm" method="post" >
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-wrp">
                                            <button type="submit" class="cmn-btn">Delete</button>
                                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

<!-- End Of Delete Room Modal -->

<!-- Read More Modal Begin -->

        <div class="modal fade cmn-popwrp" id="readMore" tabindex="-1" role="dialog"
                aria-labelledby="readMore" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{asset('staff/assets/images/cross-icon.svg')}}" alt="Icon"></span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2 id="assignmentModalTitle">Assignment Description</h2>
                            </div>

                            <div class="cmn-pop-inr-content-wrp">
                                <p id="assignmentModalDescription">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<!-- End Of Read More Modal -->

@endsection

@push('script')
<script>
    // Initialize CKEditor for description
    ClassicEditor
        .create(document.querySelector('#assignment_description'))
        .catch(error => {
            console.error(error);
        });
</script>

<script> 

    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.querySelector('.assignments');
        const popup = document.getElementById('assignmentPopup');
        const closeBtn = document.querySelector('.close-btn-assignment');
        const popupBox = document.querySelector('.popup-box-assignment');

        openBtn.addEventListener('click', function () {
            popup.style.display = 'flex';
        });

        closeBtn.addEventListener('click', function () {
            popup.style.display = 'none';
        });

        window.addEventListener('click', function (e) {
            if (e.target === popup) {
                popup.style.display = 'none';
            }
        });

    });

</script>

<script>
 // for add assignment
   $("#assignmentForm").on("submit", function (e) {
    e.preventDefault();

        let formData = new FormData(this);
        // console.log(formData);
        let editorData = document.querySelector('.ck-editor__editable').innerHTML;
        formData.set('description', editorData);

        // console.log(editorData);

        $.ajax({
            url: "{{ route('staff.assignment.store_assignment') }}",
            type: "POST",
            data: formData,
            processData: false,   
            contentType: false,   
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    showSuccess(response.message);
                    $("#assignmentPopup").hide();
                    $("#assignmentForm")[0].reset();
                    location.reload();

                } else {
                showError(response.message);
                }
            },
            error: function (xhr) {

                if (xhr.status === 422) {
                     console.log("422 ERROR:", xhr.responseJSON);
                    
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Please fix the following errors:\n";
                    for (let field in errors) {
                        errorMessage += "- " + errors[field][0] + "\n";
                    }
                    showError(errorMessage);
                } else {
                    showError("Error: Unable to submit assignment.");
                }
            }
        });
   });
</script>

<script>
$(document).ready(function() {
    //for read more
    $(document).on('click', '.read-more', function() {
        const $wrapper = $(this).closest('.toggle-text-wrapper');
        const description = $wrapper.data('description');
        const title = $wrapper.data('title');
    
        $('#assignmentModalTitle').text(title);
        $('#assignmentModalDescription').text(description);
    });

   // for delete assignment 
    $(document).on("click", ".deleteAssignmentBtn", function () {
        let id = $(this).data("id");
        let url = "{{ route('staff.assignment.destroyAssignment', ':id') }}";
        url = url.replace(':id', id);

        $("#deleteAssignmentForm").attr("action", url);
    });


   $(document).on("submit", "#deleteAssignmentForm", function (e) {
        e.preventDefault();

        let url = $(this).attr("action");

        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE" 
            },
            success: function (response) {
                if (response.status) {
                    showSuccess(response.message);
                    $('#deleteAssignmentModal').modal('hide');

                    setTimeout(function() {
                        location.reload();
                    }, 1200);
                } else {
                    showError(response.message);
                }
            },
            error: function (xhr) {
                console.log(xhr);
                showError("Something went wrong!");
            }
        });
   });

    
});

</script>

<script>
    //for switch tab
    document.addEventListener('DOMContentLoaded', function() {
        function showTab(tabName) {

            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            
            document.querySelectorAll('.tab-switch').forEach(tab => {
                tab.classList.remove('active');
            });
            
            const selectedTab = document.querySelector(`.${tabName}`);
            if (selectedTab) {
                selectedTab.style.display = 'block';
            
                const tableContainer = selectedTab.querySelector('[class*="-assignments"]');
                if (tableContainer) {
                    tableContainer.style.display = 'block';
                }
            }
            
            const tabHeader = document.querySelector(`[data-tab="${tabName}"]`);
            if (tabHeader) {
                tabHeader.classList.add('active');
            }
        }

        document.querySelectorAll('.tab-switch').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                showTab(tabName);
            });
        });

        showTab('current-tab');
    });
</script>

<script>
 // for upload assignment   
$(document).ready(function () {

    $(document).on("click", ".view-attachment-btn", function () {
        let assignmentId = $(this).data("assignment-id");
        // console.log('assignment id',assignmentId);
        $("#uploadAssignmentId").val(assignmentId);

        $baseurl = "{{ route('staff.assignment.getAssignementMedia', ':id') }}",

        $.ajax({
            url: baseurl.replace(':id', assignmentId),
            type: "GET",
            success: function (data) {
                // console.log(' get data',data);
                let html = "";
                $.each(data, function (i, file) {
                    html += `
                        <li class="assignment-column">
                            <p>Assignment No: ${file.assignment_id}</p>
                            <p>Title: ${file.title}</p>
                            <p>Grade: ${file.grade}</p>
                            <p>File: ${file.file_name}</p>
                            <p>File Format: ${file.media_type.toUpperCase()}</p>
                            
                        </li>
                    `;
                });
                $(".uploads").html(html);
            }
        });
    });

    
    $("#uploadFile").on("change", function () {
        let file = this.files[0];
        uploadAssignmentFile(file);
    });

    let dropZone = $("#dropZone");
    dropZone.on("dragover dragenter", function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.addClass("drag-active");
    });

    dropZone.on("dragleave dragend drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.removeClass("drag-active");
    });

   
    dropZone.on("drop", function (e) {
        let files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            uploadAssignmentFile(files[0]);
        }
    });

    function uploadAssignmentFile(file) {
        let assignmentId = $("#uploadAssignmentId").val();
        // console.log('assignment id for upload',assignmentId);
        let formData = new FormData();

        formData.append("file", file);
        formData.append("assignment_id", assignmentId);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: "{{ route('staff.assignment.uploadAssignmentMedia') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (!response.status) {
                    showError(response.message);
                    return;
                }

                showSuccess(response.message);

                $(".view-attachment-btn[data-assignment-id='" + assignmentId + "']").click();
            }
        });
    }
});
</script>

<script>
    // for edit assignment
    function openEditPopup(id)
    {
        // console.log('Opening edit popup for assignment:', id);
        // console.log('EditPopup element:', $('#EditPopup'));
        
        $.ajax({
            url: "{{ route('staff.assignment.editAssignment', '') }}/" + id,
            type: "GET",
            success: function(response) {
                console.log('AJAX success, response:', response);
                
                if (response.status) {
                    let assignment = response.data;
                    // console.log('Assignment data:', assignment);
                    $('#edit_assignment_id').val(assignment.id);

                    $('#edit_subject').empty().append('<option value="">Select Subject</option>');
                    response.subjects.forEach(function(subject) {
                        $('#edit_subject').append(
                            `<option value="${subject.id}">${subject.name}</option>`
                        );
                    });

                    $('#edit_class').empty().append('<option value="">Select Class</option>');
                    response.classes.forEach(function(cls) {
                        $('#edit_class').append(
                            `<option value="${cls.id}">${cls.name}</option>`
                        );
                    });

                    // Set current values
                    $('#edit_subject').val(assignment.subject_id);
                    $('#edit_class').val(assignment.class_id);
                    $('#edit_title').val(assignment.title);
                    $('#edit_grade').val(assignment.grade);
                    $('#edit_description').val(assignment.description);

                    if (assignment.due_date) {
                        let dueDate = assignment.due_date;
                        console.log('Due date raw:', dueDate);
                        
                        if (dueDate.includes('T')) {
                            dueDate = dueDate.split('T')[0];
                        }
                        // console.log('Due date formatted:', dueDate);
                        $('#edit_date').val(dueDate);
                    }

                    displayExistingAttachments(response.media || []);

                    $('#EditPopup').show();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert("Something went wrong!");
            }
        });
    }

    // Function to display existing attachments
    function displayExistingAttachments(media) {
        const attachmentsList = $('#attachments-list');
        attachmentsList.empty();
        
        if (media.length === 0) {
            attachmentsList.html('<p>No attachments</p>');
            return;
        }
        
        media.forEach(function(file) {
            const fileItem = `
                <div class="attachment-item" style="display: flex; justify-content: space-between; align-items: center; margin: 5px 0; padding: 5px; border: 1px solid #ddd;">
                    <span>${file.file_name || 'File'}</span>
                
                </div>
            `;
            attachmentsList.append(fileItem);
        });
        
    
    }

    function closeEditPopup() {
        $('#EditPopup').hide();
    }

    $(document).ready(function () {
        $(document).on('click', '.edit-icon', function() {
            var id = $(this).data('id');
            // console.log('Edit icon clicked, id:', id);
            openEditPopup(id);
        });
        
        
       // Save button handler
       $('.req-btn-edit').click(function() {
        let formData = {

            _token: "{{ csrf_token() }}",
            id: $('#edit_assignment_id').val(),
            subject_id: $('#edit_subject').val(),
            class_id: $('#edit_class').val(),
            title: $('#edit_title').val(),
            grade: $('#edit_grade').val(),
            due_date: $('#edit_date').val(),
            description: $('#edit_description').val()
        };

        // console.log('Sending update data:', formData);

        $.ajax({
            url: "{{ route('staff.assignment.updateAssignment') }}",
            type: "POST",
            data: formData,
            success: function(response){
                // console.log('Update response:', response);
                if(response.status){
                    showSuccess(response.message);
                    $('#EditPopup').hide();
                    location.reload();
                } else {
                    if (response.errors) {
                        // Display validation errors
                        let errorMessages = [];
                        for (let field in response.errors) {
                            errorMessages.push(response.errors[field][0]);
                        }
                        alert("Validation errors:\n" + errorMessages.join('\n'));
                    } else {
                        showError(response.message);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Update Error:', error);
                showError("Something went wrong!");
            }
        });
    });
});
</script>

 

@endpush