@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">

    <div class="ds-breadcrumb">
        <h1>Report Management</h1>
        <ul>
            <li><a href="./dashboard">Dashboard</a> /</li>
            <li>Report Management</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="ds-cmn-table-wrp">
            <div class="ds-content-head">
                <div class="sec-head">
                    <h2>Reports</h2>
                </div>
            </div>
            
            <div class="ds-cmn-info-cards-wrp">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ds-cmn-info-card">
                            <div class="ds-cmn-ic-head">
                                <div class="ds-cmn-ic-icon">
                                    <img src="{{ asset('images/report/report-m-card-icon-1.svg') }}" alt="Icon">
                                </div>
                                <div class="ds-cmn-ic-count">
                                    <span>12 reports</span>
                                </div>
                            </div>
                            <div class="ds-cmn-ic-body">
                                <h3>Student Information</h3>
                                <p>Student profiles, parent info, class assignments and teacher data</p>
                            </div>
                            <div class="ds-cmn-ic-ftr">
                                <a href="#" class="cmn-btn w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#studentInfoModal">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ds-cmn-info-card">
                            <div class="ds-cmn-ic-head">
                                <div class="ds-cmn-ic-icon">
                                    <img src="{{ asset('images/report/report-m-card-icon-2.svg') }}" alt="Icon">
                                </div>
                                <div class="ds-cmn-ic-count">
                                    <span>12 reports</span>
                                </div>
                            </div>
                            <div class="ds-cmn-ic-body">
                                <h3>Attendance Report</h3>
                                <p>Daily attendance, checklists, forms, and comprehensive reports</p>
                            </div>
                            <div class="ds-cmn-ic-ftr">
                                <a href="{{ route('report-management.attendance-report') }}" class="cmn-btn w-100 btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ds-cmn-info-card">
                            <div class="ds-cmn-ic-head">
                                <div class="ds-cmn-ic-icon">
                                    <img src="{{ asset('images/report/report-m-card-icon-3.svg') }}" alt="Icon">
                                </div>
                                <div class="ds-cmn-ic-count">
                                    <span>12 reports</span>
                                </div>
                            </div>
                            <div class="ds-cmn-ic-body">
                                <h3>Class Report</h3>
                                <p>Student profiles, parent info, class assignments and teacher data</p>
                            </div>
                            <div class="ds-cmn-ic-ftr">
                                <a href="{{ route('report-management.class-report') }}" class="cmn-btn w-100 btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ds-cmn-info-card">
                            <div class="ds-cmn-ic-head">
                                <div class="ds-cmn-ic-icon">
                                    <img src="{{ asset('images/report/report-m-card-icon-4.svg') }}" alt="Icon">
                                </div>
                                <div class="ds-cmn-ic-count">
                                    <span>12 reports</span>
                                </div>
                            </div>
                            <div class="ds-cmn-ic-body">
                                <h3>Applicant Report</h3>
                                <p>Applicant management, admission reports and process tracking</p>
                            </div>
                            <div class="ds-cmn-ic-ftr">
                                <a href="{{ route('report-management.applicant-report') }}" class="cmn-btn w-100 btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ds-cmn-info-card">
                            <div class="ds-cmn-ic-head">
                                <div class="ds-cmn-ic-icon">
                                    <img src="{{ asset('images/report/report-m-card-icon-4.svg') }}" alt="Icon">
                                </div>
                                <div class="ds-cmn-ic-count">
                                    <span>12 reports</span>
                                </div>
                            </div>
                            <div class="ds-cmn-ic-body">
                                <h3>School Grade Report</h3>
                                <p>Track applicant performance, admission results, and grading progress.</p>
                            </div>
                            <div class="ds-cmn-ic-ftr">
                                <a href="{{ route('report-management.attendance-grade-report') }}" class="cmn-btn w-100 btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ds-cmn-info-card">
                            <div class="ds-cmn-ic-head">
                                <div class="ds-cmn-ic-icon">
                                    <img src="{{ asset('images/report/report-m-card-icon-4.svg') }}" alt="Icon">
                                </div>
                                <div class="ds-cmn-ic-count">
                                    <span>12 reports</span>
                                </div>
                            </div>
                            <div class="ds-cmn-ic-body">
                                <h3>Tuition Report</h3>
                                <p>Generate reports on tuition payments, fee status, and related processes.</p>
                            </div>
                            <div class="ds-cmn-ic-ftr">
                                <a href="{{ route('report-management.tuition-report') }}" class="cmn-btn w-100 btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>

</div>
<!-- Dashboard Body End -->


<!-- Select Report Template Modal Begin -->
<div class="modal fade cmn-popwrp pop800" id="studentInfoModal" tabindex="-1" role="dialog" aria-labelledby="studentInfoModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="{{ asset('backend') }}/assets/images/new_images/cross-icon.svg" alt="Icon"></span>
                </button>
                <div class="modal-body">
                    <div class="cmn-pop-inr-content-wrp">
                        <h3>Select Report Template</h3>
                        <div class="new-request-form-wrp">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="ds-cmn-info-card">
                                        <div class="ds-cmn-ic-head">
                                            <div class="ds-cmn-ic-icon">
                                                <img src="{{ asset('images/report/report-m-card-icon-1.svg') }}" alt="Icon">
                                            </div>
                                        </div>
                                        <div class="ds-cmn-ic-body">
                                            <h3><a href="{{ route('report-management.general-student-report') }}">General Student Reports</a></h3>
                                            <p>Generate printable student labels and list</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="ds-cmn-info-card">
                                        <div class="ds-cmn-ic-head">
                                            <div class="ds-cmn-ic-icon">
                                                <img src="{{ asset('images/report/report-m-card-icon-1.svg') }}" alt="Icon">
                                            </div>
                                        </div>
                                        <div class="ds-cmn-ic-body">
                                            <h3><a href="{{ route('report-management.teacher-report') }}">Teacher Reports</a></h3>
                                            <p>Teachers and their assigned classes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-request-form-wrp mt-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="ds-cmn-info-card">
                                        <div class="ds-cmn-ic-head">
                                            <div class="ds-cmn-ic-icon">
                                                <img src="{{ asset('images/report/report-m-card-icon-1.svg') }}" alt="Icon">
                                            </div>
                                        </div>
                                        <div class="ds-cmn-ic-body">
                                            <h3><a href="{{ route('report-management.alumni-report') }}">Alumni Reports</a></h3>
                                            <p>Generate alumni complete list</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="new-request-form-wrp mt-4">
                            <div class="ds-cmn-ic-ftr">
                                <a href="{{ route('report-management.tuition-report') }}" class="cmn-btn btn-sm">Select</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Of Select Report Template Modal -->

@endsection