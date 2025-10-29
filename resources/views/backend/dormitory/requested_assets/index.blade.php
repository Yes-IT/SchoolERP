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

    .cmn-tab-head {
        position: relative;
    }

    .cmn-tab-head ul {
        position: relative;
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .cmn-tab-head ul li {
        position: relative;
        padding: 8px 20px;
        cursor: pointer;
        z-index: 2;
    }

    .cmn-tab-head .tab-bg {
        position: absolute;
        top: 4px;
        height: 35px;
        background: #fff;
        /* White highlight */
        border-radius: 6px;
        transition: all 0.3s ease;
        z-index: 1;
    }

    .cmn-tab-head ul li.active {
        font-weight: bold;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        /* space between buttons */
        justify-content: center;
        /* center them horizontally */
        align-items: center;
    }

    /* Common button styles */
    .action-buttons button {
        padding: 6px 14px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 6px;
        /* space between icon and text */
        transition: background 0.3s ease;
        position: relative;
        left: -85px;
    }

         .action-buttons p {
        padding: 6px 14px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 6px;
        /* space between icon and text */
        transition: background 0.3s ease;
        position: relative;
        left: -85px;
    }

    /* Approve button (green) */
    .btn-approve {
        background-color: #28a745;
    }

    .btn-approve:hover {
        background-color: #218838;
    }

    /* Reject button (red) */
    .btn-reject {
        background-color: #dc3545;
    }

    .btn-reject:hover {
        background-color: #c82333;
    }
</style>



@section('content')


            <div class="ds-breadcrumb">
                <h1>Requested assets</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">IT</a> /</li>
                    <li>IT assets</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <div class="ds-content-head">
                                    <div class="cmn-tab-head">
                                        <ul>
                                            <li class="tab-bg"
                                                style="left: 12px; top: 4px; width: 175.125px; height: 35px;"></li>
                                            <li class="active" onclick="switchTab(this,'pending-request')">Pending Request
                                            </li>
                                            <li onclick="switchTab(this,'request-status')">Request Status</li>
                                        </ul>
                                    </div>


                                </div>
                            </div>
                            <div class="btn-wrp align-items-start">
                                <div class="input-grp search-field mb-0">
                                    <div class="input-grp fees-type">
                                        <select id="requestStatusFilter" onchange="filterRequestStatus()"
                                            style="width:97px;height:38px; display:none;">
                                            <option value="select-year">Filter</option>
                                            <option value="approve">Approved</option>
                                            <option value="rejected">Rejected</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ds-cmn-tble count-row">
                            <table id="pending-request">
                                <thead>

                                    <tr>
                                        <th>S. No</th>



                                        <th>Asset Id</th>
                                        <th>Quantity</th>
                                        <th>Reason</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredRequests = $requests->whereIn('status', [0, 1]);
                                    @endphp

                                    @if ($filteredRequests->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 py-3">
                                                No data found
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($filteredRequests as $index => $request)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $request->asset_id }}</td>
                                                <td>{{ $request->quantity }}</td>
                                                <td>{{ $request->reason }}</td>

                                                <td class="action-buttons">
                                                    <button class="btn-approve" data-id="{{ $request->id }}"
                                                        onclick="updateRequestStatus(this, 3)">
                                                        <i class="fa-solid fa-check"></i> Approve
                                                    </button>

                                                    <button class="btn-reject" data-id="{{ $request->id }}"
                                                        onclick="updateRequestStatus(this, 4)">
                                                        <i class="fa-solid fa-xmark"></i> Reject
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>

                            <table id="request-status" style="display:none;">
                                <thead>
                                    <tr>
                                        <th>S. No</th>



                                        <th>Asset Id</th>
                                        <th>Quantity</th>
                                        <th>Reason</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody id="requeststatusBody">

                                    @include('backend.dormitory.requested_assets.requested_assets-list')



                                </tbody>
                            </table>


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

                </div>

            </div>
       
@endsection
