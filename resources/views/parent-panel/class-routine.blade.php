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
            
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

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

            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("applyBtn")) {
                    document.getElementById("dateFilterForm").submit();
                }
            });

        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    function initDateRangePicker() {
        const yearSelect = document.getElementById('year-select');
        const monthSelect = document.getElementById('month-select');
        const weekSelect = document.getElementById('week-select');
        const rangeDisplay = document.getElementById('range-display');
        const btnCancel = document.getElementById('btn-cancel');
        const btnApply = document.getElementById('btn-apply');
        const pdfStartDate = document.getElementById('pdf-start-date');
        const pdfEndDate = document.getElementById('pdf-end-date');
        
        let startDate, endDate;
        
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i <= currentYear + 1; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }
        
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = index + 1;
            option.textContent = month;
            monthSelect.appendChild(option);
        });
        
        
        function updateWeeks() {
            weekSelect.innerHTML = '';
            const year = parseInt(yearSelect.value);
            const month = parseInt(monthSelect.value);
            
            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0);
            
            let weekCount = 1;
            let currentDate = new Date(firstDay);
            
            while (currentDate <= lastDay) {
                const weekStart = new Date(currentDate);
                const weekEnd = new Date(currentDate);
                weekEnd.setDate(weekEnd.getDate() + 6);
                
                if (weekEnd > lastDay) {
                    weekEnd.setDate(lastDay.getDate());
                }
                
                const option = document.createElement('option');
                option.value = weekCount;
                option.textContent = `Week ${weekCount}: ${formatDate(weekStart)} - ${formatDate(weekEnd)}`;
                option.dataset.start = weekStart.toISOString().split('T')[0];
                option.dataset.end = weekEnd.toISOString().split('T')[0];
                weekSelect.appendChild(option);
                
                weekCount++;
                currentDate.setDate(currentDate.getDate() + 7);
            }
        
            if (weekSelect.options.length > 0) {
                weekSelect.selectedIndex = 0;
                updateDisplay();
            }
        }
        
        function formatDate(date) {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
        }
        
        function updateDisplay() {
            if (weekSelect.selectedOptions.length > 0) {
                const selectedOption = weekSelect.selectedOptions[0];
                startDate = selectedOption.dataset.start;
                endDate = selectedOption.dataset.end;
                rangeDisplay.textContent = `${formatDate(new Date(startDate))} - ${formatDate(new Date(endDate))}`;
                
                if (pdfStartDate && pdfEndDate) {
                    pdfStartDate.value = startDate;
                    pdfEndDate.value = endDate;
                }
            }
        }
        
        yearSelect.addEventListener('change', updateWeeks);
        monthSelect.addEventListener('change', updateWeeks);
        weekSelect.addEventListener('change', updateDisplay);
        
        btnCancel.addEventListener('click', function() {
            document.querySelector('.datepicker-body-wrp').style.display = 'none';
        });
        
        btnApply.addEventListener('click', function() {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = window.location.pathname;
            
            const startInput = document.createElement('input');
            startInput.type = 'hidden';
            startInput.name = 'start_date';
            startInput.value = startDate;
            form.appendChild(startInput);
            
            const endInput = document.createElement('input');
            endInput.type = 'hidden';
            endInput.name = 'end_date';
            endInput.value = endDate;
            form.appendChild(endInput);
            
            document.body.appendChild(form);
            form.submit();
        });
        
        monthSelect.value = new Date().getMonth() + 1;
        updateWeeks();
    }
    
    initDateRangePicker();
});
</script>
@endpush
