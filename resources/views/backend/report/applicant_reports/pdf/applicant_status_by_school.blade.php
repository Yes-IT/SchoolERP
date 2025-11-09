<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Applicant Report</title>
    <style>
        @page { margin: 40px 20px; }

        body { font-family: 'Calibri', sans-serif; font-size: 12px; }

        h2 { text-align: center; margin-bottom: 20px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th { background: #f0f0f0; }

        .school-header {
            background: #fff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            border-bottom: none;
            font-size: 13px;
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

        /* .page-break { page-break-before: always; } */
    </style>
</head>
<body>
    <h2>Meohr Bais Yaakov Applicant Status List</h2>

    @if($data['grouped'])
        @foreach($data['groupedApplicants'] as $schoolName => $applicants)
            <table class="{{ !$loop->first ? 'page-break' : '' }}">
                <thead>
                    <tr>
                        <th colspan="3" class="school-header">{{ $schoolName }}</th>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applicants as $applicant)
                        <tr>
                            <td>{{ $applicant->last_name ?? '' }}</td>
                            <td>{{ $applicant->first_name ?? '' }}</td>
                            <td>{{ ucfirst($applicant->applicant_status->value ?? '') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @else
        <table>
            <thead>
                <tr>
                    <th colspan="3" class="school-header">{{ $data['schoolName'] }}</th>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['applicants'] as $applicant)
                    <tr>
                        <td>{{ $applicant->last_name ?? '' }}</td>
                        <td>{{ $applicant->first_name ?? '' }}</td>
                        <td>{{ ucfirst($applicant->applicant_status->value ?? '') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">
        <div>{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
        <div>Page {PAGE_NUM} of {PAGE_COUNT}</div>
    </div>
</body>
</html>