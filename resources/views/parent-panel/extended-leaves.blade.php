@extends('parent-panel.partials.master')

@section('title')
    {{ ___('common.Online Class Routine 2023') }}
@endsection

@section('content')

@php
    use Carbon\Carbon;
@endphp

<div class="ds-breadcrumb">
    <h1>Extended Leaves</h1>
        <ul>
            <li><a href="dashboard.html">Dashboard</a> /</li>
            <li>Extended Leaves</li>
        </ul>
</div>

<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">

        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Leaves
                    <div class="ibtn">
                        <button type="button" class="ibtn-icon">
                            <img src="{{ asset('parent/images/i-icon.svg') }}" class="eyebtn" alt="Icon">
                        </button>
                        <div class="ibtn-info lg rt p15">
                            <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                <img src="{{ asset('parent/images/fa-times.svg') }}" alt="icon">
                            </button>
                            <h3 class="txt-primary mb-2">Leave Information:</h3>
                            <p>If your child’s leave extends beyond 
                                4 days, the details of those leaves will appear here. Please monitor attendance regularly to stay updated.</p>
                        </div>
                    </div>
                </h2>
                
            </div>
            <div class="ds-cmn-filter-wrp">
                <div class="dsbdy-filter-wrp p-0">
                    <select name="year" id="year" class="mr-2">
                        <option value="">All Years</option>
                        @foreach($years as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>

                    <select name="semester" id="semester">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ ucfirst(str_replace('-', ' ', $semester->name)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="ds-cmn-tble count-row w1200" id="leaves-table-container">
            <!-- Initial table will be loaded here via PHP, AJAX will replace content -->
            @include('parent-panel.extended_leaves_table')
        </div>

    </div>

</div>

@endsection

@push('script')

<script>
    function filterLeaves(page = 1) {
        let year     = $('#year').val();
        let semester = $('#semester').val();
        let perPage  = $('select[name="perPage"]').val() || 10;

        // If pagination link clicked, extract page from URL
        if (page > 1) {
            let urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', page);
            year = urlParams.get('year') || $('#year').val();
            semester = urlParams.get('semester') || $('#semester').val();
            perPage = urlParams.get('perPage') || perPage;
        }

        $.ajax({
            url: '{{ route("parent-panel-extendedLeaves.index") }}',
            method: 'GET',
            data: {
                year: year,
                semester: semester,
                perPage: perPage,
                page: page
            },
            success: function(data) {
                $('#leaves-table-container').html(data);
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    }

    $(document).ready(function() {
        // Filter on dropdown change
        $('#year, #semester').on('change', function() {
            filterLeaves(1); // Reset to page 1
        });

        // Handle pagination links (delegate because they are loaded via AJAX)
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = new URL(this.href);
            let page = url.searchParams.get('page');
            filterLeaves(page);
        });
    });
</script>
    
@endpush