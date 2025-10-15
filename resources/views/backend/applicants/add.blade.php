@extends('backend.master')
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Applicant</h1>
            <ul>
                <li><a href="../dashboard">Dashboard</a> /</li>
                <li><a href="./dashboard">Application</a> /</li>
                <li><a href="./profile">Applicants List</a> /</li>
                <li><a href="./profile">Applicants Info</a> /</li>
                <li>Add Applicant</li>
            </ul>
        </div>
        <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp">
                <div class="request-leave-form spradmin">
                    <form action="{{ route('applicant.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                        @csrf
                        <div class="new-request-form">
                            <h3>Applicant Details</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                  <label for="id">ID</label>
                                  <input id="id" name="id" type="text" placeholder="id" required>
                                </div>
                                <div class="input-grp">
                                  <label for="last_name">Last Name</label>
                                  <input id="last_name" name="last_name" type="text" placeholder="Last Name" required>
                                </div>
                                <div class="input-grp">
                                  <label for="first_name">First Name</label>
                                  <input id="first_name" name="first_name" type="text" placeholder="First Name" required>
                                </div>
                                <div class="input-grp">
                                  <label for="high_school">High School</label>
                                  <input id="high_school" name="high_school" type="text" placeholder="High School" required>
                                </div>
                                <div class="input-grp">
                                  <label for="date_of_birth">Birth Date</label>
                                  <input id="date_of_birth" name="date_of_birth" type="date" placeholder="Birth Date" required>
                                </div>
                                <div class="input-grp">
                                  <label for="mobile">USA Cell</label>
                                  <input id="mobile" name="mobile" type="text" placeholder="USA Cell" required>
                                </div>
                                <div class="input-grp">
                                  <label for="email">Email</label>
                                  <input id="email" name="email" type="text" placeholder="Email" required>
                                </div>
                                <div class="input-grp">
                                  <label for="high_school_application">High School(Application)</label>
                                  <input id="high_school_application" name="high_school_application" type="text" placeholder="High School(Application)" required>
                                </div>
                            </div>
                        </div>
                        <div class="new-request-form">
                            <h3>Camp (S) Attended</h3>
                            <button type="button" class="cmn-btn btn-sm" id="add-camp-btn"><img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"> Add</button>
                            <div class="added-camp-main" id="camp-main-container">
                            </div>
                        </div>

                        <div class="new-request-form">
                            <h3>Applicant Check List</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                  <label for="fee">Fee</label>
                                  <input id="fee" name="fee" type="text" placeholder="$1200.00" required>
                                </div>
                                <div class="input-grp">
                                  <label for="cc_last_4">CC Last 4</label>
                                  <input id="cc_last_4" name="cc_last_4" type="text" placeholder="CC Last 4" required>
                                </div>
                                <div class="input-grp">
                                  <label for="date_deposited">Date Deposited</label>
                                  <input id="date_deposited" name="date_deposited" type="date" placeholder="Date Deposited" required>
                                </div>
                                <div class="input-grp">
                                  <label for="references">References</label>
                                  <input id="references" name="references" type="text" placeholder="References" required>
                                </div>
                                <div class="input-grp">
                                  <label for="pictures">Pictures</label>
                                  <input id="pictures" name="pictures" type="text" placeholder="Pictures" required>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp checkbox d-flex justify-content-between">
                                  <label>Hold Hebrew <input id="hold_hebrew" name="hold_hebrew" value="1" type="checkbox"> </label>
                                  <label>Hold English<input id="hold_english" name="hold_english" value="1" type="checkbox"> </label>
                                </div>
                            </div>
                        </div>

                        <div class="new-request-form">
                            <h3>Application Processing</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                  <label for="interview_date">Interview Date</label>
                                  <input id="interview_date" name="interview_date" type="date" required>
                                </div>
                                <div class="input-grp">
                                  <label for="interview_time">Interview Time</label>
                                  <input id="interview_time" name="interview_time" type="time" placeholder="Interview Time" required>
                                </div>
                                <div class="input-grp">
                                  <label for="interview_location">Interview Location</label>
                                  <input id="interview_location" name="interview_location" type="text" placeholder="Interview Location" required>
                                </div>
                                <div class="input-grp">
                                  <label for="status">Status</label>
                                  <input id="status" name="status" type="text" placeholder="Status" required>
                                </div>
                                <div class="input-grp">
                                  <label for="coming">Coming</label>
                                  <input id="coming" name="coming" type="text" placeholder="Coming" required>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp w-100">
                                    <label for="application_comment">Application Comment</label>
                                    <textarea id="application_comment" name="application_comment" placeholder="Application Comment"></textarea>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp w-100">
                                    <label for="scholarship_comment">Scholarship Comment</label>
                                    <textarea id="scholarship_comment" name="scholarship_comment" placeholder="Scholarship Comment"></textarea>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp w-100">
                                    <label for="tution_comment">Tution Comment</label>
                                    <textarea id="tution_comment" name="tution_comment" placeholder="Tution Comment"></textarea>
                                </div>
                            </div>
                            <div class="multi-input-grp grp-1">
                                <div class="input-grp checkbox">
                                  <label>Letter Sent<input id="letter_sent" name="letter_sent" value="1" type="checkbox"> </label>
                                </div>
                            </div>
                        </div>

                        <div class="new-request-form">
                            <h3 id="parent-details-heading">Parents Information</h3>
                            <div class="multi-input-grp grp-3">
                                <div class="input-grp">
                                    <label for="parent_id">ID</label>
                                    <input id="parent_id" name="parent_id" type="text" placeholder="id">
                                </div>
                                <div class="input-grp">
                                    <label for="father_last_name">Last Name</label>
                                    <input id="father_last_name" name="father_last_name" type="text" placeholder="Last Name">
                                </div>
                                <div class="input-grp">
                                    <label for="father_title">Father Title</label>
                                    <input id="father_title" name="father_title" type="text" placeholder="Father Title">
                                </div>
                                <div class="input-grp">
                                    <label for="father_name">Father Name</label>
                                    <input id="father_name" name="father_name" type="text" placeholder="Father Name">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_title">Mother Title</label>
                                    <input id="mother_title" name="mother_title" type="text" placeholder="Mother Title">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_name">Mother Name</label>
                                    <input id="mother_name" name="mother_name" type="text" placeholder="Mother Name">
                                </div>
                                <div class="input-grp">
                                    <label for="maiden_name">Maiden Name</label>
                                    <input id="maiden_name" name="maiden_name" type="text" placeholder="Maiden Name">
                                </div>
                                <div class="input-grp">
                                    <label for="guardian_address">Address</label>
                                    <input id="guardian_address" name="guardian_address" type="text" placeholder="Address">
                                </div>
                                <div class="input-grp">
                                    <label for="guardian_city">City</label>
                                    <input id="guardian_city" name="guardian_city" type="text" placeholder="City">
                                </div>
                                <div class="input-grp">
                                  <label for="state">State</label>
                                  <select id="state" name="state" required>
                                    <option value="" disabled selected>State Name</option>
                                    <option value="state-1">State 1</option>
                                    <option value="state-2">State 2</option>
                                  </select>
                                </div>
                                <div class="input-grp">
                                  <label for="zip_code">Zip Code</label>
                                  <input id="zip_code" name="zip_code" type="text" inputmode="numeric" placeholder="Zip Code" required>
                                </div>
                                <div class="input-grp">
                                    <label for="country">Country</label>
                                    <select id="country" name="country" required>
                                      <option value="" disabled selected>Country</option>
                                      <option value="country-1">Country 1</option>
                                      <option value="country-2">Country 2</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label for="marital_status">Marital Status</label>
                                    <select id="marital_status" name="marital_status" required>
                                        <option value="" disabled selected>Marital Status</option>
                                        <option value="married">Married</option>
                                        <option value="single">Single</option>
                                    </select>
                                </div>
                                <div class="input-grp">
                                  <label for="marital_comment">Marital Comment</label>
                                  <input id="marital_comment" name="marital_comment" type="text" placeholder="Marital Comment" required>
                                </div>
                                <div class="input-grp">
                                  <label for="home_phone">Home Phone</label>
                                  <input id="home_phone" name="home_phone" type="text" placeholder="Home Phone" required>
                                </div>
                                <div class="input-grp">
                                    <label for="father_cell">Father Cell</label>
                                    <input id="father_cell" name="father_cell" type="tel" inputmode="tel" placeholder="Father Cell">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_cell">Mother Cell</label>
                                    <input id="mother_cell" name="mother_cell" type="tel" inputmode="tel" placeholder="Mother Cell">
                                </div>
                                <div class="input-grp">
                                    <label for="father_email">Father Email</label>
                                    <input id="father_email" name="father_email" type="email" placeholder="Father Email">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_email">Mother Email</label>
                                    <input id="mother_email" name="mother_email" type="email" placeholder="Mother Email">
                                </div>
                                <div class="input-grp">
                                    <label for="father_profession">Father Occupation</label>
                                    <input id="father_profession" name="father_profession" type="text" placeholder="Father Occupation">
                                </div>
                                <div class="input-grp">
                                    <label for="mother_profession">Mother Occupation</label>
                                    <input id="mother_profession" name="mother_profession" type="text" placeholder="Mother Occupation">
                                </div>
                            </div>
                            <div class="multi-input-grp grp-2">
                                <div class="input-grp">
                                    <label for="additional_mobile_numbers">Additional Phone No.</label>
                                    <input id="additional_mobile_numbers" name="additional_mobile_numbers" type="text" placeholder="23489632, 1641556456">
                                </div>
                                <div class="input-grp">
                                    <label for="additional_emails">Additional Email Addresses</label>
                                    <input id="additional_emails" name="additional_emails" type="text" placeholder="carolinethomas36@gmail.com, olivierthomas55@gmail.com">
                                </div>
                            </div>
                        </div>
                        <div class="form-submission btn-sm align-right">
                            <input type="submit" value="Save Student">
                        </div>
                    </form>
                    <form>
                    </form>
                    <div id="camp-template" style="display: none;">
                      <div class="added-element-card">
                        <span class="sl-count"></span>
                        <div class="multi-input-grp">
                            <div class="input-grp">
                                <input type="text" name="camps[]" placeholder="Camp">
                            </div>
                            <div class="input-grp">
                                <input type="text" name="positions[]" placeholder="Position">
                            </div>
                        </div>
                        <div class="added-elm-actions btn-grp">
                            {{-- <button type="submit" class="cmn-btn btn-sm"><img src="{{ asset('backend') }}/assets/images/new_images/edit-icon.svg" alt="Icon"> Edit</button> --}}
                            <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Dashboard Body -->
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            let count = 0;
            $('#add-camp-btn').on('click', function () {
                count++;
                let $clone = $('#camp-template .added-element-card').clone();
                $clone.find('.sl-count').text(count + '.');
                $('#camp-main-container').append($clone);
            });
            $('#camp-main-container').on('click', '.delete-btn', function () {
                $(this).closest('.added-element-card').remove();
                updateSerialNumbers();
            });
            function updateSerialNumbers() {
                $('#camp-main-container .added-element-card').each(function (index) {
                    $(this).find('.sl-count').text((index + 1) + '.');
                });
                count = $('#camp-main-container .added-element-card').length;
            }
        });
    </script>
@endpush