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
                        <form id="report-filters-form">
                            <div class="request-leave-form student-report-filter-form">
                                <div class="input-grp">
                                    <label>Applicant School Year</label>
                                    <select name="school_year" required>
                                        <option value="1">2024-2025</option>
                                        <option value="2">2025-2026</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dsbdy-cmn-card">
                    <div class="sec-head">
                        <h2 class="mb-0">Report Type Selection</h2>
                        <p class="muted-sm">Choose between labels or lists format</p>
                    </div>
                    <div class="request-leave-form-wrp student-report-filter-form-wrp">

                        <form id="report-type-form" aria-labelledby="report-type-heading">
                            <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                <legend id="report-type-heading" class="sr-only">Report Type Selection</legend>

                                <div id="report-types" class="multi-input-grp grp-1">
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_type" value="applicant_status" checked />Applicant Status Reports
                                        </label>
                                    </div>
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_type" value="accepted_response"/>Accepted Applicant Response Reports
                                        </label>
                                    </div>
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_type" value="application"/>Application Reports
                                        </label>
                                    </div>
                                    <div class="input-grp">
                                        <label>
                                            <input type="radio" name="report_type" value="interview"/>Interview Reports
                                        </label>
                                    </div>
                                </div>

                                <div id="toggle-report-options" class="multi-input-grp report-options">

                                    <!-- Applicant Status Reports options -->
                                    <div class="report-column p-3" data-report="applicant_status">
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="applicant_status_by_name" checked />
                                                Status List by Applicant Name
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="applicant_status_by_school"/>
                                                Status List by High School
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="applicant_status_by_camp"/>
                                                Status List by Camp
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="applicant_status_by_status"/>
                                                Status List by Status
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Accepted Applicant Response Reports options -->
                                    <div class="report-column p-3" data-report="accepted_response" style="display: none;">
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="response_by_name"/>
                                                Response List by Applicant Name
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="response_by_school"/>
                                                Response List by Applicant Name
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="response_by_response"/>
                                                Response List by Response
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Application Reports Options -->
                                    <div class="report-column p-3" data-report="application" style="display: none;">
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="application_amounts_by_school"/>
                                                Application Amounts by High School
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="application_checklist"/>
                                                General Application Checklist
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="application_missing_items"/>
                                                Missing Items Report
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Interview Reports Options -->
                                    <div class="report-column p-3" data-report="interview" style="display: none;">
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="interview_schedule_by_date"/>
                                                Interview Schedule by Date
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="interview_schedule_by_name"/>
                                                Interview Schedule by Applicant Name
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="interview_schedule_by_school"/>
                                                Interview Schedule by High School
                                            </label>
                                        </div>
                                        <div class="input-grp">
                                            <label>
                                                <input type="radio" name="report_option" value="interview_summary"/>
                                                General Interview Summary
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
                            <label for="">Export Format</label>
                            <select id="" name="export_format" required>
                                <option value="pdf" selected>Pdf Document</option>
                            </select>
                        </div>

                        <div class="input-grp">
                            <label>Which High School(s) should be included?</label>
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
                            <button type="submit" id="generateReportBtn" class="cmn-btn generate-btn">Generate Reports</button>
                        </div>
                    </form>
                </div>
                
                <div class="dsbdy-cmn-card">
                    <div class="sec-head">
                        <h2 class="mb-0">Quick Actions</h2>
                    </div>
                    <div class="request-leave-form-wrp student-report-filter-form-wrp">
                        <button id="previewReportBtn" class="print-preview cmn-white-btn w-100"><img src="{{ asset('backend/assets/images/new_images/print-preview-icon.svg') }}" alt="Icon"> Print Preview</button>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</div>
<!-- Dashboard Body End -->
@endsection

@push('script')

<script>
$(function() {
    function toggleReportOptions() {
        const selectedReport = $('input[name="report_type"]:checked').val();

        $('#toggle-report-options .report-column').each(function() {
            const $section = $(this);
            const isVisible = $section.data('report') === selectedReport;
            $section.toggle(isVisible);

            if (!isVisible) {
                $section.find('input[type="radio"]').prop('checked', false);
            } else if (!$section.find('input[type="radio"]:checked').length) {
                $section.find('input[type="radio"]').first().prop('checked', true);
            }
        });
    }

    $('input[name="report_type"]').on('change', toggleReportOptions);
});
</script>

<script>
$(document).ready(function () {
    // Selectors
    const selectors = {
        reportFiltersForm: '#report-filters-form',
        reportTypeForm: '#report-type-form',
        outputOptionsForm: '#output-options-form',
    };

    // Routes
    const routes = {
        generateReport: '{{ route("report-management.generate-applicant-report") }}',
    };

    const $generateBtn = $('#generateReportBtn');
    const $previewBtn = $('#previewReportBtn');

    $generateBtn.on('click', function (e) {
        e.preventDefault();
        generateReport(false, $(this));
    });

    $previewBtn.on('click', function (e) {
        e.preventDefault();
        generateReport(true, $(this));
    });

    function generateReport(isPreview = false, $btn) {
        const formData = {
            school_year: $(`${selectors.reportFiltersForm} select[name="school_year"]`).val(),
            report_type: $(`${selectors.reportTypeForm} input[name="report_type"]:checked`).val(),
            report_option: $(`${selectors.reportTypeForm} input[name="report_option"]:checked`).val(),
            export_format: $(`${selectors.outputOptionsForm} select[name="export_format"]`).val(),
            is_preview: isPreview ? 1 : 0,
            _token: '{{ csrf_token() }}'
        };

        console.log(formData);
        return;

        // Validation
        if (!formData.school_year || !formData.report_type || !formData.report_option || !formData.export_format) {
            alert('Please fill in all required fields.');
            return;
        }

        $btn.prop('disabled', true).text('Generating...');

        $.ajax({
            url: routes.generateReport,
            method: 'POST',
            data: formData,
            xhrFields: { responseType: 'blob' },
            success: function (response, status, xhr) {
                if(formData.export_format === 'pdf') {
                    if (isPreview) {
                        previewPDF(response);
                    } else {
                        generatePDF(response, xhr);
                    }
                } else {
                    alert('Unsupported export format.');
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText || xhr.statusText);
                alert('Failed to generate PDF. Check console for details.');
            },
            complete: function () {
                $btn.prop('disabled', false).text(isPreview ? 'Print Preview' : 'Generate Report');
            }
        });
    }

    function previewPDF(blob) {
        const fileURL = window.URL.createObjectURL(blob);
        const previewWindow = window.open(fileURL, '_blank');
        if (previewWindow) {
            previewWindow.onload = () => URL.revokeObjectURL(fileURL);
        }
    }

    function generatePDF(blob, xhr) {
        const disposition = xhr.getResponseHeader('Content-Disposition');
        let fileName = 'alumni-report.pdf';

        if (disposition) {
            const matches = disposition.match(/filename="?([^"]*)"?.*$/);
            if (matches && matches[1]) fileName = matches[1];
        }

        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
});
</script>

@endpush