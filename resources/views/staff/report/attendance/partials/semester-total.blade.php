{{-- resources/views/staff/report/attendance/partials/semester-total.blade.php --}}
<div class="ds-cmn-tble completed count-table semester-total active">
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Excused</th>
                <th>Late</th>
                <th>Not Counted</th>
                <th>%</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summary as $item)
                @php
                    // Total possible attendance days in the selected month
                    $totalDays   = $maxDay;

                    // Present = total days - absences - excused - not counted
                    $totalAbsences = $item['total_absences']; // direct (3) + converted from lates
                    $presentDays   = $totalDays - $totalAbsences - $item['excused'] - $item['not_counted'];

                    // Attendance percentage
                    $percentage = $totalDays > 0 
                        ? round(($presentDays / $totalDays) * 100, 1) 
                        : 0;

                    // Points = total absences (direct + converted from lates) → you said "points is black for now"
                    $points = $totalAbsences;

                    // Color for percentage
                    $percentClass = $percentage >= 90 ? 'text-success' :
                                   ($percentage >= 75 ? 'text-warning' : 'text-danger');
                @endphp

                <tr>
                    <td>
                        <strong>{{ $item['student']->full_name }}</strong>

                        {{-- Optional: show breakdown on hover (nice touch) --}}
                        @if($item['absences_direct'] > 0 || $item['absences_from_late'] > 0)
                            <small class="d-block text-muted">
                                @if($item['absences_direct'] > 0)
                                    Absent: {{ $item['absences_direct'] }}
                                @endif
                                @if($item['absences_from_late'] > 0)
                                    @if($item['absences_direct'] > 0) • @endif
                                    Late → Absent: {{ $item['absences_from_late'] }}
                                @endif
                            </small>
                        @endif
                    </td>

                    <td><span class="text-success">{{ $item['excused'] }}</span></td>

                    <td>
                        {{ $item['late'] }}
                        @if($item['absences_from_late'] > 0)
                            <small class="text-danger d-block">
                                ({{ $item['absences_from_late'] }} converted to absence)
                            </small>
                        @endif
                    </td>

                    <td><span class="text-danger">{{ $item['not_counted'] }}</span></td>

                    <td>
                        <strong class="{{ $percentClass }}">
                            {{ $percentage }}%
                        </strong>
                    </td>

                    <td>
                        <span class="badge bg-dark">
                            {{ $points }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No data available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>