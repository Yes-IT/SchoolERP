@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
<style>
    .gray-bg {
    background-color: #c0c0c0 !important;
    color: #666 !important;
    cursor: not-allowed !important;
    opacity: 0.7;
   }

   .single-centered-btn {
    text-wrap: nowrap;
}




</style>

@section('content')
            <div class="ds-breadcrumb">
                <h1>Student Application Forms</h1>
                <ul>
                    <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                    <li><a href="{{route('applicant.student_application_form')}}">Student Application Forms</a> /</li>
                    
                </ul>
            </div>
            <div class="ds-pr-body">
                
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Filters</h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                        <form id="filterForm">
                            @csrf
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options multi-input-grp">
                                    <div class="input-grp">
                                        <select name="session_id" id="session_id">
                                            <option value="">Select Year</option>
                                            @foreach($sessions as $session)
                                                <option value="{{ $session->id }}" 
                                                    {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                                    {{ $session->name }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select name="year_status_id" id="year_status_id">
                                            <option value="">Select Year Status</option>
                                            @foreach($yearStatuses as $yearStatus)
                                                <option value="{{ $yearStatus->id }}"
                                                    {{ request('year_status_id') == $yearStatus->id ? 'selected' : '' }}>
                                                    {{ $yearStatus->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Hidden field for applicant name -->
                                 <input type="hidden" name="applicant_name" id="applicant_name" value="{{ request('applicant_name') }}">

                                <!-- Search Button -->
                                <button type="submit" class="btn-search">Search</button>
                            </div>
                        </form>
                    </div> 
                </div>

                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Application Forms List</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Select Applicant">
                                    <div class="dropdown-trigger">
                                      <span class="dropdown-label">Select Applicant</span>
                                      <i class="dropdown-arrow"></i>
                                    </div>
                                    <div class="dropdown-options">
                                          <div class="dropdown-search">
                                                <input type="text" 
                                                    id="dropdownSearch" 
                                                    class="form-control" 
                                                    placeholder="Search applicants..."
                                                    autocomplete="off">
                                                <i class="search-icon"></i>
                                            </div>
                                          <div class="dropdown-option" data-value="">All Applicants</div>
                                                @foreach($applicantNames as $applicant)
                                                    <div class="dropdown-option" data-value="{{ $applicant->full_name }}">
                                                        {{ $applicant->full_name }}
                                                    </div>
                                                @endforeach
                                         </div>  
                                    </div>
                                </div>

                               <input type="hidden" name="applicant_name" id="applicant_name" value="">
                                
                                 
                            </div>
                        </div>
                    </div>

                    <div class="ds-cmn-tble count-row " id="applicantTableContainer">
                         @include('backend.applicant.partials.applicant_list', ['applicants' => $applicants])
                    </div>

                   
                </div>
                  
            </div>



@endsection

@push('script')
<script>
// document.addEventListener('DOMContentLoaded', function () {
//     const tableContainer = document.querySelector('#applicantTableContainer');

//     function loadTableData(url = '{{ route('applicant.student_application_form') }}') {
//         fetch(url, {
//             headers: { 'X-Requested-With': 'XMLHttpRequest' }
//         })
//         .then(response => {
//             if (!response.ok) throw new Error('Network response was not ok');
//             return response.json();
//         })
//         .then(data => {
//             tableContainer.innerHTML = data.html;
//             attachPaginationListeners(); 
//         })
//         .catch(console.error);
//     }

//     function attachPaginationListeners() {
//         document.querySelectorAll('.tablepagination a').forEach(link => {
//             link.addEventListener('click', e => {
//                 e.preventDefault();
//                 const pageUrl = link.getAttribute('href');
//                 loadTableData(pageUrl);
//             });
//         });
//     }

//     attachPaginationListeners();
// });

</script>

<script>
   
    document.addEventListener('DOMContentLoaded', function () {
        const tableContainer = document.querySelector('#applicantTableContainer');
        const filterForm = document.querySelector('#filterForm');
        const resetFilter = document.querySelector('#resetFilter');
        const applicantNameField = document.querySelector('#applicant_name');
        const dropdownTrigger = document.querySelector('.dropdown-trigger');
        const dropdownLabel = document.querySelector('.dropdown-label');
        const dropdownOptions = document.querySelector('.dropdown-options');
        const dropdownSearchInput = document.querySelector('#dropdownSearch');
        const perPageSelect = document.querySelector('#perPageSelect');
        const perPageForm = document.querySelector('#perPageForm');

        dropdownTrigger.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownOptions.classList.toggle('active');
            if (dropdownOptions.classList.contains('active')) {
                dropdownSearchInput.focus();
            }
        });

        dropdownOptions.addEventListener('click', function (e) {
            e.stopPropagation(); 
        });

        if (dropdownSearchInput) {
            dropdownSearchInput.addEventListener('keyup', function () {
                const filterValue = this.value.toLowerCase();
                const options = dropdownOptions.querySelectorAll('.dropdown-option');
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(filterValue) ? '' : 'none';
                });
            });
        }

        dropdownOptions.querySelectorAll('.dropdown-option').forEach(option => {
            option.addEventListener('click', function () {
                const applicantName = this.getAttribute('data-value');
                const applicantText = this.textContent.trim();

                dropdownLabel.textContent = applicantText;
                applicantNameField.value = applicantName;

                dropdownOptions.classList.remove('active');
                dropdownSearchInput.value = '';
                dropdownOptions.querySelectorAll('.dropdown-option').forEach(opt => (opt.style.display = ''));

                applyFilter();
            });
        });

        document.addEventListener('click', function (event) {
            const isClickInsideDropdown =
                dropdownTrigger.contains(event.target) || dropdownOptions.contains(event.target);
            if (!isClickInsideDropdown) {
                dropdownOptions.classList.remove('active');
                dropdownSearchInput.value = '';
                dropdownOptions.querySelectorAll('.dropdown-option').forEach(opt => (opt.style.display = ''));
            }
        });

        function applyFilter() {
            const formData = new FormData(filterForm);

            if (perPageSelect) {
                formData.set('per_page', perPageSelect.value);
            }

            loadTableData('{{ route('applicant.student_application_form') }}', formData);
        }

        function loadTableData(url = '{{ route('applicant.student_application_form') }}', formData = null) {
            let finalUrl = url;
            if (formData) {
                const params = new URLSearchParams(formData);
                finalUrl = `${url}?${params.toString()}`;
            }

           console.log('Loading table data from:', finalUrl); // Debug log

            fetch(finalUrl, { 
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                } 
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    tableContainer.innerHTML = data.html;
                    attachPaginationListeners();
                })
                .catch(error => {
                    console.error('Error loading table data:', error);
                });
        }

        function attachPaginationListeners() {
        document.querySelectorAll('.tablepagination a').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const pageUrl = link.getAttribute('href');
                const formData = new FormData(filterForm);
                
                // Add per_page to pagination links
                if (perPageSelect) {
                    formData.set('per_page', perPageSelect.value);
                }
                
                loadTableData(pageUrl, formData);
            });
        });
    }

        if (filterForm) {
            filterForm.addEventListener('submit', function (e) {
                e.preventDefault();
                applyFilter();
            });
        }

        if (resetFilter) {
            resetFilter.addEventListener('click', function () {
                filterForm.reset();
                applicantNameField.value = '';
                dropdownLabel.textContent = 'Select Applicant';
                dropdownSearchInput.value = '';
                dropdownOptions.querySelectorAll('.dropdown-option').forEach(opt => (opt.style.display = ''));
                
                // Reset per_page to default if needed
                if (perPageSelect) {
                    perPageSelect.value = '10';
                }
                
                loadTableData('{{ route('applicant.student_application_form') }}');
            });
        }


        if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const perPage = this.value;
                    console.log("Per page changed to:", perPage);
                    
                    // Use filter form data and add per_page
                    const formData = new FormData(filterForm);
                    formData.set('per_page', perPage);
                    formData.delete('page'); // Reset to first page when changing per_page
                    
                    console.log("Form data with per_page:", Object.fromEntries(formData));
                    
                    loadTableData('{{ route('applicant.student_application_form') }}', formData);
                });
         }
         
        attachPaginationListeners();
    });

    $(document).ready(function () {
        $('.applicant-action-btn').on('click', function () {
            let applicantId = $(this).data('id');
            let action = $(this).data('action');
            let $row = $(this).closest('tr');

            if (!confirm(`Are you sure you want to ${action} this applicant?`)) {
                return;
            }

            $.ajax({
                url: "{{ route('applicant.applicant_update_status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    applicant_id: applicantId,
                    status: action
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);

                        let $statusCell = $row.find('td').eq(-2).find('span');
                        $statusCell.text(response.new_status);

                        $statusCell.removeClass('green-bg red-bg yellow-bg');

                        if (response.new_status === 'accept') {
                            $statusCell.addClass('green-bg');
                            $statusCell.text('Approved');
                        } else if (response.new_status === 'not_accepted') {
                            $statusCell.addClass('red-bg');
                            $statusCell.text('Rejected');
                        } else {
                            $statusCell.addClass('yellow-bg');
                            $statusCell.text('Pending');
                        }

                        $row.find('.applicant-action-btn').prop('disabled', true);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('Something went wrong while updating the status.');
                }
            });
        });
    });
</script>

<script>
// working script    
// $(document).ready(function () {
//     $('.applicant-action-btn').on('click', function () {
//         let applicantId = $(this).data('id');
//         let action = $(this).data('action'); // approved / rejected
//         let $row = $(this).closest('tr');

//         if (!confirm(`Are you sure you want to ${action} this applicant?`)) {
//             return;
//         }

//         $.ajax({
//             url: "{{ route('applicant.applicant_update_status') }}",
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//                 applicant_id: applicantId,
//                 status: action
//             },
//             success: function (response) {
//                 if (response.success) {
//                     alert(response.message);

//                     // Update status cell
//                     let $statusCell = $row.find('td').eq(-2).find('span');
//                     $statusCell.text(response.new_status);

//                     // Reset color classes
//                     $statusCell.removeClass('green-bg red-bg yellow-bg');

//                     if (response.new_status === 'accept') {
//                         $statusCell.addClass('green-bg');
//                         $statusCell.text('Approved');
//                     } else if (response.new_status === 'not_accepted') {
//                         $statusCell.addClass('red-bg');
//                         $statusCell.text('Rejected');
//                     } else {
//                         $statusCell.addClass('yellow-bg');
//                         $statusCell.text('Pending');
//                     }

//                     // Disable or hide buttons
//                     $row.find('.applicant-action-btn').prop('disabled', true);
//                 } else {
//                     alert('Error: ' + response.message);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error:', error);
//                 alert('Something went wrong while updating the status.');
//             }
//         });
//     });
// });

</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
    const tableContainer = document.querySelector('#applicantTableContainer');
    const filterForm = document.querySelector('#filterForm');
    const resetFilter = document.querySelector('#resetFilter');
    const applicantNameField = document.querySelector('#applicant_name');
    const dropdownTrigger = document.querySelector('.dropdown-trigger');
    const dropdownLabel = document.querySelector('.dropdown-label');
    const dropdownOptions = document.querySelector('.dropdown-options');
    const dropdownSearch = document.getElementById('dropdownSearch');
    const dropdownOptionsList = document.querySelector('.dropdown-options-list');
    const originalOptions = dropdownOptionsList.innerHTML; 

    let searchTimeout;

    // Dropdown functionality
    dropdownTrigger.addEventListener('click', function() {
        dropdownOptions.classList.toggle('active');
        // Focus on search input when dropdown opens
        if (dropdownOptions.classList.contains('active')) {
            setTimeout(() => {
                dropdownSearch.focus();
            }, 100);
        }
    });

    // Search functionality for dropdown
    dropdownSearch.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const searchTerm = e.target.value.trim().toLowerCase();
        
        searchTimeout = setTimeout(() => {
            filterDropdownOptions(searchTerm);
        }, 300);
    });

    // Filter dropdown options based on search
    function filterDropdownOptions(searchTerm) {
        const allOptions = document.querySelectorAll('.dropdown-option');
        
        if (!searchTerm) {
            // Show all options if search is empty
            allOptions.forEach(option => {
                option.style.display = 'block';
            });
            return;
        }

        // Filter options
        allOptions.forEach(option => {
            const optionText = option.textContent.toLowerCase();
            if (optionText.includes(searchTerm)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    }

    // Clear search when dropdown closes
    dropdownOptions.addEventListener('click', function(e) {
        if (e.target.classList.contains('dropdown-search') || 
            e.target.id === 'dropdownSearch') {
            e.stopPropagation(); // Prevent dropdown from closing when clicking search
        }
    });

    // Handle dropdown option selection
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('dropdown-option')) {
            const applicantName = e.target.getAttribute('data-value');
            const applicantText = e.target.textContent;
            
            // Update dropdown label
            dropdownLabel.textContent = applicantText;
            
            // Set the hidden field value
            applicantNameField.value = applicantName;
            
            // Close dropdown
            dropdownOptions.classList.remove('active');
            
            // Reset search and show all options
            dropdownSearch.value = '';
            filterDropdownOptions('');
            
            // Apply filter immediately
            applyFilter();
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdownTrigger.contains(event.target) && !dropdownOptions.contains(event.target)) {
            dropdownOptions.classList.remove('active');
            // Reset search when dropdown closes
            dropdownSearch.value = '';
            filterDropdownOptions('');
        }
    });

    // Handle Enter key in search
    dropdownSearch.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            // Select first visible option or do nothing
            const firstVisibleOption = document.querySelector('.dropdown-option[style=""]', 
                '.dropdown-option:not([style*="display: none"])');
            if (firstVisibleOption) {
                firstVisibleOption.click();
            }
        }
    });

    // Apply filter function
    function applyFilter() {
        const formData = new FormData(filterForm);
        loadTableData('{{ route('applicant.student_application_form') }}', formData);
    }

    function loadTableData(url = '{{ route('applicant.student_application_form') }}', formData = null) {
        let finalUrl = url;
        
        if (formData) {
            const params = new URLSearchParams(formData);
            finalUrl = `${url}?${params.toString()}`;
        }

        fetch(finalUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            tableContainer.innerHTML = data.html;
            attachPaginationListeners(); 
        })
        .catch(console.error);
    }

    function attachPaginationListeners() {
        document.querySelectorAll('.tablepagination a').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const pageUrl = link.getAttribute('href');
                const formData = new FormData(filterForm);
                loadTableData(pageUrl, formData);
            });
        });
    }

    // Handle main filter form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilter();
    });

    // Handle reset filter
    if (resetFilter) {
        resetFilter.addEventListener('click', function() {
            filterForm.reset();
            applicantNameField.value = '';
            dropdownLabel.textContent = 'Select Applicant';
            dropdownSearch.value = '';
            filterDropdownOptions('');
            loadTableData('{{ route('applicant.student_application_form') }}');
        });
    }

    attachPaginationListeners();
});

// Keep your existing jQuery code for applicant actions (unchanged)
$(document).ready(function () {
    $('.applicant-action-btn').on('click', function () {
        let applicantId = $(this).data('id');
        let action = $(this).data('action');
        let $row = $(this).closest('tr');

        if (!confirm(`Are you sure you want to ${action} this applicant?`)) {
            return;
        }

        $.ajax({
            url: "{{ route('applicant.applicant_update_status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                applicant_id: applicantId,
                status: action
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);

                    let $statusCell = $row.find('td').eq(-2).find('span');
                    $statusCell.text(response.new_status);

                    $statusCell.removeClass('green-bg red-bg yellow-bg');

                    if (response.new_status === 'accept') {
                        $statusCell.addClass('green-bg');
                        $statusCell.text('Approved');
                    } else if (response.new_status === 'not_accepted') {
                        $statusCell.addClass('red-bg');
                        $statusCell.text('Rejected');
                    } else {
                        $statusCell.addClass('yellow-bg');
                        $statusCell.text('Pending');
                    }

                    $row.find('.applicant-action-btn').prop('disabled', true);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Something went wrong while updating the status.');
            }
        });
    });
});
</script> --}}
    
@endpush