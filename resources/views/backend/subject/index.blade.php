@extends('backend.master')
@section('title')
    Subject List
@endsection
@section('content')

<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">

    <div class="ds-breadcrumb">
        <h1>Subject List</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Subject</a> /</li>
            <li>Subject List</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="ds-cmn-table-wrp">
            <div class="ds-content-head has-drpdn">
                <div class="sec-head">
                    <h2>Subject List</h2>
                </div>
                <div class="ds-cmn-filter-wrp">
                    <div class="dsbdy-filter-wrp p-0">
                        <form action="{{ route('superadmin.subject.index') }}" method="GET" id="subjectFilterForm">
                            <div class="dropdown subject-dropdown">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">{{ request('subject_name') ?: 'Select Subject' }}</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <label class="dropdown-item" data-value="">All Subjects</label>
                                    @foreach($allSubjects as $subject)
                                        <label class="dropdown-item" data-value="{{ $subject->name }}">{{ $subject->name }}</label>
                                    @endforeach
                                </div>
                                <input type="hidden" name="subject_name" id="subject_name" value="{{ request('subject_name') }}">
                            </div>
                        </form>
                        <a href="{{ route('superadmin.subject.add') }}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Subject</a>
                    </div>
                </div>
            </div>

            <div class="ds-cmn-tble count-row tbl-5_4k" id="subjectTableContainer">
                <!-- Table will be loaded here via AJAX -->
            </div>
        </div>
    </div>

</div>
<!-- End Of Dashboard Body -->

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const dropdownLabel = document.querySelector('.dropdown-toggle .label');
    const hiddenInput = document.querySelector('#subject_name');
    const form = document.querySelector('#subjectFilterForm');
    const tableContainer = document.querySelector('#subjectTableContainer');

    // Function to load table data via AJAX
    function loadTableData(url = '{{ route('superadmin.subject.index') }}') {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            tableContainer.innerHTML = data.html;
            attachPaginationListeners();
            attachPerPageListener();
        })
        .catch(error => {
            console.error('Error loading table:', error);
        });
    }

    // Function to attach click listeners to pagination links
    function attachPaginationListeners() {
        document.querySelectorAll('.tablepagination a').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                loadTableData(url);
            });
        });
    }

    // Function to attach change listener to per-page select
    function attachPerPageListener() {
        const perPageSelect = document.querySelector('select[name="per_page"]');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function () {
                const perPage = this.value;
                const url = new URL('{{ route('superadmin.subject.index') }}');
                if (hiddenInput.value) {
                    url.searchParams.set('subject_name', hiddenInput.value);
                }
                url.searchParams.set('per_page', perPage);
                loadTableData(url.toString());
            });
        }
    }

    // Handle dropdown option selection
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function () {
            const selectedValue = this.getAttribute('data-value');
            dropdownLabel.textContent = selectedValue || 'Select Subject';
            hiddenInput.value = selectedValue;
            dropdownMenu.style.display = 'none';
            
            // Construct URL with query parameters
            const url = new URL('{{ route('superadmin.subject.index') }}');
            if (selectedValue) {
                url.searchParams.set('subject_name', selectedValue);
            }
            const perPageSelect = document.querySelector('select[name="per_page"]');
            if (perPageSelect) {
                url.searchParams.set('per_page', perPageSelect.value);
            }
            loadTableData(url.toString());
        });
    });

    // Initial table load
    loadTableData();
});
</script>
@endpush