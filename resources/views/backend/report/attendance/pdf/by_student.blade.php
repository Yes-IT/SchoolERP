<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance - {{ $student->full_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 0.8cm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 12px;
            font-weight: normal;
        }

        .tables-wrapper {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: space-between;
        }

        .table-container {
            flex: 1;
            min-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #000;
            font-size: 10px;
        }

        td {
            border: 1px solid #000;
            padding: 5px 4px;
            vertical-align: top;
        }

        .absences-table td:nth-child(1),
        .absences-table td:nth-child(2) {
            text-align: center;
            font-weight: bold;
        }

        .absences-table td:nth-child(3),
        .absences-table td:nth-child(4),
        .absences-table td:nth-child(5) {
            font-size: 9.5px;
        }

        .totals-table th,
        .totals-table td {
            text-align: center;
        }

        .totals-table th:first-child,
        .totals-table td:first-child {
            text-align: left;
            padding-left: 6px;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            margin-bottom: 6px;
            display: block;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #555;
        }

        .generated {
            text-align: right;
            font-size: 9px;
            margin-top: 10px;
        }

        /* Ensure long text wraps */
        td {
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1>Attendance Record: {{ $semesterName }}</h1>
        <p>Student: {{ $student->full_name }}</p>
    </div>

    <!-- Tables Side by Side -->
    <div class="tables-wrapper">

        <!-- ABSENCES TABLE -->
        <div class="table-container">
            <span class="section-title">Absences</span>
            <table class="absences-table">
                <thead>
                <tr>
                    <th width="10%">Day</th>
                    <th width="18%">Date</th>
                    <th width="38%">Class</th>
                    <th width="17%">Type</th>
                    <th width="17%">Comment</th>
                </tr>
                </thead>
                <tbody>
                @forelse($attendances as $record)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('D') }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d.m.y') }}</td>
                        <td>{{ $record->class->name ?? 'N/A' }}</td>
                        <td></td> <!-- Type blank -->
                        <td></td> <!-- Comment blank -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; font-style:italic; color:#888; padding:15px 0;">
                            No absences recorded
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- SEMESTER TOTALS TABLE -->
        <div class="table-container">
            <span class="section-title">Semester Totals</span>
            <table class="totals-table">
                <thead>
                <tr>
                    <th width="40%">Subject</th>
                    <th width="10%">E</th>
                    <th width="10%">P</th>
                    <th width="10%">P*</th>
                    <th width="10%">NC</th>
                    <th width="10%">%</th>
                    <th width="10%">Points</th>
                </tr>
                </thead>
                <tbody>
                @php
                    // Group by subject and calculate totals
                    $subjectStats = $attendances->groupBy('subject_id')->map(function ($rows) {
                        $total = $rows->count();
                        $excused = $rows->where('excused', 1)->count(); // assuming column exists
                        $present = $rows->where('status', 'present')->count();
                        $late = $rows->where('status', 'late')->count();
                        $nc = $total - $excused - $present - $late;
                        $percentage = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;
                        $points = 0; // Logic to be added

                        return [
                            'name' => $rows->first()->subject->name ?? 'Unknown',
                            'E' => $excused,
                            'P' => $present,
                            'P*' => $late,
                            'NC' => $nc,
                            'percent' => $percentage,
                            'points' => $points
                        ];
                    });
                @endphp

                @if($subjectStats->count() > 0)
                    @foreach($subjectStats as $stat)
                        <tr>
                            <td>{{ $stat['name'] }}</td>
                            <td>{{ $stat['E'] }}</td>
                            <td>{{ $stat['P'] }}</td>
                            <td>{{ $stat['P*'] }}</td>
                            <td>{{ $stat['NC'] }}</td>
                            <td>{{ $stat['percent'] }}%</td>
                            <td>{{ $stat['points'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align:center; font-style:italic; color:#888; padding:12px 0;">
                            No subject data
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        This is a system-generated report. For queries, contact the school administration.
    </div>

    <div class="generated">
        Generated on {{ now()->format('d M Y \a\t H:i') }}
    </div>

</div>

</body>
</html>