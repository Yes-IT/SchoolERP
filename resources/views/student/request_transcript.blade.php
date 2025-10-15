@extends('student.Layout.app')

@section('content')

<!-- Dashboard Begin -->
<div class="ds-breadcrumb">
    <h1>Request Transcript</h1>
    <ul>
        <li><a href="{{route('student.dashboard')}}">Dashboard</a> /</li>
        <li>Request Transcript</li>
    </ul>
</div>
<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp request-transcript-pg tbl-btn-new">
        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Transcripts</h2>
            </div>
            <div class="btn-wrp align-items-start">
                <div class="ibtn">
                    <button type="button" class="ibtn-icon">
                        <img src="{{asset('student/images/i-icon.svg')}}" alt="Icon">
                    </button>
                    <div class="ibtn-info lg rt p15">
                        <button type="button" class="ibtn-close" style="filter: brightness(0);">
                            <img src="{{asset('student/images/fa-times.svg')}}" alt="icon">
                        </button>
                        <h3 class="txt-primary mb-2">Important Notice:</h3>
                        <p>You cannot request a transcript if your tuition fees are not paid. Please clear all dues before applying.</p>
                    </div>
                </div>

                <button class="cmn-btn" data-bs-target="#newRequest" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> New Request
                </button>
            </div>
        </div>

        <div class="ds-cmn-tble count-row">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Payment Requirement</th>
                        <th>Payment Status</th>
                        <th>Payment Receipt</th>
                        <th>Application Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0</td>
                        <td>04/25/2025</td>
                        <td>Lorem ipsum dolor sit amet</td>
                        <td>Yes</td>
                        <td>
                            <div class="upcoming cmn-tbl-btn green-bg">Paid</div>
                        </td>
                        <td><button class="cmn-tbl-btn gap-10"><img src="{{asset('student/images/download-icon.svg')}}" alt="Icon"> Download</button></td>
                        <td>
                            <p class="green-txt">Approved</p>
                        </td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>04/25/2025</td>
                        <td>Lorem ipsum dolor sit amet</td>
                        <td>No</td>
                        <td>---</td>
                        <td>--</td>
                        <td>
                            <p class="green-txt">Approved</p>
                        </td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>04/25/2025</td>
                        <td>Lorem ipsum dolor sit amet</td>
                        <td>Yes</td>
                        <td>
                            <div class="upcoming cmn-tbl-btn red-bg">Failed</div>
                        </td>
                        <td><button class="cmn-tbl-btn gap-10"><img src="{{asset('student/images/download-icon.svg')}}" alt="Icon"> Download</button></td>
                        <td>
                            <p class="red-txt">Rejected</p>
                        </td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>04/25/2025</td>
                        <td>Lorem ipsum dolor sit amet</td>
                        <td>Yes</td>
                        <td>
                            <div class="upcoming cmn-tbl-btn yellow-bg">Pending</div>
                        </td>
                        <td>--</td>
                        <td>--</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tablepagination">
            <div class="tbl-pagination-inr">
                <ul>
                    <li><a href="#url"><img src="{{asset('student/images/arrow-left.svg')}}" alt="Icon"></a></li>
                    <li class="active"><a href="#url">1</a></li>
                    <li><a href="#url">2</a></li>
                    <li><a href="#url">3</a></li>
                    <li><a href="#url"><img src="{{asset('student/images/arrow-right.svg')}}" alt="Icon"></a></li>
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
<!-- End Of Dashboard -->

<!-- Attachments Modal Begin -->
<div class="modal fade cmn-popwrp pop650" id="newRequest" tabindex="-1" role="dialog" aria-labelledby="newRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <h2>New Request</h2>
                    <div class="new-request-form-wrp">
                        <form>
                            <div class="new-request-form">
                                <div class="autocomplete input-grp h48">
                                    <label for="dest">Destination</label>
                                    <input class="dest" type="text" placeholder="Lorem ipsum dolor sit amet" autocomplete="off">
                                    <div class="dist-list-wrp">
                                        <div class="dest-list" class="autocomplete-list" hidden></div>
                                    </div>
                                </div>
                                <div class="input-grp h48 paylink">
                                    <label>Payment Link</label>
                                    <div class="has-submit">
                                        <input type="url" placeholder="https://pay.example.com/share/invoice123xyz">
                                        <input type="submit" value="Pay Now">
                                    </div>
                                </div>
                                <button type="button" value="Submit" class="cmn-btn btn-sm" data-bs-target="#success" data-bs-toggle="modal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Of Attachments Modal -->

<!-- Success Modal Begin -->
<div class="modal fade cmn-popwrp popwrp w400" id="success" tabindex="-1" role="dialog" aria-labelledby="success" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="{{asset('student/images/cross-icon.svg')}}" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-inr-content-wrp">
                    <div class="modal-icon">
                        <img src="{{asset('student/images/check-circle-primary.svg')}}" alt="Bin Icon">
                    </div>
                    <div class="sec-head head-center">
                        <h2>Successful</h2>
                        <p>Your transcript request has been submitted successfully.</p>
                        <div class="btn-wrp">
                            <button type="submit" data-bs-dismiss="modal" aria-label="Close" class="cmn-btn btn-sm">Okay</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Of Success Modal -->
@endsection

@push('page_script')

@endpush
