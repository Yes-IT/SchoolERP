@extends('backend.master')

@section('title')
    {{ ___('common.School Management System | Edit Parent') }}
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
            <h1>Edit Parent</h1>
            <ul>
                <li><a href="../dashboard">Dashboard</a> /</li>
                <li><a href="{{ route('parent_flow.index') }}">Parent</a> /</li>
                <li>Edit Parent</li>
            </ul>
        </div>

        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="request-leave-form spradmin">
                    <form action="{{ route('parent_flow.parent.update', $parent->id) }}" method="POST" id="parentForm">
                        @csrf
                        @method('PUT')

                        {{-- Hidden fields --}}
                        <input type="hidden" name="parent_guardian_id" value="{{ $parent->id }}">
                        <input type="hidden" name="user_id" value="{{ $parent->user_id }}">
                        <input type="hidden" name="student_id" value="{{ $parent->student_id ?? '' }}">

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
                                <div class="input-grp">
                                    <label for="marital_status">Marital Status *</label>
                                    <select id="marital_status" name="marital_status">
                                        <option value="">Select</option>
                                        <option value="married" {{ old('marital_status', $parent->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="remarried" {{ old('marital_status', $parent->marital_status) == 'remarried' ? 'selected' : '' }}>Remarried</option>
                                        <option value="widowed" {{ old('marital_status', $parent->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="divorced" {{ old('marital_status', $parent->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="separated" {{ old('marital_status', $parent->marital_status) == 'separated' ? 'selected' : '' }}>Separated</option>
                                    </select>
                                </div>

                                <div class="input-grp w-50">
                                    <label for="legal_guardian">Which parent do you share a primary residence with? *</label>
                                    <select name="legal_guardian" id="legal_guardian">
                                        <option value="">Select Legal Guardian</option>
                                        <option value="mother" {{ old('legal_guardian', $parent->primary_custodian) == 'mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="father" {{ old('legal_guardian', $parent->primary_custodian) == 'father' ? 'selected' : '' }}>Father</option>
                                        <option value="both" {{ old('legal_guardian', $parent->primary_custodian) == 'both' ? 'selected' : '' }}>Both parents</option>
                                        <option value="legal_guardian" {{ old('legal_guardian', $parent->primary_custodian) == 'legal_guardian' ? 'selected' : '' }}>Legal guardian/s</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        {{-- ================= Parent Details ================= --}}
                        <div class="new-request-form">
                            <h3>Parent Details</h3>

                            {{-- Title & Full Name --}}
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp father-field">
                                    <label for="father_title">Father Title</label>
                                    <input id="father_title" name="father_title" type="text"
                                           value="{{ old('father_title', $parent->father_title) }}" placeholder="e.g. Mr.">
                                </div>
                                <div class="input-grp father-field">
                                    <label for="father_name">Father Name</label>
                                    <input id="father_name" name="father_name" type="text"
                                           value="{{ old('father_name', $parent->father_name) }}" placeholder="Enter father's full name">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_title">Mother Title</label>
                                    <input id="mother_title" name="mother_title" type="text"
                                           value="{{ old('mother_title', $parent->mother_title) }}" placeholder="e.g. Mrs.">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp mother-field">
                                    <label for="mother_name">Mother Name</label>
                                    <input id="mother_name" name="mother_name" type="text"
                                           value="{{ old('mother_name', $parent->mother_name) }}" placeholder="Enter mother's full name">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="maiden_name">Maiden Name (Optional)</label>
                                    <input id="maiden_name" name="maiden_name" type="text"
                                           value="{{ old('maiden_name', $parent->maiden_name) }}" placeholder="Mother's maiden name">
                                </div>
                                <div class="input-grp">
                                    &nbsp;
                                </div>
                            </div>

                            {{-- Hebrew Names --}}
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp father-field">
                                    <label for="father_hebrew_name">Father Hebrew Name (Optional)</label>
                                    <input id="father_hebrew_name" name="father_hebrew_name" type="text"
                                           value="{{ old('father_hebrew_name', $parent->father_hebrew_name) }}">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_hebrew_name">Mother Hebrew Name (Optional)</label>
                                    <input id="mother_hebrew_name" name="mother_hebrew_name" type="text"
                                           value="{{ old('mother_hebrew_name', $parent->mother_hebrew_name) }}">
                                </div>
                            </div>

                            {{-- Date of Birth --}}
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp father-field">
                                    <label for="father_dob">Father Date of Birth</label>
                                    <input id="father_dob" name="father_dob" type="date"
                                           value="{{ old('father_dob', $parent->father_dob) }}">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_dob">Mother Date of Birth</label>
                                    <input id="mother_dob" name="mother_dob" type="date"
                                           value="{{ old('mother_dob', $parent->mother_dob) }}">
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp father-field">
                                    <label for="father_phone">Father Phone</label>
                                    <input id="father_phone" name="father_phone" type="text"
                                           value="{{ old('father_phone', $parent->father_mobile) }}" placeholder="e.g. +1 123-456-7890">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_phone">Mother Phone</label>
                                    <input id="mother_phone" name="mother_phone" type="text"
                                           value="{{ old('mother_phone', $parent->mother_mobile) }}" placeholder="e.g. +1 123-456-7890">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_phone">Additional Phone (Optional)</label>
                                    <input id="additional_phone" name="additional_phone" type="text"
                                           value="{{ old('additional_phone', $parent->additional_mobile_numbers) }}">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp father-field">
                                    <label for="father_email">Father Email</label>
                                    <input id="father_email" name="father_email" type="email"
                                           value="{{ old('father_email', $parent->father_email) }}" placeholder="father@example.com">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_email">Mother Email</label>
                                    <input id="mother_email" name="mother_email" type="email"
                                           value="{{ old('mother_email', $parent->mother_email) }}" placeholder="mother@example.com">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_email">Additional Email (Optional)</label>
                                    <input id="additional_email" name="additional_email" type="email"
                                           value="{{ old('additional_email', $parent->additional_emails) }}">
                                </div>
                            </div>

                            {{-- Occupation --}}
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp father-field">
                                    <label for="father_occupation">Father Occupation</label>
                                    <input id="father_occupation" name="father_occupation" type="text"
                                           value="{{ old('father_occupation', $parent->father_profession) }}" placeholder="e.g. Engineer">
                                </div>
                                <div class="input-grp mother-field">
                                    <label for="mother_occupation">Mother Occupation</label>
                                    <input id="mother_occupation" name="mother_occupation" type="text"
                                           value="{{ old('mother_occupation', $parent->mother_profession) }}" placeholder="e.g. Teacher">
                                </div>
                                <div class="input-grp">
                                    <label for="marital_comment">Marital Comment</label>
                                    <input id="marital_comment" name="marital_comment" type="text"
                                           value="{{ old('marital_comment', $parent->marital_comment) }}"
                                           placeholder="e.g. Additional notes">
                                </div>
                            </div>

                            {{-- Parent Address (Shared) --}}
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp">
                                    <label for="parent_address">Parent Home Address (Fallback)</label>
                                    <input id="parent_address" name="parent_address" type="text"
                                           value="{{ old('parent_address', $parent->address_line) }}" placeholder="Enter full home address">
                                </div>
                            </div>
                        </div>

                        {{-- ================= Address Details ================= --}}
                        <div class="new-request-form">
                            <h3>Address Details</h3>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="address_line">Address Line</label>
                                    <input id="address_line" name="address_line" type="text"
                                           value="{{ old('address_line', $parent->address_line) }}" placeholder="Street address / Apt / House no.">
                                </div>
                                <div class="input-grp">
                                    <label for="country">Country *</label>
                                    <select id="country" name="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->country_id }}"
                                                {{ old('country', $parent->country) == $country->country_id ? 'selected' : '' }}>
                                                {{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="state">State / Province *</label>
                                    <select id="state" name="state">
                                        <option value="">Select State</option>
                                        {{-- Will be populated via AJAX or pre-filled if possible --}}
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label for="city">City *</label>
                                    <select id="city" name="city">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label for="zip_code">Zip / Postal Code</label>
                                    <input id="zip_code" name="zip_code" type="text"
                                           value="{{ old('zip_code', $parent->zip_code) }}" placeholder="e.g. 12345">
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
                                    <input id="relative_name" name="relative_name" type="text"
                                           value="{{ old('relative_name', $parent->guardian_name) }}" placeholder="Enter relative's full name">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_relationship">Relationship</label>
                                    <input id="relative_relationship" name="relative_relationship" type="text"
                                           value="{{ old('relative_relationship', $parent->guardian_relation) }}" placeholder="e.g. Grandmother, Uncle">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_home_phone">Home Phone</label>
                                    <input id="relative_home_phone" name="relative_home_phone" type="text"
                                           value="{{ old('relative_home_phone', $parent->guardian_home_phone) }}" placeholder="e.g. +1 123-456-7890">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="relative_cell_phone">Cell Phone</label>
                                    <input id="relative_cell_phone" name="relative_cell_phone" type="text"
                                           value="{{ old('relative_cell_phone', $parent->guardian_mobile) }}" placeholder="e.g. +1 987-654-3210">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_email">Email</label>
                                    <input id="relative_email" name="relative_email" type="email"
                                           value="{{ old('relative_email', $parent->guardian_email) }}" placeholder="relative@example.com">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp">
                                    <label for="relative_address">Address (Optional)</label>
                                    <input id="relative_address" name="relative_address" type="text"
                                           value="{{ old('relative_address', $parent->guardian_address) }}" placeholder="Enter relative's full address">
                                </div>
                            </div>
                        </div>

                        {{-- ================= Submit ================= --}}
                        <div class="input-grp">
                            <button type="submit" class="btn btn-primary">Update Parent</button>
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

        // Toggle visibility of father/mother fields based on legal guardian
        function toggleParentFields() {
            const guardian = $('#legal_guardian').val();

            if (guardian === 'mother') {
                $('.father-field').closest('.input-grp').addClass('hidden-section');
                $('.mother-field').closest('.input-grp').removeClass('hidden-section');
            } else if (guardian === 'father') {
                $('.mother-field').closest('.input-grp').addClass('hidden-section');
                $('.father-field').closest('.input-grp').removeClass('hidden-section');
            } else {
                $('.father-field, .mother-field').closest('.input-grp').removeClass('hidden-section');
            }
        }

        // Initial toggle on page load
        toggleParentFields();

        // Bind change event
        $('#legal_guardian').on('change', toggleParentFields);

        // Load States on Country Change
        $('#country').on('change', function() {
            var country_id = $(this).val();
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
                                $('#state').append('<option value="' + value.id_state + '">' + value.state + '</option>');
                            });
                            $('#state').prop('disabled', false);

                            // If current state value exists, select it
                            @if(old('state', $parent->state))
                                $('#state').val('{{ old('state', $parent->state) }}');
                                $('#state').trigger('change');
                            @endif
                        }
                    }
                });
            }
        });

        // Load Cities on State Change
        $('#state').on('change', function() {
            var state_id = $(this).val();
            $('#city').empty().append('<option value="">Select City</option>').prop('disabled', true);

            if (state_id) {
                $.ajax({
                    url: '{{ route("get.cities", ["state_id" => ":state_id"]) }}'.replace(':state_id', state_id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' + value.city + '</option>');
                            });
                            $('#city').prop('disabled', false);

                            // Pre-select current city if available
                            @if(old('city', $parent->city))
                                $('#city').val('{{ old('city', $parent->city) }}');
                            @endif
                        }
                    }
                });
            }
        });

        // Trigger country change on load to populate state/city if country is pre-selected
        @if(old('country', $parent->country))
            $('#country').trigger('change');
        @endif

        // AJAX Form Submission
        $('#parentForm').on('submit', function(e) {
            e.preventDefault();

            $('.input-grp').removeClass('error');
            $('.error-message').remove();

            let formData = new FormData(this);
            if (selectedStudentId) {
                formData.append('student_id', selectedStudentId);
            }

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        alert('Parent updated successfully!');
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