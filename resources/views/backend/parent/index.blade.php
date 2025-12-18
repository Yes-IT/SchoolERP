@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Parent') }}
@endsection


@section('content')
    
    <div class="ds-breadcrumb">
        <h1>Parents</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Parents</a> /</li>
            <li>Parents List</li>
        </ul>
    </div>

    {{-- @dump($parents->toArray()); --}}

    <div class="ds-pr-body">
        
        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter student-filter">
                <form  method="GET" id="filterForm" >

                    <input type="hidden" name="student_id" id="selectedStudentId">

                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options multi-input-grp">

                            <div class="input-grp">
                                <select name="session_year" class="form-control" id="sessionYearSelect">
                                    <option value="">Select Year</option>
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session->id }}" 
                                            {{ request('session_year') == $session->id ? 'selected' : '' }}>
                                            {{ $session->name }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Year Status --}}
                            <div class="input-grp">
                                <select name="year_status" class="form-control" id="yearStatusSelect">
                                    <option value="">Select Year Status</option>
                                     @foreach ($yearStatuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ request('year_status') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}  
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div> 
        </div>

        <div class="ds-cmn-table-wrp">
            
            <div class="ds-content-head has-drpdn">
                <div class="sec-head">
                    <h2>Parents List</h2>
                </div>
                <div class="ds-cmn-filter-wrp">
                    <div class="dsbdy-filter-wrp p-0">
                        <div class="dropdown-year" data-selected="Select Student">
                            <div class="dropdown-trigger">
                                {{-- <span class="dropdown-label" id="dropdownLabel">
                                    Select Student
                                </span> --}}
                                <span class="dropdown-label" id="dropdownLabel">
                                    @if(request('student_id') && $selectedStudent)
                                        {{ $selectedStudent->first_name }} {{ $selectedStudent->last_name }}
                                    @else
                                        Select Student
                                    @endif
                                </span>
                                <i class="dropdown-arrow"></i>
                            </div>

                            <div class="dropdown-options" id="dropdownOptions">
                                <input 
                                    type="text" 
                                    class="dropdown-search" 
                                    placeholder="Search student..."
                                    onkeyup="filterStudents(this.value)"
                                >
                                @foreach ($students as $student)
                                    <div 
                                        class="dropdown-option" 
                                        data-value="{{ $student->id }}"
                                        data-name="{{ $student->first_name }} {{ $student->last_name }}"
                                        onclick="selectStudent({{ $student->id }}, '{{ $student->first_name }} {{ $student->last_name }}')"
                                    >
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            <a href="{{ route('parent_flow.parent.add') }}" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Parent</a>
                            {{-- <a href="./phone-log.html" class="cmn-btn btn-sm">Phone Log</a> --}}
                    </div>
                </div>
            </div>

            <div id="parentListContainer">
                @include('backend.parent.parent-list')
            </div>

        </div>
            
    </div>

@endsection

@push('script')

<script>

document.addEventListener('DOMContentLoaded', function() {
    const isRefresh = performance.navigation.type === 1 || 
                      performance.getEntriesByType("navigation")[0]?.type === "reload";
    
    if (isRefresh) {
        if (window.location.search) {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
            document.getElementById('dropdownLabel').textContent = 'Select Student';
        }
    }
    
    initDropdown();
    initFilters();
    updateFormFromUrl();
});

// Select student function
function selectStudent(studentId) {
    const selectedOption = document.querySelector(`.dropdown-option[data-value="${studentId}"]`);
    const studentName = selectedOption ? selectedOption.getAttribute('data-name') : '';

    document.getElementById('dropdownLabel').textContent = studentName;
    document.getElementById('selectedStudentId').value = studentId;
    loadParents();
}

function filterStudents(keyword) {
    keyword = keyword.toLowerCase();
    
    document.querySelectorAll('.dropdown-option').forEach(option => {
        const name = option.getAttribute('data-name').toLowerCase();
        option.style.display = name.includes(keyword) ? 'block' : 'none';
    });
}

// Dropdown functionality
function initDropdown() {
    const dropdownTrigger = document.querySelector('.dropdown-trigger');
    const dropdownOptions = document.getElementById('dropdownOptions');
    
    if (dropdownTrigger && dropdownOptions) {
        dropdownTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
        });
    }
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-year') && dropdownOptions) {
            dropdownOptions.style.display = 'none';
        }
    });
}

function initFilters() {
    const filterForm = document.getElementById('filterForm');
    const sessionYearSelect = document.getElementById('sessionYearSelect');
    const yearStatusSelect = document.getElementById('yearStatusSelect');

    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loadParents();
        });
    }
    
    if (sessionYearSelect) {
        sessionYearSelect.addEventListener('change', function() {
            loadParents();
        });
    }
    
    if (yearStatusSelect) {
        yearStatusSelect.addEventListener('change', function() {
            loadParents();
        });
    }
}

function loadParents(page = 1) {
   
    const formData = new FormData(document.getElementById('filterForm'));
    const params = new URLSearchParams(formData);
    const urlParams = new URLSearchParams(window.location.search);
    const currentPerPage = urlParams.get('per_page');
    if (currentPerPage) {
        params.set('per_page', currentPerPage);
    }
    
    params.set('page', page);
    const url = new URL(window.location.href);
    url.search = params.toString();
    
    const container = document.getElementById('parentListContainer');
    container.innerHTML = '<div class="text-center p-3">Loading...</div>';

    fetch(url.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.html) {
            container.innerHTML = data.html;
            initPagination(); 
            updateBrowserHistory(url); 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        container.innerHTML = '<div class="text-center p-3 text-danger">Error loading data</div>';
    });
}

function initPagination() {
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = new URL(this.href);
            const page = url.searchParams.get('page');
            
            if (page) {
                loadParents(page);
            }
        });
    });

    document.querySelectorAll('.pagination .per-page-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            const perPage = this.getAttribute('data-per-page');
            if (perPage) {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                url.searchParams.delete('page'); 
                
                window.history.pushState({}, document.title, url.toString());
                loadParents(1);
            }
        });
    });
}

function updateBrowserHistory(url) {
    window.history.pushState({}, document.title, url.toString());
}

window.addEventListener('popstate', function() {
    const url = new URL(window.location.href);
    const page = url.searchParams.get('page') || 1;
    updateFormFromUrl();
    loadParents(page);
});

function updateFormFromUrl() {
    const url = new URL(window.location.href);
    const studentId = url.searchParams.get('student_id');

    if (studentId) {
        document.getElementById('selectedStudentId').value = studentId;
        const selectedOption = document.querySelector(`.dropdown-option[data-value="${studentId}"]`);
        if (selectedOption) {
            const studentName = selectedOption.getAttribute('data-name');
            document.getElementById('dropdownLabel').textContent = studentName;
        }
    }
    
    const sessionYear = url.searchParams.get('session_year');
    if (sessionYear && document.getElementById('sessionYearSelect')) {
        document.getElementById('sessionYearSelect').value = sessionYear;
    }
    
    const yearStatus = url.searchParams.get('year_status');
    if (yearStatus && document.getElementById('yearStatusSelect')) {
        document.getElementById('yearStatusSelect').value = yearStatus;
    }
}
</script>

  
@endpush