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

    .group-modal {
        display: flex;
        flex-direction: column;
        position: relative;
        left: 15px;
    }

    .modal-body {
        width: 615px;
    }

    .input-grp input {
        height: 37px;
    }

    .input-grp label {
        color: var(--primary-clr);
        font-size: 15px;
    }

    .cmn-btn {
        position: relative;
        left: 31px;
    }

    .cross-icon {
        position: relative;
        left: -161px;
        top: 11px;
    }

    .ds-cmn-info-cards-v2 .col-lg-4:nth-child(n+4) {
        margin-top: 20px;
        /* adjust as per design */
    }

    .multi-input {
        display: flex;
        flex-direction: row;
        margin-top: 27px;
        margin-left: 16px;
        gap: 50px;
    }

    .multi-input input {
        width: 50px;
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




            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">

                    <div class="atndnc-filter-wrp w-100" id="historyFilter">
                        <div class="sec-head">
                            <h2>Filters</h2>
                        </div>
                        <div class="atndnc-filter student-filter">
                            <form>
                                <div class="atndnc-filter-form">
                                    <div class="atndnc-filter-options multi-input-grp">
                                        <div class="input-grp">
                                            <select id="room_id" onchange="filterByroomMentainence()"
                                                style="position: relative;left: -27px;border: 1px solid var(--primary-clr);
                                                            background-color: white;height: 46px;border-radius: 8px;">

                                                <option value="">All Room</option>
                                                @foreach ($rooms as $room)
                                                        <option value="{{ $room }}">{{ $room }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    
                                    </div>

                                    <!-- Search Button -->
                                    <button type="submit" class="btn-search" onclick="filterByIssueDate()">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new" id="rest-section2">
                        <div class="ds-content-head has-drpdn">
                            <div class="sec-head" id="tabSection">
                                <div class="ds-content-head">
                                    <div class="cmn-tab-head">
                                        <ul>
                                            <li class="tab-bg"
                                                style="left: 12px; top: 4px; width: 161.125px; height: 35px;"></li>
                                            <li class="active" onclick="switchTab(this,'pending-request')">Pending Request
                                            </li>
                                            <li onclick="switchTab(this,'request-status')">Resolved Status</li>
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
                                            <button data-bs-toggle="modal" data-bs-target="#addrequest"
                                                style="    background: var(--primary-clr);
                                                                padding: 7px;
                                                                color: white;
                                                                position: relative;
                                                                left: 186px;">Add
                                                request</button>
                                        </div>
                                        <div class="dsbdy-filter-wrp p-0 align-items-start">


                                            <a href="#url" class="cmn-btn btn-sm flex-shrink-0" id="downloadListBtn"
                                                style="position:relative;left:-12px;" onclick="exportVisibleTable()">
                                                Download List
                                            </a>
                                        </div>


                                    </div>


                                </div>




                            </div>



                        </div>

                        <div class="ds-cmn-tble count-row" >
                            @include('backend.dormitory.maintenance_request.maintence-request-list')

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
                                                        placeholder="Enter total amount" onkeyup="updateAmountDisplay();">
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
        <div class="modal fade cmn-popwrp pop800" id="addrequest" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <img src="{{ asset('images/fees/cross-icon.svg') }}" alt="Close"
                                style="position:relative; left:-150px; top:13px;">
                        </span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2>Add Request </h2>
                            </div>


                            <form  action="{{ route('maintenance.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                                @csrf
                               




                                <div class="multi-input-grp grp-2 mt-3 group-modal">
                                    <div class="group-modal">
                                        <div class="input-grp">
                                            <label for="edit_name">Date</label>
                                            <input id="edit_name" name="issue_date" type="date" placeholder="Title Name"
                                                style="height:37px;" />
                                        </div>

                                        <div class="input-grp" style="margin-top: 10px;">
                                            <label for="edit_description">Problem</label>
                                            <input id="edit_description" name="problem" type="text"
                                                placeholder="Problem" style="height:57px; width: 500px;" />
                                        </div>

                                        <div class="multi-input">
                                            <div class="input-grp">
                                                <label for="select_room">Select Room</label>
                                                <select id="roomFilter" name="room_no" style="    width: 210px;
                                                                                    background: white;
                                                                                    color: gray;
                                                                                    position: relative;
                                                                                    left: -12px;
                                                                                    border-radius: 11px">
                                                    <option value="">Select School Room</option>
                                                    @foreach ($rooms as $room)
                                                        <option value="{{ $room }}">{{ $room }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div class="input-grp"> 
                                             <label for="" style="position: relative; left: -91px;">Due Date</label>
                                               <input type="date" name="due_date" style="width: 230px;
                                                                        position: relative;
                                                                        
                                                                        left: -96px;" placeholder="Due Date">
                                             
                                             </div> 
                                          
                                        </div>

                                    </div>
                                </div>

                                <button type="submit" class="btn-sm cmn-btn mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
