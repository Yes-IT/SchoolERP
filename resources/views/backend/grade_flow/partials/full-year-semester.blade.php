<table>

    <thead>

        <tr>

            <th>S. No</th>

            <th>Student Name</th>
            <th>Year Average</th>
            <th>Year Transcript</th>
            

        </tr>

    </thead>

    <tbody>
        
        @foreach ($studentAverageGrades as $record )
        
            <tr class="table-rows">

                <td>{{ $loop->iteration }}</td>

                <td>{{ $record->student_full_name }}</td>

                <td>{{ $record->year_average }}</td>
                <td>{{ $record->year_transcript }}</td>
                

            </tr> 
        @endforeach
        

        

    </tbody>

</table>