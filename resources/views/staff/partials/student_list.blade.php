<table class="student-table">
    <thead>
        <tr>
            <th>S. No</th>
            <th>Year Status</th>
            <th>Name</th>
            <th>High School</th>
            <th>Attendance</th>
            <th>Grades</th>
            <th>Mobile Number</th>
            <th>Email ID</th>
            <th>Parent Name</th>
            <th>Parent Mobile Number</th>
            <th>Current Address</th>
            <th>Hebrew Name</th>
            <th>Birth Country</th>
            <th>D.O.B</th>
            <th>Hebrew Birth</th>
        </tr>
    </thead>

    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    @foreach($student->classes as $class)
                        {{ $class->yearStatus->name ?? '-' }}
                    @endforeach
                </td>

                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->high_school }}</td>
                <td>{{ $student->attendance_percentage }}</td>
                <td>—</td>
                <td>{{ $student->mobile }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->parent_full_name }}</td>
                <td>{{ $student->parent_mobile_number }}</td>
                <td>{{ $student->residance_address }}</td>
                <td>{{ $student->hebrew_first_name }} {{ $student->hebrew_last_name }}</td>
                <td>{{ $student->place_of_birth }}</td>
                <td>{{ $student->dob }}</td>
                <td>{{ $student->hebrew_dob }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

