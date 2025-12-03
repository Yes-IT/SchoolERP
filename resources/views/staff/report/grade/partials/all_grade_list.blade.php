<div class="ds-content-head">
    <div class="cmn-tab-head">
        <p class="record-heading">All Grade Records</p>
    </div>
</div>

<div class="tab-content current-tab active">
    <div class="ds-cmn-tble pending count-table">
        <table>
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Student Name</th>
                    <th>Average</th>
                    <th>Personal Absences</th>
                    <th>Excused Absences</th>
                    <th>Reduced</th>
                    <th>Percentage</th>
                    <th>Report Card</th>
                    <th>Transcript</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $stats      = $attendanceStats[$student->id] ?? null;
                        $totalDays  = $stats['total_days'] ?? 0;
                        $personal   = $stats['personal'] ?? 0;
                        $excused    = $stats['excused'] ?? 0;
                        $reduced    = $stats['not_counted'] ?? 0;

                        $percentage = $totalDays > 0 ? round(($personal / $totalDays) * 100, 2) : 0;
                        $fails      = $percentage > 20;
                    @endphp

                    <tr class="{{ $fails ? 'table-danger' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->user->name ?? 'Unknown Student' }}</td>
                        <td>-</td>
                        <td>{{ $personal }}</td>
                        <td>{{ $excused }}</td>
                        <td>{{ $reduced }}</td>
                        <td>
                            <strong style="color: {{ $fails ? 'red' : 'inherit' }}">
                                {{ $percentage }}% @if($fails)*@endif
                            </strong>
                        </td>
                        <td>
                           |
                        </td>
                        <td>
                            |
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            No students found for the selected criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="grade-bottom">
    <p><span>KEY: E</span>=Excused; <span>P</span>=Personal; <span>NC</span>=Not Counted;</p>
    <p><span>*</span> = Exceeds 20% absence → Fails subject automatically</p>
</div>