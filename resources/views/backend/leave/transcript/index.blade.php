@extends('backend.master')

@section('title')
    {{ @$data['title'] ?? 'Transcript Requests' }}
@endsection

@section('content')
    <style>
        .ds-cmn-tble {
            transition: opacity 0.3s ease;
        }
        .ds-cmn-tble.loading {
            opacity: 0.5;
        }
        .tbl-pagination-inr ul li {
            margin: 0 5px;
        }
        .pages-select {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .pages-select .formfield {
            margin-right: 15px;
        }
        .cmn-tab-head ul li {
            cursor: pointer;
        }
        .cmn-tab-head ul li span {
            display: block;
            text-decoration: none;
            color: inherit;
        }
        .count-row table tbody tr td:first-child {
            color: #000;
        }
    </style>

    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Transcript Requests</h1>
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a> /</li>
                <li><a href="{{ route('transcript.index') }}">Transcript</a> /</li>
                <li>Request Transcript</li>
            </ul>
        </div>
        <div class="ds-pr-body">
            

            <div class="ds-cmn-table-wrp tab-wrapper">
                <div class="ds-content-head">
                    <div class="cmn-tab-head">
                        <ul>
                            <li class="tab-bg" style="left: {{ request('tab') == 'final' ? '363.86px' : '181.141px' }}; top: 0px; width: 182.719px; height: 35px;"></li>
                            <li class="{{ request('tab') != 'final' ? 'active' : '' }}" data-tab="pending"><span data-tab="pending">Pending Request Transcript</span></li>
                            <li class="{{ request('tab') == 'final' ? 'active' : '' }}" data-tab="final"><span data-tab="final">Final Request Transcript</span></li>
                        </ul>
                    </div>
                </div>

                <div id="transcript-table-content">
                    @include('backend.leave.transcript.list', [
                        'tab' => $tab,
                        'pendingTranscripts' => $pendingTranscripts,
                        'finalTranscripts' => $finalTranscripts,
                        'perPage' => $perPage,
                        'pagination' => $pagination
                    ])
                </div>

                <!-- Pagination Section -->
                <div class="tablepagination" id="pagination-links">
                    <!-- Pagination links will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                let currentTab = '{{ request('tab', 'pending') }}';
                let perPage = '{{ request('per_page', 2) }}';

                // Function to load transcript data
                function loadTranscriptData(tab, page = 1, perPage = 2, filters = {}) {
                    $('#transcript-table-content').addClass('loading');
                    $.ajax({
                        url: '{{ route('transcript.data') }}',
                        method: 'GET',
                        data: {
                            tab: tab,
                            page: page,
                            per_page: perPage,
                            ...filters
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#transcript-table-content').html(response.html);
                            $('#pagination-links').html(response.pagination);
                            $('#transcript-table-content').removeClass('loading');

                            // Update tab background position
                            updateTabBackground(tab);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading transcript data:', error, xhr.responseText);
                            alert('Error loading data. Please try again.');
                            $('#transcript-table-content').removeClass('loading');
                        }
                    });
                }

                // Function to update tab background position
                function updateTabBackground(tab) {
                    const $tabBg = $('.cmn-tab-head .tab-bg');
                    const $tab = $(`.cmn-tab-head li[data-tab="${tab}"]`);
                    if ($tab.length) {
                        const left = $tab.position().left;
                        const width = $tab.outerWidth();
                        $tabBg.css({ left: left, width: width });
                    }
                }


                $('.cmn-tab-head ul li').on('click', function(e) {
                    e.preventDefault();
                    const tab = $(this).data('tab');
                    $('.cmn-tab-head ul li').removeClass('active');
                    $(this).addClass('active');
                    currentTab = tab;
                    loadTranscriptData(tab, 1, perPage);
                });


                // Per page selection handler
                $(document).on('change', '#pagination-links select[name="per_page"]', function(e) {
                    e.preventDefault();
                    perPage = $(this).val();
                    const filters = $('#leave-filter-form').serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadTranscriptData(currentTab, 1, perPage, filters);
                });


                // Function to update transcript status
                function updateTranscriptStatus(transcriptId, action) {
                $.ajax({
                    url: '{{ route('transcript.update') }}',
                    method: 'POST',
                    data: JSON.stringify({
                         _token: '{{ csrf_token() }}',
                        transcript_id: transcriptId,
                        action: action
                    }),
                    contentType: 'application/json',
                    success: function(data) {
                        if (data.success) {
                            loadTranscriptData(currentTab, 1, perPage);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating transcript status:', error, xhr.responseText);
                        alert('Error updating status. Please try again.');
                    }
                });
            }

                // Initial load
                loadTranscriptData(currentTab, 1, perPage);

                // Tab click handler
                $('.cmn-tab-head ul li').on('click', function(e) {
                    e.preventDefault();
                    const tab = $(this).data('tab');
                    $('.cmn-tab-head ul li').removeClass('active');
                    $(this).addClass('active');
                    currentTab = tab;
                    loadTranscriptData(tab, 1, perPage);
                });

                // Pagination click handler
                $(document).on('click', '#pagination-links .tbl-pagination-inr a', function(e) {
                    e.preventDefault();
                    const url = new URL($(this).attr('href'));
                    const page = url.searchParams.get('page') || 1;
                    const filters = $('#transcript-filter-form').serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadTranscriptData(currentTab, page, perPage, filters);
                });

                // Per page selection handler
                $(document).on('change', '.per-page-select', function(e) {
                    e.preventDefault();
                    perPage = $(this).val();
                    const filters = $('#transcript-filter-form').serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadTranscriptData(currentTab, 1, perPage, filters);
                });

                // Filter form submission
                $('#transcript-filter-form').on('submit', function(e) {
                    e.preventDefault();
                    const filters = $(this).serializeArray().reduce((obj, item) => {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    loadTranscriptData(currentTab, 1, perPage, filters);
                });

                // Approve/Reject button handler
                $(document).on('click', '.approve-transcript, .reject-transcript', function() {
                    const transcriptId = $(this).data('id');
                    const action = $(this).hasClass('approve-transcript') ? 'approve' : 'reject';
                    updateTranscriptStatus(transcriptId, action);
                });
            });
        </script>
    @endpush
@endsection