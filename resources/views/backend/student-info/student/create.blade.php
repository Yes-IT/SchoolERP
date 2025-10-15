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
      <h1>Add Students</h1>
      <ul>
        <li><a href="../dashboard">Dashboard</a> /</li>
        <li><a href="./dashboard">Students</a> /</li>
        <li><a href="./profile">Students Info</a> /</li>
        <li>Add Student</li>
      </ul>
    </div>
    <div class="ds-pr-body">
      <div class="ds-cmn-table-wrp">
        <div class="request-leave-form spradmin">
          <form action="{{ route('student.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
            @csrf
            <div class="new-request-form">
              <h3>Student Details</h3>
              <div class="input-grp h48">
                <label>Image Link</label>
                <div class="floating-input-btn input-grp w-70">
                  <div class="has-submit">
                    <label class="file-label">
                      <span class="file-text">No file chosen</span>
                      <input type="file" id="fileUpload" name="image" />
                    </label>
                    <input type="button" id="uploadBtn" value="Upload" style="width: 10%; height: 40px; " class="btn-upload" />
                  </div>
                </div>


              </div>
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="first_name">First Name</label>
                  <input id="first_name" name="first_name" type="text" placeholder="First Name" required>
                </div>
                <div class="input-grp">
                  <label for="last_name">Last Name</label>
                  <input id="last_name" name="last_name" type="text" placeholder="Last Name" required>
                </div>
                <div class="input-grp">
                  <label for="hebrew_last_name">Hebrew Last Name</label>
                  <input id="hebrew_last_name" name="hebrew_last_name" type="text" placeholder="Hebrew Last Name">
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="hebrew_first_name">Hebrew First Name</label>
                  <input id="hebrew_first_name" name="hebrew_first_name" type="text" placeholder="Hebrew First Name">
                  {{-- test code --}}
                  <input id="status" name="status" type="hidden" value="1" type="text">
                  {{-- test code end --}}
                </div>
                <div class="input-grp">
                  <label for="diploma_name">Diploma Name</label>
                  <input id="diploma_name" name="diploma_name" type="text" placeholder="Diploma Name">
                </div>
                <div class="input-grp">
                  <label for="birth_date">Birth Date</label>
                  <input id="birth_date" name="date_of_birth" type="date" placeholder="Birth Date" required>
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="hebrew_dob">Hebrew Birthday</label>
                  <input id="hebrew_dob" name="hebrew_dob" type="date" placeholder="Hebrew Birthday">
                </div>
                <div class="input-grp">
                  <label for="place_of_birth">Birth Country</label>
                  <select id="place_of_birth" name="place_of_birth" required>
                    <option value="">Birth Country</option>
                    <option>India</option>
                    <option>Israel</option>
                    <option>United States</option>
                    <option>Other</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="ssn">SSN</label>
                  <input id="ssn" name="ssn" type="text" placeholder="SSN">
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="passport_no">Passport No.</label>
                  <input id="passport_no" name="passport_no" type="text" placeholder="Passport No.">
                </div>
                <div class="input-grp">
                  <label for="passport_name">Passport Name</label>
                  <input id="passport_name" name="passport_name" type="text" placeholder="Passport Name">
                </div>
                <div class="input-grp">
                  <label for="passport_country">Passport Country</label>
                  <select id="passport_country" name="passport_country">
                    <option value="">Passport Country</option>
                    <option>India</option>
                    <option>Israel</option>
                    <option>United States</option>
                    <option>Other</option>
                  </select>
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="passport_exp_date">Passport Exp. Date</label>
                  <input id="passport_exp_date" name="passport_exp_date" type="date" placeholder="Passport Exp. Date">
                </div>
                <div class="input-grp">
                  <label for="teudat_zehut">Teudat Zehut</label>
                  <input id="teudat_zehut" name="teudat_zehut" type="text" placeholder="Teudat Zehut">
                </div>
                <div class="input-grp">
                  <label for="insurance">Insurance</label>
                  <input id="insurance" name="insurance" type="text" placeholder="Insurance">
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="insurance_type">Insurance Type</label>
                  <select id="insurance_type" name="insurance_type">
                    <option value="">Insurance Type</option>
                    <option>Private</option>
                    <option>Government</option>
                    <option>None</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="email">Email Address</label>
                  <input id="email" name="email" type="email" placeholder="Email Address" required>
                </div>
                <div class="input-grp">
                  <label for="cell_israel">Cell Israel</label>
                  <input id="cell_israel" name="cell_israel" type="tel" placeholder="Cell Israel">
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="cell_usa">Cell USA</label>
                  <input id="cell_usa" name="cell_usa" type="tel" placeholder="Cell USA">
                </div>
                <div class="input-grp">
                  <label for="mobile">Home Phone</label>
                  <input id="mobile" name="mobile" type="tel" placeholder="Home Phone">
                </div>
                <div class="input-grp">
                  <label for="high_school">High School</label>
                  <select id="high_school" name="high_school">
                    <option value="">High School</option>
                    <option value="a">School A</option>
                    <option value="b">School B</option>
                    <option value="other">Other</option>
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
                  <input id="address_line1" name="residance_address" type="text" placeholder="Address" required>
                </div>

                <div class="input-grp">
                  <label for="city">City</label>
                  <input id="city" name="city" type="text" placeholder="City Name" required>
                </div>
              </div>

              <div class="multi-input-grp grp-3">
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
              </div>
            </div>

            <div class="new-request-form">
              <h3>Marital Status</h3>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="marital_status">Marital Status</label>
                  <select id="marital_status" name="marital_status" required>
                    <option value="" disabled selected>Marital Status</option>
                    <option value="married">Married</option>
                    <option value="single">Single</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="new-request-form">
              <h3 id="parent-details-heading">Parent Details</h3>

              <!-- 3-column grid (uses your .grp-3 rules) -->
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="father_name">Father Name</label>
                  <input id="father_name" name="father_name" type="text" placeholder="Father Name">
                </div>

                <div class="input-grp">
                  <label for="mother_name">Mother Name</label>
                  <input id="mother_name" name="mother_name" type="text" placeholder="Mother Name">
                </div>

                <div class="input-grp">
                  <label for="father_hebrew_name">Father Hebrew Name</label>
                  <input id="father_hebrew_name" name="father_hebrew_name" type="text" placeholder="Father Hebrew Name">
                </div>

                <div class="input-grp">
                  <label for="mother_hebrew_name">Mother Hebrew Name</label>
                  <input id="mother_hebrew_name" name="mother_hebrew_name" type="text" placeholder="Mother Hebrew Name">
                </div>

                <div class="input-grp">
                  <label for="maiden_name">Maiden Name</label>
                  <input id="maiden_name" name="maiden_name" type="text" placeholder="Maiden Name">
                </div>

                <div class="input-grp">
                  <label for="father_dob">Father Birth Date</label>
                  <input id="father_dob" name="father_dob" type="date" placeholder="Father Birth Date">
                </div>

                <div class="input-grp">
                  <label for="mother_dob">Mother Birth Date</label>
                  <input id="mother_dob" name="mother_dob" type="date" placeholder="Mother Birth Date">
                </div>

                <div class="input-grp">
                  <label for="father_mobile">Father Phone Number</label>
                  <input id="father_mobile" name="father_mobile" type="tel" inputmode="tel" placeholder="Father Phone Number">
                </div>

                <div class="input-grp">
                  <label for="mother_mobile">Mother Phone Number</label>
                  <input id="mother_mobile" name="mother_mobile" type="tel" inputmode="tel" placeholder="Mother Phone Number">
                </div>

                <div class="input-grp">
                  <label for="additional_mobile_numbers">Additional Phone Numbers</label>
                  <input id="additional_mobile_numbers" name="additional_mobile_numbers" type="text" placeholder="23489632, 1641556456">
                </div>

                <div class="input-grp">
                  <label for="father_email">Father Email</label>
                  <input id="father_email" name="father_email" type="email" placeholder="Father Email">
                </div>

                <div class="input-grp">
                  <label for="mother_email">Mother Email</label>
                  <input id="mother_email" name="mother_email" type="email" placeholder="Mother Email">
                </div>
              </div>

              <!-- full-width row for additional emails (uses your .grp-1 rules) -->
              <div class="multi-input-grp grp-1">
                <div class="input-grp">
                  <label for="additional_emails">Additional Email Addresses</label>
                  <input id="additional_emails" name="additional_emails" type="text"
                    placeholder="carolinethomas36@gmail.com, olivierthomas55@gmail.com">
                </div>
              </div>

              <!-- occupations + parents address row -->
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="father_profession">Father Occupation</label>
                  <input id="father_profession" name="father_profession" type="text" placeholder="Father Occupation">
                </div>

                <div class="input-grp">
                  <label for="mother_profession">Mother Occupation</label>
                  <input id="mother_profession" name="mother_profession" type="text" placeholder="Mother Occupation">
                </div>

                <div class="input-grp">
                  <label for="guardian_address">Parents Address</label>
                  <input id="guardian_address" name="guardian_address" type="text" placeholder="Parents Address">
                </div>
              </div>
            </div>

            <div class="new-request-form">
              <h3>Relative Details</h3>
              <!-- 3-column grid (uses your .grp-3 rules) -->
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="guardian_name">Name</label>
                  <input id="guardian_name" name="guardian_name" type="text" placeholder="Name">
                </div>
                <div class="input-grp">
                  <label for="guardian_relation">Relationship</label>
                  <input id="guardian_relation" name="guardian_relation" type="text" placeholder="Relationship">
                </div>
                <div class="input-grp">
                  <label for="guardian_home_phone">Home Phone</label>
                  <input id="guardian_home_phone" name="guardian_home_phone" type="text" placeholder="Home Phone">
                </div>
                <div class="input-grp">
                  <label for="guardian_mobile">Cell Phone</label>
                  <input id="guardian_mobile" name="guardian_mobile" type="text" placeholder="Cell Phone">
                </div>
                <div class="input-grp">
                  <label for="guardian_email">Email</label>
                  <input id="guardian_email" name="guardian_email" type="text" placeholder="Email">
                </div>
              </div>
              <!-- full-width row for address (uses your .grp-1 rules) -->
              <div class="multi-input-grp grp-1">
                <div class="input-grp">
                  <label for="guardian_address">Address</label>
                  <input id="guardian_address" name="guardian_address" type="text" placeholder="Address">
                </div>
              </div>
            </div>

            <div class="new-request-form">
              <h3>School Year (s)</h3>
              <!-- 3-column grid (uses your .grp-3 rules) -->
              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="school_id">ID</label>
                  <input id="school_id" name="school_id" type="text" placeholder="Name">
                </div>
                <div class="input-grp">
                  <label for="school_year">School Year</label>
                  <select id="school_year" name="school_yearsd">
                    <option value="">Select</option>
                    @foreach ($data['school_years'] as $school_year)
                      <option value="{{ $school_year->name }}">{{ $school_year->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-grp">
                  <label for="year_status">Year Status</label>
                  <select id="year_status" name="year_statussd">
                    <option value="">Select</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="college">College</label>
                  <select id="college" name="college">
                    <option value="">Select</option>
                    <option value="1">College 1</option>
                    <option value="2">College 2</option>
                    <option value="3">College 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="withdraw_date">Withdraw Date</label>
                  <input id="withdraw_date" name="withdraw_date" type="date" placeholder="Withdraw Date">
                </div>
                <div class="input-grp">
                  <label for="homeroom_class">Homeroom Class</label>
                  <select id="homeroom_class" name="homeroom_class">
                    <option value="">Select</option>
                    @foreach ($data['classes'] as $class)
                      <option value="{{ $class->id }}">Class {{ $class->id }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-grp">
                  <label for="group">Group</label>
                  <select id="group" name="group">
                    <option value="">Select</option>
                    <option value="1">Group 1</option>
                    <option value="2">Group 2</option>
                    <option value="3">Group 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="division">Division</label>
                  <select id="division" name="division">
                    <option value="">Select</option>
                    <option value="1">Group 1</option>
                    <option value="2">Group 2</option>
                    <option value="3">Group 3</option>
                  </select>
                </div>
                <div class="input-grp">
                  <label for="floor">Floor</label>
                  <input id="floor" name="floor" type="text" placeholder="Floor">
                </div>
                <div class="input-grp">
                  <label for="room">Room</label>
                  <input id="room" name="room" type="text" placeholder="Room">
                </div>
              </div>
            </div>

            <div class="new-request-form">
              <h3>Classes</h3>
              <button type="button" class="cmn-btn btn-sm" id="add-class-btn">Add Classes <img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"></button>
              <div class="added-class-main" id="class-main-container">
              </div>
            </div>

            <div class="new-request-form">
              <h3>Request Transcript</h3>
              <button type="button" class="cmn-btn btn-sm" id="add-request-btn">Add Request <img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"></button>
              <div class="added-request-main" id="request-main-container">
              </div>
            </div>


            <div class="new-request-form">
              <h3>Form Checklist</h3>
              <button type="button" class="cmn-btn btn-sm" id="add-form-checklist-btn">Add Form <img src="{{ asset('backend') }}/assets/images/new_images/plus-circle.svg" alt="Icon"></button>
              <div class="added-form-main" id="form-main-container">
              </div>
            </div>

            <div class="form-submission btn-sm align-right">
              <input type="submit" value="Save Student">
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
                  <select id="school_year" name="school_year[]">
                    <option value="">Select</option>
                    @foreach ($data['school_years'] as $school_year)
                      <option value="{{ $school_year->name }}">{{ $school_year->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-grp">
                  <label for="year_status">Year Status</label>
                  <select id="year_status" name="year_status[]">
                    <option value="">Select</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
              </div>

              <div class="multi-input-grp grp-3">
                <div class="input-grp">
                  <label for="travel_form">Travel Form</label>
                  <input type="text" id="travel_form" name="travel_form[]">
                </div>
                <div class="input-grp">
                  <label for="flight_date">Flight Date</label>
                  <input type="text" id="flight_date" name="flight_date[]">
                </div>
                <div class="input-grp">
                  <label for="flight_information">Flight Information</label>
                  <input type="text" id="flight_information" name="flight_information[]">
                </div>
                <!-- <div class="input-grp checkbox">
                  <label>Waiver
                    <input type="checkbox" name="checklist[__INDEX__]" value="1" class="single-check">
                  </label>
                </div>

                <div class="input-grp checkbox">
                  <label>Medical Form
                    <input type="checkbox" name="checklist[__INDEX__]" value="2" class="single-check">
                  </label>
                </div> -->


                <div class="input-grp checkbox">
                  <label>
                    Waiver
                    <input type="checkbox" name="checklist[]" value="1" class="single-check">
                  </label>
                </div>

                <div class="input-grp checkbox">
                  <label>
                    Medical Form
                    <input type="checkbox" name="checklist[]" value="2" class="single-check">
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

      // Initially hide the role selection div
      $('#SelectionDiv').hide();

      // Attach an event listener to the radio buttons
      $('input[name="password_type"]').on('change', function() {
        if ($(this).val() === 'custom') {

          // If the 'custom' radio button is selected, show the role selection div
          $('#SelectionDiv').show();
        } else {
          // If the 'default' radio button is selected or other value, hide the  selection div
          $('#SelectionDiv').hide();
        }
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      let count = 0;
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

      let requestCount = 0;
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
    $(document).on('change', '.single-check', function() {
      var $group = $(this).closest('.added-form-main, .add-element-card');
      $group.find('.single-check').not(this).prop('checked', false);
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




  @endpush