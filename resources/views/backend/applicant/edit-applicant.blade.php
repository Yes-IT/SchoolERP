@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
                    <div class="ds-breadcrumb">
                        <h1>Edit Applicant</h1>
                        <ul>
                             <li><a href="{{route('applicant.dashboard')}}">Dashboard</a> /</li>
                            <li><a href="#">Application</a> /</li>
                            <li><a href="{{route('applicant.student_application_form')}}">Applicants List</a> /</li>
                            {{-- <li><a href="#url">Applicant Info</a> /</li> --}}
                            <li>Edit Applicant </li>
                        </ul>

                         <button onclick="window.location.href='{{ route('applicant.student_application_form') }}'" class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                <form  action="{{ route('applicant.update_applicant', $applicant->id) }}" method="POST">
                                    @csrf

                                    <div class="new-request-form">
                                        <h3>Applicant Details</h3>
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input type="text" id="identification_number" name="identification_number" value="{{ old('identification_number', $applicant->custom_id ?? '') }}"  placeholder="ID" readonly >
                                            </div>
                                            <div class="input-grp">
                                              <label for="">Last Name</label>
                                              <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $applicant->last_name ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">First Name</label>
                                              <input  type="text" id="first_name" name="first_name" value="{{ old('first_name', $applicant->first_name ?? '') }}">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="subject">High School</label>
                                              <input type="text" id="high_school" name="high_school" value="{{ old('high_school', $applicant->high_school ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                              <label for="subject">Others High School</label>
                                              <input type="text" id="high_school" name="high_school" value="{{ old('high_school', $applicant->high_school ?? '') }}" >
                                            </div>

                                            <div class="input-grp">
                                              <label for="">Birthdate</label>
                                              <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $applicant->date_of_birth ?? '') }}">
                                            </div>
                                            
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="">USA Cell</label>
                                              <input type="text" id="usa_cell" name="usa_cell" value="{{ old('usa_cell', $applicant->usa_cell ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Email</label>
                                                <input type="text" id ="email" name="email" value="{{ old('email', $applicant->email ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">High School (Application)</label>
                                                <input type="text" id="highschool_application" name="highschool_application" value="{{ old('highschool_application', $applicant->highschool_application ?? '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                        <h3>Camp (S) Attended</h3>

                                        <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>
                                        <div class="add-form-element" id="schedule-wrapper">

                                          @foreach($applicant->camps as $index => $camp)

                                            <div class="added-element-card schedule-row">
                                                <span class="sl-count"></span>
                                                <div class="multi-input-grp input-grp-5">
                                                    <input type="hidden" name="camps[{{ $index }}][id]" value="{{ $camp->id }}">

                                                    <div class="input-grp">
                                                      {{-- <input type="text" id="camp" name="camp" placeholder="Camp"> --}}
                                                      <input type="text" name="camps[{{ $index }}][camp]" value="{{ old('camps.'.$index.'.camp', $camp->camp) }}" placeholder="Camp">

                                                    </div>
                                                    <div class="input-grp">
                                                         {{-- <input type="text" id ="position" name="position" placeholder="Position"> --}}
                                                        <input type="text" name="camps[{{ $index }}][position]" value="{{ old('camps.'.$index.'.position', $camp->position) }}" placeholder="Position">

                                                    </div>

                                                </div>
                                                <div class="added-elm-actions btn-grp">
                                                    <button type="submit" class="cmn-btn btn-sm"><img
                                                                src="{{global_asset('backend/assets/images/edit-icon.svg')}}" alt="Icon"> Edit</button>
                                                    <button type="submit" class="cmn-btn btn-sm delete-row-btn">Delete</button>
                                                </div>
                                            </div>
                                          @endforeach
                                            
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Application Check List</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Fee</label>
                                                <input  type="text" name="checklist[fee]" value="{{ old('checklist.fee', $applicant->checklist->fee ?? '') }}">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">CC Last 4</label>
                                                <input type="text" name="checklist[cc_last_4]" value="{{ old('checklist.cc_last_4', $applicant->checklist->cc_last_4 ?? '') }}">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Date Deposited</label>
                                                <input  type="text" name="checklist[date_deposited]" value="{{ old('checklist.date_deposited', $applicant->checklist->date_deposited ?? '') }}" > 
                                            </div>

                                            <div class="input-grp">
                                                <label for="">References</label>
                                                <input type="text" name="checklist[references]" value="{{ old('checklist.references', $applicant->checklist->references ?? '') }}" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Pictures</label>
                                                <input type="text" name="checklist[pictures]" value="{{ old('checklist.pictures', $applicant->checklist->pictures ?? '') }}" >
                                            </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Transcript Hebrew <input  type="checkbox" id="transcript_hebrew" name="transcript_hebrew" {{ old('transcript_hebrew', $applicant->transcript_hebrew ?? false) ? 'checked' : '' }}> </label>
                                            </div>
                                            
                                            <div class="input-grp checkbox">
                                                <label>Transcript English <input type="checkbox" id="transcript_english" name="transcript_english"  {{ old('transcript_english', $applicant->transcript_english ?? false) ? 'checked' : '' }} > </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Application Processing</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Interview Date</label>
                                                <input type="date"  name="processing[interview_date]" value="{{ old('processing.interview_date', $applicant->processing->interview_date ?? '') }}">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Interview Time</label>
                                                <input type="text" name="processing[interview_time]" value="{{ old('processing.interview_time', $applicant->processing->interview_time ?? '') }}">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Interview Location</label>
                                                <select name="processing[interview_location]" >
                                                    <option value="">Choose Location</option>
                                                    <option value="India" {{ old('processing.interview_location', $applicant->processing->interview_location ?? '') == 'India' ? 'selected' : '' }}>India</option>
                                                    <option value="Canada" {{ old('processing.interview_location', $applicant->processing->interview_location ?? '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                    <option value="Israel" {{ old('processing.interview_location', $applicant->processing->interview_location ?? '') == 'Israel' ? 'selected' : '' }}>Israel</option>
                                                </select>
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Status</label>
                                                <input type="text"  name="processing[status]" value="{{ old('processing.status', $applicant->processing->status ?? '') }}"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Coming</label>
                                                <input  type="text" name="processing[coming]" value="{{ old('processing.coming', $applicant->processing->coming ?? '') }}"  >
                                            </div>
                                        </div>
                                     
                                    </div>

                                    <div class="new-request-form" id="">    
                                        <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Application Comment</label>
                                                <textarea  name="processing[application_comment]" >{{ old('processing.application_comment', $applicant->processing->application_comment ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Scholarship Comment</label>
                                                <textarea name="processing[scholarship_comment]" >{{ old('processing.scholarship_comment', $applicant->processing->scholarship_comment ?? '') }}</textarea>
                                            </div>
                                        </div>
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Tuition Comment</label>
                                                <textarea name="processing[tuition_comment]" >{{ old('processing.tuition_comment', $applicant->processing->tuition_comment ?? '') }}</textarea>
                                            </div>
                                        </div>

                                       <div class="input-grp checkbox">
                                            <label>Letter Sent <input  type="checkbox" name="processing[letter_sent]" {{ old('processing.letter_sent', $applicant->processing->letter_sent ?? false) ? 'checked' : '' }}> </label>
                                        </div>

                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Parents Information</h3>

                                        @php
                                            $parent = $applicant->parents->first();
                                        @endphp

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">ID</label>
                                                 <input type="text" id="identification_number" name="identification_number"  placeholder="ID"    readonly >
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Last Name</label>
                                                <input id="last_name" name="last_name" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Father Title</label>
                                                <input id="father_title" name="father_title" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Father Name</label>
                                                <input id="father_name" name="father_name" type="text" value="{{ old('father_name', $parent->father_name ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Title</label>
                                                <input id="mother_title" name="mother_title" type="text" value="{{ old('mother_title', $parent->mother_title ?? '') }}"  >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Name</label>
                                                <input id="mother_name" name="mother_name" type="text" value="{{ old('mother_name', $parent->mother_name ?? '') }}"  >
                                            </div>

                                             <div class="input-grp">
                                                <label for="">Maiden Name</label>
                                                <input id="maiden_name" name="maiden_name" type="text" value="{{ old('maiden_name', $parent->maiden_name ?? '') }}">
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Address</label>
                                                <input id="address" name="address" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">City</label>
                                                <input id="city" name="city" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}">
                                            </div>

                                             <div class="input-grp">
                                                <label for="">State</label>
                                                <input id="state" name="state" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}">
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Zip Code</label>
                                                <input id="zip_code" name="zip_code" type="text"value="{{ old('father_title', $parent->father_title ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Country</label>
                                                <input id="country" name="country" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Status</label>
                                                <input id="marital_status" name="marital_status" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Comment</label>
                                                <input id="marital_comment" name="marital_comment" type="text" value="{{ old('father_title', $parent->father_title ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Home Phone</label>
                                                <input id="home_phone" name="home_phone" type="text" value="{{ old('additional_mobile_numbers', $parent->additional_mobile_numbers ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Cell</label>
                                                <input id="father_cell" name="father_cell" type="text" value="{{ old('father_title', $parent->mother_mobile ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Cell</label>
                                                <input id="mother_cell" name="mother_cell" type="text" value="{{ old('father_title', $parent->mother_mobile ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Email</label>
                                                <input id="father_email" name="father_email" type="text" value="{{ old('father_email', $parent->father_email ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Email</label>
                                                <input id="mother_email" name="mother_email" type="text" value="{{ old('mother_email', $parent->mother_email ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Occupation</label>
                                                <input id="father_occupation" name="father_occupation" type="text" value="{{ old('father_profession', $parent->father_profession ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Occupation</label>
                                                <input id="mother_occupation" name="mother_occupation" type="text" value="{{ old('mother_profession', $parent->mother_profession ?? '') }}" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Phone No.</label>
                                                <input id="additional_phone_no" name="additional_phone_no" type="text" value="{{ old('additional_mobile_numbers', $parent->additional_mobile_numbers ?? '') }}">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Email Addresses</label>
                                                <input id="additional_emails" name="additional_emails" type="text" value="{{ old('additional_emails', $parent->additional_emails ?? '') }}" >
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