@extends('backend.master')
@section('title')
    {{ @$data['title'] }}

@endsection

<style>
    .atndnc-filter-options {
        display: flex;
        align-items: center;
        gap: 10px;
        /* space between inputs */
    }

    .atndnc-filter-options .input-grp {
        flex: 1;
        /* make both take equal width */
    }

    .atndnc-filter-options .search-field {
        display: flex;
        gap: 5px;
        /* gap between text input & button */
    }

    .tbl-5_4k table {
        min-width: 400px;
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
    .fees-type-btn{
            width: 30%;
    position: relative;
    left: 26px;
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
                <h1>Fees Type(2)</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Additional Fees</a> /</li>
                    <li>Fees Types</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="ds-cmn-table-wrp">

                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Fees Types</h2>
                        </div>
                        <div class="filters">
                            <div class="atndnc-filter-form">
                                <div class="atndnc-filter-options multi-input-grp">
                                    <div class="input-grp search-field mb-0">
                                        <input type="text" placeholder="Search Fees Types"  id="feesTypeSearch">
                                        <input type="submit" value="Search" onclick="filterBySearch()">
                                    </div>
                                    <div class="input-grp fees-type">
                                        <select id="categoryFilter" onchange="filterFeesTypes()">
                                            <option value="select-year">Categories</option>
                                            <option value="Academic">Academic</option>
                                            <option value="Facility">Facility</option>
                                            <option value="One Time">One Time</option>
                                            <option value="Activity">Activity</option>
                                            <option value="Penalty">Penalty</option>
                                        </select>
                                    </div>
                                    <div class="dsbdy-filter-wrp p-0 align-items-start">

                                        <a href="#url" data-bs-toggle="modal" data-bs-target="#createtype"
                                            class="cmn-btn btn-sm flex-shrink-0"><i class="fa-solid fa-plus"></i>
                                            Create
                                            Type</a>
                                    </div>

                                </div>


                            </div>




                        </div>



                    </div>


                    <!-- <a href="#url" class="cmn-btn btn-sm flex-shrink-0"><i class="fa-solid fa-plus"></i> Create
                                                Type</a> -->


                    <div class="ds-cmn-tble count-row tbl-5_4k">
                        <table style="min-width:400px;">
                            <thead class="thead">
                                <tr>

                                    <th class="purchase">S.No</th>
                                    <th class="purchase">Name</th>
                                    <th class="purchase">Category</th>
                                    <th class="purchase">Description</th>
                                    <th class="purchase">Type</th>
                                    <th class="purchase">Status</th>
                                    <th class="purchase">Action</th>







                                </tr>
                            </thead>
                            <tbody id="feesTypesTable">
                         @include('backend.fees.type.fees-type-table')


                        




                            </tbody>

                        </table>
                    </div>

                    <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            <ul>
                                  {!! $data['fees_types']->appends(\Request::capture()->except('page'))->links() !!}
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

   
       <div class="modal fade cmn-popwrp pop800" id="createtype" tabindex="-1" role="dialog" aria-labelledby="addVideo"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('images/fees/cross-icon.svg') }}" alt="Icon"
                                class="cross-icon" style="    position: relative; left: -150px; top: 13px;"></span>


                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2>Create New Fees Type</h2>
                            </div>



                            <div class="cmn-tab-content">
                                <form action="{{ route('fees-type.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                                  @csrf
                                    <div class="multi-input-grp grp-2 mt-3 group-modal">
                                       <div class="group-modal">
                                                <div class="input-grp">
                                                    <label for="title">Type name</label>
                                                    <input id="name" name="name" type="text" placeholder="Title Name"
                                                        style="height:37px;" />
                                                </div>

                                                
                                                <div class="input-grp" style="margin-top: 10px;">
                                                    <label for="category">Category</label>
                                                    <select id="category" name="category" style="height: 37px; width: 500px;">
                                                        <option value="Academic">Academic</option>
                                                        <option value="Facility">Facility</option>
                                                        <option value="One Time">One Time</option>
                                                        <option value="Activity">Activity</option>
                                                        <option value="Penalty">Penalty</option>
                                                    </select>
                                                </div>

                                                <div class="input-grp" style="margin-top: 10px;">
                                                    <label for="description">Description</label>
                                                    <input id="description" name="description" type="text" placeholder="Author Name"
                                                        style="height:37px; width: 500px;" />
                                                </div>
                                                  <div class="input-grp" style="margin-top: 10px;">
                                                   
                                                    <input id="author" name="status" type="text" placeholder="Author Name" hidden/>
                                                       
                                                </div>

                                                </div>






                                    <button class="btn-sm cmn-btn fees-type-btn">Create Fees Type</button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

  

         <div class="modal fade cmn-popwrp pop800" id="edittype" tabindex="-1" role="dialog" aria-labelledby="addVideo"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('images/fees/cross-icon.svg') }}" alt="Icon"
                                class="cross-icon" style="    position: relative; left: -150px; top: 13px;"></span>


                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-content-wrapper">
                            <div class="cmn-pop-head">
                                <h2>Edit Fees Type</h2>
                            </div>

                           

                         <form action="{{route('fees-type.update') }}" enctype="multipart/form-data" method="POST" id="visitForm">
                                 @csrf
                                  
                                    <div class="multi-input-grp grp-2 mt-3 group-modal">
                                       <div class="group-modal">
                                                <div class="input-grp">
                                                    <label for="title">Type name</label>
                                                    <input id="ed_title_name" name="name" type="text" placeholder="Title Name"
                                                        style="height:37px;"    value="{{ old('name', $data['fees_type']->name ?? '') }}"  />
                                                </div>
                                                <input type="hidden" name="edit_fee_id" id="edit_fee_id">

                                                
                                                <div class="input-grp" style="margin-top: 10px;">
                                                    <label for="category">Category</label>
                                                    <select id="ed_category" name="category" style="height: 37px; width: 500px;" value="{{ old('name', $data['fees_type']->category ?? '') }}">
                                                        <option value="Academic">Academic</option>
                                                        <option value="Facility">Facility</option>
                                                        <option value="One Time">One Time</option>
                                                        <option value="Activity">Activity</option>
                                                        <option value="Penalty">Penalty</option>
                                                    </select>
                                                </div>

                                                <div class="input-grp" style="margin-top: 10px;">
                                                    <label for="description">Description</label>
                                                    <input id="ed_description" name="description" type="text" placeholder="Author Name"
                                                        style="height:37px; width: 500px;" value="{{ old('name', $data['fees_type']->description ?? '') }}"   />
                                                </div>
                                                 
                                                </div>






                                    <button class="btn-sm cmn-btn fees-type-btn">Edit Fees Type</button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


@endsection