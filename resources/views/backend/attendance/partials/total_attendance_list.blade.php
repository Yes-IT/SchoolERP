<div class="ds-content-head has-drpdn">

    <div class="sec-head">
        <h2>Daily Attendance</h2>
    </div>

    <div class="dropdown year-dropdown" style="width: 160px;">
        <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="toggle-year">
            <span class="label">Select Student</span>
            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" role="menu" aria-labelledby="toggle-year">
            <label><input type="radio" name="students" value=""> All Students</label>
            @foreach($students as $student)
                <label><input type="radio" name="school_year" value="{{ $student->id }}">&nbsp;{{ $student->first_name }}</label>
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
                <th>points</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

