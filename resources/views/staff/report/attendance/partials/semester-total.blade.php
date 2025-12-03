<div class="ds-cmn-tble completed count-table semester-total active">
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Excused</th>
                <th>Late</th>
                <th>Not Counted</th>
                <th>%</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summary as $item)
                <tr>
                    <td><strong>{{ $item['student']->full_name }}</strong></td>
                    <td><span class="text-success">{{ $item['excused'] }}</span></td>
                    <td>{{ $item['late'] }}</td>
                    <td><span class="text-danger">{{ $item['not_counted'] }}</span></td>
                    <td>
                        --
                    </td>
                    <td>
                        --
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
                   