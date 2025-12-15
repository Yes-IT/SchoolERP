@extends('parent-panel.partials.master')
@section('content')
<!-- Start Dashboard -->
<div class="ds-breadcrumb">
    <h1>My Assignments</h1>
    <ul>
        <li><a href="{{ route('parent-panel-dashboard.index') }}">Dashboard</a> /</li>
        <li>My Assignments </li>
    </ul>
</div>
<div class="ds-pr-body">
    <div class="ds-cmn-table-wrp tab-wrapper">
        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Assignments</h2>
            </div>
            <div class="cmn-tab-head">
                <ul>
                    <li class="tab-bg"></li>
                    <li class="tab-btn {{ $activeTab == 'pending' ? 'active' : '' }}" data-tab="pending">
                        Pending
                    </li>

                    <li class="tab-btn {{ $activeTab == 'completed' ? 'active' : '' }}" data-tab="completed">
                        Completed
                    </li>
                </ul>
            </div>
        </div>

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
                       
                    </tr>
                </thead>
            
                <tbody>
                   
                    @forelse ($pending as $key => $assignment)
                       @php
                            $firstMedia = $assignment->media->first();

                            $fileName   = $firstMedia->file_name ?? '';
                            $fileFormat = $firstMedia->extension ?? '';

                            $downloadUrl = $firstMedia
                                ? route('parent-panel-assignment.assignment_download', [
                                    'filename' => urlencode($firstMedia->path)
                                ])
                                : '';
                        @endphp


                        <tr data-assignment-id="{{ $assignment->id }}" data-subject-id="{{ $assignment->subject_id }}">
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $assignment->subject_name }}</td>
                            <td>{{ $assignment->title }}</td>
                            <td>
                                {{-- <div class="toggle-text-wrapper">
                                    <div class="toggle-text-content">
                                        {{ $assignment->description }}
                                    </div>
                                </div> --}}

                               <div class="toggle-text-wrapper"
                                    data-description="{{ $assignment->description ?? 'No description' }}"
                                    data-title="{{ $assignment->title }}">
                                    
                                    <div class="toggle-text-content">
                                        {{ $assignment->description ?? 'No description' }}
                                    </div>
                                </div>

                            </td>
                            <td>
                                <button class="view-attachment-btn"
                                    data-bs-target="#viewAttachedDocs"
                                    data-bs-toggle="modal"
                                    data-id="{{ $assignment->id }}"
                                    data-title="{{ $assignment->title }}"
                                    data-subject="{{ $assignment->subject_name }}"
                                    data-media_type="{{ $firstMedia->media_type ?? '' }}"
                                    data-file_name="{{ $fileName }}"
                                    data-download-url="{{ $downloadUrl }}"
                                    data-grade="{{ $assignment->grade ?? 'Not graded yet' }}"
                                    data-format="{{ $fileFormat }}"
                                    @if(!$firstMedia) disabled @endif
                                >
                                    <img src="{{ asset('student/images/eye-white.svg') }}" alt="Eye Icon">
                                </button>
                            </td>



                            <td>{{ \Carbon\Carbon::parse($assignment->assigned_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') }}</td>

                        
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No assignments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{--  PAGINATION FOR PENDING  --}}
           <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        {{-- Prev --}}
                        @if ($pending->onFirstPage())
                            <li>
                                <a><img src="{{ asset('student/images/arrow-left.svg') }}"></a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $pending->appends(request()->query())->previousPageUrl() }}">
                                    <img src="{{ asset('student/images/arrow-left.svg') }}">
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($pending->getUrlRange(1, $pending->lastPage()) as $page => $url)
                            <li class="{{ $pending->currentPage() == $page ? 'active' : '' }}">
                                <a href="{{ $pending->appends(request()->query())->url($page) }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        {{-- Next --}}
                        @if ($pending->hasMorePages())
                            <li>
                                <a href="{{ $pending->appends(request()->query())->nextPageUrl() }}">
                                    <img src="{{ asset('student/images/arrow-right.svg') }}">
                                </a>
                            </li>
                        @else
                            <li>
                                <a><img src="{{ asset('student/images/arrow-right.svg') }}"></a>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Per Page --}}
                <div class="pages-select">
                    <form method="GET">
                        <input type="hidden" name="tab" value="pending">

                        {{-- Keep completed page parameters safe --}}
                        @if(request()->has('completed_page'))
                            <input type="hidden" name="completed_page" value="{{ request('completed_page') }}">
                        @endif

                        <div class="formfield">
                            <label>Per page</label>

                            <select name="pending_per_page" onchange="this.form.submit()">
                                @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $value)
                                    <option value="{{ $value }}"
                                        {{ request('pending_per_page', 5) == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <p>of {{ $pending->total() }} results</p>
                </div>
            </div>

            {{--  END PENDING PAGINATION  --}}

        </div>

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
                        <th>Submitted On</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @forelse ($completed as $key => $assignment)
                    <tr data-assignment-id="{{ $assignment->id }}"
                        data-subject-id="{{ $assignment->subject_id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $assignment->subject_name }}</td>
                        <td>{{ $assignment->title }}</td>
                        <td>
                            {{-- <div class="toggle-text-wrapper">
                                <div class="toggle-text-content">
                                    {{ $assignment->description }}
                                </div>
                            </div> --}}
                            <div class="toggle-text-wrapper"
                                data-description="{{ $assignment->description ?? 'No description' }}"
                                data-title="{{ $assignment->title }}">
                                
                                <div class="toggle-text-content">
                                    {{ $assignment->description ?? 'No description' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="view-attachment-btn" data-bs-target="#viewAttachedDocs"
                                data-bs-toggle="modal" data-id="{{ $assignment->id }}"
                                data-title="{{ $assignment->title }}"
                                data-subject="{{ $assignment->subject_name }}"
                                data-file="{{ $assignment->assignment_uploads ?? '' }}"
                                data-media_type="{{ $firstMedia->media_type ?? '' }}"
                                data-file_name="{{ $fileName ?? '' }}" data-download-url="{{ $downloadUrl }}">
                                <img src="{{ asset('student/images/eye-white.svg') }}" alt="Eye Icon">
                            </button>
                        </td>

                        <td>{{ \Carbon\Carbon::parse($assignment->assigned_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') }}</td>
                        <td>
                            <div class="submitted-on">
                                <span>{{ \Carbon\Carbon::parse($assignment->submitted_on)->format('d/m/Y') }}</span>
                                <div class="submitted-tag">Submitted</div>
                                <button class="edit-file-btn cmn-tbl-btn" data-bs-target="#viewAttachments"
                                    data-bs-toggle="modal" data-assignment-id="{{ $assignment->id }}"
                                    data-subject-id="{{ $assignment->subject_id }}"> <img src="{{ asset('student/images/eye-white.svg') }}" alt="Eye Icon"></button>
                            </div>
                        </td>
                        <!-- <td>
                           
                        </td> -->
                        <td>{{ $assignment->grade }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No assignments found.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>


            {{--  PAGINATION FOR COMPLETED --}}
           <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        {{-- Prev --}}
                        @if ($completed->onFirstPage())
                            <li><a><img src="{{ asset('student/images/arrow-left.svg') }}"></a></li>
                        @else
                            <li>
                                <a href="{{ $completed->appends(request()->query())->previousPageUrl() }}">
                                    <img src="{{ asset('student/images/arrow-left.svg') }}">
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($completed->getUrlRange(1, $completed->lastPage()) as $page => $url)
                            <li class="{{ $completed->currentPage() == $page ? 'active' : '' }}">
                                <a href="{{ $completed->appends(request()->query())->url($page) }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        {{-- Next --}}
                        @if ($completed->hasMorePages())
                            <li>
                                <a href="{{ $completed->appends(request()->query())->nextPageUrl() }}">
                                    <img src="{{ asset('student/images/arrow-right.svg') }}">
                                </a>
                            </li>
                        @else
                            <li><a><img src="{{ asset('student/images/arrow-right.svg') }}"></a></li>
                        @endif
                    </ul>
                </div>

                {{-- Per Page --}}
                <div class="pages-select">
                    <form method="GET">
                        <input type="hidden" name="tab" value="completed">

                        {{-- Keep pending_page safe --}}
                        @if(request()->has('pending_page'))
                            <input type="hidden" name="pending_page" value="{{ request('pending_page') }}">
                        @endif

                        <div class="formfield">
                            <label>Per page</label>

                            <select name="completed_per_page" onchange="this.form.submit()">
                                @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $value)
                                    <option value="{{ $value }}"
                                        {{ request('completed_per_page', 5) == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <p>of {{ $completed->total() }} results</p>
                </div>
            </div>

            {{--  END COMPLETED PAGINATION --}}

        </div>      
   </div>
</div>
<!-- End Dashboard -->

<!-- Attachments Modal Begin -->
{{-- <div class="modal fade cmn-popwrp pop800" id="viewAttachments" tabindex="-1" role="dialog"
    aria-labelledby="viewAttachments" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{ asset('student/images/cross-icon.svg') }}"
                        alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="tab-wrapper">
                    <div class="cmn-pop-head">
                        <div class="cmn-tab-head dif">
                            <ul>
                                <li class="tab-bg"
                                    style="   left: 12px;
                                                                top: 4px;
                                                                width: 123.156px;
                                                                height: 35px;">
                                </li>
                                <li class="active" id="new-upload-container">New Upload</li>
                                <li id="recent-upload-container">Recent</li>
                            </ul>
                        </div>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="cmn-tab-content new-upload">
                            <form action="{{ route('student.assignment.upload') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assignment_id" id="assignment_id" value="">
                                <input type="hidden" name="subject_id" id="subject_id" value="">

                                <div class="file-upload-lg">
                                    <input type="file" name="file"
                                        accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                    <div class="file-upld-lg-design">
                                        <div class="fupld-lg-icon">
                                            <img src="{{ asset('student/images/upload-white.svg') }}" alt="Icon">
                                        </div>
                                        <p class="upload-text">Click to browse or drag and drop your files</p>
                                    </div>
                                </div>

                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls,
                                        .xlsx files.</p>
                                </div>

                                <button type="submit" style="margin-top: 20px;"
                                    class="btn-sm cmn-btn">Upload</button>
                            </form>
                        </div>

                        <div class="cmn-tab-content recent">
                            <!-- Upload List Component -->
                            <div class="upload-list">
                                <ul class="uploads">
                                    @forelse ($pending as $assignment)
                                    @forelse ($assignment->media as $media)
                                    <li class="upload-item">
                                        <span class="icon pdf-icon">
                                            <img src="{{ asset('student/images/pdf-icon.svg') }}"
                                                alt="icon">
                                        </span>
                                        <div class="details">
                                            <span class="filename">{{ $media->file_name }}</span>
                                            <span
                                                class="timestamp">{{ \Carbon\Carbon::parse($media->updated_at)->diffForHumans() }}</span>
                                        </div>
                                        <span class="size">{{ $media->size }}</span>
                                        <button class="remove-btn">
                                            <img src="{{ asset('student/images/cross-circle.svg') }}"
                                                alt="Icon">
                                        </button>
                                    </li>
                                    @empty
                                    <li class="upload-item">
                                        <div class="details">
                                            <span class="filename text-muted">No uploads yet for this
                                                assignment</span>
                                        </div>
                                    </li>
                                    @endforelse
                                    @empty
                                    <li class="upload-item">
                                        <div class="details">
                                            <span class="filename text-muted">No assignments found</span>
                                        </div>
                                    </li>
                                    @endforelse
                                </ul>
                                <div class="btn-wrp">
                                    <button class="view-all-btn cmn-btn">View all uploads</button>
                                </div>
                                <div class="last-updated">
                                    <img src="{{ asset('student/images/check-circle.svg') }}" alt="Icon">
                                    Last updated:
                                    {{ \Carbon\Carbon::parse($assignment->last_updated)->format('d M Y, h:i A') }}
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div> --}}

<div class="modal fade cmn-popwrp pop800" id="viewAttachments" tabindex="-1" role="dialog" aria-labelledby="viewAttachments" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-show">
           
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-head">
                    <h2>Uploaded Files</h2>
                </div>

                @php
                    function getMediaIcon($media) {
                        $ext = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
                        // dd($ext);
                        

                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            return asset('parent/images/folder-icon.svg');
                        } elseif ($ext === 'pdf') {
                            return asset('parent/images/pdf-icon.svg');
                        } elseif (in_array($ext, ['mp4', 'mov', 'avi', 'wmv', 'mkv'])) {
                            return asset('parent/images/video.svg');
                        } else {
                            return asset('parent/images/file-icon.svg');
                        }
                    }
                @endphp
                <div class="viewAttachedDocs">
                    <!-- File Card 1 (Error) -->
                    {{-- <div class="attached-card file-error">
                        <div class="attached-doc-info photo-div">
                            <p><img src="{{asset('student/images/photo.svg')}}" class="photoupload" /></p>
                            <div class="photo-texts">
                            <p>Sheet-01.pdf</p>
                            <p>2d ago</p>
                            </div>
                        </div>
                        <div class="file-actions">
                            <span class="file-size">604KB</span>
                            <button class="remove-btn"><img src="{{asset('student/images/download-icon.svg')}}" class="cancelImg" /></button>
                        </div>
                    </div>

                    <!-- File Card 2 (Success) -->
                    <div class="attached-card">
                        <div class="attached-doc-info photo-div">
                            <p><img src="./images/photo.svg" class="photoupload" /></p>
                            <div class="photo-texts">
                            <p>Stock Photos</p>
                            <p>2d ago</p>
                            </div>
                        </div>
                        <div class="file-actions">
                            <span class="file-size">2.20GB</span>
                            <button class="remove-btn"><img src="./images/cancel.svg" class="cancelImg" /></button>
                        </div>
                    </div>

                    <!-- File Card 3 (Success) -->
                    <div class="attached-card">
                        <div class="attached-doc-info photo-div">
                            <p><img src="./images/video.svg" class="photoupload" /></p>
                            <div class="photo-texts">
                            <p>Assignment.mp4</p>
                            <p>2d ago</p>
                            </div>
                        </div>
                        <div class="file-actions">
                        <span class="file-size">1.46MB</span>
                            <button class="remove-btn"><img src="./images/cancel.svg" class="cancelImg" /></button>
                        </div>
                    </div> --}}

                      @forelse ($completed as $assignment)
                        @forelse ($assignment->media as $media)

                        <div class="attached-card">
                            <div class="attached-doc-info photo-div">

                                <p>
                                    <img src="{{ getMediaIcon($media) }}" class="photoupload" />
                                </p>

                                <div class="photo-texts">
                                    <p>{{ $media->file_name }}</p>
                                    <p>{{ \Carbon\Carbon::parse($media->updated_at)->diffForHumans() }}</p>
                                </div>

                            </div>

                            <div class="file-actions">
                                <span class="file-size">{{ $media->size }}</span>

                                {{-- download button --}}
                                <a href="{{ asset($media->path) }}" download class="remove-btn">
                                    <img src="{{ asset('student/images/download-icon.svg') }}" class="cancelImg" />
                                </a>
                            </div>
                        </div>

                        @empty
                            <p class="text-muted">No uploaded files</p>
                        @endforelse
                    @empty
                        <p class="text-muted">No assignments found</p>
                    @endforelse
                </div>
            </div>        
        </div>
    </div>
</div>

<!-- End Of Attachments Modal -->

<!-- uploaded File Modal Begin -->

<div class="modal fade cmn-popwrp pop800" id="UploadedFile" tabindex="-1" role="dialog" aria-labelledby="editFile"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{ asset('student/images/cross-icon.svg') }}"
                        alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Uploaded Files</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                       
                        <div class="cmn-tab-content">
                            <div class="upload-list">
                           

                                <ul class="uploads">
                                    @forelse ($completed as $assignment)
                                        @forelse ($assignment->media as $media)
                                            <li class="upload-item" style="justify-content: space-between;">

                                                <div class="details">
                                                    <img src="{{ asset('student/images/pdf-icon.svg') }}" alt="icon">
                                                    <span class="filename">{{ $media->file_name }}</span>
                                                    <span class="timestamp">{{ \Carbon\Carbon::parse($media->updated_at)->diffForHumans() }}</span>
                                                </div>

                                                <div class="view-attachment-btn" style="display: flex; align-items: center; gap: 150px;">
                                                    <span class="file-size">({{ $media->size }})</span>
                                                    {{-- <a href="{{ asset('backend/uploads/assignments/images/'.$media->file_name) }}"  download class="download-btn">
                                                    <img src="{{ asset('student/images/download-icon.svg') }}" alt="">
                                                    </a> --}}

                                                    <a href="{{ asset($media->path) }}" download class="download-btn">
                                                        <img src="{{ asset('student/images/download-icon.svg') }}" alt="">
                                                    </a>
                                                </div>  
                                            </li>
                                        @empty
                                        {{-- <li class="upload-item">
                                            <div class="details">
                                                <span class="filename text-muted">No uploads yet for this assignment</span>
                                            </div>
                                        </li> --}}
                                         <p class="text-muted">No uploads yet.</p>
                                         @endforelse
                                   
                                    @empty
                                        {{-- <li class="upload-item">
                                            <div class="details">
                                                <span class="filename text-muted">No assignments found</span>
                                            </div>
                                        </li> --}}
                                       <p class="text-muted">No assignments found.</p>

                                    @endforelse
                                </ul>
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

<div class="modal fade cmn-popwrp pop800" id="viewAttachedDocs" tabindex="-1" role="dialog"
    aria-labelledby="viewAttachedDocs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{ asset('student/images/cross-icon.svg') }}"
                        alt="Icon"></span>
            </button>
            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Attached Files</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="viewAttachedDocs">
                            <!-- Assignment details will be inserted dynamically -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Of viewAttachedDocs Modal -->

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
    document.addEventListener("DOMContentLoaded", function() {

        let activeTab = "{{ $activeTab }}";

        if (activeTab === "completed") {

            // Switch tab header
            document.querySelectorAll(".cmn-tab-head li")[1].classList.remove("active");
            document.querySelectorAll(".cmn-tab-head li")[2].classList.add("active");

            // Switch sections
            document.querySelector(".pending-section").style.display = "none";
            document.querySelector(".completed-section").style.display = "block";
        }
    });



    $(document).on('click', '.file-upload-btn, .edit-file-btn', function() {
        let assignmentId = $(this).data('assignment-id');
        let subjectId = $(this).data('subject-id');

        // Fill the hidden inputs in the modal form
        $('#assignment_id').val(assignmentId);
        $('#subject_id').val(subjectId);

        $('#edit_assignment_id').val(assignmentId);
        $('#edit_subject_id').val(subjectId);


    });

     // changes by nazmin
    document.addEventListener('DOMContentLoaded', function() {
        $(document).on('click', '.view-attachment-btn', function() {
            const assignmentId = $(this).data('id');
            const title = $(this).data('title');
            const downloadUrl = $(this).data('download-url');
            const fileFormat = $(this).data('format') || 'N/A';
            const grade = $(this).data('grade') || 'Not graded yet';

            let fileSection = `
                <div class="attached-doc-card">
                    <div class="attached-doc-info">
                        <p>Assignment No: ${assignmentId}</p>
                        <p><strong>Grade:</strong> ${grade}</p>
                        <p><strong>Title:</strong> ${title}</p>
                        <p><strong>File Format:</strong> ${fileFormat.toUpperCase()}</p>
                    </div>

                    <div class="btn-wrp">
                        <a href="${downloadUrl}"
                            class="cmn-btn ${downloadUrl ? '' : 'disabled'}"
                            ${downloadUrl ? '' : 'disabled'}
                            download>
                            Download
                        </a>
                    </div>
                </div>
            `;

            $('.viewAttachedDocs').html(fileSection);
        });
    });

</script>




<script>
    $('.cmn-tab-btn').on('click', function() {
        let tab = $(this).data('tab');

        // Update the URL (no refresh)
        let baseUrl = window.location.origin + window.location.pathname;
        let newUrl = baseUrl + '?tab=' + tab;
        window.history.pushState({}, '', newUrl);

        // FIX pagination - update all pagination links
        $('.tablepagination a').each(function() {
            let href = $(this).attr('href');

            if (!href) return;

            // Remove old tab value
            href = href.replace(/tab=\w+/g, '');

            // Remove ?& or && duplicates
            href = href.replace(/[?&]+$/, '');

            // Add correct tab
            if (href.includes('?')) {
                href += '&tab=' + tab;
            } else {
                href += '?tab=' + tab;
            }

            $(this).attr('href', href);
        });
    });
</script>


<script>
    $("#recent-upload-container").click(function() {
        $(".cmn-tab-content.recent").css("display", "block");
        $(".cmn-tab-content.new-upload").css("display", "none");

        $("#recent-upload-container").addClass("active");
        $("#new-upload-container").removeClass("active");
    });

    $("#new-upload-container").click(function() {
        $(".cmn-tab-content.recent").css("display", "none");
        $(".cmn-tab-content.new-upload").css("display", "block");

        $("#new-upload-container").addClass("active");
        $("#recent-upload-container").removeClass("active");
    });
</script>

<script>
 //changes by nazmin with read more modal functionality   
$(document).ready(function () {

    $(document).on('click', '.read-more', function (e) {
        e.preventDefault(); 

        const wrapper = $(this).closest('.toggle-text-wrapper');
        const description = wrapper.data('description');
        const title = wrapper.data('title');

        $('#assignmentModalTitle').text(title);
        $('#assignmentModalDescription').text(description);

        $('#readMore').modal('show');
    });

    $(document).off('click', '.toggle-text-wrapper .read-more');
});


</script>



@endpush