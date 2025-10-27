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
                                            <img src="{{ Storage::disk('public')->url($item->path) }}" alt="{{ $item->title ?? 'Gallery Image' }}">
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
    <div class="modal fade cmn-popwrp pop800" id="addGallery" tabindex="-1" role="dialog" aria-labelledby="addGallery" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                            <div class="cmn-tab-content mb-4">
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
                                        <button type="button" class="btn-sm cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button type="button" class="btn-sm cmn-btn" id="saveAddMedia">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Media Modal -->
    <div class="modal fade cmn-popwrp pop800" id="editGallery" tabindex="-1" role="dialog" aria-labelledby="editGallery" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                            <div class="cmn-tab-content mb-4">
                                <form id="editGalleryForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" id="editId">
                                    <div class="mb-3">
                                        <label for="editFile" class="form-label">Media File</label>
                                        <div class="file-upload-lg">
                                            <input type="file" id="editFile" name="file" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov" class="form-control">
                                            <div class="file-upld-lg-design">
                                                <div class="fupld-lg-icon">
                                                    <img src="{{ global_asset('backend/assets/images/upload-file-icon.svg') }}" alt="Icon">
                                                </div>
                                                <p>Click to browse or drag and drop your files</p>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="cmn-tab-content">
                                        <div class="upload-list">
                                            <ul class="uploads">
                                                <li class="upload-item" id="currentFile">
                                                    <span class="icon">
                                                        <img src="{{ global_asset('backend/assets/images/video-reel-icon.svg') }}" alt="Icon">
                                                    </span>
                                                    <div class="details">
                                                        <span class="filename"></span>
                                                        <span class="timestamp"></span>
                                                    </div>
                                                    <span class="size"></span>
                                                    <a href="#" class="download-btn" download><img src="{{ global_asset('backend/assets/images/download-2.svg') }}" alt="Download"></a>
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
                                        <button type="button" class="btn-sm cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button type="button" class="btn-sm cmn-btn" id="saveEditMedia">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Media Modal -->
    <div class="modal fade cmn-popwrp" id="deleteGallery" tabindex="-1" role="dialog" aria-labelledby="deleteGallery" aria-hidden="true">
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
                                <form id="deleteGalleryForm">
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

</div>

@push('script')

<script>
    $(document).ready(function() {
        // Clear previous validation errors
        function clearErrors(formId) {
            $(`${formId} .form-control`).removeClass('is-invalid');
            $(`${formId} .invalid-feedback`).empty();
        }

        // Display validation errors
        function displayErrors(formId, errors) {
            clearErrors(formId);
            $.each(errors, function(field, messages) {
                let $input = $(`${formId} #${field === 'file' ? (formId === '#addGalleryForm' ? 'addFile' : 'editFile') : field}`);
                let $errorDiv = $input.next('.invalid-feedback');
                if ($errorDiv.length === 0) {
                    $errorDiv = $input.closest('.file-upload-lg').find('.invalid-feedback');
                }
                $input.addClass('is-invalid');
                $errorDiv.html(messages.join('<br>'));
                Toast.fire({
                    icon: 'error',
                    title: messages.join(' ')
                });
            });
        }

        // Handle add media save button
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
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    $('#addGallery').modal('hide');
                    $('#addGalleryForm')[0].reset();
                    $('#addFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop your files');
                    clearErrors('#addGalleryForm');
                    
                    // Use setTimeout to ensure modal is fully hidden before reload
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    let message = response.message || 'An error occurred';
                    
                    if (response.errors) {
                        displayErrors('#addGalleryForm', response.errors);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: message
                        });
                    }
                },
                complete: function() {
                    $('#saveAddMedia').prop('disabled', false).text('Save');
                }
            });
        });

        // Handle edit button click
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            
            $.ajax({
                url: '{{ url("alumni_flow/alumni-gallery") }}/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    let item = response.galleryItem;
                    $('#editId').val(item.id);
                    $('#editTitle').val(item.title || '');
                    $('#editDescription').val(item.description || '');
                    $('#currentFile .filename').text(item.filename);
                    $('#currentFile .timestamp').text(item.created_at);
                    $('#currentFile .size').text(formatFileSize(item.size));
                    $('#currentFile .download-btn').attr('href', item.path);
                    $('#currentFile .cross-btn').data('id', item.id);
                    $('#editFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop to replace file');
                    $('#currentFile').show();
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Error fetching gallery item'
                    });
                }
            });
        });

        // Handle edit media save button
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
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    $('#editGallery').modal('hide');
                    $('#editGalleryForm')[0].reset();
                    $('#editFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop your files');
                    clearErrors('#editGalleryForm');
                    
                    // Use setTimeout to ensure modal is fully hidden before reload
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    let message = response.message || 'An error occurred';
                    
                    if (response.errors) {
                        displayErrors('#editGalleryForm', response.errors);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: message
                        });
                    }
                },
                complete: function() {
                    $('#saveEditMedia').prop('disabled', false).text('Save');
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            $('#deleteId').val(id);
        });

        // Handle confirm delete
        $('#confirmDelete').on('click', function() {
            let id = $('#deleteId').val();
            
            $.ajax({
                url: '{{ url("alumni_flow/alumni-gallery") }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('#confirmDelete').prop('disabled', true).text('Deleting...');
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    $('#deleteGallery').modal('hide');
                    
                    // Use setTimeout to ensure modal is fully hidden before reload
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Error deleting gallery item'
                    });
                },
                complete: function() {
                    $('#confirmDelete').prop('disabled', false).text('Delete');
                }
            });
        });

        // Handle cross button click to delete file
        $(document).on('click', '#currentFile .cross-btn', function() {
            let id = $(this).data('id');
            if (!id) return;

            if (confirm('Are you sure you want to remove this file?')) {
                $.ajax({
                    url: '{{ url("alumni_flow/alumni-gallery") }}/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#currentFile .cross-btn').prop('disabled', true);
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'File removed successfully'
                        });
                        $('#currentFile').hide();
                        $('#currentFile .filename').text('');
                        $('#currentFile .timestamp').text('');
                        $('#currentFile .size').text('');
                        $('#currentFile .download-btn').attr('href', '#');
                        $('#editFile').next('.file-upld-lg-design').find('p').text('Click to browse or drag and drop your files');
                        
                        // Use setTimeout to ensure modal is fully hidden before reload
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    },
                    error: function(xhr) {
                        let response = xhr.responseJSON;
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'Error removing file'
                        });
                    },
                    complete: function() {
                        $('#currentFile .cross-btn').prop('disabled', false);
                    }
                });
            }
        });

        // Update file input label when file is selected
        $('#addFile, #editFile').on('change', function() {
            let fileName = this.files.length > 0 ? this.files[0].name : 'Click to browse or drag and drop your files';
            $(this).next('.file-upld-lg-design').find('p').text(fileName);
        });

        // Format file size
        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            else return (bytes / 1048576).toFixed(1) + ' MB';
        }

        // Handle download all click
        $('#downloadAll').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("alumni_flow.gallery.download_all") }}',
                type: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
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
                    Toast.fire({
                        icon: 'success',
                        title: 'Download started'
                    });
                },
                error: function(xhr) {
                    let response = xhr.responseJSON || {};
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Error preparing download'
                    });
                },
                complete: function() {
                    $('#downloadAll').prop('disabled', false).text('Download All');
                }
            });
        });

        // Reset forms when modals are hidden
        $('#addGallery, #editGallery, #deleteGallery').on('hidden.bs.modal', function () {
            // Clear any backdrop that might be stuck
            $('.modal-backdrop').remove();
            // Ensure body has correct classes
            $('body').removeClass('modal-open');
        });
    });
</script>

@endpush

@endsection