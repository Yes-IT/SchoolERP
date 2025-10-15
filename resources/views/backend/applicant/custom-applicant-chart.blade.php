@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
            <div class="ds-breadcrumb">
                <h1>Custom Applicant Chart</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="#">Application</a> /</li>
                     <li>Applicantion Report </li>
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
                            <h2>Applicant Chart</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0 align-items-start">
                                <div class="input-grp search-field mb-0">
                                    <input type="text" id="searchInput" placeholder="Search ">
                                    <input type="submit" value="Search" id="searchButton">
                                </div>
                                <a href="#url" class="cmn-btn btn-sm flex-shrink-0"><img src="{{global_asset('backend/assets/images/mi_filter.svg')}}" alt=""> Filter</a>
                               
                                
                            </div>
                        </div>
                    </div>

                    <div class="ds-cmn-tble count-row tbl-5_4k">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>View</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>High School</th>  
                                    <th>City</th>
                                    <th>F</th>
                                    <th>T</th>
                                    <th>SK</th>
                                    <th>Ave</th>
                                    <th>Initial</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>Final</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Coming</th>
                                    <th>Birthdate</th>
                                    <th>Age</th>
                                    <th>Marital Status</th>
                                    <th>Father Occupation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td>1</td>
                                  <td><a href="#" class="view-attachment-btn">
                                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                    </a></td>
                                  <td>Lorem ipsum</td>
                                  <td>Lorem ipsum dolor sit amet</td>
                                  <td>Baltimore</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><span class="cmn-tbl-btn red-bg">Not Accepted</span></td>
                                  <td>Lorem</td>
                                  <td>yes</td>
                                  <td>04/01/2025</td>
                                  <td>1</td>
                                  <td>Married</td>
                                  
                                  <td>
                                    <div class="actions-wrp">
                                        <a href="#">
                                            <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Edit">
                                        </a>
                                         <a href="#">
                                            <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Delete">
                                        </a>
                                    </div>
                                  </td>
                                </tr>
                                 <tr>
                                  <td>2</td>
                                  <td><a href="#" class="view-attachment-btn">
                                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                    </a></td>
                                  <td>Lorem ipsum</td>
                                  <td>Lorem ipsum dolor sit amet</td>
                                  <td>Baltimore</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><span class="cmn-tbl-btn green-bg"> Accepted</span></td>
                                  <td>Lorem</td>
                                  <td>yes</td>
                                  <td>04/01/2025</td>
                                  <td>1</td>
                                  <td>Married</td>
                                  
                                  <td>
                                    <div class="actions-wrp">
                                        <a href="#">
                                            <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Edit">
                                        </a>
                                         <a href="#">
                                            <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Delete">
                                        </a>
                                    </div>
                                  </td>
                                </tr>
                                 <tr>
                                  <td>3</td>
                                  <td><a href="#" class="view-attachment-btn">
                                        <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
                                    </a></td>
                                  <td>Lorem ipsum</td>
                                  <td>Lorem ipsum dolor sit amet</td>
                                  <td>Baltimore</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><span class="cmn-tbl-btn yellow-bg">Pending</span></td>
                                  <td>Lorem</td>
                                  <td>yes</td>
                                  <td>04/01/2025</td>
                                  <td>1</td>
                                  <td>Married</td>
                                  
                                  <td>
                                    <div class="actions-wrp">
                                        <a href="#">
                                            <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Edit">
                                        </a>
                                         <a href="#">
                                            <img src="{{ global_asset('backend/assets/images/bin-icon.svg') }}" alt="Delete">
                                        </a>
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