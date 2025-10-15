@forelse($classes as $index => $class)
    <tr>
        <td>{{ $loop->iteration }}</td>

        <td>
            <a href="{{ route('classes.class_info', ['id' => $class->id]) }}" class="view-attachment-btn">
                <img src="{{ global_asset('backend/assets/images/eye-white.svg') }}" alt="Eye Icon">
            </a>
        </td>

        <td>{{ $class->name }}</td>
        <td>{{ $class->abbreviation ?? '--' }}</td>
        <td>{{ $class->subject?->name ?? 'N/A' }}</td>
        <td>{{ $class->teacher?->first_name . ' ' . $class->teacher?->last_name }}</td>
        <td>{{ $class->schoolYear?->name ?? 'N/A' }}</td>
        <td>{{ $class->yearStatus?->name ?? 'N/A' }}</td>
        <td>{{ $class->semester?->name ?? 'N/A' }}</td>

        <td><input type="checkbox" {{ $class->status ? 'checked' : '' }}></td>
        <td>{{ $class->credits ?? '--' }}</td>
        <td>{{ $class->allow_absence ?? '--' }}</td>
        <td>{{ $class->allow_penalty_amount ?? '--' }}</td>
        <td>{{ $class->number_of_latenesses_equal_to_one_absence ?? '--' }}</td>
        <td><input type="checkbox" {{ $class->hebrew_attendance ? 'checked' : '' }}></td>
        <td>{{ $class->gpa_weight ?? '--' }}</td>
        <td><input type="checkbox" {{ $class->report_card ? 'checked' : '' }}></td>
        <td>{{ $class->precedence_on_rc ?? '--' }}</td>
        <td><input type="checkbox" {{ $class->college_transcript ? 'checked' : '' }}></td>
        <td>{{ $class->transcript_name ?? '--' }}</td>
        <td>{{ $class->transcript_course ?? '--' }}</td>
        <td>{{ $class->precedence_on_transcript ?? '--' }}</td>
        <td><input type="checkbox" {{ $class->charter_oak_transcript ? 'checked' : '' }}></td>
        <td><input type="checkbox" {{ $class->charter_oak_year_long ? 'checked' : '' }}></td>
        <td>{{ $class->charter_oak_department ?? '--' }}</td>
        <td><input type="checkbox" {{ $class->elective ? 'checked' : '' }}></td>
        <td><input type="checkbox" {{ $class->composite_average ? 'checked' : '' }}></td>
        <td>{{ $class->composite_class_1 ?? '--' }}</td>
        <td>{{ $class->composite_class_2 ?? '--' }}</td>
        <td>{{ $class->composite_class_1_weight ?? '--' }}</td>
        <td>{{ $class->composite_class_2_weight ?? '--' }}</td>
        <td>{{ $class->comment ?? '--' }}</td>
        <td><input type="checkbox" {{ $class->attendance_percent_auto_fail ? 'checked' : '' }}></td>
        <td>{{ $class->attendance_percent_amount ?? '--' }}</td>
        <td>{{ $class->attendance_percent_fail_grade ?? '--' }}</td>

        <td>
            <div class="actions-wrp">
                <a href="{{ route('classes.edit', $class->id) }}">
                    <img src="{{ global_asset('backend/assets/images/edit-icon-primary.svg') }}" alt="Edit">
                </a>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="10" class="text-center">No classes found</td>
    </tr>
 @endforelse