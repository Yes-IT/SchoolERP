@extends('backend.master')

@section('title')
    {{ ___('common.School Management System | Recorded Classes') }}
@endsection

@section('content')
<style>
.ds-vdo-gl-media {
    position: relative;
    overflow: hidden;
    height: 150px !important;
}
.upload-disabled {
    pointer-events: none;
    opacity: 0.5;
}
.upload-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>

    <div class="ds-breadcrumb">
        <h1>Recorded Classes</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li>Recorded Classes</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        <div class="ds-cmn-table-wrp tab-wrapper">
            <div class="ds-content-head">
                <div class="cmn-tab-head">
                    <ul>
                        <li class="tab-bg"></li>
                        <li class="active" data-tab="video"><span data-tab="video">Videos</span></li>
                        <li class="" data-tab="audio"><span data-tab="audio">Audios</span></li>
                    </ul>
                </div>
                <div class="dsbdy-filter-wrp p-0 align-items-start">
                    <div class="input-grp search-field mb-0">
                        <input type="text" id="searchInput" placeholder="Search Recorded Class">
                        <input type="submit" value="Search" id="searchButton">
                    </div>
                    <button class="cmn-btn btn-sm add-media-btn" data-bs-target="#addMedia" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i> <span class="btn-text">Add Video</span>
                    </button>
                </div>
            </div>

            <!-- Videos Table -->
            <div class="ds-cmn-tble video active">
                <div class="ds-vdo-gl-wrp">
                    <div class="row" id="videoList">
                        @forelse($videos as $item)
                            <div class="ds-vdo-gl-cd-wrp col-lg-3" data-search="{{ strtolower($item->title . ' ' . $item->author . ' ' . ($item->class ? $item->class->name : '') . ' ' . $item->speaker) }}">
                                <div class="ds-vdo-gl-cd">
                                    <div class="">
                                        <div class="ds-vdo-gl-media" style="position: relative;">
                                            <a data-fancybox="gallery" href="{{ Storage::disk('public')->url($item->path) }}">
                                                <video width="100%" height="auto" poster="">
                                                    <source src="{{ Storage::disk('public')->url($item->path) }}" type="video/mp4">
                                                </video>
                                                <img src="{{ global_asset('backend/assets/images/play-icon.svg') }}" alt="Play" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; cursor: pointer;">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ds-vdo-gl-content">
                                        <div class="ds-vdo-gl-info">
                                            <h3>Title: {{ $item->title }}</h3>
                                            <p><strong>Author:</strong> {{ $item->author }}</p>
                                            <p><strong>Category:</strong> {{ $item->class ? $item->class->name : 'N/A' }}</p>
                                            <p><strong>Speaker:</strong> {{ $item->speaker }}</p>
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y \a\t h:i a') }}</p>
                                        </div>
                                        <div class="ds-vdo-gl-cd-actions btn-wrp">
                                            <button type="button" class="cmn-btn btn-sm edit-media" data-bs-toggle="modal" data-bs-target="#editMedia" data-id="{{ $item->id }}" data-size="{{ $item->size }}" data-title="{{ $item->title }}" data-author="{{ $item->author }}" data-class_id="{{ $item->class_id }}" data-speaker="{{ $item->speaker }}" data-date="{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}" data-filename="{{ $item->filename }}">Edit</button>
                                            <button type="button" class="cmn-btn btn-sm btn-danger delete-media" data-bs-toggle="modal" data-bs-target="#deleteMedia" data-id="{{ $item->id }}">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">No record found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Audios Table -->
            <div class="ds-cmn-tble audio">
                <div class="ds-vdo-gl-wrp">
                    <div class="row" id="audioList">
                        @forelse($audios as $item)
                            <div class="ds-vdo-gl-cd-wrp col-lg-3" data-search="{{ strtolower($item->title . ' ' . $item->author . ' ' . ($item->class ? $item->class->name : '') . ' ' . $item->speaker) }}">
                                <div class="ds-vdo-gl-cd">
                                    <div class="ds-vdo-gl-media">
                                        <a data-fancybox="gallery" href="{{ Storage::disk('public')->url($item->path) }}">
                                            <img src="{{ global_asset('backend/assets/images/audio-play.svg') }}" alt="Play">
                                        </a>
                                    </div>
                                    <div class="ds-vdo-gl-content">
                                        <div class="ds-vdo-gl-info">
                                            <h3>Title: {{ $item->title }}</h3>
                                            <p><strong>Author:</strong> {{ $item->author }}</p>
                                            <p><strong>Category:</strong> {{ $item->class ? $item->class->name : 'N/A' }}</p>
                                            <p><strong>Speaker:</strong> {{ $item->speaker }}</p>
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y \a\t h:i a') }}</p>
                                        </div>
                                        <div class="ds-vdo-gl-cd-actions btn-wrp">
                                            <button type="button" class="cmn-btn btn-sm edit-media" data-bs-toggle="modal" data-bs-target="#editMedia" data-id="{{ $item->id }}" data-size="{{ $item->size }}" data-title="{{ $item->title }}" data-author="{{ $item->author }}" data-class_id="{{ $item->class_id }}" data-speaker="{{ $item->speaker }}" data-date="{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}" data-filename="{{ $item->filename }}">Edit</button>
                                            <button type="button" class="cmn-btn btn-sm btn-danger delete-media" data-bs-toggle="modal" data-bs-target="#deleteMedia" data-id="{{ $item->id }}">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">No record found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Media Modal -->
    <div class="modal fade cmn-popwrp pop800" id="addMedia" tabindex="-1" role="dialog" aria-labelledby="addMedia" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Add Media</h2>
                        </div>
                        <div class="cmn-pop-inr-content-wrp">
                            <div class="cmn-tab-content mb-4">
                                <form id="add-media-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="file-upload-lg">
                                        <input type="file" name="file" id="media-file" accept=".mp4,.mp3">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="{{ global_asset('backend/assets/images/upload-file-icon.svg') }}" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop your files</p>
                                        </div>
                                    </div>
                                    <div class="note">
                                        <p id="file-support-note">Supports .mp4 for videos</p>
                                        <div class="ibtn">
                                            <button type="button" class="ibtn-icon">
                                                <img src="{{ global_asset('backend/assets/images/i-icon.svg') }}" alt="Icon">
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="cmn-tab-content">
                                <div class="upload-list">
                                    <ul class="Uploads" id="upload-list">
                                        <!-- Uploaded files will be appended here -->
                                    </ul>
                                    <div class="multi-input-grp grp-2 mt-3">
                                        <div class="input-grp">
                                            <label for="title">Title</label>
                                            <input id="title" name="title" type="text" placeholder="Title Name" />
                                        </div>
                                        <div class="input-grp">
                                            <label for="author">Author</label>
                                            <input id="author" name="author" type="text" placeholder="Author Name" />
                                        </div>
                                    </div>
                                    <div class="multi-input-grp grp-2">
                                        <div class="input-grp">
                                            <label for="speaker">Speaker</label>
                                            <input id="speaker" name="speaker" type="text" placeholder="Speaker Name" />
                                        </div>
                                        <div class="input-grp">
                                            <label for="class_id">Category (Class)</label>
                                            <select id="class_id" name="class_id">
                                                <option value="">Select Class</option>
                                                @foreach(\App\Models\Academic\Classes::all() as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="multi-input-grp grp-2">
                                        <div class="input-grp">
                                            <label for="date">Date</label>
                                            <input id="date" name="date" type="date" placeholder="Select Date" />
                                        </div>
                                    </div>
                                    <div class="btn-wrp justify-content-end">
                                        <button class="btn-sm cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button class="btn-sm cmn-btn" id="save-media">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Media Modal -->
    <div class="modal fade cmn-popwrp pop800" id="editMedia" tabindex="-1" role="dialog" aria-labelledby="editMedia" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Icon"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Edit Media</h2>
                        </div>
                        <div class="cmn-pop-inr-content-wrp">
                            <div class="cmn-tab-content mb-4">
                                <form id="edit-media-form" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="editId">
                                    <div class="file-upload-lg">
                                        <input type="file" name="file" id="edit-media-file" accept=".mp4,.mp3">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="{{ global_asset('backend/assets/images/upload-file-icon.svg') }}" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop your files</p>
                                        </div>
                                    </div>
                                    <div class="note">
                                        <p id="edit-file-support-note">Supports .mp4 for videos</p>
                                        <div class="ibtn">
                                            <button type="button" class="ibtn-icon">
                                                <img src="{{ global_asset('backend/assets/images/i-icon.svg') }}" alt="Icon">
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="cmn-tab-content">
                                <div class="upload-list">
                                    <ul class="Uploads" id="edit-upload-list">
                                        <!-- Uploaded files will be appended here -->
                                    </ul>
                                    <div class="multi-input-grp grp-2 mt-3">
                                        <div class="input-grp">
                                            <label for="edit-title">Title</label>
                                            <input id="edit-title" name="title" type="text" placeholder="Title Name" />
                                        </div>
                                        <div class="input-grp">
                                            <label for="edit-author">Author</label>
                                            <input id="edit-author" name="author" type="text" placeholder="Author Name" />
                                        </div>
                                    </div>
                                    <div class="multi-input-grp grp-2">
                                        <div class="input-grp">
                                            <label for="edit-speaker">Speaker</label>
                                            <input id="edit-speaker" name="speaker" type="text" placeholder="Speaker Name" />
                                        </div>
                                        <div class="input-grp">
                                            <label for="edit-class_id">Category (Class)</label>
                                            <select id="edit-class_id" name="class_id">
                                                <option value="">Select Class</option>
                                                @foreach(\App\Models\Academic\Classes::all() as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="multi-input-grp grp-2">
                                        <div class="input-grp">
                                            <label for="edit-date">Date</label>
                                            <input id="edit-date" name="date" type="date" placeholder="Select Date" />
                                        </div>
                                    </div>
                                    <div class="btn-wrp justify-content-end">
                                        <button class="btn-sm cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button class="btn-sm cmn-btn" id="update-media">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Media Modal -->
    <div class="modal fade cmn-popwrp" id="deleteMedia" tabindex="-1" role="dialog" aria-labelledby="deleteMedia" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Close"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Delete Media</h2>
                        </div>
                        <div class="cmn-pop-inr-content-wrp">
                            <div class="cmn-tab-content mb-4">
                                <p>Are you sure you want to delete this media item?</p>
                                <form id="deleteMediaForm">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" id="deleteId">
                                    <div class="btn-wrp justify-content-end">
                                        <button type="button" class="btn-sm cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button type="button" class="btn-sm cmn-btn btn-danger" id="confirmDelete">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Format file size function
    function formatFileSize(bytes) {
        if (!bytes) return '0 KB';
        if (bytes < 1024) return bytes + ' B';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
        else return (bytes / 1048576).toFixed(2) + ' MB';
    }

    // Initialize Fancybox for both video and audio
    Fancybox.bind("[data-fancybox='gallery']", {
        Thumbs: false,
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: [],
                right: ["close"],
            },
        },
        Html: {
            video: {
                autoplay: true,
                controls: true,
            },
            audio: {
                autoplay: true,
                controls: true,
            },
        },
    });

    // Search functionality
    $('#searchInput').on('input', function () {
        const searchTerm = $(this).val().toLowerCase().trim();
        const activeTab = $('.cmn-tab-head li.active').data('tab');
        const targetList = activeTab === 'video' ? '#videoList' : '#audioList';

        $(targetList).find('.ds-vdo-gl-cd-wrp').each(function () {
            const $item = $(this);
            const searchData = $item.data('search') || '';
            
            if (searchTerm === '' || searchData.includes(searchTerm)) {
                $item.show();
            } else {
                $item.hide();
            }
        });

        // Show/hide "No record found" message
        const visibleItems = $(targetList).find('.ds-vdo-gl-cd-wrp:visible').length;
        const noRecordMessage = $(targetList).find('.text-center');
        
        if (visibleItems === 0 && !noRecordMessage.length) {
            $(targetList).append('<div class="col-12"><p class="text-center">No record found</p></div>');
        } else if (visibleItems > 0 && noRecordMessage.length) {
            noRecordMessage.parent().remove();
        }
    });

    // Clear search input on tab change
    $('.cmn-tab-head li').on('click', function () {
        $('#searchInput').val('');
        $('#videoList .ds-vdo-gl-cd-wrp, #audioList .ds-vdo-gl-cd-wrp').show();
        $('#videoList .text-center, #audioList .text-center').parent().remove();
        
        const tabType = $(this).data('tab');
        const addButton = $('.add-media-btn');
        const addButtonText = addButton.find('.btn-text');
        const mediaFileInput = $('#media-file');
        const editMediaFileInput = $('#edit-media-file');
        const fileSupportNote = $('#file-support-note');
        const editFileSupportNote = $('#edit-file-support-note');

        if (tabType === 'video') {
            addButtonText.text('Add Video');
            addButton.attr('data-bs-target', '#addMedia');
            mediaFileInput.attr('accept', '.mp4');
            editMediaFileInput.attr('accept', '.mp4');
            fileSupportNote.text('Supports .mp4 for videos');
            editFileSupportNote.text('Supports .mp4 for videos');
        } else if (tabType === 'audio') {
            addButtonText.text('Add Audio');
            addButton.attr('data-bs-target', '#addMedia');
            mediaFileInput.attr('accept', '.mp3');
            editMediaFileInput.attr('accept', '.mp3');
            fileSupportNote.text('Supports .mp3 for audios');
            editFileSupportNote.text('Supports .mp3 for audios');
        }
    });

    // Handle file selection for add modal
    $('#media-file').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const fileSize = formatFileSize(file.size);
            const fileName = file.name;
            const timestamp = new Date().toLocaleTimeString();
            const icon = fileName.endsWith('.mp4') ? '{{ global_asset('backend/assets/images/video-reel-icon.svg') }}' : '{{ global_asset('backend/assets/images/audio-play.svg') }}';
            const uploadItem = `
                <li class="upload-item">
                    <span class="icon"><img src="${icon}" alt="icon"></span>
                    <div class="details">
                        <span class="filename">${fileName}</span>
                        <span class="timestamp">${timestamp}</span>
                    </div>
                    <span class="size">${fileSize}</span>
                    <button type="button" class="remove-btn"><img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove"></button>
                </li>`;
            $('#upload-list').html(uploadItem);

            // Handle remove button click
            $('.remove-btn').on('click', function () {
                $('#media-file').val('');
                $('#upload-list').empty();
            });
        }
    });

    // Handle form submission for adding media
    $('#save-media').on('click', function () {
        const form = $('#add-media-form')[0];
        const formData = new FormData(form);
        formData.append('title', $('#title').val());
        formData.append('author', $('#author').val());
        formData.append('class_id', $('#class_id').val());
        formData.append('speaker', $('#speaker').val());
        formData.append('date', $('#date').val());

        // Disable upload section
        $('.file-upload-lg, .btn-wrp').addClass('upload-disabled');

        $.ajax({
            url: '{{ route("admin.recorded-classes.store") }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                $('#addMedia').modal('hide');
                
                // Use setTimeout to ensure modal is fully hidden before reload
                setTimeout(() => {
                    location.reload();
                }, 300);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Validation failed:<br>';
                    $.each(errors, function (key, messages) {
                        errorMessage += messages.join('<br>') + '<br>';
                    });
                    Toast.fire({
                        icon: 'error',
                        title: errorMessage
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Error saving media'
                    });
                }
            },
            complete: function () {
                // Re-enable upload section
                $('.file-upload-lg, .btn-wrp').removeClass('upload-disabled');
            }
        });
    });

    // Handle edit button click to populate modal
    $(document).on('click', '.edit-media', function () {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const author = $(this).data('author');
        const class_id = $(this).data('class_id');
        const speaker = $(this).data('speaker');
        const date = $(this).data('date');
        const filename = $(this).data('filename');
        const size = $(this).data('size');
        
        const icon = filename.endsWith('.mp4') ? '{{ global_asset('backend/assets/images/video-reel-icon.svg') }}' : '{{ global_asset('backend/assets/images/audio-play.svg') }}';
        const fileSize = formatFileSize(size);
        const timestamp = new Date().toLocaleTimeString();
        const activeTab = $('.cmn-tab-head li.active').data('tab');
        const editFileSupportNote = $('#edit-file-support-note');

        $('#editId').val(id);
        $('#edit-title').val(title);
        $('#edit-author').val(author);
        $('#edit-class_id').val(class_id);
        $('#edit-speaker').val(speaker);
        $('#edit-date').val(date);
        $('#edit-media-file').attr('accept', activeTab === 'video' ? '.mp4' : '.mp3');
        editFileSupportNote.text(activeTab === 'video' ? 'Supports .mp4 for videos' : 'Supports .mp3 for audios');

        const uploadItem = `
            <li class="upload-item">
                <span class="icon"><img src="${icon}" alt="icon"></span>
                <div class="details">
                    <span class="filename">${filename}</span>
                    <span class="timestamp">${timestamp}</span>
                </div>
                <span class="size">${fileSize}</span>
                <button type="button" class="remove-btn"><img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove"></button>
            </li>`;
        $('#edit-upload-list').html(uploadItem);

        // Handle remove button click for edit modal
        $('.remove-btn').on('click', function () {
            $('#edit-media-file').val('');
            $('#edit-upload-list').empty();
        });
    });

    // Handle file selection for edit modal
    $('#edit-media-file').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const fileSize = formatFileSize(file.size);
            const fileName = file.name;
            const timestamp = new Date().toLocaleTimeString();
            const icon = fileName.endsWith('.mp4') ? '{{ global_asset('backend/assets/images/video-reel-icon.svg') }}' : '{{ global_asset('backend/assets/images/audio-play.svg') }}';
            const uploadItem = `
                <li class="upload-item">
                    <span class="icon"><img src="${icon}" alt="icon"></span>
                    <div class="details">
                        <span class="filename">${fileName}</span>
                        <span class="timestamp">${timestamp}</span>
                    </div>
                    <span class="size">${fileSize}</span>
                    <button type="button" class="remove-btn"><img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove"></button>
                </li>`;
            $('#edit-upload-list').html(uploadItem);

            // Handle remove button click
            $('.remove-btn').on('click', function () {
                $('#edit-media-file').val('');
                $('#edit-upload-list').empty();
            });
        }
    });

    // Handle form submission for updating media
    $('#update-media').on('click', function () {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('id', $('#editId').val());
        formData.append('title', $('#edit-title').val() || '');
        formData.append('author', $('#edit-author').val() || '');
        formData.append('class_id', $('#edit-class_id').val() || null);
        formData.append('speaker', $('#edit-speaker').val() || '');
        formData.append('date', $('#edit-date').val() || '');
        formData.append('coded_name', '');
        const file = $('#edit-media-file')[0].files[0];
        if (file) {
            formData.append('file', file);
        }

        // Log FormData
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $('.file-upload-lg, .btn-wrp').addClass('upload-disabled');

        $.ajax({
            url: '{{ route("admin.recorded-classes.update", ":id") }}'.replace(':id', $('#editId').val()),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success response:', response);
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                $('#editMedia').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 300);
            },
            error: function (xhr) {
                console.log('Error response:', xhr.responseJSON);
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Error updating media: ' + xhr.status
                });
            },
            complete: function () {
                $('.file-upload-lg, .btn-wrp').removeClass('upload-disabled');
            }
        });
    });

    // Handle delete button click to populate modal
    $(document).on('click', '.delete-media', function () {
        const id = $(this).data('id');
        $('#deleteId').val(id);
    });

    // Handle delete confirmation
    $('#confirmDelete').on('click', function () {
        const id = $('#deleteId').val();

        $.ajax({
            url: '{{ route("admin.recorded-classes.destroy", ":id") }}'.replace(':id', id),
            method: 'DELETE',
            data: {
                _token: $('input[name="_token"]').val()
            },
            success: function (response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                $('#deleteMedia').modal('hide');
                
                // Use setTimeout to ensure modal is fully hidden before reload
                setTimeout(() => {
                    location.reload();
                }, 300);
            },
            error: function (xhr) {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Error deleting media'
                });
            }
        });
    });

    // Clean up modal backdrops when modals are hidden
    $('#addMedia, #editMedia, #deleteMedia').on('hidden.bs.modal', function () {
        // Remove any stuck backdrops
        $('.modal-backdrop').remove();
        // Ensure body has correct classes
        $('body').removeClass('modal-open');
    });
});
</script>
@endpush