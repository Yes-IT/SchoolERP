@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Alumni Reports</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Report Management</a> /</li>
                <li>Alumni Reports</li>
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
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="dsbdy-cmn-card">
                        <div class="sec-head">
                            <h2 class="mb-0">Report Type Selection</h2>
                            <p class="muted-sm">Choose a alumni report</p>
                        </div>
                        <div class="request-leave-form-wrp student-report-filter-form-wrp">
                            <form id="report-type-form" aria-labelledby="report-type-heading">
                                <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                    <div class="multi-input-grp report-options">
                                        <div class="report-column p-3 w-100">
                                            <div class="input-grp">
                                                <label for="rpt-1"><input type="checkbox" name="report_type" value="student-parent"/> Alumni List</label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-2"><input type="checkbox" name="report_type" value="student-names-en"/> Alumni Home Address Labels</label>
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

                            <fieldset class="opt-group">
                                <legend class="opt-title">Sort Order</legend>
                            
                                <label class="opt-row">
                                  <input type="radio" name="sort_order" value="student_name" checked>
                                  <span class="opt-label">By Name</span>
                                </label>
                            
                                <label class="opt-row">
                                  <input type="radio" name="sort_order" value="high_school">
                                  <span class="opt-label">By Year</span>
                                </label>
                            </fieldset>

                            <div class="input-grp checkbox">
                                <label class="text-muted">
                                    <input type="checkbox" name="include-applicant" id="include-applicant">
                                    Show year in the corner of label
                                </label>
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