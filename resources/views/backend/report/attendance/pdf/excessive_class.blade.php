<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #222;
        }
        .info {
            margin: 15px 0;
            font-size: 13px;
            text-align: center;
            color: #555;
        }
        .info strong {
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11.5px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        td {
            vertical-align: middle;
        }
        .count, .percent {
            text-align: center;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: right;
            color: #777;
        }
        .class-name {
            font-weight: bold;
            font-size: 14px;
            color: #1a5fb4;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Excessive Absences for {{ $semesterName }} Semester</h1>
        @if($class)
            <div class="class-name">{{ $class->name }}</div>
        @endif
    </div>

    <!-- Date Range & Filters -->
    <div class="info">
        | <strong>Year Status:</strong> {{ \App\Models\Academic\YearStatus::find(request('year_status'))?->name ?? '—' }}
    </div>

    <!-- Table -->
    @if($noData ?? false)
        <div class="no-data">
            No attendance records found for the selected period and class.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Admission No.</th>
                    <th>Student Name</th>
                    <th>Present (P)</th>
                    <th>Late (P*)</th>
                    <th>Total Days</th>
                    <th>Attendance %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $row)
                    <tr>
                        <td class="count">{{ $loop->iteration }}</td>
                        <td>{{ $row['student']->admission_no ?? '—' }}</td>
                        <td>{{ $row['student']->first_name }} {{ $row['student']->last_name }}</td>
                        <td class="count">{{ $row['P'] }}</td>
                        <td class="count">{{ $row['P_star'] }}</td>
                        <td class="count">{{ $row['total'] }}</td>
                        <td class="percent">{{ $row['percent'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-data">No students enrolled in this class.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('d M Y \a\t H:i') }}
    </div>

</body>
</html>