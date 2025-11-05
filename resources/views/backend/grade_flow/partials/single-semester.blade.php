<table>

    <thead>

        <tr>

            <th>S. No</th>

            <th>Student Name</th>
            <th>Average</th>
            <th>Class</th>
            <th>Reduction</th>
            <th>Override</th>

            <th>Omit</th>
            
            <th>Value</th>
            <th>Personal Absences</th>
            
            <th>Excused Absences</th>
            
            <!-- <th>P* Absences</th> -->
            
            <th>Reduced</th>
            
            <th>Percentage</th>
            
            <th>Report Card</th>
            
            <th>Transcript</th>
            <th>Notes</th>

        </tr>

    </thead>

    <tbody>
        @foreach ($allGradeRecords as $record )
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $record->student_first_name }} {{ $record->student_last_name }}</td>

                <td>{{ $record->average }}</td>
                <td>{{ $record->class_name }}</td>
                <td>{{ $record->reduction }}</td>
                <td>{{ $record->override }}</td>
                <td>{{ $record->omit }}</td>
                <td>{{ $record->value }}</td>
                
                <td>{{ $record->personal_absence_count }}</td>
                
                <td>{{ $record->excused_count }}</td>
                
                <!-- <td>{{ $record->consecutive_absence_count }}</td> -->
                
                <td>{{ $record->reduced }}</td>
                
                <td>{{ $record->percentage }}</td>
                
                <td>{{ $record->report_card }}</td>
                
                <td>{{ $record->transcript }}</td>
                
                <td>{{ $record->notes }}</td>
                

            </tr> 
        @endforeach
        

        

    </tbody>

</table>