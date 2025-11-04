@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
<div class="dashboard-body dspr-body-outer">
                  

                    <div class="ds-breadcrumb">
                        <h1>High School Contacts</h1>
                        <ul>
                            <li><a href="../dashboard.html">Dashboard</a> /</li>
                            <li><a href="../dashboard.html">Application</a> /</li>
                            <li><a href="../dashboard.html">Applicants List</a> /</li>
                            <li><a href="../dashboard.html">Applicant Info</a> /</li>
                            <li>High School Contacts</li>
                        </ul>
                    </div>
                    <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                
                                <form>
                                  
                                    <div class="new-request-form">
                                       <h3>High School Information</h3>

                                        <div class="multi-input-grp grp-3">
                                          
                                            <div class="input-grp">
                                                <label>ID</label>
                                                <input type="text" placeholder="ID">
                                            </div>
                                            
                                            <div class="input-grp">
                                                <label>Abbreviation </label>
                                                <input type="text" placeholder="last Name">
                                            </div>

                                            <div class="input-grp">
                                                <label>Full Name </label>
                                                <input type="text" placeholder="First Name">
                                            </div>

                                            <div class="input-grp">
                                                <label>Address </label>
                                                <input type="text" placeholder="Address">
                                            </div>
                                            <div class="input-grp">
                                                <label>City</label>
                                                <input type="text" placeholder="City">
                                            </div>
                                            <div class="input-grp">
                                                <label>State </label>
                                                <input type="text" placeholder="State">
                                            </div>
                                            <div class="input-grp">
                                                <label>Zip Code </label>
                                                <input type="text" placeholder="Zip Code">
                                            </div>
                                            <div class="input-grp">
                                                <label>Country </label>
                                                <input type="text" placeholder="Country">
                                            </div>
                                            <div class="input-grp">
                                                <label>Region </label>
                                                <input type="text" placeholder="Region">
                                            </div>
                                            <div class="input-grp">
                                                <label>Phone </label>
                                                <input type="text" placeholder="Phone">
                                            </div>
                                            <div class="input-grp">
                                                <label>Email </label>
                                                <input type="text" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                         <h3>Additional School Phone Numbers</h3>

                                         <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add Affiliation  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>

                                        <div class="cmn-form-row brdr-primary">
                                            

                                            <div class="cmn-box-style ">
                                                <div class="multi-input-grp grp-3">
                                                    <div class="input-grp">
                                                        <label>Type </label>
                                                       <select name="" id="">
                                                        <option value="">Type</option>
                                                       </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Contact Info </label>
                                                        <input type="text">
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Primary </label>
                                                        <input type="text" placeholder="Primary">
                                                    </div>

                                                    <div class="input-grp">
                                                        <label for="comment">Comment</label>
                                                        <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Enter Comments"></textarea>
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

                                      <div class="new-request-form">
                                         <h3>Additional Email ID</h3>

                                         <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>

                                        <div class="cmn-form-row">
                                            

                                            <div class="cmn-box-style">
                                                <div class="multi-input-grp grp-3">
                                                    <div class="input-grp">
                                                        <label>Type</label>
                                                       <select name="" id="">
                                                        <option value="">Type</option>
                                                       </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Contact Info</label>
                                                        <select name="" id="">
                                                            <option value="">contact info</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Primary </label>
                                                       <select name="" id="">
                                                            <option value="">Primary</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-grp">
                                                        <label for="comment">Comment</label>
                                                        <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Enter Comments"></textarea>
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

                                    <div class="new-request-form">
                                         <h3>Contacts for this High School</h3>

                                         <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>

                                        <div class="cmn-form-row">
                                            

                                            <div class="cmn-box-style">
                                                <div class="multi-input-grp grp-3">
                                                    <div class="input-grp">
                                                        <label>Contact</label>
                                                       <select name="" id="">
                                                        <option value="">Type</option>
                                                       </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Open</label>
                                                        <select name="" id="">
                                                            <option value="">Open</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Position </label>
                                                       <input type="text" name="" id="">
                                                    </div>
                                                     <div class="input-grp">
                                                        <label>Home Phone </label>
                                                       <input type="text" name="Home Phone" id="">
                                                    </div>
                                                     <div class="input-grp">
                                                        <label>Cell Phone </label>
                                                       <input type="text" name="Cell Phone" id="">
                                                    </div>
                                                     <div class="input-grp">
                                                        <label>Email </label>
                                                       <input type="text" name="Email" id="">
                                                    </div>

                                                    <div class="input-grp">
                                                        <label for="comment">Comment</label>
                                                        <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Enter Comments"></textarea>
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

                                       <div class="new-request-form">
                                         <h3>Application Amount for this High School</h3>

                                         <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>

                                        <div class="cmn-form-row">
                                            

                                            <div class="cmn-box-style">
                                                <div class="multi-input-grp grp-2">
                                                    <div class="input-grp">
                                                        <label>Application Year</label>
                                                       <select name="" id="">
                                                        <option value="">Application Year</option>
                                                       </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Amount</label>
                                                        <input type="text" name="" id="">
                                                    </div>
                                                  
                                                    <div class="input-grp">
                                                        <label for="comment">Comment</label>
                                                        <textarea id="comment" name="comment" cols="50" rows="10" placeholder="Enter Comments"></textarea>
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


                                    <div class="form-submission btn-sm align-right">
                                        <input type="submit" value="Save Info">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

@endsection