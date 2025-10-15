@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
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
    </style>

    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Leaves</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="dashboard.html">Transcript</a> /</li>
                <li>College</li>
            </ul>
        </div>

        <div class="ds-pr-body">
            

            <div class="ds-cmn-table-wrp tab-wrapper">
                <div class="ds-content-head">
                    <div class="sec-head">
                        <h2>College List</h2>
                    </div>
                    <div class="ds-cmn-filter-wrp">
                        <div class="dsbdy-filter-wrp p-0">
                            <button class="cmn-btn h-40" data-bs-target="#addCollege" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> Add Request</button>
                        </div>
                    </div>
                </div>

                <div id="college-table-content">
                    <!-- Table content will be loaded here via AJAX -->
                </div>

                <div class="tablepagination" id="pagination-links">
                    <!-- Pagination links will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Dashboard Body -->

    <!-- Add College Modal Begin -->
    <div class="modal fade cmn-popwrp pop650" id="addCollege" tabindex="-1" role="dialog" aria-labelledby="newRequest" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <h2>Add New College</h2>
                        <div class="new-request-form-wrp">
                            <form id="add-college-form">
                                <div class="new-request-form">
                                    <div class="autocomplete input-grp h48">
                                        <label for="name">College Name</label>
                                        <input class="dest" type="text" name="name" placeholder="Enter college name" autocomplete="off" required>
                                    </div>
                                    <div class="input-grp h48 paylink">
                                        <label>Funded</label>
                                        <div class="has-submit">
                                            <input type="checkbox" name="is_funded" id="is_funded" value="1">
                                        </div>
                                    </div>
                                    <div class="autocomplete input-grp h48" id="amount-field" style="display: none;">
                                        <label for="amount">Amount</label>
                                        <input class="dest" type="number" name="amount" placeholder="Enter amount" step="0.01" min="0">
                                    </div>
                                    <button type="submit" class="cmn-btn btn-sm">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Add College Modal -->

    <!-- Success Modal Begin -->
    <div class="modal fade cmn-popwrp popwrp w400" id="success" tabindex="-1" role="dialog" aria-labelledby="success" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <div class="modal-icon">
                            <img src="{{ asset('backend') }}/assets/images/new_images/check-circle-primary.svg" alt="Bin Icon">
                        </div>
                        <div class="sec-head head-center">
                            <h2>Successful</h2>
                            <p>Your college request has been submitted successfully.</p>
                            <div class="btn-wrp">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="cmn-btn btn-sm">Okay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Success Modal -->

    @push('script')

    <script>
        $(document).ready(function() {
            let perPage = '{{ request('per_page', 5) }}';

            // Function to load college data
            function loadCollegeData(page = 1, perPage = 2, filters = {}) {
                $('#college-table-content').addClass('loading');
                $.ajax({
                    url: '{{ route('transcript.college.data') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: perPage,
                        ...filters
                    },
                    success: function(response) {
                        $('#college-table-content').html(response.html);
                        $('#pagination-links').html(response.pagination);
                        $('#college-table-content').removeClass('loading');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error loading data:', textStatus, errorThrown);
                        alert('Error loading data. Please try again.');
                        $('#college-table-content').removeClass('loading');
                    }
                });
            }

            // Initial load
            loadCollegeData(1, perPage);

            // Pagination click handler
            $(document).on('click', '#pagination-links .tbl-pagination-inr a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page') || 1;
                const filters = $('#college-filter-form').serializeArray().reduce((obj, item) => {
                    obj[item.name] = item.value;
                    return obj;
                }, {});
                loadCollegeData(page, perPage, filters);
            });

            // Per page selection handler
            $(document).on('change', '#pagination-links select[name="per_page"]', function(e) {
                e.preventDefault();
                perPage = $(this).val();
                const filters = $('#college-filter-form').serializeArray().reduce((obj, item) => {
                    obj[item.name] = item.value;
                    return obj;
                }, {});
                loadCollegeData(1, perPage, filters);
            });

            // Toggle amount field based on funded checkbox
            $('#is_funded').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#amount-field').show();
                    $('#amount-field input[name="amount"]').attr('required', true);
                } else {
                    $('#amount-field').hide();
                    $('#amount-field input[name="amount"]').removeAttr('required').val('');
                }
            });

            // Add college form submission
            $('#add-college-form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serializeArray().reduce((obj, item) => {
                    obj[item.name] = item.value;
                    return obj;
                }, {});
                formData._token = '{{ csrf_token() }}';
                formData.is_funded = formData.is_funded ? 1 : 0;

                $.ajax({
                    url: '{{ route('transcript.college.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addCollege').modal('hide');
                            $('#success').modal('show');
                            loadCollegeData(1, perPage);
                            $('#add-college-form')[0].reset();
                            $('#amount-field').hide();
                            $('#amount-field input[name="amount"]').removeAttr('required');
                        } else {
                            alert('Failed to add college record: ' + (response.message || 'Unknown error'));
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error adding college record:', textStatus, errorThrown);
                        alert('Error adding college record. Please try again.');
                    },
                    complete: function() {
                        // Ensure modal backdrop is removed to prevent freeze
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                    }
                });
            });

            // Ensure modals are properly closed to prevent freeze
            $('#addCollege, #success').on('hidden.bs.modal', function() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });
        });
    </script>
        
    @endpush

@endsection
