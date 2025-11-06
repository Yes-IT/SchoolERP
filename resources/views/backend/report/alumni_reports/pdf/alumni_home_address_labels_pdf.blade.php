<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Home Address Report</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
        }
        .report-container {
            background: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        th, td {
            padding: 6px 8px;
            text-align: left;
            border: none;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .student-info {
            font-size: 16px;
            font-weight: 500;
        }
        .student-info p {
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <table>
            <tbody>
                @forelse($data->chunk(3) as $chunk)
                    <tr>
                        @foreach($chunk as $alumni)
                            <td>
                                <div class="student-info">
                                    <p>{{ $alumni->first_name }} {{ $alumni->last_name }}</p>
                                    <p>{{ $alumni->residance_address }}</p>
                                    <p>{{ $alumni->city }} {{ $alumni->state }} {{ $alumni->zip_code }}</p>
                                    <p>{{ $alumni->country }}</p>
                                </div>
                            </td>
                        @endforeach

                        {{-- Fill remaining empty cells if less than 3 --}}
                        @for($i = $chunk->count(); $i < 3; $i++)
                            <td></td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">No data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>