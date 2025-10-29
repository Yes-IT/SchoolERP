<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Excessive Absences for {{ $semesterName }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .info {
            margin: 15px 0;
            font-size: 13px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .student-name {
            text-align: left;
        }
        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Excessive Absences for {{ $semesterName }}</h1>
    </div>

    <!-- Date Range Info -->
    <div class="info">
        Period: {{ $dateRange['start'] }} to {{ $dateRange['end'] }}
    </div>

    <!-- Table -->
    @if($students->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="student-name">Student Name</th>
                    <th>P</th>
                    <th>P*</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $item)
                    @php
                        $student = $item['student'];
                        $absent = $item['count'];

                        // Calculate total sessions this student *should* have attended
                        // We count all attendance records (any type) in the date range for this student
                        $totalSessions = \App\Models\Attendance\Attendance::where('student_id', $student->id)
                            ->where('session_id', $data['school_year'])
                            ->where('year_status_id', $data['year_status'])
                            ->where('semester_id', $data['semester'])
                            ->whereBetween('date', [
                                \Carbon\Carbon::parse($data['start_date']),
                                \Carbon\Carbon::parse($data['end_date'])
                            ])
                            ->count();

                        $present = $totalSessions - $absent;
                        $late = 0; // P* = Late (you can adjust if you track late separately)


                        $percentage = $totalSessions > 0 ? round(($present + $late) / $totalSessions * 100, 1) : 0;
                    @endphp

                    <tr>
                        <td class="student-name">
                            {{ $student->first_name }} {{ $student->last_name }}
                        </td>
                        <td>{{ $present }}</td>
                        <td>{{ $late }}</td>
                        <td>0 %</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center; margin-top:30px; color:#666;">
            No attendance records found for the selected period.
        </p>
    @endif

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('d M Y \a\t H:i') }}
    </div>

</body>
</html>