<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Address Labels</title>
        <style>
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            html,
            body {
                height: 100%;
                margin: 0;
                font-family: "Helvetica Neue", Arial, sans-serif;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            body {
                background: #fff;
                color: #111;
            }
            .labels-root {
                width: calc(100% - 24mm);
                max-width: 210mm;
                margin: 0 auto;
                padding: 8mm;
                box-sizing: border-box;
                background: #fff;
            }
            .labels-table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
            }
            .labels-table td {
                width: 33.3333%;
                vertical-align: top;
                padding: 6mm 8mm;
                border: 0px solid rgba(0, 0, 0, 0.04);
                box-sizing: border-box;
                min-height: 36mm;
            }
            .label {
                display: block;
            }
            .label .name {
                font-size: 14px;
                margin-bottom: 6px;
                color: #111;
            }
            .label .line {
                font-size: 12.25px;
                color: #222;
                line-height: 1.2;
                margin-bottom: 2px;
            }
            .label .muted {
                color: #666;
                font-weight: 600;
                font-size: 11.25px;
            }
            @media print {
                .labels-root {
                    padding: 8mm;
                }

                .labels-table td {
                    border: none;
                }
            }
            @media (max-width:900px) {
                .labels-table td {
                    padding: 8px;
                    min-height: 48px;
                }
            }
        </style>
    </head>

    <body>
        <div class="labels-root">
            <table class="labels-table" role="presentation" aria-hidden="false">
                <tbody>
                    @forelse ($data['teachers']->chunk(3) as $row)
                        <tr>
                            @foreach ($row as $item)
                                <td>
                                    <div class="label">
                                        <div class="name">{{ $item->first_name }} {{ $item->last_name }}</div>
                                    </div>
                                </td>
                            @endforeach

                            @for ($i = $row->count(); $i < 3; $i++)
                                <td></td>
                            @endfor
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </body>

</html>