<div class="ds-content-head">
    <div class="cmn-tab-head">
        <p class="record-heading">Students with Failing Grades</p>
    </div>
</div>

<div class="tab-content current-tab active">
    <div class="ds-cmn-tble pending count-table active">
        <table>
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Student Name</th>
                    <th>Average</th>
                    <th>Reduced</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grouped as $item)
                    @foreach($item['students'] as $index => $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['subject_name'] }}</td>
                            <td>{{ $item['class_name'] }}</td>
                            <td>{{ $student['student_name'] }}</td>
                            <td>{{ $student['average'] ?? '-' }}</td>
                            <td>{{ $student['reduced'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <strong>No students with failing grades found.</strong>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>