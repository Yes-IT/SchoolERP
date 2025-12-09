@extends('parent-panel.partials.master')

@section('content')
    <!-- Dashboard Begin -->
    <div class="ds-breadcrumb">
        <h1>My Classes</h1>
        <ul>
            <li><a href="{{ route('student.dashboard') }}">Dashboard</a> /</li>
            <li>My Classes</li>
        </ul>
    </div>

    <div class="ds-pr-body">
        <div class="classes-schedule-container">
            <div class="classes-schedule-filter">
                <div class="datepicker">
                     <!-- <div class="datepicker__header">
                    <img src="{{asset('student/images/calender-icon.svg')}}" alt="Icon">
                    <span id="range-display">Jan 01, 2025 - Jan 05, 2025</span>
                </div>
                <div class="datepicker-body-wrp">
                    <div class="datepicker__body">
                        <select id="year-select"></select>
                        <select id="month-select"></select>
                        <select id="week-select"></select>
                    </div>
                    <div class="datepicker__footer">
                        <button class="datepicker__btn datepicker__btn--cancel cmn-btn" id="btn-cancel">Cancel</button>
                        <button class="datepicker__btn datepicker__btn--apply cmn-btn" id="btn-apply">Apply</button>
                    </div>
                </div> -->
                <form id="dateFilterForm" method="GET" action="">
                    <div class="input-grp">
                        <input type="text" name="dates" id="dates" value="" />
                    </div>
                </form>
            </div>

                <!-- <button class="cmn-btn print-btn">Print Now <img src="{{ 'student/images/printer-icon.svg' }}"
                            alt="Icon"></button> -->

                <button class="cmn-btn print-btn" onclick="printDiv('printArea')">
                    Print Now <img src="{{ asset('student/images/printer-icon.svg') }}" alt="Icon">
                </button>
            </div>

            <div id="printArea">
                <div class="boxtbl-outer">
                    <div class="box-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Day/Time</th>
                                    @foreach ($times as $time)
                                        <th>{{ $time }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($weekDays as $day)
                                    <tr>
                                        <th>{{ $day }}</th>
                                        @foreach ($times as $time)
                                            <td>
                                                @if (isset($grouped[$day][$time]))
                                                    <strong>{{ $grouped[$day][$time]->subject_name }}</strong><br>
                                                    {{ $grouped[$day][$time]->staff_first_name }}
                                                    {{ $grouped[$day][$time]->staff_last_name }}<br>
                                                    Room No. {{ $grouped[$day][$time]->room }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <!-- Shabbos -->
                                {{-- <tr>
                                <th>Shabbos</th>
                                <td colspan="12" style="background: var(--secondary-clr);"></td>
                            </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Of Dashboard -->
@endsection

@push('script')
    <script>
        function printDiv(divId) {
            // Get print content
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            // Replace body with print section
            document.body.innerHTML = `
            <html>
                <head>
                    <title>Class Timetable</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            padding: 20px;
                        }
                        h2 {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            font-size: 14px;
                        }
                        th, td {
                            border: 1px solid #000;
                            padding: 8px;
                            text-align: center;
                            vertical-align: top;
                        }
                        th {
                            background-color: #f2f2f2;
                            font-weight: bold;
                        }
                        .text-muted {
                            color: #888;
                        }
                        /* Hide buttons or controls in print */
                        .print-btn {
                            display: none !important;
                        }
 
                        @media print {
                            body {
                                -webkit-print-color-adjust: exact;
                            }
                        }
                    </style>
                </head>
                <body>
                    <h2>Class Timetable</h2>
                    ${printContents}
                </body>
            </html>
        `;

            // Trigger print
            window.print();

            // Restore original content
            document.body.innerHTML = originalContents;

            // Reload so JS rebinds properly
            location.reload();
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // When the user clicks APPLY inside the date picker
            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("applyBtn")) {
                    document.getElementById("dateFilterForm").submit();
                }
            });

        });
    </script>
    <script>
$(function () {
    $("#dates").datepicker({
        dateFormat: "yy-mm-dd",   // format you want in GET
        onSelect: function () {
            $("#dateFilterForm").submit(); // auto submit
        }
    });
});
</script>
@endpush
