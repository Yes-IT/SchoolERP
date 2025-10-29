<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Class Attendance Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, Arial, sans-serif; 
            font-size: 11px; 
            margin: 25px; 
        }
        .header { 
            text-align: center; 
            border-bottom: 2px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .header h1 { 
            margin: 0; 
            font-size: 16px; 
            text-transform: uppercase; 
        }
        .class-info {
            margin-bottom: 15px;
            font-size: 12px;
        }
        .student-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .student-header {
            background: #f0f0f0;
            font-weight: bold;
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #000;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 10px; 
            margin-bottom: 10px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 4px 3px; 
            text-align: center; 
        }
        th { 
            background: #e9e9e9; 
            font-weight: bold; 
            font-size: 9.5px;
        }
        .type-present { color: #28a745; }
        .type-absent  { color: #dc3545; }
        .type-late    { color: #ffc107; }
        .type-excused { color: #17a2b8; }
        .footer { 
            margin-top: 40px; 
            text-align: center; 
            font-size: 9px; 
            color: #666; 
        }
        .period { 
            font-size: 10px; 
            margin-top: 5px; 
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Class Attendance Details: {{ $semesterName }}</h1>
    <div class="class-info">
        <strong>Class:</strong> {{ $class->name ?? 'N/A' }}<br>
        <span class="period">Period: {{ $startDate->format('d M Y') }} to {{ $endDate->format('d M Y') }}</span>
    </div>
</div>

@foreach($attendances as $studentId => $records)
    @php
        $student = $records->first()->student ?? null;
        if (!$student) continue;
    @endphp
    
    <div class="student-section">
        <div class="student-header">
            Student: {{ $student->first_name }} {{ $student->last_name }}
            @if($records->count() > 0)
                ({{ $records->count() }} records)
            @endif
        </div>
        
        <table>
            <thead>
                <tr>
                    <th width="12%">Day</th>
                    <th width="18%">Date</th>
                    <th width="20%">Subject</th>
                    <th width="15%">Type</th>
                    <th width="35%">Comment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records->sortBy('date') as $record)
                    @php
                        $typeLabel = match($record->attendance) {
                            1 => 'Present',
                            2 => 'Excused', 
                            3 => 'Late',
                            4 => 'Absent',
                            default => 'Unknown'
                        };
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('D') }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d.m.y') }}</td>
                        <td>{{ $record->subject->name ?? 'N/A' }}</td>
                        <td>
                            <span class="type-{{ strtolower(str_replace(' ', '-', $typeLabel)) }}">
                                {{ $typeLabel }}
                            </span>
                        </td>
                        <td style="text-align: left;">{{ $record->comment ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="font-style: italic; color: #888; text-align: center;">
                            No attendance records
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach

@if($attendances->isEmpty())
<div style="text-align: center; margin-top: 30px; font-style: italic; color: #888;">
    No attendance records found for this class and period.
</div>
@endif

<div class="footer">
    Generated on {{ now()->format('d M Y \a\t H:i') }} | School ERP System
</div>

</body>
</html>