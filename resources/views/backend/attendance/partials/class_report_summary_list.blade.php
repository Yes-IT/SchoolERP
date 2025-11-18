@forelse($summary as $row)
<tr>
    <td>{{ $row->student_name }}</td>
    <td>{{ $row->excused }}</td>
    <td>{{ $row->late }}</td>
    <td>{{ $row->personal }}</td>
    <td>{{ $row->not_counted }}</td>
</tr>
@empty
<tr><td colspan="5">No summary data available.</td></tr>
@endforelse