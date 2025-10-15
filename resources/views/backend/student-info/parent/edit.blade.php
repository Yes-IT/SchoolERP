@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
          <h1>Parents Info</h1>
          <ul>
              <li><a href="../dashboard.html">Dashboard</a> /</li>
              <li><a href="./dashboard.html">Parents</a> /</li>
              <li><a href="./profile.html">Parents Info</a> /</li>
              <li>Edit Parents Info</li>
          </ul>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="request-leave-form spradmin">
                    <form action="{{ route('parent.update', ['id' => $data['student_data']->id]) }}" enctype="multipart/form-data" method="post" id="visitForm">
                        @csrf
                        @method('PUT')
                        <div class="new-request-form">
                            <h3>Marital Status</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="marital_status">Marital Status</label>
                                    <select id="marital_status" name="marital_status" disabled>
                                        <option value="" disabled {{ old('marital_status', @$data['student_data']->marital_status) ? '' : 'selected' }}>Marital Status</option>
                                        <option value="married" {{ old('marital_status', @$data['student_data']->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="single" {{ old('marital_status', @$data['student_data']->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="new-request-form">
                            <h3>Parent Details</h3>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="father_title">Father Title</label>
                                <input id="father_title" value="{{ old('father_title', @$data['student_data']->parent->father_title) }}" name="father_title" type="text" placeholder="Father Title" required>
                              </div>
                              <div class="input-grp">
                                <label for="father_name">Father Name</label>
                                <input id="father_name" value="{{ old('father_name', @$data['student_data']->parent->father_name) }}" name="father_name" type="text" placeholder="Father Name" required>
                              </div>
                              <div class="input-grp">
                                <label for="mother_title">Mother Title</label>
                                <input id="mother_title" value="{{ old('mother_title', @$data['student_data']->parent->mother_title) }}" name="mother_title" type="text" placeholder="Mother Title">
                              </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="mother_name">Mother Name</label>
                                <input id="mother_name" value="{{ old('mother_name', @$data['student_data']->parent->mother_name) }}" name="mother_name" type="text" placeholder="Mother Name">
                              </div>
                              <div class="input-grp">
                                <label for="father_hebrew_name">Father Hebrew Name</label>
                                <input id="father_hebrew_name" value="{{ old('father_hebrew_name', @$data['student_data']->parent->father_hebrew_name) }}" name="father_hebrew_name" type="text" placeholder="Father Hebrew Name">
                              </div>
                              <div class="input-grp">
                                <label for="mother_hebrew_name">Mother Hebrew Name</label>
                                <input id="mother_hebrew_name" value="{{ old('mother_hebrew_name', @$data['student_data']->parent->mother_hebrew_name) }}" name="mother_hebrew_name" type="text" placeholder="Mother Hebrew Name" required>
                              </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="maiden_name">Maiden Name</label>
                                <input id="maiden_name" value="{{ old('maiden_name', @$data['student_data']->parent->maiden_name) }}" name="maiden_name" type="text" placeholder="Maiden Name">
                              </div>
                              <div class="input-grp">
                                <label for="father_dob">Father Birth Date</label>
                                  <input id="father_dob" value="{{ old('father_dob', @$data['student_data']->parent->father_dob) }}" name="father_dob" type="date" placeholder="Father Birth Date">
                              </div>
                              <div class="input-grp">
                                <label for="mother_dob">Mother Birth Date</label>
                                <input id="mother_dob" value="{{ old('mother_dob', @$data['student_data']->parent->mother_dob) }}" name="mother_dob" type="date" placeholder="Mother Birth Date">
                              </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="father_mobile">Father Phone Number</label>
                                <input id="father_mobile" value="{{ old('father_mobile', @$data['student_data']->parent->father_mobile) }}" name="father_mobile" type="text" placeholder="Father Phone Number">
                              </div>
                              <div class="input-grp">
                                <label for="mother_mobile">Mother Phone Number</label>
                                <input id="mother_mobile" value="{{ old('mother_mobile', @$data['student_data']->parent->mother_mobile) }}" name="mother_mobile" type="text" placeholder="Mother Phone Number">
                              </div>
                              <div class="input-grp">
                                <label for="additional_mobile_numbers">Additional Phone Number</label>
                                <input id="additional_mobile_numbers" value="{{ old('additional_mobile_numbers', @$data['student_data']->parent->additional_mobile_numbers) }}" name="additional_mobile_numbers" type="text" placeholder="Additional Phone Number">
                              </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="father_email">Father Email</label>
                                <input id="father_email" value="{{ old('father_email', @$data['student_data']->parent->father_email) }}" name="father_email" type="email" placeholder="Father Email">
                              </div>
                              <div class="input-grp">
                                <label for="mother_email">Mother Email</label>
                                <input id="mother_email" value="{{ old('mother_email', @$data['student_data']->parent->mother_email) }}" name="mother_email" type="email" placeholder="Mother Email">
                              </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="additional_emails">Additional Email Address</label>
                                    <input id="additional_emails" value="{{ old('additional_emails', @$data['student_data']->parent->additional_emails) }}" name="additional_emails" type="text" placeholder="Additional Email Address">
                                </div>
                                <div class="input-grp">
                                    <label for="father_profession">Father Occupation</label>
                                    <input id="father_profession" value="{{ old('father_profession', @$data['student_data']->parent->father_profession) }}" name="father_profession" type="text" placeholder="Father Occupation" required>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="mother_profession">Mother Occupation</label>
                                    <input id="mother_profession" value="{{ old('mother_profession', @$data['student_data']->parent->mother_profession) }}" name="mother_profession" type="text" placeholder="Mother Occupation">
                                </div>
                                {{-- <div class="input-grp">
                                    <label for="guardian_address">Parents Address</label>
                                    <input id="guardian_address" name="guardian_address" type="text" placeholder="Parents Address">
                                </div> --}}
                            </div>
                            <div class="input-grp checkbox">
                                <label>Hold Transcript <input id="hold_transcript" name="hold_transcript" type="checkbox"> </label>
                            </div>
                        </div>
                        <div class="new-request-form">
                            <h3>Address Details</h3>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="residance_address">Address</label>
                                <input id="residance_address" value="{{ old('residance_address', @$data['student_data']->residance_address) }}" name="residance_address" type="text" placeholder="Address" readonly>
                              </div>
                              <div class="input-grp">
                                <label for="city">City</label>
                                <input id="city" value="{{ old('city', @$data['student_data']->city) }}" name="city" type="text" placeholder="City" readonly>
                              </div>
                              <div class="input-grp">
                                <label for="state">State</label>
                                <input id="state" value="{{ old('state', @$data['student_data']->state) }}" name="state" type="text" placeholder="State" readonly>
                              </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="zip_code">Zipcode</label>
                                <input id="zip_code" value="{{ old('zip_code', @$data['student_data']->zip_code) }}" name="zip_code" type="text" placeholder="Zipcode" readonly>
                              </div>
                              <div class="input-grp">
                                <label for="country">Country</label>
                                <input id="country" value="{{ old('country', @$data['student_data']->country) }}" name="country" type="text" placeholder="Country" readonly>
                              </div>
                            </div>
                        </div>
                        <div class="new-request-form">
                            <h3>Daughter Info</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="student_id">Student Name</label>
                                    <select id="student_id" name="student_id" required>
                                        <option value="">-- Select Student --</option>
                                        @foreach($data['students'] as $student)
                                            <option value="{{ $student['id'] }}"
                                                {{ old('student_id', @$data['student_data']->id) == $student['id'] ? 'selected' : '' }}>
                                                {{ $student['first_name'] }} {{ $student['last_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                  <label for="school_year">School Year</label>
                                  <input id="school_year" name="school_year" type="text" placeholder="School Year" readonly>
                                </div>
                                <div class="input-grp">
                                  <label for="year_status">Year Status</label>
                                  <input id="year_status" name="year_status" type="text" placeholder="Year Status" readonly>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="dob">Birthdate</label>
                                <input id="dob" value="{{ old('dob', @$data['student_data']->dob) }}" name="dob" type="text" placeholder="Birthdate" readonly>
                              </div>
                            </div>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                              name="status" id="validationServer04"
                              aria-describedby="validationServer04Feedback" hidden>
                                <option value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                <option value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}</option>
                            </select>
                        </div>

                        <div class="new-request-form">
                            <h3>Relative Details</h3>          
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                  <label for="guardian_name"> Name</label>
                                  <input id="guardian_name" value="{{ old('guardian_name', @$data['student_data']->parent->guardian_name) }}" name="guardian_name" type="text" placeholder="Name" required>
                                </div>
                                <div class="input-grp">
                                  <label for="guardian_relation">Relationship</label>
                                  <input id="guardian_relation" value="{{ old('guardian_relation', @$data['student_data']->parent->guardian_relation) }}" name="guardian_relation" type="text" placeholder="Relationship" required>
                                </div>
                                <div class="input-grp">
                                  <label for="guardian_home_phone">Home Phone</label>
                                  <input id="guardian_home_phone" value="{{ old('guardian_home_phone', @$data['student_data']->parent->guardian_home_phone) }}" name="guardian_home_phone" type="text" placeholder="Home Phone">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                              <div class="input-grp">
                                <label for="guardian_mobile"> Cell Phone</label>
                                <input id="guardian_mobile" value="{{ old('guardian_mobile', @$data['student_data']->parent->guardian_mobile) }}" name="guardian_mobile" type="text" placeholder="Cell Phone" required>
                              </div>
                              <div class="input-grp">
                                <label for="guardian_email">Email</label>
                                <input id="guardian_email" value="{{ old('guardian_email', @$data['student_data']->parent->guardian_email) }}" name="guardian_email" type="text" placeholder="Email" required>
                              </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                              <div class="input-grp">
                                <label for="hebrew_last_name"> Phone</label>
                                <input id="mother_name" name="mother_name" type="text" placeholder="Phone">
                              </div>
                            </div>
                        </div>
                        <div class="form-submission btn-sm align-right">
                          <input type="hidden" name="password"
                                placeholder="{{ ___('frontend.Password') }}" autocomplete="off"
                                class="form-control ot-form-control ot-input" value="{{ old('password') }}"
                                id="password">
                          <input type="submit" value="Save Parent">
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
            var fileInp1 = document.getElementById("fileBrouse1");
            if (fileInp1) {
                fileInp1.addEventListener("change", showFileName);
                function showFileName(event) {
                    var fileInp = event.srcElement;
                    var fileName = fileInp.files[0].name;
                    document.getElementById("placeholder1").placeholder = fileName;
                }
            }
            function checkCheckboxState() {
                var isChecked = $('#previous_school').prop('checked');
                if (isChecked) {
                    $('#previous_school_info').removeClass('d-none');
                    $('#previous_school_doc').removeClass('d-none');
                } else {
                    $('#previous_school_info').addClass('d-none');
                    $('#previous_school_doc').addClass('d-none');
                }
            }
            $('#previous_school').change(checkCheckboxState);
            checkCheckboxState();
            $('#SelectionDiv').hide();
            $('input[name="password_type"]').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#SelectionDiv').show();
                } else {
                    $('#SelectionDiv').hide();
                }
            });

            document.getElementById('student_id').addEventListener('change', function () {
              let studentId = this.value;
              if(studentId){
                  window.location.href = "{{ url('parent/edit') }}/" + studentId;
              }
            });
        });
    </script>
@endpush
