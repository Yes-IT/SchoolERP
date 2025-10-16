@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
<style>
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
    margin-top: 20px; /* adjust as per design */
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
                <h1>Fees Group</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Additional Fees</a> /</li>
                    <li>Fees Group</li>
                </ul>
            </div>
            <div class="ds-pr-body">
                <div class="ds-cmn-table-wrp">

                    <div class="ds-content-head has-drpdn">
                        <div class="sec-head">
                            <h2>Fees Groups List</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                            <div class="dsbdy-filter-wrp p-0 align-items-start">
                                <div class="input-grp search-field mb-0">
                                    <input type="text" id="searchGroup"  placeholder="Search Group">
                                    <input type="submit" value="Search" onclick="searchFeesGroup()">
                                </div>
                               
                                <a href="#" class="cmn-btn btn-sm flex-shrink-0" data-bs-toggle="modal"
                                    data-bs-target="#creategroup">
                                    <i class="fa-solid fa-plus"></i> Create Group
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="ds-cmn-info-cards-wrp ds-cmn-info-cards-v2">
                        <div class="row g-3 mt-4" id="feesGroupCards"><!-- row outside loop with gap -->
                            @foreach($data['fees_groups'] as $group)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="ds-cmn-info-card h-200">
                                        <div class="ds-cmn-ic-head d-flex justify-content-between align-items-center">
                                            <h3 class="clr-primary mb-0">{{ $group->name }}</h3>
                                            <div class="actions-wrp">
                                                @if($group->status == 1)
                                                    <span class="cmn-tbl-btn green-bg">Active</span>
                                                @else
                                                    <span class="cmn-tbl-btn red-bg">Inactive</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ds-cmn-ic-body">
                                            <p>{{ $group->description }}</p>
                                        </div>

                                        <div
                                            class="ds-cmn-ic-ftr actions-wrp d-flex justify-content-between align-items-center">
                                            <p class="mb-0">450 students assigned</p>
                                            <div class="btn-wrp d-flex gap-2">
                                                <button type="button" class="edit-group-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editgroup" data-id="{{ $group->id }}"
                                                    data-name="{{ $group->name }}" data-description="{{ $group->description }}">
                                                    <img src="{{ asset('images/fees/edit-icon-primary.svg') }}" alt="Icon">
                                                </button>

                                           <button type="button"
                                                    data-id="{{ $group->id }}"
                                                    onclick="deletefeesgroup(this)">
                                                <img src="{{ asset('images/fees/bin-icon.svg') }}" alt="Delete">
                                            </button>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="modal fade cmn-popwrp pop800" id="creategroup" tabindex="-1" role="dialog" aria-labelledby="addVideo"
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
                                <h2>Create New Fees Group</h2>
                            </div>



                            <div class="cmn-tab-content">
                                <form action="{{ route('fees-group.store') }}" enctype="multipart/form-data" method="post"
                                    id="visitForm">
                                    @csrf
                                    <div class="multi-input-grp grp-2 mt-3 group-modal">
                                        <div class="group-modal">
                                            <div class="input-grp">
                                                <label for="title">Group Name</label>
                                                <input id="title" name="name" type="text" placeholder="Title Name"
                                                    style="height:37px;" />
                                            </div>

                                            <div class="input-grp" style="margin-top: 10px;">
                                                <label for="author">Description</label>
                                                <input id="author" name="description" type="text" placeholder="Author Name"
                                                    style="height:37px; width: 500px;" />
                                            </div>
                                        </div>
                                    </div>





                                    <button class="btn-sm cmn-btn">Create Group</button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal fade cmn-popwrp pop800" id="editgroup" tabindex="-1" aria-hidden="true">
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
                            <h2>Edit Fees Group </h2>
                        </div>


                        <form action="{{ route('fees-group.update', $group->id) }}" enctype="multipart/form-data"
                            method="post" id="visitForm">
                            @csrf
                            @method('PUT')




                            <div class="multi-input-grp grp-2 mt-3 group-modal">
                                <div class="group-modal">
                                    <div class="input-grp">
                                        <label for="edit_name">Group Name</label>
                                        <input id="edit_name" name="name" type="text" placeholder="Title Name"
                                            style="height:37px;" value="{{ old('name', $group->name ?? '') }}" />
                                    </div>

                                    <div class="input-grp" style="margin-top: 10px;">
                                        <label for="edit_description">Description</label>
                                        <input id="edit_description" name="description" type="text"
                                            placeholder="Description" style="height:37px; width: 500px;"
                                            value="{{ old('name', $group->description ?? '') }}" />
                                    </div>

                                </div>
                            </div>

                            <button type="submit" class="btn-sm cmn-btn mt-3">Update Group</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>

@endsection