@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
<div class="dashboard-body dspr-body-outer">
                  

                    <div class="ds-breadcrumb">
                        <h1>Contact Info</h1>
                        <ul>
                            <li><a href="../dashboard.html">Dashboard</a> /</li>
                            <li><a href="../dashboard.html">Application</a> /</li>
                            <li><a href="../dashboard.html">Applicants List</a> /</li>
                            <li><a href="../dashboard.html">Applicant Info</a> /</li>
                            <li>Contact Info</li>
                        </ul>
                    </div>
                    <div class="ds-pr-body">
                        <div class="ds-cmn-table-wrp">
                            
                            <div class="request-leave-form spradmin">
                                
                                <form>
                                  

                                   

                                    <div class="new-request-form">
                                       <h3>Contact Information</h3>

                                        <div class="multi-input-grp grp-3">
                                          
                                            <div class="input-grp">
                                                <label>ID</label>
                                                <input type="text" placeholder="ID">
                                            </div>
                                            
                                            <div class="input-grp">
                                                <label>Last Name </label>
                                                <input type="text" placeholder="last Name">
                                            </div>

                                            <div class="input-grp">
                                                <label>First Name </label>
                                                <input type="text" placeholder="First Name">
                                            </div>

                                            <div class="input-grp">
                                                <label>Title </label>
                                                <input type="text" placeholder="Title">
                                            </div>
                                            <div class="input-grp">
                                                <label>Home Phone </label>
                                                <input type="text" placeholder="Home Phone">
                                            </div>
                                            <div class="input-grp">
                                                <label>Cell Phone </label>
                                                <input type="text" placeholder="Cell Phone">
                                            </div>
                                            <div class="input-grp">
                                                <label>Email </label>
                                                <input type="text" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="new-request-form">
                                         <h3>Create a New Affiliation</h3>

                                         <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add Affiliation  <img
                                                    src="{{global_asset('backend/assets/images/plus-circle.svg')}}" alt="Icon">
                                        </button>

                                        <div class="cmn-form-row">
                                            

                                            <div class="cmn-box-style">
                                                <div class="multi-input-grp grp-3">
                                                    <div class="input-grp">
                                                        <label>Type of Affiliation</label>
                                                       <select name="" id="">
                                                        <option value="">Type</option>
                                                       </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Name of Affiliation </label>
                                                        <select name="" id="">
                                                            <option value="">affiliation names</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-grp">
                                                        <label>Position </label>
                                                        <input type="text" placeholder="position">
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
                                         <h3>Additional Phone Number</h3>

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
                                         <h3>Additional Email ID</h3>

                                         <button type="submit" id="add-row-btn" class="cmn-btn btn-sm">Add  <img
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


                                    <div class="form-submission btn-sm align-right">
                                        <input type="submit" value="Save Info">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

@endsection