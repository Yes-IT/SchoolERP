@extends('staff.master')

@section('content')

@push('styles')
    <!-- Optional: CKEditor 5 default styles (you can customize later) -->
    <style>
        .ck-editor__editable { min-height: 300px; }
    </style>
@endpush

<div class="ds-breadcrumb">
    <h1>Compose New Message</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Compose New Message</li>
    </ul>
</div>

<div class="ds-pr-body">
    <div class="ds-cmn-table-wrp">
        <h2 class="add-heading">New Message</h2>

        <!-- Success/Error Message Alert -->
        <div id="responseAlert" class="alert" style="display: none; margin-bottom: 20px;"></div>

        <form id="composeMessageForm">
            @csrf

            <div class="desc-rows">

                <div class="assign-align">
                    <div class="assign-column">
                        <p class="assign-heading">Title <span class="text-danger">*</span></p>
                        <input type="text" placeholder="Enter title" id="title" name="title" required>
                    </div>
                </div>

                <div class="assign-align">
                    <div class="assign-columndate">
                        <p class="assign-heading">Notice Date <span class="text-danger">*</span></p>
                        <input type="date" id="date" name="date" required>
                    </div>

                    <div class="assign-columndate">
                        <p class="assign-heading">Attachment (Optional)</p>
                        <div class="attachment file-upload">
                            <input type="file" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.png">
                            <span>Drag and drop a file here or click</span>
                        </div>
                    </div>
                </div>

                <div class="assign-desc">
                    <p class="assign-heading">Message <span class="text-danger">*</span></p>
                    <!-- CKEditor will replace this textarea -->
                    <textarea class="desc-column" id="message" name="message"></textarea>
                </div>
            </div>

            <button type="submit" class="req-btn">Send Message</button>
        </form>
    </div>
</div>

@endsection

@push('script')

<script>

    let editor; 

    $(document).ready(function() {

        // Initialize CKEditor 5 Classic
        ClassicEditor
            .create(document.querySelector('#message'), {
                placeholder: 'Write your message here...',
                // You can add toolbar items, plugins, etc. here
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ],
                
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error('CKEditor 5 error:', error);
            });

        // Handle form submission via AJAX
        $('#composeMessageForm').on('submit', function(e) {
            e.preventDefault();

            // Important: Update the textarea with CKEditor content before sending
            if (editor) {
                $('#message').val(editor.getData());
            }

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route("staff.communicate.messages.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#responseAlert')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .html('<strong>Success!</strong> ' + (response.message || 'Message sent successfully.'))
                        .slideDown();

                    // Reset form
                    $('#composeMessageForm')[0].reset();
                    if (editor) editor.setData('');   // Clear CKEditor

                    setTimeout(() => $('#responseAlert').slideUp(), 5000);
                },
                error: function(xhr) {
                    let errorMsg = 'Something went wrong. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }

                    $('#responseAlert')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html('<strong>Error!</strong> ' + errorMsg)
                        .slideDown();
                }
            });
        });
    });

</script>

@endpush