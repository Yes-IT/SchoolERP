@extends('parent-panel.partials.master')
@section('content')
<!-- Start Dashboard -->
<div class="ds-breadcrumb">
    <h1>My Assignments</h1>
    <ul>
        <li><a href="{{ route('student.dashboard') }}">Dashboard</a> /</li>
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
                        <!-- <th>Upload File</th> -->
                    </tr>
                </thead>
                @php
                $fileName = $firstMedia->file_name ?? null;
                $downloadUrl = $fileName ? route('assignment.download', ['filename' => $fileName]) : '';
                @endphp

                <tbody>
                    {{-- @forelse ($assignments as $key => $assignment) --}}
                    @forelse ($pending as $key => $assignment)
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

                        <!-- <td>
                            <div class="file-upload">
                                <button class="file-upload-btn" data-bs-target="#viewAttachments"
                                    data-bs-toggle="modal" data-assignment-id="{{ $assignment->id }}"
                                    data-subject-id="{{ $assignment->subject_id }}">
                                    <img src="{{ asset('student/images/upload-white.svg') }}">Upload
                                </button>

                            </div>
                        </td> -->
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No assignments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ⭐⭐⭐ PAGINATION FOR PENDING ⭐⭐⭐ --}}
            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        {{-- Prev --}}
                        @if ($pending->onFirstPage())
                        <li><a><img src="{{ asset('student/images/arrow-left.svg') }}"></a></li>
                        @else
                        <li>
                            <a
                                href="{{ $pending->appends(request()->except('pending_page'))->appends(['tab' => 'pending'])->previousPageUrl() }}">
                                <img src="{{ asset('student/images/arrow-left.svg') }}">
                            </a>
                        </li>
                        @endif

                        {{-- Pages --}}
                        @foreach ($pending->getUrlRange(1, $pending->lastPage()) as $page => $url)
                        <li class="{{ $pending->currentPage() == $page ? 'active' : '' }}">
                            <a
                                href="{{ $pending->appends(request()->except('pending_page'))->appends(['tab' => 'pending'])->url($page) }}">
                                {{ $page }}
                            </a>
                        </li>
                        @endforeach

                        {{-- Next --}}
                        @if ($pending->hasMorePages())
                        <li>
                            <a
                                href="{{ $pending->appends(request()->except('pending_page'))->appends(['tab' => 'pending'])->nextPageUrl() }}">
                                <img src="{{ asset('student/images/arrow-right.svg') }}">
                            </a>
                        </li>
                        @else
                        <li><a><img src="{{ asset('student/images/arrow-right.svg') }}"></a></li>
                        @endif
                    </ul>

                </div>

                <div class="pages-select">
                    <form method="GET">
                        <input type="hidden" name="tab" value="pending">

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
            {{-- ⭐⭐⭐ END PENDING PAGINATION ⭐⭐⭐ --}}

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
                        <!-- <th>Edit File</th> -->
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php
                            $filteredAssignments = $assignments->whereNotNull('grade');
                        @endphp --}}
                    {{-- @forelse ($filteredAssignments as $key => $assignment) --}}
                    @forelse ($completed as $key => $assignment)
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
                                <button class="edit-file-btn cmn-tbl-btn" data-bs-target="#editFile"
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


            {{-- ⭐⭐⭐ PAGINATION FOR COMPLETED ⭐⭐⭐ --}}
            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        {{-- Prev --}}
                        @if ($completed->onFirstPage())
                        <li><a><img src="{{ asset('student/images/arrow-left.svg') }}"></a></li>
                        @else
                        <li>
                            <a
                                href="{{ $completed->appends(request()->except('completed_page'))->appends(['tab' => 'completed'])->previousPageUrl() }}">
                                <img src="{{ asset('student/images/arrow-left.svg') }}">
                            </a>
                        </li>
                        @endif

                        {{-- Pages --}}
                        @foreach ($completed->getUrlRange(1, $completed->lastPage()) as $page => $url)
                        <li class="{{ $completed->currentPage() == $page ? 'active' : '' }}">
                            <a
                                href="{{ $completed->appends(request()->except('completed_page'))->appends(['tab' => 'completed'])->url($page) }}">
                                {{ $page }}
                            </a>
                        </li>
                        @endforeach

                        {{-- Next --}}
                        @if ($completed->hasMorePages())
                        <li>
                            <a
                                href="{{ $completed->appends(request()->except('completed_page'))->appends(['tab' => 'completed'])->nextPageUrl() }}">
                                <img src="{{ asset('student/images/arrow-right.svg') }}">
                            </a>
                        </li>
                        @else
                        <li><a><img src="{{ asset('student/images/arrow-right.svg') }}"></a></li>
                        @endif
                    </ul>



                </div>

                <div class="pages-select">
                    <form method="GET">
                        <input type="hidden" name="tab" value="completed">

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
            {{-- ⭐⭐⭐ END COMPLETED PAGINATION ⭐⭐⭐ --}}

        </div>

        {{-- <div class="tablepagination">
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
</div> --}}
</div>
</div>
<!-- End Dashboard -->

<!-- Attachments Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="viewAttachments" tabindex="-1" role="dialog"
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
                        <h2>Attached Files</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <!-- <div class="cmn-tab-content mb-4">
                            <form action="{{ route('student.assignment.upload') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assignment_id" id="edit_assignment_id" value="">
                                <input type="hidden" name="subject_id" id="edit_subject_id" value="">

                                <div class="file-upload-lg">
                                    <input type="file" name="file"
                                        accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                    <div class="file-upld-lg-design">
                                        <div class="fupld-lg-icon">
                                            <img src="{{ asset('student/images/upload-white.svg') }}" alt="Icon">
                                        </div>
                                        <p class="upload-text-edit">Click to browse or drag and drop your files</p>
                                    </div>
                                </div>

                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls,
                                        .xlsx files.</p>
                                </div>

                                <button type="submit" style="margin-top: 20px;"
                                    class="btn-sm cmn-btn">Upload</button>
                            </form>
                        </div> -->

                        <div class="cmn-tab-content">
                            <div class="upload-list">
                                <ul class="uploads">
                                    @forelse ($completed as $assignment)
                                    @forelse ($assignment->media as $media)
                                    <li class="upload-item" style="justify-content: space-between;">


                                        <div class="details">
                                            <!-- <span class="icon pdf-icon"> -->
                                                <img src="{{ asset('student/images/pdf-icon.svg') }}" alt="icon">
                                            <!-- </span> -->
                                            <span class="filename">{{ $media->file_name }}</span>
                                            <span class="timestamp">{{ \Carbon\Carbon::parse($media->updated_at)->diffForHumans() }}</span>
                                        </div>

                                        <!-- <span class="size">{{ $media->size }}</span> -->

                                        <!-- 🔽 DOWNLOAD BUTTON -->
                                        <div class="view-attachment-btn">
                                            <a href="{{ asset('backend/uploads/assignments/images/'.$media->file_name) }}"  download class="download-btn">
                                              <img src="{{ asset('student/images/download-icon.svg') }}" alt="">
                                            </a>
                                        </div>
                                        <!-- ❌ DELETE BUTTON -->
                                        <!-- <button class="remove-btn">
                                            <img src="{{ asset('student/images/cross-circle.svg') }}" alt="Icon">
                                        </button> -->
                                    </li>
                                    @empty
                                    <li class="upload-item">
                                        <div class="details">
                                            <span class="filename text-muted">No uploads yet for this assignment</span>
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


    document.addEventListener('DOMContentLoaded', function() {
        $(document).on('click', '.view-attachment-btn', function() {
            const title = $(this).data('title');
            const subject = $(this).data('subject');
            const mediaType = $(this).data('media_type') || 'N/A';
            const downloadUrl = $(this).data('download-url');
            const fileName = $(this).data('assignment_uploads') || '';

            let fileSection = `
            <div class="attached-doc-card">
                <div class="attached-doc-info">
                    <p><strong>Subject:</strong> ${subject}</p>
                    <p><strong>Title:</strong> ${title}</p>
                    <p><strong>File Path:</strong> ${fileName}</p>
                </div>
                <div class="btn-wrp">
                    <a href="${downloadUrl || '#'}"
                       ${downloadUrl ? '' : 'disabled'}
                       class="cmn-btn ${downloadUrl ? '' : 'disabled'}"
                       download>
                       Download
                    </a>
                </div>
            </div>
        `;

            $('.viewAttachedDocs').html(fileSection);
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        $(document).on('click', '.view-attachment-btn', function() {
            const title = $(this).data('title');
            const subject = $(this).data('subject');
            const mediaType = $(this).data('media_type') || 'N/A';
            const downloadUrl = $(this).data('download-url');
            const fileName = $(this).data('file') || 'N/A';

            let fileSection = `
            <div class="attached-doc-card">
                <div class="attached-doc-info">
                    <p><strong>Subject:</strong> ${subject}</p>
                    <p><strong>Title:</strong> ${title}</p>
                    <p><strong>File Path:</strong> ${fileName}</p>
                </div>
                <div class="btn-wrp">
                    <a href="${downloadUrl || '#'}"
                       ${downloadUrl ? '' : 'disabled'}
                       class="cmn-btn ${downloadUrl ? '' : 'disabled'}"
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


@endpush