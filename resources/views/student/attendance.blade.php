@extends('student.Layout.app')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <!-- Dashboard Begin -->
    <div class="ds-breadcrumb">
        <h1>My Attendance</h1>
        <ul>
            <li><a href="{{ route('student.dashboard') }}">Dashboard</a> /</li>
            <li>My Attendance</li>
        </ul>
    </div>
    <div class="ds-pr-body">

        <div class="atndnc-filter-wrp w-100">
            <div class="sec-head">
                <h2>Filters</h2>
            </div>
            <div class="atndnc-filter">
                <form method="GET" action="{{ url('student_attendance') }}">
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
                                            {{ in_array('all', request()->get('subjects', ['all'])) ? 'checked' : '' }} />
                                        All Subjects
                                    </label>

                                    @foreach ($subjects as $subject)
                                        <label>
                                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                                {{ in_array($subject->id, request()->get('subjects', ['all'])) ? 'checked' : '' }} />
                                            {{ $subject->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Year/Month Picker Dropdown -->
                            <div class="dropdown date-dropdown">
                                <button type="button" class="dropdown-toggle">
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
                    <button class="cmn-btn">Download Report</button>
                </div>

                <div class="ds-cmn-tble pending attendance-pg w1200">
                    <table>
                        <thead>
                            <tr>
                                @foreach ($daysOfWeek as $day)
                                    <th>{{ $day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentDate = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
                            @endphp

                            @while ($currentDate <= $lastDay->copy()->endOfWeek(Carbon::SATURDAY))
                                <tr>
                                    @for ($i = 0; $i < 7; $i++)
                                        @php
                                            $isOutsideMonth = $currentDate->month !== $firstDay->month;
                                            $status = $attendanceData[$currentDate->format('Y-m-d')] ?? null;
                                        @endphp

                                        <td class="{{ $isOutsideMonth ? 'outside' : '' }}">
                                            <div class="date-cal-box">
                                                <span class="date-number">{{ $currentDate->format('j') }}</span>
                                                @if ($status)
                                                    <div class="status {{ $status }}">{{ ucfirst($status) }}</div>
                                                @endif
                                            </div>
                                        </td>

                                        @php $currentDate->addDay(); @endphp
                                    @endfor
                                </tr>
                            @endwhile
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Dashboard -->

@endsection

@push('page_script')
    <!-- Include jsPDF and html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadBtn = document.querySelector('.cmn-btn');

            downloadBtn.addEventListener('click', async function() {
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('p', 'pt', 'a4');

                // Get heading text
                const headingText = document.querySelector('.sec-head h2')?.textContent ||
                    'Attendance Report';

                // Temporarily hide the download button before capturing
                downloadBtn.style.display = 'none';

                // Select only the attendance table area
                const tableContainer = document.querySelector('.attendance-calendar');

                // Capture the table as an image
                const canvas = await html2canvas(tableContainer, {
                    scale: 2, // higher quality
                    useCORS: true,
                    scrollY: 0,
                    windowWidth: document.documentElement.offsetWidth
                });

                // Show the button again after capture
                downloadBtn.style.display = 'inline-block';

                // Convert the captured area to an image
                const imgData = canvas.toDataURL('image/png');

                // Calculate dimensions to fit the image properly on the page
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = pdfWidth - 40; // margins
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                // Add heading text manually
                pdf.setFontSize(16);
                pdf.text(headingText, 40, 40);

                // Fit the image nicely on one page (below heading)
                const yOffset = 60;
                const availableHeight = pdfHeight - yOffset - 20; // bottom margin
                const finalHeight = Math.min(imgHeight, availableHeight);

                pdf.addImage(imgData, 'PNG', 20, yOffset, imgWidth, finalHeight);

                // Save the PDF file
                pdf.save(`${headingText.replace(/\s+/g, '_')}.pdf`);
            });
        });
    </script>
@endpush
