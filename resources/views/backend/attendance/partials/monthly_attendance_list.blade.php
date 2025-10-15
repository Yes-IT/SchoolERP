<div class="ds-content-head has-drpdn">
    <div class="sec-head">
        <h2>Monthly Attendance</h2>
    </div>
</div>

<div class="ds-cmn-tble">
    <table style="min-width:auto !important;">
        <thead class="thead">
            <tr>
                <th>Student Name</th>
                @for($i = 1; $i <= $daysInMonth; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($data['students'] as $student)
                <?php
                    $studentAttendance = App\Models\Attendance\Attendance::where('student_id', $student->id)
                        ->whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->get()
                        ->keyBy(function($item) {
                            return \Carbon\Carbon::parse($item->date)->day;
                        });
                    
                    $counts = [
                        'present' => 0,
                        'late' => 0,
                        'absent' => 0,
                        'half_day' => 0
                    ];
                ?>
                <tr>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    @for($i = 1; $i <= $daysInMonth; $i++)
                        <td>
                            @if(isset($studentAttendance[$i]))
                                @switch($studentAttendance[$i]->attendance)
                                    @case(1)
                                        <p class="green-bg cmn-tbl-btn">P</p>
                                        <?php $counts['present']++; ?>
                                        @break
                                    @case(2)
                                        <p class="yellow-bg cmn-tbl-btn">L</p>
                                        <?php $counts['late']++; ?>
                                        @break
                                    @case(3)
                                        <p class="red-bg cmn-tbl-btn">A</p>
                                        <?php $counts['absent']++; ?>
                                        @break
                                    @case(4)
                                        <p class="cyan-bg cmn-tbl-btn">H</p>
                                        <?php $counts['half_day']++; ?>
                                        @break
                                @endswitch
                            @else
                                -
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="tablepagination">
    {{ $data['students']->links('backend.partials.pagination', ['routeName' => 'monthly.index']) }}
</div>