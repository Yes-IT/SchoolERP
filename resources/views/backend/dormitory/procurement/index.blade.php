@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .input-grp select {
        width: 189px;
        height: 52px;
        position: relative;
        left: -77px;
        border-radius: 11px;
        /* background: var(--primary-clr); */
        color: var(--primary-clr);
        top: 39px;
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
                            <option value="Request Matching Status">Request Matching Status</option>
                            <option value="Procurement Entry">Procurement Entry</option>
                            <option value="Approved request">Approved Request</option>
                            <option value="Fullfillment History">Fullfillment History</option>
                        </select>
                    </div>



                    <!-- Search Button -->

                </div>



                <div class="ds-pr-body">

                    <div class="ds-bdy-content w-100 align-items-start">

                    



                        <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new" id="request-section">
                            <div class="ds-content-head has-drpdn">
                                <div class="sec-head" id="tabSection">
                                    <div class="ds-content-head">
                                        <div class="cmn-tab-head">
                                            <ul>
                                                <li class="tab-bg"
                                                    style="left: 12px; top: 4px; width: 161.125px; height: 35px;"></li>
                                                <li class="active" onclick="switchTab(this,'pending-request')">Fullfilled
                                                </li>
                                                <li onclick="switchTab(this,'request-status')">Unfilled</li>
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
                                                <input type="text" placeholder="Search" id="procurementSearch">
                                                <input type="submit" value="Search"
                                                    onclick="searchProcure('procurementSearch','ProcurementBody');">
                                            </div>
                                            <div class="dsbdy-filter-wrp p-0 align-items-start">

                                                <a href="#url" data-bs-toggle="modal" data-bs-target="#createtype"
                                                    class="cmn-btn btn-sm flex-shrink-0" style="display: none;">
                                                    Export
                                                </a>
                                                <a href="#url" data-bs-toggle="modal" data-bs-target="#createtype"
                                                    class="cmn-btn btn-sm flex-shrink-0" id="requestStatusFilter"
                                                    style="display: none;" onclick="exportRequestStatusTable()">
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

                            <div class="request-section">
                                @include('backend.dormitory.procurement.procurement-list', [
                                    'requests' => $requests,
                                ])
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
                        <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new" id="approved-section"
                            style="display:none;">
                            <div class="ds-content-head has-drpdn">
                                <div class="sec-head" id="tabSection">
                                    <div class="ds-content-head">
                                        <div class="sec-head">
                                            <h3 class="h2-title">Assets list</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="filters">
                                    <div class="atndnc-filter-form">
                                        <div class="atndnc-filter-options multi-input-grp" style="gap:10px;">
                                            <div class="input-grp search-field mb-0">
                                                <input type="text" placeholder="Search" id="approved_req_search">
                                                <input type="submit" value="Search"
                                                    onclick="searchProcure('approved_req_search','approvedRequestBody');">
                                            </div>
                                            <div class="dsbdy-filter-wrp p-0 align-items-start">



                                                 <a href="#url" data-bs-toggle="modal" data-bs-target="#createtype"
                                                    class="cmn-btn btn-sm flex-shrink-0" id="requestStatusFilter"
                                                     onclick="exportRequestStatusTable()">
                                                    Download List
                                                </a>
                                            </div>


                                        </div>


                                    </div>




                                </div>



                            </div>

                            <div class="request-section">
                                @include('backend.dormitory.procurement.approved-request-list', [
                                    'requests' => $requests,
                                ])
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

                                            <form action="{{ route('procurement.store') }}" enctype="multipart/form-data"
                                                method="post" id="visitForm">
                                                @csrf

                                                <div class="request-leave-form fees-master-form">
                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <label>Category</label>
                                                            <select name="category_id" id="categorySelect" required>
                                                                <option value="">-- Select Category --</option>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}">
                                                                        {{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="input-grp">
                                                            <label>Pantry Item Name</label>
                                                            <input type="text" name="item_name" required>
                                                        </div>
                                                    </div>

                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <label>Purchased Quantity</label>
                                                            <input type="number" name="qty" required>
                                                        </div>

                                                        <div class="input-grp">
                                                            <label>Cost per unit</label>
                                                            <input type="number" name="amount_per_qty" required>
                                                        </div>
                                                    </div>

                                                    <div class="multi-input-grp">
                                                        <div class="input-grp">
                                                            <label>Supplier name</label>
                                                            <input type="text" name="supplier_name" required>
                                                        </div>

                                                        <div class="input-grp">
                                                            <label>Delivery Date</label>
                                                            <input type="date" name="delivery_date" required>
                                                        </div>
                                                    </div>

                                                    <div class="btn-wrp justify-content-start">
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
                                            <div class="choosefile-btn">
                                                <form action="{{ route('procurement.import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="file" accept=".csv, .xlsx, .xls"
                                                        required>
                                                    <button type="submit"
                                                        style="  margin-top: 34px;
                                                            border: 1px solid var(--primary-clr);
                                                            padding: 9px;
                                                            border-radius: 5px;
                                                            width: 100px;
                                                            color: var(--primary-clr);">Upload</button>
                                                </form>

                                            </div>

                                        </div>



                                    </div>


                                </div>

                            </div>
                        </div>

                        <div class="dashboard-body dspr-body-outer" id="fullfillmentHistory-section"
                            style="display: none;">

                            <div class="atndnc-filter-wrp w-100" id="historyFilter">
                                <div class="sec-head">
                                    <h2>Filters</h2>
                                </div>
                                <div class="atndnc-filter student-filter">
                                    <form>
                                        <div class="atndnc-filter-form">
                                            <div class="atndnc-filter-options multi-input-grp">
                                                <div class="input-grp">
                                                    <select id="userFilter"
                                                        style="background: white; position: relative; left: -89px; border:1px solid #660000;"
                                                        onchange="filterRequestsByUser()">
                                                        <option value="">All Users</option>
                                                        @foreach ($staff as $member)
                                                            <option value="{{ $member->id }}">
                                                                {{ $member->first_name }} {{ $member->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-grp">
                                                    <input type="date" id="deliveryDateFilter"
                                                        style="background: white; border:1px solid #660000; position: relative; left: -54px; top:38px;"
                                                        onchange="filterByDeliveryDate()" >
                                                </div>

                                            </div>

                                            <!-- Search Button -->
                                           
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                                <div class="ds-content-head has-drpdn">
                                    <div class="sec-head" id="tabSection">
                                        <div class="ds-content-head">
                                            <div class="sec-head">
                                                <h3 class="h2-title">Fullfillment History</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filters">
                                        <div class="atndnc-filter-form">
                                            <div class="atndnc-filter-options multi-input-grp" style="gap:10px;">
                                                <div class="input-grp search-field mb-0">
                                                    <input type="text" placeholder="Search"
                                                        id="fullfillment_req_search">
                                                    <input type="submit" value="Search"
                                                        onclick="searchProcure('fullfillment_req_search','fullfillmentHistoryBody');">
                                                </div>
                                                <div class="dsbdy-filter-wrp p-0 align-items-start">



                                                   <a href="#url" data-bs-toggle="modal" data-bs-target="#createtype"
                                                    class="cmn-btn btn-sm flex-shrink-0" id="requestStatusFilter"
                                                  onclick="exportRequestStatusTable()">
                                                    Download List
                                                </a>
                                                </div>


                                            </div>


                                        </div>




                                    </div>



                                </div>

                                <div class="request-section">
                                    @include('backend.dormitory.procurement.fullfillment-history-list', [
                                        'requests' => $requests,
                                    ])
                                </div>



                                <div class="tablepagination">
                                    <div class="tbl-pagination-inr">
                                        <ul>
                                            <li><a href="#url"><img
                                                        src="{{ asset('images/fees/arrow-left.svg') }}"></a>
                                            </li>
                                            <li class="active"><a href="#url">1</a></li>
                                            <li><a href="#url">2</a></li>
                                            <li><a href="#url">3</a></li>
                                            <li><a href="#url"><img
                                                        src="{{ asset('images/fees/arrow-right.svg') }}"></a>
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
                        </div>

                    </div>

                </div>
            </div>

        </div>
    @endsection
