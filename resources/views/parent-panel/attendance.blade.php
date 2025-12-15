@extends('parent-panel.partials.master')

@section('content')

    <style>
        .status.holiday {
            background: #D3D3D3;
            color: #333;
            font-weight: 500;
            display: inline-block;
            padding: 21px 10px;
            border-radius: 6px;
            font-size: 36px;
            color: gray
        }

        .holiday-row {
            background-color: #f5f5f5;
        }
    </style>
    @php
        use Carbon\Carbon;
    @endphp
    <!-- Dashboard Begin -->
    <div class="ds-breadcrumb">
        <h1>My Attendance</h1>
        <ul>
            <li><a href="{{ route('student.dashboard') }}">Dashboard</a> /</li>
            <li>My Attendances</li>
        </ul>
    </div>
    <div class="ds-pr-body">

        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter">
                <form method="GET" action="{{ url('parent-panel-attendance') }}">
                    <div class="atndnc-filter-form">
                        <div class="atndnc-filter-options">

                            <!-- Subject Multi-Select Dropdown -->
                            <div class="dropdown subject-dropdown">
                                <button type="button" class="dropdown-toggle">
                                    <span class="label">
                                        {{ request()->has('subjects') ? 'Filtered Subjects' : 'All Subjects' }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <label>
                                        <input type="checkbox" name="subjects[]" value="all"
                                            {{ in_array('all', request()->get('subjects', [])) ? 'checked' : '' }}>
                                        All Subjects
                                    </label>

                                    @foreach ($subjects as $subject)
                                        <label>
                                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                                {{ in_array($subject->id, request()->get('subjects', [])) ? 'checked' : '' }}>
                                            {{ $subject->name }}
                                        </label>
                                    @endforeach
                                </div>



                            </div>

                            <!-- Year/Month Picker Dropdown -->
                            <div class="dropdown date-dropdown" style="width: 200px !important;">
                                <button type="button" class="dropdown-toggle" style="width: 200px !important; height: 45px !important;">
                                    <span class="label">
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}, {{ $year }}
                                    </span>
                                    <i class="fa-regular fa-calendar"></i>
                                </button>
                                <div class="dropdown-menu date-menu">
                                    <select class="year-select" name="year">
                                        @for ($y = date('Y') - 15; $y <= date('Y') + 15; $y++)
                                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>

                                    <select class="month-select" name="month">
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>

                                    <div class="actions">
                                        <button type="button" class="btn-cancel">Cancel</button>
                                        <button type="submit" class="btn-apply">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="btn-search">Search</button>
                    </div>
                </form>


            </div>
        </div>
        <div class="ds-cmn-table-wrp">
            <div class="attendance-calendar">
                <div class="sec-head d-flex justify-content-between align-items-center">
                    <h2>Attendance - {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}</h2>
                    <button class="download-attendance-btn cmn-btn">Download Report</button>
                </div>

                <div class="ds-cmn-tble pending attendance-pg w1200">
                    <table id="calendarTable"
                        style="{{ empty($selectedSubjects) || in_array('all', $selectedSubjects) ? '' : 'display:none;' }}">
                        {{-- Calendar View --}}
                        <thead>
                            <tr>
                                @foreach ($daysOfWeek as $day)
                                    <th>{{ $day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $currentDate = $firstDay->copy()->startOfWeek(Carbon::SUNDAY); @endphp
                            @while ($currentDate <= $lastDay->copy()->endOfWeek(Carbon::SATURDAY))
                                <tr>
                                    @for ($i = 0; $i < 7; $i++)
                                        @php
                                            $isOutsideMonth = $currentDate->month !== $firstDay->month;
                                            $dateKey = $currentDate->format('Y-m-d');
                                        @endphp
                                        <td class="{{ $isOutsideMonth ? 'outside' : '' }}">
                                            <div class="date-cal-box">
                                                <span class="date-number">{{ $currentDate->format('j') }}</span>

                                                @if (!empty($attendanceData[$dateKey]))
                                                    @foreach ($attendanceData[$dateKey] as $subjectId => $status)
                                                        <div class="status {{ $status }}">
                                                          {{ ucfirst(str_replace('_', ' ', $status)) }}

                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        @php $currentDate->addDay(); @endphp
                                    @endfor
                                </tr>
                            @endwhile
                        </tbody>

                    </table>

                    {{-- Subject-Based View --}}
                    @php

                        // Get selected subjects
                        $selectedSubjects = request()->get('subjects', ['all']);

                        // Determine which subjects to display
                        $displaySubjects = in_array('all', $selectedSubjects)
                            ? $subjects
                            : $subjects->whereIn('id', $selectedSubjects);

                        // Month loop setup
                        $currentDate = $firstDay->copy()->startOfMonth();
                        $endDate = $firstDay->copy()->endOfMonth();
                    @endphp

                    <table id="subjectTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                @foreach ($displaySubjects as $subject)
                                    <th>{{ $subject->name }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @while ($currentDate <= $endDate)
                                @php
                                    $isSaturday = $currentDate->isSaturday();
                                    $dateKey = $currentDate->format('Y-m-d');
                                @endphp

                                {{-- If it's Saturday, show one row spanning all columns --}}
                                @if ($isSaturday)
                                    <tr class="holiday-row">
                                        <td colspan="{{ count($displaySubjects) + 1 }}">
                                            <div class="date-cal-box" style="text-align:center;">
                                                <span class="date-number">{{ $currentDate->format('j M') }}</span>
                                                <div class="status holiday">Holiday</div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    {{-- Normal attendance row --}}
                                    <tr>
                                        {{-- Date Column --}}
                                        <td class="date-column">
                                            <div class="date-cal-box">
                                                <span class="date-number">{{ $currentDate->format('j M') }}</span>
                                            </div>
                                        </td>

                                        {{-- Subject Columns --}}
                                        @foreach ($displaySubjects as $subject)
                                            @php
                                                $status = $attendanceData[$dateKey][$subject->id] ?? null;
                                            @endphp
                                            <td>
                                                <div class="date-cal-box">
                                                   
                                                    @if ($status)
                                                        <div class="status {{ $status }}">  
                                                            {{-- @if($status=='half_day')
                                                            Half Day
                                                            @else --}}

                                                            {!! ucwords(str_replace('_', ' ', $status)) !!}
                                                            {{-- @endif --}}
                                                  

                                                        </div>
                                                    @else
                                                        <div class="status" style="background: #e0e0e0;">—</div>
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif

                                @php $currentDate->addDay(); @endphp
                            @endwhile
                        </tbody>
                    </table>






                </div>
            </div>
        </div>
    </div>
    <!-- End Of Dashboard -->

@endsection

@push('script')
    <!-- Include jsPDF and html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Select the correct button
            const downloadBtn = document.querySelector('.download-attendance-btn');

            if (!downloadBtn) {
                console.error("Download button not found!");
                return;
            }

            downloadBtn.addEventListener('click', async function() {
          

                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('p', 'pt', 'a4');

                const headingText = document.querySelector('.sec-head h2')?.textContent ||
                    'Attendance Report';

                downloadBtn.style.display = 'none';

                const tableContainer = document.querySelector('.attendance-calendar');

                const canvas = await html2canvas(tableContainer, {
                    scale: 2,
                    useCORS: true,
                    scrollY: 0,
                    windowWidth: document.documentElement.offsetWidth
                });

                downloadBtn.style.display = 'inline-block';

                const imgData = canvas.toDataURL('image/png');

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = pdfWidth - 40;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                pdf.setFontSize(16);
                pdf.text(headingText, 40, 40);

                const yOffset = 60;
                const availableHeight = pdfHeight - yOffset - 20;
                const finalHeight = Math.min(imgHeight, availableHeight);

                pdf.addImage(imgData, 'PNG', 20, yOffset, imgWidth, finalHeight);

                pdf.save(`${headingText.replace(/\s+/g, '_')}.pdf`);
            });
        });




        document.addEventListener('DOMContentLoaded', function() {
            const allCheckbox = document.querySelector('input[value="all"]');
            const subjectCheckboxes = document.querySelectorAll('input[name="subjects[]"]:not([value="all"])');
            const calendarTable = document.getElementById('calendarTable');
            const subjectTable = document.getElementById('subjectTable');

            function updateTableVisibility() {
                const checkedSubjects = Array.from(document.querySelectorAll('input[name="subjects[]"]:checked'))
                    .map(cb => cb.value);

                if (checkedSubjects.length === 0) {
                    // nothing selected -> show calendar view
                    calendarTable.style.display = '';
                    subjectTable.style.display = 'none';
                } else {
                    // either all or specific subjects selected -> show subject table
                    calendarTable.style.display = 'none';
                    subjectTable.style.display = '';
                }
            }

            // Handle "All Subjects" toggle
            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    subjectCheckboxes.forEach(cb => cb.checked = false);
                }
                updateTableVisibility();
                this.closest('form').submit(); // reload page with selected subjects
            });

            // Handle specific subject selection
            subjectCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        allCheckbox.checked = false;
                    }
                    updateTableVisibility();
                    this.closest('form').submit();
                });
            });

            // On initial page load
            updateTableVisibility();
        });
    </script>
@endpush
