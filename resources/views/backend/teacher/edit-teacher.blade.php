@extends('backend.master')

@section('title')
{{ ___('common.School Management System | Teacher') }}
@endsection

@section('content')
<div class="dashboard-body dspr-body-outer">
                    <div class="ds-breadcrumb">
                        <h1>Edit Teacher</h1>
                        <ul>
                            <li><a href="../dashboard">Dashboard</a> /</li>
                            <li><a href="{{route('teacher.index')}}">Teachers</a> /</li>
                            <li><a href="./profile">Teachers Info</a> /</li>
                            <li>Edit Teacher</li>
                        </ul>
                        <button  class="cmn-btn" >
                           <img src="{{global_asset('backend/assets/images/new_images/lets-icons_back.png')}}" alt="Back" />
                             Back
                        </button>
                    </div>
                    <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            <div class="request-leave-form spradmin">
                                <form action="{{ route('teacher.update', $teacher->id) }}" enctype="multipart/form-data" method="POST" >
                                    @csrf
                                    @method('PUT')

                                    <div class="new-request-form">
                                        <h3>Edit Teacher Details</h3>
                                        <div class="input-grp h48">
                                            <label>Image Link</label>
                                            <div class="floating-input-btn input-grp w-70">
                                                <div class="has-submit">
                                                    <label class="file-label">
                                                        <span class="file-text">
                                                            @if($teacher->upload)
                                                                <a href="{{ asset($teacher->upload->path) }}" target="_blank">
                                                                    {{ $teacher->upload->path }}
                                                                </a>
                                                            @else
                                                                No file chosen
                                                            @endif
                                                        </span>
                                                        <input type="file" id="fileUpload" name="fileUpload" />
                                                    </label>
                                                    <input type="submit" value="Upload" class="btn-upload" />
                                                </div>
                                              </div>
                                        </div>
                                        <div class="multi-input-grp grp-3">
                                             <div class="input-grp">
                                              <label for="Title">Title</label>
                                              <input id="title" name="title" type="text"  value="{{ old('title', $teacher->title) }}" required>
                                            </div>

                                            <div class="input-grp">
                                              <label for="first_name">First Name</label>
                                              <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $teacher->first_name) }}"  required>
                                            </div>
                                            <div class="input-grp">
                                              <label for="last_name">Last Name</label>
                                              <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $teacher->last_name) }}" required>
                                            </div>
                                           
                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                                <label for="hebrew_title">Hebrew Title</label>
                                                <input id="hebrew_title" name="hebrew_title" type="text" value="{{ old('hebrew_title', $teacher->hebrew_title) }}" >
                                             </div>
                                            <div class="input-grp">
                                              <label for="hebrew_first_name">Hebrew First Name</label>
                                              <input id="hebrew_first_name" name="hebrew_first_name" type="text" value="{{ old('hebrew_first_name', $teacher->hebrew_first_name) }}">

                                              
                                            </div>
                                             <div class="input-grp">
                                                <label for="hebrew_last_name">Hebrew Last Name</label>
                                                <input id="hebrew_last_name" name="hebrew_last_name" type="text" value="{{ old('hebrew_last_name', $teacher->hebrew_last_name) }}">
                                             </div>
                                            <div class="input-grp">
                                              <label for="ID">ID</label>
                                              <input id="identification_number" name="identification_number" type="text" value="{{ old('identification_number', $teacher->identification_number) }}">
                                            </div>
                                            <div class="input-grp">
                                              <label for="dob">Birth Date</label>
                                              <input id="dob" name="dob" type="date" value="{{ old('dob', $teacher->dob) }}" required>
                                            </div>

                                            <div class="input-grp">
                                              <label for="hebrew_dob">Hebrew Birthday</label>
                                              <input id="hebrew_dob" name="hebrew_dob" type="date" value="{{ old('hebrew_dob', $teacher->hebrew_dob) }}">
                                            </div>
                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                            
                                           <div class="input-grp">
                                              <label for="Neighborhood">Neighborhood</label>
                                              <input id="neighborhood" name="neighborhood" type="text" value="{{ old('neighborhood', $teacher->neighborhood) }}">
                                            </div>

                                            <div class="input-grp">
                                              <label for="ssn">SSN</label>
                                              <input id="ssn" name="ssn" type="text" value="{{ old('ssn', $teacher->ssn) }}">
                                            </div>

                                            <div class="input-grp">
                                              <label for="home_phone">Home Phone</label>
                                              <input id="home_phone" name="home_phone" type="tel" value="{{ old('home_phone', $teacher->phone) }}">
                                            </div>

                                          </div>
                                      
                                          <div class="multi-input-grp grp-3">
                                            <div class="input-grp">
                                              <label for="cell_phone">Cell Phone</label>
                                              <input id="cell_phone" name="cell_phone" type="tel" value="{{ old('cell_phone', $teacher->cell_phone) }}">
                                            </div>
                                            <div class="input-grp">
                                              <label for="email">Email Address</label>
                                              <input id="email" name="email" type="email" placeholder="Email Address" value="{{ old('email', $teacher->email) }}" required>
                                            </div>

                                             <div class="input-grp">
                                              <label for="Position">Position</label>
                                              <input id="position" name="position" type="text" placeholder="Position" value="{{ old('position', $teacher->position) }}" required>
                                            </div>
                                            
                                          </div>
                                      
                                         
                                      
                                          <div class="input-grp checkbox">
                                            <label>Inactive <input id="inactive" name="inactive" type="checkbox" value="1" {{ old('inactive', $teacher->inactive) ? 'checked' : '' }} > </label>
                                          </div>
                                    </div>

                                    <div class="new-request-form">
                                        <h3>Address Details</h3>
                                        <div class="multi-input-grp grp-2-1 grp-3">
                                            <div class="input-grp input-full">
                                              <label for="address">Address</label>
                                              <input id="address" name="address" type="text" value="{{ old('address', $teacher->current_address) }}" required>
                                            </div>
                                           <div class="input-grp">
                                              <label for="city">City</label>
                                               <select id="city" name="city" required>
                                                  <option value="" disabled {{ old('city', $teacher->city) ? '' : 'selected' }}>City Name</option>
                                                  <option value="Mumbai" {{ old('city', $teacher->city) == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                                                  <option value="Delhi" {{ old('city', $teacher->city) == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                                  <option value="Tel Aviv" {{ old('city', $teacher->city) == 'Tel Aviv' ? 'selected' : '' }}>Tel Aviv</option>
                                                  <option value="Jerusalem" {{ old('city', $teacher->city) == 'Jerusalem' ? 'selected' : '' }}>Jerusalem</option>
                                                  <option value="New York" {{ old('city', $teacher->city) == 'New York' ? 'selected' : '' }}>New York</option>
                                                  <option value="Los Angeles" {{ old('city', $teacher->city) == 'Los Angeles' ? 'selected' : '' }}>Los Angeles</option>
                                              </select>
                                            </div>
                                           
                                          </div>
                                        
                                          <div class="multi-input-grp grp-3">
                                           
                                        
                                            <div class="input-grp">
                                              <label for="zip_code">Zip Code</label>
                                              <input id="zip_code" name="zip_code" type="text" inputmode="numeric"value="{{ old('zip_code', $teacher->zip_code) }}" required>
                                            </div>
                                        
                                            <div class="input-grp">
                                              <label for="country">Country</label>
                                               <select id="country" name="country" required>
                                                  <option value="" disabled {{ old('country', $teacher->country) ? '' : 'selected' }}>Country</option>
                                                  <option value="India" {{ old('country', $teacher->country) == 'India' ? 'selected' : '' }}>India</option>
                                                  <option value="Israel" {{ old('country', $teacher->country) == 'Israel' ? 'selected' : '' }}>Israel</option>
                                                  <option value="USA" {{ old('country', $teacher->country) == 'USA' ? 'selected' : '' }}>USA</option>
                                              </select>
                                            </div>
                                          </div>
                                    </div>

                                    <div class="form-submission btn-sm align-right">
                                        {{-- <input type="submit" value="Save Teacher"> --}}
                                        <button type="submit" class="cmn-btn btn-sm ">Save Teacher</button>

                                    </div>
                                </form>  
                            </div>

                        </div>
                    </div>
                </div>
@endsection