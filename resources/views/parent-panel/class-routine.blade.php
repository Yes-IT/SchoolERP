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

    {{-- <div class="ds-pr-body">
        <div class="classes-schedule-container">
            <div class="classes-schedule-filter">
                <div class="datepicker">
                   
                <form id="dateFilterForm" method="GET" action="">
                    <div class="input-grp">
                        <input type="text" name="dates" id="dates" value="" />
                    </div>
                </form>
            </div>

               
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

                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

        <div class="ds-pr-body">
                        
                        <div class="classes-schedule-container">
                            <div class="classes-schedule-filter">
                                <div class="datepicker">
                                    <div class="datepicker__header">
                                        <img src="{{asset('parent/images/calender-icon.svg')}}" alt="Icon">
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
                                    </div>
                                </div>

                                {{-- <button class="cmn-btn print-btn">Print Now <img src="{{ asset('parent/images/printer-icon.svg') }}" alt="Icon"></button> --}}

                                <form id="pdf-form" action="{{ route('parent-panel-class-routine.classes-pdf') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="start_date" id="pdf-start-date">
                                    <input type="hidden" name="end_date" id="pdf-end-date">
                                    <button type="submit" class="cmn-btn print-btn">
                                        <img src="{{ asset('parent/images/printer-icon.svg') }}" alt="Icon">
                                         Print Now
                                    </button>
                                </form>
                            </div>

                            <div class="boxtbl-outer">
                                <div class="box-table-container">
                                    {{-- <table>
                                      <thead>
                                        <tr>
                                          <th>Day/Time</th>
                                          <th>10:00 AM - 10:59 AM</th>
                                          <th>11:00 AM - 11:59 AM</th>
                                          <th>12:00 PM - 12:59 PM</th>
                                          <th>01:00 AM - 01:59 AM</th>
                                          <th>02:00 PM - 02:59 PM</th>
                                          <th>03:00 PM - 03:59 PM</th>
                                          <th>04:00 PM - 04:59 PM</th>
                                          <th>05:00 PM - 05:59 PM</th>
                                          <th>06:00 PM - 06:59 PM</th>
                                          <th>07:00 PM - 07:59 PM</th>
                                          <th>08:00 PM - 08:59 PM</th>
                                          <th>09:00 PM - 09:59 PM</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <!-- Friday -->
                                        <tr>
                                          <th>Friday</th>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                        </tr>
                                  
                                        <!-- Monday -->
                                        <tr>
                                          <th>Monday</th>
                                          <td>
                                            <strong>Subject Name</strong><br>
                                            Teacher Name<br>
                                            Room No. 12
                                          </td>
                                          <!-- repeat the same cell 11 more times -->
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                        </tr>
                                  
                                        <!-- Tuesday -->
                                        <tr>
                                          <th>Tuesday</th>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                        </tr>
                                  
                                        <!-- Wednesday -->
                                        <tr>
                                          <th>Wednesday</th>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                        </tr>
                                  
                                        <!-- Thursday -->
                                        <tr>
                                          <th>Thursday</th>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                        </tr>
                                  
                                        <!-- Friday (second row) -->
                                        <tr>
                                          <th>Friday</th>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                          <td><strong>Subject Name</strong><br>Teacher Name<br>Room No. 12</td>
                                        </tr>
                                  
                                        <!-- Shabbos -->
                                        <tr>
                                          <th>Shabbos</th>
                                          <td colspan="12" style="background: var(--secondary-clr);"></td>
                                        </tr>
                                      </tbody>
                                    </table> --}}

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Day / Time</th>

                                                @foreach($timeSlots as $slot)
                                                    <th>{{ $slot['label'] }}</th>
                                                @endforeach

                                            </tr>
                                        </thead>

                                        <tbody>

                                            {{-- @foreach($days as $day)

                                            <tr>
                                                <th>{{ $day }}</th>

                                                @if($day === 'Shabbos')
                                                    <td colspan="{{ count($timeSlots) }}" style="background: #eee;"></td>

                                                @else
                                                    @foreach($timeSlots as $startTime => $slot)

                                                        @php  $data = $formatted[$day][$startTime];  @endphp

                                                        <td>
                                                            @if($data)
                                                                <strong> Subject Name: {{ $data['subject'] }}</strong><br>
                                                                Teacher Name: {{ $data['teacher'] }}<br>
                                                                Room: {{ $data['room'] }}
                                                            @endif
                                                        </td>

                                                    @endforeach
                                                @endif
                                            </tr>

                                            @endforeach --}}

                                              @foreach($days as $day)
                                                    <tr>
                                                        <th>{{ $day }}</th>
                                                        
                                                        @if($day === 'Shabbos')
                                                            <td colspan="{{ count($timeSlots) }}" style="background: #f0f0f0; text-align: center; font-style: italic;">
                                                                <strong>No Classes - Shabbos</strong>
                                                            </td>
                                                        @else
                                                            @foreach($timeSlots as $startTime => $slot)
                                                                @php $data = $formatted[$day][$startTime] ?? null; @endphp
                                                                
                                                                <td style="border: 1px solid #ddd; padding: 8px; min-height: 80px;">
                                                                    @if($data && (!isset($data['is_empty']) || !$data['is_empty']))
                                
                                                                            <strong>Subject Name: {{ $data['subject'] }}</strong><br>
                                                                            <small>Teacher Name : {{ $data['teacher'] }}</small><br>
                                                                            <small>Room No: {{ $data['room'] }}</small>
                                                                        
                                                                    @else
                                                                        <div style="color: #ccc; text-align: center;">
                                                                            —
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                 @endforeach

                                        </tbody>
                                    </table>

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
