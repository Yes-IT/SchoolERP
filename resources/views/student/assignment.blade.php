@extends('student.Layout.app')

@section('content')
    <!-- Start Dashboard -->
    <div class="ds-breadcrumb">
        <h1>My Assignments</h1>
        <ul>
            <li><a href="{{ route('student.dashboard') }}">Dashboard</a> /</li>
            <li>My Assignments</li>
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
                        <li class="active">Pending</li>
                        <li>Completed</li>
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
                            <th>Upload File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assignments as $key => $assignment)
                            <tr data-assignment-id="{{ $assignment->id }}" data-subject-id="{{ $assignment->subject_id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $assignment->subject_name }}</td>
                                <td>{{ $assignment->title }}</td>
                                <td>
                                    <div class="toggle-text-wrapper">
                                        <div class="toggle-text-content">
                                            {{ $assignment->description }}
                                        </div>
                                    </div>

                                </td>
                                <td><button class="view-attachment-btn" data-bs-target="#viewAttachedDocs"
                                        data-bs-toggle="modal"><img src="{{ asset('student/images/eye-white.svg') }}"
                                            alt="Eye Icon"></button></td>

                                <td>{{ \Carbon\Carbon::parse($assignment->assigned_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="file-upload">
                                        <button class="file-upload-btn" data-bs-target="#viewAttachments"
                                            data-bs-toggle="modal"><img
                                                src="{{ asset('student/images/upload-white.svg') }}">Upload</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No assignments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                            <th>Edit File</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($completed_assignments as $key => $assignment)
                            <tr data-assignment-id="{{ $assignment->id }}"
                                data-subject-id="{{ $assignment->subject_id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $assignment->subject_name }}</td>
                                <td>{{ $assignment->title }}</td>
                                <td>
                                    <div class="toggle-text-wrapper">
                                        <div class="toggle-text-content">
                                            {{ $assignment->description }}
                                        </div>
                                    </div>

                                </td>
                                <td><button class="view-attachment-btn" data-bs-target="#viewAttachedDocs"
                                        data-bs-toggle="modal" data-assignment-media="{{ $assignment->media }}"><img
                                            src="{{ asset('student/images/eye-white.svg') }}" alt="Eye Icon"></button></td>

                                <td>{{ \Carbon\Carbon::parse($assignment->assigned_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="file-upload">
                                        <button class="file-upload-btn" data-bs-target="#viewAttachments"
                                            data-bs-toggle="modal"><img
                                                src="{{ asset('student/images/upload-white.svg') }}">Upload</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-dark">No assignments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        <li><a href="#url"><img src="{{ asset('student/images/arrow-left.svg') }}" alt="Icon"></a>
                        </li>
                        <li class="active"><a href="#url">1</a></li>
                        <li><a href="#url">2</a></li>
                        <li><a href="#url">3</a></li>
                        <li><a href="#url"><img src="{{ asset('student/images/arrow-right.svg') }}" alt="Icon"></a>
                        </li>
                    </ul>
                </div>

                <div class="pages-select">
                    <form>
                        <div class="formfield">
                            <label>Per page</label>
                            <select>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </form>
                    <p>of 2 results</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Dashboard -->

    <!-- Attachments Modal Begin -->
    <div class="modal fade cmn-popwrp pop800" id="viewAttachments" tabindex="-1" role="dialog"
        aria-labelledby="viewAttachments" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('student/images/cross-icon.svg') }}" alt="Icon"></span>
                </button>

                <div class="modal-body">
                    <div class="tab-wrapper">
                        <div class="cmn-pop-head">
                            <div class="cmn-tab-head dif">
                                <ul>
                                    <li class="tab-bg"></li>
                                    <li class="active">New Upload</li>
                                    <li>Recent</li>
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
                                            <p>Click to browse or drag and drop your files</p>
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
                                        <li class="upload-item">
                                            <span class="icon pdf-icon"><img
                                                    src="{{ asset('student/images/pdf-icon.svg') }}"
                                                    alt="icon"></span>
                                            <div class="details">
                                                <span class="filename">Sheet-01.pdf</span>
                                                <span class="timestamp">2m ago</span>
                                            </div>
                                            <span class="size">604KB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item">
                                            <span class="icon folder-icon"><img
                                                    src="{{ asset('student/images/folder-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">Stock Photos</span>
                                                <span class="timestamp">3m ago</span>
                                            </div>
                                            <span class="size">2.20GB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item">
                                            <span class="icon video-icon"><img
                                                    src="{{ asset('student/images/video-reel-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">Assignment.mp4</span>
                                                <span class="timestamp">5m ago</span>
                                            </div>
                                            <span class="size">1.46MB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item error">
                                            <span class="icon doc-icon"><img
                                                    src="{{ asset('student/images/document-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">Strategy-Pitch-Final.docx</span>
                                                <span class="timestamp">10m ago</span>
                                            </div>
                                            <div class="status">
                                                <button class="retry-btn">⟳</button>
                                                <span class="error-text">Error</span>
                                            </div>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item">
                                            <span class="icon image-icon"><img
                                                    src="{{ asset('student/images/gallery-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">man-holding-mobile-phone-while.jpg</span>
                                                <span class="timestamp">10m ago</span>
                                            </div>
                                            <span class="size">929KB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                    </ul>
                                    <div class="btn-wrp">
                                        <button class="view-all-btn cmn-btn">View all uploads</button>
                                    </div>
                                    <div class="last-updated"><img src="{{ asset('student/images/check-circle.svg') }}"
                                            alt="Icon"> Last updated: 3 mins ago</div>
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

    <div class="modal fade cmn-popwrp pop800" id="editFile" tabindex="-1" role="dialog" aria-labelledby="editFile"
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
                            <div class="cmn-tab-content mb-4">
                                <form>
                                    <div class="file-upload-lg">
                                        <input type="file"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="{{ asset('student/images/upload-white.svg') }}" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop your files</p>
                                        </div>
                                    </div>
                                    <div class="note">
                                        <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls,
                                            .xlsx files.</p>
                                        <div class="ibtn">
                                            <button type="button" class="ibtn-icon">
                                                <img src="{{ asset('student/images/i-icon.svg') }}" alt="Icon">
                                            </button>
                                            <div class="ibtn-info">
                                                <button type="button" class="ibtn-close">
                                                    <img src="{{ asset('student/images/fa-times.svg') }}" alt="icon">
                                                </button>
                                                <h3>Upload Guidelines</h3>
                                                <ul>
                                                    <li>Images larger than 5 MB are not accepted.</li>
                                                    <li>Videos must be under 10 MB in size.</li>
                                                    <li>If your files are larger, please upload them to your Google Drive
                                                        and share the link here. This helps ensure smooth uploads and better
                                                        convenience for you.</li>
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
                                            <span class="icon pdf-icon"><img
                                                    src="{{ asset('student/images/pdf-icon.svg') }}"
                                                    alt="icon"></span>
                                            <div class="details">
                                                <span class="filename">Sheet-01.pdf</span>
                                                <span class="timestamp">2m ago</span>
                                            </div>
                                            <span class="size">604KB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item">
                                            <span class="icon folder-icon"><img
                                                    src="{{ asset('student/images/folder-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">Stock Photos</span>
                                                <span class="timestamp">3m ago</span>
                                            </div>
                                            <span class="size">2.20GB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item">
                                            <span class="icon video-icon"><img
                                                    src="{{ asset('student/images/video-reel-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">Assignment.mp4</span>
                                                <span class="timestamp">5m ago</span>
                                            </div>
                                            <span class="size">1.46MB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item error">
                                            <span class="icon doc-icon"><img
                                                    src="{{ asset('student/images/doc-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">Strategy-Pitch-Final.docx</span>
                                                <span class="timestamp">10m ago</span>
                                            </div>
                                            <div class="status">
                                                <button class="retry-btn">⟳</button>
                                                <span class="error-text">Error</span>
                                            </div>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                        <li class="upload-item">
                                            <span class="icon image-icon"><img
                                                    src="{{ asset('student/images/gallery-icon.svg') }}"
                                                    alt="Icon"></span>
                                            <div class="details">
                                                <span class="filename">man-holding-mobile-phone-while.jpg</span>
                                                <span class="timestamp">10m ago</span>
                                            </div>
                                            <span class="size">929KB</span>
                                            <button class="remove-btn"><img
                                                    src="{{ asset('student/images/cross-circle.svg') }}"
                                                    alt="Icon"></button>
                                        </li>
                                    </ul>
                                    <div class="btn-wrp justify-content-end">
                                        <button class="btn-sm cmn-btn" data-bs-dismiss="modal"
                                            aria-label="Close">Cancel</button>
                                        <button class="btn-sm cmn-btn">Save Changes</button>
                                    </div>
                                    <div class="last-updated"><img src="{{ asset('student/images/check-circle.svg') }}"
                                            alt="Icon"> Last updated: 3 mins ago</div>
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
                            <div class="viewAttachedDocs" id="attachedDocsContent">
                                <!-- Dynamic content will be loaded here -->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Of viewAttachedDocs Modal -->
@endsection

@push('page_script')
    <script>
        $('#viewAttachedDocs').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var media = button.data('assignment-id');
            var assignmentId = button.data('assignment-id');
            var assignmentId = button.data('title');

            var modal = $(this);
            htmlContent = '';
            if (button.data('assignment-media')) {
                var mediaFiles = button.data('assignment-media').split(',');
                mediaFiles.forEach(function(file) {
                     htmlContent += `<div class="attached-doc-card">
                                    <div class="attached-doc-info">
                                        <p>Assignment No.- 24</p>
                                        <p>Title: Lorem Ipsum</p>
                                        <p>File Format: PDF File</p>
                                    </div>
                                    <div class="btn-wrp">
                                        <a href="{{ asset('student/images/document-icon.svg') }}"
                                            download="{{ asset('student/images/download-icon.svg') }}"
                                            class="cmn-btn">Download</a>
                                    </div>
                                </div>`;
                });
               
            } else {
                htmlContent = '<p>No attachments found for this assignment.</p>';
            }


        });
    </script>
    <script>
        document.querySelectorAll('.file-upload-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                let tr = button.closest('tr');
                let assignmentId = tr.dataset
                    .assignmentId;
                let subjectId = tr.dataset
                    .subjectId;
                gg

                document.getElementById('assignment_id').value = assignmentId;
                document.getElementById('subject_id').value = subjectId;
            });
        });
    </script>
@endpush
