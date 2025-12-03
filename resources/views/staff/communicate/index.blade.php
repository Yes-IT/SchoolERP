@extends('staff.master')

@section('content')

<div class="ds-breadcrumb">
    <h1>Notice Board</h1>
    <ul>
        <li><a href="{{ route('staff.dashboard') }}">Dashboard</a> /</li>
        <li>Notice Board</li>
    </ul>
</div>


<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp notice-board-pg">
        <div class="dsbdycmncd-body">
            <div class="notice-list">

                <a href="{{ route('staff.communicate.message.add') }}" class="open-modal-btn session-btn">
                    + Post New Message
                </a>

                <br><br>

               <ul>
                    @forelse($notices as $notice)
                        @php
                            $noticeDate = \Carbon\Carbon::parse($notice->date);
                            $file = $notice->attachment;
                            $isActive = trim(strtolower($notice->title)) === 'change of schedule';
                            $isMyNotice = $notice->teacher_id && $notice->teacher_id == Auth::id();
                        @endphp

                        <li class="has-info-card {{ $isActive ? 'active' : '' }}">

                            <div class="msg-inr-cd" style="border-bottom:1px solid rgba(0, 0, 0, .1);">

                                <a href="javascript:void(0)" class="notice-toggle" style="border-bottom:none;">
                                    @if($notice->teacher_id)
                                        <img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Notice">
                                    @else
                                        <img src="{{ asset('staff/assets/images/notice-icon-2.svg') }}" alt="Notice">
                                    @endif

                                    {{ $notice->title }} ({{ $noticeDate->format('d/m/Y') }})
                                </a>

                                @if($isMyNotice)
                                    <div class="actions-wrp">
                                        {{-- EDIT --}}
                                        <button type="button" class="edit-btn" data-edit-url="{{ route('staff.communicate.message.edit', $notice->id) }}">
                                            <img src="{{ asset('staff/assets/images/edit-icon-primary.svg') }}" alt="Edit">
                                        </button>

                                        {{-- DELETE --}}
                                        <button type="button" class="delete-btn" 
                                                data-id="{{ $notice->id }}" 
                                                data-title="{{ $notice->title }}">
                                            <img src="{{ asset('staff/assets/images/bin-primary.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                @endif
                            </div>

                            {{-- Sliding Info Card --}}
                            <div class="notice-info-wrp">
                                <div class="overlay"></div>

                                <div class="notice-info">
                                    <div class="nc-info-head">
                                        <button type="button" class="btn-back">
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </button>
                                        <h2>{{ $notice->title }}</h2>
                                        <button type="button" class="notice-btn-close">
                                            <img src="{{ asset('staff/assets/images/cross-icon.svg') }}">
                                        </button>
                                    </div>

                                    <div class="nc-info-body">
                                        <p>{{ $notice->description ?? 'No description provided.' }}</p>

                                        @if($file)
                                            <div class="nc-doc-wrap">
                                                <button type="button" class="doc-download cmn-btn">
                                                    <img src="{{ asset('staff/assets/images/file-icon.svg') }}" alt="File">

                                                    <span>{{ $file }}</span>

                                                    <a href="{{ asset('uploads/notice/' . $file) }}" download>
                                                        <img src="{{ asset('staff/assets/images/download-icon-light.svg') }}" alt="Download">
                                                    </a>
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="nc-info-footer">
                                        <div class="notice-date">
                                            <img src="{{ asset('staff/assets/images/calender-primary.svg') }}" alt="Calendar">
                                            <span>Notice Date: {{ $noticeDate->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </li>

                    @empty
                        <li><em>No notices found.</em></li>
                    @endforelse
                </ul>


            </div>
        </div>
    </div>

    <div class="modal fade cmn-popwrp popwrp w400" id="deleteMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <img src="{{ asset('staff/assets/images/cross-icon.svg') }}" alt="Icon">
                    </span>
                </button>

                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <div class="modal-icon">
                            <img src="{{ asset('staff/assets/images/bin-primary.svg') }}" alt="Bin Icon">
                        </div>
                        <div class="sec-head head-center">
                            <h2>Delete!</h2>
                            <p id="delete-message-text">Are you sure you want to delete this message?</p>

                            <form id="deleteMessageForm">
                                @csrf
                                @method("DELETE")
                                <input type="hidden" id="delete-message-id" name="id">

                                <div class="btn-wrp">
                                    <button type="submit" class="cmn-btn">Delete</button>
                                    <button type="button" class="cmn-btn" data-bs-dismiss="modal">Cancel</button>
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

// -----------------------------
// NOTICE OPEN/CLOSE (Your OLD Code)
// -----------------------------
document.querySelectorAll('.notice-toggle').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        
        const li = this.closest('li');
        const isActive = li.classList.contains('active');

        // Close all others
        document.querySelectorAll('.has-info-card').forEach(el => {
            el.classList.remove('active');
        });

        // If it wasn't already active, open it
        if (!isActive) {
            li.classList.add('active');
        }
    });
});

// Close when clicking close button, back button, or overlay
document.querySelectorAll('.notice-btn-close, .btn-back, .overlay').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        document.querySelectorAll('.has-info-card').forEach(el => {
            el.classList.remove('active');
        });
    });
});


// -----------------------------
// EDIT BUTTON – REDIRECT
// -----------------------------
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        window.location.href = this.dataset.editUrl;
    });
});


// -----------------------------
// DELETE BUTTON – OPEN MODAL
// -----------------------------
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        let id = this.dataset.id;
        let title = this.dataset.title;

        document.getElementById('delete-message-id').value = id;

        let modal = new bootstrap.Modal(document.getElementById('deleteMessageModal'));
        modal.show();
    });
});


// -----------------------------
// DELETE MESSAGE – AJAX CALL
// -----------------------------
document.getElementById('deleteMessageForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let id = document.getElementById('delete-message-id').value;

    fetch(`/staff/communicate/messages/delete/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {

        // Close modal
        let modal = bootstrap.Modal.getInstance(document.getElementById('deleteMessageModal'));
        modal.hide();

        // Remove notice from list instantly
        let noticeRow = document.querySelector(`button.delete-btn[data-id="${id}"]`);
        if (noticeRow) {
            noticeRow.closest('li').remove();
        }

        if (window.toastr) {
            toastr.success("Message deleted successfully");
        }
    })
    .catch(err => {
        if (window.toastr) {
            toastr.error("Failed to delete. Try again.");
        }
    });
});

</script>
@endpush

