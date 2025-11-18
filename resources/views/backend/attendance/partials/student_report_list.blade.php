{{-- resources/views/backend/attendance/partials/student_report_list.blade.php --}}
@forelse($attendance as $i => $row)
    <tr>
        {{-- Serial No (1-based) --}}
        <td>{{ $attendance->firstItem() + $i }}</td>

        {{-- Class name (already joined in controller) --}}
        <td>{{ $row->class_name ?? 'N/A' }}</td>

        {{-- Date --}}
        <td>{{ $row->date ? \Carbon\Carbon::parse($row->date)->format('d M Y') : 'N/A' }}</td>

        {{-- Comment (your column is called `attendance` in the DB) --}}
        <td>{{ $row->attendance ?? 'N/A' }}</td>

        {{-- Category – you said 1=P, 2=L, 3=A --}}
        <td>
            @php
                $status = [
                    1 => 'P',
                    2 => 'L',
                    3 => 'A',
                ];
            @endphp
            {{ $status[$row->attendance] ?? 'N/A' }}
        </td>

        {{-- Type – human readable (Excused / Personal / …) --}}
        <td>{{ $row->attendance_type_name ?? 'N/A' }}</td>

        {{-- Late time --}}
        <td>
            {{ $row->late_time
                ? \Carbon\Carbon::parse($row->late_time)->format('h:i A')
                : 'N/A' }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7">No attendance records found.</td>
    </tr>
@endforelse