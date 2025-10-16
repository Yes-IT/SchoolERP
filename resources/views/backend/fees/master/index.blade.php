@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

<style>
    .number-of-installment {
        margin-top: 15px;
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    .number-of-installment input {
        width: 170px;
    }

    .installment-form {
        margin-top: 15px;
    }

    .installment-form h3 {
        color: var(--primary-clr);
        font-size: 18px;
        position: relative;
        top: 11px;
    }

    .installment-review {
        text-align: left;
        font-size: 18px;
        font-weight: 700;
    }

    .autosplit {
        position: relative;
        left: 184px;
        top: -49px;
    }

    .input-grp img {
        position: relative;
        left: 506px;
        top: -36px;
        width: 25px;
        height: 28px;
    }

    .installment-select input {
        width: 168px;
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
                <h1>Fees Master</h1>
                <ul>
                    <li><a href="./dashboard.html">Dashboard</a> /</li>
                    <li><a href="./additional-fees.html">Additional Fees</a> /</li>
                    <li>Fees Master</li>
                </ul>
            </div>

            <div class="ds-pr-body">

                <div class="ds-bdy-content w-100 align-items-start">

                    <div class="dsbdy-cmn-card w55">
                        <div class="sec-head">
                            <h2>Create Fees Master</h2>
                        </div>
                        <div class="request-leave-form-wrp fees-master-form-wrp">

                            <form action="{{ route('fees-master.store') }}" enctype="multipart/form-data" method="post"
                                id="visitForm">
                                @csrf

                                <div class="request-leave-form fees-master-form">
                                    <div class="multi-input-grp">
                                        <div class="input-grp">
                                            <label>Fees Group</label>
                                            <select name="fees_group_id" id="fees_group_id" onchange="fill_details('fees_group_id');" required>
                                                <option value="">Select Fees Group</option>
                                                @php
                                                    $selected = old(
                                                        'fees_group_id',
                                                        $fees_master->fees_group_id ?? null,
                                                    );
                                                @endphp

                                                @foreach ($fees_groups as $group)
                                                    <option value="{{ $group->id }}"
                                                        {{ (string) $selected === (string) $group->id ? 'selected' : '' }}>
                                                        {{ $group->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="input-grp">
                                            <label>Fees Type</label>
                                            <select name="fees_type_id" id="fees_type_id" onchange="fill_details('fees_type_id');" required>
                                                <option value="Select Fees Type">Select Fees Type</option>
                                                @php
                                                    $selected = old('fees_type_id', $fees_master->fees_type_id ?? null);
                                                @endphp
                                                @foreach ($fees_types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ (string) $selected === (string) $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-grp">
                                        <label>Total Amount</label>
                                        <input type="text" name="amount" id="amount"
                                            placeholder="Enter total amount"  onkeyup="updateAmountDisplay();">
                                    </div>
                                    <div class="input-grp">
                                        <div class="installment-toggle">
                                            <input id="enable-installments" class="toggle-input" type="checkbox"
                                                onchange="toggleInstallmentSection()" />
                                            <label for="enable-installments" class="toggle-label">
                                                <span class="toggle-track" aria-hidden="true">
                                                    <span class="toggle-thumb" aria-hidden="true"></span>
                                                </span>
                                                <span class="toggle-text">Enable installments</span>
                                            </label>
                                        </div>

                                        <div class="number-of-installment" style="display: none;">
                                            <div class="installment-select">
                                                <!-- <select id="installment-count" onchange="generateInstallmentRows()">
                                                    <option>1</option>
                                                    <option value="group-1">2</option>
                                                    <option value="group-2">3</option>
                                                    <option value="group-3">4</option>
                                                    <option value="group-4">5</option>
                                                </select> -->
                                                <input type="number" name="total_installment" id="installment-count"
                                                    min="0" max="5" onkeyup="generateInstallmentRows()"
                                                    style="width: 168px;">
                                            </div>

                                            <div class="installment-toggle autosplit">
                                                <input id="auto-split" class="toggle-input" type="checkbox"
                                                    onchange="toggleInstallmentForm()" />
                                                <label for="auto-split" class="toggle-label"
                                                    style="position:relative; top:10px;">
                                                    <span class="toggle-track" aria-hidden="true">
                                                        <span class="toggle-thumb" aria-hidden="true"></span>
                                                    </span>
                                                    <span class="toggle-text">Auto split amount equally</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="installment-form" style="display:none;" id="installment_fields">
                                            <h3>Installments</h3>
                                            <hr>
                                            <div class="multi-input-grp" id="installment-rows-container">
                                                <div class="input-grp">
                                                    <label>Installment 1</label>
                                                    <input type="number" style="width: 200px;"
                                                        name="installment_amount[]">
                                                </div>
                                                <div class="input-grp">
                                                    <label style="position:relative; top: -9px; left:-40px;">Due
                                                        Date</label>
                                                    <input type="date" name="due_date[]"
                                                        style= " width: 207px; position:relative;left:-116px; top:28px; height: 50px;">
                                                </div>
                                                <div class="input-grp">
                                                    <img src="{{ asset('images/fees/bin-icon.svg') }}" alt="Icon">

                                                </div>
                                            </div>

                                            <!-- Wrap these two in a flex row -->



                                        </div>

                                    </div>
                                    <div class="btn-wrp justify-content-start">
                                        <!-- <button type="button" class="cmn-btn btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button> -->
                                        <button type="submit" class="cmn-btn btn-sm w-100">Save Fees Master</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dsbdy-cmn-card w45">
                        <div class="sec-head">
                            <h3 class="h2-title">Summary Review</h3>
                        </div>
                        <div class="dsprprofile-course-info p-0">
                            <table>
                                <tr>
                                    <td>Fees Group:</td>
                                    <td id="fees_group_id_name"></td>
                                </tr>
                                <tr>
                                    <td>Fees Type:</td>
                                    <td id="fees_type_id_name"></td>
                                </tr>
                                <tr>
                                    <td id="total_amount">Total Amount:</td>
                                    <td>$100</td>
                                </tr>
                                <tr>
                                    <td>Installments:</td>
                                    <td>1</td>
                                </tr>
                            </table>
                            <hr>
                            <table>
                                <h4 class="installment-review">Installment Schdule</h4>
                                <tr>
                                    <td>Installment 1:</td>
                                    <td>$750</td>
                                </tr>
                                <tr>
                                    <td>Installment 2:</td>
                                    <td>$750</td>
                                </tr>

                            </table>

                        </div>
                    </div>

                   
                </div>

            </div>
        </div>

    </div>
@endsection
