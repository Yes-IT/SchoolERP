@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">
    <div class="ds-breadcrumb">
        <h1>Applicant Reports</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Report Management</a> /</li>
            <li>Applicant Reports</li>
        </ul>
    </div>
    <div class="ds-pr-body">
        <div class="ds-bdy-content w-100 align-items-start">

            <div class="w55 d-flex flex-column gap-4">
                <div class="dsbdy-cmn-card">
                    <div class="sec-head">
                        <h2>Reports Filters</h2>
                    </div>
                    <div class="request-leave-form-wrp student-report-filter-form-wrp">
                        <form>
                            <div class="request-leave-form student-report-filter-form">
                                <div class="input-grp">
                                    <label>Applicant School Year</label>
                                    <select >
                                        <option value="2024-2025">2024-2025</option>
                                        <option value="2025-2026">2025-2026</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="dsbdy-cmn-card">
                    <div class="sec-head">
                        <h2 class="mb-0">Report Type Selection</h2>
                    </div>
                    <div class="request-leave-form-wrp student-report-filter-form-wrp">
                        <form id="report-type-form" aria-labelledby="report-type-heading">
                            <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                <legend id="report-type-heading" class="sr-only">Report Type Selection</legend>
                                <div class="multi-input-grp grp-1">
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_format" value="labels"/>Applicant Status Reports
                                        </label>
                                    </div>
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_format" value="lists" checked/>Accepted Applicant Response Reports
                                        </label>
                                    </div>
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_format" value="lists" checked/>Application Reports
                                        </label>
                                    </div>
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_format" value="lists" checked/>Interview Reports
                                        </label>
                                    </div>
                                </div>
                                <div class="multi-input-grp report-options">
                                    <div class="report-column p-3">
                                        <div class="input-grp">
                                            <label for="rpt-1">
                                                <input type="checkbox" name="report_type" value="student-parent"/>
                                                Status List by Applicant Name
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label for="rpt-2">
                                                <input type="checkbox" name="report_type" value="student-names-en"/>
                                                Status List by High School
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label for="rpt-3">
                                                <input type="checkbox" name="report_type" value="student-highschools"/>
                                                Status List by Camp
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label for="rpt-4">
                                                <input type="checkbox" name="report_type" value="student-separated-camps"/>
                                                Status List by Status
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w45 d-flex flex-column gap-4">
                <div class="dsbdy-cmn-card output-options-card">
                    <div class="sec-head">
                        <h3 class="h2-title">Output Options</h3>
                    </div>

                    <form class="request-leave-form output-options-filter" id="output-options-form" aria-labelledby="output-options-heading">
                        <div class="input-grp">
                            <label for="state">Export Format</label>
                            <select id="state" name="state" required="">
                                <option value="" disabled="" selected="">Pdf Document</option>
                            </select>
                        </div>

                        <div class="input-grp mb-0">
                            <label for="state">Which High School(s) should be included?</label>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <input type="radio" name="sort_order" value="student_name" checked>
                                <label for="student_name">All</label>
                            </div>
                            <div class="d-flex gap-1 align-content-start">
                                <div style="width:fit-content">
                                    <input type="radio" name="sort_order" value="student_name">
                                </div>
                                <div class="w-100">
                                    <div><label for="student_name">Specific High School(s):</label></div>
                                    <div>
                                        <select>
                                            <option value="">Select High School(s)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-grp mb-0">
                            <label for="state">Which dates should be included?</label>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <input type="radio" name="sort_order" value="student_name" checked>
                                <label for="student_name">All</label>
                            </div>
                            <div class="">
                                <div>
                                    <input type="radio" name="sort_order" value="student_name" checked>
                                    <label for="student_name">Specific dates:</label>
                                </div>
                                <div class="input-grp">
                                  <label for="state">Enter Start Date</label>
                                  <input type="date" name="start_date" required="">
                                </div>
    
                                <div class="input-grp">
                                  <label for="state">Enter End Date</label>
                                  <input type="date" name="end_date" required="">
                                </div>
                            </div>
                        </div>
                    
                        <div class="opt-cta">
                            <button type="submit" class="cmn-btn generate-btn">Generate Reports</button>
                        </div>
                    </form>
                </div>
                
                <div class="dsbdy-cmn-card">
                    <div class="sec-head">
                        <h2 class="mb-0">Quick Actions</h2>
                    </div>
                    <div class="request-leave-form-wrp student-report-filter-form-wrp">
                        <form id="report-type-form" aria-labelledby="report-type-heading">
                            <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                <div class="multi-input-grp report-options">
                                    <div class="report-column w-100 p-2">
                                        <div class="input-grp w-100">
                                            <label for="rpt-1"><input type="checkbox" name="report_type" value="student-parent"/> Print Preview</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</div>
<!-- Dashboard Body End -->
@endsection