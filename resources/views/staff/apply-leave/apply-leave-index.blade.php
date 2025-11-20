@extends('staff.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
    
<div class="ds-breadcrumb">
    <h1>Apply Leaves</h1>
    <ul>
        <li><a href="dashboard.html">Dashboard</a> /</li>
        <li>Apply Leaves</li>
    </ul>
</div>

@dump($data['leaves']->toArray())

<div class="ds-pr-body">
    
    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">

        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Leaves</h2>
            </div>
            <div class="ds-cmn-filter-wrp">
                <div class="dsbdy-filter-wrp p-0">
                    <button class="cmn-btn h-40" data-bs-target="#requestLeave" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i> Request Leave
                    </button>
                </div>
            </div>
        </div>

        <div class="ds-cmn-tble count-row w1200">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Apply Date</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Reason</th>
                        <th>
                            <div class="status-wrp">
                                Status
                                <div class="ibtn">
                                    <button type="button" class="ibtn-icon">
                                        <img src="{{ asset('staff/assets/images/i-icon.svg') }}" alt="Icon">
                                    </button>
                                    <div class="ibtn-info lg rt p15">
                                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                                            <img src="{{ asset('staff/assets/images/fa-times.svg') }}" alt="icon">
                                        </button>
                                        <h3 class="txt-primary mb-2">Note:</h3>
                                        <p>Your leave will be reviewed by your Mechaneches.</p>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0</td>
                        <td>04/02/2025</td>
                        <td>04/02/2025</td>
                        <td>04/02/2025</td>
                        <td><div class="linecamped line-count-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div></td>
                        <td><p class="red-bg cmn-tbl-btn">Pending</p></td>
                        <td>
                            <div class="actions-wrp">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editLeaveRequest">
                                    <img src="./images/edit-icon-primary.svg" alt="Icon">
                                </button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteLeaveRequest">
                                    <img src="./images/bin-icon.svg" alt="Icon">
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>04/02/2025</td>
                        <td>04/02/2025</td>
                        <td>04/02/2025</td>
                        <td><div class="linecamped line-count-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div></td>
                        <td><p class="green-bg cmn-tbl-btn">Approved (04/01/2025)</p></td>
                        <td>--</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tablepagination">

            <div class="tbl-pagination-inr">
                <ul>
                    <li><a href="#url"><img src="./images/arrow-left.svg" alt="Icon"></a></li>
                    <li class="active"><a href="#url">1</a></li>
                    <li><a href="#url">2</a></li>
                    <li><a href="#url">3</a></li>
                    <li><a href="#url"><img src="./images/arrow-right.svg" alt="Icon"></a></li>
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

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="requestLeave" tabindex="-1" role="dialog" aria-labelledby="requestLeave" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Request Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form>
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea placeholder="Reason"></textarea>
                                </div>
                                <input type="submit" value="Submit" class="btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="editLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="editLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>Edit Leave</h2>
                    <div class="request-leave-form-wrp">
                        <form>
                            <div class="request-leave-form">
                                <div class="multi-input-grp">
                                    <div class="input-grp">
                                        <label>From Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="input-grp">
                                        <label>To Date *</label>
                                        <input type="date" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                                <div class="input-grp">
                                    <label>Reason</label>
                                    <textarea placeholder="Reason">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</textarea>
                                </div>
                                <input type="submit" value="Submit" class="btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

<!-- Request Leave Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="deleteLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="deleteLeaveRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="./images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="./images/bin-primary.svg" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Delete!</h2>
                        <p>Are you sure you want to delete this Leave Request?</p>
                        <div class="btn-wrp">
                            <button type="submit" class="cmn-btn">Delete</button>
                            <button type="button" class="cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- End Of Request Leave Modal -->

@endsection

@push('script')
    
@endpush