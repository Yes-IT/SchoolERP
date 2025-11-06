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
                            <form id="report-filters-form">
                                <div class="request-leave-form student-report-filter-form">
                                    <div class="input-grp">
                                        <label>School Year</label>
                                        <select name="school_year" required>
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
                                        <select name="year_status" id="year_status" required>
                                            <option value="all" selected>All</option>
                                            @forelse($data['year_statuses'] as $yearStatus)
                                                <option value="{{ $yearStatus->id }}">{{ $yearStatus->name }}</option>
                                            @empty
                                                <option value="">No year status available</option>
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
                            <p class="muted-sm">Choose a alumni report</p>
                        </div>
                        <div class="request-leave-form-wrp student-report-filter-form-wrp">
                            <form id="report-type-form" aria-labelledby="report-type-heading">
                                <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                    <div class="multi-input-grp report-options">
                                        <div class="report-column p-3 w-100">
                                            <div class="input-grp">
                                                <label for="rpt-1"><input type="radio" name="report_type" value="alumni_list" checked /> Alumni List</label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-2"><input type="radio" name="report_type" value="alumni_home_address_labels"/> Alumni Home Address Labels</label>
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
                              <label for="exportOption">Export Format</label>
                              <select id="exportOption" name="export_format" required>
                                    <option value="pdf" selected>Pdf Document</option>
                              </select>
                            </div>

                            <fieldset class="input-grp" id="sort_order_fieldset">
                                <label>Sort Order</label>

                                <label class="opt-row">
                                    <input type="radio" name="sort_order" value="name" checked>
                                    <span class="opt-label">By Name</span>
                                </label>

                                <label class="opt-row">
                                    <input type="radio" name="sort_order" value="year">
                                    <span class="opt-label">By Year</span>
                                </label>
                            </fieldset>

                            <div class="input-grp checkbox">
                                <label class="text-muted">
                                    <input type="checkbox" name="show_year" id="show_year" />
                                    Show year in the corner of label
                                </label>
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
    $(function () {
        const $yearSelect = $('#year_status');
        const $sortFieldset = $('#sort_order_fieldset');
        const $sortInputs = $sortFieldset.find('input[name="sort_order"]');

        function toggleSortOptions() {
            const isAll = $yearSelect.val() === 'all';
            $sortInputs.prop('disabled', !isAll);
            $sortFieldset.css('opacity', isAll ? 1 : 0.5);
        }

        $yearSelect.on('change', toggleSortOptions);
        toggleSortOptions();
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
        generateReport: '{{ route("report-management.generate-alumni-report") }}',
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
            year_status: $(`${selectors.reportFiltersForm} select[name="year_status"]`).val(),
            report_type: $(`${selectors.reportTypeForm} input[name="report_type"]:checked`).val(),
            export_format: $(`${selectors.outputOptionsForm} select[name="export_format"]`).val(),
            sort_order: $(`${selectors.outputOptionsForm} input[name="sort_order"]:checked`).val(),
            show_year: $(`${selectors.outputOptionsForm} input[name="show_year"]`).is(':checked') ? 1 : 0,
            is_preview: isPreview ? 1 : 0,
            _token: '{{ csrf_token() }}'
        };

        // Validation
        if (!formData.school_year || !formData.year_status || !formData.report_type || !formData.export_format) {
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