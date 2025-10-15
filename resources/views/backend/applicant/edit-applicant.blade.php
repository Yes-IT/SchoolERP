@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
                    <div class="ds-breadcrumb">
                        <h1>Edit Applicant</h1>
                        <ul>
                            <li><a href="dashboard.html">Dashboard</a> /</li>
                            <li><a href="#url">Applicantion</a> /</li>
                            <li><a href="#url">Applicants List</a> /</li>
                            <li><a href="#url">Applicant Info</a> /</li>
                            <li>Edit Applicant </li>
                        </ul>

                         <button onclick="window.location.href='{{ route('applicant.index') }}'" class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                <form  action="#" method="POST">
                                    @csrf
                                    <div class="new-request-form">
                                        <h3>Applicant Details</h3>
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input type="text" id="identification_number" name="identification_number"  placeholder="ID"    readonly >
                                            </div>
                                            <div class="input-grp">
                                              <label for="">Last Name</label>
                                              <input type="text" id="" name=""  placeholder="Last Name">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">First Name</label>
                                              <input  type="text" id="" name=""  placeholder="First Name">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="subject">High School</label>
                                              <input type="text" id="high_school" name="high_school" placeholder="High School">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">Birthdate</label>
                                              <input type="date" id="" name="" placeholder="Birthdate">
                                            </div>
                                            <div class="input-grp">
                                              <label for="">USA Cell</label>
                                              <input type="text" id="" name="" placeholder="USA Cell">
                                            </div>
                                        </div>
                                      
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="">Email</label>
                                                <input type="text" name="" placeholder="Email">
                                            </div>
                                            <div class="input-grp">
                                                <label for="">High School (Application)</label>
                                                <input type="text" name="" placeholder="High School (Application)">
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
                                                      <input type="text" placeholder="Camp">
                                                    </div>
                                                    <div class="input-grp">
                                                         <input type="text" placeholder="Position">
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
                                                <input id="" name="" type="text" placeholder="$1200.00">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">CC Last 4</label>
                                                <input id="" name="" type="text" placeholder="Lorem">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Date Deposited</label>
                                                <input id="" name="" type="text" placeholder="12/11/2001"  > 
                                            </div>

                                            <div class="input-grp">
                                                <label for="">References</label>
                                                <input id="" name="" type="text" placeholder="Enter References" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Pictures</label>
                                                <input id="" name="" type="text" placeholder="59" >
                                            </div>
                                        </div>
                                        
                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp checkbox">
                                                <label>Transcript Hebrew <input id="" name="" type="checkbox"> </label>
                                            </div>
                                            
                                            <div class="input-grp checkbox">
                                                <label>Transcript English <input id="" name="" type="checkbox" > </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Application Processing</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">Interview Date</label>
                                                <input type="date" id="" name="" placeholder="Birthdate">
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Interview Time</label>
                                                <input id="" name="" type="text" placeholder="Interview Time">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Interview Location</label>
                                                <select name="" id=""></select>
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Status</label>
                                                <input id="" name="" type="text" placeholder="Status" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Coming</label>
                                                <input id="" name="" type="text" placeholder="Coming" >
                                            </div>
                                        </div>
                                     
                                    </div>

                                    <div class="new-request-form" id="">    
                                        <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Application Comment</label>
                                                <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Application Comment"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form" id="">
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Scholarship Comment</label>
                                                <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Scholarship Comment"></textarea>
                                            </div>
                                        </div>
                                          <div class="multi-input-grp grp-1">
                                            <div class="input-grp">
                                                <label for="comment">Tuition Comment</label>
                                                <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Tuition Comment"></textarea>
                                            </div>
                                        </div>

                                       <div class="input-grp checkbox">
                                            <label>Letter Sent <input id="" name="" type="checkbox"> </label>
                                        </div>

                                    </div>

                                    <div class="new-request-form" id="">
                                        <h3>Parents Information</h3>

                                        <div class="multi-input-grp grp-3">
                                            <div class="input-grp input-full">
                                                <label for="">ID</label>
                                                 <input type="text" id="identification_number" name="identification_number"  placeholder="ID"    readonly >
                                            </div>
                                        
                                            <div class="input-grp">
                                                <label for="">Last Name</label>
                                                <input id="" name="" type="text" placeholder="Last Name">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Father Title</label>
                                                <input id="" name="" type="text" placeholder="Father Title">
                                            </div>

                                            <div class="input-grp">
                                                <label for="">Father Name</label>
                                                <input id="" name="" type="text" placeholder="Father Name" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Title</label>
                                                <input id="" name="" type="text" placeholder="Mother Title"  >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Name</label>
                                                <input id="" name="" type="text" placeholder="Mother Name"  >
                                            </div>

                                             <div class="input-grp">
                                                <label for="">Maiden Name</label>
                                                <input id="" name="" type="text" placeholder="Maiden Name"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Address</label>
                                                <input id="" name="" type="text" placeholder="Address"  >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">City</label>
                                                <input id="" name="" type="text" placeholder="City" >
                                            </div>

                                             <div class="input-grp">
                                                <label for="">State</label>
                                                <input id="" name="" type="text" placeholder="State" >
                                            </div>
                                             <div class="input-grp">
                                                <label for="">Zip Code</label>
                                                <input id="" name="" type="text" placeholder="Zip Code" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Country</label>
                                                <input id="" name="" type="text" placeholder="Country" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Status</label>
                                                <input id="" name="" type="text" placeholder="Marital Status" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Marital Comment</label>
                                                <input id="" name="" type="text" placeholder="Marital Comment" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Home Phone</label>
                                                <input id="" name="" type="text" placeholder="Home Phone" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Cell</label>
                                                <input id="" name="" type="text" placeholder="Father Cell" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Cell</label>
                                                <input id="" name="" type="text" placeholder="Mother Cell" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Email</label>
                                                <input id="" name="" type="text" placeholder="Father Email" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Email</label>
                                                <input id="" name="" type="text" placeholder="Mother Email" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Father Occupation</label>
                                                <input id="" name="" type="text" placeholder="Father Occupation" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Mother Occupation</label>
                                                <input id="" name="" type="text" placeholder="Mother Occupation" >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Phone No.</label>
                                                <input id="" name="" type="text" placeholder="Additional Phone No." >
                                            </div>
                                            <div class="input-grp">
                                                <label for="">Additional Email Addresses</label>
                                                <input id="" name="" type="text" placeholder="Additional Email Addresses" >
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