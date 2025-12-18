<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Class Routine - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #666; }
        .no-class { background: #f0f0f0; text-align: center; font-style: italic; }
        .subject { font-weight: bold; }
        .teacher { font-size: 10px; color: #666; }
        .room { font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Class Routine - {{ $student->first_name }} {{ $student->last_name }}</h2>
        <p>Period: {{ $startDate }} to {{ $endDate }}</p>
        <p>Generated on: {{ $generatedAt }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Day / Time</th>
                @foreach($timeSlots as $slot)
                    <th>{{ $slot['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($days as $day)
                <tr>
                    <th>{{ $day }}</th>
                    
                    @if($day === 'Shabbos')
                        <td colspan="{{ count($timeSlots) }}" class="no-class">
                            <strong>No Classes - Shabbos</strong>
                        </td>
                    @else
                        @foreach($timeSlots as $startTime => $slot)
                            @php $data = $formatted[$day][$startTime] ?? null; @endphp
                            
                            <td>
                                @if($data && (!isset($data['is_empty']) || !$data['is_empty']))
                                    <div class="subject">{{ $data['subject'] }}</div>
                                    <div class="teacher">{{ $data['teacher'] }}</div>
                                    <div class="room">{{ $data['room'] }}</div>
                                @else
                                    <div style="color: #ccc; text-align: center;">—</div>
                                @endif
                            </td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>© {{ date('Y') }} School Management System</p>
    </div>
</body>
</html>