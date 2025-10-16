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

    .action-buttons {
        display: flex;
        gap: 10px;
        /* space between buttons */
        justify-content: center;
        /* center them horizontally */
        align-items: center;
        position: relative;
        left: 25px;
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
        color: white;
        padding: 4px;
    }

    .btn-approve:hover {
        background-color: #218838;
        color: white;
        padding: 4px;
    }

    /* Reject button (red) */
    .btn-reject {
        background-color: #dc3545;
        color: white;
        padding: 4px;
    }

    .btn-reject:hover {
        background-color: #c82333;
        color: white;
        padding: 4px;
    }
</style>



@section('content')


    <div class="ds-breadcrumb">
        <h1>Requested Inventory</h1>
        <ul>
            <li><a href="./dashboard.html">Dashboard</a> /</li>
            <li><a href="./additional-fees.html">Pantry</a> /</li>
            <li>Requested Inventory</li>
        </ul>
    </div>

    <div class="ds-pr-body">

        <div class="ds-bdy-content w-100 align-items-start">



            <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                <div class="ds-content-head">
                    <div class="sec-head" id="tabSection">
                        <div class="ds-content-head">
                            <div class="cmn-tab-head">
                                <ul>
                                    <li class="tab-bg" style="left: 12px; top: 4px; width: 185.125px; height: 35px;"></li>
                                    <li class="active" onclick="switchTab(this,'pending-request')">Pending Request
                                    </li>
                                    <li onclick="switchTab(this,'request-status')"> Request Status</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="ds-cmn-tble count-row">
                    <table id="pending-request">
                        <thead style="background:#f5f5f5;">
                            <tr>
                                <th>S. No</th>
                                <th>Request ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Requested Quantity</th>
                                <th>Requested Date</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $filteredRequests = $requests->whereIn('status', [0]);
                            @endphp

                            @if ($filteredRequests->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-3">
                                        No data found
                                    </td>
                                </tr>
                            @else
                                @foreach ($filteredRequests as $index => $req)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $req->id }}</td>
                                        <td>{{ $req->product_name ?? 'N/A' }}</td>
                                        <td>{{ $req->category_name ?? 'N/A' }}</td>
                                        <td>{{ $req->quantity }}</td>
                                        <td>{{ \Carbon\Carbon::parse($req->created_at)->format('d M Y') }}</td>
                                        <td>{{ $req->reason }}</td>
                                        <td class="action-buttons">
                                            <button class="btn-approve" data-id="{{ $req->id }}"
                                                onclick="updateInventoryRequestStatus(this, 3)">
                                                <i class="fa-solid fa-check"></i> Approve
                                            </button>

                                            <button class="btn-reject" data-id="{{ $req->id }}"
                                                onclick="updateInventoryRequestStatus(this, 4)">
                                                <i class="fa-solid fa-xmark"></i> Reject
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                    <table id="request-status" style="display: none;">
                        <thead style="background:#f5f5f5;">
                            <tr>
                                <th>S. No</th>
                                <th>Request ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Requested Quantity</th>
                                <th>Requested Date</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $filteredRequests = $requests->whereIn('status', [3, 4]);
                            @endphp

                            @if ($filteredRequests->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-3">
                                        No data found
                                    </td>
                                </tr>
                            @else
                                @foreach ($filteredRequests as $index => $req)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $req->id }}</td>
                                        <td>{{ $req->product_name ?? 'N/A' }}</td>
                                        <td>{{ $req->category_name ?? 'N/A' }}</td>
                                        <td>{{ $req->quantity }}</td>
                                        <td>{{ \Carbon\Carbon::parse($req->created_at)->format('d M Y') }}</td>
                                        <td>{{ $req->reason }}</td>
                                        <td>
                                            @if ($req->status == 0)
                                                <p class="btn-pending" data-id="{{ $req->id }}">
                                                    <i class="fa-solid fa-clock"></i> Pending
                                                </p>
                                            @elseif ($req->status == 3)
                                                <p class="btn-approve" data-id="{{ $req->id }}">
                                                    <i class="fa-solid fa-check"></i> Approved
                                                </p>
                                            @elseif ($req->status == 4)
                                                <p class="btn-reject" data-id="{{ $req->id }}">
                                                    <i class="fa-solid fa-xmark"></i> Rejected
                                                </p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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

@endsection
