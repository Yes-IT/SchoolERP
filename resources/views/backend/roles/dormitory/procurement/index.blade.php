@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .input-grp select {
        width: 150px;
        height: 44px;
        position: relative;
        left: 159px;
        border-radius: 2px;
        background: var(--primary-clr);
        color: white;
    }

    .available-btn {
        background-color: green;
        color: white;
        font-size: 14px;
    }

    .assigned-btn {
        background-color: yellowgreen;
        color: white;
        font-size: 14px;
    }

    .pending-btn {
        background-color: red;
        color: white;
        font-size: 14px;

    }

    .content {
        text-align: center;
        padding: 2px;

    }

    .download-icon i {
        font-size: 28px;
        color: var(--primary-clr);
    }

    .cmn-crd-content p {
        color: grey;
        margin-top: 22px;
        font-weight: 400;
    }

    .choosefile-btn button {
        margin-top: 34px;
        border: 1px solid var(--primary-clr);
        padding: 9px;
        border-radius: 5px;
        width: 100px;
        color: var(--primary-clr);
    }

    .dsbdy-cmn-card {
        border: 1px dotted grey;
    }
</style>



@section('content')
    <div class="dashboard-main light-bg">

        <!-- Sidebar Begin -->

        @include('backend.partials.sidebar')
        <!-- End Of Sidebar -->

        <!-- Dashboard Body Begin -->

        <div class="dashboard-body dspr-body-outer" id="rest-section" style="    margin-left: -9px;">
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
                <h1>It assets</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">IT</a> /</li>
                    <li>IT assets</li>
                </ul>
            </div>
            <div class="atndnc-filter-form">
                <div class="atndnc-filter-options multi-input-grp">
                    <div class="input-grp">
                        <select id="ParentyearFilter"
                            style="width:197px; position:relative; left:27px; top:11px;border-radius: 6px;"
                            onchange="toggleTabs()">
                            <option value="Request Matching Status" onchange="toggleTabs()">Request Matching Status</option>
                            <option value="Procurement Entry" onchange="toggleTabs()">Procurement Entry</option>
                            <option value="Approved request" onchange="toggleTabs()">Approved Request</option>
                            <option value="Fullfillment History" onchange="toggleTabs()">Fullfillment History</option>
                        </select>
                    </div>



                    <!-- Search Button -->

                </div>



                <div class="ds-pr-body">

                    <div class="ds-bdy-content w-100 align-items-start">

                        <div class="atndnc-filter-wrp w-100" id="historyFilter" style="display:none;">
                            <div class="sec-head">
                                <h2>Filters</h2>
                            </div>
                            <div class="atndnc-filter student-filter">
                                <form>
                                    <div class="atndnc-filter-form">
                                        <div class="atndnc-filter-options multi-input-grp">
                                            <div class="input-grp">
                                                <select id="ParentyearFilter"
                                                    style="background: white; position: relative; left: 605px;">
                                                    <option value="">Select Year</option>
                                                    @foreach (range(date('Y'), 2000) as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-grp">
                                                <select style="background: white; position: relative; left: 299px;">
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



                        <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new" id="rest-section2" >
                            <div class="ds-content-head has-drpdn">
                                <div class="sec-head" id="tabSection">
                                    <div class="ds-content-head">
                                        <div class="cmn-tab-head">
                                            <ul>
                                                <li class="tab-bg"
                                                    style="left: 12px; top: 4px; width: 161.125px; height: 35px;"></li>
                                                <li class="active" onclick="switchTab(this)">Fullfilled</li>
                                                <li onclick="switchTab(this)">Unfilled</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <h3 id="approvedHeading" style="display:none;">Approved Requests</h3>
                                <h3 id="historyHeading" style="display:none;">Fullfillment History</h3>
                                <div class="filters">
                                    <div class="atndnc-filter-form">
                                        <div class="atndnc-filter-options multi-input-grp" style="gap:10px;">
                                            <div class="input-grp search-field mb-0">
                                                <input type="text" placeholder="Search Fees Types" id="feesTypeSearch">
                                                <input type="submit" value="Search" onclick="filterBySearch()">
                                            </div>
                                            <div class="dsbdy-filter-wrp p-0 align-items-start">

                                                <a href="#url" data-bs-toggle="modal" data-bs-target="#createtype"
                                                    class="cmn-btn btn-sm flex-shrink-0" id="exportBtn"
                                                    style="display: none;">
                                                    Export
                                                </a>
                                                <a href="#url" class="cmn-btn btn-sm flex-shrink-0" id="downloadListBtn"
                                                    style="display:none;">
                                                    Download List
                                                </a>
                                            </div>


                                        </div>


                                    </div>




                                </div>



                            </div>

                            <div class="ds-cmn-tble count-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Request Id</th>
                                            <th>User Name</th>
                                            <th>Staff Id</th>
                                            <th>Item Name</th>
                                            <th>Asset Type</th>
                                            <th>No of asset</th>
                                            <th>Requested quantity</th>
                                            <th>Requested Date</th>

                                        </tr>
                                    </thead>
                                    <tbody id="assetsBody">
                                        <tr>
                                            <td>1</td>
                                            <td>hjhgjh</td>
                                            <td>jhkhyu</td>
                                            <td>hiuyui</td>
                                            <td>
                                                giiiuiuyu
                                            </td>

                                            <td>yutytyt</td>
                                            <td>ddddd</td>
                                            <td>ddddd</td>
                                            <td>ddddd</td>

                                        </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div class="tablepagination">
                                <div class="tbl-pagination-inr">
                                    <ul>
                                        <li><a href="#url"><img src="{{ asset('images/fees/arrow-left.svg') }}"></a>
                                        </li>
                                        <li class="active"><a href="#url">1</a></li>
                                        <li><a href="#url">2</a></li>
                                        <li><a href="#url">3</a></li>
                                        <li><a href="#url"><img src="{{ asset('images/fees/arrow-right.svg') }}"></a>
                                        </li>
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
                        <div class="dashboard-body dspr-body-outer" id="procure-section" style="display: none;">




                            <div class="ds-pr-body">

                                <div class="ds-bdy-content w-100 align-items-start">

                                    <div class="dsbdy-cmn-card w55">
                                        <div class="sec-head">
                                            <h2>Manual Procurement Entry</h2>
                                        </div>
                                        <div class="request-leave-form-wrp fees-master-form-wrp">

                                            <form action="" enctype="multipart/form-data" method="post"
                                                id="visitForm">
                                                @csrf

                                                <div class="request-leave-form fees-master-form">
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <label>Pay Item Name</label>
                                                            <input type="text">
                                                        </div>

                                                        <div class="input-grp">
                                                            <label>Purchased Quantity</label>
                                                            <input type="number">
                                                        </div>
                                                    </div>
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <label>Cost Per Unit</label>
                                                            <input type="text">
                                                        </div>

                                                        <div class="input-grp">
                                                            <label>Supplier name</label>
                                                            <input type="text">
                                                        </div>
                                                    </div>

                                                    <div class="input-grp">
                                                        <label>Delivery Date</label>
                                                        <input type="date" name="amount" id="amount"
                                                            placeholder="Enter total amount"
                                                            onkeyup="updateAmountDisplay();">
                                                    </div>

                                                    <div class="btn-wrp justify-content-start">
                                                        <!-- <button type="button" class="cmn-btn btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button> -->
                                                        <button type="submit" class="cmn-btn btn-sm w-30">Add
                                                            Item</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="dsbdy-cmn-card w45">
                                        <div class="content">
                                            <div class="download-icon"><i class="fa-solid fa-download"></i></div>
                                            <div class="cmn-crd-content">
                                                <p>Upload CSV and Excel file with procurement data</p>
                                            </div>
                                            <div class="choosefile-btn"><button>Add File</button></div>

                                        </div>



                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    @endsection
