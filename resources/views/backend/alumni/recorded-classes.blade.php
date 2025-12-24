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

    /* Custom Toaster */
    #custom-toaster {
        visibility: hidden;
        min-width: 280px;
        margin-left: -140px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 16px 24px;
        position: fixed;
        z-index: 99999;
        left: 50%;
        bottom: 30px;
        font-size: 16px;
        font-weight: 500;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        transform: translateY(100px);
        transition: all 0.4s ease-in-out;
        line-height: 1.5;
    }
    #custom-toaster.show {
        visibility: visible;
        transform: translateY(0);
    }
    #custom-toaster.success {
        background-color: #28a745;
    }
    #custom-toaster.error {
        background-color: #dc3545;
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
                    <li class="active" data-tab="video"><span>Videos</span></li>
                    <li data-tab="audio"><span>Audios</span></li>
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
                                        <button type="button" class="cmn-btn btn-sm edit-media" data-bs-toggle="modal" data-bs-target="#editMedia"
                                            data-id="{{ $item->id }}"
                                            data-size="{{ $item->size }}"
                                            data-title="{{ $item->title }}"
                                            data-author="{{ $item->author }}"
                                            data-class_id="{{ $item->class_id }}"
                                            data-speaker="{{ $item->speaker }}"
                                            data-date="{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}"
                                            data-filename="{{ $item->filename }}">Edit</button>
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
                                        <button type="button" class="cmn-btn btn-sm edit-media" data-bs-toggle="modal" data-bs-target="#editMedia"
                                            data-id="{{ $item->id }}"
                                            data-size="{{ $item->size }}"
                                            data-title="{{ $item->title }}"
                                            data-author="{{ $item->author }}"
                                            data-class_id="{{ $item->class_id }}"
                                            data-speaker="{{ $item->speaker }}"
                                            data-date="{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}"
                                            data-filename="{{ $item->filename }}">Edit</button>
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
<div class="modal fade cmn-popwrp pop800" id="addMedia" tabindex="-1" aria-labelledby="addMedia" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                                    <input type="file" name="file" id="media-file" accept=".mp4">
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
                                <ul class="Uploads" id="upload-list"></ul>
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
                                        <input id="date" name="date" type="date" />
                                    </div>
                                </div>
                                <div class="btn-wrp justify-content-end">
                                    <button class="btn-sm cmn-btn" data-bs-dismiss="modal">Cancel</button>
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
<div class="modal fade cmn-popwrp pop800" id="editMedia" tabindex="-1" aria-labelledby="editMedia" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                                    <input type="file" name="file" id="edit-media-file" accept=".mp4">
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
                                <ul class="Uploads" id="edit-upload-list"></ul>
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
                                        <input id="edit-date" name="date" type="date" />
                                    </div>
                                </div>
                                <div class="btn-wrp justify-content-end">
                                    <button class="btn-sm cmn-btn" data-bs-dismiss="modal">Cancel</button>
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
<div class="modal fade cmn-popwrp" id="deleteMedia" tabindex="-1" aria-labelledby="deleteMedia" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                        <p>Are you sure you want to delete this media item?</p>
                        <form id="deleteMediaForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteId">
                            <div class="btn-wrp justify-content-end">
                                <button type="button" class="btn-sm cmn-btn" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn-sm cmn-btn btn-danger" id="confirmDelete">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
// Custom Toaster
function showToast(message, type = 'success') {
    const toaster = document.getElementById('custom-toaster');
    if (!toaster) return;

    toaster.textContent = message;
    toaster.className = 'show ' + type;

    setTimeout(() => {
        toaster.className = toaster.className.replace('show', '');
    }, 3500);
}

if (!document.getElementById('custom-toaster')) {
    const toasterDiv = document.createElement('div');
    toasterDiv.id = 'custom-toaster';
    document.body.appendChild(toasterDiv);
}

$(document).ready(function () {

    // Fancybox
    Fancybox.bind("[data-fancybox='gallery']", {
        Thumbs: false,
        Toolbar: { display: { left: ["infobar"], middle: [], right: ["close"] } },
        Html: { video: { autoplay: true }, audio: { controls: true } }
    });

    // Search functionality
    $('#searchInput').on('input', function () {
        const term = $(this).val().toLowerCase().trim();
        const activeTab = $('.cmn-tab-head li.active').data('tab');
        const list = activeTab === 'video' ? '#videoList' : '#audioList';

        let visible = 0;
        $(list).find('.ds-vdo-gl-cd-wrp').each(function () {
            const text = $(this).data('search') || '';
            if (term === '' || text.includes(term)) {
                $(this).show();
                visible++;
            } else {
                $(this).hide();
            }
        });

        const $msg = $(list).find('.col-12 p.text-center');
        if (visible === 0 && $msg.length === 0) {
            $(list).append('<div class="col-12"><p class="text-center">No record found</p></div>');
        } else if (visible > 0 && $msg.length > 0) {
            $msg.parent().remove();
        }
    });

    // Tab switching
    $('.cmn-tab-head li[data-tab]').on('click', function () {
        if ($(this).hasClass('active')) return;

        const tab = $(this).data('tab');

        $('.cmn-tab-head li').removeClass('active');
        $(this).addClass('active');

        $('.ds-cmn-tble').removeClass('active');
        $(`.ds-cmn-tble.${tab}`).addClass('active');

        // Update button text
        $('.add-media-btn .btn-text').text(tab === 'video' ? 'Add Video' : 'Add Audio');

        // Clear search
        $('#searchInput').val('').trigger('input');
    });

    // Update Add Modal when shown
    $('#addMedia').on('show.bs.modal', function () {
        const activeTab = $('.cmn-tab-head li.active').data('tab') || 'video';
        const accept = activeTab === 'video' ? '.mp4' : '.mp3';
        const note = activeTab === 'video' ? 'Supports .mp4 for videos' : 'Supports .mp3 for audios';

        $('#media-file').attr('accept', accept);
        $('#file-support-note').text(note);

        // Reset form
        $('#media-file').val('');
        $('#upload-list').empty();
        $('#title, #author, #speaker, #date').val('');
        $('#class_id').val('');
    });

    // Update Edit Modal when shown
    $('#editMedia').on('show.bs.modal', function () {
        const activeTab = $('.cmn-tab-head li.active').data('tab') || 'video';
        const accept = activeTab === 'video' ? '.mp4' : '.mp3';
        const note = activeTab === 'video' ? 'Supports .mp4 for videos' : 'Supports .mp3 for audios';

        $('#edit-media-file').attr('accept', accept);
        $('#edit-file-support-note').text(note);
    });

    // File preview - Add modal
    $('#media-file').on('change', function (e) {
        const file = e.target.files[0];
        $('#upload-list').empty();
        if (file) {
            const icon = file.name.endsWith('.mp4')
                ? '{{ global_asset('backend/assets/images/video-reel-icon.svg') }}'
                : '{{ global_asset('backend/assets/images/audio-play.svg') }}';

            $('#upload-list').html(`
                <li class="upload-item">
                    <span class="icon"><img src="${icon}" alt="icon"></span>
                    <div class="details">
                        <span class="filename">${file.name}</span>
                        <span class="timestamp">${new Date().toLocaleTimeString()}</span>
                    </div>
                    <span class="size">${formatFileSize(file.size)}</span>
                    <button type="button" class="remove-btn"><img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove"></button>
                </li>`);

            $('#upload-list').off('click', '.remove-btn').on('click', '.remove-btn', function () {
                $('#media-file').val('');
                $('#upload-list').empty();
            });
        }
    });

    // Save new media
    $('#save-media').on('click', function () {
        const file = $('#media-file')[0].files[0];
        if (!file) {
            showToast('Please select a file', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('title', $('#title').val().trim());
        formData.append('author', $('#author').val().trim());
        formData.append('speaker', $('#speaker').val().trim());
        formData.append('class_id', $('#class_id').val() || '');
        formData.append('date', $('#date').val());

        $('.file-upload-lg, .btn-wrp').addClass('upload-disabled');

        $.ajax({
            url: '{{ route("admin.recorded-classes.store") }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                showToast(res.message || 'Media added successfully', 'success');
                $('#addMedia').modal('hide');
                setTimeout(() => location.reload(), 600);
            },
            error: function (xhr) {
                let msg = 'Error adding media';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join(' • ');
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                showToast(msg, 'error');
            },
            complete: () => $('.file-upload-lg, .btn-wrp').removeClass('upload-disabled')
        });
    });

    // Populate Edit modal
    $(document).on('click', '.edit-media', function () {
        const btn = $(this);
        $('#editId').val(btn.data('id'));
        $('#edit-title').val(btn.data('title'));
        $('#edit-author').val(btn.data('author'));
        $('#edit-speaker').val(btn.data('speaker'));
        $('#edit-class_id').val(btn.data('class_id'));
        $('#edit-date').val(btn.data('date'));

        const filename = btn.data('filename');
        const size = btn.data('size');
        const icon = filename.endsWith('.mp4')
            ? '{{ global_asset('backend/assets/images/video-reel-icon.svg') }}'
            : '{{ global_asset('backend/assets/images/audio-play.svg') }}';

        $('#edit-upload-list').html(`
            <li class="upload-item">
                <span class="icon"><img src="${icon}" alt="icon"></span>
                <div class="details">
                    <span class="filename">${filename}</span>
                    <span class="timestamp">Current</span>
                </div>
                <span class="size">${formatFileSize(size)}</span>
                <button type="button" class="remove-btn"><img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove"></button>
            </li>`);

        $('#edit-upload-list').off('click', '.remove-btn').on('click', '.remove-btn', function () {
            $('#edit-media-file').val('');
            $('#edit-upload-list').empty();
        });
    });

    // Edit file change
    $('#edit-media-file').on('change', function (e) {
        const file = e.target.files[0];
        $('#edit-upload-list').empty();
        if (file) {
            const icon = file.name.endsWith('.mp4')
                ? '{{ global_asset('backend/assets/images/video-reel-icon.svg') }}'
                : '{{ global_asset('backend/assets/images/audio-play.svg') }}';

            $('#edit-upload-list').html(`
                <li class="upload-item">
                    <span class="icon"><img src="${icon}" alt="icon"></span>
                    <div class="details">
                        <span class="filename">${file.name}</span>
                        <span class="timestamp">New</span>
                    </div>
                    <span class="size">${formatFileSize(file.size)}</span>
                    <button type="button" class="remove-btn"><img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove"></button>
                </li>`);

            $('#edit-upload-list').off('click', '.remove-btn').on('click', '.remove-btn', function () {
                $('#edit-media-file').val('');
                $('#edit-upload-list').empty();
            });
        }
    });

    // Update media
    $('#update-media').on('click', function () {
        const id = $('#editId').val();
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('title', $('#edit-title').val().trim());
        formData.append('author', $('#edit-author').val().trim());
        formData.append('speaker', $('#edit-speaker').val().trim());
        formData.append('class_id', $('#edit-class_id').val() || '');
        formData.append('date', $('#edit-date').val());

        const file = $('#edit-media-file')[0].files[0];
        if (file) formData.append('file', file);

        $('.file-upload-lg, .btn-wrp').addClass('upload-disabled');

        $.ajax({
            url: '{{ route("admin.recorded-classes.update", ":id") }}'.replace(':id', id),
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                showToast(res.message || 'Media updated successfully', 'success');
                $('#editMedia').modal('hide');
                setTimeout(() => location.reload(), 600);
            },
            error: function (xhr) {
                let msg = 'Error updating media';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join(' • ');
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                showToast(msg, 'error');
            },
            complete: () => $('.file-upload-lg, .btn-wrp').removeClass('upload-disabled')
        });
    });

    // Delete media
    $(document).on('click', '.delete-media', function () {
        $('#deleteId').val($(this).data('id'));
    });

    $('#confirmDelete').on('click', function () {
        const id = $('#deleteId').val();

        $.ajax({
            url: '{{ route("admin.recorded-classes.destroy", ":id") }}'.replace(':id', id),
            method: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                showToast(res.message || 'Media deleted successfully', 'success');
                $('#deleteMedia').modal('hide');
                setTimeout(() => location.reload(), 600);
            },
            error: function (xhr) {
                showToast(xhr.responseJSON?.message || 'Error deleting media', 'error');
            }
        });
    });

    // Clean modal backdrop
    $('#addMedia, #editMedia, #deleteMedia').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    // File size formatter
    function formatFileSize(bytes) {
        if (!bytes) return '0 KB';
        const kb = bytes / 1024;
        return kb < 1024 ? kb.toFixed(1) + ' KB' : (kb / 1024).toFixed(1) + ' MB';
    }
});
</script>
@endpush