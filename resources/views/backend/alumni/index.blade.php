@extends('backend.master')

@section('title')

  
{{ ___('common.School Management System | Alumni') }}

@endsection

@section('content')
  
      

           <div class="ds-breadcrumb">
                <h1>Alumni</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="./dashboard.html">Alumni</a> /</li>
                    <li>Alumni List</li>
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
                                <div class="atndnc-filter-options grp-3 multi-input-grp">
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
                                    <div class="input-grp">
                                        <select>
                                            <option value="select-year">Select Semester</option>
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
                            <h2>Alumni List</h2>

                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0">
                                <div class="dropdown-year" data-selected="Select Student">
                                    <div class="dropdown-trigger">
                                      <span class="dropdown-label">Select Alumni</span>
                                      <i class="dropdown-arrow"></i>
                                    </div>
                                    <div class="dropdown-options">
                                      <div class="dropdown-option">Alumni 1</div>
                                      <div class="dropdown-option">Alumni 2</div>
                                      <div class="dropdown-option">Alumni 3</div>
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
                                            <th>Current Name</th>
                                            <th>School Year</th>
                                            <th>Year Status</th>
                                            <th>Marital Status</th>
                                            <th>Date Married</th>
                                            <th>Current Address</th>

                                            <th>Current City</th>
                                            <th>Current State</th>
                                            <th>Current Zipcode</th>
                                            <th>Current Country</th>
                                            <th>Current Home Phone</th>
                                            <th>Cell Phone</th>

                                            <th>Email</th>
                                            <th>Student Last Name</th>
                                            <th>First Name</th>
                                            <th>Parents</th>
                                            <th>Parents Address</th>
                                            <th>Parents City</th>
                                            <th>Parents State</th>
                                            <th>Parents Zipcode</th>
                                            <th>Parents Country</th>
                                            <th>Parents Home Phone</th>

                                            <th>Updated Last Name</th>
                                            <th>Updated Title Name</th>
                                            <th>Husband Name</th>
                                            <th>Husband Title</th>
                                            <th>Updated Address</th>
                                            <th>Updated City</th>
                                            <th>Updated State</th>

                                            <th>Updated Zip Code</th>
                                            <th>Updated Country</th>
                                            <th>Updated Home Phone</th>
                                            <th>High School</th>
                                            <th>Birth Date</th>
                                            <th>Hold Transcript</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                            <td>1</td>
                                            <td>lorem ipsum</td>
                                            <td>2024-2025</td>
                                            <td>shana lll</td>
                                            <td>lorem</td>
                                            <td>12/12/2024</td>
                                            <td>lorem</td>

                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>243435</td>
                                            <td>lorem</td>
                                            <td>23344322</td>
                                            <td>22333421</td>

                                            <td>example@gmail.com</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>63772</td>
                                            <td>lorem</td>
                                            <td>3393392873</td>

                                            <td>--</td>
                                            <td>--</td>
                                            <td>---</td>
                                            <td>--</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>---</td>

                                            <td>---</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>--</td>
                                            <td>12/12/2024</td>
                                            <td></td>

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

