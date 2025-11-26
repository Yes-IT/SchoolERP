<div class="ds-cmn-tble pending count-table">
    <table>
        <thead>
            <tr>
                <th>Student Name / Date</th>
                @for($day = 1; $day <= $maxDay; $day++)
                    <th>{{ sprintf('%02d', $day) }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ htmlspecialchars($student->first_name ?? 'Unknown Student') }}</td>
                    @for($day = 1; $day <= $maxDay; $day++)
                        @php
                            $key = $student->id . '-' . $day;
                            $cell = '<p class="tr-item-A">A</p>'; // Default: Absent

                            // Approved Leave overrides everything
                            if (isset($leaveDays[$student->id][$day])) {
                                $cell = '<p class="tr-item-AL">AL</p>';
                            }
                            // Attendance record
                            elseif ($attendanceRecords->has($key)) {
                                $status = $attendanceRecords[$key];
                                if ($status == 1) {
                                    $cell = '<p class="tr-item-P">P</p>';
                                } elseif ($status == 2) {
                                    $cell = '<p class="tr-item-L">L</p>';
                                } elseif ($status == 3) {
                                    $cell = '<p class="tr-item-A">A</p>';
                                }
                            }
                        @endphp
                        <td>{!! $cell !!}</td>
                    @endfor
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $maxDay + 1 }}" class="text-center text-muted py-4">
                        No students found for the selected criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Legend -->
<p class="bottom-txt mt-3">
    <span>KEY: P(Green)</span>=Present; 
    <span>A(Red)</span>=Absent; 
    <span>L(Yellow)</span>=Late; 
    <span>AL(Maroon)</span>=Approved Leave
</p>