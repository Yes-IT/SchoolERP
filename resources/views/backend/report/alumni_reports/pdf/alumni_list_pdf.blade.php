<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Meohr Bais Yaakov — Alumni List</title>
        <style>
            @page {
                size: A4 landscape;
                margin: 12mm 10mm;
            }
            html,
            body {
                height: 100%;
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .teacher-list-root {
                font-family: 'Calibri';
                color: #111;
                background: #fff;
                box-sizing: border-box;
                padding: 10mm;
            }
            .report-header {
                display: flex;
                align-items: baseline;
                justify-content: space-between;
                margin-bottom: 8px;
            }
            .report-title {
                font-size: 28px;
                font-weight: 600;
                margin: 0;
            }
            .report-sub {
                font-size: 12px;
                color: #555;
                margin-top: 4px;
            }
            .hr {
                height: 1px;
                background: #e0e0e0;
                margin: 10px 0 12px 0;
            }
            .teacher-table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
                font-size: 12px;
            }
            .teacher-table thead th {
                text-align: left;
                font-weight: 700;
                padding: 8px 10px;
                border-bottom: 2px solid #cfcfcf;
                vertical-align: bottom;
                background: transparent;
            }
            .teacher-table tbody td {
                padding: 8px 10px;
                vertical-align: top;
                border: 1px solid #ececec;
                color: #111;
                line-height: 1.05;
                word-wrap: break-word;
            }
            .teacher-table tbody tr:nth-child(odd){
                background: #f2f2f2;
            }
            .rtl {
                direction: rtl;
                unicode-bidi: embed;
                text-align: right;
            }
            .teacher-table thead th {
                font-size: 12px;
                letter-spacing: 0.6px;
                color: #222;
            }
            .teacher-table tbody tr:nth-child(2n) td {
                background: rgba(0, 0, 0, 0.00);
            }
            .teacher-table thead {
                display: table-header-group;
            }
            .teacher-table tfoot {
                display: table-row-group;
            }
            .report-footer {
                position: running(footer);
            }
            .page-footer {
                display: flex;
                justify-content: space-between;
                font-size: 11px;
                color: #444;
                margin-top: 12px;
            }
            @media print {
                .page-footer {
                    position: fixed;
                    bottom: 8mm;
                    left: 12mm;
                    right: 12mm;
                    background: transparent;
                }
                .page-footer .date {
                    text-align: left;
                }
                .page-footer .pager {
                    text-align: right;
                }
                .page-footer .pager::after {
                    content: "Page " counter(page);
                }
                tr,
                td {
                    page-break-inside: avoid;
                }
            }
            @media (max-width:1000px) {
                .teacher-list-root {
                    padding: 8px;
                }
                .teacher-table thead th,
                .teacher-table tbody td {
                    padding: 6px 8px;
                    font-size: 11px;
                }
                .report-title {
                    font-size: 20px;
                }
            }
        </style>
    </head>

    <body>
        <div class="teacher-list-root">

            <!-- Header -->
            <header class="report-header" role="banner">
                <div>
                    <h1 class="report-title">Meohr Bais Yaakov {{ $data['school_year']}}  Alumni List</h1>
                </div>
            </header>

            <div class="hr" aria-hidden="true"></div>

            <!-- Table -->
            <table class="teacher-table" role="table" aria-label="Teacher list">
                <thead>
                    <tr>
                        <th">Year</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Maiden Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        <th>Country</th>
                        <th>Home Phone</th>
                        <th>Cell Phone</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data['alumni'] as $row)
                        <tr>
                            <td>{{ $row->session_name ?? ''}}</td>
                            <td>{{ $row->last_name ?? '' }}</td>
                            <td>{{ $row->first_name ?? '' }}</td>
                            <td></td>
                            <td>{{ $row->residance_address ?? '' }}</td>
                            <td>{{ $row->city ?? '' }}</td>
                            <td>{{ $row->state ?? '' }}</td>
                            <td>{{ $row->zip_code ?? '' }}</td>
                            <td>{{ $row->country ?? '' }}</td>
                            <td>{{ $row->cell_usa ?? '' }}</td>
                            <td>{{ $row->cell_israel ?? '' }}</td>
                            <td>{{ $row->email ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">No teacher data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="page-footer" aria-hidden="true">
                <div class="date">30 October 2025</div>
                <div class="pager">Page </div>
            </div>

        </div>
    </body>

</html>