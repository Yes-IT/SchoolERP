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
</style>



@section('content')
    <div class="dashboard-main light-bg">

        <!-- Sidebar Begin -->

        @include('backend.partials.sidebar')
        <!-- End Of Sidebar -->

        <!-- Dashboard Body Begin -->

        <div class="dashboard-body dspr-body-outer" style="    margin-left: -9px;">
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
                <h1>Inventory</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Pantry</a> /</li>
                    <li>Inventory</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">



                    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
                        <div class="ds-content-head">
                            <div class="sec-head">
                                <h3 class="h2-title">Products</h3>
                            </div>
                            <div class="btn-wrp align-items-start">
                                <div class="dsbdy-filter-wrp p-0 align-items-start">


                                    <a href="#" class="cmn-btn btn-sm flex-shrink-0" id="exportBtn"
                                        style="position: relative; left: -12px; height: 41px;"
                                        onclick="exportVisibleLateTable()">
                                        Download List
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="ds-cmn-tble count-row">
                            <table id="pending-request">
                                <thead>
                                    <tr>
                                        <th>S. No</th>

                                        <th>Product Name</th>
                                        <th>Category</th>

                                        <th>Quality in stock</th>
                                        <th>Thresold value</th>
                                        <th>Expiration Date</th>
                                        <th>Last Updated at</th>

                                    </tr>
                                </thead>
                                <tbody id="assetsBody">
                                    @forelse ($inventories as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->product_name ?? 'N/A' }}</td>
                                            <td>{{ $item->category_name ?? 'N/A' }}</td>
                                            <td>{{ $item->qty }} {{ $item->unit }}</td>
                                            <td>{{ $item->price ?? '—' }}</td>
                                            <td>{{ $item->expiration_date ?? '—' }}</td>
                                            <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y, h:i A') : '—' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No inventory records found</td>
                                        </tr>
                                    @endforelse
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
