<div class="ds-cmn-tble pending count-table">
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Student Name</th>
                <th>Total Marks</th>
                <th>Marks Achieved <span><img src="{{ asset('staff/assets/images/newpencil.svg') }}"
                            class="pencil" /></span></th>
                <th>Grades</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paginator as $item)
                <tr>
                    <td>{{ $loop->iteration + ($paginator->currentPage() - 1) * $paginator->perPage() }}</td>
                    <td>{{ $item->student_name }}</td>
                    <td>100</td>
                    <td>
                        <input type="number" min="0" max="100"
                                class="form-control form-control-sm marks-input text-center"
                                style="width:80px;"
                                data-student-id="{{ $item->student_id }}"
                                value="{{ $item->marks_achieved ?? '' }}"
                                placeholder="--">
                                
                            <button type="button" class="btn btn-link p-0 ms-2 save-marks-btn" 
                                    style="border:none; background:none;"
                                    data-student-id="{{ $item->student_id }}">
                                <img src="{{ asset('staff/assets/images/true.svg') }}" 
                                    alt="Save" width="20">
                            </button>
                    </td>
                    <td><span class="grade-display">{{ $item->grade }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">No students found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>