@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
            <div class="ds-breadcrumb">
                <h1>Student Application Forms</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="#">Student Application Forms</a> /</li>
                    
                </ul>
            </div>
            <div class="ds-pr-body">
                
                <div class="atndnc-filter-wrp w-100">
                    <div class="sec-head">
                        <h2>Filters</h2>
                    </div>
                    <div class="atndnc-filter student-filter">
                        <form>
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options multi-input-grp">
                                    <div class="input-grp">
                                        <select>
                                            <option value="select-year">Select Year</option>
                                            <option value="2024">2024</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <select>
                                            <option value="select-year">Select Year Status</option>
                                            <option value="2024">2024</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Search Button -->
                                <button type="submit" class="btn-search">Search</button>
                            </div>
                        </form>
                    </div> 
                </div>

                <div class="ds-cmn-table-wrp">
                    
                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Application Forms List</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Select Student">
                                    <div class="dropdown-trigger">
                                      <span class="dropdown-label">Select Student</span>
                                      <i class="dropdown-arrow"></i>
                                    </div>
                                    <div class="dropdown-options">
                                      <div class="dropdown-option">Student 1</div>
                                      <div class="dropdown-option">Student 2</div>
                                      <div class="dropdown-option">Student 3</div>
                                    </div>
                                  </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="ds-cmn-tble count-row tbl-5_4k">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>High School</th>
                                    <th>High School (Application)</th>
                                    <th>City</th>
                                    <th>Birth Date</th>
                                    <th>Age</th>
                                    <th>USA Cell</th>
                                    <th>Email</th>
                                    <th>Father Title</th>
                                    <th>Father Name</th>
                                    <th>Mother Title</th>
                                    <th>Mother Name</th>
                                    <th>Maiden Name</th>
                                    <th>Address</th>
                                    <th>Current State</th>
                                    <th>Current Zipcode</th>
                                    <th>Current Country</th>
                                    <th>Marital Status</th>
                                    <th>Marital Comment</th>
                                    <th>Home Phone</th>
                                    <th>Father Cell</th>
                                    <th>Mother Cell</th>
                                    <th>Father Email</th>
                                    <th>Mother Email</th>
                                    <th>Interview Status</th>
                                    <th>Interview Mode</th>
                                    <th>Interview Date</th>
                                    <th>Interview Time</th>
                                    <th>Interview Location</th>
                                    <th>Meeting Link</th>
                                    <th>Interview Action</th>
                                    <th>Applicant Status</th>
                                    <th>Applicant Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>High School Diploma</td>
                                  <td>Central HS</td>
                                  <td>Parent One</td>
                                  <td>2006-03-12</td>
                                  <td>א׳ ניסן תשס״ו</td>
                                  <td>USA</td>
                                  <td>000-00-0001</td>
                                  <td>USA</td>
                                  <td>P0000001</td>
                                  <td>IPSUM LOREM</td>
                                  <td>USA</td>
                                  <td>2030-01-01</td>
                                  <td>123456789</td>
                                  <td>Yes</td>
                                  <td>Full</td>
                                  <td>lorem.ipsum1@example.com</td>
                                  <td>+1-555-000-0001</td>
                                  <td>+972-50-000-0001</td>
                                  <td>123 Example St</td>
                                  <td>USA</td>
                                  <td>+1-555-111-0001</td>
                                  <td>No</td>
                                  <td>/images/lorem1.jpg</td>
                                  <td>10A</td>
                                  <td>Group 1</td>
                                  <td>Division A</td>
                                  <td>2</td>
                                  <td>201</td>
                                  <td>Signed</td>
                                  <td>Received</td>
                                  <td>Submitted</td>
                                  <td>
                                    <a href="#url" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Image"> Reschedule Interview</a>
                                  </td>
                                  <td><span class="cmn-tbl-btn yellow-bg">Pending</span></td>
                                  <td>
                                    <div class="actions-wrp">
                                        <button type="button" class="cmn-tbl-btn green-bg"><i class="fa-solid fa-check"></i> Approve</button>
                                        <button type="button" class="cmn-tbl-btn red-bg"><i class="fa-solid fa-xmark"></i> Reject</button>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>High School Diploma</td>
                                    <td>Central HS</td>
                                    <td>Parent One</td>
                                    <td>2006-03-12</td>
                                    <td>א׳ ניסן תשס״ו</td>
                                    <td>USA</td>
                                    <td>000-00-0001</td>
                                    <td>USA</td>
                                    <td>P0000001</td>
                                    <td>IPSUM LOREM</td>
                                    <td>USA</td>
                                    <td>2030-01-01</td>
                                    <td>123456789</td>
                                    <td>Yes</td>
                                    <td>Full</td>
                                    <td>lorem.ipsum1@example.com</td>
                                    <td>+1-555-000-0001</td>
                                    <td>+972-50-000-0001</td>
                                    <td>123 Example St</td>
                                    <td>USA</td>
                                    <td>+1-555-111-0001</td>
                                    <td>No</td>
                                    <td>/images/lorem1.jpg</td>
                                    <td>10A</td>
                                    <td>Group 1</td>
                                    <td>Division A</td>
                                    <td>2</td>
                                    <td>201</td>
                                    <td>Signed</td>
                                    <td>Received</td>
                                    <td>Submitted</td>
                                    <td>
                                      <a href="#url" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Image"> Reschedule Interview</a>
                                    </td>
                                    <td><span class="cmn-tbl-btn yellow-bg">Pending</span></td>
                                    <td>
                                      <div class="actions-wrp">
                                          <button type="button" class="cmn-tbl-btn green-bg"><i class="fa-solid fa-check"></i> Approve</button>
                                          <button type="button" class="cmn-tbl-btn red-bg"><i class="fa-solid fa-xmark"></i> Reject</button>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>High School Diploma</td>
                                    <td>Central HS</td>
                                    <td>Parent One</td>
                                    <td>2006-03-12</td>
                                    <td>א׳ ניסן תשס״ו</td>
                                    <td>USA</td>
                                    <td>000-00-0001</td>
                                    <td>USA</td>
                                    <td>P0000001</td>
                                    <td>IPSUM LOREM</td>
                                    <td>USA</td>
                                    <td>2030-01-01</td>
                                    <td>123456789</td>
                                    <td>Yes</td>
                                    <td>Full</td>
                                    <td>lorem.ipsum1@example.com</td>
                                    <td>+1-555-000-0001</td>
                                    <td>+972-50-000-0001</td>
                                    <td>123 Example St</td>
                                    <td>USA</td>
                                    <td>+1-555-111-0001</td>
                                    <td>No</td>
                                    <td>/images/lorem1.jpg</td>
                                    <td>10A</td>
                                    <td>Group 1</td>
                                    <td>Division A</td>
                                    <td>2</td>
                                    <td>201</td>
                                    <td>Signed</td>
                                    <td>Received</td>
                                    <td>Submitted</td>
                                    <td>
                                      <a href="./schedule-interview.html" class="cmn-btn btn-sm"><img src="{{global_asset('backend/assets/images/calender-icon.svg')}}" alt="Image"> Schedule Interview</a>
                                    </td>
                                    <td><span class="cmn-tbl-btn red-bg">Rejected</span></td>
                                    <td>
                                      <div class="actions-wrp">
                                          <button type="button" class="cmn-tbl-btn btn-disabled"><i class="fa-solid fa-check"></i> Approve</button>
                                          <button type="button" class="cmn-tbl-btn btn-disabled"><i class="fa-solid fa-xmark"></i> Reject</button>
                                      </div>
                                    </td>
                                  </tr>
                              </tbody>
                        </table>
                    </div>

                    <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            <ul>
                                <li><a href="#url"><img src="{{global_asset('backend/assets/images/arrow-left.svg')}}" alt="Icon"></a></li>
                                <li class="active"><a href="#url">1</a></li>
                                <li><a href="#url">2</a></li>
                                <li><a href="#url">3</a></li>
                                <li><a href="#url"><img src="{{global_asset('backend/assets/images/arrow-right.svg')}}" alt="Icon"></a></li>
                            </ul>
                        </div>

                        <div class="pages-select">
                            <form>
                                <div class="formfield">
                                    <label>Per page</label>
                                    <select>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </form>
                            <p>of 2 results</p>
                        </div>
                    </div>
                </div>
                  
            </div>



@endsection