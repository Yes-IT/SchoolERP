@extends('backend.master')

@section('title')
    {{ ___('common.School Management System | Alumni') }}
@endsection

@section('content')
<style>
    #addVideo .upload-list .upload-item {
        border: 1px solid var(--border-clr);
        border-radius: 10px;
        padding: 12px;
    }
    .upload-item {
        border: 1px solid var(--border-clr);
        border-radius: 10px;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .upload-item .cross-btn {
        cursor: pointer;
    }
    .upload-item:last-child {border-bottom: 1px solid !important;}
</style>

<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Gallery</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li>Gallery</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="ds-cmn-table-wrp">
            <div class="ds-content-head justify-content-end">
                <div class="btn-wrp">
                    <button class="cmn-btn btn-sm" data-bs-target="#addGallery" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i>Add Gallery
                    </button>
                    <a href="{{ route('alumni_flow.gallery.download_all') }}" class="cmn-btn btn-sm" id="downloadAll">Download All</a>
                </div>
            </div>

            <div class="ds-gl-wrp">
                <div class="row">
                    @if($galleryItems->isNotEmpty())
                        @foreach($galleryItems as $item)
                            <div class="ds-gl-cd-wrp col-lg-3">
                                <div class="ds-gl-cd">
                                    <div class="ds-gl-content">
                                        @if(in_array($item->type, ['jpg', 'jpeg', 'png', 'webp']))
                                            <img src="{{ Storage::disk('public')->url($item->path) }}" alt="Gallery Image">
                                        @else
                                            <video controls>
                                                <source src="{{ Storage::disk('public')->url($item->path) }}" type="video/{{ $item->type }}">
                                            </video>
                                        @endif
                                    </div>
                                    <div class="ds-gl-cd-actions actions-wrp">
                                        <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editGallery" data-id="{{ $item->id }}">
                                            <img src="{{ global_asset('backend/assets/images/new_images/edit-icon-primary.svg') }}" alt="Edit">
                                        </button>
                                        <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteGallery" data-id="{{ $item->id }}">
                                            <img src="{{ global_asset('backend/assets/images/new_images/bin-icon.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <p class="text-center text-muted">No gallery items found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Media Modal -->
    <div class="modal fade cmn-popwrp pop800" id="addGallery" tabindex="-1" aria-labelledby="addGallery" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Close"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Add Media</h2>
                        </div>
                        <div class="cmn-pop-inr-content-wrp">
                            <form id="addGalleryForm" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="addFile" class="form-label">Media File</label>
                                    <div class="file-upload-lg">
                                        <input type="file" id="addFile" name="file" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov" class="form-control">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="{{ global_asset('backend/assets/images/upload-file-icon.svg') }}" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop your files</p>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="note">
                                    <p>jpg, .jpeg, .png, .webp, .mp4, .mov files.</p>
                                    <div class="ibtn">
                                        <button type="button" class="ibtn-icon">
                                            <img src="{{ global_asset('backend/assets/images/i-icon.svg') }}" alt="Icon">
                                        </button>
                                        <div class="ibtn-info">
                                            <button type="button" class="ibtn-close">
                                                <img src="{{ global_asset('backend/assets/images/fa-times.svg') }}" alt="Icon">
                                            </button>
                                            <h3>Upload Guidelines</h3>
                                            <ul>
                                                <li>Images larger than 5 MB are not accepted.</li>
                                                <li>Videos must be under 10 MB in size.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-wrp justify-content-end">
                                    <button type="button" class="btn-sm cmn-btn" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn-sm cmn-btn" id="saveAddMedia">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Media Modal -->
    <div class="modal fade cmn-popwrp pop800" id="editGallery" tabindex="-1" aria-labelledby="editGallery" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ global_asset('backend/assets/images/cross-icon.svg') }}" alt="Close"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-content-wrapper">
                        <div class="cmn-pop-head">
                            <h2>Edit Media</h2>
                        </div>
                        <div class="cmn-pop-inr-content-wrp">
                            <form id="editGalleryForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="editId">

                                <div class="mb-3">
                                    <label for="editFile" class="form-label">Replace Media File (Optional)</label>
                                    <div class="file-upload-lg">
                                        <input type="file" id="editFile" name="file" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov" class="form-control">
                                        <div class="file-upld-lg-design">
                                            <div class="fupld-lg-icon">
                                                <img src="{{ global_asset('backend/assets/images/upload-file-icon.svg') }}" alt="Icon">
                                            </div>
                                            <p>Click to browse or drag and drop to replace file</p>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="cmn-tab-content">
                                    <div class="upload-list">
                                        <ul class="uploads">
                                            <li class="upload-item" id="currentFile" style="display:none;">
                                                <span class="icon">
                                                    <img src="{{ global_asset('backend/assets/images/video-reel-icon.svg') }}" alt="Icon">
                                                </span>
                                                <div class="details">
                                                    <span class="filename"></span>
                                                    <span class="timestamp"></span>
                                                </div>
                                                <span class="size"></span>
                                                <a href="#" class="download-btn" download>
                                                    <img src="{{ global_asset('backend/assets/images/new_images/download.svg') }}" alt="Download">
                                                </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <img src="{{ global_asset('backend/assets/images/cross-circle.svg') }}" alt="Remove File" class="cross-btn" data-id="">
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="note">
                                    <p>jpg, .jpeg, .png, .webp, .mp4, .mov files.</p>
                                    <div class="ibtn">
                                        <button type="button" class="ibtn-icon">
                                            <img src="{{ global_asset('backend/assets/images/i-icon.svg') }}" alt="Icon">
                                        </button>
                                        <div class="ibtn-info">
                                            <button type="button" class="ibtn-close">
                                                <img src="{{ global_asset('backend/assets/images/fa-times.svg') }}" alt="Icon">
                                            </button>
                                            <h3>Upload Guidelines</h3>
                                            <ul>
                                                <li>Images larger than 5 MB are not accepted.</li>
                                                <li>Videos must be under 10 MB in size.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-wrp justify-content-end">
                                    <button type="button" class="btn-sm cmn-btn" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn-sm cmn-btn" id="saveEditMedia">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Media Modal -->
    <div class="modal fade cmn-popwrp" id="deleteGallery" tabindex="-1" aria-labelledby="deleteGallery" aria-hidden="true">
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
                            <form id="deleteGalleryForm">
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
</div>

@endsection

@push('script')
<style>
    /* Simple Toaster Styles */
    #toaster {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 16px;
        position: fixed;
        z-index: 9999;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(100px);
        transition: all 0.4s ease;
    }
    #toaster.show {
        visibility: visible;
        transform: translateY(0);
    }
    #toaster.success {
        background-color: #28a745;
    }
    #toaster.error {
        background-color: #dc3545;
    }
</style>

<div id="toaster"></div>

<script>
$(document).ready(function() {
    // Simple Toaster Function
    function Toast(options) {
        const toaster = $('#toaster');
        toaster.removeClass('success error show');
        toaster.text(options.title || 'Notification');

        if (options.icon === 'success') {
            toaster.addClass('success');
        } else if (options.icon === 'error') {
            toaster.addClass('error');
        } else {
            toaster.css('background-color', '#333');
        }

        toaster.addClass('show');

        setTimeout(function() {
            toaster.removeClass('show');
        }, 3000);
    }

    // Clear validation errors
    function clearErrors(formId) {
        $(`${formId} .form-control`).removeClass('is-invalid');
        $(`${formId} .invalid-feedback`).empty();
    }

    // Display validation errors
    function displayErrors(formId, errors) {
        clearErrors(formId);
        $.each(errors, function(field, messages) {
            let $input = $(`${formId} #${field === 'file' ? (formId === '#addGalleryForm' ? 'addFile' : 'editFile') : field}`);
            let $errorDiv = $input.closest('.file-upload-lg').find('.invalid-feedback');
            $input.addClass('is-invalid');
            $errorDiv.html(messages.join('<br>'));
            Toast({ icon: 'error', title: messages.join(' ') });
        });
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        else return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // Add Media
    $('#saveAddMedia').on('click', function() {
        clearErrors('#addGalleryForm');
        let formData = new FormData($('#addGalleryForm')[0]);
        $.ajax({
            url: '{{ route("alumni_flow.gallery.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#saveAddMedia').prop('disabled', true).text('Uploading...');
            },
            success: function(response) {
                Toast({ icon: 'success', title: response.message });
                $('#addGallery').modal('hide');
                $('#addGalleryForm')[0].reset();
                $('#addFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop your files');
                setTimeout(() => location.reload(), 300);
            },
            error: function(xhr) {
                let response = xhr.responseJSON;
                if (response.errors) {
                    displayErrors('#addGalleryForm', response.errors);
                } else {
                    Toast({ icon: 'error', title: response.message || 'An error occurred' });
                }
            },
            complete: function() {
                $('#saveAddMedia').prop('disabled', false).text('Save');
            }
        });
    });

    // Edit Button Click
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '{{ url("alumni_flow/alumni-gallery") }}/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                let item = response.galleryItem;
                $('#editId').val(item.id);

                $('#currentFile .filename').text(item.filename);
                $('#currentFile .timestamp').text(item.created_at);
                $('#currentFile .size').text(formatFileSize(item.size));
                $('#currentFile .download-btn').attr('href', item.path);
                $('#currentFile .cross-btn').data('id', item.id);

                $('#editFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop to replace file');
                $('#currentFile').show();
            },
            error: function(xhr) {
                Toast({ icon: 'error', title: xhr.responseJSON?.message || 'Error fetching item' });
            }
        });
    });

    // Save Edit
    $('#saveEditMedia').on('click', function() {
        clearErrors('#editGalleryForm');
        let formData = new FormData($('#editGalleryForm')[0]);
        let id = $('#editId').val();

        $.ajax({
            url: '{{ url("alumni_flow/alumni-gallery") }}/' + id + '/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#saveEditMedia').prop('disabled', true).text('Updating...');
            },
            success: function(response) {
                Toast({ icon: 'success', title: response.message });
                $('#editGallery').modal('hide');
                setTimeout(() => location.reload(), 300);
            },
            error: function(xhr) {
                let response = xhr.responseJSON;
                if (response.errors) {
                    displayErrors('#editGalleryForm', response.errors);
                } else {
                    Toast({ icon: 'error', title: response.message || 'An error occurred' });
                }
            },
            complete: function() {
                $('#saveEditMedia').prop('disabled', false).text('Save');
            }
        });
    });

    // Delete Button
    $(document).on('click', '.delete-btn', function() {
        $('#deleteId').val($(this).data('id'));
    });

    // Confirm Delete
    $('#confirmDelete').on('click', function() {
        let id = $('#deleteId').val();
        $.ajax({
            url: '{{ url("alumni_flow/alumni-gallery") }}/' + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            beforeSend: function() {
                $('#confirmDelete').prop('disabled', true).text('Deleting...');
            },
            success: function(response) {
                Toast({ icon: 'success', title: response.message });
                $('#deleteGallery').modal('hide');
                setTimeout(() => location.reload(), 300);
            },
            error: function(xhr) {
                Toast({ icon: 'error', title: xhr.responseJSON?.message || 'Error deleting item' });
            },
            complete: function() {
                $('#confirmDelete').prop('disabled', false).text('Delete');
            }
        });
    });

    // Remove file in edit
    $(document).on('click', '#currentFile .cross-btn', function() {
        let id = $(this).data('id');
        if (!id || !confirm('Remove this file permanently?')) return;

        $.ajax({
            url: '{{ url("alumni_flow/alumni-gallery") }}/' + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function() {
                Toast({ icon: 'success', title: 'File removed successfully' });
                $('#currentFile').hide();
                $('#editFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop your files');
                setTimeout(() => location.reload(), 300);
            },
            error: function(xhr) {
                Toast({ icon: 'error', title: xhr.responseJSON?.message || 'Error removing file' });
            }
        });
    });

    // Update file name display
    $('#addFile, #editFile').on('change', function() {
        let fileName = this.files.length > 0 ? this.files[0].name : 'Click to browse or drag and drop your files';
        $(this).next('.file-upld-lg-design').find('p').text(fileName);
    });

    // Download All
    $('#downloadAll').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("alumni_flow.gallery.download_all") }}',
            type: 'GET',
            xhrFields: { responseType: 'blob' },
            beforeSend: function() {
                $('#downloadAll').prop('disabled', true).text('Preparing...');
            },
            success: function(data) {
                const url = window.URL.createObjectURL(new Blob([data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'gallery_files.zip');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
                Toast({ icon: 'success', title: 'Download started' });
            },
            error: function() {
                Toast({ icon: 'error', title: 'Error preparing download' });
            },
            complete: function() {
                $('#downloadAll').prop('disabled', false).text('Download All');
            }
        });
    });

    // Clean up modals
    $('#addGallery, #editGallery, #deleteGallery').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
});
</script>
@endpush

