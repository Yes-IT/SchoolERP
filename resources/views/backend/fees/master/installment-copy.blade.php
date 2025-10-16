@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .number-of-installment {
        margin-top: 15px;
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    .number-of-installment select {
        width: 170px;
    }

    .installment-form {
        margin-top: 10px;
    }

    .installment-form h3 {
        color: var(--primary-clr);
        font-size: 18px;
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
                <h1>Fees Master</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Additional Fees</a> /</li>
                    <li>Fees Master</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">

                    <div class="dsbdy-cmn-card w55">
                        <div class="sec-head">
                            <h2>Create Fees Master</h2>
                        </div>
                        <div class="request-leave-form-wrp fees-master-form-wrp">
                            <form>
                                <div class="request-leave-form fees-master-form">
                                    <div class="multi-input-grp">
                                        <div class="input-grp">
                                            <label>Fees Group</label>
                                            <select>
                                                <option value="Select Fees Group">Select Fees Group</option>
                                                <option value="group-1">Group 1</option>
                                                <option value="group-2">Group 2</option>
                                            </select>
                                        </div>
                                        <div class="input-grp">
                                            <label>Fees Type</label>
                                            <select>
                                                <option value="Select Fees Type">Select Fees Type</option>
                                                <option value="type-1">Type 1</option>
                                                <option value="type-2">Type 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-grp">
                                        <label>Total Amount</label>
                                        <input type="text" placeholder="Enter total amount">
                                    </div>
                                    <div class="input-grp">
                                        <div class="installment-toggle">
                                            <input id="enable-installments" class="toggle-input" type="checkbox" />
                                            <label for="enable-installments" class="toggle-label">
                                                <span class="toggle-track" aria-hidden="true">
                                                    <span class="toggle-thumb" aria-hidden="true"></span>
                                                </span>
                                                <span class="toggle-text">Enable installments</span>
                                            </label>
                                        </div>
                                        <div class="number-of-installment">
                                            <div class="installment-select">
                                                <select>
                                                    <option>2</option>
                                                    <option value="group-1">Group 1</option>
                                                    <option value="group-2">Group 2</option>
                                                </select>
                                            </div>

                                            <div class="installment-toggle">
                                                <input id="enable-installments" class="toggle-input" type="checkbox" />
                                                <label for="enable-installments" class="toggle-label"
                                                    style="position:relative; top:10px;">
                                                    <span class="toggle-track" aria-hidden="true">
                                                        <span class="toggle-thumb" aria-hidden="true"></span>
                                                    </span>
                                                    <span class="toggle-text">Enable installments</span>
                                                </label>
                                            </div>



                                        </div>
                                        <div class="installment-form">
                                            <h3>Installments</h3>
                                            <hr>


                                        </div>




                                    </div>
                                    <div class="btn-wrp justify-content-start">
                                        <!-- <button type="button" class="cmn-btn btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button> -->
                                        <button type="submit" class="cmn-btn btn-sm w-100">Save Fees Master</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dsbdy-cmn-card w45">
                        <div class="sec-head">
                            <h3 class="h2-title">Summary Review</h3>
                        </div>
                        <div class="dsprprofile-course-info p-0">
                            <table>
                                <tr>
                                    <td>Fees Group:</td>
                                    <td>Lorem Ipsum</td>
                                </tr>
                                <tr>
                                    <td>Fees Type:</td>
                                    <td>Lorem Ipsum</td>
                                </tr>
                                <tr>
                                    <td>Total Amount:</td>
                                    <td>$100</td>
                                </tr>
                                <tr>
                                    <td>Installments:</td>
                                    <td>1</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                    <div class="ds-content-head">
                        <div class="sec-head">
                            <h3 class="h2-title">Existing Fees Masters</h3>
                        </div>
                        <div class="btn-wrp align-items-start">
                            <div class="input-grp search-field mb-0">
                                <input type="text" placeholder="Search Group">
                                <input type="submit" value="Search">
                            </div>
                        </div>
                    </div>

                    <div class="ds-cmn-tble count-row">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Fees Group</th>
                                    <th>Fees Type</th>
                                    <th>Total Amount</th>
                                    <th>Installments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0</td>
                                    <td>Lorem ipsum</td>
                                    <td>Lorem ipsum</td>
                                    <td>$500</td>
                                    <td>5</td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn green-bg">Active</div>
                                    </td>
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editLeaveRequest">
                                                <img src="{{ asset('images/fees/edit-icon-primary.svg') }}"
                                                    alt="Edit">
                                            </button>

                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteLeaveRequest"><img
                                                    src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon"></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0</td>
                                    <td>Lorem ipsum</td>
                                    <td>Lorem ipsum</td>
                                    <td>$500</td>
                                    <td>5</td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn green-bg">Active</div>
                                    </td>
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editLeaveRequest">
                                                <img src="{{ asset('images/fees/edit-icon-primary.svg') }}"
                                                    alt="Edit">
                                            </button>

                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteLeaveRequest"><img
                                                    src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon"></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0</td>
                                    <td>Lorem ipsum</td>
                                    <td>Lorem ipsum</td>
                                    <td>$500</td>
                                    <td>5</td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn green-bg">Active</div>
                                    </td>
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editLeaveRequest">
                                                <img src="{{ asset('images/fees/edit-icon-primary.svg') }}"
                                                    alt="Edit">
                                            </button>

                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteLeaveRequest"><img
                                                    src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon"></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0</td>
                                    <td>Lorem ipsum</td>
                                    <td>Lorem ipsum</td>
                                    <td>$500</td>
                                    <td>5</td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn btn-disabled">Inactive</div>
                                    </td>
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editLeaveRequest">
                                                <img src="{{ asset('images/fees/edit-icon-primary.svg') }}"
                                                    alt="Edit">
                                            </button>

                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteLeaveRequest"><img
                                                    src="{{ asset('images/fees/bin-icon.svg') }}"
                                                    alt="Icon"></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0</td>
                                    <td>Lorem ipsum</td>
                                    <td>Lorem ipsum</td>
                                    <td>$500</td>
                                    <td>5</td>
                                    <td>
                                        <div class="upcoming cmn-tbl-btn green-bg">Active</div>
                                    </td>
                                    <td>
                                        <div class="actions-wrp">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editLeaveRequest">
                                                <img src="{{ asset('images/fees/edit-icon-primary.svg') }}"
                                                    alt="Edit">
                                            </button>

                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteLeaveRequest"><img
                                                    src="{{ asset('images/fees/bin-icon.svg') }}"
                                                    alt="Icon"></button>
                                        </div>
                                    </td>
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
