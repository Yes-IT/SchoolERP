<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Two Column Category Tables</title>
    <style>
        @page {
            margin: 60px 40px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* 50% width table containers */
        .table-block {
            width: 48%;
            float: left;
            margin-right: 4%;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        /* Even items float right */
        .table-block:nth-child(2n) {
            margin-right: 0;
            float: right;
        }

        /* Clear float after each pair */
        .clearfix {
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    <h2>Student Report by Category</h2>

    <!-- Start tables -->
    <?php
    $categories = [
        [
            'name' => 'Category A',
            'students' => [
                ['last_name' => 'Smith', 'first_name' => 'John', 'status' => 'Active', 'school' => 'Central High'],
                ['last_name' => 'Brown', 'first_name' => 'Alice', 'status' => 'Inactive', 'school' => 'West High'],
            ]
        ],
        [
            'name' => 'Category B',
            'students' => [
                ['last_name' => 'Lee', 'first_name' => 'Michael', 'status' => 'Active', 'school' => 'East High'],
                ['last_name' => 'Doe', 'first_name' => 'Jane', 'status' => 'Active', 'school' => 'North High'],
            ]
        ],
        [
            'name' => 'Category C',
            'students' => [
                ['last_name' => 'Patel', 'first_name' => 'Amit', 'status' => 'Active', 'school' => 'Greenwood'],
                ['last_name' => 'Khan', 'first_name' => 'Sara', 'status' => 'Inactive', 'school' => 'Riverside'],
            ]
        ],
        [
            'name' => 'Category D',
            'students' => [
                ['last_name' => 'Garcia', 'first_name' => 'Carlos', 'status' => 'Active', 'school' => 'Hilltop'],
                ['last_name' => 'Nguyen', 'first_name' => 'Linh', 'status' => 'Active', 'school' => 'Sunset High'],
            ]
        ],
        [
            'name' => 'Category E',
            'students' => [
                ['last_name' => 'Singh', 'first_name' => 'Raj', 'status' => 'Inactive', 'school' => 'Maple Grove'],
                ['last_name' => 'Kumar', 'first_name' => 'Ravi', 'status' => 'Active', 'school' => 'Cedar Park'],
            ]
        ],
    ];
    ?>

    <?php foreach ($categories as $index => $category): ?>
        <div class="table-block">
            <table>
                <thead>
                    <tr>
                        <th colspan="4"><?php echo $category['name']; ?></th>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Status</th>
                        <th>High School</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category['students'] as $student): ?>
                        <tr>
                            <td><?php echo $student['last_name']; ?></td>
                            <td><?php echo $student['first_name']; ?></td>
                            <td><?php echo $student['status']; ?></td>
                            <td><?php echo $student['school']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (($index + 1) % 2 == 0): ?>
            <div class="clearfix"></div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="footer">
        <span>Date: <?php echo date('d-m-Y'); ?></span>
        <span>Page {PAGE_NUM} of {PAGE_COUNT}</span>
    </div>
</body>
</html>
