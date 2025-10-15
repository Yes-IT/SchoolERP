@extends('backend.master')

@section('title')
{{ @$data['title'] }}
@endsection
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li> {{-- each validation error --}}
    @endforeach
  </ul>
</div>
@endif
<div class="dashboard-body dspr-body-outer">
  <!-- <div class="dashboard-body-head">
    <div class="dsbdy-head-left">
      <div class="dsbdy-search-form">
        <div class="input-grp search-field">
          <input type="text" placeholder="Search Page">
          <input type="submit" value="Search">
        </div>
      </div>
    </div>
    <div class="dsbdy-head-right">
      <button class="tgl-flscrn" aria-label="Toggle fullscreen">
        <img src="{{ asset('backend') }}/assets/images/new_images/fullscreen-toggler-icon.svg" onclick="javascript:toggleFullScreen()" alt="Icon">
      </button>
      <div class="profile-ctrl">
        <button class="profile-ctrl-toggler">
          <div class="pr-pic">
            <img src="{{ asset('backend') }}/assets/images/new_images/profile-picture.png" alt="Profile Picture">
          </div>
          <i class="fa-solid fa-chevron-down"></i>
        </button>
        <div class="pr-ctrl-menu">
          <ul>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="../../set-password.html">Change Password</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div> -->
  <!-- Dashboard Body Begin -->
  <div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
      <h1>Edit Students</h1>
      <ul>
        <li><a href="../dashboard">Dashboard</a> /</li>
        <li><a href="./dashboard">Students</a> /</li>
        <li><a href="./profile">Students Info</a> /</li>
        <li>Edit Student</li>
      </ul>
    </div>
    <div class="ds-pr-body">
      <div class="ds-cmn-table-wrp">
        <div class="request-leave-form spradmin">
          <form action="{{ route('student.update', $data['student']->id) }}" method="post" enctype="multipart/form-data" id="visitForm">
            @csrf
            @method('PUT')
            <div class="new-request-form">
              <h3>Student Details</h3>
              <!-- <div class="input-grp h48">
                <label>Image Link</label>
                <div class="floating-input-btn input-grp w-70">
                  <div class="has-submit">
                    <label class="file-label">
                      <span class="file-text">No file chosen</span>
                      <input type="file" id="fileUpload" name="image" />
                    </label>
                    <input type="button" id="uploadBtn" value="Upload" class="btn-upload" />
                  </div>
                </div>
              </div> -->
              <div class="input-grp h48">
                <label>Image Link</label>
                <div class="floating-input-btn input-grp w-70">
                  <div class="has-submit">
                    <label class="file-label">
                      @php
                      $imageLink = $data['student']->imageUpload ? asset($data['student']->imageUpload->path) : null;
                      @endphp
                      <span class="file-text">
                        {{ $imageLink ? $imageLink : 'No file chosen' }}
                      </span>
                      <input type="file" id="fileUpload" name="image" />
                    </label>
                    <input type="button" id="uploadBtn" value="Upload" style="width: 10%; height: 40px; " class="btn-upload" />
                  </div>
                </div>
              </div>

              <!-- @if($imageLink)
              <div class="current-image">
                <a href="{{ $imageLink }}" target="_blank">View Current Image</a>
              </div>
              @endif -->

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="first_name">First Name</label>
                  <input id="first_name" name="first_name" type="text" value="{{ ( $data['student']->first_name) }}" placeholder="First Name" required>
                </div>
                <div class="input-grp">
                  <label for="last_name">Last Name</label>
                  <input id="last_name" name="last_name" type="text" value="{{ ( $data['student']->last_name) }}" placeholder="Last Name" required>
                </div>
                <div class="input-grp">
                  <label for="hebrew_last_name">Hebrew Last Name</label>
                  <input id="hebrew_last_name" name="hebrew_last_name" type="text" value="{{ ( $data['student']->hebrew_last_name) }}" placeholder="Hebrew Last Name">
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="hebrew_first_name">Hebrew First Name</label>
                  <input id="hebrew_first_name" name="hebrew_first_name" type="text" value="{{ ( $data['student']->hebrew_first_name) }}" placeholder="Hebrew First Name">
                  {{-- test code --}}
                  <input id="status" name="status" type="hidden" value="1" type="text">
                  {{-- test code end --}}
                </div>
                <div class="input-grp">
                  <label for="diploma_name">Diploma Name</label>
                  <input id="diploma_name" name="diploma_name" type="text" value="{{ ( $data['student']->diploma_name) }}" placeholder="Diploma Name">
                </div>
                <div class="input-grp">
                  <label for="birth_date">Birth Date</label>
                  <input id="birth_date" name="date_of_birth" type="date" value="{{ ( $data['student']->dob) }}" placeholder="Birth Date" required>
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="hebrew_dob">Hebrew Birthday</label>
                  <input id="hebrew_dob" name="hebrew_dob" type="date" value="{{ ( $data['student']->hebrew_dob) }}" placeholder="Hebrew Birthday">
                </div>
                <!-- <div class="input-grp">
                  <label for="place_of_birth">Birth Country</label>
                  <select id="place_of_birth" name="place_of_birth" required>
                    <option value="">Birth Country</option>
                    <option>India</option>
                    <option>Israel</option>
                    <option>United States</option>
                    <option>Other</option>
                  </select>
                </div> -->

                <div class="input-grp">
                  <label for="place_of_birth">Birth Country</label>
                  <select id="place_of_birth" name="place_of_birth" required>
                    <option value="">Birth Country</option>
                    <option value="India" {{ $data['student']->place_of_birth == 'India' ? 'selected' : '' }}>India</option>
                    <option value="Israel" {{ $data['student']->place_of_birth == 'Israel' ? 'selected' : '' }}>Israel</option>
                    <option value="United States" {{ $data['student']->place_of_birth == 'United States' ? 'selected' : '' }}>United States</option>
                    <option value="Other" {{ $data['student']->place_of_birth == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>

                <div class="input-grp">
                  <label for="ssn">SSN</label>
                  <input id="ssn" name="ssn" type="text" value="{{ ( $data['student']->ssn) }}" placeholder="SSN">
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="passport_no">Passport No.</label>
                  <input id="passport_no" name="passport_no" value="{{ ( $data['student']->passport_no) }}" type="text" placeholder="Passport No.">
                </div>
                <div class="input-grp">
                  <label for="passport_name">Passport Name</label>
                  <input id="passport_name" name="passport_name" type="text" value="{{ ( $data['student']->passport_name) }}" placeholder="Passport Name">
                </div>
                <!-- <div class="input-grp">
                  <label for="passport_country">Passport Country</label>
                  <select id="passport_country" name="passport_country">
                    <option value="">Passport Country</option>
                    <option>India</option>
                    <option>Israel</option>
                    <option>United States</option>
                    <option>Other</option>
                  </select>
                </div> -->

                <div class="input-grp">
                  <label for="passport_country">Passport Country</label>
                  <select id="passport_country" name="passport_country">
                    <option value="">Passport Country</option>
                    <option value="India" {{ $data['student']->passport_country == 'India' ? 'selected' : '' }}>India</option>
                    <option value="Israel" {{ $data['student']->passport_country == 'Israel' ? 'selected' : '' }}>Israel</option>
                    <option value="United States" {{ $data['student']->passport_country == 'United States' ? 'selected' : '' }}>United States</option>
                    <option value="Other" {{ $data['student']->passport_country == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>


              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="passport_exp_date">Passport Exp. Date</label>
                  <input id="passport_exp_date" name="passport_exp_date" type="date" value="{{ ( $data['student']->passport_exp_date) }}" placeholder="Passport Exp. Date">
                </div>
                <div class="input-grp">
                  <label for="teudat_zehut">Teudat Zehut</label>
                  <input id="teudat_zehut" name="teudat_zehut" type="text" value="{{ ( $data['student']->teudat_zehut) }}" placeholder="Teudat Zehut">
                </div>
                <div class="input-grp">
                  <label for="insurance">Insurance</label>
                  <input id="insurance" name="insurance" type="text" value="{{ ( $data['student']->insurance) }}" placeholder="Insurance">
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <!-- <div class="input-grp">
                  <label for="insurance_type">Insurance Type</label>
                  <select id="insurance_type" name="insurance_type">
                    <option value="">Insurance Type</option>
                    <option>Private</option>
                    <option>Government</option>
                    <option>None</option>
                  </select>
                </div> -->

                <div class="input-grp">
                  <label for="insurance_type">Insurance Type</label>
                  <select id="insurance_type" name="insurance_type">
                    <option value="">Insurance Type</option>
                    <option value="Private" {{ $data['student']->insurance_type == 'Private' ? 'selected' : '' }}>Private</option>
                    <option value="Government" {{ $data['student']->insurance_type == 'Government' ? 'selected' : '' }}>Government</option>
                    <option value="None" {{ $data['student']->insurance_type == 'None' ? 'selected' : '' }}>None</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="email">Email Address</label>
                  <input id="email" name="email" type="email" value="{{ ( $data['student']->email) }}" placeholder="Email Address" required>
                </div>
                <div class="input-grp">
                  <label for="cell_israel">Cell Israel</label>
                  <input id="cell_israel" name="cell_israel" type="tel" value="{{ ( $data['student']->cell_israel) }}" placeholder="Cell Israel">
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="cell_usa">Cell USA</label>
                  <input id="cell_usa" name="cell_usa" type="tel" value="{{ ( $data['student']->cell_usa) }}" placeholder="Cell USA">
                </div>
                <div class="input-grp">
                  <label for="mobile">Home Phone</label>
                  <input id="mobile" name="mobile" type="tel" value="{{ ( $data['student']->mobile) }}" placeholder="Home Phone">
                </div>
                <!-- <div class="input-grp">
                  <label for="high_school">High School</label>
                  <select id="high_school" name="high_school">
                    <option value="">High School</option>
                    <option value="a">School A</option>
                    <option value="b">School B</option>
                    <option value="other">Other</option>
                  </select>
                </div> -->

                <div class="input-grp">
                  <label for="high_school">High School</label>
                  <select id="high_school" name="high_school">
                    <option value="">High School</option>
                    <option value="a" {{ $data['student']->high_school == 'a' ? 'selected' : '' }}>School A</option>
                    <option value="b" {{ $data['student']->high_school == 'b' ? 'selected' : '' }}>School B</option>
                    <option value="other" {{ $data['student']->high_school == 'other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>

              </div>
              <div class="input-grp checkbox">
                <label>Hold Transcript <input id="hold_transcript" name="hold_transcript" type="checkbox"> </label>
              </div>
            </div>
            <div class="new-request-form">
              <h3>Address Details</h3>
              <div class="multi-input-grp grp-2-1 grp-3">
                <div class="input-grp input-full">
                  <label for="address_line1">Address</label>
                  <input id="address_line1" name="residance_address" type="text" value="{{ ( $data['student']->residance_address) }}" placeholder="Address" required>
                </div>
                <div class="input-grp">
                  <label for="city">City</label>
                  <input id="city" name="city" type="text" value="{{ ( $data['student']->city) }}" placeholder="City Name" required>
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <!-- <div class="input-grp">
                  <label for="state">State</label>
                  <select id="state" name="state" required>
                    <option value="" disabled selected>State Name</option>
                    <option value="state-1">State 1</option>
                    <option value="state-2">State 2</option>
                  </select>
                </div> -->
                <div class="input-grp">
                  <label for="state">State</label>
                  <select id="state" name="state" required>
                    <option value="">State Name</option>
                    <option value="state-1" {{ $data['student']->state == 'state-1' ? 'selected' : '' }}>State 1</option>
                    <option value="state-2" {{ $data['student']->state == 'state-2' ? 'selected' : '' }}>State 2</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="zip_code">Zip Code</label>
                  <input id="zip_code" name="zip_code" type="text" value="{{ ( $data['student']->zip_code) }}" inputmode="numeric" placeholder="Zip Code" required>
                </div>
                <div class="input-grp">
                  <label for="country">Country</label>
                  <select id="country" name="country" required>
                    <option value="">Country</option>
                    <option value="country-1" {{ $data['student']->country == 'country-1' ? 'selected' : '' }}>Country 1</option>
                    <option value="country-2" {{ $data['student']->country == 'country-2' ? 'selected' : '' }}>Country 2</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="new-request-form">
              <h3>Marital Status</h3>
              <div class="multi-input-grp grp-3">
                <!-- <div class="input-grp">
                  <label for="marital_status">Marital Status</label>
                  <select id="marital_status" name="marital_status" required>
                    <option value="" disabled selected>Marital Status</option>
                    <option value="married">Married</option>
                    <option value="single">Single</option>
                  </select>
                </div> -->
                <div class="input-grp">
                  <label for="marital_status">Marital Status</label>
                  <select id="marital_status" name="marital_status" required>
                    <option value="">Marital Status</option>
                    <option value="married" {{ $data['student']->marital_status == 'married' ? 'selected' : '' }}>Married</option>
                    <option value="single" {{ $data['student']->marital_status == 'single' ? 'selected' : '' }}>Single</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="new-request-form">
              <h3 id="parent-details-heading">Parent Details</h3>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="father_name">Father Name</label>
                  <input id="father_name" name="father_name" type="text" value="{{ ( $data['student']->father_name) }}" placeholder="Father Name">
                </div>
                <div class="input-grp">
                  <label for="mother_name">Mother Name</label>
                  <input id="mother_name" name="mother_name" type="text" value="{{ ( $data['student']->mother_name) }}" placeholder="Mother Name">
                </div>
                <div class="input-grp">
                  <label for="father_hebrew_name">Father Hebrew Name</label>
                  <input id="father_hebrew_name" name="father_hebrew_name" type="text" value="{{ ( $data['student']->father_hebrew_name) }}" placeholder="Father Hebrew Name">
                </div>
                <div class="input-grp">
                  <label for="mother_hebrew_name">Mother Hebrew Name</label>
                  <input id="mother_hebrew_name" name="mother_hebrew_name" type="text" value="{{ ( $data['student']->mother_hebrew_name) }}" placeholder="Mother Hebrew Name">
                </div>
                <div class="input-grp">
                  <label for="maiden_name">Maiden Name</label>
                  <input id="maiden_name" name="maiden_name" type="text" value="{{ ( $data['student']->maiden_name) }}" placeholder="Maiden Name">
                </div>
                <div class="input-grp">
                  <label for="father_dob">Father Birth Date</label>
                  <input id="father_dob" name="father_dob" type="date" value="{{ ( $data['student']->father_dob) }}" placeholder="Father Birth Date">
                </div>
                <div class="input-grp">
                  <label for="mother_dob">Mother Birth Date</label>
                  <input id="mother_dob" name="mother_dob" type="date" value="{{ ( $data['student']->mother_dob) }}" placeholder="Mother Birth Date">
                </div>
                <div class="input-grp">
                  <label for="father_mobile">Father Phone Number</label>
                  <input id="father_mobile" name="father_mobile" type="tel" inputmode="tel" value="{{ ( $data['student']->father_mobile) }}" placeholder="Father Phone Number">
                </div>
                <div class="input-grp">
                  <label for="mother_mobile">Mother Phone Number</label>
                  <input id="mother_mobile" name="mother_mobile" type="tel" inputmode="tel" value="{{ ( $data['student']->mother_mobile) }}" placeholder="Mother Phone Number">
                </div>
                <div class="input-grp">
                  <label for="additional_mobile_numbers">Additional Phone Numbers</label>
                  <input id="additional_mobile_numbers" name="additional_mobile_numbers" type="text" value="{{ ( $data['student']->additional_mobile_numbers) }}" placeholder="23489632, 1641556456">
                </div>
                <div class="input-grp">
                  <label for="father_email">Father Email</label>
                  <input id="father_email" name="father_email" type="email" value="{{ ( $data['student']->father_email) }}" placeholder="Father Email">
                </div>
                <div class="input-grp">
                  <label for="mother_email">Mother Email</label>
                  <input id="mother_email" name="mother_email" type="email" value="{{ ( $data['student']->mother_email) }}" placeholder="Mother Email">
                </div>
              </div>
              <div class="multi-input-grp grp-1">
                <div class="input-grp">
                  <label for="additional_emails">Additional Email Addresses</label>
                  <input id="additional_emails" name="additional_emails" value="{{ ( $data['student']->additional_emails) }}" type="text"
                    placeholder="carolinethomas36@gmail.com, olivierthomas55@gmail.com">
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="father_profession">Father Occupation</label>
                  <input id="father_profession" name="father_profession" type="text" value="{{ ( $data['student']->father_profession) }}" placeholder="Father Occupation">
                </div>
                <div class="input-grp">
                  <label for="mother_profession">Mother Occupation</label>
                  <input id="mother_profession" name="mother_profession" type="text" value="{{ ( $data['student']->mother_profession) }}" placeholder="Mother Occupation">
                </div>
                <div class="input-grp">
                  <label for="guardian_address">Parents Address</label>
                  <input id="guardian_address" name="guardian_address" type="text" value="{{ ( $data['student']->guardian_address) }}" placeholder="Parents Address">
                </div>
              </div>
            </div>
            <div class="new-request-form">
              <h3>Relative Details</h3>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="guardian_name">Name</label>
                  <input id="guardian_name" name="guardian_name" type="text" value="{{ ( $data['student']->guardian_name) }}" placeholder="Name">
                </div>
                <div class="input-grp">
                  <label for="guardian_relation">Relationship</label>
                  <input id="guardian_relation" name="guardian_relation" type="text" value="{{ ( $data['student']->guardian_relation) }}" placeholder="Relationship">
                </div>
                <div class="input-grp">
                  <label for="guardian_home_phone">Home Phone</label>
                  <input id="guardian_home_phone" name="guardian_home_phone" type="text" value="{{ ( $data['student']->guardian_home_phone) }}" placeholder="Home Phone">
                </div>
                <div class="input-grp">
                  <label for="guardian_mobile">Cell Phone</label>
                  <input id="guardian_mobile" name="guardian_mobile" type="text" value="{{( $data['student']->guardian_mobile) }}" placeholder="Cell Phone">
                </div>
                <div class="input-grp">
                  <label for="guardian_email">Email</label>
                  <input id="guardian_email" name="guardian_email" type="text" value="{{ ( $data['student']->guardian_email) }}" placeholder="Email">
                </div>
              </div>
              <div class="multi-input-grp grp-1">
                <div class="input-grp">
                  <label for="guardian_address">Address</label>
                  <input id="guardian_address" name="guardian_address" type="text" value="{{(  $data['student']->guardian_address) }}" placeholder="Address">
                </div>
              </div>
            </div>
            <div class="new-request-form">
              <h3>School Year (s)</h3>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="school_id">ID</label>
                  <input id="school_id" name="school_id" type="text" value="{{ ( $data['student']->school_id) }}" placeholder="Name">
                </div>
                <div class="input-grp">
                  <label for="school_year">School Year</label>
                  <select id="school_year" name="school_yearsd">
                    <option value="">Select</option>
                    <option value="2015-2016" {{ $data['student']->school_year == '2015-2016' ? 'selected' : '' }}>2015-2016</option>
                    <option value="2016-2017" {{ $data['student']->school_year == '2016-2017' ? 'selected' : '' }}>2016-2017</option>
                    <option value="2017-2018" {{ $data['student']->school_year == '2017-2018' ? 'selected' : '' }}>2017-2018</option>
                    <option value="2018-2019" {{ $data['student']->school_year == '2018-2019' ? 'selected' : '' }}>2018-2019</option>
                    <option value="2019-2020" {{ $data['student']->school_year == '2019-2020' ? 'selected' : '' }}>2019-2020</option>
                    <option value="2021-2022" {{ $data['student']->school_year == '2021-2022' ? 'selected' : '' }}>2021-2022</option>
                    <option value="2022-2023" {{ $data['student']->school_year == '2022-2023' ? 'selected' : '' }}>2022-2023</option>
                    <option value="2023-2024" {{ $data['student']->school_year == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                    <option value="2024-2025" {{ $data['student']->school_year == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="year_status">Year Status</label>
                  <select id="year_status" name="year_statussd">
                    <option value="">Select</option>
                    <option value="active" {{ $data['student']->year_status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $data['student']->year_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="college">College</label>
                  <select id="college" name="college">
                    <option value="">Select</option>
                    <option value="1" {{ $data['student']->college == '1' ? 'selected' : '' }}>College 1</option>
                    <option value="2" {{ $data['student']->college == '2' ? 'selected' : '' }}>College 2</option>
                    <option value="3" {{ $data['student']->college == '3' ? 'selected' : '' }}>College 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="withdraw_date">Withdraw Date</label>
                  <input id="withdraw_date" name="withdraw_date" type="date" value="{{( $data['student']->withdraw_date) }}" placeholder="Withdraw Date">
                </div>
                <div class="input-grp">
                  <label for="homeroom_class">Homeroom Class</label>
                  <select id="homeroom_class" name="homeroom_class">
                    <option value="">Select</option>
                    <option value="1" {{ $data['student']->homeroom_class == '1' ? 'selected' : '' }}>Class 1</option>
                    <option value="2" {{ $data['student']->homeroom_class == '2' ? 'selected' : '' }}>Class 2</option>
                    <option value="3" {{ $data['student']->homeroom_class == '3' ? 'selected' : '' }}>Class 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="group">Group</label>
                  <select id="group" name="group">
                    <option value="">Select</option>
                    <option value="1" {{ $data['student']->group == '1' ? 'selected' : '' }}>Group 1</option>
                    <option value="2" {{ $data['student']->group == '2' ? 'selected' : '' }}>Group 2</option>
                    <option value="3" {{ $data['student']->group == '3' ? 'selected' : '' }}>Group 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="division">Division</label>
                  <select id="division" name="division">
                    <option value="">Select</option>
                    <option value="1" {{ $data['student']->division == '1' ? 'selected' : '' }}>Group 1</option>
                    <option value="2" {{ $data['student']->division == '2' ? 'selected' : '' }}>Group 2</option>
                    <option value="3" {{ $data['student']->division == '3' ? 'selected' : '' }}>Group 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="floor">Floor</label>
                  <input id="floor" name="floor" value="{{( $data['student']->floor) }}" type="text" placeholder="Floor">
                </div>
                <div class="input-grp">
                  <label for="room">Room</label>
                  <input id="room" name="room" type="text" value="{{( $data['student']->room) }}" placeholder="Room">
                </div>
              </div>
            </div>
            <div class="new-request-form">
              <h3>Classes</h3>
              <button type="button" class="cmn-btn btn-sm" id="add-class-btn">Add Classes <img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"></button>
              <div class="added-class-main" id="class-main-container">
                @foreach ($data['classMappings'] as $index => $classMap)
                <div class="added-element-card">
                  <span class="sl-count">{{ $loop->iteration }}.</span>
                  <div class="multi-input-grp">
                    <div class="input-grp">
                      <select name="class_id[]" required>
                        <option value="">Select Class</option>
                        @foreach ($data['classes'] as $class)
                        <option value="{{ $class->id }}" {{ $classMap->class_id == $class->id ? 'selected' : '' }}>
                          {{ $class->class->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="input-grp">
                      <select name="teacher_id[]" required>
                        <option value="">Select Teacher</option>
                        @foreach ($data['teachers'] as $teacher)
                        <option value="{{ $teacher->id }}" {{ $classMap->teacher_id == $teacher->id ? 'selected' : '' }}>
                          {{ $teacher->first_name }} {{ $teacher->last_name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="added-elm-actions btn-grp">
                    <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
                  </div>
                </div>
                @endforeach
              </div>

            </div>
            <div class="new-request-form">
              <h3>Request Transcript</h3>
              <button type="button" class="cmn-btn btn-sm" id="add-request-btn">Add Request <img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"></button>
              <div class="added-request-main" id="request-main-container">
                @foreach ($data['requestTranscripts'] as $index => $rt)
                <div class="added-element-card">
                  <span class="sl-count">{{ $loop->iteration }}.</span>
                  <div class="multi-input-grp grp-3">
                    <div class="input-grp">
                      <input type="date" name="request_date[]" value="{{ $rt->request_date }}" required>
                    </div>
                    <div class="input-grp">
                      <select name="request_destination[]" required>
                        <option value="">Destination</option>
                        <option value="1" {{ $rt->destination == 1 ? 'selected' : '' }}>Destination 1</option>
                        <option value="2" {{ $rt->destination == 2 ? 'selected' : '' }}>Destination 2</option>
                        <option value="3" {{ $rt->destination == 3 ? 'selected' : '' }}>Destination 3</option>
                      </select>
                    </div>
                    <div class="input-grp">
                      <select name="payment_status[]" required>
                        <option value="1" {{ $rt->type == 1 ? 'selected' : '' }}>Paid</option>
                        <option value="0" {{ $rt->type == 0 ? 'selected' : '' }}>Unpaid</option>
                      </select>
                    </div>
                  </div>
                  <div class="added-elm-actions btn-grp">
                    <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
                  </div>
                </div>
                @endforeach
              </div>

            </div>
            <div class="new-request-form">
              <h3>Form Checklist</h3>
              <button type="button" class="cmn-btn btn-sm" id="add-form-checklist-btn">Add Form <img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"></button>
              <div class="added-form-main" id="form-main-container">
                @foreach ($data['formChecklists'] as $fc)
                <div class="add-element-card p-4 mt-3 mb-3" style="border:1px solid rgb(120,0 ,0);border-radius:7px;">
                  <div class="multi-input-grp grp-3">
                    <div class="input-grp">
                      <label>School Year</label>
                      <select name="school_year[]">
                        <option value="">Select</option>
                        <option value="2019-2020" {{ $fc->school_year == '2019-2020' ? 'selected' : '' }}>2019-2020</option>
                        <option value="2021-2022" {{ $fc->school_year == '2021-2022' ? 'selected' : '' }}>2021-2022</option>
                        <option value="2022-2023" {{ $fc->school_year == '2022-2023' ? 'selected' : '' }}>2022-2023</option>
                        <option value="2023-2024" {{ $fc->school_year == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                        <option value="2024-2025" {{ $fc->school_year == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                      </select>
                    </div>
                    <div class="input-grp">
                      <label>Year Status</label>
                      <select name="year_status[]">
                        <option value="">Select</option>
                        <option value="active" {{ $fc->year_status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $fc->year_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </div>
                  </div>

                  <div class="multi-input-grp grp-3">
                    <div class="input-grp">
                      <label>Travel Form</label>
                      <input type="text" name="travel_form[]" value="{{ $fc->travel_from }}">
                    </div>
                    <div class="input-grp">
                      <label>Flight Date</label>
                      <input type="text" name="flight_date[]" value="{{ $fc->flight_date }}">
                    </div>
                    <div class="input-grp">
                      <label>Flight Info</label>
                      <input type="text" name="flight_information[]" value="{{ $fc->flight_info }}">
                    </div>
                  </div>

                  <div class="multi-input-grp grp-3">
                    <div class="input-grp checkbox">
                      <label>
                        Waiver
                        <input type="checkbox" name="checklist[]" value="1" {{ $fc->checklist == 1 ? 'checked' : '' }}>
                      </label>
                    </div>
                    <div class="input-grp checkbox">
                      <label>
                        Medical Form
                        <input type="checkbox" name="checklist[]" value="2" {{ $fc->checklist == 2 ? 'checked' : '' }}>
                      </label>
                    </div>
                  </div>

                  <div class="multi-input-grp grp-1">
                    <div class="input-grp">
                      <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>

            </div>
            <div class="form-submission btn-sm align-right">
              <input type="submit" value="Update Student">
            </div>
          </form>
          <div id="class-template" style="display: none;">
            <div class="added-element-card">
              <span class="sl-count"></span>
              <div class="multi-input-grp">
                <div class="input-grp">
                  <select name="class_id[]" required>
                    <option value="">Select Class</option>
                    @foreach ($data['classes'] as $class)
                    <option value="{{ $class->id }}">{{ $class->class->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-grp">
                  <select name="teacher_id[]" required>
                    <option value="">Select Teacher</option>
                    @foreach ($data['teachers'] as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="added-elm-actions btn-grp">
                {{-- <button type="submit" class="cmn-btn btn-sm"><img src="{{ asset('backend') }}/assets/images/new_images/edit-icon.svg" alt="Icon"> Edit</button> --}}
                <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
              </div>
            </div>
          </div>
          <div id="request-template" style="display: none;">
            <div class="added-element-card">
              <span class="sl-count"></span>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <input type="date" name="request_date[]" required>
                </div>
                <div class="input-grp">
                  <select name="request_destination[]" required>
                    <option value="">Destination</option>
                    <option value="1">Destination 1</option>
                    <option value="2">Destination 2</option>
                    <option value="3">Destination 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <select name="payment_status[]" required>
                    <option value="1">Paid</option>
                    <option value="0">Unpaid</option>
                  </select>
                </div>
              </div>
              <div class="added-elm-actions btn-grp">
                <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
              </div>
            </div>
          </div>
          <div id="form-template" style="display: none;">
            <div class="add-element-card p-4 mt-3 mb-3" style="border:1px solid rgb(120,0 ,0);border-radius:7px;">
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="school_year">School Year</label>
                  <select id="school_year" name="school_year">
                    <option value="">Select</option>
                    <option value="2019-2020">2019-2020</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="year_status">Year Status</label>
                  <select id="year_status" name="year_status">
                    <option value="">Select</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="travel_form">Travel Form</label>
                  <input type="text" id="travel_form" value="{{ ( $data['student']->travel_from) }}" name="travel_form">
                </div>
                <div class="input-grp">
                  <label for="flight_date">Flight Date</label>
                  <input type="text" id="flight_date" value="{{ ( $data['student']->flight_date) }}" name="flight_date">
                </div>
                <div class="input-grp">
                  <label for="flight_information">Flight Information</label>
                  <input type="text" id="flight_information" value="{{ ( $data['student']->flight_info) }}" name="flight_information">
                </div>

                <div class="input-grp checkbox">
                  <label>
                    Waiver
                    <input type="checkbox" name="checklist" value="1" class="single-check">
                  </label>
                </div>

                <div class="input-grp checkbox">
                  <label>
                    Medical Form
                    <input type="checkbox" name="checklist" value="2" class="single-check">
                  </label>
                </div>
              </div>
              <div class="multi-input-grp grp-1">
                <div class="input-grp">
                  <button type="button" class="cmn-btn btn-sm delete-btn">Delete</button>
                </div>
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
    });
  </script>

  <script>
    $(document).ready(function() {
      let count = $('#class-main-container .added-element-card').length;
      $('#add-class-btn').on('click', function() {
        count++;
        let $clone = $('#class-template .added-element-card').clone();
        $clone.find('.sl-count').text(count + '.');
        $('#class-main-container').append($clone);
      });
      $('#class-main-container').on('click', '.delete-btn', function() {
        $(this).closest('.added-element-card').remove();
        updateSerialNumbers();
      });

      function updateSerialNumbers() {
        $('#class-main-container .added-element-card').each(function(index) {
          $(this).find('.sl-count').text((index + 1) + '.');
        });
        count = $('#class-main-container .added-element-card').length;
      }

      let requestCount = $('#request-main-container .added-element-card').length;
      $('#add-request-btn').on('click', function() {
        requestCount++;
        let $clone = $('#request-template .added-element-card').clone();
        $clone.find('.sl-count').text(requestCount + '.');
        $('#request-main-container').append($clone);
      });
      $('#request-main-container').on('click', '.delete-btn', function() {
        $(this).closest('.added-element-card').remove();
        updateRequestNumbers();
      });

      function updateRequestNumbers() {
        $('#request-main-container .added-element-card').each(function(index) {
          $(this).find('.sl-count').text((index + 1) + '.');
        });
        requestCount = $('#request-main-container .added-element-card').length;
      }

      $('#add-form-checklist-btn').on('click', function() {
        let $clone = $('#form-template .add-element-card').clone();
        $('#form-main-container').append($clone);
      });
      $('#form-main-container').on('click', '.delete-btn', function() {
        $(this).closest('.add-element-card').remove();
      });

    });
  </script>

  <script>
    document.getElementById('fileUpload').addEventListener('change', function() {
      let fileName = this.files[0] ? this.files[0].name : "No file chosen";
      this.closest('label').querySelector('.file-text').textContent = fileName;
    });

    document.getElementById('uploadBtn').addEventListener('click', function() {
      document.getElementById('fileUpload').click();
    });
  </script>

    <script>
    $(document).on('change', '.single-check', function() {
      var $group = $(this).closest('.added-form-main, .add-element-card');
      $group.find('.single-check').not(this).prop('checked', false);
    });
  </script>

  @endpush