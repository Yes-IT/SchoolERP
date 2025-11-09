@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
                    <div class="ds-breadcrumb">
                        <h1>Applicant</h1>
                        <ul>
                            <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                            <li><a href="#">Application</a> /</li>
                            <li><a href="{{route('applicant.student_application_form')}}">Applicants List</a> /</li>
                            {{-- <li><a href="#url">Applicant Info</a> /</li> --}}
                            <li>Add Applicant </li>
                        </ul>

                         <button onclick="window.location.href='{{ route('applicant.student_application_form') }}'" class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                <form action="{{ route('applicant.store_applicant') }}" method="POST">
                                    @csrf

                                    <div class="new-request-form">
                                        <h3>Applicant Details</h3>
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input type="text" id="custom_id" name="custom_id" value="{{ $nextId }}" placeholder="ID" readonly>

                                            </div>
                                            <div class="input-grp">
                                              <label for="">Last Name</label>
                                              <input type="text" id="last_name" name="last_name"  placeholder="Last Name">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">First Name</label>
                                              <input  type="text" id="first_name" name="first_name"  placeholder="First Name">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="subject">High School</label>
                                              <input type="text" id="high_school" name="high_school" placeholder="High School">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">Birthdate</label>
                                              <input type="date" id="date_of_birth" name="date_of_birth" placeholder="Birthdate">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">USA Cell</label>
                                              <input type="text" id="usa_cell" name="usa_cell" placeholder="USA Cell">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="">Email</label>
                                                <input type="text" id="email" name="email" placeholder="Email">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">High School (Application)</label>
                                                <input type="text" id="highschool_application" name="highschool_application" placeholder="2024–2025">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                        <h3>Camp (S) Attended</h3>

                                        <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>
                                        <div class="add-form-element" id="schedule-wrapper">

                                            <div class="added-element-card schedule-row">
                                                <span class="sl-count"></span>
                                                <div class="multi-input-grp input-grp-5">
                                                    
                                                    <div class="input-grp">
                                                      <input type="text"  name="camps[0][camp]" placeholder="Camp">
                                                    </div>
                                                    <div class="input-grp">
                                                         <input type="text" name="camps[0][position]" placeholder="Position">
                                                    </div>

                                                </div>
                                                <div class="added-elm-actions btn-grp">
                                                    <button type="submit" class="cmn-btn btn-sm"><img
                                                                src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon"> Edit</button>
                                                    <button type="submit" class="cmn-btn btn-sm delete-row-btn">Delete</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Application Check List</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Fee</label>
                                                <input id="fee" name="fee" type="text" placeholder="$1200.00">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">CC Last 4</label>
                                                <input id="cc_last_4" name="cc_last_4" type="text" placeholder="Lorem">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Date Deposited</label>
                                                <input id="date_deposited" name="date_deposited" type="text" placeholder="12/11/2001"  > 
                                            </div>

                                            <div class="input-grp">
                                                <label for="">References</label>
                                                <input id="references" name="references" type="text" placeholder="Enter References" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Pictures</label>
                                                <input id="pictures" name="pictures" type="text" placeholder="59" >
                                            </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Transcript Hebrew <input id="transcript_hebrew" name="transcript_hebrew" type="checkbox"></label>
                                            </div>
                                            
                                            <div class="input-grp checkbox">
                                                <label>Transcript English <input id="transcript_english" name="transcript_english" type="checkbox"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Application Processing</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Interview Date</label>
                                                <input type="date" id="interview_date" name="interview_date" placeholder="Birthdate">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Interview Time</label>
                                                <input id="interview_time" name="interview_time" type="text" placeholder="Interview Time">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Interview Location</label>
                                                <select name="interview_location" id="interview_location">
                                                    <option value="">Choose Location</option>
                                                    <option value="India">India</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Israel">Israel</option>
                                                </select>
                                            </div>

                                            <div class="input-grp">
                                                <label for="Status">Status</label>
                                                <input id="status" name="status" type="text" placeholder="Status" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="Coming">Coming</label>
                                                <input id="coming" name="coming" type="text" placeholder="Coming" >
                                            </div>
                                        </div>
                                     
                                    </div>

                                    <div class="new-request-form" id="">    
                                        <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Application Comment</label>
                                                <textarea id="application_comment" name="application_comment" cols="50" rows="10" placeholder="Application Comment"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Scholarship Comment</label>
                                                <textarea id="scholarship_comment" name="scholarship_comment" cols="50" rows="10" placeholder="Scholarship Comment"></textarea>
                                            </div>
                                        </div>
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Tuition Comment</label>
                                                <textarea id="tuition_comment" name="tuition_comment" cols="50" rows="10" placeholder="Tuition Comment"></textarea>
                                            </div>
                                        </div>

                                       <div class="input-grp checkbox">
                                            <label>Letter Sent <input id="letter_sent" name="letter_sent" type="checkbox"> </label>
                                        </div>

                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Parents Information</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="ID">ID</label>
                                                 <input type="text" id="identification_number" name="identification_number"  placeholder="ID"    readonly >
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="Last Name">Last Name</label>
                                                <input id="last_name" name="last_name" type="text" placeholder="Last Name">
                                            </div>

                                            <div class="input-grp">
                                                <label for="Father Title">Father Title</label>
                                                <input id="father_title" name="father_title" type="text" placeholder="Father Title">
                                            </div>

                                            <div class="input-grp">
                                                <label for="Father Name">Father Name</label>
                                                <input id="father_name" name="father_name" type="text" placeholder="Father Name" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="Mother Title">Mother Title</label>
                                                <input id="mother_title" name="mother_title" type="text" placeholder="Mother Title"  >
                                            </div>
                                            <div class="input-grp">
                                                <label for="Mother Name">Mother Name</label>
                                                <input id="mother_name" name="mother_name" type="text" placeholder="Mother Name"  >
                                            </div>

                                             <div class="input-grp">
                                                <label for="Maiden Name">Maiden Name</label>
                                                <input id="maiden_name" name="maiden_name" type="text" placeholder="Maiden Name"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="Address">Address</label>
                                                <input id="address" name="address" type="text" placeholder="Address"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="City">City</label>
                                                <input id="city" name="city" type="text" placeholder="City" >
                                            </div>

                                             <div class="input-grp">
                                                <label for="State">State</label>
                                                <input id="state" name="state" type="text" placeholder="State" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="Zip Code">Zip Code</label>
                                                <input id="zip_code" name="zip_code" type="text" placeholder="Zip Code" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="Country">Country</label>
                                                <input id="country" name="country" type="text" placeholder="Country" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="Marital Status">Marital Status</label>
                                                <input id="marital_status" name="marital_status" type="text" placeholder="Marital Status" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Comment</label>
                                                <input id="marital_comment" name="marital_comment" type="text" placeholder="Marital Comment" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Home Phone</label>
                                                <input id="home_phone" name="home_phone" type="text" placeholder="Home Phone" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Cell</label>
                                                <input id="father_cell" name="father_cell" type="text" placeholder="Father Cell" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Cell</label>
                                                <input id="mother_cell" name="mother_cell" type="text" placeholder="Mother Cell" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Email</label>
                                                <input id="father_email" name="father_email" type="text" placeholder="Father Email" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Email</label>
                                                <input id="mother_email" name="mother_email" type="text" placeholder="Mother Email" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Occupation</label>
                                                <input id="father_occupation" name="father_occupation" type="text" placeholder="Father Occupation" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Occupation</label>
                                                <input id="mother_occupation" name="mother_occupation" type="text" placeholder="Mother Occupation" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Phone No.</label>
                                                <input id="additional_phone_no" name="additional_phone_no" type="text" placeholder="Additional Phone No." >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Email Addresses</label>
                                                <input id="additional_emails" name="additional_emails" type="text" placeholder="Additional Email Addresses" >
                                            </div>
                                            
                                        </div>
                                     
                                    </div>
                                  

                                    <div class="form-submission btn-sm align-right">
                                        <button type="submit" class="cmn-btn btn-sm">Save Applicant</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                   

@endsection

@push('script')
<script>
    $(document).ready(function() {
        let campIndex = 0;

        // When "Add" button is clicked
        $('#add-row-btn').on('click', function(e) {
            e.preventDefault();

            // Create a new camp row with indexed names
            let newRow = `
                <div class="added-element-card schedule-row">
                    <span class="sl-count"></span>
                    <div class="multi-input-grp input-grp-5">
                        <div class="input-grp">
                            <input type="text" name="camps[${campIndex}][camp]" placeholder="Camp">
                        </div>
                        <div class="input-grp">
                            <input type="text" name="camps[${campIndex}][position]" placeholder="Position">
                        </div>
                    </div>
                    <div class="added-elm-actions btn-grp">
                      <button type="submit" class="cmn-btn btn-sm"><img
                                                                src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon"> Edit</button>
                        <button type="submit" class="cmn-btn btn-sm delete-row-btn">Delete</button>
                    </div>
                </div>
            `;

            $('#schedule-wrapper').append(newRow);
            campIndex++;
        });

        // Delete row functionality
        $(document).on('click', '.delete-row-btn', function(e) {
            e.preventDefault();
            $(this).closest('.schedule-row').remove();

            // Re-index after removal (optional)
            $('#schedule-wrapper .schedule-row').each(function(i, el) {
                $(el).find('input[name^="camps"]').each(function() {
                    let oldName = $(this).attr('name');
                    let newName = oldName.replace(/\[\d+\]/, `[${i}]`);
                    $(this).attr('name', newName);
                });
            });
            campIndex = $('#schedule-wrapper .schedule-row').length;
        });
    });
</script>

@endpush