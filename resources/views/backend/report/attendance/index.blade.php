@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <!-- Dashboard Body Begin -->
    <div class="dashboard-body dspr-body-outer">
        <div class="ds-breadcrumb">
            <h1>Attendance Reports</h1>
            <ul>
                <li><a href="../dashboard.html">Dashboard</a> /</li>
                <li><a href="./dashboard.html">Report Management</a> /</li>
                <li>Attendance Reports</li>
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
                                        <select name="school_year" id="school_year">
                                            @foreach($data['school_years'] as $schoolYear)
                                                <option value="{{ $schoolYear->id }}">{{ $schoolYear->start_date }} - {{ $schoolYear->end_date }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Year Status</label>
                                        <select name="year_status" id="year_status">
                                            @foreach($data['year_statuses'] as $yearStatus)
                                                <option value="{{ $yearStatus->id }}">{{ $yearStatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Semester</label>
                                        <select name="semester" id="semester">
                                            @foreach($data['semesters'] as $semester)
                                                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dsbdy-cmn-card">
                        <div class="sec-head">
                            <h2 class="mb-0">Report Type Selection</h2>
                            <p class="muted-sm">Choose a attendance report</p>
                        </div>
                        <div class="request-leave-form-wrp student-report-filter-form-wrp">
                            <form id="report-type-form" aria-labelledby="report-type-heading">
                                <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                    <div class="multi-input-grp report-options">
                                        <div class="report-column p-3">
                                            <div class="input-grp">
                                                <label for="rpt-1">
                                                    <input type="checkbox" name="report_type" value="attendance-student" id="rpt-1" /> Attendance Details By Student
                                                </label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-2">
                                                    <input type="checkbox" name="report_type" value="attendance-details-class" id="rpt-2" /> Attendance Details By Class
                                                </label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-3">
                                                    <input type="checkbox" name="report_type" value="class-absences-summary" id="rpt-3" /> Class Absences Summary For Teachers
                                                </label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-4">
                                                    <input type="checkbox" name="report_type" value="excessive-absence-student" id="rpt-4" /> Excessive Absence Report - By Student
                                                </label>
                                            </div>
                                            <div class="input-grp">
                                                <label for="rpt-5">
                                                    <input type="checkbox" name="report_type" value="excessive-absence-class" id="rpt-5" /> Excessive Absence Report - By Class
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
                                <label for="export_format">Export Format</label>
                                <select id="export_format" name="export_format" required>
                                    <option value="" disabled selected>Pdf Document</option>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                </select>
                            </div>

                            <div class="input-grp">
                                <label for="student_select">Select Student</label>
                                <select id="student_select" name="student_id" required>
                                    <option value="" disabled selected>Select Student</option>
                                    @foreach($data['students'] as $student)
                                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-grp">
                                <label for="start_date">Enter Start Date</label>
                                <input type="date" name="start_date" id="start_date" required>
                            </div>

                            <div class="input-grp">
                                <label for="end_date">Enter End Date</label>
                                <input type="date" name="end_date" id="end_date" required>
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
                            <form id="quick-actions-form">
                                <div class="multi-input-grp report-options">
                                    <div class="report-column w-100 p-2">
                                        <div class="input-grp w-100">
                                            <button type="button"
                                                    class="cmn-btn w-100"
                                                    id="print_preview_btn">
                                                Print Preview
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>                           
            </div>
            
        </div>

        <div id="print-preview-container" style="display:none; margin-top:2rem;">
            <iframe id="preview-iframe" style="width:100%; height:800px; border:1px solid #ddd;"></iframe>
        </div>

    </div>
    <!-- Dashboard Body End -->
@endsection

@push('script')

    <script>
        $(function () {

            // -------------------------------------------------
            // 1. Generate Reports → ONLY DOWNLOAD PDF
            // -------------------------------------------------
            $('.generate-btn').on('click', function (e) {
                e.preventDefault();
                generateReport(false); // false = no preview, just download
            });

            // -------------------------------------------------
            // 2. Print Preview → ONLY OPEN PRINT DIALOG (Ctrl + P)
            // -------------------------------------------------
            $('#print_preview_btn').on('click', function () {
                generateReport(true); // true = preview only, no download
            });

            // -------------------------------------------------
            // Core function
            // -------------------------------------------------
            function generateReport(isPreview = false) {
                const formData = {
                    school_year:   $('#school_year').val(),
                    year_status:   $('#year_status').val(),
                    semester:      $('#semester').val(),
                    report_types:  [],
                    export_format: $('#export_format').val(),
                    student_id:    $('#student_select').val(),
                    start_date:    $('#start_date').val(),
                    end_date:      $('#end_date').val(),
                    print_preview: isPreview ? 1 : 0,
                    _token:        '{{ csrf_token() }}'
                };

                $('input[name="report_type"]:checked').each(function () {
                    formData.report_types.push($(this).val());
                });

                // ---- Validation ----
                if (!formData.school_year || !formData.year_status || !formData.semester) {
                    Toast.fire({ icon: 'error', title: 'Please select School Year, Year Status and Semester.' });
                    return;
                }
                if (formData.report_types.length === 0) {
                    Toast.fire({ icon: 'error', title: 'Please select at least one report type.' });
                    return;
                }
                if (!formData.student_id || !formData.start_date || !formData.end_date) {
                    Toast.fire({ icon: 'error', title: 'Please select a Student and fill Start / End dates.' });
                    return;
                }
                if (!formData.export_format) {
                    Toast.fire({ icon: 'error', title: 'Please select Export Format.' });
                    return;
                }

                // ---- Disable buttons ----
                $('.generate-btn').prop('disabled', true).text('Generating...');
                $('#print_preview_btn').prop('disabled', true).text('Preparing...');

                $.ajax({
                    url: '{{ route("attendance.reports.generate") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {

                        // =============================================
                        // CASE 1: Generate Reports → ONLY DOWNLOAD
                        // =============================================
                        if (!isPreview) {
                            response.pdfs.forEach(pdf => {
                                const a = document.createElement('a');
                                a.href = pdf.base64;
                                a.download = pdf.filename;
                                a.click();
                            });
                            return;
                        }

                        // =============================================
                        // CASE 2: Print Preview → ONLY PRINT DIALOG
                        // =============================================
                        if (isPreview && response.html) {
                            // Create hidden iframe (never shown on screen)
                            const iframe = document.createElement('iframe');
                            iframe.style.position = 'fixed';
                            iframe.style.right = '0';
                            iframe.style.bottom = '0';
                            iframe.style.width = '0';
                            iframe.style.height = '0';
                            iframe.style.border = 'none';
                            document.body.appendChild(iframe);

                            const doc = iframe.contentWindow.document;
                            doc.open();
                            doc.write(response.html);
                            doc.close();

                            // Add print styles
                            const style = doc.createElement('style');
                            style.textContent = `
                                @media print {
                                    body { margin: 0; padding: 10mm; font-family: "DejaVu Sans", sans-serif; }
                                    .no-print { display: none !important; }
                                }
                                body { font-family: "DejaVu Sans", sans-serif; }
                            `;
                            doc.head.appendChild(style);

                            // Wait for render → open print dialog
                            setTimeout(() => {
                                iframe.contentWindow.focus();
                                iframe.contentWindow.print();

                                // Remove iframe after print dialog closes
                                iframe.contentWindow.onfocus = () => {
                                    setTimeout(() => iframe.remove(), 500);
                                };
                            }, 600);
                        }
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || 'Something went wrong.');
                    },
                    complete: function () {
                        $('.generate-btn').prop('disabled', false).text('Generate Reports');
                        $('#print_preview_btn').prop('disabled', false).text('Print Preview');
                    }
                });
            }
        });
    </script>

@endpush