<div class="ds-content-head has-drpdn">
    <div class="sec-head">
        <h2>Semester Total Attendance</h2>
    </div>

    <div class="dropdown student-dropdown" style="width: 230px;">
        <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-student">
            <span class="label">Select Student</span>
            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" role="menu" aria-labelledby="toggle-student">
            <label><input type="radio" name="student_id" value=""> All Students</label>
            @foreach($students as $student)
                <label><input type="radio" name="student_id" value="{{ $student->id }}">&nbsp;{{ $student->first_name }} {{ $student->last_name }}</label>
            @endforeach
        </div>
    </div>
</div>

<div class="ds-cmn-tble">
    <table style="min-width:auto !important;">
        <thead class="thead">
            <tr>
                <th>Student Name</th>
                <th>Excused</th>
                <th>Late</th>
                <th>Personal</th>
                <th>Not Counted</th>
                <th>%</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody class="tbody">
            @foreach($data['students'] as $student)
                <tr>
                    <td>{{ $student->first_name }} {{ $student->last_name }} </td>
                    <td>{{ $student->excused_count ?? 0 }}</td>
                    <td>{{ $student->late_count ?? 0 }}</td>
                    <td>{{ $student->personal_count ?? 0 }}</td>
                    <td>{{ $student->not_counted ?? 0 }}</td>
                    <td>{{ $student->attendance_percentage ?? 0 }}%</td>
                    <td>{{ $student->points ?? 0 }}</td>
                </tr>
            @endforeach
            @if($data['students']->isEmpty())
                <tr>
                    <td colspan="7">No records found.</td>
                </tr>
            @endif
        </tbody>
    </table>

 
</div>