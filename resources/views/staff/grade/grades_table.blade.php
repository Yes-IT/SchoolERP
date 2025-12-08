<div class="ds-cmn-tble pending count-table">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Student Name</th>
                <th>Total Marks</th>
                <th>Marks Achieved 
                    <span class="pencil-header">
                        <img src="{{ asset('staff/assets/images/newpencil.svg') }}" class="pencil-header-img" />
                    </span>
                </th>
                <th>Grades</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paginator as $item)
                <tr>
                    <td>{{ $loop->iteration + ($paginator->currentPage() - 1) * $paginator->perPage() }}</td>
                    <td>{{ $item->student_name }}</td>
                    <td>100</td>
                    <td class="marks-cell">
                        <!-- Display mode (default) -->
                        <span class="marks-display">
                            {{ $item->marks_achieved ?? '--' }}
                        </span>

                        <!-- Edit mode input (hidden initially) -->
                        <input type="number" min="0" max="100" class="form-control-sm marks-input d-none"
                            style="width:70px;"
                            data-student-id="{{ $item->student_id }}"
                            value="{{ $item->marks_achieved ?? '' }}"
                            placeholder="--">
                    </td>
                    <td><span class="grade-display">{{ $item->grade }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">No students found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>