@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')

<!-- Dashboard Body Begin -->
<div class="dashboard-body dspr-body-outer">

    <div class="ds-breadcrumb">
        <h1>General Student Reports</h1>
        <ul>
            <li><a href="../dashboard.html">Dashboard</a> /</li>
            <li><a href="./dashboard.html">Report Management</a> /</li>
            <li>General Student Reports</li>
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
                        <form id="report-filters-form" aria-labelledby="report-filters-heading" method="post" action="">
                            <div class="request-leave-form student-report-filter-form">
                                <div class="input-grp">
                                    <label>School Year</label>
                                    <select name="school_year">
                                        @foreach($data['classes'] as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-grp">
                                    <label>Year Status</label>
                                    <select name="year_status">
                                        <option value="Shana Bias">Shana Bias</option>
                                        <option value="type-1">Type 1</option>
                                        <option value="type-2">Type 2</option>
                                    </select>
                                </div>

                                <div class="input-grp checkbox">
                                    <label>
                                        <input type="checkbox" name="include_applicant" id="include-applicant">
                                        Include Applicants
                                    </label>
                                </div>

                                <div class="multi-input-grp" id="applicant-options" style="display: none;">
                                    <div class="input-grp">
                                        <label>Applicants Status</label>
                                        <select name="applicants_status">
                                            <option value="">Select Status</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Accept Category</label>
                                        <select name="accept_category">
                                            <option value="">Select Category</option>
                                            <option value="category-1">Category 1</option>
                                            <option value="category-2">Category 2</option>
                                        </select>
                                    </div>
                                    <div class="input-grp">
                                        <label>Applicant</label>
                                        <select name="applicant">
                                            <option value="">Select Applicant</option>
                                            <option value="Status">Status</option>
                                        </select>
                                    </div>
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
                        <form id="report-type-form" aria-labelledby="report-type-heading" method="post" action="">
                            <fieldset class="request-leave-form student-report-filter-form" id="report-type-fieldset">
                                <legend id="report-type-heading" class="sr-only">Report Type Selection</legend>
                                
                                <!-- Radio buttons for format selection -->
                                <div class="multi-input-grp grp-1">
                                    <div class="input-grp">
                                        <label><input type="radio" name="report_format" value="labels" checked /> Labels</label>
                                    </div>
                                    <div class="input-grp">
                                        <label><input type="radio" name="report_format" value="lists" /> Lists</label>
                                    </div>
                                </div>

                                <!-- Labels Options -->
                                <div class="multi-input-grp report-options" data-format="labels">
                                    <div class="report-column p-3">
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-home-address" /> Student Home Address Labels</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="parent-home-address" /> Parent Home Address Labels</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-name-labels" /> Student Name Labels</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-name-labels-full-sheet" /> Student Name Labels- full sheet</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lists Options -->
                                <div class="multi-input-grp report-options" data-format="lists" style="display:none;">
                                    <div class="report-column p-3">
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-names-he" /> Student List - Names Only - Hebrew</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-highschools" /> Student List with High Schools</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-separated-highschools" /> Student List Separated by High Schools</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-separated-camps" /> Student List Separated by Camps</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-albums-whole" /> Student "Albums" List - whole school</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-albums-class" /> Student "Albums" List - by class</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="student-placement" /> Student Placement List</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="class-lists" /> Class Lists</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="class-lists-highschools" /> Class Lists with High Schools</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="division-lists" /> Division Lists</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="mechaneches-lists" /> Mechaneches Lists</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="dorm-room-students" /> Dorm Room Assignments - by students</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="dorm-room-rooms" /> Dorm Room Assignments - by room</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="closest-relative" /> Closest Relative List</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="cell-phone" /> Cell Phone List</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="email-list" /> Email List</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="government-list" /> Government List</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="registration-form" /> Registration Form</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="shabbos-signout" /> Shabbos Sign-Out Sheet</label>
                                        </div>
                                        <div class="input-grp">
                                            <label><input type="checkbox" name="report_type[]" value="curfew-signin" /> Curfew Sign-In Sheet</label>
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
                    
                    <form class="output-options-filter" id="output-options-form" aria-labelledby="output-options-heading">
                        <fieldset class="opt-group">
                        <legend class="opt-title">Paper Size</legend>
                    
                        <label class="opt-row">
                            <input type="radio" name="paper_size" value="israeli" checked>
                            <span class="opt-label">Israeli (A4)</span>
                        </label>
                    
                        <label class="opt-row">
                            <input type="radio" name="paper_size" value="american">
                            <span class="opt-label">American (Letter)</span>
                        </label>
                        </fieldset>
                    
                        <fieldset class="opt-group">
                        <legend class="opt-title">Sort Order</legend>
                    
                        <label class="opt-row">
                            <input type="radio" name="sort_order" value="student_name" checked>
                            <span class="opt-label">Student Name</span>
                        </label>
                    
                        <label class="opt-row">
                            <input type="radio" name="sort_order" value="high_school">
                            <span class="opt-label">High School</span>
                        </label>
                        </fieldset>
                    
                        <div class="opt-heading">What heading should be used?</div>

                        <div class="opt-input-row">
                            <input type="text" name="report_heading" placeholder="Enter the name of Parsha" />
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
                        <form id="preview-print" aria-labelledby="preview-print-heading">
                            <fieldset class="request-leave-form student-report-filter-form">
                                <div class="multi-input-grp report-options">
                                    <div class="report-column w-100 p-2">
                                        <div class="input-grp w-100">
                                            <label for="rpt-1"><input type="checkbox" name="print_preview" value=""/> Print Preview</label>
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

@push('script')
<script>
$(function() {
    $('#include-applicant').on('change', function() {
        const $section = $('#applicant-options');

        if (this.checked) {
            $section.show();
        } else {
            $section.hide().find('select').prop('selectedIndex', 0);
        }
    });
});
</script>

<script>
$(function() {
    function toggleReportOptions() {
        const selectedFormat = $('input[name="report_format"]:checked').val();

        $('#report-type-form .report-options').each(function() {
            const $section = $(this);
            const isVisible = $section.data('format') === selectedFormat;
            
            $section.toggle(isVisible);
            
            // Uncheck hidden checkboxes
            if (!isVisible) {
                $section.find('input[type="checkbox"]').prop('checked', false);
            }
        });
    }
    
    // Bind event listener
    $('input[name="report_format"]').on('change', toggleReportOptions);
    
    // Initialize on page load
    toggleReportOptions();
});
</script>

<script>
    $(document).ready(function(){
        $('#output-options-form').on('submit', function(e) {
            e.preventDefault();
            let combinedData = {};

            $('#report-filters-form').serializeArray().forEach(function(item) {
                if (combinedData[item.name]) {
                    if (!Array.isArray(combinedData[item.name])) {
                        combinedData[item.name] = [combinedData[item.name]];
                    }
                    combinedData[item.name].push(item.value);
                } else {
                    combinedData[item.name] = item.value;
                }
            });

            $('#report-type-form').serializeArray().forEach(function(item) {
                if (combinedData[item.name]) {
                    if (!Array.isArray(combinedData[item.name])) {
                        combinedData[item.name] = [combinedData[item.name]];
                    }
                    combinedData[item.name].push(item.value);
                } else {
                    combinedData[item.name] = item.value;
                }
            });
            
            $(this).serializeArray().forEach(function(item) {
                if (combinedData[item.name]) {
                    if (!Array.isArray(combinedData[item.name])) {
                        combinedData[item.name] = [combinedData[item.name]];
                    }
                    combinedData[item.name].push(item.value);
                } else {
                    combinedData[item.name] = item.value;
                }
            });

            console.log(combinedData);
        });
    });
</script>

@endpush