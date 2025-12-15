@extends('parent-panel.partials.master')
@section('content')

<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>Notice Board</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>Notice Board</li>
    </ul>
</div>
<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp notice-board-pg">
        <div class="dsbdycmncd-body">
            <div class="notice-list">
                <ul>
                    @foreach($notices as $notice)
                    @php
                    $isActive = isset($selectedNoticeId) && $selectedNoticeId == $notice->id;
                    @endphp

                    <li class="has-info-card {{ $isActive ? 'active default-active' : '' }}">
                        <a href="#url" class="notice-link" data-notice-id="{{ $notice->id }}">
                            @if($notice->title == 'Change of Schedule')
                            <img src="{{ asset('student/images/notice-icon-2.svg') }}" alt="Icon">
                            @else
                            <img src="{{ asset('student/images/envelope.svg') }}" alt="Icon">
                            @endif
                            {{ $notice->title }}
                            ({{ \Carbon\Carbon::parse($notice->publish_date)->format('d/m/Y') }})
                        </a>

                        <div class="notice-info-wrp" style="{{ $isActive ? 'display:block;' : '' }}">
                            <div class="overlay"></div>
                            <div class="notice-info">
                                <div class="nc-info-head">
                                    <button type="button" id="btn-back" class="btn-back">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </button>

                                    <h2>{{ $notice->title }}</h2>

                                    <button type="button" class="notice-btn-close">
                                        <img src="{{ asset('student/images/cross-icon.svg') }}" alt="Close">
                                    </button>
                                </div>

                                <div class="nc-info-body">
                                    <p>{!! $notice->description !!}</p>

                                    {{-- @if($notice->attachment)
                                    <div class="nc-doc-wrap">
                                        <button type="button" class="doc-download cmn-btn" onclick="downloadNoticePDF({{ $notice->id }})">
                                            <img src="{{ asset('student/images/file-icon.svg') }}" alt="Icon">
                                            <span>{{ basename($notice->attachment) }}</span>
                                            <img src="{{ asset('student/images/download-icon-light.svg') }}" alt="Icon">
                                        </button>
                                    </div>
                                    @endif --}}
                                    @if($notice->attachment)
                                        <div class="nc-doc-wrap">
                                            <button type="button" class="doc-download cmn-btn" onclick="downloadNoticePDF({{ $notice->id }})">
                                                <img src="{{ asset('student/images/file-icon.svg') }}" alt="Icon">
                                                <span>{{ basename($notice->attachment) }}</span>
                                                <img src="{{ asset('student/images/download-icon-light.svg') }}" alt="Icon">
                                            </button>
                                        </div>
                                    @else
                                        <div class="nc-doc-wrap no-attachment">
                                            <p class="text-muted">No attachment available for this notice.</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="nc-info-footer">
                                    <div class="notice-date">
                                        <img src="{{ asset('student/images/calender-primary.svg') }}" alt="Icon">
                                        <span>Notice Date: {{ \Carbon\Carbon::parse($notice->publish_date)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Of Dashboard -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="requestLeave" tabindex="-1" role="dialog" aria-labelledby="requestLeave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Request Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form>
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea placeholder="Reason"></textarea>
                                </div>
                                <input type="submit" value="Submit" class="btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp popwrp" id="deleteLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="deleteLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{asset('student/images/bin-primary.svg')}}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Leave Request?</p>
                        <div class="btn-wrp">
                            <button type="submit" class="cmn-btn">Delete</button>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

@endsection

@push('script')





<script>
    function downloadNoticePDF(noticeId) {
        window.location.href = `/parent/notice/${noticeId}/download-pdf`;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 🔹 Function to close a specific notice card
        function closeNoticeCard(button) {
            const noticeInfo = button.closest('.notice-info-wrp');
            if (noticeInfo) {
                noticeInfo.classList.remove('active');
                noticeInfo.style.display = 'none';
            }
            const parentLi = button.closest('.has-info-card');
            if (parentLi) {
                parentLi.classList.remove('active');
            }
        }

        // 🔹 Function to close all notice cards
        function closeAllNotices() {
            document.querySelectorAll('.has-info-card').forEach(li => {
                li.classList.remove('active');
            });
            document.querySelectorAll('.notice-info-wrp').forEach(info => {
                info.classList.remove('active');
                info.style.display = 'none';
            });
        }

        // 🔹 Function to open a specific notice card
        function openNoticeCard(li) {
            const info = li.querySelector('.notice-info-wrp');
            if (info) {
                li.classList.add('active');
                info.classList.add('active');
                info.style.display = 'block';
            }
        }

        // 🔹 Close all, then open only the one marked as default-active
        closeAllNotices();
        const defaultActive = document.querySelector('.has-info-card.default-active');
        if (defaultActive) {
            openNoticeCard(defaultActive);
            defaultActive.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // 🔹 Attach close/back button handlers
        document.querySelectorAll('.notice-btn-close, .btn-back').forEach(button => {
            button.addEventListener('click', function() {
                closeNoticeCard(this);
            });
        });

        // 🔹 (Optional) Allow manual clicking on notice titles to open them
        document.querySelectorAll('.notice-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const li = this.closest('.has-info-card');
                if (!li.classList.contains('active')) {
                    closeAllNotices();
                    openNoticeCard(li);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const noticeItems = document.querySelectorAll('.has-info-card');
        const defaultActive = document.querySelector('.has-info-card.default-active');

        // On click of any notice title
        document.querySelectorAll('.notice-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all
                noticeItems.forEach(item => item.classList.remove('active'));

                // Add active to clicked one
                const parent = this.closest('.has-info-card');
                parent.classList.add('active');

                // (Optional) Open the info if you’re using slide/toggle behavior
                parent.querySelector('.notice-info-wrp').classList.add('open');
            });
        });

        // On close or back button click
        document.querySelectorAll('.notice-btn-close, .btn-back').forEach(btn => {
            btn.addEventListener('click', function() {
                const currentItem = this.closest('.has-info-card');

                // Hide info and remove active
                currentItem.classList.remove('active');
                currentItem.querySelector('.notice-info-wrp').classList.remove('open');

                // Restore default active (Change of Schedule.)
                if (defaultActive) {
                    defaultActive.classList.add('active');
                }
            });
        });
    });
</script>


@endpush