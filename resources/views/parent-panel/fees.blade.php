@extends('parent-panel.partials.master')

@section('content')
    <!-- Dashboard Begin -->
    <div class="ds-breadcrumb">
        <h1>My Tuition Fees</h1>
        <ul>
            <li><a href="{{ route('parent-panel-dashboard.index') }}">Dashboard</a> /</li>
            <li>My Tuition Fees</li>
        </ul>
    </div>
    <div class="ds-pr-body">
            <div class="ds-cmn-table-wrp fees-pg">
                    <div class="ds-content-head">
                        <div class="sec-head">
                            <!-- Replace heading with tabs -->
                            <ul class="nav nav-tabs" id="feesTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab">Tuition Fees</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="uniform-tab" data-bs-toggle="tab" data-bs-target="#uniform" type="button" role="tab">Student Fees</button>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="select-yr">
                            <select>
                                <option value="2024-25" selected>2024-25</option>
                                <option value="2025-26">2025-26</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="feesTabContent">
                        <!-- Assignments Table -->
                        <div class="tab-pane fade show active" id="assignments" role="tabpanel">
                            <div class="ds-cmn-tble count-row">
                                <table>
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Transaction Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Payment ID</th>
                                                <th>Payment Method</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Uniform</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td><div class="upcoming cmn-tbl-btn red-bg" onclick="showModal()">Upcoming</div></td>
                                                <td>4500.00</td>
                                                <td>1056/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td><div class="upcoming cmn-tbl-btn red-bg">Upcoming</div></td>
                                                <td>4500.00</td>
                                                <td>1058/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <!-- Uniform Fees Table -->
                        <div class="tab-pane fade" id="uniform" role="tabpanel">
                            <div class="ds-cmn-tble count-row">
                                <table>
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Transaction Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Payment ID</th>
                                                <th>Payment Method</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Uniform</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td><div class="upcoming cmn-tbl-btn red-bg">Upcoming</div></td>
                                                <td>4500.00</td>
                                                <td>1056/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td><div class="upcoming cmn-tbl-btn red-bg">Upcoming</div></td>
                                                <td>4500.00</td>
                                                <td>1058/1</td>
                                                <td>--</td>
                                                <td><button class="edit-file-btn cmn-tbl-btn">Pay</button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>Cash</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Exam Form</td>
                                                <td>21/12/2024</td>
                                                <td>21/12/2024</td>
                                                <td>11:00 AM</td>
                                                <td><div class="upcoming cmn-tbl-btn green-bg">Paid</div></td>
                                                <td>4500.00</td>
                                                <td>--</td>
                                                <td>UPI</td>
                                                <td><button class="print-btn"><img src="../images/printer-icon.svg" alt="Icon"></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <!-- Exam Fees Table -->
                        
                    </div>
            </div>   
    </div>
    <!-- End Of Dashboard -->

   <!-- POPUP-->

    <div id="customModalBackdrop" class="modal-backdrop">
            <div class="modal-box">
                <button class="modal-close" onclick="hideModal()"><img src="./../images/cancel.svg" /></button>
                <h2>Lorem ipsum dolor sit amet</h2>
                <div class="modalmiddleItem">
                    <div class="itemgap">
                    <p class="modalItem"><b>Date:</b></p>
                    <p class="modalItem"><b>Fees ($):</b></p>
                    <p class="modalItem"><b>Fine ($):</b></p>
                </div>
                <div class="itemgap">
                    <p class="modalItem"> 04/16/2025</p>
                    <p class="modalItem">350.00</p>
                    <p class="modalItem">50.00</p>
                </div>
            </div>
            <div class="feespopupbtns">
                <button class="action-btn btn-cancel" onclick="hideModal()">Cancel</button>
                <button class="action-btn btn-pay">$ Pay</button>
            </div>
    </div>


@endsection

@push('script')
  
@endpush
