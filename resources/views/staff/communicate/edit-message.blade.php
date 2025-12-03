@extends('staff.master')

@section('content')

@push('styles')
    <style>
        .ck-editor__editable { min-height: 300px; }
        .current-attachment {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
@endpush

<div class="ds-breadcrumb">
    <h1>Edit Message</h1>
    <ul>
        <li><a href="">Dashboard</a> /</li>
        <li><a href="">Notice Board</a> /</li>
        <li>Edit Message</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="ds-cmn-table-wrp">
        <h2 class="add-heading">Edit Message</h2>

        <!-- Alert -->
        <div id="responseAlert" class="alert" style="display: none; margin-bottom: 20px;"></div>

        <form id="editMessageForm" data-id="{{ $notice->id }}">
            @csrf
            @method('PUT')

            <div class="desc-rows">

                <div class="assign-align">
                    <div class="assign-column">
                        <p class="assign-heading">Title <span class="text-danger">*</span></p>
                        <input type="text" placeholder="Enter title" id="title" name="title" 
                               value="{{ old('title', $notice->title) }}" required>
                    </div>
                </div>

                <div class="assign-align">
                    <div class="assign-columndate">
                        <p class="assign-heading">Notice Date <span class="text-danger">*</span></p>
                        <input type="date" id="date" name="date" 
                               value="{{ old('date', $notice->date) }}" required>
                    </div>

                    <div class="assign-columndate">
                        <p class="assign-heading">Attachment (Optional)</p>
                        <div class="attachment file-upload">
                            <input type="file" id="document" name="document" 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <span>Drag and drop a file here or click</span>
                        </div>

                    </div>
                </div>

                <div class="assign-desc">
                    <p class="assign-heading">Message <span class="text-danger">*</span></p>
                    <textarea class="desc-column" id="message" name="message">{{ old('message', $notice->description) }}</textarea>
                </div>
            </div>

            <button type="submit" class="req-btn">Update</button>
        </form>
    </div>
</div>

@endsection

@push('script')
<script>
    let editor;

    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#message'), {
                placeholder: 'Write your message here...',
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|',
                    'blockQuote', 'insertTable', '|', 'undo', 'redo'
                ]
            })
            .then(newEditor => {
                editor = newEditor;
                editor.setData(`{!! addslashes($notice->description) !!}`);
            })
            .catch(error => console.error('CKEditor Error:', error));

        // Form Submit
        $('#editMessageForm').on('submit', function(e) {
            e.preventDefault();

            if (editor) {
                $('#message').val(editor.getData());
            }

            let formData = new FormData(this);
            let noticeId = $(this).data('id');

            // Append _method for PUT
            formData.append('_method', 'PUT');

            $.ajax({
                url: '{{ route("staff.communicate.messages.update", ":id") }}'.replace(':id', noticeId),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.success) {
                        $('#responseAlert')
                            .removeClass('alert-danger')
                            .addClass('alert-success')
                            .html('<strong>Success!</strong> ' + (res.message || 'Message updated successfully!'))
                            .slideDown();

                        // Redirect after 1.5 seconds
                        setTimeout(() => {
                            window.location.href = res.redirect || '{{ route("staff.communicate.index") }}';
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    let msg = 'Something went wrong.';
                    if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON?.errors) {
                        msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }

                    $('#responseAlert')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html('<strong>Error!</strong> ' + msg)
                        .slideDown();
                }
            });
        });
    });
</script>
@endpush