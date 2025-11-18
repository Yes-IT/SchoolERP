<!-- Dynamic Title -->
<h3 style="margin: 0 0 15px 0; font-weight: 600;">
    Student Name {{ $semesterName }} Attendance Summary
</h3>

<div class="ds-cmn-tble">
    <table>
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Excused</th>
                <th>Late</th>
                <th>Personal</th>
                <th>%</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summary as $row)
                <tr>
                    <td>{{ $row->class_name }}</td>
                    <td>{{ $row->excused }}</td>
                    <td>{{ $row->late }}</td>
                    <td>{{ $row->personal }}</td>
                    <td><strong>{{ $row->percentage }}%</strong></td>
                    <td>{{ $row->points }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No attendance data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>