@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
        <!-- Dashboard Body Begin -->
        <div class="dashboard-body dspr-body-outer">
            
            <div class="ds-breadcrumb">
                <h1>Leaves</h1>
                <ul>
                    <li><a href="../dashboard.html">Dashboard</a> /</li>
                    <li><a href="dashboard.html">Transcript</a> /</li>
                    <li>Request Transcript /</li>
                    <li><a href="{{ route('leave.transcript.college.index') }}">College</a></li>
                </ul>
            </div>
            <div class="ds-pr-body">

                <div class="ds-cmn-table-wrp tab-wrapper">
                    <div class="ds-content-head">
                        <div class="sec-head">
                            <h2>College List</h2>
                        </div>
                        <div class="ds-cmn-filter-wrp">
                                    <div class="dsbdy-filter-wrp p-0">
                                        <button class="cmn-btn h-40" data-bs-target="#addCollege" data-bs-toggle="modal"><i class="fa-solid fa-plus"></i> Add Request
                                        </button>
                                    </div>
                                </div>
                    </div>
                    

                    <div class="ds-cmn-tble count-row" style="">
                        <table>
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>College Name</th>
                                    <th>Funded</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Lorem ipsum dolor</td>
                                    <td>Yes</td>
                                    <td>$ 100</td>
                                    <td>04/01/2025</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Lorem ipsum dolor</td>
                                    <td>No</td>
                                    <td>$ 100</td>
                                    <td>04/01/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="tablepagination">
                        <div class="tbl-pagination-inr">
                            <ul>
                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-left.svg" alt="Icon"></a></li>
                                <li class="active"><a href="#url">1</a></li>
                                <li><a href="#url">2</a></li>
                                <li><a href="#url">3</a></li>
                                <li><a href="#url"><img src="{{ asset('backend') }}/assets/images/new_images/arrow-right.svg" alt="Icon"></a></li>
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
                                    </select>
                                </div>
                            </form>
                            <p>of 2 results</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    <!-- End Of Dashboard Body -->


    <!-- Add college Modal Begin -->

        <div class="modal fade cmn-popwrp pop650" id="addCollege" tabindex="-1" role="dialog" aria-labelledby="newRequest" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-inr-content-wrp">
                            <h2>Add New College</h2>
                            <div class="new-request-form-wrp">
                                <form>
                                    <div class="new-request-form">
                                        <div class="autocomplete input-grp h48">
                                            <label for="dest">College Name</label>
                                            <input class="dest" type="text" placeholder="Lorem ipsum dolor sit amet" autocomplete="off">
                                        </div>
                                        <div class="input-grp h48 paylink">
                                            <label>Funded</label>
                                            <div class="has-submit">
                                                <input type="checkbox">
                                            </div>
                                        </div>
                                        <div class="autocomplete input-grp h48">
                                            <label for="dest">Amount</label>
                                            <input class="dest" type="text" placeholder="Lorem ipsum dolor sit amet" autocomplete="off">
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

    <!-- Add college Leave Modal -->

     <!-- Success Modal Begin -->

        <div class="modal fade cmn-popwrp popwrp w400" id="success" tabindex="-1" role="dialog" aria-labelledby="success" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
                    </button>

                    <div class="modal-body">
                        <div class="cmn-pop-inr-content-wrp">
                            <div class="modal-icon">
                                <img src="{{ asset('backend') }}/assets/images/new_images/check-circle-primary.svg" alt="Bin Icon">
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