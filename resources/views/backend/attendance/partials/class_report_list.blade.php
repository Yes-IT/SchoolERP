@forelse($attendance as $i => $row)
<tr>
    <td>{{ $attendance->firstItem() + $i }}</td>
    <td>{{ $row->student_name }}</td>
    <td>{{ $row->date ? \Carbon\Carbon::parse($row->date)->format('d M Y') : 'N/A' }}</td>
    <td>{{ $row->comment ?? 'N/A' }}</td>
    <td>
        @php
            $status = [1 => 'P', 2 => 'L', 3 => 'A'];
        @endphp
        {{ $status[$row->attendance] ?? 'N/A' }}
    </td>
    <td>{{ $row->attendance_type_name ?? 'N/A' }}</td>
    <td>{{ $row->late_time ? \Carbon\Carbon::parse($row->late_time)->format('h:i A') : 'N/A' }}</td>
</tr>
@empty
<tr><td colspan="7">No attendance records found.</td></tr>
@endforelse