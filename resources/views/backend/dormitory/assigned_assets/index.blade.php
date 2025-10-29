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
</style>



@section('content')
  

            <div class="ds-breadcrumb">
                <h1>Assigned Assets</h1>
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
                                <h3 class="h2-title">Assigned Assets</h3>
                            </div>

                            <div class="ds-cmn-tble count-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Assigned Id</th>
                                            <th>Employee Id</th>
                                            <th>Asset Type</th>
                                            <th>Asset Id</th>
                                            <th>Asset Model No</th>

                                        </tr>
                                    </thead>
                                    <tbody id="assetsBody">
                                        @forelse($assignedAssets as $index => $asset)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $asset->assign_id }}</td>
                                                <td>{{ $asset->employee_id ?? 'N/A' }}</td>
                                                <td>{{ $asset->asset_type }}</td>
                                                <td>{{ $asset->asset_id }}</td>
                                                <td>{{ $asset->asset_model }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No assigned assets found.</td>
                                            </tr>
                                        @endforelse
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
            </div>

     
    @endsection
