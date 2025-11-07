<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Report by Category</title>
    <style>
        @page {
            margin: 40px 20px;
        }

        body {
            font-family: 'Calibri', sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 40px;
            right: 40px;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <h2>Meohr Bais Yaakov Applicant Status List</h2>

    <table>
        <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Status</th>
                <th>High School</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['applicants'] as $applicant)
                <tr>
                    <td>{{ $applicant->last_name ?? '' }}</td>
                    <td>{{ $applicant->first_name ?? '' }}</td>
                    <td>{{ ucfirst($applicant->applicant_status->value ?? '') }}</td>
                    <td>{{ $applicant->high_school ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
        <div>Page {PAGE_NUM} of {PAGE_COUNT}</div>
    </div>
</body>
</html>