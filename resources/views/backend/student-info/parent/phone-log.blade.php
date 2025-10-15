@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer"> 
        <div class="ds-breadcrumb">
            <h1>Parents</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Parents</a> /</li>
                <li>Phone Log</li>
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
                    
            <div class="ds-cmn-table-wrp tab-wrapper">
                <div class="ds-content-head">
                    <div class="sec-head">
                        <h2>Phone Log</h2>
                    </div>
                    <div class="ds-cmn-filter-wrp">
                        <div class="dsbdy-filter-wrp p-0">
                            <div class="dropdown-year" data-selected="Select Student">
                                <div class="dropdown-trigger">
                                  <span class="dropdown-label">Select Parent</span>
                                  <i class="dropdown-arrow"></i>
                                </div>
                                <div class="dropdown-options">
                                  <div class="dropdown-option">Parent 1</div>
                                  <div class="dropdown-option">Parent 2</div>
                                  <div class="dropdown-option">Parent 3</div>
                                </div>
                              </div>
                            
                              <a href="../student-flow/add-students.html" class="cmn-btn btn-sm"><i class="fa-solid fa-plus"></i> Add Student</a>
                        </div>
                    </div>
                </div>
                <div class="ds-cmn-tble small-tbl count-row">
                    <table>
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Secretary</th>
                                <th>Date</th>
                                <th>Assignment Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>
                                    <div class="toggle-text-wrapper">
                                        <div class="toggle-text-content">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </div>
                                      </div>
                                      
                                </td>
                                <td>
                                    <div class="actions-wrp">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editPhoneLog"><img src="{{ asset('backend') }}/assets/images/edit-icon-primary.svg" alt="Icon"></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deletePhoneLog"><img src="{{ asset('backend') }}/assets/images/bin-icon.svg" alt="Icon"></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>
                                    <div class="toggle-text-wrapper">
                                        <div class="toggle-text-content">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </div>
                                      </div>
                                      
                                </td>
                                <td>
                                    <div class="actions-wrp">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editPhoneLog"><img src="{{ asset('backend') }}/assets/images/edit-icon-primary.svg" alt="Icon"></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deletePhoneLog"><img src="{{ asset('backend') }}/assets/images/bin-icon.svg" alt="Icon"></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>
                                    <div class="toggle-text-wrapper">
                                        <div class="toggle-text-content">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </div>
                                      </div>
                                      
                                </td>
                                <td>
                                    <div class="actions-wrp">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editPhoneLog"><img src="{{ asset('backend') }}/assets/images/edit-icon-primary.svg" alt="Icon"></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deletePhoneLog"><img src="{{ asset('backend') }}/assets/images/bin-icon.svg" alt="Icon"></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>Lorem ipsum dolor sit amet </td>
                                <td>
                                    <div class="toggle-text-wrapper">
                                        <div class="toggle-text-content">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </div>
                                      </div>
                                      
                                </td>
                                <td>
                                    <div class="actions-wrp">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editPhoneLog"><img src="{{ asset('backend') }}/assets/images/edit-icon-primary.svg" alt="Icon"></button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deletePhoneLog"><img src="{{ asset('backend') }}/assets/images/bin-icon.svg" alt="Icon"></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tablepagination">
                    <div class="tbl-pagination-inr">
                        <ul>
                            <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/arrow-left.svg" alt="Icon"></a></li>
                            <li class="active"><a href="#url">1</a></li>
                            <li><a href="#url">2</a></li>
                            <li><a href="#url">3</a></li>
                            <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/arrow-right.svg" alt="Icon"></a></li>
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
    </div>
    <!-- Dashboard Body Begin -->
@endsection