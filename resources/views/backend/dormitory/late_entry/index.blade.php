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
        width: 662px;
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
        margin-left: -9px;
        gap: 50px;
    }

    .multi-input input {
        width: 50px;
    }

    .late-filters {
        display: flex;
        flex-direction: row;
        gap: 29px;
    }

    .late-filters input {
        width: 200px;
    }

    .btn {
        padding: 5px 5px;
        border-radius: 6px;
        color: white;
        border: none;
        cursor: default;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-warning {
        background-color: #ff9800;
    }
</style>



@section('content')


            <div class="ds-breadcrumb">
                <h1>Late Curfew Entry</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>

                    <li>Late Curfew </li>
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
                                    <div class="atndnc-filter-options multi-input-grp late-filters" style="gap:29px;">

                                        <select id="room_id" style="width: 250px;" onclick="filterByRoomLate()">
                                            <option value="">All Rooms</option>
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room }}">{{ $room }}</option>
                                            @endforeach
                                        </select>
                                        <select id="student_id" style="width: 250px;" onchange="filterByStudentLate()">
                                            <option value="">Select Student</option>
                                            @foreach ($students as $student)
                                                @if (!empty($student->first_name))
                                                    <option value="{{ $student->id }}">{{ $student->first_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <input type="date" style="width: 250px;" onchange="filterByDateLate()"
                                            id="filter_date">


                                    </div>

                                    <!-- Search Button -->

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
                                                style="left: 12px; top: 4px; width: 185.125px; height: 35px;"></li>
                                            <li class="active" onclick="switchTab(this,'pending-request')">Request for admin
                                            </li>
                                            <li onclick="switchTab(this,'request-status')">Student Request Status</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h3 id="approvedHeading" style="display:none;">Request for admin</h3>
                            <h3 id="historyHeading" style="display:none;">Student Request S</h3>
                            <div class="filters">
                                <div class="atndnc-filter-form">
                                    <div class="atndnc-filter-options multi-input-grp" style="gap:10px;">
                                        <div class="input-grp search-field mb-0">
                                            <button data-bs-toggle="modal" data-bs-target="#addrequest"
                                                style="    background: var(--primary-clr);
                                                                padding: 7px;
                                                                color: white;
                                                                position: relative;
                                                                left: 180px;">Add
                                                Late Entry</button>
                                        </div>
                                        <div class="dsbdy-filter-wrp p-0 align-items-start">


                                            <a href="#" class="cmn-btn btn-sm flex-shrink-0" id="exportBtn"
                                                style="position: relative; left: -12px; height: 41px;"
                                                onclick="exporttttttttttt()">
                                                Download List
                                            </a>
                                        </div>


                                    </div>


                                </div>




                            </div>



                        </div>

                        <div class="ds-cmn-tble count-row">

                            @include('backend.dormitory.late_entry.late_entry-list')

                        </div>

                        <div class="tablepagination">
                            <div class="tbl-pagination-inr">
                               <ul>
                                    <li><a href="#url"><img src="{{ asset('images/parent/arrow-left.svg') }}"></a></li>
                                    <li class="active"><a href="#url">1</a></li>
                                    <li><a href="#url">2</a></li>
                                    <li><a href="#url">3</a></li>
                                    <li><a href="#url"><img src="{{ asset('images/parent/arrow-right.svg') }}"></a></li>
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
        
        <div class="modal fade cmn-popwrp pop800" id="addrequest" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <img src="{{ asset('images/fees/cross-icon.svg') }}" alt="Close"
                                style="position:relative; left:-106px; top:13px;">
                        </span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2>Add Late Student Entry </h2>
                            </div>


                            <form action="{{ route('latecurfew.store') }}" enctype="multipart/form-data" method="post"
                                id="visitForm">
                                @csrf





                                <div class="multi-input-grp grp-2 mt-3 group-modal">
                                    <div class="group-modal">
                                        <div class="multi-input">
                                            <div class="input-grp">
                                                <label for="">Student Name</label>
                                                 <select id="student_name_select" name="first_name"  style="width: 250px; background: white; color: gray; position: relative; left: 2px;
               border-radius: 8px; height: 43px; border-color: #69696970;"  onclick="handleStudentSelect()">
                                            <option value="">Select Student</option>
                                            @foreach ($students as $student)
                                                @if (!empty($student->first_name))
                                                    <option value="{{ $student->id }}">{{ $student->first_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                            </div>

                                            <div class="input-grp" style="position: relative; left: -42px;">
                                                <label for="">Student ID</label>
                                                <!-- Student ID Input -->
                                                <input type="text" id="student_id_field" placeholder="Student ID"
                                                    name="student_id"
                                                    style="width: 250px; height: 40px; border: 1px solid #80808052; border-radius: 6px; margin-left: 10px;"
                                                    readonly>
                                            </div>


                                        </div>
                                        <div class="multi-input">
                                            <div class="input-grp">
                                                <label for="">Select Room</label>
                                                <input type="text" id="room_field" name="room"
                                                    style="width: 298px; height: 43px; border: 1px solid #80808052; border-radius: 6px;"
                                                    placeholder="School Room" readonly>
                                            </div>

                                            <div class="input-grp" style="position: relative; left: -42px;">
                                                <label for="">Date</label>
                                                <input type="date" name="date"
                                                    style="width: 298px; height: 43px; border: 1px solid #80808052; border-radius: 5px; padding: 5px;">
                                            </div>


                                        </div>

                                        <div class="input-grp" style="margin-top: 10px;">
                                            <label for="edit_description">Return Time</label>
                                            <input id="edit_description" name="time" type="time"
                                                name="time"
                                                style="height:44px; width: 338px;border-color: #80808052;" />
                                        </div>

                                        <div class="input-grp" style="margin-top: 10px;">
                                            <label for="edit_description">Reason</label>
                                            <input id="edit_description" name="reason" type="text" name="reason"
                                                placeholder="Description"
                                                style="height:80px; width: 598px;border-color: #80808052;" />
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

    
@endsection
