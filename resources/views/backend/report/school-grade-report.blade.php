@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>School Grade Reports</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Report Management</a> /</li>
                <li>School Grade Reports</li>
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
                                        <label>School Year</label>
                                        <select >
                                            <option value="2024-2025">2024-2025</option>
                                            <option value="2025-2026">2025-2026</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Year Status</label>
                                        <select >
                                            <option value="Shana Bias">Shana Bias</option>
                                            <option value="type-1">Type 1</option>
                                            <option value="type-2">Type 2</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Semester</label>
                                        <select >
                                            <option value="Shana Bias">Select Semester</option>
                                            <option value="type-1">Type 1</option>
                                            <option value="type-2">Type 2</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="dsbdy-cmn-card">
                        <div class="sec-head">
                            <h2 class="mb-0">Report Type Selection</h2>
                            <p class="muted-sm">Choose a grade</p>
                        </div>
                        <div class="request-leave-form-wrp student-report-filter-form-wrp">
                            <form id="report-type-form" aria-labelledby="report-type-heading">
                                <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                    <div class="multi-input-grp report-options">
                                        <div class="report-column p-3">
                                            <div class="input-grp">
                                                <label for="rpt-1"><input type="checkbox" name="report_type" value="student-parent"/> School Grade Sheet</label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-2"><input type="checkbox" name="report_type" value="student-names-en"/> Students with Missing Grades</label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-3"><input type="checkbox" name="report_type" value="student-highschools"/> Classes with Missing Grades </label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-3"><input type="checkbox" name="report_type" value="student-highschools"/> Student with Failing Grades </label>
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

                            <div class="input-grp">
                              <label for="state">Select Class</label>
                              <select id="state" name="state" required="">
                                    <option value="" disabled="" selected="">Select Class</option>
                              </select>
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