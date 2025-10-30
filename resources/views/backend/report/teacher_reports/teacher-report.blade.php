@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Teacher Reports</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Report Management</a> /</li>
                <li>Teacher Reports</li>
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
                                        <label>School Year</label>
                                        <select name="session_id" required>
                                            @forelse($data['school_years'] as $schoolYear)
                                                <option value="{{ $schoolYear->id}}">
                                                    {{ $schoolYear->start_date }} - {{ $schoolYear->end_date }}
                                                </option>
                                            @empty
                                                <option value="">No school years available</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Year Status</label>
                                        <select name="year_status_id" required>
                                            @forelse($data['year_statuses'] as $yearStatus)
                                                <option value="{{ $yearStatus->id }}">
                                                    {{ $yearStatus->name }}
                                                </option>
                                            @empty
                                                <option value="">No year status available</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Classes</label>
                                        <select name="class_id" required>
                                            @forelse($data['classes'] as $class)
                                                <option value="{{ $class->id}}">{{ $class->name}}</option>
                                            @empty
                                            <option value="">No class available</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="dsbdy-cmn-card">
                        <div class="sec-head">
                            <h2 class="mb-0">Report Type Selection</h2>
                            <p class="muted-sm">Choose a teacher report</p>
                        </div>
                        <div class="request-leave-form-wrp student-report-filter-form-wrp">
                            <form id="report-type-form" aria-labelledby="report-type-heading">
                                <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                    <div class="multi-input-grp report-options">
                                        <div class="report-column p-3">
                                            <div class="input-grp">
                                                <label for="rpt-1"><input type="radio" id="rpt-1" name="report_type" value="teacher_list" checked /> Teacher List</label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-2"><input type="radio" id="rpt-2" name="report_type" value="teacher_home_address_labels"/> Teacher Home Address Labels</label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-3"><input type="radio" id="rpt-3" name="report_type" value="teacher_name_labels"/> Teacher Name Labels</label>
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
                                <label for="export_format">Export Format</label>
                                <select id="export_format" name="export_format" required>
                                    <!-- <option value="" disabled selected>Select Document Type</option> -->
                                    <option value="pdf">PDF Document</option>
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
                            <div class="opt-cta">
                                <button type="submit" id="print-preview-btn" class="cmn-btn">Print Preview</button>
                            </div>
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
$(document).ready(function() {
    // Selectors
    const selectors = {
        reportFiltersForm: '#report-filters-form',
        reportTypeForm: '#report-type-form',
        outputOptionsForm: '#output-options-form',
        generateBtn: '#output-options-form button[type="submit"]',
        previewBtn: '#print-preview-btn'
    };

    // Routes
    const routes = {
        generatePDF: '{{ route("report-management.generate-teacher-pdf") }}',
        previewPDF: '{{ route("report-management.preview-teacher-report") }}'
    };

    // Combine form data from multiple forms
    function collectCombinedFormData(forms) {
        const combinedData = {};
        forms.forEach(selector => {
            $(selector).serializeArray().forEach(item => {
                if (combinedData[item.name]) {
                    if (!Array.isArray(combinedData[item.name])) {
                        combinedData[item.name] = [combinedData[item.name]];
                    }
                    combinedData[item.name].push(item.value);
                } else {
                    combinedData[item.name] = item.value;
                }
            });
        });
        return combinedData;
    }

    // Required fields
    const requiredFields = [
        `${selectors.reportFiltersForm} select[name="session_id"]`,
        `${selectors.reportFiltersForm} select[name="year_status_id"]`,
        `${selectors.reportFiltersForm} select[name="class_id"]`,
        `${selectors.outputOptionsForm} select[name="export_format"]`
    ];

    const $generateBtn = $(selectors.generateBtn);
    const $previewBtn = $(selectors.previewBtn);

    // Disable buttons initially
    $generateBtn.prop('disabled', true);
    $previewBtn.prop('disabled', true);

    function validateRequiredFields() {
        let allFilled = true;

        requiredFields.forEach(selector => {
            const $field = $(selector);
            if (!$field.val()) {
                allFilled = false;
            }
        });

        $generateBtn.prop('disabled', !allFilled);
        $previewBtn.prop('disabled', !allFilled);
    }

    $(document).on('change', 'select', validateRequiredFields);
    validateRequiredFields();

    // Generate Report
    $(selectors.outputOptionsForm).on('submit', function(e) {
        e.preventDefault();

        const $btn = $generateBtn;
        const combinedData = collectCombinedFormData([
            selectors.reportFiltersForm,
            selectors.reportTypeForm,
            selectors.outputOptionsForm
        ]);

        $.ajax({
            url: routes.generatePDF,
            method: 'POST',
            data: combinedData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            xhrFields: { responseType: 'blob' },
            beforeSend: function() {
                $btn.prop('disabled', true).text('Generating...');
            },
            success: function(response, status, xhr) {

                // console.log(response);
                // return;

                const blob = new Blob([response], { type: 'application/pdf' });
                const disposition = xhr.getResponseHeader('Content-Disposition');
                let fileName = 'teacher-report.pdf';

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
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText || xhr.statusText);
                alert('Failed to generate PDF. Check console for details.');
            },
            complete: function() {
                $btn.prop('disabled', false).text('Generate Reports');
            }
        });
    });

    // Print Preview
    $(selectors.previewBtn).on('click', function(e) {
        e.preventDefault();

        const $btn = $(this);
        const combinedData = collectCombinedFormData([
            selectors.reportFiltersForm,
            selectors.reportTypeForm,
            selectors.outputOptionsForm
        ]);

        $.ajax({
            url: routes.previewPDF,
            method: 'POST',
            data: combinedData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            xhrFields: { responseType: 'blob' },
            beforeSend: function() {
                $btn.prop('disabled', true).text('Generating...');
            },
            success: function(blob) {
                const fileURL = window.URL.createObjectURL(blob);
                const previewWindow = window.open(fileURL, '_blank');
                if (previewWindow) {
                    previewWindow.onload = () => URL.revokeObjectURL(fileURL);
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'Failed to generate preview.';
                alert(errorMsg);
                console.error('Preview error:', xhr);
            },
            complete: function() {
                $btn.prop('disabled', false).text('Print Preview');
            }
        });
    });
});
</script>

@endpush