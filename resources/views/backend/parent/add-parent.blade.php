@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Add Parent') }}
@endsection

<style>
    .input-grp.error input,
    .input-grp.error select {
        border-color: red !important;
    }

    .hidden-section {
        display: none !important;
    }
</style>

@section('content')
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Add Parent</h1>
            <ul>
                <li><a href="../dashboard">Dashboard</a> /</li>
                <li><a href="./dashboard">Parent</a> /</li>
                <li>Add Parent</li>
            </ul>
        </div>

        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="request-leave-form spradmin">
                    <form action="" method="POST" id="parentForm">
                        @csrf

                        {{-- ================= Marital Status ================= --}}
                        <div class="new-request-form">

                            <div class="dropdown-year" data-selected="Select Student">
                                <div class="dropdown-trigger">
                                    <span class="dropdown-label">Connect Student To Existing Parent</span>
                                    <i class="dropdown-arrow"></i>
                                </div>
                                <div class="dropdown-options">
                                    @foreach ($students as $student)
                                        <div 
                                            class="dropdown-option" 
                                            data-value="{{ $student->id }}">
                                            {{ $student->first_name }} {{ $student->last_name }} - {{ $student->student_id }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <br><br>

                            <h3>Marital Status</h3>

                            <div class="multi-input-grp grp-3">

                                <div class="input-grp ">
                                    <label for="marital_status">Marital Status *</label>
                                    <select id="marital_status" name="marital_status">
                                        <option value="">Select</option>
                                        <option value="married">Married</option>
                                        <option value="remarried">Remarried</option>
                                        <option value="widowed">Widowed</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="separated">Separated</option>
                                    </select>
                                </div>

                                <div class="input-grp w-50">
                                    <label for="legal_guardian">Which parent do you share a primary residence with? *</label>
                                    <select name="legal_guardian" id="legal_guardian">
                                        <option value="">Select Legal Guardian</option>
                                        <option value="mother">Mother</option>
                                        <option value="father">Father</option>
                                        <option value="both">Both parents</option>
                                        <option value="legal_guardian">Legal guardian/s</option>
                                    </select>
                                </div>
                               
                            </div>
                        </div>

                        {{-- ================= Parent Details (Field-wise) ================= --}}
                        <div class="new-request-form">
                            <h3>Parent Details</h3>

                            {{-- Title & Full Name --}}
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp father-field">
                                    <label for="father_title">Father Title</label>
                                    <input id="father_title" name="father_title" type="text" placeholder="e.g. Mr.">
                                </div>
                                <div class="input-grp father-field">
                                    <label for="father_name">Father Name</label>
                                    <input id="father_name" name="father_name" type="text" placeholder="Enter father's full name">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_title">Mother Title</label>
                                    <input id="mother_title" name="mother_title" type="text" placeholder="e.g. Mrs.">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp mother-field">
                                    <label for="mother_name">Mother Name</label>
                                    <input id="mother_name" name="mother_name" type="text" placeholder="Enter mother's full name">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="maiden_name">Maiden Name (Optional)</label>
                                    <input id="maiden_name" name="maiden_name" type="text" placeholder="Mother's maiden name">
                                </div>
                                <div class="input-grp"> <!-- Empty spacer for alignment -->
                                    &nbsp;
                                </div>
                            </div>

                            {{-- Hebrew Names --}}
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp father-field">
                                    <label for="father_hebrew_name">Father Hebrew Name (Optional)</label>
                                    <input id="father_hebrew_name" name="father_hebrew_name" type="text">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_hebrew_name">Mother Hebrew Name (Optional)</label>
                                    <input id="mother_hebrew_name" name="mother_hebrew_name" type="text">
                                </div>
                            </div>

                            {{-- Date of Birth --}}
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp father-field">
                                    <label for="father_dob">Father Date of Birth</label>
                                    <input id="father_dob" name="father_dob" type="date">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_dob">Mother Date of Birth</label>
                                    <input id="mother_dob" name="mother_dob" type="date">
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp father-field">
                                    <label for="father_phone">Father Phone</label>
                                    <input id="father_phone" name="father_phone" type="text" placeholder="e.g. +1 123-456-7890">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_phone">Mother Phone</label>
                                    <input id="mother_phone" name="mother_phone" type="text" placeholder="e.g. +1 123-456-7890">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_phone">Additional Phone (Optional)</label>
                                    <input id="additional_phone" name="additional_phone" type="text">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp father-field">
                                    <label for="father_email">Father Email</label>
                                    <input id="father_email" name="father_email" type="email" placeholder="father@example.com">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_email">Mother Email</label>
                                    <input id="mother_email" name="mother_email" type="email" placeholder="mother@example.com">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_email">Additional Email (Optional)</label>
                                    <input id="additional_email" name="additional_email" type="email">
                                </div>
                            </div>

                            {{-- Occupation --}}
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp father-field">
                                    <label for="father_occupation">Father Occupation</label>
                                    <input id="father_occupation" name="father_occupation" type="text" placeholder="e.g. Engineer">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_occupation">Mother Occupation</label>
                                    <input id="mother_occupation" name="mother_occupation" type="text" placeholder="e.g. Teacher">
                                </div>
                                <div class="input-grp ">
                                    <label for="marital_comment">Marital Comment</label>
                                    <input id="marital_comment" name="marital_comment" type="text" placeholder="e.g.">
                                </div>
                            </div>

                            {{-- Parent Address (Shared) --}}
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp">
                                    <label for="parent_address">Parent Home Address</label>
                                    <input id="parent_address" name="parent_address" type="text" placeholder="Enter full home address">
                                </div>
                            </div>
                        </div>


                        {{-- ================= Address Details ================= --}}
                        <div class="new-request-form">
                            <h3>Address Details</h3>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="address_line">Address Line</label>
                                    <input id="address_line" name="address_line" type="text" placeholder="Street address / Apt / House no.">
                                </div>
                                <div class="input-grp">
                                    <label for="country">Country *</label>
                                    <select id="country" name="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)  {{-- Assume you pass $countries from controller --}}
                                            <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="state">State / Province *</label>
                                    <select id="state" name="state" disabled>
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label for="city">City *</label>
                                    <select id="city" name="city" disabled>
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label for="zip_code">Zip / Postal Code</label>
                                    <input id="zip_code" name="zip_code" type="text" placeholder="e.g. 12345">
                                </div>
                            </div>
                        </div>


                        {{-- ================= Daughter Info ================= --}}
                        <div class="new-request-form">
                            <h3>Daughter Info</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="daughter_name">Student Name</label>
                                    <input id="daughter_name" name="daughter_name" type="text" placeholder="Enter daughter's full name" readonly>
                                </div>
                                <div class="input-grp">
                                    <label for="school_year">School Year</label>
                                    <input id="school_year" name="school_year" type="text" placeholder="e.g. 2025-2026" readonly>
                                </div>
                                <div class="input-grp">
                                    <label for="year_status">Year Status</label>
                                    <input id="year_status" name="year_status" type="text" placeholder="e.g. Grade 10" readonly>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="daughter_dob">Birth Date</label>
                                    <input id="daughter_dob" name="daughter_dob" type="date">
                                </div>
                            </div>
                        </div>

                        {{-- ================= Relative Details ================= --}}
                        <div class="new-request-form">
                            <h3>Relative Details</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="relative_name">Name</label>
                                    <input id="relative_name" name="relative_name" type="text" placeholder="Enter relative's full name">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_relationship">Relationship</label>
                                    <input id="relative_relationship" name="relative_relationship" type="text" placeholder="e.g. Grandmother, Uncle">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_home_phone">Home Phone</label>
                                    <input id="relative_home_phone" name="relative_home_phone" type="text" placeholder="e.g. +1 123-456-7890">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="relative_cell_phone">Cell Phone</label>
                                    <input id="relative_cell_phone" name="relative_cell_phone" type="text" placeholder="e.g. +1 987-654-3210">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_email">Email</label>
                                    <input id="relative_email" name="relative_email" type="email" placeholder="relative@example.com">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp">
                                    <label for="relative_address">Address (Optional)</label>
                                    <input id="relative_address" name="relative_address" type="text" placeholder="Enter relative's full address">
                                </div>
                            </div>
                        </div>

                        {{-- ================= Submit ================= --}}
                        <div class="input-grp">
                            <button type="submit" class="btn btn-primary">Save Parent</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

<script>

    $(document).ready(function() {

        // Toggle visibility of father/mother fields
        function toggleParentFields() {
            const guardian = $('#legal_guardian').val();

            if (guardian === 'mother') {
                $('.father-field').closest('.input-grp').addClass('hidden-section');
                $('.mother-field').closest('.input-grp').removeClass('hidden-section');
            } else if (guardian === 'father') {
                $('.mother-field').closest('.input-grp').addClass('hidden-section');
                $('.father-field').closest('.input-grp').removeClass('hidden-section');
            } else {
                // Both or Legal guardian/s or none → show all
                $('.father-field, .mother-field').closest('.input-grp').removeClass('hidden-section');
            }
        }

        // Toggle non-married section
        function toggleNonMarriedSection() {
            const status = $('#marital_status').val();
            if (status === 'married') {
                $('#non-married-section').addClass('hidden-section');
            } else {
                $('#non-married-section').removeClass('hidden-section');
            }
        }

        // Initial toggle
        toggleParentFields();
        toggleNonMarriedSection();

        // Bind events
        $('#legal_guardian').on('change', toggleParentFields);
        $('#marital_status').on('change', toggleNonMarriedSection);

        // AJAX Submission
        $('#parentForm').on('submit', function(e) {
            e.preventDefault();

            $('.input-grp').removeClass('error');
            $('.error-message').remove();

            let formData = new FormData(this);

            if (selectedStudentId) {
                formData.append('student_id', selectedStudentId);
            }

            $.ajax({
                url: '{{ route("parent_flow.parent.store") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        alert('Parent added successfully!');
                        window.location.href = '{{ route("parent_flow.index") }}';
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let inputField = $('[name="' + field + '"]');
                            let inputGroup = inputField.closest('.input-grp');
                            inputGroup.addClass('error');
                            inputGroup.find('.error-message').remove();
                            let errorHtml = '<span class="error-message" style="color:red; font-size:12px; display:block; margin-top:5px;">' + messages[0] + '</span>';
                            inputGroup.append(errorHtml);
                        });
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });

</script>


<script>

    $(document).ready(function() {

        $('#country').on('change', function() {
            var country_id = $(this).val();

            // Reset state and city dropdowns
            $('#state').empty().append('<option value="">Select State</option>').prop('disabled', true);
            $('#city').empty().append('<option value="">Select City</option>').prop('disabled', true);

            if (country_id) {
                $.ajax({
                    url: '{{ route("get.states", ["country_id" => ":country_id"]) }}'.replace(':country_id', country_id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                // Use 'id_state' as value and 'state' as display text
                                $('#state').append('<option value="' + value.id_state + '">' + value.state + '</option>');
                            });
                            $('#state').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        console.log('Error loading states:', xhr.responseText);
                        alert('Failed to load states.');
                    }
                });
            }
        });

        $('#state').on('change', function() {
            var state_id = $(this).val();

            // Reset city dropdown
            $('#city').empty().append('<option value="">Select City</option>').prop('disabled', true);

            if (state_id) {
                $.ajax({
                    url: '{{ route("get.cities", ["state_id" => ":state_id"]) }}'.replace(':state_id', state_id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                // Use 'id' as value and 'city' as display text
                                $('#city').append('<option value="' + value.id + '">' + value.city + '</option>');
                            });
                            $('#city').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        console.log('Error loading cities:', xhr.responseText);
                        alert('Failed to load cities.');
                    }
                });
            }
        });

    });

</script>


<script>
        let selectedStudentId = null; // Will hold the selected student ID

        $('.dropdown-trigger').on('click', function() {
            $(this).parent().toggleClass('open');
        });

        $('.dropdown-option').on('click', function() {
            const value = $(this).data('value');
            const text = $(this).text();

            selectedStudentId = value; // Store the ID

            // === Fetch student details and fill Daughter Info ===
            if (value) {
                $.ajax({
                    url: '{{ route("parent_flow.parent_flow.get_student_details", ["id" => ":id"]) }}'.replace(':id', value),
                    type: 'GET',
                    dataType: 'json',
                    success: function(student) {
                        $('#daughter_name').val(
                            (student.first_name ?? '') + ' ' + (student.last_name ?? '')
                        );
                        $('#school_year').val(student.school_year ?? '');
                        $('#year_status').val(student.year_status ?? '');
                        $('#daughter_dob').val(student.date_of_birth ?? '');
                    },
                    error: function() {
                        alert('Failed to load student details.');
                    }
                });
            } else {
                // Clear fields if deselected (optional)
                $('#daughter_name, #school_year, #year_status, #daughter_dob').val('');
            }
        });

</script>

@endpush