{{-- resources/views/backend/report/attendance/pdf/excessive_student.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Excessive Absences – {{ $semesterName }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; font-weight: bold; }
        .info { margin: 15px 0; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .count { text-align: center; font-weight: bold; }
        .footer { margin-top: 40px; font-size: 11px; text-align: right; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Excessive Absences – {{ $semesterName }}</h1>
    </div>

    <!-- Date Range & Filters -->
    <div class="info" style="text-align:center;">
        Period: {{ $dateRange['start'] }} to {{ $dateRange['end'] }} <br>
        School Year: {{ \App\Models\Academic\Session::find(request('school_year'))?->name ?? '' }}
        | Year Status: {{ \App\Models\Academic\YearStatus::find(request('year_status'))?->name ?? '' }}
    </div>

    <!-- Table -->
    @if($students->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Admission No.</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Total Absences</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['student']->admission_no ?? '-' }}</td>
                        <td>{{ $item['student']->first_name }} {{ $item['student']->last_name }}</td>
                        <td>{{ $item['student']->currentClass?->name ?? '—' }}</td>
                        <td class="count">{{ $item['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center; margin-top:30px; color:#666;">
            No absences recorded for the selected semester and date range.
        </p>
    @endif

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('d M Y \a\t H:i') }}
    </div>

</body>
</html>