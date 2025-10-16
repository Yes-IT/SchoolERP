@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .multi-input-grp {
        display: flex;
        gap: 20px;
        /* space between inputs */
    }

    .multi-input-grp .input-grp {
        flex: 1;
        /* make them equal width */
        display: flex;
        flex-direction: column;
    }
</style>

@section('content')


    <div class="dashboard-main light-bg">

        <!-- Sidebar Begin -->

        @include('backend.partials.sidebar')
        <!-- End Of Sidebar -->

        <!-- Dashboard Body Begin -->

        <div class="dashboard-body dspr-body-outer">
            <div class="dashboard-body-head">
                <div class="dsbdy-head-left">
                    <div class="dsbdy-search-form">
                        <div class="input-grp search-field">
                            <input type="text" placeholder="Search Page">
                            <input type="submit" value="Search">
                        </div>
                    </div>
                </div>
                <div class="dsbdy-head-right">
                    <button class="tgl-flscrn" aria-label="Toggle fullscreen">
                        <img src="{{ asset('images/fees/fullscreen-toggler-icon.svg') }}" alt="Icon">
                    </button>
                    <div class="profile-ctrl">
                        <button class="profile-ctrl-toggler">
                            <div class="pr-pic">
                                <img src="{{ asset('images/fees/profile-picture.png') }}" alt="Profile Picture">
                            </div>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="pr-ctrl-menu">
                            <ul>
                                <li><a href="profile.html">My Profile</a></li>
                                <li><a href="../../set-password.html">Change Password</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ds-breadcrumb">
                <h1>Assigning Fees to Students</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Additional Fees</a> /</li>
                    <li>Assigning Fees to Students</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">

                    <div class="dsbdy-cmn-card w55" style="width:1500px;">
                        <div class="sec-head">
                            <h2>Filter Students</h2>
                        </div>
                        <div class="request-leave-form-wrp fees-master-form-wrp">
                            <form>
                                <div class="request-leave-form fees-master-form">
                                    <div class="multi-input-grp">
                                        <div class="input-grp">
                                            <label>Class</label>
                                            <select>
                                                <option value="Select Fees Group">Class</option>
                                                <option value="group-1">Group 1</option>
                                                <option value="group-2">Group 2</option>
                                            </select>
                                        </div>
                                        <div class="input-grp">
                                            <label>Subject</label>
                                            <select>
                                                <option value="Select Fees Type">Subject</option>
                                                <option value="type-1">Type 1</option>
                                                <option value="type-2">Type 2</option>
                                            </select>
                                        </div>
                                        <div class="input-grp">
                                            <label>Fees Group</label>
                                            <select>
                                                <option value="Select Fees Type">Fees Group</option>
                                                <option value="type-1">Type 1</option>
                                                <option value="type-2">Type 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-grp" style="width: 31%;">
                                        <label>Fees Type</label>
                                        <input type="text" placeholder="Enter total amount" style="width: 400px;">
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <h3 class="h2-title">Students (0 Selected)</h3>
                            </div>
                            <div class="filters">
                                <div class="atndnc-filter-form">
                                    <div class="atndnc-filter-options multi-input-grp">
                                        <div class="input-grp search-field mb-0">
                                            <input type="text" placeholder="Search Student Name">
                                            <input type="submit" value="Search">
                                        </div>
                                        <div class="input-grp fees-type">
                                            <select>
                                                <option value="select-year">Select all</option>
                                                <option value="2024">2024</option>
                                            </select>
                                        </div>
                                        <div class="dsbdy-filter-wrp p-0 align-items-start">

                                            <a href="#url" class="cmn-btn btn-sm flex-shrink-0"><i
                                                    class="fa-solid fa-plus"></i>
                                                Assign Fees</a>
                                        </div>

                                    </div>


                                </div>




                            </div>
                        </div>

                        <div class="ds-cmn-tble count-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Student Details</th>
                                        <th>Contact</th>
                                        <th>Parents Name</th>
                                        <th>Alloted Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fa-regular fa-square"></i></td>
                                        <td>Lorem ipsumbr
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Student Id- 24646</span>
                                            
                                        </td>
                                                                            <td>example@gmail.com
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Phone No- 24646</span>
                                            
                                        </td>
                                        <td>$500</td>
                                        <td>5</td>

                                    </tr>
                                    <tr>
                                        <td><i class="fa-regular fa-square"></i></td>
                                     <td>Lorem ipsumbr
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Student Id- 24646</span>
                                            
                                        </td>
                                      <td>example@gmail.com
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Phone No- 24646</span>
                                            
                                        </td>
                                        <td>$500</td>
                                        <td>5</td>

                                    </tr>
                                    <tr>
                                        <td><i class="fa-regular fa-square"></i></td>
                                       <td>Lorem ipsumbr
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Student Id- 24646</span>
                                            
                                        </td>
                                     <td>example@gmail.com
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Phone No- 24646</span>
                                            
                                        </td>
                                        <td>$500</td>
                                        <td>5</td>

                                    </tr>
                                    <tr>
                                        <td><i class="fa-regular fa-square"></i></td>
                                         <td>Lorem ipsumbr
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Student Id- 24646</span>
                                            
                                        </td>
                                  <td>example@gmail.com
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Phone No- 24646</span>
                                            
                                        </td>
                                        <td>$500</td>
                                        <td>5</td>

                                    </tr>
                                    <tr>
                                        <td><i class="fa-regular fa-square"></i></td>
                                         <td>Lorem ipsumbr
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Student Id- 24646</span>
                                            
                                        </td>
                                       <td>example@gmail.com
                                            <br>
                                            <span style="font-size: 14px;
                                                         color: var(--primary-clr);
                                            ">Phone No- 24646</span>
                                            
                                        </td>
                                        <td>$500</td>
                                        <td>5</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tablepagination">
                            <div class="tbl-pagination-inr">
                                <ul>
                                    <li><a href="#url"><img src="{{ asset('images/fees/arrow-left.svg') }}"></a></li>
                                    <li class="active"><a href="#url">1</a></li>
                                    <li><a href="#url">2</a></li>
                                    <li><a href="#url">3</a></li>
                                    <li><a href="#url"><img src="{{ asset('images/fees/arrow-right.svg') }}"></a></li>
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
        </div>

    </div>

@endsection