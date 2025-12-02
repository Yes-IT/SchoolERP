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
                            // Fix Carbon error: Use full class name
                            $noticeDate = \Carbon\Carbon::parse($notice->date);
                            $file = $notice->attachment;

                            // Your exact condition: only "Change of Schedule" gets .active
                            $isActive = trim(strtolower($notice->title)) === 'change of schedule';
                        @endphp

                        <li class="{{ $isActive ? 'active' : '' }} has-info-card">
                            <a href="javascript:void(0)" class="notice-toggle">
                                @if($notice->teacher_id)
                                    <img src="{{ asset('staff/assets/images/envelope.svg') }}" alt="Message">
                                @else
                                    <img src="{{ asset('staff/assets/images/notice-icon-2.svg') }}" alt="Notice">
                                @endif
                                {{ $notice->title }} ({{ $noticeDate->format('d/m/Y') }})
                            </a>

                            <!-- Sliding Info Card -->
                            <div class="notice-info-wrp">
                                <div class="overlay"></div>
                                <div class="notice-info">
                                    <div class="nc-info-head">
                                        <button type="button" class="btn-back">
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </button>
                                        <h2>{{ $notice->title }}</h2>
                                        <button type="button" class="notice-btn-close">
                                            <img src="{{ asset('staff/assets/images/cross-icon.svg') }}" alt="Close">
                                        </button>
                                    </div>

                                    <div class="nc-info-body">
                                        <p>{{ $notice->description ?? 'No description provided.' }}</p>

                                        @if($file)
                                            <div class="nc-doc-wrap">
                                                <a href="" 
                                                   download 
                                                   class="doc-download cmn-btn">
                                                    <img src="{{ asset('staff/assets/images/file-icon.svg') }}" alt="File">
                                                    <span></span>
                                                    <img src="{{ asset('staff/assets/images/download-icon-light.svg') }}" alt="Download">
                                                </a>
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
    
</div>

@endsection

@push('scripts')
<script>
    // Open notice on click
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
</script>
@endpush
