@extends('backend.master')

@section('title')
    Edit Parent
@endsection

<style>
    .input-grp.error input,
    .input-grp.error select {
        border-color: red !important;
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
                        @method('PUT') <!-- Important for update -->

                        {{-- Hidden fields --}}
                        <input type="hidden" name="parent_guardian_id" value="{{ $parent->id }}">
                        <input type="hidden" name="user_id" value="{{ $parent->user_id }}">
                        <input type="hidden" name="student_id" value="{{ $parent->student_id }}">

                        {{-- ================= Marital Status ================= --}}
                        <div class="new-request-form">
                            <h3>Marital Status</h3>
                            <div class="input-grp w-50">
                                <label for="marital_status">Marital Status <span class="text-danger">*</span></label>
                                <select id="marital_status" name="marital_status" >
                                    <option value="">Select</option>
                                    <option value="married" {{ old('marital_status', $parent->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="unmarried" {{ old('marital_status', $parent->marital_status) == 'unmarried' ? 'selected' : '' }}>Un-Married</option>
                                    <option value="divorced" {{ old('marital_status', $parent->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widow" {{ old('marital_status', $parent->marital_status) == 'widow' ? 'selected' : '' }}>Widow</option>
                                </select>
                            </div>
                        </div>

                        {{-- ================= Parent Details ================= --}}
                        <div class="new-request-form">
                            <h3>Parent Details</h3>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="father_title">Father Title</label>
                                    <input id="father_title" name="father_title" type="text" value="{{ old('father_title', $parent->father_title) }}" placeholder="e.g. Mr.">
                                </div>
                                <div class="input-grp">
                                    <label for="father_name">Father Name <span class="text-danger">*</span></label>
                                    <input id="father_name" name="father_name" type="text" value="{{ old('father_name', $parent->father_name) }}" >
                                </div>
                                <div class="input-grp">
                                    <label for="mother_title">Mother Title</label>
                                    <input id="mother_title" name="mother_title" type="text" value="{{ old('mother_title', $parent->mother_title) }}" placeholder="e.g. Mrs.">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="mother_name">Mother Name <span class="text-danger">*</span></label>
                                    <input id="mother_name" name="mother_name" type="text" value="{{ old('mother_name', $parent->mother_name) }}" >
                                </div>
                                <div class="input-grp">
                                    <label for="father_hebrew_name">Father Hebrew Name</label>
                                    <input id="father_hebrew_name" name="father_hebrew_name" type="text" value="{{ old('father_hebrew_name', $parent->father_hebrew_name) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_hebrew_name">Mother Hebrew Name</label>
                                    <input id="mother_hebrew_name" name="mother_hebrew_name" type="text" value="{{ old('mother_hebrew_name', $parent->mother_hebrew_name) }}">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="maiden_name">Maiden Name</label>
                                    <input id="maiden_name" name="maiden_name" type="text" value="{{ old('maiden_name', $parent->maiden_name) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="father_dob">Father Date of Birth</label>
                                    <input id="father_dob" name="father_dob" type="date" value="{{ old('father_dob', $parent->father_dob) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_dob">Mother Date of Birth</label>
                                    <input id="mother_dob" name="mother_dob" type="date" value="{{ old('mother_dob', $parent->mother_dob) }}">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="father_phone">Father Phone</label>
                                    <input id="father_phone" name="father_phone" type="text" value="{{ old('father_phone', $parent->father_mobile) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_phone">Mother Phone</label>
                                    <input id="mother_phone" name="mother_phone" type="text" value="{{ old('mother_phone', $parent->mother_mobile) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_phone">Additional Phone</label>
                                    <input id="additional_phone" name="additional_phone" type="text" value="{{ old('additional_phone', $parent->additional_mobile_numbers) }}">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="father_email">Father Email</label>
                                    <input id="father_email" name="father_email" type="email" value="{{ old('father_email', $parent->father_email) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_email">Mother Email</label>
                                    <input id="mother_email" name="mother_email" type="email" value="{{ old('mother_email', $parent->mother_email) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_email">Additional Email</label>
                                    <input id="additional_email" name="additional_email" type="email" value="{{ old('additional_email', $parent->additional_emails) }}">
                                </div>
                            </div>

                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="father_occupation">Father Occupation</label>
                                    <input id="father_occupation" name="father_occupation" type="text" value="{{ old('father_occupation', $parent->father_profession) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_occupation">Mother Occupation</label>
                                    <input id="mother_occupation" name="mother_occupation" type="text" value="{{ old('mother_occupation', $parent->mother_profession) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Address Details --}}
                        <div class="new-request-form">
                            <h3>Address Details</h3>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="address_line">Address Line <span class="text-danger">*</span></label>
                                    <input id="address_line" name="address_line" type="text" value="{{ old('address_line', $parent->address_line) }}" >
                                </div>
                                <div class="input-grp">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <input id="city" name="city" type="text" value="{{ old('city', $parent->city) }}" >
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="state">State / Province</label>
                                    <input id="state" name="state" type="text" value="{{ old('state', $parent->state) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="zip_code">Zip / Postal Code</label>
                                    <input id="zip_code" name="zip_code" type="text" value="{{ old('zip_code', $parent->zip_code) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <input id="country" name="country" type="text" value="{{ old('country', $parent->country) }}" >
                                </div>
                            </div>
                        </div>

                        {{-- Relative Details --}}
                        <div class="new-request-form">
                            <h3>Relative Details</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="relative_name">Name</label>
                                    <input id="relative_name" name="relative_name" type="text" value="{{ old('relative_name', $parent->guardian_name) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_relationship">Relationship</label>
                                    <input id="relative_relationship" name="relative_relationship" type="text" value="{{ old('relative_relationship', $parent->guardian_relation) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_home_phone">Home Phone</label>
                                    <input id="relative_home_phone" name="relative_home_phone" type="text" value="{{ old('relative_home_phone', $parent->guardian_home_phone) }}">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="relative_cell_phone">Cell Phone</label>
                                    <input id="relative_cell_phone" name="relative_cell_phone" type="text" value="{{ old('relative_cell_phone', $parent->guardian_mobile) }}">
                                </div>
                                <div class="input-grp">
                                    <label for="relative_email">Email</label>
                                    <input id="relative_email" name="relative_email" type="email" value="{{ old('relative_email', $parent->guardian_email) }}">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp">
                                    <label for="relative_address">Address</label>
                                    <input id="relative_address" name="relative_address" type="text" value="{{ old('relative_address', $parent->guardian_address) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="input-grp">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    $('#parentForm').on('submit', function(e) {
        e.preventDefault();

        $('.input-grp').removeClass('error');
        $('.error-message').remove();

        let formData = new FormData(this);

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
                    alert('Something went wrong.');
                }
            }
        });
    });
});
</script>
@endpush