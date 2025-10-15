@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Teacher') }}
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
                        <h1>Add Teachers</h1>
                        <ul>
                            <li><a href="../dashboard">Dashboard</a> /</li>
                            <li><a href="{{route('teacher.index')}}">Teachers</a> /</li>
                            <li><a href="#">Teachers Info</a> /</li>
                          

                            <li>Add Teacher</li>
                        </ul>
                        <button  class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                    <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            <div class="request-leave-form spradmin">
                                <form action="{{ route('teacher.store') }}" enctype="multipart/form-data" method="post" >
                                    @csrf
                                    <div class="new-request-form">
                                        <h3>Teacher Details</h3>
                                          <div class="input-grp h48">
                                              <label>Image Link</label>
                                              <div class="floating-input-btn input-grp w-70">
                                                  <div class="has-submit">
                                                    <label class="file-label">
                                                      <span class="file-text">No file chosen</span>
                                                      <input type="file" id="fileUpload" name="fileUpload" />
                                                    </label>
                                                    <input type="submit" value="Upload" class="btn-upload" />
                                                  </div>
                                                </div>
                                          </div>
                                          <div class="multi-input-grp grp-3">
                                              <div class="input-grp">
                                                <label for="Title">Title</label>
                                                <input  type="text" id="title" name="title" placeholder="Title" required>
                                              </div>

                                              <div class="input-grp">
                                                <label for="first_name">First Name</label>
                                                <input id="first_name" name="first_name" type="text" placeholder="First Name" required>
                                              </div>
                                              <div class="input-grp">
                                                <label for="last_name">Last Name</label>
                                                <input id="last_name" name="last_name" type="text" placeholder="Last Name" required>
                                              </div>
                                            
                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                              <div class="input-grp">
                                                  <label for="hebrew_title">Hebrew Title</label>
                                                  <input id="hebrew_title" name="hebrew_title" type="text" placeholder="Hebrew Title">
                                              </div>

                                            <div class="input-grp">
                                              <label for="hebrew_first_name">Hebrew First Name</label>
                                              <input id="hebrew_first_name" name="hebrew_first_name" type="text" placeholder="Hebrew First Name">
                                            </div>

                                            <div class="input-grp">
                                                <label for="hebrew_last_name">Hebrew Last Name</label>
                                                <input id="hebrew_last_name" name="hebrew_last_name" type="text" placeholder="Hebrew Last Name">
                                            </div>

                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input id="identification_number" name="identification_number" type="text"  value="{{ $nextTeacherId }}"  readonly  >
                                            </div>

                                            <div class="input-grp">
                                              <label for="dob">Birth Date</label>
                                              <input id="dob" name="dob" type="date" placeholder="Birth Date" required>
                                            </div>

                                            <div class="input-grp">
                                              <label for="hebrew_dob">Hebrew Birthday</label>
                                              <input id="hebrew_dob" name="hebrew_dob" type="date" placeholder="Hebrew Birthday">
                                            </div>

                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                            
                                              <div class="input-grp">
                                                <label for="Neighborhood">Neighborhood</label>
                                                <input id="neighborhood" name="neighborhood" type="text" placeholder="Neighborhood">
                                              </div>

                                              <div class="input-grp">
                                                <label for="ssn">SSN</label>
                                                <input id="ssn" name="ssn" type="text" placeholder="SSN">
                                              </div>

                                              <div class="input-grp">
                                                <label for="mobile">Home Phone</label>
                                                <input id="home_phone" name="home_phone" type="tel" placeholder="Home Phone">
                                              </div>

                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                              <div class="input-grp">
                                                <label for="cell_phone">Cell Phone</label>
                                                <input id="cell_phone" name="cell_phone" type="tel" placeholder="Cell Phone">
                                              </div>
                                              <div class="input-grp">
                                                <label for="email">Email Address</label>
                                                <input id="email" name="email" type="email" placeholder="Email Address" required>
                                              </div>

                                              <div class="input-grp">
                                                <label for="Position">Position</label>
                                                <input id="position" name="position" type="text" placeholder="Position" required>
                                              </div>
                                          </div>
                                      
                                         
                                      
                                          <div class="input-grp checkbox">
                                            <label>Inactive <input id="inactive" name="inactive" type="checkbox"> </label>
                                          </div>
                                    </div>

                                    <div class="new-request-form">
                                        <h3>Address Details</h3>
                                        <div class="multi-input-grp grp-2-1 grp-3">
                                            <div class="input-grp input-full">
                                              <label for="address_line1">Address</label>
                                              <input id="address" name="address" type="text" placeholder="Address" required>
                                            </div>
                                           <div class="input-grp">
                                              <label for="city">City</label>
                                              <select id="city" name="city" required>
                                                <option value="" disabled selected>City Name</option>
                                                <option value="Mumbai">Mumbai</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Tel Aviv">Tel Aviv</option>
                                                <option value="Jerusalem">Jerusalem</option>
                                                <option value="New York">New York</option>
                                                <option value="Los Angeles">Los Angeles</option>
                                            </select>
                                            </div>
                                           
                                          </div>
                                        
                                          <div class="multi-input-grp grp-3">
                                           
                                            <div class="input-grp">
                                              <label for="zip_code">Zip Code</label>
                                              <input id="zip_code" name="zip_code" type="text" inputmode="numeric" placeholder="Zip Code" required>
                                            </div>
                                        
                                            <div class="input-grp">
                                              <label for="nationality">Country</label>
                                              <select id="country" name="country" required>
                                                  <option value="" disabled selected>Country</option>
                                                  <option value="India">India</option>
                                                  <option value="Israel">Israel</option>
                                                  <option value="USA">USA</option>
                                              </select>
                                            </div>
                                          </div>
                                    </div>

                                    <div class="form-submission btn-sm align-right">
                                        
                                        <button type="submit" class="cmn-btn btn-sm ">Save Teacher</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
@endsection