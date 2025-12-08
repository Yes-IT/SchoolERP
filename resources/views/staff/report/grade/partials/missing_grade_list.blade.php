<div class="ds-content-head">
    <div class="cmn-tab-head">
        <p class="record-heading">Students with Missing Grades</p>
    </div>
</div>

<div class="tab-content current-tab active">
    <div class="ds-cmn-tble pending count-table">
        <table>
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Student Name</th>
                    <th>Grades</th>
                </tr>
            </thead>
            <tbody>
               @forelse($missing as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['subject_name'] }}</td>
                        <td>{{ $item['class_name'] }}</td>
                        <td>{{ $item['student_name'] }}</td>
                        <td>
                            --
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-success fw-bold">
                            <i class="fas fa-check-circle"></i> No missing grades found. All grades are entered!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


 <div class="tablepagination" id="paginationContainer">
    @include('backend.partials.pagination', [
                'paginator' => $paginator,
                'routeName' => $routeName
            ])
</div>
